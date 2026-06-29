# Triage rubric — request intake

How the `intake` skill classifies a relayed client request and decides how much process
it deserves. The goal: never bureaucratize a tiny ask, never let a risky one skip a gate.

## Type

| Type | Signals | Default route |
|---|---|---|
| **content** | "change the text", "add a post/product", "swap an image" | Client self-edit (restricted role) or `wp loamkit seed`; no dev pipeline |
| **dev-feature** | new section/block/template/behavior | analyst → architect → engineer → security + tester |
| **bug** | "X is broken / doesn't work" | analyst (root cause) → engineer → tester |
| **styling** | colors, spacing, layout tweaks | architect (theme.json/tokens) → engineer → tester |
| **eshop-woo** | products, catalog, cart, shipping, tax | as dev-feature, on the Woo branch |
| **payment-checkout** | checkout, cart totals, payment gateways, refunds, orders | **MANDATORY human gate + security sign-off** |
| **infra** | deploy, env, DNS, hosting | usually out of the agent pipeline; surface to the user |

## Lane (the two-lane test)

- **CONTENT** — the change is data the client owns (post body, product info, options).
  Prefer the client editing it themselves, or a code-defined seeder for placeholders.
  Content lives in the DB and flows DOWN; never push it up.
- **CODE** — templates, blocks, theme.json, custom plugins, hooks. Flows UP via git
  through the agent pipeline.

If a request is "just content", say so and don't open a dev task.

## Size

- **S** — one small, unambiguous change. Skip the spec file; one-line task → orchestrator.
- **M** — a few files / some design needed. Write a spec.
- **L** — multi-file / architecture / cross-cutting. Write a spec; consider feeding it to
  the `spec-driven-development` flow for a full requirements → design → tasks breakdown.

## Gates (never skip)

- **payment / checkout / orders / customer data** → mandatory human gate + `wp-security-reviewer`
  sign-off before any merge. Intake flags this prominently and never auto-proceeds.
- Everything else → the standard hand-off approval in Step 5 is the gate.

## Source handling

- **Freeform (default):** the relayed text in the user's message / `$ARGUMENTS`.
- **GitHub issue (optional):** `#N` or an issue URL → `gh issue view N --json title,body,labels`.
  After triage you may post the summary back via `gh issue comment` and apply a label.
- **Ticketing MCP (Linear/Jira) / email:** not bundled. If such an MCP is connected, the
  same flow applies; otherwise the user forwards the text and it's handled as freeform.

## PII & storage

Requests may contain client personal data. Spec files go to `.claude/requests/`, which is
**git-ignored** — they must not be committed. The GitHub issue is the trackable record.

## Hand-off

Intake stops at an **approved** hand-off to `wp-orchestrator` (via the Task tool). It
never writes code itself. The orchestrator then runs the normal pipeline
(analyst → architect → engineer → security-reviewer + tester) with the project's quality
gates and the two-lane invariant.
