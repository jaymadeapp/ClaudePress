# Content seeding — reference

ClaudePress lets Claude populate the **DEV** database with clearly-marked
placeholder content for a quick preview, and then promote that content to
staging **without violating the two-lane invariant**. The safe pattern is
*content as code*: an idempotent, versioned seeder (`content-seed.php`
mu-plugin) that flows UP through git and is create-if-absent, so it never
overwrites content a client later edits in wp-admin.

See [`two-lane.md`](./two-lane.md) for the underlying invariant.

## On DEV: content CRUD is allowed

The two-lane guard does **not** block content CRUD. It only blocks pushing the
DB upstream and committing dumps/secrets. So on DEV, Claude can freely edit
content through WP-CLI or the WordPress MCP (content capabilities):

- `wp post create` / `wp post update`
- `wp option update`
- `wp wc product create` (e-shop)

This is how Claude assembles a live preview locally. None of it flows upstream by
itself — DEV content stays on DEV.

## Promoting placeholder content to staging — the SAFE way

Do **not** push the raw DB up to promote your placeholder content. The two-lane
invariant forbids it and `guard-two-lane.sh` blocks it (fail-closed). A DB push
would also destroy whatever content already lives on staging.

Instead, author the content as the idempotent **`content-seed.php` mu-plugin**
(content-as-code):

1. It is code, so it flows **UP via git** like any other mu-plugin — through the
   normal deploy pipeline, never through a DB push.
2. It runs as a **post-deploy step**: `wp claudepress seed`.
3. It runs on **dev/staging ONLY** — the command refuses to run when
   `WP_ENV === 'production'` (`WP_CLI::error("refusing to seed on production")`).
4. It is **create-if-absent**: each page is created only if its slug does not
   already exist; each demo product only if its SKU does not already exist.
   Existing items are skipped, never updated.

Because it is create-if-absent, running the seed again after a client has edited
a seeded page changes nothing — the client's edits in wp-admin are never
overwritten.

## The two-lane handoff

Placeholder content and real content live in different lanes, and they hand off
cleanly:

- **Claude-authored placeholder content = code-defined seed → travels UP.** It
  is defined in `content-seed.php`, shipped via git, and applied with
  `wp claudepress seed` on dev/staging.
- **Client-authored real content = database → travels DOWN, never overwritten.**
  Once the client edits a seeded page in wp-admin, that page exists, so the
  seeder's create-if-absent check skips it forever. The seeder leaves it alone.

In other words: the seed *bootstraps* a page; the moment a human takes ownership
of it, it becomes canonical DB content that only ever flows DOWN.

## Greenfield exception

For a **brand-new site with no real content yet**, a one-time full
dev → staging DB sync at launch is acceptable — there is nothing on staging to
destroy. This is the only sanctioned exception. After launch (once real content
exists anywhere upstream), the seeder is the repeatable, safe default and a DB
push up is again forbidden.

## Cleanup

`wp claudepress unseed` removes **only** seeded placeholders — items carrying the
`_claudepress_seeded = 1` post meta. Placeholder pages are force-deleted and demo
products are removed; real client content is never touched. Like `seed`, it
refuses to run on production.
