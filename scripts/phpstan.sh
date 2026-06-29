#!/usr/bin/env bash
#
# phpstan.sh — Loamkit Stop hook (full PHPStan gate)
#
# Wired on the Stop event (spec §6.2): runs ONCE at the end of a task with full
# autoload context, instead of after every keystroke (which would produce false
# positives on a single file). This is the static-analysis quality gate.
#
# Behaviour:
#   - If PHPStan is installed (vendor/bin/phpstan) AND a phpstan.neon config
#     exists, run `phpstan analyse --no-progress --error-format=raw`.
#       * errors found      -> exit non-zero (gate fails)
#       * clean             -> exit 0
#   - If PHPStan is NOT set up yet (fresh project), print an informational note
#     and exit 0 — do not block a project that hasn't installed the tool.
#
# This hook reads STDIN (the Stop payload) but does not need any field from it;
# we drain it so the writer never blocks on a full pipe.

set -uo pipefail

note() { printf 'phpstan: %s\n' "$*" >&2; }

# Drain STDIN if present (Stop payload) — ignore contents.
if [ ! -t 0 ]; then
  cat >/dev/null 2>&1 || true
fi

# --- Locate the PHPStan binary (project-local preferred, then PATH). ---
phpstan_bin=""
if [ -x "./vendor/bin/phpstan" ]; then
  phpstan_bin="./vendor/bin/phpstan"
elif command -v phpstan >/dev/null 2>&1; then
  phpstan_bin="$(command -v phpstan)"
fi

# --- Locate a phpstan config. ---
phpstan_config=""
if [ -f "./phpstan.neon" ]; then
  phpstan_config="./phpstan.neon"
elif [ -f "./phpstan.neon.dist" ]; then
  phpstan_config="./phpstan.neon.dist"
fi

# Fresh project: tool not set up yet -> informational, do not block.
if [ -z "$phpstan_bin" ]; then
  note "PHPStan not installed (no vendor/bin/phpstan) — skipping static-analysis gate."
  note "Install with: composer require --dev phpstan/phpstan szepeviktor/phpstan-wordpress"
  exit 0
fi
if [ -z "$phpstan_config" ]; then
  note "PHPStan installed but no phpstan.neon found — skipping (configure phpstan.neon to enable the gate)."
  exit 0
fi

note "running static analysis ($phpstan_bin, config: $phpstan_config) ..."

# Run the analysis. Non-zero exit from phpstan == reported errors == gate fails.
if ! analyse_out="$("$phpstan_bin" analyse --no-progress --error-format=raw --configuration="$phpstan_config" 2>&1)"; then
  note "static analysis reported errors:"
  printf '%s\n' "$analyse_out" >&2
  exit 1
fi

# Surface any informational output even on success (usually empty with raw format).
if [ -n "${analyse_out//[[:space:]]/}" ]; then
  printf '%s\n' "$analyse_out" >&2
fi

note "static analysis clean."
exit 0
