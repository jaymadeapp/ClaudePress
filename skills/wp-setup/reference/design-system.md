# Loamkit design system — Terra

The design system is what makes a Loamkit site look **designed**, not "stock
WordPress". The default is **Terra** — a premium, art-directed, warm-organic
wellness system (sand / sage-olive / clay), not a generic teal "business" theme.
It is a single token contract expressed as `theme.json`, a bundled premium
block-pattern library, section-style colorways, a small component-utility CSS
layer, bundled CC0 imagery, and self-hosted fonts — all rendered into the Sage 11
theme by `scaffold.sh` Step 4e. An agent (frontend-design → wp-designer →
wp-engineer) composes pages from these; it never hand-rolls colors, spacing, or
type. Read this before any visual/theme work.

## How it loads (Sage 11)

- Our `theme.json` is **authoritative**. `scaffold.sh` deep-merges the **Terra base**
  (`templates/theme.json`) with the chosen **direction preset** (`templates/theme-presets/`,
  palette + fonts slug-merged so base-only tokens survive). Sage's Vite build
  (`npm run build`) then reads it, merges the Tailwind `@theme` tokens (base-wins on slug
  dedupe), and emits the final `theme.json` WordPress reads. **You must run `npm run build`
  after editing `theme.json` / tokens / fonts** for changes to take effect.
- `theme.json`, `patterns/`, `styles/`, `images/` and `fonts/` live at the **theme root**
  (`web/app/themes/<slug>/`). WP core auto-registers `/patterns/*.php` and `/styles/*.json` —
  no wiring. Fonts sit at the theme root (not `resources/`, which Vite content-hashes) so
  `theme.json`'s `file:./fonts/...` srcs resolve.
- The Tailwind `@theme` block (from `templates/theme/css/app.css.append`, appended to Sage's
  `resources/css/app.css`) **mirrors the same Terra tokens** so Tailwind utilities
  (`bg-primary`, `text-contrast`, `p-50`, `rounded-lg`, `shadow-md`, `font-display`) and WP
  presets never drift. **`theme.json` is the single source of truth — keep the mirror in
  sync.** That CSS file also carries the component utilities and base niceties below.

## The Terra token contract

Patterns, styles, and CSS reference tokens **by slug only**. Never hardcode a hex or px
(layout container widths and `1px` hairlines are the only exceptions).

### Color — 10 palette slugs (Terra base)

| slug | value | role |
|---|---|---|
| `base` | `#f1eae0` | page background — warm sand |
| `surface` | `#f7f2e9` | alt section background — lighter warm off-white |
| `surface-2` | `#2c271f` | deep section / footer — dark ink (pair with `base` text) |
| `contrast` | `#2c271f` | primary text / on-base |
| `contrast-2` | `#5d564a` | muted / secondary text |
| `primary` | `#3f4a2e` | brand — sage-olive; buttons, links, brand sections |
| `primary-hover` | `#313a23` | darker brand (hover/active) |
| `secondary` | `#7d8a5c` | supporting — sage |
| `accent` | `#a25f31` | highlight — clay; use **sparingly**, one focal element per view |
| `border` | `#e3d9c8` | hairlines — warm sand border |

`custom.color` ships three warm tints used by patterns and image fills —
`sand-2` (`#e3d3bd`), `sage-tint` (`#d8e0cb`), `clay-tint` (`#ecd3c2`) — exposed as
`var:custom|color|<slug>` and Tailwind `--color-*`. Two token gradients ship: `clay` (a warm
clay diagonal) and `sand-fade` (base→surface). `custom: false` locks the picker to the
palette; `customDuotone: true` is **on** (see imagery).

All Terra pairings are designed for WCAG-AA (text on `base`/`surface`; `base` text on
`primary`/`accent`). When you add a color, keep it on the warm family and re-check contrast.
The **direction preset** swaps the whole palette to one of the six directions below.

### Typography — Hanken / Fraunces / Geist Mono

Font families are generic slugs so patterns use `var:preset|font-family|<slug>` regardless of
direction. Terra's faces:

- **`heading`** + **`body`** — **Hanken Grotesk** (variable `100 900`, `display:swap`). A warm,
  slightly humanist grotesk; carries both UI headings and reading body.
- **`display`** — **Fraunces** (variable, `normal italic`). Used for the **Fraunces-italic
  accent treatment**: a single emphasized word inside an H1 is set in the display serif italic
  in `accent` clay (e.g. the hero `<em class="has-display-font-family">live well</em>`), the
  one editorial flourish against the grotesk. Reach for it sparingly — it is the type-drama
  move, not a body face.
- **`mono`** — **Geist Mono** — eyebrows, tracked-caps labels, data.

All faces are self-hosted OFL variable woff2 (`100 900`, `display: swap`), GDPR-clean — never
hotlink Google Fonts. Sizes are a fluid `clamp()` modular scale: `small`, `medium` (body),
`large`, `x-large`, `xx-large`, `huge` (display). Headings carry tight line-height
(`1.05–1.15`) and negative tracking; H6 is uppercase tracked. `customFontSize` is locked off
for clients.

### Spacing, radius, shadow, depth

- **Spacing** is one fluid rhythm: `10` (2xs) … `80` (3xl). `blockGap` and root padding default
  to `50`. Use `var:preset|spacing|NN` — never a raw px gap.
- **Radius** — Terra is soft/rounded: `var:custom|radius|sm|md|lg|xl|pill`
  (`8 / 14 / 22 / 32 / 999px`). Buttons are pills.
- **Shadow** — **soft warm** elevation, never black: `var:custom|shadow|sm|md|lg`
  (warm brown rgba, e.g. `0 26px 60px -20px rgba(80,55,30,.20)`), also exposed as native
  `theme.json` shadow presets.
- **Blob radii** — `custom.blob.blob1|blob2|blob3` are organic `border-radius` values that
  drive the `.lk-blob*` shapes. `custom.aspectRatio` (`square` / `video` / `portrait`) gives
  consistent media ratios.

### customDuotone

`customDuotone: true` with a bundled **`clay` duotone** preset (`#2c271f` → `#c98a52`). This is
how client photos auto-grade on-brand: a client-swapped image gets the warm-clay duotone and
reads as part of the Terra palette without manual grading (see imagery).

## Component utilities (in `app.css.append`)

Beyond the `@theme` mirror, the appended CSS ships a small, token-driven utility layer plus
safe 2026 base niceties (brand `:focus-visible` ring, warm `::selection`, `text-wrap:
balance/pretty`, comfortable measure, smooth scroll gated on reduced-motion). The Terra
components:

- **`.lk-blob` / `.lk-blob-2` / `.lk-blob-3`** — organic blob shapes; each maps to one of the
  `custom.blob.blob*` radii. Used as gradient/secondary backdrops behind a hero subject.
- **`.lk-blob-img`** — masks an `<img>` into the `blob1` organic shape (`object-fit: cover`).
- **`.lk-frame`** — a soft rounded image frame (`radius|lg` + warm `shadow|lg` + `surface`
  backing) for the framed-image depth treatment.
- **`.lk-reveal`** — **scroll-reveal motion**: fade + 16px rise, staggered via a `--i` custom
  property (`90ms` per step), fully gated behind `prefers-reduced-motion`. Add `.lk-reveal`
  (and `--i`) to a block; it animates in when it enters the viewport.
- The **`.wp-element-button`** also gets a soft lift + shadow-grow on hover (reduced-motion
  safe).

### The reveal mu-plugin (IntersectionObserver)

`mu-plugins/loamkit-design.php` (from `loamkit-design.php.tmpl`) does two things: it
registers the **`loamkit` pattern category** (so the bundled patterns group in the
inserter), and it **footer-prints a tiny dependency-free IntersectionObserver script** that
adds `.is-in` to `.lk-reveal` elements as they scroll into view. It is safe by construction:
for reduced-motion users, or when `IntersectionObserver` is unavailable, it reveals everything
immediately so content is **never** hidden. The CSS half is gated on reduced-motion to match.

## Bundled imagery (CC0/Pexels)

`templates/theme/images/` ships **8 warm, art-directed photos** plus `LICENSES.md` —
`hero.webp`, `lifestyle-1..4.webp`, `product-1..3.webp` (sunlit interiors, wellness, ceramics,
craft still-life). All are sourced under the **Pexels License** (free commercial use, no
attribution required, modification allowed), resized to a max 1600px long edge, **warm-graded**
to the Terra palette, and encoded as WebP. They exist so a fold has a **real subject** — never a
placeholder box (a missing subject is a design-review hard-fail, and a hotlinked external image
is another). To swap in client photos, drop replacements at the same filenames; the theme's
`customDuotone` warm-clay preset keeps client-swapped photos on-brand without manual grading.

## Premium principles

Terra is opinionated on purpose — stock WordPress and generic AI output are the **failure
state**. The premium moves the system is built to make (and that the design-review gate
checks):

- **Risk-on / asymmetric.** Lead with an asymmetric, editorial composition — offset hero,
  split, broken grid, sidebar eyebrow — and take **one** defensible aesthetic risk per page.
  A centered-symmetric hero is a hard-fail; timid is also a failure mode.
- **Real subject, not placeholders.** Anchor the fold with real visual material — a bundled
  image, the framed/duotone treatment, or an organic shape. Never a bare colored box, never a
  "replace me" placeholder, never a hotlinked stock photo.
- **Type drama.** Step both **size and weight/style** across the hierarchy (display `huge` H1 →
  lighter subhead → tracked-caps mono eyebrow), and use the **Fraunces-italic accent word** as
  the one editorial flourish. A single-weight headline wall is a hard-fail.
- **Depth & materiality.** Make ≥ 1 depth move per page — soft warm `shadow` elevation, a
  `section-inverse` band, layered blob overlap, image framing — so the page reads built, not
  flat. Premium cards read portrait / soft (not bordered squares).

These are the planning half of the **frontend-design** skill (PASS 1 commit / PASS 2
self-critique) and exactly what the **design-review** hard-fail gate verifies on the render.

## The six directions

Terra is the **base default**; the other five are alternate **DIRECTION presets** in
`templates/theme-presets/<name>.json` (each a full palette + font swap, slug-merged onto the
Terra base, so all base-only tokens — blobs, tints, shadow, radius unless overridden — survive).
Pick **one** per project and hold the whole site to it.

- **Terra** *(base default)* — warm sand/clay neutrals, sage-olive primary, terracotta accent,
  soft depth, Hanken + Fraunces. Studios, services, lifestyle, food. The safe-but-crafted base.
- **Atlas** — indigo-on-near-black, luminous primary, confident dark UI; Geist + Geist Mono.
  Tech, SaaS, product.
- **Linen** — warm paper, ink-brown contrast, clay primary, zero radius (sharp), slow rhythm;
  Fraunces + Newsreader. Makers, print-adjacent, editorial, hospitality.
- **Pulse** — bright base, high-energy coral primary, big type, fast read; Bricolage Grotesque +
  Inter. Launches, consumer, campaigns.
- **Monolith** — black/white/grey, near-zero hue, sharp `radius:2px`, oversized type; Archivo +
  Inter, Geist Mono display. Agencies, portfolios, brutalist-clean statements.
- **Aurora** — light base, violet primary, airy gradients-from-tokens, soft tech polish; Plus
  Jakarta Sans throughout. Modern SaaS / product marketing that wants warmth without going dark.

A **custom** direction is allowed only when none fits — justify why in one line and still
express it entirely in the kit's token vocabulary (no new ad-hoc system).

## Composing a page (the workflow)

1. **frontend-design (commit)** — before any code: PASS 1 commits to ONE of the six directions
   + a token system + one signature element + one defensible risk + the asymmetry/depth moves;
   PASS 2 self-critiques against the AI-slop reject-list. No pixels until PASS 2 clears.
2. **wp-designer** carries that commitment as the brief: which patterns compose each template,
   the `theme.json` token spec, and which **section style** (`section-soft` / `section-brand` /
   `section-inverse`) bands the scroll. It is the read-only art director.
3. **wp-engineer** composes the page from the bundled **premium patterns**, applying section
   styles for rhythm and the `.lk-*` utilities for depth/motion. Only author a new pattern when
   nothing composes — token-driven, client-safe (`lock` the wrapper, leave content editable),
   like the existing ones.
4. **design-review loop** renders it in a real browser, screenshots 3 viewports, runs the
   **hard-fail gate** (H1 asymmetric hero, H2 no placeholders, H3 weight contrast, H4 premium
   cards, H5 real subject above fold, H6 no hotlinks) + the objective checks (contrast, overflow,
   font-fallback, console, token-leak) + the rubric, and returns token/pattern fixes until it
   PASSes (max 3 iterations).

## Bundled assets

- `patterns/` — premium website set: `hero-organic` (asymmetric hero with Fraunces-italic
  accent + clay/sage blobs), `features-bento`, `image-band`, `feature-rows`, `testimonial-soft`,
  `cta-band`, `footer-editorial`, plus `pricing-table`, `testimonials`, `logo-cloud`,
  `newsletter-cta`; retuned blog (`post-list`) and portfolio (`project-gallery`,
  `case-study-hero`). All token-driven, using only bundled images.
- `styles/` — `section-soft`, `section-brand`, `section-inverse` (block style variations for
  Group/Columns) + `variation-bold` (optional bold global variation).
- `images/` — the 8 warm CC0 WebP photos + `LICENSES.md`.
- `fonts/` — all OFL variable woff2 used by Terra and the five presets: Hanken Grotesk,
  Fraunces, Geist, Geist Mono, Inter, Newsreader, Bricolage Grotesque, Archivo, Plus Jakarta
  Sans, Space Grotesk (each with its `OFL.txt`).

## Licensing

The design assets (`theme.json`, `patterns/`, `styles/`, the `app.css` block,
`mu-plugins/loamkit-design.php`) are **GPL-2.0-or-later** — they adapt core-block markup and
live in a WordPress theme. The fonts are **OFL-1.1** (each ships its license). The bundled
images are under the **Pexels License** (free commercial use, no attribution; provenance in
`images/LICENSES.md`). The rest of the kit's tooling/agents remains MIT.
