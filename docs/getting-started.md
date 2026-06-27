# Getting started — ClaudePress, end to end

One verified walkthrough from an empty directory to a deployed staging preview, for a
**Website + Docker** project. The **WooCommerce e-shop** path is identical plus the Woo
notes called out below. Every step lists a checkpoint so you know it worked.

> This is the happy path. The skills are auto-invoked from plain language, so in practice
> you mostly just *talk* — the explicit commands below are the fallback / what runs
> underneath.

## 0. Prerequisites

- **Claude Code** with the ClaudePress plugin installed
  (`/plugin marketplace add jaymadeapp/ClaudePress` → `/plugin install claudepress@claudepress`).
- **PHP 8.4+**, **Composer**, **Node.js**, and **DDEV** on a container engine
  (`brew install ddev/ddev/ddev` + `mkcert -install`). See the README §2.

Checkpoint: `claude --version`, `ddev --version`, `composer --version`, `php -v` all print.

## 1. Create the project

In an empty directory, just ask:

> "Vytvoř nový WordPress eshop" / "create a new WordPress website"

The **wp-setup** skill auto-runs. It confirms the stack + target directory, then asks:
local env (Docker/no-Docker), build type (website/e-shop), slug, and subtype. It writes a
validated `resolved-config.json`, scaffolds Bedrock + Sage 11, and renders the project:
`CLAUDE.md`, `.claude/settings.json`, `.mcp.json`, `.ddev/config.yaml`, the quality-gate
config, the restricted client roles, the **content seeder**, and `.claude/deploy.json`.

Explicit form: `/claudepress:wp-setup my-shop`.

Checkpoint: `composer.json` is a Bedrock root; `web/app/themes/<slug>/` exists;
`.gitignore` contains a `# ClaudePress` block ignoring `/.claude/requests/`;
`web/app/mu-plugins/content-seed.php` and `.claude/deploy.json` exist.

## 2. Bring the environment up

    cp .env.example .env        # set DB_* to DDEV's db/db/db@db, WP_HOME, WP_ENV=development
    ddev start
    ddev composer install
    ddev wp core install --url="https://<slug>.ddev.site" --title="<title>" \
      --admin_user=admin --admin_email=you@example.com --prompt=admin_password

For an **e-shop**: `ddev wp plugin activate woocommerce` (HPOS is on by default; CI/tests
run on MySQL — never SQLite).

Checkpoint: `https://<slug>.ddev.site` returns HTTP 200; `ddev wp core is-installed` passes.

## 3. Wire the WordPress MCP (zero manual secrets)

    ddev wp ... is already running, so just:
    bash <plugin>/skills/wp-setup/scripts/setup-mcp.sh resolved-config.json

This installs the `WordPress/mcp-adapter` plugin and creates the least-privilege
`claudepress-mcp` user. The `.mcp.json` already points at a STDIO server
(`ddev wp mcp-adapter serve … --user=claudepress-mcp`) — **no application password**.
Restart Claude Code (or `/reload-plugins`).

Checkpoint: `ddev wp plugin is-active mcp-adapter`; the `wordpress` MCP server responds.

## 4. Seed placeholder content (for preview before the client's real copy)

    ddev wp claudepress seed

Creates placeholder pages (home, about, services, contact) — and, for an e-shop, a few
demo products — all create-if-absent and dev/staging-only (it refuses on production). A
client's later edits are never overwritten; `ddev wp claudepress unseed` removes only the
placeholders. See `reference/content-seeding.md`.

Checkpoint: 4 placeholder pages exist (`ddev wp post list --post_type=page`); re-running
`seed` creates nothing new (idempotent).

## 5. Handle a client request

Just relay it in plain language:

> "Klient chce na produktové stránce pruh 'Doprava zdarma nad 1500 Kč'."

The **intake** skill auto-triages it (type / lane / size / gates), right-sizes the work
(pure content → client editor/seeder; checkout/payments → mandatory human gate), writes a
spec to `.claude/requests/` (git-ignored, PII), and — once you approve — hands off to
**wp-orchestrator** → analyst → architect → engineer → security + tester. Quality gates
(PHPCS / PHPStan / PHPUnit / Playwright) run via hooks; nothing is "done" until they're
green. See README §6.

Checkpoint: a green diff with passing gates; the change visible at `https://<slug>.ddev.site`.

## 6. Ship to staging

Configure `.claude/deploy.json` (staging branch/remote, optional webhook) once, then:

> "nasaď to na staging" — or `/claudepress:deploy-staging`

It runs the gates and pushes the `staging` branch your host watches (Coolify / own VPS /
Forge / GitHub Actions). **Code only** — the database, content and orders are never
deployed. Production stays human-gated. See `reference/deploy.md`.

Checkpoint: the staging branch updated; your host redeployed; the preview URL reflects the
change.

## The two-lane rule (keep this in your head)

- **Code goes UP** — git/deploy push code only.
- **Content & orders go DOWN** — pull prod → dev (anonymized for e-shops); never push the
  DB up. Placeholder content is the one thing that goes up — as *code* (the seeder), not a
  DB push.
