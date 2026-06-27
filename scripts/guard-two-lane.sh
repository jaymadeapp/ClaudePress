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
# Use `jq -r` (NOT -e): -e exits 4 on a null/absent result, which would short-
# circuit before our explicit empty-string check. We rely on a single -z check
# and treat an actual parse failure of the whole payload as fail-closed.
tool="$(printf '%s' "$payload" | jq -r '.tool_name // empty')"
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
    # Use `jq -r` (NOT -e) and rely on the explicit -z check below; a parse
    # failure of the whole payload was already caught at .tool_name extraction.
    cmd="$(printf '%s' "$payload" | jq -r '.tool_input.command // empty')"
    jq_rc=$?
    if [ "$jq_rc" -ne 0 ]; then
      echo "two-lane: malformed Bash payload (.tool_input.command) — fail-closed" >&2
      exit 1
    fi
    if [ -z "$cmd" ]; then
      echo "two-lane: Bash call without a command (fail-closed)" >&2
      exit 1
    fi

    # --- 1) Legacy DB-push keywords (kept for back-compat). ---
    #   - DB push upstream:                db push / db-push / db_push
    #   - staging/committing .sql dumps:    git add/commit ... *.sql (literal)
    #   - staging/committing .env secrets:  git add/commit ... .env  (literal)
    if printf '%s' "$cmd" | grep -Eiq \
      '(db[ _-]?push|(git[[:space:]]+(add|commit).*(\.sql|\.env)))'
    then
      echo "two-lane: BLOCKED — DB must go DOWN only, never up; never commit DB dumps or .env." >&2
      echo "two-lane: offending command: $cmd" >&2
      exit 2
    fi

    # --- 2) DB import into ANY remote: any `wp db import` is upstream-capable. ---
    # (Previously only blocked when the word "prod"/"production" appeared, which
    #  missed `wp db import dump.sql` aimed at a remote alias.)
    if printf '%s' "$cmd" | grep -Eiq 'wp[[:space:]]+db[[:space:]]+import'
    then
      echo "two-lane: BLOCKED — 'wp db import' can push the DB upstream; DB goes DOWN only." >&2
      echo "two-lane: offending command: $cmd" >&2
      exit 2
    fi

    # --- 3) Exfiltration: an OUTBOUND TRANSPORT co-occurring with a DB SOURCE. ---
    # e.g.  wp db export - | ssh prod "wp db import -"
    #       scp local.sql prod:/tmp/x.sql
    #       rsync -avz dump.sql user@prod:/var/www/
    transport='\b(ssh|scp|rsync|sftp|nc|ncat|curl|wget)\b'
    dbsource='(\b(db[ _-]?(export|dump)|mysqldump)\b|\.sql(\.gz)?\b)'
    if printf '%s' "$cmd" | grep -Eiq "$transport" \
       && printf '%s' "$cmd" | grep -Eiq "$dbsource"
    then
      echo "two-lane: BLOCKED — outbound transport + DB dump/export looks like a DB exfiltration/push." >&2
      echo "two-lane: offending command: $cmd" >&2
      exit 2
    fi

    # --- 4) mysqldump piped into a remote mysql (host flag). ---
    # e.g.  mysqldump wpdb | mysql -h prod.example.com wpremote
    if printf '%s' "$cmd" | grep -Eiq 'mysqldump\b' \
       && printf '%s' "$cmd" | grep -Eiq 'mysql\b.*(-h|--host)'
    then
      echo "two-lane: BLOCKED — mysqldump piped into a remote mysql host pushes the DB upstream." >&2
      echo "two-lane: offending command: $cmd" >&2
      exit 2
    fi

    # --- 5) Bulk `git add`/`git commit` that could sweep in untracked dumps/secrets. ---
    # The literal-token check above misses `git add -A`, `git commit -am`, a bare
    # `.`, or `*` selector. When such a bulk selector is present, run a REAL check
    # against the working tree instead of trusting the command string.
    if printf '%s' "$cmd" | grep -Eiq 'git[[:space:]]+(add|commit)' \
       && printf '%s' "$cmd" | grep -Eiq '(^|[[:space:]])(-A|--all|-a|-[a-z]*a[a-z]*m|\.|\*)([[:space:]]|$)'
    then
      # Only meaningful inside a git work tree with git available; otherwise skip
      # this sub-check gracefully (the literal-token check still applies above).
      if command -v git >/dev/null 2>&1 \
         && git rev-parse --is-inside-work-tree >/dev/null 2>&1; then
        if git status --porcelain --untracked-files=all 2>/dev/null \
             | sed 's/^...//' \
             | grep -Eiq '\.(sql|sql\.gz|dump)$|(^|/)\.env(\.|$)'
        then
          echo "two-lane: BLOCKED — a bulk 'git add/commit' would stage a DB dump or .env secret." >&2
          echo "two-lane: offending command: $cmd" >&2
          exit 2
        fi
      fi
    fi
    ;;

  Write|Edit|MultiEdit|NotebookEdit)
    # For write-like tools, the target path is mandatory. Absence => fail closed.
    # `jq -r` (NOT -e): rely on the explicit -z check below.
    path="$(printf '%s' "$payload" | jq -r '.tool_input.file_path // empty')"
    jq_rc=$?
    if [ "$jq_rc" -ne 0 ]; then
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
