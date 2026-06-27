# Docker workflow (DDEV + Bedrock) — reference

The Docker branch runs the project in DDEV with a Bedrock-structured WordPress.
It is the recommended path: isolated, reproducible, and the only way to get full
CI parity for the e-shop branch.

## Stack

- **DDEV** provisions the containers (web + database). Config is rendered from
  `templates/ddev/config.website.yaml` (website) or `config.woo.yaml` (e-shop)
  into `.ddev/config.yaml`.
  - Website: `mariadb 10.11`, `php 8.3`, `docroot: web`, `nginx-fpm`.
  - E-shop: `mysql 8.0` (HPOS engine parity), `php 8.3`, `docroot: web`,
    `WP_MEMORY_LIMIT=512M`.
- **Bedrock** gives the project layout: `web/` docroot, `web/app/` for
  themes/plugins/mu-plugins/uploads, `web/wp/` for WordPress core (never edited
  by hand), `config/` for environment config, `.env` for secrets (never
  committed).
- **Sage 11** theme under `web/app/themes/<slug>` (Acorn 6, Blade, Vite).

## Scaffold commands (run by scaffold.sh)

```
composer create-project roots/bedrock .
composer create-project roots/sage web/app/themes/<slug>
```

`scaffold.sh` deliberately does **not** run `ddev start` or `ddev composer
install` — those are printed as NEXT steps for you to run after scaffolding:

```
ddev start
ddev composer install
```

> Exact `roots/sage` / `roots/acorn` versions are resolved against Composer at
> build time (PHP >=8.3, Vite, Acorn 6). Do not pin guessed versions.

## Day-to-day commands

- Start / stop: `ddev start`, `ddev stop`.
- WP-CLI: `ddev wp <command>` (e.g. `ddev wp plugin list`).
- Composer: `ddev composer <command>`.
- Node/Vite (theme assets): `ddev npm run dev` / `ddev npm run build`, or run
  Vite on the host pointing at the DDEV URL.
- **Test sites from the host browser**, not from inside the container — the host
  reaches the DDEV URL (e.g. `https://<slug>.ddev.site`) directly.

## Database — DOWN only (two-lane)

- Pull production DB **down** to local: a `ddev pull <provider>`-style flow (or
  `ddev import-db` from a downloaded dump). This is the only allowed direction.
- **Never** push the local DB upstream. `ddev export-db` is for local
  backups/migrations between local environments only — it must never feed a
  deploy. `guard-two-lane.sh` blocks DB-up patterns regardless of tooling.
- For the e-shop: orders/customers/payment data pulled down are production data —
  never re-commit or re-deploy them.

## MCP

- The plugin-root `.mcp.json` ships with **only Playwright** active (browser
  automation for E2E; no filesystem writes outside artifacts). The WordPress MCP
  is **per-project**, wired from `templates/mcp/{website,woocommerce}.json`.
- **Local = STDIO via WP-CLI, fully automated.** The `wordpress` server runs the
  canonical `WordPress/mcp-adapter` plugin over **DDEV stdio**
  (`ddev wp mcp-adapter serve --server=mcp-adapter-default-server --user=claudepress-mcp`).
  It authenticates **as the WP user** `claudepress-mcp` — there is **no
  application password** and no secret in the file.
- **Zero manual steps.** `scripts/setup-mcp.sh` (run by `scaffold.sh` once WP is
  installed) auto-installs + activates `mcp-adapter`
  (`wp plugin install https://github.com/WordPress/mcp-adapter/releases/latest/download/mcp-adapter.zip --activate`,
  needs WP >=6.9 / Abilities API, PHP >=7.4), creates the content-only role
  `claudepress_mcp` and the least-privilege user `claudepress-mcp`. For the
  e-shop, that role **excludes order/payment capabilities** — the MCP client acts
  as that user, so its role is the security boundary.
- **Remote/production fallback (optional, remote only).** For a remote site you
  cannot reach over WP-CLI stdio, use the HTTP proxy `@automattic/mcp-wordpress-remote`
  with `WP_API_URL` / `WP_API_USERNAME` / `WP_API_PASSWORD`, where the password is
  an Application Password created with
  `wp user application-password create <user> <name> --porcelain` and read from
  `WP_MCP_APP_PASSWORD` in your env (never committed). The autonomous agent works
  against LOCAL only — never prod.
