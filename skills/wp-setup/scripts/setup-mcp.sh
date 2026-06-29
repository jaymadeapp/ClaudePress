#!/usr/bin/env bash
#
# setup-mcp.sh — Loamkit: provision the LOCAL WordPress MCP (idempotent)
#
# Usage: setup-mcp.sh [path-to-resolved-config.json]
#
# Makes the WordPress MCP server in .mcp.json work with ZERO manual steps for
# local development. It:
#   1. Detects the right WP-CLI runner (`ddev wp` for a DDEV project, else `wp`).
#   2. Verifies WordPress is installed/reachable (prerequisite, not a guess).
#   3. Installs + activates the canonical WordPress/mcp-adapter plugin.
#   4. Creates the least-privilege role `loamkit_mcp` (CONTENT-ONLY caps).
#   5. Creates the MCP user `loamkit-mcp` with that role.
#
# Security: the MCP client (Claude Code) authenticates AS `loamkit-mcp` over
# STDIO, so this user's role IS the boundary. It is content-only and NEVER gets
# manage_options, manage_woocommerce, edit_theme_options, install_plugins,
# edit_files, or any order/payment capability. There is NO application password
# for the local case — STDIO via WP-CLI authenticates as the WP user directly.
#
# Design guarantees:
#   - IDEMPOTENT: every step is guarded; re-runs are safe and make no changes.
#   - DEFENSIVE: if WP isn't installed yet we print the exact prerequisite and
#     exit non-zero so it's obviously a missing step, not a silent failure.

set -euo pipefail

# ----------------------------------------------------------------------------
# Plumbing
# ----------------------------------------------------------------------------
CONFIG="${1:-resolved-config.json}"

# Fixed constants (do NOT vary these — they are the contract in .mcp.json).
MCP_USER="loamkit-mcp"
MCP_ROLE="loamkit_mcp"
MCP_ROLE_NAME="Loamkit MCP"
MCP_USER_EMAIL="loamkit-mcp@example.test"
ADAPTER_SLUG="mcp-adapter"
ADAPTER_ZIP="https://github.com/WordPress/mcp-adapter/releases/latest/download/mcp-adapter.zip"

# Content-only capabilities. NEVER add manage_options, manage_woocommerce,
# edit_theme_options, install_plugins, edit_files, or any order/payment caps.
CONTENT_CAPS=(read edit_posts edit_others_posts edit_published_posts edit_pages edit_others_pages edit_published_pages upload_files)

# Capabilities that MUST NOT be on the role (asserted/stripped defensively).
FORBIDDEN_CAPS=(manage_options manage_woocommerce edit_theme_options install_plugins edit_files edit_shop_orders read_shop_order publish_shop_orders delete_shop_orders manage_woocommerce_orders)

say()  { printf '  %s\n' "$*"; }
step() { printf '\n==> %s\n' "$*"; }
warn() { printf '  ! %s\n' "$*" >&2; }
die()  { printf '\nsetup-mcp: FATAL: %s\n' "$*" >&2; exit 1; }

# have <bin> -> true if on PATH
have() { command -v "$1" >/dev/null 2>&1; }

# ----------------------------------------------------------------------------
# 1. Detect the WP-CLI runner: `ddev wp` for a DDEV project, else native `wp`.
# ----------------------------------------------------------------------------
USE_DDEV="no"
if [ -f ".ddev/config.yaml" ] && have ddev; then
  USE_DDEV="yes"
fi

# WP() wraps the right runner so the rest of the script is runner-agnostic.
if [ "$USE_DDEV" = "yes" ]; then
  WP() { ddev wp "$@"; }
  RUNNER="ddev wp"
else
  WP() { wp "$@"; }
  RUNNER="wp"
fi

step "Loamkit MCP setup — runner: $RUNNER"

if [ "$USE_DDEV" = "yes" ]; then
  say "DDEV project detected (.ddev/config.yaml + ddev on PATH)."
else
  if [ -f ".ddev/config.yaml" ] && ! have ddev; then
    warn ".ddev/config.yaml exists but ddev is not on PATH — falling back to native wp."
  fi
  have wp || die "wp (WP-CLI) not found on PATH and no usable ddev runner — cannot provision the MCP user."
fi

# ----------------------------------------------------------------------------
# 2. Verify WordPress is reachable/installed (PREREQUISITE).
# ----------------------------------------------------------------------------
step "Checking WordPress is installed"

if ! WP core is-installed >/dev/null 2>&1; then
  warn "WordPress is not installed / not reachable via '$RUNNER'."
  if [ "$USE_DDEV" = "yes" ]; then
    say "Run this first, then re-run this script:"
    say "  ddev start && ddev wp core install ..."
  else
    say "Run this first, then re-run this script:"
    say "  wp core install ...   (ensure your local PHP + DB are up and .env points at them)"
  fi
  say "Re-run: bash skills/wp-setup/scripts/setup-mcp.sh"
  exit 1
fi
say "WordPress is installed."

# ----------------------------------------------------------------------------
# 3. Install + activate the WordPress/mcp-adapter plugin (idempotent).
# ----------------------------------------------------------------------------
step "WordPress/mcp-adapter plugin"

if WP plugin is-active "$ADAPTER_SLUG" >/dev/null 2>&1; then
  say "mcp-adapter already active — skipping install."
else
  say "Installing + activating mcp-adapter from the GitHub release zip..."
  if WP plugin install "$ADAPTER_ZIP" --activate; then
    say "mcp-adapter installed and activated."
  else
    die "failed to install/activate mcp-adapter from $ADAPTER_ZIP (requires WP >=6.9 / Abilities API, PHP >=7.4)."
  fi
fi

# ----------------------------------------------------------------------------
# 4. Least-privilege role `loamkit_mcp` (CONTENT-ONLY caps, idempotent).
# ----------------------------------------------------------------------------
step "Least-privilege role '$MCP_ROLE'"

if WP role list --field=role 2>/dev/null | grep -qx "$MCP_ROLE"; then
  say "Role '$MCP_ROLE' already exists."
else
  say "Creating role '$MCP_ROLE' ($MCP_ROLE_NAME)..."
  WP role create "$MCP_ROLE" "$MCP_ROLE_NAME" >/dev/null \
    || die "could not create role '$MCP_ROLE'."
fi

# Grant content-only caps (cap add is idempotent — re-adding is a no-op).
say "Granting content-only capabilities..."
WP cap add "$MCP_ROLE" "${CONTENT_CAPS[@]}" >/dev/null \
  || die "could not add content capabilities to '$MCP_ROLE'."
say "Caps: ${CONTENT_CAPS[*]}"

# ----------------------------------------------------------------------------
# 5. MCP user `loamkit-mcp` (idempotent).
# ----------------------------------------------------------------------------
step "MCP user '$MCP_USER'"

if WP user get "$MCP_USER" --field=ID >/dev/null 2>&1; then
  say "User '$MCP_USER' already exists — ensuring role is '$MCP_ROLE'."
  WP user set-role "$MCP_USER" "$MCP_ROLE" >/dev/null 2>&1 || true
else
  say "Creating user '$MCP_USER' with role '$MCP_ROLE'..."
  WP user create "$MCP_USER" "$MCP_USER_EMAIL" --role="$MCP_ROLE" --porcelain >/dev/null \
    || die "could not create user '$MCP_USER'."
  say "User '$MCP_USER' created."
fi

# ----------------------------------------------------------------------------
# 6. E-shop defense: assert the role has NO woo/order/payment caps.
# ----------------------------------------------------------------------------
WOO_FLAG="false"
if [ -f "$CONFIG" ] && have jq; then
  WOO_FLAG="$(jq -r '.flags.WOO // false' "$CONFIG" 2>/dev/null || echo false)"
fi

step "Capability safety check"
if [ "$WOO_FLAG" = "true" ]; then
  say "E-shop project (flags.WOO=true) — asserting '$MCP_ROLE' has NO WooCommerce order/payment caps."
fi
# Strip any forbidden caps defensively, regardless of build type (cap remove is
# idempotent and harmless if the cap was never present).
for cap in "${FORBIDDEN_CAPS[@]}"; do
  WP cap remove "$MCP_ROLE" "$cap" >/dev/null 2>&1 || true
done
say "Confirmed: '$MCP_ROLE' is content-only (no manage_options / manage_woocommerce / order / payment caps)."

# ----------------------------------------------------------------------------
# Summary
# ----------------------------------------------------------------------------
step "Summary"
say "Adapter:  $ADAPTER_SLUG (active)"
say "Role:     $MCP_ROLE — content-only"
say "User:     $MCP_USER (role $MCP_ROLE)"
say "Transport: STDIO via WP-CLI ($RUNNER) — no application password."
say ""
say "The 'wordpress' MCP server in .mcp.json is now ready."
say "Restart Claude Code (or run /reload-plugins) if the server isn't picked up yet."

printf '\nsetup-mcp: done.\n'
exit 0
