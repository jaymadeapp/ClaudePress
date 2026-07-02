---
name: deploy-staging
description: Deploy the current code to the staging environment via git, host-agnostic. Use when the user wants to ship to staging/preview.
disable-model-invocation: true
user-invocable: true
allowed-tools: >
  Read
  Bash(git status:*)
  Bash(git log:*)
  Bash(git push:*)
  Bash(composer *)
  Bash(npm run *)
  Bash(bash ${CLAUDE_PLUGIN_ROOT}/scripts/deploy-staging.sh*)
---

# Deploy to staging (Loamkit)

Ships the **current code** to the staging environment. Loamkit is
host-agnostic: a deploy is just a `git push` to a branch your host watches
(Coolify, a self-hosted VPS, Forge/Ploi, GitHub Actions — all the same model).
This skill pushes to the staging branch and optionally pokes a deploy webhook;
the **host** performs the actual build & release.

It is **never** auto-invoked (`disable-model-invocation: true`) — deploys are
always a deliberate, user-triggered action.

**TWO-LANE INVARIANT.** This deploy moves **CODE only**. The database, content
and (for e-shops) orders/payments are **never** deployed. See
`../wp-setup/reference/two-lane.md` and `../wp-setup/reference/deploy.md`.

**PRODUCTION IS OUT OF SCOPE.** This skill only ever ships to a staging branch.
Production deploys stay manual / human-gated / denied — never use this skill,
its script, or a webhook here to push to prod.

Follow these steps IN ORDER. Do not skip the gates.

---

## Step 1 — Verify the quality gates are green

A deploy must not ship broken code. Confirm the gates pass before pushing:

- **PHPCS**, **PHPStan** and **PHPUnit** must be green. In a Loamkit
  project these are already enforced by the plugin hooks (lint on
  `PostToolUse`, PHPStan on `Stop`) — if the hooks have been running clean you
  can note that; otherwise run the project's commands (e.g. `composer lint`,
  `composer stan`, `composer test`) and read the result.
- If **any** gate fails, **STOP** and refuse to deploy. Report the failure and
  let the user fix it first. Never deploy red.

---

## Step 2 — Show what will ship and confirm (lightweight human gate)

Staging is low-friction, but still confirmed once.

1. Show the commit that will ship and a summary of the diff:
   - `git log -1 --stat` (the commit + touched files), and/or
   - `git status` to confirm the work tree is clean (the helper refuses to run
     on a dirty tree — it never auto-commits, so commit first if needed).
2. Ask the user to confirm this commit should go to staging. Wait for a clear
   yes before continuing.

---

## Step 3 — Run the deploy helper

```bash
bash ${CLAUDE_PLUGIN_ROOT}/scripts/deploy-staging.sh
```

The helper reads config from env first, then optional `./.claude/deploy.json`
(`staging_branch`, `staging_remote`, `staging_webhook`, `staging_url`; see
`../wp-setup/templates/deploy.example.json`). It pushes `HEAD` to the staging
branch on the configured remote, optionally POSTs the deploy webhook, and never
force-pushes or touches main/prod. It refuses a dirty tree or a protected
branch name and fails closed.

---

## Step 4 — Report

Tell the user:
- which commit was pushed, to which remote/branch, and whether a webhook fired;
- the staging URL (if known) so they can preview;
- that the **host auto-deploys from the branch** (or that the webhook triggered
  it) — Loamkit pushed code; the host builds & releases.

---

## Step 5 — State the production boundary explicitly

Finish by stating plainly: **production is out of scope for this skill.** Prod
deploys stay manual / human-gated / denied. Do not push to a production branch,
do not point this at a prod webhook, and never use this flow to ship the
database — code only, staging only.
