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
tool="$(printf '%s' "$payload" | jq -er '.tool_name // empty')"
if [ $? -ne 0 ]; then
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
# A jq parse failure (malformed JSON) => fail closed.
subject="$(printf '%s' "$payload" | jq -er '.tool_input.command // .tool_input.file_path // empty')"
if [ $? -ne 0 ]; then
  echo "woo-data: malformed tool_input (.command/.file_path) — fail-closed" >&2
  exit 1
fi
if [ -z "$subject" ]; then
  echo "woo-data: tool call without a command or file_path to inspect (fail-closed)" >&2
  exit 1
fi

# BLOCK patterns (case-insensitive). These cover:
#   - HPOS / legacy order tables:   wc_orders, wp_woocommerce_order(_items|meta)
#   - exported order data:          orders.csv / order.sql / orders.sql
#   - payment gateway code/config:  payment gateway / payment-gateway / payment_gateway
#   - checkout / cart-total touch points that demand a human gate
if printf '%s' "$subject" | grep -Eiq \
  '(wc_orders|wp_woocommerce_order|/orders?\.(csv|sql)|payment[s]?[ _-]?gateway|checkout|cart[ _-]?total)'
then
  echo "woo-data: BLOCKED — orders/payments are never deployed or committed;" >&2
  echo "          checkout/payment/cart-total changes need a HUMAN GATE + security sign-off." >&2
  echo "woo-data: offending subject: $subject" >&2
  exit 2
fi

exit 0
