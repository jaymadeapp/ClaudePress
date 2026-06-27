# Changelog

All notable changes to ClaudePress are documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.1.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [0.1.5] - 2026-06-27

### Changed

- **`wp-setup` is now auto-invocable.** Dropped `disable-model-invocation` so a
  plain-language ask ("create a new eshop", "vytvoř nový web") starts the installer
  directly — consistent with the `intake` skill; `/claudepress:wp-setup` still works.
  Safeguard: the skill now **confirms the target directory** before scaffolding (and
  stops if it looks like the kit repo or an existing project), and nothing irreversible
  runs until the questions are answered and validation passes.

## [0.1.4] - 2026-06-27

Client-request intake skill.

### Added

- **`intake` skill** (`skills/intake/`) — the front door for client/customer requests.
  It is **auto-invoked** (model-invocable) when you relay a request in plain language
  ("the client wants…", "zákazník chce…", any language); `/claudepress:intake "<request>"`
  is an explicit fallback. It **right-sizes** the process: trivial asks skip the ceremony,
  pure content is routed to the client editor / seeder, and checkout/payment/order
  requests force a mandatory human gate + security sign-off. For non-trivial work it
  triages (type / lane / size / risk), does a read-only scan for likely-affected files,
  writes a spec to `.claude/requests/` (git-ignored — may hold PII), optionally records a
  GitHub issue (`gh`), and — only after approval — hands off to `wp-orchestrator`.
  Includes `templates/request-spec.md.tmpl` and `reference/triage-rubric.md`.
- Generated projects now git-ignore `.claude/requests/` (PII), and `CLAUDE.md` documents
  the intake flow.

## [0.1.3] - 2026-06-27

Content seeding + host-agnostic staging deploy.

### Added

- **Content seeder** — `web/app/mu-plugins/content-seed.php` (template) registers
  `wp claudepress seed` / `wp claudepress unseed`. Idempotent, create-if-absent
  placeholder pages (+ demo WooCommerce products when active), refuses to run on
  production (`WP_ENV`), and is WP-CLI-only. Lets Claude populate dev for preview
  and promote placeholders to staging **as code** — a client's real edits are never
  overwritten. See `reference/content-seeding.md`.
- **`/claudepress:deploy-staging` skill** + `scripts/deploy-staging.sh` — a
  **host-agnostic** staging deploy: runs the gates, then pushes a `staging` branch
  the host watches (optional webhook). Code only — DB/content/orders are never
  deployed; production stays out of scope (human-gated). Config in
  `.claude/deploy.json` (from `templates/deploy.example.json`).
- **`reference/deploy.md`** — the universal git-push deploy model, branch strategy,
  a **Coolify** preset (recommended), and "bring your own host" notes (VPS / Forge /
  Ploi / GitHub Actions). ClaudePress does not require any specific platform.

## [0.1.2] - 2026-06-27

Live end-to-end smoke-test fixes (real Bedrock + DDEV + WooCommerce run).

### Fixed

- **WordPress plugins now install** — switched the composer fragments from the
  retired `wpackagist-plugin/*` names to Roots' **WP Packages** (`wp-plugin/*`),
  registered in Bedrock by default since WPackagist's March-2026 acquisition.
  Verified: `wp-plugin/woocommerce` 10.9.1 installs and activates.
- **Fragments are additive only** — dropped the base packages the fragments used to
  re-require (`roots/wordpress`, `php`, `composer/installers`, …), which conflicted
  with Bedrock's pinned WordPress 7.0 and broke the whole `composer require`.
- **Dev tooling installs** — `scaffold.sh` now allows the phpcs/phpstan composer
  plugins (`allow-plugins`) before requiring, so PHPCS/PHPStan/PHPUnit install
  cleanly (previously aborted with an allow-plugins exception).
- **`require-dev` is honored** — the scaffolder used to process only `require`.
- **Faster + resilient requires** — batch all requires in one command, falling back
  to per-package only on failure (was: one full solve per package).
- **No bad PHP platform pin** — removed a `config.platform.php` override that pinned
  to `8.x.0` and under-satisfied deps needing `>= 8.4.1`; php_version is host-matched
  instead (Sage 11 / Acorn 6 require PHP 8.4+).

### Verified (live)

Real `composer create-project` Bedrock + Sage, `ddev start`, `wp core install`,
`setup-mcp.sh` (mcp-adapter installed, least-privilege `claudepress-mcp` user/role
created with order/payment caps excluded for e-shops), and a **WordPress MCP STDIO
handshake returning a valid JSON-RPC result** over `ddev wp mcp-adapter serve`.

## [0.1.1] - 2026-06-27

Security & correctness hardening (adversarial review pass).

### Fixed

- **Two-lane guard bypasses** — `guard-two-lane.sh` now blocks DB exfiltration over
  `ssh`/`scp`/`rsync`/`sftp`/`nc` and `mysqldump | mysql -h`, blocks any `wp db import`,
  and runs a real `git status` check so bulk `git add -A` can't sneak `.env`/`.sql`
  dumps past the guard. `settings.json` deny-list gained the same transports.
- **`git checkout` false-positive** — the Woo guard no longer blocks `git checkout`
  (and other `checkout` paths); checkout/cart/payment patterns are anchored to real
  WooCommerce file paths, and order-data blocks are gated on `flags.WOO`.
- **Hooks wiring** — PreToolUse matchers now include `Write|Edit|MultiEdit`, so the
  write-side guards (e.g. blocking a `.env` write) actually run.
- **`.mcp.json` now generated** — `scaffold.sh` writes the project `.mcp.json` from the
  build-type template and rewrites the WordPress MCP runner to native `wp` for no-Docker.
- **DDEV `php_version`** now honors the chosen PHP version (was hardcoded 8.3).
- **bash 3.2 (macOS)** — fixed empty-array expansion abort in `scaffold.sh`.
- **No-Docker** — dropped the misleading "wp-env" mention, added a `wp-cli.yml`
  (`path: web/wp`) and a native serving note. Broadened the PHP-version regex to
  accept 8.10+/9.x. Reconciled docs that claimed `composer install` runs in scaffold.

## [0.1.0] - 2026-06-27

Initial release.

### Added

- **Plugin manifest & marketplace** — `.claude-plugin/plugin.json` and
  `.claude-plugin/marketplace.json` so the kit installs via
  `/plugin marketplace add` + `/plugin install`.
- **Interactive install skill** — `skills/wp-setup/` (`/claudepress:wp-setup`).
  Asks for local env (Docker/no-Docker), build type (website/WooCommerce e-shop),
  project slug and subtype, then renders a tailored project from bundled templates:
  `composer.json`, `.env.example`, `.gitignore`, `.mcp.json`, DDEV config,
  `theme.json`, `phpcs.xml`, `phpstan.neon`, restricted client roles, a tests
  skeleton and a tailored `CLAUDE.md`.
- **Role-based agents** — `agents/wp-orchestrator`, `wp-analyst`, `wp-architect`,
  `wp-engineer`, `wp-security-reviewer`, `wp-tester`, all pinned to Opus 4.8
  (`claude-opus-4-8`).
- **Security layer** — fail-closed hooks (`hooks/hooks.json`) wiring
  `guard-two-lane.sh` and `guard-woo-data.sh` (PreToolUse), `lint-php.sh`
  (PostToolUse) and `phpstan.sh` (Stop gate). The two-lane invariant and
  WooCommerce data-safety gate are enforced by these hook scripts, not by
  permission globs.
- **MCP least-privilege, auto-provisioned** — plugin-root `.mcp.json` ships only
  the Playwright MCP server. Per-project templates wire the WordPress MCP via the
  canonical `WordPress/mcp-adapter` plugin over **STDIO via WP-CLI** — no
  application password, no secret in the file. `scripts/setup-mcp.sh` auto-installs
  the adapter and creates a content-only least-privilege user `claudepress-mcp`
  (role `claudepress_mcp`; e-shop role excludes order/payment caps), so local
  setup is zero-touch. The HTTP-proxy + Application Password path
  (`@automattic/mcp-wordpress-remote`, `WP_MCP_APP_PASSWORD`) remains documented as
  a remote/production-only fallback.
- **Documentation** — `README.md`, `LICENSE` (MIT), `NOTICE` and this changelog.

[0.1.0]: https://github.com/jaymadeapp/ClaudePress/releases/tag/v0.1.0
