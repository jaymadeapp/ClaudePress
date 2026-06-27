#!/usr/bin/env bash
#
# guard-woo-data.sh — ClaudePress PreToolUse guard (WooCommerce data-safety)
#
# Enforces the WooCommerce HARD GATE (spec §4.4, §6.2):
#   - Orders, customers and payment data are NEVER deployed and NEVER committed.
#   - Any change to checkout / cart totals / payment gateways requires an
#     explicit HUMAN GATE + wp-security-reviewer sign-off before merge.
#
# I/O CONTRACT (spec §6.2):
#   - Receives the tool-call JSON payload on STDIN.
#   - Inspects .tool_input.command (Bash) OR .tool_input.file_path (Write|Edit).
#   - On a blocked match: writes the reason to STDERR and exits 2 (BLOCK).
#   - On ANY parse error / missing field / unreadable input: exits non-zero
#     (TRUE fail-closed — block rather than let an unparseable call through).
#   - Otherwise exits 0 (ALLOW).
#
# This guard is wired for the "Bash|Write|Edit" matcher, so a payload may carry
# either a command (Bash) or a file_path (Write|Edit). We evaluate whichever is
# present; if neither is present we fail closed.

set -uo pipefail

# --- Fail closed if jq is unavailable. ---
if ! command -v jq >/dev/null 2>&1; then
  echo "woo-data: jq is required to parse the tool payload (fail-closed)" >&2
  exit 1
fi

# --- Read the entire STDIN payload. ---
payload="$(cat)" || {
  echo "woo-data: could not read tool payload from STDIN (fail-closed)" >&2
  exit 1
}

if [ -z "${payload//[[:space:]]/}" ]; then
  echo "woo-data: empty tool payload (fail-closed)" >&2
  exit 1
fi

# --- Extract tool_name; malformed JSON => fail closed. ---
# `jq -r` (NOT -e): -e exits 4 on null/absent, short-circuiting before our
# explicit empty-string check. Rely on a single -z check; a real parse failure
# of the whole payload is still caught here as fail-closed.
tool="$(printf '%s' "$payload" | jq -r '.tool_name // empty')"
jq_rc=$?
if [ "$jq_rc" -ne 0 ]; then
  echo "woo-data: malformed tool payload (could not parse .tool_name) — fail-closed" >&2
  exit 1
fi
if [ -z "$tool" ]; then
  echo "woo-data: missing .tool_name in payload (fail-closed)" >&2
  exit 1
fi

# Only gate the tools this guard is matched against. Anything else: allow.
case "$tool" in
  Bash|Write|Edit|MultiEdit|NotebookEdit) : ;;
  *) exit 0 ;;
esac

# --- Extract the subject to inspect: command first, else file_path. ---
# `jq -r` (NOT -e); rely on the explicit -z check below.
subject="$(printf '%s' "$payload" | jq -r '.tool_input.command // .tool_input.file_path // empty')"
jq_rc=$?
if [ "$jq_rc" -ne 0 ]; then
  echo "woo-data: malformed tool_input (.command/.file_path) — fail-closed" >&2
  exit 1
fi
if [ -z "$subject" ]; then
  echo "woo-data: tool call without a command or file_path to inspect (fail-closed)" >&2
  exit 1
fi

# --- Is this actually a WooCommerce project? ---
# Order/payment-data blocks ONLY apply to WooCommerce projects. Read
# ./resolved-config.json `.flags.WOO`; if it is false, or the config is absent
# or unreadable, do NOT apply order-data blocks (a plain website is unaffected).
woo_enabled=0
if [ -f ./resolved-config.json ]; then
  woo_flag="$(jq -r '.flags.WOO // false' ./resolved-config.json 2>/dev/null)"
  if [ "$woo_flag" = "true" ]; then
    woo_enabled=1
  fi
fi

# If not a WooCommerce project, there is nothing order-specific to gate.
if [ "$woo_enabled" -ne 1 ]; then
  exit 0
fi

# ===========================================================================
# WooCommerce project: enforce the order/payment HARD GATE.
#
# Scope carefully — the REAL risk is order/payment DATA EXFILTRATION, not
# legitimate development. Writing PHP that calls wc_get_orders() is normal CRUD
# dev and must NOT be blocked. A full local `wp db export local.sql` is an
# allowed local backup (its exfiltration is caught by guard-two-lane.sh's
# transport/commit checks). We block only:
#   1) Committing/deploying order DATA FILES (orders*.csv / orders*.sql).
#   2) Order tables in a dump/export/exfiltration context.
#   3) Changes to checkout / cart-total / payment-gateway FILES (human gate).
# ===========================================================================

# --- 1) Order DATA FILES being committed/exported (anchored to real files). ---
#   orders.csv, orders-export.csv, order-2026.sql, ...
if printf '%s' "$subject" | grep -Eiq '(^|[/[:space:]=])orders?[^/[:space:]]*\.(csv|sql)([[:space:]]|$|[^a-z])'
then
  echo "woo-data: BLOCKED — order data files (orders*.csv / orders*.sql) are never deployed or committed." >&2
  echo "woo-data: offending subject: $subject" >&2
  exit 2
fi

# --- 2) Order/customer tables moved in a DUMP/EXPORT/exfiltration context. ---
# Block raw order/customer tables only when paired with a dump/export/query that
# pulls the DATA out — NOT plain references in code.
if printf '%s' "$subject" | grep -Eiq '(wc_orders|wp_woocommerce_order|wc_customer_lookup|wc_order_(stats|product_lookup))' \
   && printf '%s' "$subject" | grep -Eiq '(mysqldump|db[ _-]?(export|dump)|select\b|into[[:space:]]+outfile|\.(csv|sql)\b)'
then
  echo "woo-data: BLOCKED — order/customer tables must not be dumped, exported or queried out." >&2
  echo "woo-data: offending subject: $subject" >&2
  exit 2
fi

# --- 3) checkout / cart-total / payment-gateway FILES need the HUMAN GATE. ---
# Anchored to real WooCommerce FILE paths/extensions so we do NOT match git
# subcommands (`git checkout -b feature/x`) or test specs (checkout.spec.ts).
if printf '%s' "$subject" | grep -Eiq \
  '(/(form-)?checkout[^/]*\.(php|blade\.php)|woocommerce/checkout/|class-wc-cart|cart[-_]totals?\.php|class-wc-payment-gateway|payment[ _-]?gateways?/.+\.php|includes/gateways/.+\.php)'
then
  echo "woo-data: BLOCKED — checkout / cart-total / payment-gateway changes need a HUMAN GATE" >&2
  echo "          + wp-security-reviewer sign-off before merge (spec §4.4)." >&2
  echo "woo-data: offending subject: $subject" >&2
  exit 2
fi

exit 0
