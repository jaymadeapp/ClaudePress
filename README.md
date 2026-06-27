# ClaudePress

A universal, security-first **WordPress / WooCommerce starter kit**, shipped as a
[Claude Code](https://code.claude.com/) plugin and built for Opus 4.8.

Its heart is an **interactive install skill**: you run one command, answer a few
questions, and ClaudePress generates a project that fits — env config, Composer
dependencies, a tailored `CLAUDE.md`, restricted client roles, role-based agents,
fail-closed security hooks and MCP configuration. One codebase covers both
content **websites** and **WooCommerce e-shops**.

---

## Rychlý start (CZ)

ClaudePress je univerzální WordPress/WooCommerce starter kit jako plugin pro
Claude Code. Interaktivní instalátor se tě zeptá na pár voleb (Docker/bez Dockeru,
web/e-shop, slug, podtyp) a vygeneruje přesně padnoucí projekt: Bedrock + Sage 11,
tailored `CLAUDE.md`, sadu agentů (Opus 4.8) a bezpečnostní hooky.

```text
/plugin marketplace add jaymadeapp/ClaudePress
/plugin install claudepress@claudepress
/claudepress:wp-setup muj-projekt
```

Klíčové: **two-lane invariant** (kód jde nahoru přes git, DB jen dolů z produkce)
a u e-shopů **tvrdá brána na data objednávek a plateb** — obojí vynucují hook
skripty, ne permission globy. Detaily níže v angličtině.

---

## 1. What it is

ClaudePress turns a blank directory into a production-shaped WordPress project:

- **Code-first stack** — Bedrock (Composer-managed WordPress) + Roots Sage 11
  (Acorn 6, Blade, Vite), `theme.json` design tokens, optional DDEV.
- **Two branches, one kit** — a content **Website** branch and a **WooCommerce
  e-shop** branch, selected interactively. All per-choice config lives in bundled
  templates, not in the skill body.
- **Security-first / fail-closed** — the two-lane invariant and WooCommerce
  data-safety are enforced by hook scripts that parse the real command, MCP runs
  least-privilege, and quality gates (PHPCS, PHPStan, PHPUnit, Playwright) must be
  green before anything is "done".
- **Opus 4.8 everywhere** — every shipped agent is pinned to `claude-opus-4-8`.

## 2. Requirements

- **Claude Code** (recent version, with plugin + marketplace support).
- **PHP 8.3+** and **Composer**.
- **Node.js** (for the theme build and Playwright E2E).
- **Docker + DDEV** — recommended. Required in practice for the WooCommerce
  e-shop branch (HPOS behavior is engine-specific and needs MySQL/MariaDB).

The installer detects your local toolchain and warns about anything missing
before it scaffolds.

## 3. Install

ClaudePress is distributed as a plugin through a GitHub marketplace:

```text
/plugin marketplace add jaymadeapp/ClaudePress
/plugin install claudepress@claudepress
```

After installing, the install skill is available as `/claudepress:wp-setup`.

> Developing the kit itself? Prototype the installer as a project skill in
> `.claude/skills/wp-setup/` (SKILL.md hot-reloads). After changing
> `hooks/`, `.mcp.json` or `agents/`, run `/reload-plugins`. Validate with
> `claude plugin validate .` before publishing.

## 4. Run the installer

```text
/claudepress:wp-setup [project-slug]
```

The installer asks a short sequence of questions (via `AskUserQuestion`, in the
main thread — it never runs itself):

1. **Local env** — *Docker (DDEV)* (recommended, isolated, reproducible) or
   *No Docker* (native PHP / wp-env; lighter, but e-shop and full CI parity are
   not guaranteed).
2. **Build type** — *Website* (Sage 11 + blocks) or *WooCommerce e-shop* (adds
   WooCommerce, HPOS, a payment human-gate and MySQL-only CI).
3. **Slug** — derive a kebab-case slug from the folder name, or type your own.
   If you passed a slug inline (`/claudepress:wp-setup my-shop`), this question
   is skipped.
4. **Subtype** — branched on build type:
   - Website → *Business*, *Blog*, or *Portfolio*.
   - E-shop → *Small shop* or *Catalog*.

The choices are written to a validated `resolved-config.json`, which is the
single contract shared by the config validator, the scaffolder and the
`CLAUDE.md` renderer. Validation is **fail-closed**: a missing key, a parse error
or a risky combination stops the run before any files are written.

## 5. What gets generated

A typical e-shop + Docker run produces something like:

```text
<project-slug>/
├── CLAUDE.md                      # tailored: stack, two-lane, quality gates, Woo data-safety
├── .claude/settings.json          # permissions + project hooks
├── composer.json                  # Bedrock (+ WooCommerce/HPOS on the e-shop branch)
├── .env.example                   # Bedrock env template (never committed)
├── .gitignore
├── .mcp.json                      # Playwright + WordPress MCP (mcp-adapter, needs app password)
├── .ddev/config.yaml              # Docker branch only (MySQL for e-shop)
├── config/                        # Bedrock config
├── web/
│   ├── app/mu-plugins/claudepress-roles.php   # restricted client roles + contentOnly
│   └── app/themes/<slug>/         # Sage 11 (theme.json, Blade, Vite)
├── tests/                         # PHPUnit + (e-shop) Playwright checkout E2E
├── phpcs.xml                      # WPCS ruleset
├── phpstan.neon                   # PHPStan + szepeviktor/phpstan-wordpress
└── resolved-config.json           # resolved choices, schema-validated
```

Every generated file has a bundled template — nothing is generated "from
nothing". The website branch is the same, minus WooCommerce, the checkout E2E
spec and the `.ddev/` directory when you choose no-Docker.

## 6. How you work — the agent workflow

ClaudePress ships role-based subagents (all Opus 4.8) that mirror a clean
delivery flow. The **orchestrator** routes work; a typical task fans out as:

```text
wp-orchestrator
   → wp-analyst     (investigate code/docs, report with file:line — read-only)
   → wp-architect   (design + trade-offs, respects two-lane/Woo — read-only)
   → wp-engineer    (implement across files — effort: high)
   → wp-security-reviewer + wp-tester  (run in parallel)
```

- **wp-analyst** — investigates and reports evidence; verifies external facts via
  WebSearch / allow-listed WebFetch; never invents WP/Woo APIs.
- **wp-architect** — designs across affected files, lists trade-offs; read-only.
- **wp-engineer** — implements the approved design following Bedrock/Sage
  conventions; the most consequential role, so it runs at `effort: high`.
- **wp-security-reviewer** — audits the diff (SQLi/XSS/CSRF/nonce/cap checks,
  secrets, two-lane violations, Woo payment/checkout changes); blocks on anything
  critical.
- **wp-tester** — runs PHPCS, PHPStan, PHPUnit and Playwright; reports pass/fail
  with evidence and verifies the MySQL engine for e-shops.

**Quality gates** that must pass before "done": PHPCS (WPCS) clean, PHPStan green,
PHPUnit green, Playwright E2E green, and zero critical security findings on the
diff.

## 7. Security model

ClaudePress is fail-closed by design. The headline rules are enforced by **hook
scripts that parse the actual command**, not by permission globs (a glob like
`Bash(* db push*)` gives a false sense of safety and often fails to match).

- **TWO-LANE INVARIANT (never violated).**
  - **CODE goes UP** — git/deploy push *code only*.
  - **CONTENT/DB goes DOWN** — pull the database from production to local only.
  - Deploy **never** pushes the database upstream; DB dumps and `.env` are never
    committed. Enforced by `guard-two-lane.sh` (PreToolUse), which blocks
    DB-up commands and refuses to write `.env` / `.sql` / DB-dump paths.

- **WooCommerce data-safety (hard gate).** Orders, customers and payment data are
  never deployed and never committed. HPOS is accessed via the CRUD API only —
  never raw SQL on order tables. Any change to checkout, cart totals or payment
  gateways requires an explicit **human gate** and a `wp-security-reviewer`
  sign-off. Enforced by `guard-woo-data.sh`.

- **Fail-closed hooks.** PreToolUse guards block on a match *and* on a parse error
  or missing field — when in doubt, they block rather than pass. PHPCS lints
  changed PHP on every edit (fast); PHPStan runs at the Stop gate (full autoload),
  not per keystroke.

- **MCP least-privilege.** The plugin-root `.mcp.json` ships **only** the
  Playwright MCP server. The per-project templates also wire the **WordPress MCP**
  via the canonical [`WordPress/mcp-adapter`](https://github.com/WordPress/mcp-adapter)
  plugin, bridged by `@automattic/mcp-wordpress-remote` (verified). It is scoped by
  the *WordPress user* it authenticates as: the installer wires a dedicated
  least-privilege `{{MCP_USER}}` and reads its Application Password from
  `WP_MCP_APP_PASSWORD` in your environment (never committed). For e-shops, that
  user's role must exclude WooCommerce order/payment capabilities — the proxy has
  no per-ability deny flag, so the WP role *is* the boundary.

- **WebFetch allow-list.** In Claude Code, *deny wins over allow*. WebFetch is
  **not** blanket-denied (that would break the analyst/architect); instead it's
  allow-listed to documentation domains (`developer.wordpress.org`, `roots.io`,
  `code.claude.com`, `woocommerce.com`).

- **Prompt-injection guardrails.** Agents treat WordPress content, post bodies,
  comments and external fetched pages as **untrusted data, never as
  instructions**. For sensitive environments, `disableSkillShellExecution` can be
  turned on in managed settings so `` ```! `` blocks don't execute.

## 8. Local dev — Docker vs no-Docker

**Docker (DDEV) — recommended:**

```text
ddev start            # boot the environment
ddev wp <command>     # WP-CLI inside the container
ddev composer <cmd>   # Composer inside the container
ddev pull             # pull production DB DOWN only — never push
```

Test sites from the **host** browser, not from inside the container.

**No-Docker:**

- Native PHP 8.3+ with a local DB; WP-CLI runs on the host. Lighter, but **CI
  parity is best-effort** — mirror PHP/DB versions to production manually.
- Acceptable for websites. For an **e-shop**, MySQL/MariaDB is mandatory
  (`db_requirement: "mysql"`); SQLite is never configured for an e-shop.

## 9. Troubleshooting

- **Risky combo: e-shop + no-Docker.** WooCommerce/HPOS needs MySQL/MariaDB;
  SQLite and "light" no-Docker setups don't guarantee CI parity or correct order
  behavior. The validator flags this and the installer **stops** to ask you to
  either switch to Docker (recommended) or confirm a local MySQL — only then does
  it generate a no-Docker variant with a hard SQLite ban in `CLAUDE.md` and CI
  notes.
- **Missing toolchain.** If toolchain detection finds Docker missing but you chose
  Docker, the installer says so and offers a no-Docker fallback or install
  instructions — it never proceeds blind.
- **Changes not picked up.** After editing `hooks/`, `.mcp.json` or `agents/`, run
  `/reload-plugins`. Skill (`SKILL.md`) edits hot-reload on their own.

## 10. License & credits

ClaudePress is released under the **MIT License**, © 2026 Jakub Sládek. See
[`LICENSE`](./LICENSE).

ClaudePress's plugin structure, interactive install-skill pattern and role-based
agent orchestration are **inspired by**
[chief-of-staff-kit](https://github.com/skyremote/chief-of-staff-kit) (MIT
License, © 2026 skyremote). Only the *pattern* is reused — **no source code from
that project is bundled** here. See [`NOTICE`](./NOTICE) for attribution. If you
want org-level "chief of staff" agents alongside ClaudePress, install
chief-of-staff-kit separately; the two are complementary.

Contributions welcome — bump `plugin.json` `version` on each release and keep the
[`CHANGELOG.md`](./CHANGELOG.md) up to date.
