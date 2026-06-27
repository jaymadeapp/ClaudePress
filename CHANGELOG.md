# Changelog

All notable changes to ClaudePress are documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.1.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

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
