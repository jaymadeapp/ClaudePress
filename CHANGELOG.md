# Changelog

All notable changes to ClaudePress are documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.1.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [0.5.0] - 2026-06-29

Design correctness + premium pass, verified end-to-end against the design-review critic. This
release fixes a foundational bug where **the Terra design tokens never fully reached the
rendered site**, makes a fresh scaffold preview as a **finished, designed site out of the box**
(not lorem), and runs the whole build through the critic loop until it passes.

### Fixed

- **Terra tokens now actually apply on the rendered site (foundational).** Sage's Vite
  `wordpressThemeJson` plugin (`disableTailwind*: false`) was **regenerating `theme.json` from
  Tailwind on every `npm run build`** — injecting the entire Tailwind palette (~300 colours, a
  ~114 KB `global-styles` blob) and letting **WordPress's default geometric spacing scale win
  the slug collisions**, so `--wp--preset--spacing--40` rendered **16 px instead of 40 px** and
  the whole Terra rhythm came out at roughly half scale. Fixed by adding
  `settings.spacing.defaultSpacingSizes: false` + `settings.typography.defaultFontSizes: false`
  to `theme.json`, and having `scaffold.sh` patch the theme's `vite.config.js` to set all four
  `disableTailwind*: true` (and correct Sage's hardcoded `base` to the project slug). Result
  (verified live): the full fluid spacing scale applies, the palette is **10 slugs, not 298**,
  and `global-styles` drops **114 KB → ~20 KB**.
- **Store "missing margin".** WooCommerce's classic templates (shop, single product, account,
  classic cart/checkout) rendered their content **edge-to-edge** while the rest of the site was
  constrained. The content wrapper is now re-pointed to a `.cp-store` container with the **same
  wide-size + inset as the header/footer chrome**, and the USP strip moved inside it.
- **The signature Fraunces-italic accent was a faux (synthesized) italic** — only an upright
  woff2 shipped behind a `"normal italic"` face. Bundled the real **Fraunces-Italic variable
  woff2** and split the display `fontFace` into true upright + italic (same fix in the `linen`
  preset). The accent word now renders as a real italic.
- **WCAG-AA contrast.** Section eyebrows (and footer headings) used `secondary` (sage), which
  fails on the warm light surfaces (~3.1:1) and on the primary band (~2.5:1); they now map to a
  passing token per surface (muted `contrast-2` on light, light `sage-tint` on dark). The
  `accent` clay was darkened `#a25f31 → #965729` so base-text-on-accent and accent-as-text both
  clear 4.5:1.
- **Responsive overflow.** `features-bento` + `post-list` used a fixed `columnCount:3` grid that
  never collapsed (horizontal scroll at 768/375); switched to responsive `minimumColumnWidth`.
  Added a global `overflow-x: clip` guard on the document element so a decorative hero blob can
  never spawn a mobile scrollbar.

### Added

- **A finished site out of the box.** The content seeder now **composes the Home / About /
  Services pages from the bundled Terra patterns** (and sets the seeded **Home as the static
  front page**), so a freshly scaffolded site opens on the designed editorial home — not the
  WordPress blog index or a "PLACEHOLDER — replace me" paragraph. Demo **products ship real,
  on-brand copy** (the old placeholder string was a design-review hard-fail). All still
  dev/staging-only, idempotent, and `unseed`-able.
- **Design review is now a MANDATORY build step.** `wp-setup` Step 6 makes the **critic loop the
  final gate** — render every key template at 3 viewports, measure the objective gates, score the
  rubric after the hard-fail gate, fix → re-render until PASS; a build is not "done" until it
  passes. Pairs with the pre-build `frontend-design` commitment skill.
- **Premium store polish** (all token-driven, style-only): the PDP buy box is a **sticky raised
  surface card** with a full-width add-to-cart, a bordered ≥44 px quantity stepper, an accent tab
  underline, trust badges on a tinted strip and a mono SKU/category eyebrow; the shop archive
  gets a **Geist Mono "Catalog" eyebrow + a large Fraunces display title**, a token-styled sort
  `<select>` (custom caret), **ghost/outline product-card CTAs** that fill on hover, a calm
  "Sale" badge, and a condensed mobile USP bar; product titles carry the **Fraunces editorial
  voice** on the PDP.
- **On-brand site icon.** A direction-aware inline-SVG favicon (reads the active palette) is
  emitted when the client hasn't set their own — no more `favicon.ico` 404 in the console.
- Inset-spine unification (one `spacing--40` inset across root, chrome, `.cp-store` and every
  pattern), an H1/H2 weight step, a crisp Fraunces display optical size (`opsz`), and a real
  body measure cap.

### Changed

- The store CTA wall, section rhythm, and several patterns (`cta-band` now asymmetric,
  `testimonials`/`post-list` lead with a featured item) were retuned for editorial variety.
- Doc drift fixed: `design-principles.md`, `frontend-design` and `wp-designer` now reference the
  **actual Terra directions, patterns and gradient tokens** (not the pre-Terra names).

## [0.4.1] - 2026-06-28

Design polish — pushes the v0.4.0 premium system to a finished, "top" feel out of the box
(designed site chrome + a fully-populated demo + hero fixes).

### Added

- **Designed site chrome** — Terra Sage Blade **header + footer** replace the default theme
  chrome: a **sticky, backdrop-blurred header** (brand lockup + primary nav + pill CTA, no-JS
  mobile disclosure) and an **editorial footer** (brand statement, newsletter capture, real nav
  columns, social row, baseline). Installed into the theme by `scaffold.sh` (backs up Sage's
  defaults); the CSS is token-driven. A `header.php` / `footer.php` **bridge** makes
  **WooCommerce pages render the same chrome** (they call the classic `get_header()`/
  `get_footer()` and bypass Sage's `@vite`, so the bridge also loads the built stylesheet), and
  WooCommerce's default sidebar (recent-posts/archives/categories widgets) is removed for a
  clean full-width storefront.
- **Populated demo out of the box** — the content seeder now creates and assigns a **"Primary"
  nav menu** from the seeded pages, gives the demo **products distinct bundled product photos**,
  and sets **hero images** on Home/About — real imagery instead of placeholders. All
  dev/staging-only, idempotent, and guarded; `unseed` cleans them up.

### Fixed

- The hero's **secondary organic blob had zero width** (collapsed) — it now renders the
  overlapping two-blob composition from the approved design.
- The **front page no longer shows Sage's redundant page-title** above the hero (the hero
  pattern carries the headline); inner content pages keep their title.

### Verified (live)

Re-scaffolded a Terra **website** and **e-shop** on DDEV, browser-tested via Playwright: the
sticky Terra header (brand + nav + CTA), the two-blob hero, real lifestyle/product imagery, and
the editorial footer all render; no redundant page title; no horizontal overflow. The store
inherits the chrome plus Terra product cards with real photos. Static gates green.

## [0.4.0] - 2026-06-28

Premium design overhaul — the kit's output went from "clean but generic" to genuinely
premium and art-directed, for both websites and e-shops. New flagship default: **Terra**.

### Added

- **Terra design system (new default)** — a premium warm-organic-wellness `theme.json`:
  sand/cream/ink + sage-olive primary + clay accent palette (WCAG-AA), **Hanken Grotesk**
  (heading+body) + a **Fraunces-italic** display accent + Geist Mono, a big fluid type scale,
  organic-blob + soft-warm-shadow + soft-radius depth tokens, `customDuotone`.
- **6 design directions** — Terra (default) + **Atlas** (restrained-tech), **Linen**
  (editorial-luxury), **Pulse** (bold DTC), **Monolith** (swiss/brutalist), **Aurora**
  (light glass) as `theme.json` presets (`templates/theme-presets/`), each a full palette +
  font set. Self-hosted OFL fonts bundled (Hanken Grotesk, Bricolage Grotesque, Archivo,
  Plus Jakarta Sans + the existing families).
- **Premium pattern library** — risk-on, art-directed website patterns: `hero-organic`
  (asymmetric + organic blobs + Fraunces-italic accent), `features-bento`, `image-band`,
  `feature-rows`, `testimonial-soft`, `cta-band`, `footer-editorial` (real nav + newsletter),
  plus retuned blog/portfolio patterns. The old centered-symmetric patterns were removed.
- **Component utilities + motion** — `.cp-blob`/`.cp-blob-img` (organic shapes), `.cp-frame`
  (framed image with depth), `.cp-reveal` scroll-reveal (IntersectionObserver in the design
  mu-plugin, reduced-motion-safe, never hides content).
- **Bundled imagery** — 8 warm-graded CC0 (Pexels) photos + `LICENSES.md`; client photos
  auto-grade on-brand via the `customDuotone` preset; a branded Woo product placeholder.
- **`frontend-design` skill** (`skills/frontend-design/`) — an original two-pass
  aesthetic-commitment method (commit to one direction + signature element + one risk, then
  self-critique against an AI-slop reject-list) tuned to Sage / `theme.json`.
- **Design-review hard-fail gate** — the `design-review` skill now adapts OneRedOak's MIT
  Playwright-driven live-browser review and adds automatic FAILs: centered-symmetric hero,
  visible placeholder/dashed box, single-weight headline wall, bordered-square-centered product
  cards, no real subject above the fold, hotlinked images. (Credited in `NOTICE`.)
- **Premium e-shop** — Terra product cards (cream surface, **portrait 3/4**, hover image-swap +
  zoom, variant swatches, pill add-to-cart, accent sale pill), sticky PDP buy box + mobile
  add-to-cart bar, store patterns retuned on `woocommerce/product-collection`.

### Changed

- The `theme.json` base is now **Terra**, replacing the generic teal "business" default; the
  old business/blog/portfolio/shop subtype presets were removed (subtype now affects build-type
  only — the design is Terra by default or a chosen direction; the Woo `styles.blocks` folded
  into the base). `scaffold.sh` Step 4e now also overlays `images/`.
- **wp-designer** must commit to a direction, pick a non-default hero composition, use a real
  visual subject (never a placeholder box), make ≥1 asymmetric + ≥1 depth move per page, and
  clear the design-review hard-fails.
- `reference/design-system.md` rewritten for Terra; README + SKILL updated.

### Verified (live)

Two real DDEV scaffolds, browser-tested via Playwright: a Terra **website** (hero-organic +
bento + image-band + testimonial + cta + editorial footer — Hanken/Fraunces, organic blobs,
scroll-reveal, warm palette, no overflow) and a Terra **e-shop** (sand storefront, cream
portrait product cards at `radius-xl`, sage-olive add-to-cart, clay sale pills, ink USP bar —
the store inherits Terra purely through the token contract). Both render premium and match the
approved Terra direction. Static gates green (`claude plugin validate`, `shellcheck`, `php -l`,
JSON, `woo.css` 0 raw hex).

### Licensing

Design assets **GPL-2.0+**; fonts **OFL-1.1**; bundled images under the **Pexels License**
(redistribution OK, no attribution required); the design-review methodology adapts
**OneRedOak/claude-code-workflows (MIT)**, credited in `NOTICE`; the `frontend-design` skill is
**original** (not derived from any proprietary plugin). Tooling/agents/skills remain MIT.

## [0.3.0] - 2026-06-28

E-shop store design — Phase 2 of the design upgrade. The WooCommerce branch now produces
a designed, conversion-aware storefront instead of stock WooCommerce, inheriting the
Phase-1 design tokens (one palette, one font set).

### Added

- **`woo.css` token bridge** (`templates/theme-woo/css/woo.css`, installed to the theme's
  `assets/css/` and **enqueued by the `claudepress-woo.php` mu-plugin after WooCommerce's own
  stylesheet** — `deps: woocommerce-general` — so the brand styling reliably wins) — styles the
  classic WooCommerce shop loop (designed product
  cards with hover lift + an image-less placeholder, token prices, accent sale badge, primary
  add-to-cart, star rating), the single-product layout (gallery/summary, tabs, related),
  breadcrumbs/result-count/ordering, notices, AND the block Cart/Checkout **components**
  (`.wc-block-components-button` / `-text-input` / totals) — every value a `theme.json` token
  CSS var.
- **`claudepress-woo.php` mu-plugin** — declares `add_theme_support('woocommerce')` + the
  gallery features, declares **HPOS** compatibility (`custom_order_tables`), and adds
  display-only conversion touches via hooks (USP bar, PDP trust badges, a 3-col / 9-per-page
  grid). Touches no order/customer/cart-total/payment data.
- **Store block-pattern library** (`templates/theme-woo/patterns/`, 7 patterns) — built on the
  canonical `woocommerce/product-collection` block (card = product-image + `core/post-title` +
  price + rating + sale-badge + button): shop-hero, product-grid, featured-products,
  category-tiles, trust-badges, product-cta, reviews-social-proof. Token-driven, client-safe,
  **no dark patterns** (no fake countdowns / stock / viewer counts — EU DFA + FTC).
- **WooCommerce `theme.json` store tokens** — the `shop` preset now styles the themeable woo
  blocks (price / rating / sale-badge / button) via `styles.blocks` (bug #49739 fixed in WC
  9.4) plus a product image aspect-ratio.
- **Enriched demo products** — the content seeder now creates 6 realistic-but-demo products
  across 3 product categories with 2 on sale (still dev/staging-only, create-if-absent, all
  two-lane guards intact), so the designed store has content to render.
- **`reference/eshop-design.md`** — the store-design model, the classic-render reality, the
  style-only locked-checkout rule, conversion ethics, performance, and the advanced
  Blade-override option.

### Changed

- **`scaffold.sh` Step 4f** (e-shop branch only) overlays the store patterns, appends `woo.css`
  to the Sage `app.css`, and renders the `claudepress-woo` mu-plugin — idempotent +
  non-destructive. The e-shop decision-tree rows in SKILL.md document the overlay.

### Architecture (verified)

- Sage 11 is a **classic theme** (`wp_is_block_theme()` false), so WooCommerce renders store
  pages via the classic PHP template hierarchy. ClaudePress **styles** those (theme.json +
  `woo.css` + hooks + Product-Collection patterns) rather than overriding WC templates —
  update-safe, with no third-party Blade-bridge dependency. The checkout stays the stock,
  hard-locked block, **styled only** — the agent never enters the human-gated payment path.

### Verified (live)

A real `wp-setup` WooCommerce e-shop scaffold on DDEV, built end-to-end: WooCommerce 10.9.1
activated, the theme declares WooCommerce support + HPOS, all 19 `claudepress/*` patterns (12
design + 7 store) registered, and the seeder created 6 demo products across 3 categories (2 on
sale). The shop archive and a product page were browser-verified via Playwright: product cards
render on the `surface` token with the brand `primary` add-to-cart button, `accent` sale badges,
the USP bar (light labels + accent icons on a dark strip) and the PDP trust badges, a clean
3-column grid and no horizontal overflow. This live pass surfaced and fixed the classic
WooCommerce override problem — the store CSS is enqueued **after** WC with targeted specificity,
and it neutralises WC's clearfix `::before`/`::after` (which had become phantom grid cells) and
contains product images via `box-sizing`. Static gates green (`claude plugin validate`,
`shellcheck`, `php -l`, JSON).

## [0.2.0] - 2026-06-28

Design system — Phase 1 of the design upgrade. The agent flow now produces designed,
custom-looking sites instead of "stock WordPress".

### Added

- **Opinionated `theme.json` design system** — replaces the near-empty token-locking
  base with a real system: a 10-slug OKLCH-derived palette (all pairings WCAG-AA
  contrast-verified), a fluid `clamp()` modular type scale, an 8-step spacing rhythm,
  radius/shadow tokens, two non-generic gradients, and self-hosted **OFL variable
  fonts** (Inter, Geist, Geist Mono, Space Grotesk, Fraunces, Newsreader). The
  client-locking flags (`color.custom:false`, `customFontSize:false`, …) are kept.
- **Per-subtype presets** (`templates/theme-presets/{business,blog,portfolio,shop}.json`)
  — palette + font-pairing overrides merged onto the base (business: Geist/Inter teal,
  blog: Fraunces/Newsreader editorial, portfolio & shop: Space Grotesk/Inter).
- **First-party block-pattern library** (`templates/theme/patterns/`, 12 patterns:
  hero ×2, features grid, pricing, testimonials, CTA, logo cloud, footer, plus
  blog/portfolio) — token-driven (only preset vars, zero hardcoded hex/px), client-safe
  (locked layout wrappers, editable content), no external images.
- **Section-style colorways** (`templates/theme/styles/`: inverse, brand, soft + a bold
  global variation) and a token-mirrored Tailwind `@theme` + base-CSS layer
  (`templates/theme/css/app.css.append`).
- **`wp-designer` agent** — a read-only art director (Opus 4.8) that sets the aesthetic
  direction, the `theme.json` token spec and the per-page pattern composition, and is
  the visual critic in the design-review loop.
- **`design-review` skill** — a bounded (max 3-iteration), read-only, screenshot-driven
  loop: render in DDEV → Playwright-capture 3 viewports → score an 8-dimension rubric
  with **objective** checks (contrast, overflow, font-fallback, console, Lighthouse) →
  return `screen@viewport: defect → token/pattern fix` until it PASSes. Ships
  `reference/rubric.md` and `reference/design-principles.md`.
- **`reference/design-system.md`** — the token contract, Sage merge behavior, and the
  compose-from-patterns workflow.

### Changed

- **`scaffold.sh` Step 4e** deterministically renders the whole design system into the
  Sage theme root: the authoritative `theme.json` (base ⊕ subtype preset, with palette +
  fontFamilies merged **by slug** so base-only tokens like `mono` survive a partial
  preset), the `patterns/`, `styles/` and `fonts/` overlays, the `app.css` token block,
  and the `claudepress-design.php` pattern-category mu-plugin. `theme.json` is no longer
  hand-rendered in SKILL.md Step 3.
- **Agents wired for design** — the orchestrator routes visible-UI work through
  wp-designer and gates "done" on the design-review loop; wp-architect defers aesthetics
  to the token system; wp-engineer enforces token discipline (preset vars only, compose
  patterns, treat design defects like test failures); wp-tester gains a Lighthouse
  perf/a11y gate.
- **Architecture (verified):** kept Sage 11 as the theme — its Vite build *merges* our
  authoritative `theme.json` (base-wins on slug dedupe) rather than clobbering it, and
  WP-core auto-loads theme-root `/patterns` and `/styles`; self-hosted fonts live at the
  non-Vite-hashed theme root so `file:./fonts/...` srcs resolve.

### Licensing

- The design-system assets (`theme.json`, `patterns/`, `styles/`, the `app.css` block,
  `mu-plugins/claudepress-design.php`) are **GPL-2.0-or-later**; the bundled fonts are
  **OFL-1.1**; the kit's tooling, agents and skills remain MIT.

### Verified (live)

A real `wp-setup` website scaffold on DDEV, built end-to-end: `scaffold.sh` Step 4e
rendered the design system, and Sage's `npm run build` **merged** our authoritative
`theme.json` into `public/build/assets/theme.json` (the 10-slug palette incl.
`primary-hover` and the self-hosted Geist `fontFace` survived the merge). All 12
`claudepress/*` patterns + the `claudepress` category registered; a pattern-composed
front page rendered with our tokens and self-hosted Inter/Geist (both
`document.fonts` loaded + usable), the brand/inverse section-style bands applied, no
horizontal overflow at 1440 or 390, only a benign favicon 404 in console. Static gates
green: `claude plugin validate`, `shellcheck`, JSON parse, `php -l`.

## [0.1.8] - 2026-06-27

### Added

- **`docs/getting-started.md`** — a verified end-to-end walkthrough (create → bring up →
  MCP → seed → handle a request → deploy).

### Verified (live)

- The content seeder (`wp claudepress seed` / `unseed`) ran live in DDEV on both branches:
  4 placeholder pages + (e-shop) 3 demo products created, re-seed idempotent, unseed removes
  only placeholders and leaves client content. Full web (25/25) and e-shop (31/31) smoke runs
  green; a demo site built by the agent flow was browser-tested end-to-end via Playwright
  (hero + working nav + content pages render; only a benign favicon 404 in console).

## [0.1.7] - 2026-06-27

Post-additions review fixes (content seeder / deploy / intake hardening).

### Fixed

- **Generated `.gitignore`, `content-seed.php` and `.claude/deploy.json` are now actually
  produced.** They were documented as generated but never rendered (Bedrock's own
  `.gitignore` shadowed ours), so `.claude/requests/` PII could be committed. `scaffold.sh`
  now deterministically appends a marker-guarded ClaudePress `.gitignore` block and renders
  the seeder + deploy config (idempotent, non-destructive); the Step-3 docs match.
- **`deploy-staging.sh` protected-branch guard** is no longer bypassable via `refs/heads/main`,
  `Main`, trailing space, etc. — the branch is normalized and structurally validated before the
  check. Push failures print a clear non-fast-forward/auth message; the webhook POST sends a
  JSON content-type + body.
- **Content seeder** — `__()` calls now use the project text domain (was hardcoded
  `'claudepress'`); idempotency keys on a stable `_claudepress_seed_key` so a renamed
  placeholder isn't duplicated on re-seed.
- **Docs match reality** — generated `CLAUDE.md` no longer links plugin-only `reference/*.md`;
  the intake skill can apply a GitHub label (`gh issue edit`); README no longer claims wp-setup
  "never runs itself" (it is auto-invoked).

### Added

- **CI for the kit repo** — `.github/workflows/ci.yml` runs `bash -n`, `shellcheck`, `php -l`,
  JSON validation and the guard self-test on every push/PR.
- **Release tags** `v0.1.0`–`v0.1.7` and CHANGELOG link references for every version.

## [0.1.6] - 2026-06-27

### Changed

- **Tightened the `wp-setup` auto-invoke trigger to WordPress only.** A bare "new
  eshop" / "new website" is not assumed to be WordPress (it could be Shopify, Next.js,
  Laravel, a static site, …). The skill now triggers only when WordPress/WooCommerce is
  named or clear from context, and **confirms the stack is WordPress before scaffolding**
  if there's any doubt — alongside the existing target-directory confirmation.

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

[0.4.1]: https://github.com/jaymadeapp/ClaudePress/releases/tag/v0.4.1
[0.4.0]: https://github.com/jaymadeapp/ClaudePress/releases/tag/v0.4.0
[0.3.0]: https://github.com/jaymadeapp/ClaudePress/releases/tag/v0.3.0
[0.2.0]: https://github.com/jaymadeapp/ClaudePress/releases/tag/v0.2.0
[0.1.8]: https://github.com/jaymadeapp/ClaudePress/releases/tag/v0.1.8
[0.1.7]: https://github.com/jaymadeapp/ClaudePress/releases/tag/v0.1.7
[0.1.6]: https://github.com/jaymadeapp/ClaudePress/releases/tag/v0.1.6
[0.1.5]: https://github.com/jaymadeapp/ClaudePress/releases/tag/v0.1.5
[0.1.4]: https://github.com/jaymadeapp/ClaudePress/releases/tag/v0.1.4
[0.1.3]: https://github.com/jaymadeapp/ClaudePress/releases/tag/v0.1.3
[0.1.2]: https://github.com/jaymadeapp/ClaudePress/releases/tag/v0.1.2
[0.1.1]: https://github.com/jaymadeapp/ClaudePress/releases/tag/v0.1.1
[0.1.0]: https://github.com/jaymadeapp/ClaudePress/releases/tag/v0.1.0
