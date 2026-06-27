#!/usr/bin/env bash
#
# guard-two-lane.sh — ClaudePress PreToolUse guard (TWO-LANE invariant)
#
# Enforces the unbreakable two-lane rule:
#   CODE goes UP   (git/deploy push code only)
#   CONTENT/DB goes DOWN (pull DB from production to local only)
# Deploy NEVER pushes the database upstream; DB dumps and .env are never committed.
#
# I/O CONTRACT (spec §6.2):
#   - Receives the tool-call JSON payload on STDIN.
#   - For tool_name == "Bash"        -> inspects .tool_input.command
#   - For tool_name == "Write|Edit"  -> inspects .tool_input.file_path
#   - On a blocked match: writes the reason to STDERR and exits 2 (BLOCK).
#   - On ANY parse error / missing field / unreadable input: exits non-zero
#     (TRUE fail-closed — block rather than let an unparseable call through).
#   - Otherwise exits 0 (ALLOW).
#
# NOTE: This guard deliberately does NOT use `set -e`. We need explicit,
# fail-closed control over every exit path; a `grep` returning 1 (no match)
# is the normal "allow" path and must not abort the script. We DO guard the
# critical parse steps explicitly and exit non-zero on their failure.

set -uo pipefail

# --- Fail closed if jq is unavailable: we cannot safely parse the payload. ---
if ! command -v jq >/dev/null 2>&1; then
  echo "two-lane: jq is required to parse the tool payload (fail-closed)" >&2
  exit 1
fi

# --- Read the entire STDIN payload. ---
payload="$(cat)" || {
  echo "two-lane: could not read tool payload from STDIN (fail-closed)" >&2
  exit 1
}

# Empty payload => we cannot evaluate the call => fail closed.
if [ -z "${payload//[[:space:]]/}" ]; then
  echo "two-lane: empty tool payload (fail-closed)" >&2
  exit 1
fi

# --- Extract tool_name. A jq failure here means malformed JSON => fail closed. ---
tool="$(printf '%s' "$payload" | jq -er '.tool_name // empty')"
jq_rc=$?
if [ "$jq_rc" -ne 0 ]; then
  echo "two-lane: malformed tool payload (could not parse .tool_name) — fail-closed" >&2
  exit 1
fi
if [ -z "$tool" ]; then
  echo "two-lane: missing .tool_name in payload (fail-closed)" >&2
  exit 1
fi

case "$tool" in
  Bash)
    # For Bash, the command string is mandatory. Absence => fail closed.
    cmd="$(printf '%s' "$payload" | jq -er '.tool_input.command // empty')"
    if [ $? -ne 0 ]; then
      echo "two-lane: malformed Bash payload (.tool_input.command) — fail-closed" >&2
      exit 1
    fi
    if [ -z "$cmd" ]; then
      echo "two-lane: Bash call without a command (fail-closed)" >&2
      exit 1
    fi

    # BLOCK patterns (case-insensitive):
    #   - DB push upstream:                db push / db-push / db_push
    #   - import DB into production:        wp db import ... prod/production
    #   - staging/committing .sql dumps:    git add/commit ... *.sql
    #   - staging/committing .env secrets:  git add/commit ... .env
    if printf '%s' "$cmd" | grep -Eiq \
      '(db[ _-]?push|wp[[:space:]]+db[[:space:]]+import.*(prod|production)|(git[[:space:]]+(add|commit).*(\.sql|\.env)))'
    then
      echo "two-lane: BLOCKED — DB must go DOWN only, never up; never commit DB dumps or .env." >&2
      echo "two-lane: offending command: $cmd" >&2
      exit 2
    fi
    ;;

  Write|Edit|MultiEdit|NotebookEdit)
    # For write-like tools, the target path is mandatory. Absence => fail closed.
    path="$(printf '%s' "$payload" | jq -er '.tool_input.file_path // empty')"
    if [ $? -ne 0 ]; then
      echo "two-lane: malformed Write/Edit payload (.tool_input.file_path) — fail-closed" >&2
      exit 1
    fi
    if [ -z "$path" ]; then
      echo "two-lane: write/edit call without a file_path (fail-closed)" >&2
      exit 1
    fi

    # BLOCK writing secrets or DB dumps:
    #   - any .env file (.env, .env.local, ...)
    #   - any *.sql file
    #   - anything inside a db-dump(s)/ directory
    if printf '%s' "$path" | grep -Eiq '(/\.env([.][^/]*)?$|^\.env([.][^/]*)?$|\.sql$|/db[-_]?dumps?/)'
    then
      echo "two-lane: BLOCKED — refusing to write .env / DB dump ($path)." >&2
      exit 2
    fi
    ;;

  *)
    # Tool we don't gate (Read, Grep, etc.) — allow.
    :
    ;;
esac

exit 0
