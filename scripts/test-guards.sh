#!/usr/bin/env bash
#
# test-guards.sh — self-test for the ClaudePress PreToolUse guards.
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

run_case "Write: .env -> BLOCKED" "$TWO_LANE" 2 \
  '{"tool_name":"Write","tool_input":{"file_path":"/proj/.env","content":"SECRET=1"}}'

run_case "Write: dump.sql -> BLOCKED" "$TWO_LANE" 2 \
  '{"tool_name":"Write","tool_input":{"file_path":"/proj/db/backup.sql","content":"INSERT"}}'

run_case "Edit: db-dumps dir -> BLOCKED" "$TWO_LANE" 2 \
  '{"tool_name":"Edit","tool_input":{"file_path":"/proj/db-dumps/x.txt"}}'

# --- ALLOWED (exit 0): benign ---
run_case "Bash: wp plugin list -> ALLOW" "$TWO_LANE" 0 \
  '{"tool_name":"Bash","tool_input":{"command":"wp plugin list"}}'

run_case "Bash: git commit code -> ALLOW" "$TWO_LANE" 0 \
  '{"tool_name":"Bash","tool_input":{"command":"git commit -m \"add feature\""}}'

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
echo "== guard-woo-data.sh =="

# --- BLOCKED (exit 2): woo data / human-gate ---
run_case "Bash: export wc_orders -> BLOCKED" "$WOO" 2 \
  '{"tool_name":"Bash","tool_input":{"command":"wp db query \"SELECT * FROM wc_orders\""}}'

run_case "Bash: dump wp_woocommerce_order_items -> BLOCKED" "$WOO" 2 \
  '{"tool_name":"Bash","tool_input":{"command":"mysqldump db wp_woocommerce_order_items"}}'

run_case "Bash: git add orders.csv -> BLOCKED" "$WOO" 2 \
  '{"tool_name":"Bash","tool_input":{"command":"git add export/orders.csv"}}'

run_case "Write: payment gateway file -> BLOCKED (human gate)" "$WOO" 2 \
  '{"tool_name":"Write","tool_input":{"file_path":"/proj/inc/payment-gateway.php","content":"<?php"}}'

run_case "Edit: checkout template -> BLOCKED (human gate)" "$WOO" 2 \
  '{"tool_name":"Edit","tool_input":{"file_path":"/proj/themes/x/woocommerce/checkout/form-checkout.php"}}'

# --- ALLOWED (exit 0): benign ---
run_case "Bash: wp plugin list -> ALLOW" "$WOO" 0 \
  '{"tool_name":"Bash","tool_input":{"command":"wp plugin list"}}'

run_case "Write: product archive template -> ALLOW" "$WOO" 0 \
  '{"tool_name":"Write","tool_input":{"file_path":"/proj/themes/x/woocommerce/archive-product.php","content":"<?php"}}'

run_case "Read: order file -> ALLOW (untracked tool)" "$WOO" 0 \
  '{"tool_name":"Read","tool_input":{"file_path":"/proj/orders.csv"}}'

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
