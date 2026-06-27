# Deploy reference — host-agnostic staging

ClaudePress is a distributable kit, so deploy is deliberately **not** tied to
any one host. The universal model is simple:

> **A deploy is a `git push` to a branch your host watches.**

The host (Coolify, a VPS, Forge/Ploi, GitHub Actions) watches a branch, and on
push it builds and releases. ClaudePress only pushes the branch and, optionally,
pokes a deploy webhook. **ClaudePress does NOT require Coolify** — Coolify is
the recommended preset, not a dependency.

## The two-lane rule still holds

Deploy ships **CODE only** — themes, plugins, mu-plugins, config. The
**database, content and (for e-shops) orders/payments are NEVER deployed**. See
`two-lane.md`. There is no "sync DB to prod" step. To refresh real data, you go
the **other way**: pull prod → dev (anonymized for e-shops). Never push the DB
up.

## Branch strategy

| Branch    | Target         | Friction                                            |
|-----------|----------------|-----------------------------------------------------|
| `staging` | staging site   | Low-friction. Can auto-deploy on every push.        |
| `main`    | production     | **Human-gated.** Out of scope for the staging skill.|

The `deploy-staging` skill only ever touches the `staging` branch. Production
deploys stay manual / human-gated / denied — the helper refuses protected
branch names (`main`, `master`, `production`, `prod`, `release`) and never
force-pushes.

## Coolify preset (recommended)

1. **Create the app** in Coolify and point it at this repo.
2. **Set the branch** to `staging`.
3. **Enable auto-deploy on push** so a push to `staging` releases automatically.
4. **Set a post-deployment command** for the staging build, e.g.:

   ```sh
   composer install && npm ci && npm run build && wp acorn optimize && wp claudepress seed && wp cache flush
   ```

   - `composer install` / `npm ci && npm run build` — install PHP/JS deps and
     compile theme assets (Sage 11).
   - `wp acorn optimize` — optimize the Acorn/Sage container.
   - `wp claudepress seed` — runs the ClaudePress content seeder. **Dev/staging
     ONLY — never run the seeder on production.** It populates demo content; it
     must never touch real prod data (two-lane).
   - `wp cache flush` — clear caches after the release.

5. Options:
   - **Deploy webhook** — Coolify exposes a deploy webhook URL. Put it in
     `CP_STAGING_WEBHOOK` (env) so `deploy-staging.sh` pokes it after pushing.
     Keep the token in env, not committed.
   - **Preview deployments** — Coolify can spin up per-PR/per-branch previews;
     useful for reviewing changes before they reach the shared staging site.

## Bring your own host

The exact same git-push model works without Coolify:

- **Self-hosted VPS** — a **bare git hook** (`post-receive` that checks out and
  runs the build), or **Deployer** / **Trellis** triggered on push. You push to
  `staging`; the hook/tool builds and releases.
- **Forge / Ploi** — connect the repo, set the branch to `staging`, paste an
  equivalent deploy script, and (optionally) use their deploy webhook in
  `CP_STAGING_WEBHOOK`.
- **GitHub Actions** — a workflow on push to `staging` that builds
  (`composer install && npm ci && npm run build`) then ships via `rsync`/SSH,
  `gh`, or a further `git push` to the server. Same model: branch in, build,
  release.

In every case ClaudePress's job is identical: push the branch (and optionally
fire a webhook); the host does the deploy.

## How the pieces fit together

- **`skills/deploy-staging/SKILL.md`** — the `/claudepress:deploy-staging` skill
  (never auto-invoked). It verifies the quality gates, shows the commit/diff and
  asks for a one-time confirmation, then runs the helper and reports the staging
  URL. It states explicitly that production is out of scope.
- **`scripts/deploy-staging.sh`** — the host-agnostic helper. Refuses a dirty
  work tree (never auto-commits) and protected branch names, pushes
  `HEAD:<staging_branch>` to the remote, optionally POSTs the webhook, and never
  force-pushes or touches main/prod.
- **`.claude/deploy.json`** — per-project config (copy from
  `templates/deploy.example.json`): `staging_branch`, `staging_remote`,
  `staging_webhook`, `staging_url`. Env vars `CP_STAGING_*` override the file;
  put secrets/webhook tokens in env, not in the committed file.

## Refreshing data goes the other way

To get real content into dev, **pull prod → dev** (anonymized for e-shops —
strip/scrub customer, order and payment data). **Never push the DB up** as part
of a deploy. Deploy moves code up; data only ever moves down.
