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

- `.mcp.json` ships with **only Playwright** active (browser automation for E2E;
  no filesystem writes outside artifacts).
- The WordPress MCP server is wired in `templates/mcp/{website,woocommerce}.json`
  via the canonical `WordPress/mcp-adapter` plugin + `@automattic/mcp-wordpress-remote`
  (verified). It needs: the mcp-adapter plugin active, a least-privilege
  `{{MCP_USER}}` with an Application Password, and `WP_MCP_APP_PASSWORD` exported in
  your env (never committed). For the e-shop, give `{{MCP_USER}}` a role that
  **excludes order/payment capabilities** — the proxy authenticates as that user,
  so its role is the security boundary.
