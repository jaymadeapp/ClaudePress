#!/usr/bin/env bash
#
# validate-config.sh — ClaudePress skill Step 2 (plan-validate-execute)
#
# Validates ./resolved-config.json (in CWD) against the contract in spec §3.6.
# This is the SINGLE shared contract that validate-config.sh, scaffold.sh and the
# CLAUDE.md renderer all rely on. It is the fail-closed gate that STOPS the skill
# before any scaffolding runs.
#
# Validation (all violations -> messages to STDERR, exit non-zero):
#   - file exists and is valid JSON
#   - all required keys present:
#       env, build, subtype, slug, project_name, php_version,
#       db_engine, db_requirement, flags{WOO,DOCKER}
#   - enum/pattern checks:
#       env ∈ {docker, no-docker}; build ∈ {website, woocommerce}
#       subtype ∈ {business, blog, portfolio, small-shop, catalog}
#       slug matches ^[a-z0-9]+(-[a-z0-9]+)*$
#       php_version matches ^8\.[3-9]$
#       db_engine ∈ {mariadb, mysql, sqlite}; db_requirement ∈ {any, mysql}
#   - derived rules:
#       flags.WOO    == (build == "woocommerce")
#       flags.DOCKER == (env   == "docker")
#       build==woocommerce  => db_engine ∈ {mariadb,mysql} AND db_requirement==mysql AND NOT sqlite
#       env==no-docker AND build==woocommerce => RISKY COMBO -> warn + exit non-zero (skill STOPS
#         for explicit user confirmation; never silently proceed)
#
# Fail-closed: any parse failure or any violation exits non-zero. Exit 0 only when
# the config is fully valid AND not a risky-combo.

set -uo pipefail

CONFIG="${1:-./resolved-config.json}"

err()  { printf 'validate-config: ERROR: %s\n' "$*" >&2; }
warn() { printf 'validate-config: WARNING: %s\n' "$*" >&2; }

# --- Preconditions. ---
if ! command -v jq >/dev/null 2>&1; then
  err "jq is required to validate the config (fail-closed)"
  exit 1
fi
if [ ! -f "$CONFIG" ]; then
  err "config file not found: $CONFIG"
  exit 1
fi

# --- Must be valid JSON. ---
if ! jq -e . "$CONFIG" >/dev/null 2>&1; then
  err "$CONFIG is not valid JSON (fail-closed)"
  exit 1
fi

# Track violations; accumulate so we can report everything at once, then fail.
violations=0
fail() { err "$*"; violations=$((violations + 1)); }

# get <jq-filter> -> echoes value or empty string
get() { jq -r "$1 // empty" "$CONFIG" 2>/dev/null; }

# has_top_key <key> -> 0 if the top-level object has <key> (even if its value is
# null/false), else 1. Uses jq's has() so a falsy VALUE never reads as "missing".
has_top_key() { jq -e --arg k "$1" 'has($k)' "$CONFIG" >/dev/null 2>&1; }

# has_flag_key <key> -> 0 if .flags has <key> (even if false), else 1.
has_flag_key() { jq -e --arg k "$1" '(.flags // {}) | has($k)' "$CONFIG" >/dev/null 2>&1; }

# --- Required keys present. ---
for key in env build subtype slug project_name php_version db_engine db_requirement flags; do
  if ! has_top_key "$key"; then
    fail "missing required key: $key"
  fi
done
if ! has_flag_key "WOO";    then fail "missing required key: flags.WOO";    fi
if ! has_flag_key "DOCKER"; then fail "missing required key: flags.DOCKER"; fi

# Read values (empty if absent).
env_val="$(get '.env')"
build_val="$(get '.build')"
subtype_val="$(get '.subtype')"
slug_val="$(get '.slug')"
project_name_val="$(get '.project_name')"
php_version_val="$(get '.php_version')"
db_engine_val="$(get '.db_engine')"
db_requirement_val="$(get '.db_requirement')"
# Booleans: read as raw so we can distinguish true/false/missing. We must NOT use
# the `// empty` alternative here — it fires on a literal `false`, which would
# make a valid `false` flag read as missing. Map an absent key to empty instead.
woo_flag="$(jq -r 'if (.flags // {}) | has("WOO") then (.flags.WOO | tostring) else empty end' "$CONFIG" 2>/dev/null)"
docker_flag="$(jq -r 'if (.flags // {}) | has("DOCKER") then (.flags.DOCKER | tostring) else empty end' "$CONFIG" 2>/dev/null)"

# in_set <value> <space-separated allowed>
in_set() {
  local val="$1"; shift
  local x
  for x in "$@"; do
    [ "$val" = "$x" ] && return 0
  done
  return 1
}

# --- Enum / pattern checks. ---
in_set "$env_val" docker no-docker \
  || fail "env must be one of {docker, no-docker}, got: '${env_val}'"

in_set "$build_val" website woocommerce \
  || fail "build must be one of {website, woocommerce}, got: '${build_val}'"

in_set "$subtype_val" business blog portfolio small-shop catalog \
  || fail "subtype must be one of {business, blog, portfolio, small-shop, catalog}, got: '${subtype_val}'"

if ! printf '%s' "$slug_val" | grep -Eq '^[a-z0-9]+(-[a-z0-9]+)*$'; then
  fail "slug must match ^[a-z0-9]+(-[a-z0-9]+)*\$ (lowercase kebab-case), got: '${slug_val}'"
fi

if [ -z "$project_name_val" ]; then
  fail "project_name must be a non-empty string"
fi

if ! printf '%s' "$php_version_val" | grep -Eq '^8\.[3-9]$'; then
  fail "php_version must match ^8\\.[3-9]\$ (>=8.3), got: '${php_version_val}'"
fi

in_set "$db_engine_val" mariadb mysql sqlite \
  || fail "db_engine must be one of {mariadb, mysql, sqlite}, got: '${db_engine_val}'"

in_set "$db_requirement_val" any mysql \
  || fail "db_requirement must be one of {any, mysql}, got: '${db_requirement_val}'"

in_set "$woo_flag" true false \
  || fail "flags.WOO must be a boolean (true/false), got: '${woo_flag}'"

in_set "$docker_flag" true false \
  || fail "flags.DOCKER must be a boolean (true/false), got: '${docker_flag}'"

# --- Derived rule: flags must agree with env/build. ---
expected_woo="false"
[ "$build_val" = "woocommerce" ] && expected_woo="true"
if [ "$woo_flag" != "$expected_woo" ]; then
  fail "flags.WOO ($woo_flag) must equal (build == woocommerce) -> expected $expected_woo"
fi

expected_docker="false"
[ "$env_val" = "docker" ] && expected_docker="true"
if [ "$docker_flag" != "$expected_docker" ]; then
  fail "flags.DOCKER ($docker_flag) must equal (env == docker) -> expected $expected_docker"
fi

# --- Derived rule: WooCommerce DB constraints (no SQLite, MySQL/MariaDB only). ---
if [ "$build_val" = "woocommerce" ]; then
  if [ "$db_engine_val" = "sqlite" ]; then
    fail "WooCommerce forbids SQLite — db_engine must be mariadb or mysql (HPOS is engine-specific)"
  elif ! in_set "$db_engine_val" mariadb mysql; then
    fail "WooCommerce requires db_engine ∈ {mariadb, mysql}, got: '${db_engine_val}'"
  fi
  if [ "$db_requirement_val" != "mysql" ]; then
    fail "WooCommerce requires db_requirement == 'mysql', got: '${db_requirement_val}'"
  fi
fi

# If structural validation already failed, stop here (fail-closed).
if [ "$violations" -gt 0 ]; then
  err "$violations validation error(s) — skill must STOP."
  exit 1
fi

# --- Risky combo: WooCommerce on no-Docker (spec §3.4). ---
# Even though the config is structurally valid, this combination requires the
# user to confirm a local MySQL is available. We STOP (non-zero) so SKILL.md
# surfaces the warning and asks for explicit confirmation before scaffolding.
if [ "$env_val" = "no-docker" ] && [ "$build_val" = "woocommerce" ]; then
  warn "risky combo: WooCommerce on no-Docker requires a local MySQL."
  warn "WooCommerce/HPOS needs MySQL/MariaDB — SQLite and a light no-Docker setup"
  warn "cannot guarantee CI parity or correct order behaviour."
  warn "STOPPING for confirmation: either switch to Docker (recommended), or only"
  warn "continue if you have a verified local MySQL (db_requirement is already 'mysql')."
  exit 2
fi

printf 'validate-config: OK — resolved-config.json is valid (%s / %s / %s).\n' \
  "$env_val" "$build_val" "$subtype_val" >&2
exit 0
