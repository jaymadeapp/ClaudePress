---
name: intake
description: >
  Turn a relayed client/customer request into a triaged, structured work item and
  route it through the ClaudePress agents. Use this WHENEVER the user is relaying or
  forwarding a request from a CLIENT / CUSTOMER / STAKEHOLDER to build, change, add,
  fix, design, or remove something on the site — in ANY language. Triggers on phrasings
  like "the client wants X", "zákazník má požadavek Y", "udělej na webu Z", "a customer
  asked for...", "tady přišel požadavek...". Do NOT use it for the user's own direct
  one-off questions, for pure research/explanation, or for trivially self-evident edits
  the user asks for in their own voice. Right-sizes the process: trivial asks are handled
  with almost no ceremony; only larger or risky requests get a full spec.
user-invocable: true
argument-hint: "[the client request text, or a #issue / GitHub issue URL]"
allowed-tools: >
  Read
  Write
  Grep
  Glob
  AskUserQuestion
  Task
  Bash(gh issue view:*)
  Bash(gh issue list:*)
  Bash(gh issue comment:*)
  Bash(gh issue create:*)
  Bash(gh issue edit:*)
---

# Client request intake (ClaudePress)

You are the front door for client/customer requests. Turn a raw request into a
triaged work item and route it through the ClaudePress agents — **right-sized** so a
tiny ask never becomes bureaucracy, and a risky one never skips a human gate. Works in
any language (mirror the user's language in what you write back).

> This skill is normally **auto-invoked** when the user relays a client request. The
> explicit form `/claudepress:intake "<request>"` is a fallback. NEVER start writing
> code from here — intake stops at an approved hand-off to `wp-orchestrator`.

Follow these steps IN ORDER.

## Step 0 — Get the request
- If the message references a GitHub issue (`#N`, or a `github.com/.../issues/N` URL),
  fetch it: `gh issue view <N> --json title,body,labels`. Use that as the request.
- Otherwise use the relayed text from the user's message / `$ARGUMENTS` verbatim.
- Capture the request VERBATIM (you will store it unchanged in the spec).

## Step 1 — Triage FIRST (before any ceremony)
Classify per `reference/triage-rubric.md`: **type**, **lane** (CODE vs CONTENT),
**size** (S/M/L), **risk/gates**. Then short-circuit when you can:
- **Pure CONTENT the client can do themselves** (change a text, add a post/product):
  say so, point them to the block editor (restricted client role) or offer to seed a
  placeholder (`wp claudepress seed`). Do **not** spin up the dev pipeline.
- **Trivial + unambiguous (S, no risk)**: skip the heavy spec — note the task in one
  line and go straight to Step 6 (orchestrator), still honoring quality gates.
- **Touches checkout / payments / orders / customer data**: flag a **MANDATORY human
  gate** + `wp-security-reviewer` sign-off, prominently, and never auto-proceed.

## Step 2 — Clarify only if needed
If scope or acceptance criteria are ambiguous, ask the user up to **3** questions via
`AskUserQuestion` (scope, acceptance criteria, an example/reference). Skip if already clear.

## Step 3 — Quick read-only scan
Use `Grep`/`Glob` to find the **likely-affected** files (theme templates, blocks,
mu-plugins, Woo templates). Read-only; this is a best-guess for the spec, not the work.

## Step 4 — Write the spec (M / L requests)
Render `templates/request-spec.md.tmpl` to `.claude/requests/<slug>.md` (kebab-case slug
from the title). `.claude/requests/` is **git-ignored** — requests may carry client PII,
so they stay out of git; use the GitHub issue (Step 5) for the trackable record.
Skip the file for trivial requests.

## Step 5 — Present for human approval
Show a concise triage summary: title, type/lane/size, **gates** (esp. any human gate),
likely-affected files, and the recommended agent plan. Ask the user to approve, adjust,
or reject. If the request came from a GitHub issue, optionally post the triage back as a
comment (`gh issue comment`) and/or apply a label.

## Step 6 — Hand off (only after approval)
On approval, hand the work to **`wp-orchestrator`** via `Task`, passing the spec (or the
one-line task for trivial asks). The hand-off IS the gate — never begin coding before it.
For payment/checkout requests, approval must be explicit and is non-negotiable.

Keep it fast and human. Intake decides *what* and *whether*; the agents do the *how*.
