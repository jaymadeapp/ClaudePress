# No-Docker workflow — reference

The no-Docker branch runs the project against a native PHP and a local database,
without DDEV. It is lighter to set up but trades away guaranteed environment
parity. It is acceptable for **websites**; for **e-shops** it is a risky combo
that requires an attested local MySQL.

## Stack

- Native **PHP >= 8.3** on the host (`php_version` per `resolved-config.json`).
- A local database:
  - Website: MariaDB or MySQL on the host (`db_engine: mariadb`/`mysql`).
  - E-shop: **MySQL/MariaDB is mandatory** (`db_engine ∈ {mysql, mariadb}`,
    `db_requirement: "mysql"`). **SQLite is never generated for an e-shop.**
- Bedrock layout and Sage 11 theme are identical to the Docker branch; only the
  environment provisioning differs. **No `.ddev/` directory is generated.**

## Scaffold commands (run by scaffold.sh)

```
composer create-project roots/bedrock .
composer create-project roots/sage web/app/themes/<slug>
composer install
```

WP-CLI runs directly on the host (`wp <command>`), pointed at the local Bedrock
install via its `.env`.

## Limitations (documented in CLAUDE.md)

- **CI parity is best-effort.** Because the local environment is not
  containerized, you must **manually mirror the production PHP and DB versions**
  (and extensions, memory limits) to keep CI and production aligned. Drift here
  is the main source of "works locally, breaks in CI/prod".
- **E-shop requires local MySQL.** WooCommerce/HPOS behavior is engine-specific.
  The skill **stops and asks for confirmation** on the e-shop + no-Docker combo:
  - (a) switch to Docker (recommended), or
  - (b) continue only if the user attests a working local MySQL — then the
    project is rendered with `db_requirement: "mysql"` and a **hard SQLite ban**
    in `CLAUDE.md` and the phpstan/CI notes.
- No automatic service orchestration: you start/stop PHP, the DB and any queue
  workers yourself.

## Database — DOWN only (two-lane)

Same invariant as Docker: pull the production DB **down** to local only; never
push it upstream, never commit dumps or `.env`. `guard-two-lane.sh` enforces this
independently of the local tooling.

## MCP

Same model as Docker, but the `wordpress` server uses the **native `wp`** runner
instead of `ddev wp`. The local WordPress MCP is **STDIO via WP-CLI**, fully
automated, with **no application password**:

```json
{ "command": "wp",
  "args": ["mcp-adapter", "serve", "--server=mcp-adapter-default-server", "--user=claudepress-mcp"] }
```

`scripts/setup-mcp.sh` auto-detects the native `wp` runner, installs + activates
the `WordPress/mcp-adapter` plugin (needs WP >=6.9 / Abilities API, PHP >=7.4),
and creates the content-only role `claudepress_mcp` plus the least-privilege user
`claudepress-mcp`. The MCP client authenticates **as** that user, so its role is
the security boundary — there is nothing to export and nothing to commit.

**Remote/production fallback (remote sites only).** For a remote site you cannot
drive over local WP-CLI, use the HTTP proxy `@automattic/mcp-wordpress-remote`
with `WP_API_URL` (your remote site URL) / `WP_API_USERNAME` / `WP_API_PASSWORD`,
where the password is an Application Password from
`wp user application-password create <user> <name> --porcelain`, read from
`WP_MCP_APP_PASSWORD` in your env (never committed). The autonomous agent works
against LOCAL only — never prod.
