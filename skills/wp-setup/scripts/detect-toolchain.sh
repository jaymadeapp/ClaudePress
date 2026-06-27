#!/usr/bin/env bash
#
# detect-toolchain.sh — ClaudePress skill Step 0 (toolchain detection)
#
# Prints detected versions of the tools the installer cares about. One line per
# tool: "<name>: <version>" or "<name>: MISSING". Plain, fast, read-only — no
# side effects, no network. Consumed by SKILL.md to set recommended options and
# warn on missing tools.
#
# This script never fails the skill load: even if every tool is missing it exits
# 0 and simply reports MISSING. (Detection must not block; the skill decides what
# to do with the result.)

set -uo pipefail

# report <label> <binary> <version-args...>
#   Prints "<label>: <first line of version output>" or "<label>: MISSING".
report() {
  local label="$1" bin="$2"
  shift 2
  if command -v "$bin" >/dev/null 2>&1; then
    local out
    # Capture version output; take the first non-empty line, trim noise.
    if out="$("$bin" "$@" 2>/dev/null | head -n 1)"; then
      out="${out#"${out%%[![:space:]]*}"}"   # ltrim
      out="${out%"${out##*[![:space:]]}"}"    # rtrim
      if [ -n "$out" ]; then
        printf '%s: %s\n' "$label" "$out"
      else
        # Binary exists but produced no version string.
        printf '%s: present (version unknown)\n' "$label"
      fi
    else
      printf '%s: present (version unknown)\n' "$label"
    fi
  else
    printf '%s: MISSING\n' "$label"
  fi
}

echo "ClaudePress toolchain detection"
echo "-------------------------------"

report "php"      php      --version
report "composer" composer --version
report "ddev"     ddev     --version
report "docker"   docker   --version
report "node"     node     --version
report "npm"      npm      --version
report "wp"       wp       --version --allow-root

echo "-------------------------------"
echo "Note: 'MISSING' tools are unavailable on this host. Docker builds require docker + ddev;"
echo "WooCommerce requires a local MySQL/MariaDB (via DDEV or natively)."

exit 0
