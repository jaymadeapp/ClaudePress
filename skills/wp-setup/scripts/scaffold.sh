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
# 3. Composer requires per build type (project-specific extras ONLY)
# ----------------------------------------------------------------------------
# Bedrock ALREADY requires WordPress core + base packages (roots/wordpress,
# composer/installers, vlucas/phpdotenv, roots/wp-config, roots/bedrock-autoloader,
# ...). Our fragments add ONLY extras: WordPress plugins via Roots' WP Packages
# repo (names "wp-plugin/<slug>", registered in Bedrock by default since
# WPackagist's 2026 retirement) plus dev tooling from regular Packagist. We pin
# composer's platform PHP to the chosen version and require packages INDIVIDUALLY,
# so one unavailable package never blocks the rest and the lock installs cleanly
# inside the matching DDEV/container PHP.
step "Step 3/4 — Composer requires for build type '$BUILD_VAL'"

FRAGMENT=""
case "$BUILD_VAL" in
  website)     FRAGMENT="$TEMPLATES_DIR/composer/website.json" ;;
  woocommerce) FRAGMENT="$TEMPLATES_DIR/composer/woocommerce.json" ;;
esac

# NOTE on PHP versions: we deliberately do NOT pin composer's config.platform.php.
# Pinning to a truncated "8.4" means 8.4.0, which under-satisfies dependencies that
# need >= 8.4.1 (current Bedrock/Sage pull pestphp/pest -> symfony/process >= 8.4.1).
# Instead the installer defaults php_version to the DETECTED host PHP, so the lock
# (resolved on the host) installs cleanly in the matching DDEV container PHP.
# Picking a php_version BELOW your host PHP can cause a lock/container mismatch —
# and Sage 11 / Acorn 6 require PHP >= 8.4.1, so 8.4+ is the practical floor.
if have composer && [ -f "composer.json" ] && [ -n "${PHP_VERSION:-}" ]; then
  say "Using PHP $PHP_VERSION (host-matched). composer resolves against the host PHP; no platform override."
fi

# Allow the dev-tooling Composer plugins (phpcs + phpstan installers). Without
# this, composer aborts the require with an "allow-plugins" exception (the
# packages download, but the command exits non-zero). Bedrock already allows
# composer/installers and roots/wordpress-core-installer.
if have composer && [ -f "composer.json" ]; then
  composer config allow-plugins.dealerdirect/phpcodesniffer-composer-installer true >/dev/null 2>&1
  composer config allow-plugins.phpstan/extension-installer true >/dev/null 2>&1
  say "Allowed phpcs/phpstan composer plugins."
fi

# require_set <prod|dev> pkg...  — batch require (fast); on failure, fall back to
# per-package so one bad package can't block the rest. Idempotent + non-fatal.
require_set() {
  local mode="$1"; shift
  local devflag=""
  [ "$mode" = "dev" ] && devflag="--dev"
  local pkgs=("$@")
  [ "${#pkgs[@]}" -gt 0 ] || return 0
  local missing=() pkg name
  for pkg in "${pkgs[@]}"; do
    name="${pkg%%:*}"
    if [ -f "composer.json" ] && jq -e --arg p "$name" \
         '((.require // {}) + (."require-dev" // {})) | has($p)' composer.json >/dev/null 2>&1; then
      say "already required: $name"
    else
      missing+=("$pkg")
    fi
  done
  [ "${#missing[@]}" -gt 0 ] || return 0
  if ! have composer || [ ! -f "composer.json" ]; then
    for pkg in "${missing[@]}"; do add_manual "composer require $devflag $pkg"; done
    return
  fi
  say "requiring ($mode, batched): ${missing[*]}"
  if composer require --no-interaction $devflag "${missing[@]}"; then
    return
  fi
  warn "batch require failed — retrying individually to isolate the culprit..."
  for pkg in "${missing[@]}"; do
    if ! composer require --no-interaction $devflag "$pkg"; then
      warn "composer require failed: $pkg"
      add_manual "composer require $devflag $pkg"
    fi
  done
}

# read_pkgs <jq-key>  -> "name:constraint" lines from the fragment for that key.
read_pkgs() {
  [ -f "$FRAGMENT" ] && jq -e . "$FRAGMENT" >/dev/null 2>&1 || return 0
  jq -r --arg k "$1" '((.[$k] // {}) | to_entries[] | "\(.key):\(.value)")' "$FRAGMENT" 2>/dev/null
}

if [ -f "$FRAGMENT" ] && jq -e . "$FRAGMENT" >/dev/null 2>&1; then
  say "using composer fragment: $FRAGMENT"
else
  say "composer fragment not found ($FRAGMENT) — only the Woo fallback (if any) applies."
fi

# Production requires (plugins), plus a WooCommerce fallback for the Woo build.
PROD_PKGS=()
while IFS= read -r line; do [ -n "$line" ] && PROD_PKGS+=("$line"); done < <(read_pkgs require)
if [ "$BUILD_VAL" = "woocommerce" ] || [ "$WOO_FLAG" = "true" ]; then
  found_woo="no"
  if [ "${#PROD_PKGS[@]}" -gt 0 ]; then
    for p in "${PROD_PKGS[@]}"; do
      case "$p" in wp-plugin/woocommerce*) found_woo="yes" ;; esac
    done
  fi
  [ "$found_woo" = "no" ] && PROD_PKGS+=("wp-plugin/woocommerce:10.9.*")
fi

# Dev requires (tooling).
DEV_PKGS=()
while IFS= read -r line; do [ -n "$line" ] && DEV_PKGS+=("$line"); done < <(read_pkgs require-dev)

require_set prod ${PROD_PKGS[@]+"${PROD_PKGS[@]}"}
require_set dev  ${DEV_PKGS[@]+"${DEV_PKGS[@]}"}
if [ "${#PROD_PKGS[@]}" -eq 0 ] && [ "${#DEV_PKGS[@]}" -eq 0 ]; then
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
    # Substitute {{SLUG}} and {{PHP_VERSION}} placeholders as we copy.
    sed -e "s/{{SLUG}}/${SLUG}/g" \
        -e "s/{{PHP_VERSION}}/${PHP_VERSION:-8.3}/g" \
        "$DDEV_SRC" > ".ddev/config.yaml" || die "could not write ddev config"
    say "Rendered $(basename "$DDEV_SRC") -> .ddev/config.yaml (slug=$SLUG php=${PHP_VERSION:-8.3})"
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

  # Native wp resolves Bedrock's WordPress core under web/wp via wp-cli.yml.
  WPCLI_SRC="$TEMPLATES_DIR/wp-cli.yml"
  if [ -f "wp-cli.yml" ]; then
    say "wp-cli.yml already exists — leaving it untouched (non-destructive)."
  elif [ -f "$WPCLI_SRC" ]; then
    cp "$WPCLI_SRC" "wp-cli.yml" || die "could not copy wp-cli.yml"
    say "Copied wp-cli.yml (path: web/wp) so native 'wp' finds Bedrock core."
  else
    warn "wp-cli.yml template not found: $WPCLI_SRC"
    add_manual "Create wp-cli.yml in the project root with: path: web/wp"
  fi

  add_next "Provide a local PHP ${PHP_VERSION:-8.3}+ and a ${DB_ENGINE:-MySQL/MariaDB} database."
  add_next "Serve WP natively: 'wp server --docroot=web' for trivial local use, or point an nginx/Apache + php-fpm vhost at docroot web/."
  if [ "$BUILD_VAL" = "woocommerce" ] || [ "$WOO_FLAG" = "true" ]; then
    add_next "WooCommerce requires MySQL/MariaDB (NOT SQLite) — point .env DB_* at it."
  fi
  add_next "Install dependencies: composer install"
fi

# Common next steps.
add_next "Copy .env.example to .env and fill DB credentials (NEVER commit .env)."

# ----------------------------------------------------------------------------
# 4c. Project .mcp.json — copy the build-type MCP template, pick the runner.
# ----------------------------------------------------------------------------
# Non-destructive like the ddev config: never clobber an existing .mcp.json
# without a backup. For no-Docker we rewrite the `wordpress` server to the native
# `wp` form (the on-disk templates default to the DDEV/Docker `ddev` runner).
MCP_SRC="$TEMPLATES_DIR/mcp/${BUILD_VAL}.json"

if [ -f "$MCP_SRC" ] && jq -e . "$MCP_SRC" >/dev/null 2>&1; then
  if [ -f ".mcp.json" ]; then
    cp ".mcp.json" ".mcp.json.bak" 2>/dev/null || true
    say ".mcp.json already exists — backed it up to .mcp.json.bak before overwriting."
  fi
  if [ "$DOCKER_FLAG" = "true" ] || [ "$ENV_VAL" = "docker" ]; then
    # Docker/DDEV form is the on-disk default — copy as-is.
    cp "$MCP_SRC" ".mcp.json" || die "could not write .mcp.json"
    say "Wrote .mcp.json (DDEV/Docker WordPress MCP runner)."
  else
    # no-Docker: rewrite the wordpress server to the native `wp` form.
    jq '.mcpServers.wordpress.command = "wp"
        | .mcpServers.wordpress.args = ["mcp-adapter","serve","--server=mcp-adapter-default-server","--user=claudepress-mcp"]' \
      "$MCP_SRC" > ".mcp.json" || die "could not write .mcp.json (no-Docker runner rewrite)"
    say "Wrote .mcp.json (native 'wp' WordPress MCP runner for no-Docker)."
  fi
else
  warn "MCP template not found or invalid: $MCP_SRC"
  add_manual "Create .mcp.json from templates/mcp/${BUILD_VAL}.json (no-Docker: set wordpress.command to 'wp')."
fi

# ----------------------------------------------------------------------------
# 4d. Deterministic renders — files that are documented but otherwise only
# Claude-rendered, so the Bedrock merge (which ships its OWN .gitignore) can
# silently shadow them. We render them here so they ALWAYS exist, regardless of
# whether the agent followed the SKILL.md Step-3 prose. All idempotent +
# non-destructive + bash-3.2-safe.
# ----------------------------------------------------------------------------
step "Step 4d — Deterministic project files (.gitignore / content-seed / deploy.json)"

# (a) .gitignore — Bedrock ships its own, so append a ClaudePress block guarded
# by a marker. This guarantees the PII/secret/DB-dump ignore rules survive the
# non-destructive Bedrock merge. Grep-then-append so re-runs never duplicate.
GITIGNORE_MARKER="# ClaudePress"
if [ -f ".gitignore" ] && grep -qF "$GITIGNORE_MARKER" ".gitignore" 2>/dev/null; then
  say ".gitignore already has the ClaudePress block — leaving it untouched."
else
  {
    printf '\n%s — keep PII/secrets/DB dumps out of git (two-lane invariant)\n' "$GITIGNORE_MARKER"
    printf '/.claude/requests/\n'
    printf '*.sql\n'
    printf '/db-dumps/\n'
    printf '/.env\n'
    printf '/web/app/uploads/\n'
  } >> ".gitignore" || die "could not append ClaudePress block to .gitignore"
  say "Appended ClaudePress block to .gitignore (requests/, *.sql, db-dumps/, .env, uploads/)."
fi

# (b) content-seed mu-plugin — render from the template, substituting {{SLUG}}
# and {{TEXTDOMAIN}} (= slug). Skip if it already exists (non-destructive).
SEED_SRC="$TEMPLATES_DIR/mu-plugins/content-seed.php.tmpl"
SEED_DST="web/app/mu-plugins/content-seed.php"
if [ -f "$SEED_DST" ]; then
  say "$SEED_DST already exists — leaving it untouched (non-destructive)."
elif [ -f "$SEED_SRC" ]; then
  mkdir -p "web/app/mu-plugins" || die "could not create web/app/mu-plugins directory"
  sed -e "s/{{SLUG}}/${SLUG}/g" \
      -e "s/{{TEXTDOMAIN}}/${SLUG}/g" \
      "$SEED_SRC" > "$SEED_DST" || die "could not render content-seed.php"
  say "Rendered content-seed.php.tmpl -> $SEED_DST (slug=$SLUG)."
else
  warn "content-seed template not found: $SEED_SRC"
  add_manual "Render web/app/mu-plugins/content-seed.php from templates/mu-plugins/content-seed.php.tmpl (substitute {{SLUG}}/{{TEXTDOMAIN}})."
fi

# (c) .claude/deploy.json — deploy config the deploy-staging helper reads.
# Skip if it already exists (back up to be safe), substituting {{SLUG}} if the
# template uses it.
DEPLOY_SRC="$TEMPLATES_DIR/deploy.example.json"
DEPLOY_DST=".claude/deploy.json"
if [ -f "$DEPLOY_SRC" ]; then
  mkdir -p ".claude" || die "could not create .claude directory"
  if [ -f "$DEPLOY_DST" ]; then
    cp "$DEPLOY_DST" "$DEPLOY_DST.bak" 2>/dev/null || true
    say "$DEPLOY_DST already exists — backed it up to $DEPLOY_DST.bak, leaving the original untouched."
  else
    sed -e "s/{{SLUG}}/${SLUG}/g" "$DEPLOY_SRC" > "$DEPLOY_DST" || die "could not write $DEPLOY_DST"
    say "Rendered deploy.example.json -> $DEPLOY_DST."
  fi
else
  warn "deploy config template not found: $DEPLOY_SRC"
  add_manual "Create .claude/deploy.json from templates/deploy.example.json."
fi

# ----------------------------------------------------------------------------
# 4e. Design system — render the AUTHORITATIVE theme.json (base ⊕ subtype preset)
# into the theme root, then overlay the pattern library, section-style variations,
# self-hosted fonts and the token-mirrored CSS. Idempotent + non-destructive.
#   - Sage's Vite build MERGES our theme.json (base-wins on slug dedupe), so ours
#     is authoritative; we overwrite Sage's minimal stub (backing it up first).
#   - WP core auto-loads /patterns and /styles from the active theme root.
#   - Self-hosted fonts live at the theme ROOT (not resources/, which Vite hashes),
#     so the theme.json `file:./fonts/...` srcs resolve. See reference/design-system.md.
# ----------------------------------------------------------------------------
step "Step 4e — Design system (theme.json + patterns + styles + fonts + CSS)"

DESIGN_SRC="$TEMPLATES_DIR/theme"            # patterns/, styles/, fonts/, css/
BASE_TJ="$TEMPLATES_DIR/theme.json"

if [ ! -d "$THEME_DIR" ]; then
  warn "theme dir $THEME_DIR missing — skipping design system (Sage not installed)."
  add_manual "Re-run scaffold once the Sage theme exists to install the ClaudePress design system."
else
  # Map subtype -> preset (small-shop/catalog share the 'shop' preset).
  case "$SUBTYPE_VAL" in
    business)           PRESET_NAME="business" ;;
    blog)               PRESET_NAME="blog" ;;
    portfolio)          PRESET_NAME="portfolio" ;;
    small-shop|catalog) PRESET_NAME="shop" ;;
    *) if [ "$WOO_FLAG" = "true" ] || [ "$BUILD_VAL" = "woocommerce" ]; then PRESET_NAME="shop"; else PRESET_NAME="business"; fi ;;
  esac
  PRESET_TJ="$TEMPLATES_DIR/theme-presets/${PRESET_NAME}.json"
  DST_TJ="$THEME_DIR/theme.json"

  # (a) theme.json — deep-merge base ⊕ preset, with palette + fontFamilies merged
  # BY SLUG so base-only tokens (e.g. the `mono` family) survive a partial preset.
  if [ -f "$BASE_TJ" ] && have jq && jq -e . "$BASE_TJ" >/dev/null 2>&1; then
    [ -f "$DST_TJ" ] && { cp "$DST_TJ" "$DST_TJ.bak" 2>/dev/null || true; }
    if [ -f "$PRESET_TJ" ] && jq -e . "$PRESET_TJ" >/dev/null 2>&1; then
      if jq -s '
            def bySlug($a; $b): ([ $a[]?, $b[]? ] | group_by(.slug) | map(.[-1]));
            .[0] as $base | .[1] as $ov |
            ($base * $ov)
            | .settings.color.palette =
                ( if ($ov.settings.color.palette // null) != null
                  then bySlug($base.settings.color.palette // []; $ov.settings.color.palette)
                  else ($base.settings.color.palette // []) end )
            | .settings.typography.fontFamilies =
                ( if ($ov.settings.typography.fontFamilies // null) != null
                  then bySlug($base.settings.typography.fontFamilies // []; $ov.settings.typography.fontFamilies)
                  else ($base.settings.typography.fontFamilies // []) end )
          ' "$BASE_TJ" "$PRESET_TJ" > "$DST_TJ.tmp" 2>/dev/null && jq -e . "$DST_TJ.tmp" >/dev/null 2>&1; then
        mv "$DST_TJ.tmp" "$DST_TJ"
        say "Rendered theme.json (base ⊕ ${PRESET_NAME} preset, slug-merged)."
      else
        rm -f "$DST_TJ.tmp" 2>/dev/null || true
        cp "$BASE_TJ" "$DST_TJ" || die "could not write theme.json"
        warn "preset merge failed — wrote base theme.json only."
      fi
    else
      cp "$BASE_TJ" "$DST_TJ" || die "could not write theme.json"
      say "Rendered theme.json (base; no usable '${PRESET_NAME}' preset)."
    fi
  else
    warn "base theme.json template missing/invalid or jq unavailable: $BASE_TJ"
    add_manual "Render $THEME_DIR/theme.json from templates/theme.json (+ subtype preset)."
  fi

  # (b/c/d) pattern library + section styles + self-hosted fonts — overlay into the
  # theme root. cp -Rn never clobbers a user-edited file (kit-owned assets only add).
  for sub in patterns styles fonts; do
    if [ -d "$DESIGN_SRC/$sub" ]; then
      mkdir -p "$THEME_DIR/$sub" || die "could not create $THEME_DIR/$sub"
      if cp -Rn "$DESIGN_SRC/$sub/." "$THEME_DIR/$sub/" 2>/dev/null; then
        say "Installed design $sub -> $THEME_DIR/$sub/"
      else
        warn "could not copy design $sub into $THEME_DIR/$sub/"
      fi
    fi
  done

  # (e) Token-mirrored CSS — append our @theme + base niceties to Sage's app.css,
  # marker-guarded so re-runs never duplicate.
  CSS_APPEND="$DESIGN_SRC/css/app.css.append"
  APP_CSS="$THEME_DIR/resources/css/app.css"
  if [ -f "$CSS_APPEND" ]; then
    if [ -f "$APP_CSS" ] && grep -qF "ClaudePress design tokens" "$APP_CSS" 2>/dev/null; then
      say "app.css already has the ClaudePress design block — leaving it untouched."
    elif [ -d "$(dirname "$APP_CSS")" ] || mkdir -p "$(dirname "$APP_CSS")" 2>/dev/null; then
      { printf '\n'; cat "$CSS_APPEND"; } >> "$APP_CSS" \
        && say "Appended ClaudePress design tokens -> $APP_CSS" \
        || warn "could not append design CSS to $APP_CSS"
    else
      warn "Sage resources/css dir missing — could not append design CSS."
      add_manual "Append templates/theme/css/app.css.append to $APP_CSS"
    fi
  fi

  # (f) Register the ClaudePress block-pattern category (mu-plugin).
  PATCAT_SRC="$TEMPLATES_DIR/mu-plugins/claudepress-design.php.tmpl"
  PATCAT_DST="web/app/mu-plugins/claudepress-design.php"
  if [ -f "$PATCAT_DST" ]; then
    say "$PATCAT_DST already exists — leaving it untouched (non-destructive)."
  elif [ -f "$PATCAT_SRC" ]; then
    mkdir -p "web/app/mu-plugins" || die "could not create web/app/mu-plugins directory"
    sed -e "s/{{TEXTDOMAIN}}/${SLUG}/g" "$PATCAT_SRC" > "$PATCAT_DST" \
      || die "could not render claudepress-design.php"
    say "Rendered claudepress-design.php (pattern category) -> $PATCAT_DST."
  fi

  add_next "Rebuild theme assets so theme.json + tokens take effect: (cd $THEME_DIR && npm install && npm run build)"
fi

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
