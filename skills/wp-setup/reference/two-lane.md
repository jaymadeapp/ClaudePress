# Two-lane invariant — reference

The two-lane invariant is the non-negotiable data-flow rule for every project
Loamkit generates. It is enforced by **hook scripts** (`guard-two-lane.sh`,
and `guard-woo-data.sh` for e-shops), running fail-closed at `PreToolUse` — **not
by permission globs**, which give a false sense of safety and rarely match the
real command.

## The two lanes

```
        ┌─────────────────────────────┐
CODE →  │  git / deploy push code UP  │  → production
        └─────────────────────────────┘

        ┌─────────────────────────────┐
        │  pull DB DOWN to local      │  ← production
CONTENT └─────────────────────────────┘
```

- **CODE = git UP.** Code (themes, plugins, mu-plugins, config) goes **up** via
  git and the deploy pipeline. That is the only thing that flows upstream.
- **CONTENT/DB = DB DOWN.** The database and uploaded content are pulled **down**
  from production to local for development. They never flow up.
- **Deploy NEVER pushes the database upstream.** There is no "sync DB to prod"
  step. A deploy ships code; production keeps its own canonical content.
- **Never commit DB dumps or `.env`.** They are not code; they hold content
  and/or secrets.

## Why hooks, not globs

A glob like `Bash(* db push*)` or `Bash(mysqldump*production*)` looks protective
but:
- it does not match the actual command shapes (`wp db import prod.sql`, a
  provider-specific deploy, a piped `mysql < dump.sql`, etc.);
- `deny` already wins over `allow` in Claude Code, so adding more globs only adds
  blind spots.

Instead, `guard-two-lane.sh` parses the real tool-call payload from stdin
(`tool_name`, `tool_input.command` / `file_path`), matches the dangerous
patterns, and exits non-zero to **block** — and also blocks on parse error or a
missing field (true fail-closed: when in doubt, deny).

Blocked patterns (illustrative): `db push` / `db-push`, `wp db import …(prod|
production)`, `git add`/`git commit` of `*.sql` or `*.env`, and writing/editing a
path matching `*.env`, `*.sql`, or `/db-dumps/`.

## WooCommerce hardening (e-shop only)

On the e-shop branch, `guard-woo-data.sh` adds a stricter lane:
- orders, customers and payment data are **never deployed and never committed**;
- it blocks tool calls touching `wc_orders` / `wp_woocommerce_order*`, exported
  `orders.(csv|sql)`, or `payment gateway` data;
- changes to checkout, cart totals or payment gateways require an explicit
  **HUMAN GATE** + `wp-security-reviewer` sign-off before merge.

## In the generated project

The generated `CLAUDE.md` restates this invariant in the **TWO-LANE INVARIANT
(NEVER VIOLATE)** section, and notes that enforcement is by `guard-two-lane.sh`
(PreToolUse, fail-closed), not by permission globs. Agents treat it as a hard
rule; `wp-engineer` "never writes DB-up", and `wp-security-reviewer` flags any
two-lane violation as critical.
