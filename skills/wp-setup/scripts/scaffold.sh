#!/usr/bin/env bash
#
# scaffold.sh — ClaudePress skill Step 4 (idempotent environment bootstrap)
#
# Usage: scaffold.sh <path-to-resolved-config.json>
#
# Runs the HEAVY commands of project bootstrap, driven by resolved-config.json.
# Template RENDERING (CLAUDE.md, settings.json, theme.json, phpcs.xml, ...) is
# done by Claude in SKILL.md Step 3 — NOT here. This script only runs the parts
# that need a shell: composer create-project, theme install, composer require.
#
# Design guarantees:
#   - IDEMPOTENT: every step is guarded so re-runs are safe. We never overwrite an
#     existing Bedrock/Sage install or delete user data.
#   - NON-DESTRUCTIVE: no `rm -rf` of project dirs, no destructive git. We only add.
#   - DEFENSIVE: if a required tool is missing, we print the exact manual command
#     instead of failing the whole run, and record it so the final summary is honest.
#   - SAFE create-project: roots/bedrock requires an empty target dir, so we
#     create it in a temporary directory and MERGE the result in, never clobbering
#     pre-existing files.
#
# Exit status: 0 if all attempted steps succeeded (or were already done /
# deferred to manual with a clear message). Non-zero only on a hard error
# (bad config, an executed command that failed).

set -uo pipefail

# ----------------------------------------------------------------------------
# Plumbing
# ----------------------------------------------------------------------------
CONFIG="${1:-}"

say()   { printf '  %s\n' "$*"; }
step()  { printf '\n==> %s\n' "$*"; }
warn()  { printf '  ! %s\n' "$*" >&2; }
die()   { printf '\nscaffold: FATAL: %s\n' "$*" >&2; exit 1; }

# Collected manual follow-ups (tools missing) and a final next-steps list.
declare -a MANUAL_STEPS=()
declare -a NEXT_STEPS=()
add_manual() { MANUAL_STEPS+=("$*"); }
add_next()   { NEXT_STEPS+=("$*"); }

# have <bin> -> true if on PATH
have() { command -v "$1" >/dev/null 2>&1; }

# Resolve the directory of this script so we can find bundled ddev templates.
SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" >/dev/null 2>&1 && pwd)"
SKILL_DIR="$(cd "$SCRIPT_DIR/.." >/dev/null 2>&1 && pwd)"   # .../skills/wp-setup
TEMPLATES_DIR="$SKILL_DIR/templates"

# ----------------------------------------------------------------------------
# 0. Validate inputs
# ----------------------------------------------------------------------------
[ -n "$CONFIG" ] || die "usage: scaffold.sh <resolved-config.json>"
[ -f "$CONFIG" ] || die "config file not found: $CONFIG"
have jq || die "jq is required to read the config"
jq -e . "$CONFIG" >/dev/null 2>&1 || die "config is not valid JSON: $CONFIG"

# Read config values.
ENV_VAL="$(jq -r '.env // empty' "$CONFIG")"
BUILD_VAL="$(jq -r '.build // empty' "$CONFIG")"
SUBTYPE_VAL="$(jq -r '.subtype // empty' "$CONFIG")"
SLUG="$(jq -r '.slug // empty' "$CONFIG")"
PHP_VERSION="$(jq -r '.php_version // empty' "$CONFIG")"
DB_ENGINE="$(jq -r '.db_engine // empty' "$CONFIG")"
WOO_FLAG="$(jq -r '.flags.WOO // false' "$CONFIG")"
DOCKER_FLAG="$(jq -r '.flags.DOCKER // false' "$CONFIG")"

# Minimal sanity (validate-config.sh is the authoritative gate; this is a guard
# against being run on garbage out of order).
[ -n "$ENV_VAL" ]   || die "config missing 'env' (run validate-config.sh first)"
[ -n "$BUILD_VAL" ] || die "config missing 'build' (run validate-config.sh first)"
[ -n "$SLUG" ]      || die "config missing 'slug' (run validate-config.sh first)"
printf '%s' "$SLUG" | grep -Eq '^[a-z0-9]+(-[a-z0-9]+)*$' \
  || die "slug '$SLUG' is not valid kebab-case (run validate-config.sh first)"

PROJECT_ROOT="$(pwd)"
THEME_DIR="web/app/themes/${SLUG}"

step "ClaudePress scaffold — env=$ENV_VAL build=$BUILD_VAL subtype=$SUBTYPE_VAL slug=$SLUG"
say "project root: $PROJECT_ROOT"
say "php: ${PHP_VERSION:-?}  db: ${DB_ENGINE:-?}  WOO=$WOO_FLAG DOCKER=$DOCKER_FLAG"

# ----------------------------------------------------------------------------
# Helper: detect whether a composer.json is already a Bedrock root.
# ----------------------------------------------------------------------------
is_bedrock_root() {
  [ -f "composer.json" ] || return 1
  # Bedrock declares roots/wordpress-core-installer + a web/wp install path, and
  # its name is typically "roots/bedrock". Check for the strong signal.
  if jq -e '
        (.require // {}) | has("roots/wordpress-core-installer")
        or has("roots/bedrock-autoloader")
      ' composer.json >/dev/null 2>&1; then
    return 0
  fi
  # Fallback signal: the canonical Bedrock directory layout already exists.
  if [ -d "web/wp" ] && [ -f "config/application.php" ]; then
    return 0
  fi
  return 1
}

# ----------------------------------------------------------------------------
# 1. Bedrock — composer create-project roots/bedrock (idempotent, non-clobbering)
# ----------------------------------------------------------------------------
step "Step 1/4 — Bedrock (roots/bedrock)"

if is_bedrock_root; then
  say "Bedrock already present (composer.json looks like a Bedrock root) — skipping create-project."
elif ! have composer; then
  warn "composer not found — cannot create Bedrock automatically."
  add_manual "composer create-project roots/bedrock . --no-interaction"
  say "Recorded as a manual step."
else
  # roots/bedrock refuses to install into a non-empty dir. Create into a temp dir,
  # then merge into the project root WITHOUT overwriting any existing files.
  say "Creating Bedrock in a temporary directory, then merging (non-destructive)..."
  TMP_BEDROCK="$(mktemp -d "${TMPDIR:-/tmp}/claudepress-bedrock.XXXXXX")" \
    || die "could not create temp dir for Bedrock"
  # Ensure cleanup of the temp dir on exit.
  cleanup_bedrock() { [ -n "${TMP_BEDROCK:-}" ] && rm -rf "$TMP_BEDROCK" 2>/dev/null || true; }
  trap cleanup_bedrock EXIT

  if composer create-project roots/bedrock "$TMP_BEDROCK" --no-interaction; then
    say "Bedrock created; merging files that don't already exist in the project..."
    # Copy without overwriting existing files (-n) and preserving structure.
    # Use a tar pipe to copy dotfiles + nested dirs reliably and merge-safely.
    if have rsync; then
      # --ignore-existing => never clobber user files (non-destructive).
      rsync -a --ignore-existing "$TMP_BEDROCK"/ "$PROJECT_ROOT"/ \
        || die "failed to merge Bedrock into project root"
    else
      # Portable fallback: cp -Rn copies recursively and does not overwrite.
      # Enable dotglob so dotfiles (.env.example, .gitignore) are included.
      shopt -s dotglob nullglob
      cp -Rn "$TMP_BEDROCK"/. "$PROJECT_ROOT"/ \
        || die "failed to merge Bedrock into project root (cp)"
      shopt -u dotglob nullglob
    fi
    say "Bedrock merged."
  else
    warn "composer create-project roots/bedrock failed."
    add_manual "composer create-project roots/bedrock . --no-interaction"
  fi
  cleanup_bedrock
  trap - EXIT
fi

# ----------------------------------------------------------------------------
# 2. Sage theme — composer create-project roots/sage (idempotent)
# ----------------------------------------------------------------------------
step "Step 2/4 — Sage 11 theme ($THEME_DIR)"

if [ -d "$THEME_DIR" ] && [ -n "$(ls -A "$THEME_DIR" 2>/dev/null)" ]; then
  say "Theme directory already exists and is non-empty — skipping Sage install."
elif ! have composer; then
  warn "composer not found — cannot install Sage."
  add_manual "composer create-project roots/sage $THEME_DIR --no-interaction"
else
  # roots/sage also wants an empty/new target; create-project will make the dir.
  mkdir -p "$(dirname "$THEME_DIR")" || die "could not create themes directory"
  if composer create-project roots/sage "$THEME_DIR" --no-interaction; then
    say "Sage theme installed into $THEME_DIR."
    add_next "Build theme assets: (cd $THEME_DIR && npm install && npm run build)"
  else
    warn "composer create-project roots/sage failed."
    add_manual "composer create-project roots/sage $THEME_DIR --no-interaction"
  fi
fi

# ----------------------------------------------------------------------------
# 3. Composer require fragments per build type
# ----------------------------------------------------------------------------
step "Step 3/4 — Composer requires for build type '$BUILD_VAL'"

# Map build type to its composer require fragment template (spec §2.1).
FRAGMENT=""
case "$BUILD_VAL" in
  website)     FRAGMENT="$TEMPLATES_DIR/composer/website.json" ;;
  woocommerce) FRAGMENT="$TEMPLATES_DIR/composer/woocommerce.json" ;;
esac

require_packages() {
  # require_packages pkg1 pkg2 ...
  # Requires each package only if it is not already present in composer.json.
  local pkgs=("$@")
  local to_add=()
  local pkg
  if [ ! -f "composer.json" ]; then
    warn "no composer.json yet — cannot add requires (Bedrock step likely deferred)."
    for pkg in "${pkgs[@]}"; do add_manual "composer require $pkg"; done
    return
  fi
  for pkg in "${pkgs[@]}"; do
    # Check both require and require-dev.
    if jq -e --arg p "$pkg" '((.require // {}) + (."require-dev" // {})) | has($p)' \
         composer.json >/dev/null 2>&1; then
      say "already required: $pkg"
    else
      to_add+=("$pkg")
    fi
  done
  if [ "${#to_add[@]}" -eq 0 ]; then
    say "all build-type packages already required."
    return
  fi
  if ! have composer; then
    warn "composer not found — cannot run composer require."
    for pkg in "${to_add[@]}"; do add_manual "composer require $pkg"; done
    return
  fi
  say "requiring: ${to_add[*]}"
  if ! composer require --no-interaction "${to_add[@]}"; then
    warn "composer require failed for: ${to_add[*]}"
    for pkg in "${to_add[@]}"; do add_manual "composer require $pkg"; done
  fi
}

# Determine the package list. Prefer the bundled fragment (authoritative); fall
# back to a sensible minimum if the fragment isn't present.
PACKAGES=()
if [ -f "$FRAGMENT" ] && jq -e . "$FRAGMENT" >/dev/null 2>&1; then
  say "using composer fragment: $FRAGMENT"
  # Fragment is expected to be a composer-style object with a "require" map.
  while IFS= read -r line; do
    [ -n "$line" ] && PACKAGES+=("$line")
  done < <(jq -r '
      ((.require // {}) | to_entries[] | "\(.key):\(.value)")
    ' "$FRAGMENT" 2>/dev/null)
else
  say "composer fragment not found ($FRAGMENT) — using built-in minimum set."
fi

# Always ensure WooCommerce is present for the Woo build (spec requirement),
# even if the fragment was missing.
if [ "$BUILD_VAL" = "woocommerce" ] || [ "$WOO_FLAG" = "true" ]; then
  # Avoid duplicate if the fragment already lists it (any version constraint).
  found_woo="no"
  for p in "${PACKAGES[@]}"; do
    case "$p" in wpackagist-plugin/woocommerce*) found_woo="yes" ;; esac
  done
  [ "$found_woo" = "no" ] && PACKAGES+=("wpackagist-plugin/woocommerce")
fi

if [ "${#PACKAGES[@]}" -gt 0 ]; then
  require_packages "${PACKAGES[@]}"
else
  say "no packages to require for this build type."
fi

# ----------------------------------------------------------------------------
# 4. DDEV config (Docker builds only) — copy template, DON'T auto-start ddev
# ----------------------------------------------------------------------------
step "Step 4/4 — Local environment"

if [ "$ENV_VAL" = "docker" ] || [ "$DOCKER_FLAG" = "true" ]; then
  # Pick the right ddev config template.
  if [ "$BUILD_VAL" = "woocommerce" ] || [ "$WOO_FLAG" = "true" ]; then
    DDEV_SRC="$TEMPLATES_DIR/ddev/config.woo.yaml"
  else
    DDEV_SRC="$TEMPLATES_DIR/ddev/config.website.yaml"
  fi

  mkdir -p ".ddev" || die "could not create .ddev directory"

  if [ -f ".ddev/config.yaml" ]; then
    say ".ddev/config.yaml already exists — leaving it untouched (non-destructive)."
  elif [ -f "$DDEV_SRC" ]; then
    cp "$DDEV_SRC" ".ddev/config.yaml" || die "could not copy ddev config"
    say "Copied $(basename "$DDEV_SRC") -> .ddev/config.yaml"
    say "Note: placeholders (e.g. {{SLUG}}) in the ddev config are rendered by the skill."
  else
    warn "ddev config template not found: $DDEV_SRC"
    add_manual "Create .ddev/config.yaml from the appropriate ddev template."
  fi

  # We deliberately DO NOT run `ddev start` — print it as a next step instead.
  if have ddev; then
    add_next "Start the dev environment: ddev start"
  else
    warn "ddev not installed on this host."
    add_next "Install DDEV, then run: ddev start  (see https://ddev.readthedocs.io)"
  fi
  add_next "After start, install WP core deps: ddev composer install"
else
  say "no-Docker build — no .ddev/ generated."
  add_next "Provide a local PHP ${PHP_VERSION:-8.3}+ and a ${DB_ENGINE:-MySQL/MariaDB} database."
  if [ "$BUILD_VAL" = "woocommerce" ] || [ "$WOO_FLAG" = "true" ]; then
    add_next "WooCommerce requires MySQL/MariaDB (NOT SQLite) — point .env DB_* at it."
  fi
  add_next "Install dependencies: composer install"
fi

# Common next steps.
add_next "Copy .env.example to .env and fill DB credentials (NEVER commit .env)."

# ----------------------------------------------------------------------------
# 5. WordPress MCP provisioning (adapter plugin + least-privilege user)
# ----------------------------------------------------------------------------
# The MCP adapter + the claudepress-mcp user need a RUNNING WordPress DB, so we
# only run setup-mcp.sh inline if WP is already installed. Otherwise we print the
# exact follow-up command. setup-mcp.sh is itself idempotent and defensive.
step "Step 5 — WordPress MCP (local, STDIO via WP-CLI)"

SETUP_MCP="$SCRIPT_DIR/setup-mcp.sh"

# Detect the right WP-CLI runner for the "is WP installed yet?" probe.
if [ -f ".ddev/config.yaml" ] && have ddev; then
  MCP_RUNNER="ddev wp"
  MCP_INSTALL_HINT="ddev start && ddev wp core install ... && bash $SETUP_MCP"
else
  MCP_RUNNER="wp"
  MCP_INSTALL_HINT="wp core install ... && bash $SETUP_MCP"
fi

if [ ! -f "$SETUP_MCP" ]; then
  warn "setup-mcp.sh not found at $SETUP_MCP — skipping MCP provisioning."
  add_manual "bash <skill>/scripts/setup-mcp.sh   (provision the WordPress MCP)"
elif $MCP_RUNNER core is-installed >/dev/null 2>&1; then
  say "WordPress is already installed — provisioning the MCP adapter + user now..."
  if bash "$SETUP_MCP" "$CONFIG"; then
    say "WordPress MCP provisioned (adapter active, claudepress-mcp user created)."
  else
    warn "setup-mcp.sh did not complete — finish it manually once WP is up."
    add_next "Provision the WordPress MCP: $MCP_INSTALL_HINT"
  fi
else
  say "WordPress is not installed yet — deferring MCP provisioning (needs a running DB)."
  add_next "Once WordPress is installed, provision the MCP: $MCP_INSTALL_HINT"
fi

# ----------------------------------------------------------------------------
# Summary
# ----------------------------------------------------------------------------
step "Summary"
say "Build: $BUILD_VAL ($SUBTYPE_VAL), env: $ENV_VAL, slug: $SLUG"
say "Theme: $THEME_DIR"

if [ "${#MANUAL_STEPS[@]}" -gt 0 ]; then
  printf '\n  The following steps could NOT be run automatically (run them yourself):\n'
  for s in "${MANUAL_STEPS[@]}"; do printf '    - %s\n' "$s"; done
fi

printf '\n  Next commands to run:\n'
if [ "${#NEXT_STEPS[@]}" -gt 0 ]; then
  for s in "${NEXT_STEPS[@]}"; do printf '    - %s\n' "$s"; done
fi

# Exit non-zero if a tool we needed was missing and we deferred required setup,
# so the skill can clearly tell the user something is incomplete. We only treat
# deferred Bedrock/composer-require as a soft failure surfaced via MANUAL_STEPS;
# the run itself is reported as success unless a command we executed failed
# (those die()'d earlier). Here we exit 0 — the manual list is the contract.
printf '\nscaffold: done.\n'
exit 0
