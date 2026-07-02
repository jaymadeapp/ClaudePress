#!/usr/bin/env bash
#
# lint-php.sh — Loamkit PostToolUse hook (fast PHP lint on changed files)
#
# Wired on PostToolUse for Write|Edit (spec §6.2). Goal: catch broken PHP the
# moment it is written, while staying sub-second so it doesn't degrade the
# autonomous loop. PHPStan is NOT run here — it runs at the Stop gate.
#
# Behaviour:
#   - Reads the tool payload from STDIN, extracts .tool_input.file_path.
#   - Non-PHP file (or no path) -> exit 0 (skip gracefully).
#   - PHP file -> run `php -l` (syntax check). If it fails -> exit non-zero
#     (the edit is reported as a failure; this is the fail-closed signal).
#   - If `phpcs` is available, additionally run it on JUST that file and fail
#     on coding-standard violations. If `phpcs` is NOT installed, run `php -l`
#     only and print a note — do NOT hard-fail merely because phpcs is absent.
#
# Parse robustness: unlike the PreToolUse guards, a PostToolUse lint failing to
# parse should not wedge the loop on benign tool calls — but we still surface a
# clear note and skip rather than silently passing bad PHP. We only ever FAIL
# (non-zero) on a real `php -l` syntax error or a real phpcs violation.

set -uo pipefail

note() { printf 'lint-php: %s\n' "$*" >&2; }

# Without jq we cannot reliably extract the path; skip (this is a quality hook,
# not a security gate — the two-lane/woo guards are the security boundary).
if ! command -v jq >/dev/null 2>&1; then
  note "jq not found; skipping PHP lint"
  exit 0
fi

payload="$(cat)" || { note "could not read payload; skipping"; exit 0; }
if [ -z "${payload//[[:space:]]/}" ]; then
  exit 0
fi

file_path="$(printf '%s' "$payload" | jq -r '.tool_input.file_path // empty' 2>/dev/null)" || {
  note "could not parse payload; skipping"
  exit 0
}

# No path, or not a .php file -> nothing to lint.
case "$file_path" in
  *.php) : ;;
  "") exit 0 ;;
  *)  exit 0 ;;
esac

# The file may have been deleted/moved between the edit and this hook; if it's
# gone there is nothing to lint.
if [ ! -f "$file_path" ]; then
  note "file no longer present, skipping: $file_path"
  exit 0
fi

# `php` itself is required to lint PHP. If it's missing we cannot verify syntax;
# emit a clear note and skip (don't block edits on a machine without PHP).
if ! command -v php >/dev/null 2>&1; then
  note "php binary not found; cannot run 'php -l' (skipping)"
  exit 0
fi

status=0

# --- 1) php -l : hard syntax check (authoritative; failure must fail the hook). ---
if ! lint_out="$(php -l "$file_path" 2>&1)"; then
  note "PHP syntax error in $file_path:"
  printf '%s\n' "$lint_out" >&2
  status=1
fi

# --- 2) phpcs : coding standard (only if installed). ---
# Prefer a project-local vendor binary, fall back to one on PATH.
phpcs_bin=""
if [ -x "./vendor/bin/phpcs" ]; then
  phpcs_bin="./vendor/bin/phpcs"
elif command -v phpcs >/dev/null 2>&1; then
  phpcs_bin="$(command -v phpcs)"
fi

if [ -n "$phpcs_bin" ]; then
  # Run phpcs on just this one file. A non-zero phpcs exit means standards
  # violations -> fail the hook so the issue is surfaced immediately.
  if ! phpcs_out="$("$phpcs_bin" --report=full "$file_path" 2>&1)"; then
    note "PHPCS violations in $file_path:"
    printf '%s\n' "$phpcs_out" >&2
    status=1
  fi
else
  note "phpcs not installed — ran 'php -l' only (install squizlabs/php_codesniffer for full WPCS checks)"
fi

exit "$status"
