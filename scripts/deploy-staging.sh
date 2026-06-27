#!/usr/bin/env bash
#
# deploy-staging.sh — host-agnostic "deploy to staging" helper for ClaudePress.
#
# The universal model: a deploy is just a `git push` to a branch your host
# watches. That works the same way for Coolify (recommended preset), a
# self-hosted VPS (bare git hook / Deployer / Trellis), Forge/Ploi, or a
# GitHub Actions pipeline — ClaudePress does NOT require any specific host.
# This script pushes the CURRENT commit to a staging branch and, optionally,
# pokes a deploy webhook; the HOST does the actual build & release.
#
# TWO-LANE INVARIANT: deploy moves CODE only. The database, content and (for
# e-shops) orders/payments are NEVER deployed. To refresh real data, pull
# prod -> dev (anonymized for e-shops); never push the DB up.
#
# PRODUCTION IS OUT OF SCOPE here. This helper only ever touches a staging
# branch; prod stays human-gated/denied.
#
set -euo pipefail

# ---------------------------------------------------------------------------
# Config — env first, then optional ./.claude/deploy.json (via jq) if present.
# Sane defaults so the script works with zero config on a conventional setup.
# ---------------------------------------------------------------------------
CP_STAGING_BRANCH="${CP_STAGING_BRANCH:-}"
CP_STAGING_REMOTE="${CP_STAGING_REMOTE:-}"
CP_STAGING_WEBHOOK="${CP_STAGING_WEBHOOK:-}"
CP_STAGING_URL="${CP_STAGING_URL:-}"

DEPLOY_JSON="./.claude/deploy.json"

# Fill any value still empty from .claude/deploy.json, if both the file and jq
# are available. Env always wins; the file only supplies what env did not set.
if [[ -f "$DEPLOY_JSON" ]]; then
  if command -v jq >/dev/null 2>&1; then
    # jq prints an empty string for missing/null keys, which we treat as "unset".
    json_get() { jq -r --arg k "$1" '.[$k] // empty' "$DEPLOY_JSON" 2>/dev/null || true; }
    [[ -z "$CP_STAGING_BRANCH"  ]] && CP_STAGING_BRANCH="$(json_get staging_branch)"
    [[ -z "$CP_STAGING_REMOTE"  ]] && CP_STAGING_REMOTE="$(json_get staging_remote)"
    [[ -z "$CP_STAGING_WEBHOOK" ]] && CP_STAGING_WEBHOOK="$(json_get staging_webhook)"
    [[ -z "$CP_STAGING_URL"     ]] && CP_STAGING_URL="$(json_get staging_url)"
  else
    echo "note: $DEPLOY_JSON exists but 'jq' is not installed — reading env only." >&2
  fi
fi

# Apply defaults last, after env + file have had their say.
CP_STAGING_BRANCH="${CP_STAGING_BRANCH:-staging}"
CP_STAGING_REMOTE="${CP_STAGING_REMOTE:-origin}"

# ---------------------------------------------------------------------------
# Safety checks (fail-closed — when in doubt, refuse).
# ---------------------------------------------------------------------------

# Must be inside a git work tree.
if ! git rev-parse --is-inside-work-tree >/dev/null 2>&1; then
  echo "error: not inside a git repository — run this from your project root." >&2
  exit 1
fi

# Refuse to deploy a dirty work tree. We never auto-commit: the user must
# decide what ships. A clean tree means HEAD is exactly what reaches staging.
if ! git diff --quiet || ! git diff --cached --quiet; then
  echo "error: working tree has uncommitted changes." >&2
  echo "       Commit (or stash) your changes first, then re-run — this helper" >&2
  echo "       never auto-commits, so HEAD is exactly what gets deployed." >&2
  exit 1
fi

# Reject a structurally unsafe branch value outright. A staging branch is a
# plain branch name: no slash (would let `heads/master` / a full refspec slip
# past the protected-name check), no whitespace (a trailing space dodges an
# exact-literal match), and no leading '-' (would be parsed as a git option).
case "$CP_STAGING_BRANCH" in
  *[!a-zA-Z0-9._-]* | */* | -* | "")
    echo "error: CP_STAGING_BRANCH '$CP_STAGING_BRANCH' is not a plain branch name." >&2
    echo "       It must contain no slash, no whitespace and no leading '-'." >&2
    echo "       Use a simple staging branch name (e.g. 'staging')." >&2
    exit 1
    ;;
esac

# Normalize before matching protected names so alternate spellings can't slip
# through the exact-literal case: strip any leading 'refs/heads/', trim
# surrounding whitespace, and lowercase. (The structural check above already
# rejected slashes/whitespace, so this is belt-and-suspenders.)
branch_check="$(printf '%s' "$CP_STAGING_BRANCH" \
  | sed -E 's#^refs/heads/##; s/^[[:space:]]+//; s/[[:space:]]+$//' \
  | tr '[:upper:]' '[:lower:]')"

# Refuse if the target branch is a protected production branch name. Staging
# must be its own branch; this command must never touch main/prod.
case "$branch_check" in
  main | master | production | prod | release)
    echo "error: CP_STAGING_BRANCH resolves to a protected branch '$CP_STAGING_BRANCH'." >&2
    echo "       Staging must be its own branch (e.g. 'staging'). Production deploys" >&2
    echo "       are out of scope for this command — they stay manual/human-gated." >&2
    exit 1
    ;;
esac

# Resolve the commit we are about to ship, for the summary and for confidence
# that there is actually something committed to deploy.
DEPLOY_COMMIT="$(git rev-parse HEAD)"
DEPLOY_COMMIT_SHORT="$(git rev-parse --short HEAD)"
DEPLOY_COMMIT_SUBJECT="$(git log -1 --pretty=%s)"

# ---------------------------------------------------------------------------
# Action — push the current commit to the staging branch.
# Never force-push. `HEAD:branch` updates only the staging branch; main/prod
# are untouched. A non-fast-forward push will be rejected by git, which is the
# behaviour we want (we do not override history).
# ---------------------------------------------------------------------------
echo "==> Deploying CODE to staging (database/content/orders are NOT deployed)"
echo "    commit : $DEPLOY_COMMIT_SHORT  $DEPLOY_COMMIT_SUBJECT"
echo "    remote : $CP_STAGING_REMOTE"
echo "    branch : $CP_STAGING_BRANCH"
echo

if ! git push "$CP_STAGING_REMOTE" "HEAD:$CP_STAGING_BRANCH"; then
  echo "error: push to staging rejected — likely non-fast-forward or auth; this" >&2
  echo "       helper never force-pushes, reconcile the staging branch and retry." >&2
  exit 1
fi

# ---------------------------------------------------------------------------
# Optional webhook — let the host kick off (or speed up) its deploy. If no
# webhook is configured, the host is expected to auto-deploy from the branch.
# ---------------------------------------------------------------------------
WEBHOOK_FIRED="no"
if [[ -n "$CP_STAGING_WEBHOOK" ]]; then
  echo
  echo "==> Triggering deploy webhook"
  if curl -fsS -X POST -H 'Content-Type: application/json' -d '{}' "$CP_STAGING_WEBHOOK" >/dev/null; then
    WEBHOOK_FIRED="yes"
  else
    # The push already succeeded; a webhook failure is non-fatal but worth
    # flagging so the user can trigger the deploy manually if needed.
    echo "warning: webhook POST failed — the branch was pushed, so trigger the" >&2
    echo "         host deploy manually if it does not auto-deploy on push." >&2
    WEBHOOK_FIRED="failed"
  fi
fi

# ---------------------------------------------------------------------------
# Summary.
# ---------------------------------------------------------------------------
echo
echo "------------------------------------------------------------------"
echo "Staging deploy summary"
echo "  pushed commit : $DEPLOY_COMMIT_SHORT ($DEPLOY_COMMIT)"
echo "  to            : $CP_STAGING_REMOTE/$CP_STAGING_BRANCH"
case "$WEBHOOK_FIRED" in
  yes)    echo "  webhook       : fired (host deploy triggered)";;
  failed) echo "  webhook       : FAILED — trigger the host deploy manually";;
  no)     echo "  webhook       : none configured — host should auto-deploy from the branch";;
esac
if [[ -n "$CP_STAGING_URL" ]]; then
  echo "  staging URL   : $CP_STAGING_URL"
else
  echo "  staging URL   : (unset — set CP_STAGING_URL / staging_url to show it here)"
fi
echo
echo "  Reminder: this deploy ships CODE only. The database, content and"
echo "  (for e-shops) orders/payments are NOT part of this deploy. To refresh"
echo "  real data, pull prod -> dev (anonymized for e-shops); never push DB up."
echo "  Production is out of scope for this command — prod stays human-gated."
echo "------------------------------------------------------------------"
