#!/usr/bin/env bash
#
# test-guards.sh — self-test for the Loamkit PreToolUse guards.
#
# Pipes crafted tool-call JSON payloads into guard-two-lane.sh and
# guard-woo-data.sh and asserts the expected exit codes:
#   exit 0 = ALLOW, exit 2 = BLOCKED, other non-zero = fail-closed (parse error).
#
# Run: bash scripts/test-guards.sh   (exit 0 = all pass, 1 = at least one failed)

set -uo pipefail

HERE="$(cd "$(dirname "${BASH_SOURCE[0]}")" >/dev/null 2>&1 && pwd)"
TWO_LANE="$HERE/guard-two-lane.sh"
WOO="$HERE/guard-woo-data.sh"

pass=0
fail=0

# run_case <description> <script> <expected_exit> <json-payload>
# Runs the guard from a NON-WooCommerce working dir (no resolved-config.json),
# so woo-data's order-specific blocks are inactive unless a case opts into WOO.
run_case() {
  local desc="$1" script="$2" expected="$3" payload="$4"
  local actual
  printf '%s' "$payload" | bash "$script" >/dev/null 2>&1
  actual=$?
  if [ "$actual" -eq "$expected" ]; then
    printf '  PASS  [exit %s] %s\n' "$actual" "$desc"
    pass=$((pass + 1))
  else
    printf '  FAIL  [exit %s, expected %s] %s\n' "$actual" "$expected" "$desc"
    fail=$((fail + 1))
  fi
}

# run_case_in <dir> <description> <script> <expected_exit> <json-payload>
# Same as run_case but executes the guard with CWD = <dir> (a subshell `cd`),
# so guards that read ./resolved-config.json or inspect the git work tree see
# the intended fixture.
run_case_in() {
  local dir="$1" desc="$2" script="$3" expected="$4" payload="$5"
  local actual
  ( cd "$dir" && printf '%s' "$payload" | bash "$script" >/dev/null 2>&1 )
  actual=$?
  if [ "$actual" -eq "$expected" ]; then
    printf '  PASS  [exit %s] %s\n' "$actual" "$desc"
    pass=$((pass + 1))
  else
    printf '  FAIL  [exit %s, expected %s] %s\n' "$actual" "$expected" "$desc"
    fail=$((fail + 1))
  fi
}

# --- Fixtures: a WooCommerce project dir and a plain-website project dir. ---
TMPROOT="$(mktemp -d "${TMPDIR:-/tmp}/loamkit-guard-test.XXXXXX")"
trap 'rm -rf "$TMPROOT"' EXIT

WOO_DIR="$TMPROOT/woo-project"
mkdir -p "$WOO_DIR"
printf '%s\n' '{"flags":{"WOO":true,"DOCKER":true}}' > "$WOO_DIR/resolved-config.json"

WEB_DIR="$TMPROOT/web-project"
mkdir -p "$WEB_DIR"
printf '%s\n' '{"flags":{"WOO":false,"DOCKER":true}}' > "$WEB_DIR/resolved-config.json"

# A git repo containing a .env and a db.sql, to exercise the bulk-git real check.
GIT_DIRTY="$TMPROOT/git-dirty"
mkdir -p "$GIT_DIRTY"
(
  cd "$GIT_DIRTY"
  git init -q
  git config user.email t@t.t
  git config user.name t
  printf 'SECRET=1\n' > .env
  printf 'INSERT INTO x VALUES (1);\n' > db.sql
  printf '# readme\n' > README.md
) >/dev/null 2>&1

# A clean-ish git repo with only safe files staged/untracked.
GIT_CLEAN="$TMPROOT/git-clean"
mkdir -p "$GIT_CLEAN"
(
  cd "$GIT_CLEAN"
  git init -q
  git config user.email t@t.t
  git config user.name t
  printf '# readme\n' > README.md
) >/dev/null 2>&1

echo "== guard-two-lane.sh =="

# --- BLOCKED (exit 2): two-lane violations ---
run_case "Bash: wp db push -> BLOCKED" "$TWO_LANE" 2 \
  '{"tool_name":"Bash","tool_input":{"command":"wp db push staging"}}'

run_case "Bash: ddev db-push -> BLOCKED" "$TWO_LANE" 2 \
  '{"tool_name":"Bash","tool_input":{"command":"ddev db-push"}}'

run_case "Bash: wp db import to production -> BLOCKED" "$TWO_LANE" 2 \
  '{"tool_name":"Bash","tool_input":{"command":"wp db import production-dump.sql"}}'

run_case "Bash: git add dump.sql -> BLOCKED" "$TWO_LANE" 2 \
  '{"tool_name":"Bash","tool_input":{"command":"git add backups/dump.sql"}}'

run_case "Bash: git commit .env -> BLOCKED" "$TWO_LANE" 2 \
  '{"tool_name":"Bash","tool_input":{"command":"git commit -m secrets .env"}}'

# --- BLOCKED (exit 2): exfiltration / DB-up boundary (#2) ---
run_case "Bash: wp db export | ssh prod wp db import -> BLOCKED" "$TWO_LANE" 2 \
  '{"tool_name":"Bash","tool_input":{"command":"wp db export - | ssh prod \"wp db import -\""}}'

run_case "Bash: mysqldump | mysql -h prod -> BLOCKED" "$TWO_LANE" 2 \
  '{"tool_name":"Bash","tool_input":{"command":"mysqldump wpdb | mysql -h prod.example.com wpremote"}}'

run_case "Bash: scp local.sql prod -> BLOCKED" "$TWO_LANE" 2 \
  '{"tool_name":"Bash","tool_input":{"command":"scp local.sql prod:/tmp/x.sql"}}'

run_case "Bash: rsync dump.sql user@prod -> BLOCKED" "$TWO_LANE" 2 \
  '{"tool_name":"Bash","tool_input":{"command":"rsync -avz dump.sql user@prod:/var/www/"}}'

run_case "Bash: wp db import (no prod word) -> BLOCKED" "$TWO_LANE" 2 \
  '{"tool_name":"Bash","tool_input":{"command":"wp db import anything.sql"}}'

# --- BLOCKED (exit 2): bulk git add real check (#3) ---
run_case_in "$GIT_DIRTY" "Bash: git add -A with .env+db.sql staged -> BLOCKED" "$TWO_LANE" 2 \
  '{"tool_name":"Bash","tool_input":{"command":"git add -A"}}'

run_case "Write: .env -> BLOCKED" "$TWO_LANE" 2 \
  '{"tool_name":"Write","tool_input":{"file_path":"/proj/.env","content":"SECRET=1"}}'

run_case "Write: bare .env (file_path=.env) -> BLOCKED" "$TWO_LANE" 2 \
  '{"tool_name":"Write","tool_input":{"file_path":".env","content":"SECRET=1"}}'

run_case "MultiEdit: .env -> BLOCKED" "$TWO_LANE" 2 \
  '{"tool_name":"MultiEdit","tool_input":{"file_path":"/proj/.env"}}'

run_case "Write: dump.sql -> BLOCKED" "$TWO_LANE" 2 \
  '{"tool_name":"Write","tool_input":{"file_path":"/proj/db/backup.sql","content":"INSERT"}}'

run_case "Edit: db-dumps dir -> BLOCKED" "$TWO_LANE" 2 \
  '{"tool_name":"Edit","tool_input":{"file_path":"/proj/db-dumps/x.txt"}}'

# --- ALLOWED (exit 0): benign ---
run_case "Bash: wp plugin list -> ALLOW" "$TWO_LANE" 0 \
  '{"tool_name":"Bash","tool_input":{"command":"wp plugin list"}}'

run_case "Bash: git commit code -> ALLOW" "$TWO_LANE" 0 \
  '{"tool_name":"Bash","tool_input":{"command":"git commit -m \"add feature\""}}'

run_case "Bash: git checkout -b feature/foo -> ALLOW" "$TWO_LANE" 0 \
  '{"tool_name":"Bash","tool_input":{"command":"git checkout -b feature/foo"}}'

run_case "Bash: git add README.md -> ALLOW" "$TWO_LANE" 0 \
  '{"tool_name":"Bash","tool_input":{"command":"git add README.md"}}'

run_case_in "$GIT_CLEAN" "Bash: git add -A (no dumps/secrets) -> ALLOW" "$TWO_LANE" 0 \
  '{"tool_name":"Bash","tool_input":{"command":"git add -A"}}'

run_case "Bash: wp db export local-backup.sql (no transport) -> ALLOW" "$TWO_LANE" 0 \
  '{"tool_name":"Bash","tool_input":{"command":"wp db export local-backup.sql"}}'

run_case "Bash: wp db export (DOWN) -> ALLOW" "$TWO_LANE" 0 \
  '{"tool_name":"Bash","tool_input":{"command":"ddev export-db --file=local.sql.gz"}}'

run_case "Write: php file -> ALLOW" "$TWO_LANE" 0 \
  '{"tool_name":"Write","tool_input":{"file_path":"/proj/web/app/themes/x/functions.php","content":"<?php"}}'

run_case "Read: anything -> ALLOW (untracked tool)" "$TWO_LANE" 0 \
  '{"tool_name":"Read","tool_input":{"file_path":"/proj/.env"}}'

# --- FAIL-CLOSED (non-zero, not 2): malformed ---
run_case "malformed JSON -> fail-closed (exit 1)" "$TWO_LANE" 1 \
  'this is not json'

run_case "Bash without command -> fail-closed (exit 1)" "$TWO_LANE" 1 \
  '{"tool_name":"Bash","tool_input":{}}'

run_case "empty payload -> fail-closed (exit 1)" "$TWO_LANE" 1 \
  ''

echo
echo "== guard-woo-data.sh (WOO project) =="

# --- BLOCKED (exit 2): order/payment DATA EXFILTRATION & human-gate files ---
# These run inside WOO_DIR (resolved-config flags.WOO=true).
run_case_in "$WOO_DIR" "Bash: export wc_orders -> BLOCKED" "$WOO" 2 \
  '{"tool_name":"Bash","tool_input":{"command":"wp db query \"SELECT * FROM wc_orders\""}}'

run_case_in "$WOO_DIR" "Bash: dump wp_woocommerce_order_items -> BLOCKED" "$WOO" 2 \
  '{"tool_name":"Bash","tool_input":{"command":"mysqldump db wp_woocommerce_order_items"}}'

run_case_in "$WOO_DIR" "Bash: git add orders.csv -> BLOCKED" "$WOO" 2 \
  '{"tool_name":"Bash","tool_input":{"command":"git add export/orders.csv"}}'

run_case_in "$WOO_DIR" "Bash: commit orders-export.csv -> BLOCKED" "$WOO" 2 \
  '{"tool_name":"Bash","tool_input":{"command":"git add orders-export.csv"}}'

run_case_in "$WOO_DIR" "Write: payment gateway file -> BLOCKED (human gate)" "$WOO" 2 \
  '{"tool_name":"Write","tool_input":{"file_path":"/proj/includes/gateways/my-gateway.php","content":"<?php"}}'

run_case_in "$WOO_DIR" "Edit: checkout template -> BLOCKED (human gate)" "$WOO" 2 \
  '{"tool_name":"Edit","tool_input":{"file_path":"/proj/themes/x/woocommerce/checkout/form-checkout.php"}}'

run_case_in "$WOO_DIR" "Edit: cart-totals.php -> BLOCKED (human gate)" "$WOO" 2 \
  '{"tool_name":"Edit","tool_input":{"file_path":"/proj/themes/x/woocommerce/cart/cart-totals.php"}}'

# --- ALLOWED (exit 0): legitimate dev in a WOO project ---
run_case_in "$WOO_DIR" "Bash: wp plugin list -> ALLOW" "$WOO" 0 \
  '{"tool_name":"Bash","tool_input":{"command":"wp plugin list"}}'

run_case_in "$WOO_DIR" "Write: PHP calling wc_get_orders() (CRUD dev) -> ALLOW" "$WOO" 0 \
  '{"tool_name":"Write","tool_input":{"file_path":"/proj/inc/report.php","content":"<?php $o = wc_get_orders();"}}'

run_case_in "$WOO_DIR" "Write: product archive template -> ALLOW" "$WOO" 0 \
  '{"tool_name":"Write","tool_input":{"file_path":"/proj/themes/x/woocommerce/archive-product.php","content":"<?php"}}'

run_case_in "$WOO_DIR" "Bash: git checkout -b feature/foo -> ALLOW (not a file)" "$WOO" 0 \
  '{"tool_name":"Bash","tool_input":{"command":"git checkout -b feature/foo"}}'

run_case_in "$WOO_DIR" "Edit: e2e checkout.spec.ts -> ALLOW (test, not woo file)" "$WOO" 0 \
  '{"tool_name":"Edit","tool_input":{"file_path":"/proj/tests/e2e/checkout.spec.ts"}}'

run_case_in "$WOO_DIR" "Bash: wp db export local-backup.sql (local backup) -> ALLOW" "$WOO" 0 \
  '{"tool_name":"Bash","tool_input":{"command":"wp db export local-backup.sql"}}'

run_case_in "$WOO_DIR" "Read: order file -> ALLOW (untracked tool)" "$WOO" 0 \
  '{"tool_name":"Read","tool_input":{"file_path":"/proj/orders.csv"}}'

echo
echo "== guard-woo-data.sh (non-WOO website) =="

# --- ALLOWED (exit 0): order blocks must NOT apply to a plain website ---
run_case_in "$WEB_DIR" "Bash: git checkout -b feature/foo -> ALLOW" "$WOO" 0 \
  '{"tool_name":"Bash","tool_input":{"command":"git checkout -b feature/foo"}}'

run_case_in "$WEB_DIR" "Edit: a file named checkout.php (non-woo) -> ALLOW" "$WOO" 0 \
  '{"tool_name":"Edit","tool_input":{"file_path":"/proj/src/checkout.php"}}'

run_case_in "$WEB_DIR" "Bash: wp db export full.sql -> ALLOW" "$WOO" 0 \
  '{"tool_name":"Bash","tool_input":{"command":"wp db export full.sql"}}'

# No resolved-config.json at all => not WOO => order blocks inactive.
run_case "Edit: checkout template, no config -> ALLOW (not WOO)" "$WOO" 0 \
  '{"tool_name":"Edit","tool_input":{"file_path":"/proj/themes/x/woocommerce/checkout/form-checkout.php"}}'

echo
echo "== guard-woo-data.sh (fail-closed) =="

# --- FAIL-CLOSED ---
run_case "malformed JSON -> fail-closed (exit 1)" "$WOO" 1 \
  'nope'

run_case "Bash without command/path -> fail-closed (exit 1)" "$WOO" 1 \
  '{"tool_name":"Bash","tool_input":{}}'

echo
echo "------------------------------------"
printf 'Total: %d passed, %d failed\n' "$pass" "$fail"
if [ "$fail" -gt 0 ]; then
  exit 1
fi
exit 0
