---
name: wp-setup
description: Scaffolds a tailored WordPress project (website or WooCommerce e-shop, Docker or no-Docker) by asking the user a few setup questions, then generating composer deps, env config, MCP config, agents wiring and a tailored CLAUDE.md. Use when the user wants to start, bootstrap or initialize a new WordPress or WooCommerce project.
disable-model-invocation: true
user-invocable: true
argument-hint: "[project-slug]"
allowed-tools: >
  Write
  Edit
  Read
  AskUserQuestion
  Bash(php *)
  Bash(composer *)
  Bash(ddev *)
  Bash(wp *)
  Bash(node *)
  Bash(npm *)
  Bash(git init*)
  Bash(bash ${CLAUDE_SKILL_DIR}/scripts/*)
---

# WordPress project setup (ClaudePress)

This skill bootstraps a security-first WordPress or WooCommerce project on a
Bedrock + Sage 11 stack, tailored to the user's answers. It runs **only in the
main thread** (never as a forked subagent — `AskUserQuestion` is unavailable
there) and is **never** auto-invoked (`disable-model-invocation: true`).

Follow these steps IN ORDER. Do not skip the questions. Do not run scaffolding
before config is validated.

> **IMPORTANT — block execution semantics.** The fenced blocks marked with
> ` ```! ` in **Step 0** and **Step 2** are *pre-execution* blocks: they run
> automatically when this skill is loaded, and their stdout is injected into the
> context before you start reasoning. They exist to detect the toolchain and to
> validate the config. **Step 4 is different**: it uses a plain ` ```bash ` block
> that is **NOT** auto-executed. You invoke it deliberately as a Bash tool call,
> and only **after** the Step 2 validation has passed. **Never convert Step 4 to
> a ` ```! ` block** — doing so would launch scaffolding before the user's
> answers exist.

---

## Step 0 — Detect toolchain (runs at skill load via ```!)

```!
bash ${CLAUDE_SKILL_DIR}/scripts/detect-toolchain.sh
```

Use the detected versions to:
- set recommended defaults for the questions (e.g. recommend Docker only if the
  Docker daemon is reachable);
- warn early on missing tools (no `composer`, no `php`, no `ddev`/`docker`);
- if the user later picks an env whose toolchain is missing, STOP and offer a
  fallback or install instructions instead of proceeding blind (see §Decision
  tree, "Missing toolchain").

---

## Step 1 — Ask the user (AskUserQuestion, main thread only)

Call `AskUserQuestion` **TWICE**. Never attempt all four decisions in one call —
the subtype options depend on the build-type answer, so they cannot be known
until Call A returns.

- **Call A** — `env`, `build type`, `slug` (up to 3 questions).
  - If an inline slug was passed (`$1` / `$ARGUMENTS`), **drop the slug
    question** from Call A and normalize the inline value to kebab-case.
- **Call B** — `subtype`, with options **branched** on Call A's build-type
  answer (website ⇒ business/blog/portfolio; e-shop ⇒ small-shop/catalog).

### Call A payload

```json
{
  "questions": [
    {
      "question": "Where should the local dev environment run?",
      "header": "Local env",
      "options": [
        { "label": "Docker (DDEV)", "description": "Recommended. DDEV + Bedrock, isolated, reproducible. Needs Docker." },
        { "label": "No Docker",     "description": "Native PHP + local DB. Lighter, but e-shop and full CI parity not guaranteed." }
      ],
      "multiSelect": false
    },
    {
      "question": "What are you building?",
      "header": "Build type",
      "options": [
        { "label": "Website",            "description": "Content site: business, blog, portfolio. Sage 11 + blocks." },
        { "label": "WooCommerce e-shop", "description": "Store/catalog. Adds WooCommerce, HPOS, payment human-gate, MySQL-only CI." }
      ],
      "multiSelect": false
    },
    {
      "question": "Project slug? (or type a custom one in the Other field)",
      "header": "Slug",
      "options": [
        { "label": "Use folder name", "description": "Derive a kebab-case slug from the current directory name. Recommended." }
      ],
      "multiSelect": false
    }
  ]
}
```

> **Slug.** The dedicated question offers a single recommended option ("Use
> folder name"); a custom slug is entered through the always-present **Other**
> free-text field. If the slug was passed inline (`$1`/`$ARGUMENTS`), omit this
> question entirely. Always normalize to kebab-case
> (`^[a-z0-9]+(-[a-z0-9]+)*$`).

### Call B payload (branch on Call A's build type)

```jsonc
// if A.build == "Website":
{ "questions": [ {
  "question": "What kind of website?",
  "header": "Subtype",
  "options": [
    { "label": "Business",  "description": "Marketing/company site, services, contact." },
    { "label": "Blog",      "description": "Editorial, posts, categories, RSS." },
    { "label": "Portfolio", "description": "Showcase/case studies, galleries." }
  ],
  "multiSelect": false
} ] }

// if A.build == "WooCommerce e-shop":
{ "questions": [ {
  "question": "What kind of shop?",
  "header": "Subtype",
  "options": [
    { "label": "Small shop", "description": "Few products, simple checkout, single currency." },
    { "label": "Catalog",    "description": "Product browsing, optional/disabled checkout." }
  ],
  "multiSelect": false
} ] }
```

---

## Step 2 — Write & validate resolved-config.json (plan-validate-execute, runs at load via ```!)

Write `resolved-config.json` from the answers, conforming **exactly** to
`templates/resolved-config.schema.json`. Map answers like so:

- `env`: `docker` | `no-docker`
- `build`: `website` | `woocommerce`
- `subtype`: `business` | `blog` | `portfolio` | `small-shop` | `catalog`
- `slug`: kebab-case
- `project_name`: human-readable name (default: Title Case of slug)
- `php_version`: from detection, `^(8\.([3-9]|[1-9][0-9])|9\.[0-9]+)$` (default `8.3`)
- `db_engine`: `mariadb` (Docker website) | `mysql` (any e-shop) | never `sqlite` for e-shop
- `db_requirement`: `mysql` for e-shop, else `any`
- `flags.WOO` = (`build == "woocommerce"`), `flags.DOCKER` = (`env == "docker"`)

Then validate:

```!
bash ${CLAUDE_SKILL_DIR}/scripts/validate-config.sh
```

If validation fails (missing required key, parse error, risky combo), the script
exits non-zero (**fail-closed**). **STOP** and surface the exact warning to the
user. The most common stop is the e-shop + no-Docker risky combo — see the
Decision tree below.

---

## Step 3 — Render templates per the decision tree

Read the matching reference file ONE level deep and render templates with
`Write`/`Edit`. Substitute placeholders from `resolved-config.json`:
`{{PROJECT_NAME}}`, `{{SLUG}}`, `{{PHP_VERSION}}`, `{{DB_ENGINE}}`,
`{{SUBTYPE}}`, `{{TEXTDOMAIN}}` (= slug). For `CLAUDE.md.tmpl`, keep or strip the
conditional blocks per §Tailored CLAUDE.md below.

The `mcp/*.json` template needs **no placeholder substitution** and you do **not**
edit it by hand: the `wordpress` server uses **STDIO via WP-CLI** as the fixed
user `claudepress-mcp` — there is NO application password and NO secret in the
file. The on-disk template defaults to the **DDEV stdio** form (`command: "ddev"`);
**`scaffold.sh` (Step 4) writes `./.mcp.json` and automatically picks the runner**
from `resolved-config.json` — Docker keeps `ddev`, and for a **no-Docker** project
it rewrites the `wordpress` server to the native `wp` form
(`{"command":"wp","args":["mcp-adapter","serve","--server=mcp-adapter-default-server","--user=claudepress-mcp"]}`).
The mcp-adapter plugin install and the least-privilege `claudepress-mcp` user are
provisioned automatically by `scripts/setup-mcp.sh` (Step 4b) — the user does
nothing manual locally. For an e-shop, role `claudepress_mcp` is content-only and
must exclude WooCommerce order/payment caps. (Only a **remote/production** site
uses the HTTP-proxy + Application Password fallback — `@automattic/mcp-wordpress-remote`
with `WP_API_URL/USERNAME/PASSWORD`; see `reference/docker.md` / `no-docker.md`.)

Also rendered in **every** branch (like `claudepress-roles.php`): the content seeder
`mu-plugins/content-seed.php` (from `templates/mu-plugins/content-seed.php.tmpl`,
substitute `{{SLUG}}`/`{{TEXTDOMAIN}}`) for safe placeholder content, and
`.claude/deploy.json` (copy `templates/deploy.example.json`, fill the staging
branch/remote/URL) for the host-agnostic `/claudepress:deploy-staging` skill. See
`reference/content-seeding.md` and `reference/deploy.md`.

| Env | Build | Subtype | Key generated files |
|---|---|---|---|
| Docker | Website | business/blog/portfolio | `composer/website.json`, `ddev/config.website.yaml`, `mcp/website.json`, `CLAUDE.md` (web+docker), `theme.json` (subtype presets), `phpcs.xml`, `phpstan.neon`, `mu-plugins/claudepress-roles.php`, `tests/phpunit.xml.dist` + `ExampleTest` |
| Docker | E-shop | small-shop/catalog | `composer/woocommerce.json`, `ddev/config.woo.yaml` (MySQL), `mcp/woocommerce.json`, `CLAUDE.md` (eshop+docker + Woo data-safety), `phpcs.xml`, `phpstan.neon`, `mu-plugins/claudepress-roles.php`, `tests/` + `e2e/checkout.spec.ts`, `guard-woo-data` active |
| No-Docker | Website | * | `composer/website.json`, `mcp/website.json`, **no** `.ddev/`, `CLAUDE.md` (web+no-docker, limits), `phpcs.xml`, `phpstan.neon`, `mu-plugins/claudepress-roles.php`, `tests/phpunit.xml.dist` + `ExampleTest` |
| No-Docker | E-shop | * | **RISKY COMBO** → see below. If the user confirms local MySQL: as Docker E-shop, **no** `.ddev/`, `db_requirement: mysql`, `e2e/checkout.spec.ts`, `guard-woo-data` active |

**Risky combos & blockers:**

- **E-shop on No-Docker.** WooCommerce/HPOS requires MySQL/MariaDB; neither
  SQLite nor a "light" no-Docker path guarantees CI parity or correct order
  behavior. `validate-config.sh` flags this as a warning and this skill **stops
  and asks the user to confirm**: offer (a) switch to Docker (recommended), or
  (b) continue **only** if the user attests a local MySQL — then render the
  no-Docker variant with `db_requirement: "mysql"` and a hard SQLite ban in
  `CLAUDE.md` and the phpstan/CI notes. **Never** generate a SQLite config for an
  e-shop.
- **Missing toolchain** (from Step 0). If Docker is unavailable but the user
  chose Docker, announce it and offer a no-Docker fallback or install
  instructions; do not proceed blind.

---

## Step 4 — Run scaffold (Claude-invoked Bash, ONLY after Step 2 passed — do NOT make this ```!)

```bash
bash ${CLAUDE_SKILL_DIR}/scripts/scaffold.sh resolved-config.json
```

`scaffold.sh` is idempotent: it runs `composer create-project roots/bedrock`,
creates the Sage 11 theme under `web/app/themes/<slug>`, places the rendered
templates, writes `./.mcp.json` (picking the DDEV vs native `wp` runner from
`resolved-config.json`) and — for no-Docker — `wp-cli.yml`, renders `.ddev/config.yaml`
(substituting `{{SLUG}}`/`{{PHP_VERSION}}`) for Docker builds, and wires the
`.claude/`, `tests/` and `mu-plugins/` trees according to `resolved-config.json`.
As its last step it provisions the local
WordPress MCP **iff** WordPress is already installed (see Step 4b); otherwise it
prints the exact follow-up command.

---

## Step 4b — Provision the WordPress MCP (auto-install adapter + least-priv user)

The local WordPress MCP is fully automated — the user does **nothing manual**.
Once WordPress is up (e.g. `ddev start && ddev wp core install ...` for Docker,
or a native `wp core install ...` for no-Docker), run:

```bash
bash ${CLAUDE_SKILL_DIR}/scripts/setup-mcp.sh resolved-config.json
```

`setup-mcp.sh` is idempotent and defensive. It auto-detects `ddev wp` vs native
`wp`, installs + activates the canonical `WordPress/mcp-adapter` plugin, creates
the content-only role `claudepress_mcp` and the least-privilege user
`claudepress-mcp`. If WordPress is not installed yet it prints the exact
prerequisite and exits non-zero — re-run it after `wp core install`. (For an
e-shop it additionally asserts the role has **no** WooCommerce order/payment
caps.) `scaffold.sh` runs this for you automatically when WP is already
installed, so usually you only run it by hand if the DB came up after scaffold.

---

## Step 5 — Verify

Confirm:
- after you run the printed `composer install` (or `ddev composer install`),
  `vendor/` exists — `scaffold.sh` does not run it, it prints it as a next step;
- the theme is present under `web/app/themes/<slug>/` with `theme.json`;
- `.mcp.json` is valid JSON with the Playwright server plus a **STDIO** WordPress
  MCP server (no secrets, no env, no application password). Confirm `setup-mcp.sh`
  installed the `WordPress/mcp-adapter` plugin and created the least-privilege
  `claudepress-mcp` user (content-only role `claudepress_mcp`). If WP wasn't
  installed at scaffold time, run `setup-mcp.sh` now to finish provisioning;
- `CLAUDE.md`, `phpcs.xml`, `phpstan.neon`, `.claude/settings.json`,
  `mu-plugins/claudepress-roles.php` and the `tests/` skeleton were written;
- for e-shop: `db_engine` is `mysql`/`mariadb` (never sqlite) and
  `e2e/checkout.spec.ts` exists.

Report what was created and the next command to run (`ddev start` for Docker, or
the native run instructions for no-Docker). If WordPress wasn't installed when
`scaffold.sh` ran, the next command is to install WP and then run
`setup-mcp.sh` to provision the WordPress MCP (no manual app-password step).

---

## Tailored CLAUDE.md (how Step 3 writes it)

1. Read `templates/CLAUDE.md.tmpl`.
2. Replace placeholders from `resolved-config.json`.
3. Resolve the conditional blocks by marker:
   - `<!-- IF:DOCKER -->…<!-- /IF -->` — keep iff `flags.DOCKER`.
   - `<!-- IF:NODOCKER -->…<!-- /IF -->` — keep iff `!flags.DOCKER`.
   - `<!-- IF:WOO -->…<!-- /IF -->` — keep iff `flags.WOO`.
   - `<!-- IF:WEBSITE -->…<!-- /IF -->` — keep iff `!flags.WOO`.
   Strip the marker comments from the output.
4. `Write` the result to `<project>/CLAUDE.md`. No `claude /init` — the content
   is deterministic from the template (plan-validate-execute).

## Reference (read one level deep in Step 3, as relevant)

- `reference/website.md` — website branch: subtypes, blocks, theme.json mapping,
  client-safe editing.
- `reference/woocommerce.md` — e-shop branch: HPOS, CRUD-only, MySQL-only CI,
  payment human-gate, Shop Manager restriction.
- `reference/docker.md` — DDEV + Bedrock workflow.
- `reference/no-docker.md` — no-Docker workflow and limitations.
- `reference/two-lane.md` — the two-lane invariant for the generated project.
