# ClaudePress design system

The design system is what makes a ClaudePress site look **designed**, not "stock
WordPress". It is a single token contract expressed as `theme.json`, a bundled
block-pattern library, section-style colorways, and self-hosted fonts — all
rendered into the Sage 11 theme by `scaffold.sh` Step 4e. An agent (wp-designer →
wp-engineer) composes pages from these; it never hand-rolls colors, spacing, or
type. Read this before any visual/theme work.

## How it loads (Sage 11)

- Our `theme.json` is **authoritative**. Sage's Vite build (`npm run build`) reads
  it, merges it with the Tailwind `@theme` tokens (base-wins on slug dedupe), and
  emits the final `theme.json` WordPress reads. **You must run `npm run build`
  after editing `theme.json` / tokens / fonts** for changes to take effect.
- `theme.json`, `patterns/`, `styles/` and `fonts/` live at the **theme root**
  (`web/app/themes/<slug>/`). WP core auto-registers `/patterns/*.php` and
  `/styles/*.json` — no wiring. Fonts sit at the theme root (not `resources/`, which
  Vite content-hashes) so `theme.json`'s `file:./fonts/...` srcs resolve.
- The Tailwind `@theme` block in `resources/css/app.css` mirrors the same tokens so
  Tailwind utilities (`bg-primary`, `text-contrast`, `p-50`) and WP presets never
  drift. **`theme.json` is the single source of truth — keep the mirror in sync.**

## The token contract

Patterns, styles, and CSS reference tokens **by slug only**. Never hardcode a hex or
px (layout container widths and `1px` hairlines are the only exceptions).

### Color — 10 palette slugs

| slug | role | use via |
|---|---|---|
| `base` | page background | `has-base-background-color` / `var:preset|color|base` |
| `surface` | alt section background (warm off-white) | `has-surface-background-color` |
| `surface-2` | deep section / footer (dark) | pair with `base` text |
| `contrast` | primary text / on-base | `has-contrast-color` |
| `contrast-2` | muted / secondary text | |
| `primary` | brand | buttons, links, brand sections |
| `primary-hover` | darker brand (hover/active) | button `:hover` |
| `secondary` | supporting | |
| `accent` | highlight — use **sparingly** | one focal element per view |
| `border` | hairlines | `var:preset|color|border` |

All pairings are WCAG-AA verified (text on `base`/`surface` ≥ 4.5:1; white on
`primary`/`accent` buttons ≥ 4.5:1). The **per-subtype preset** swaps the palette
(`templates/theme-presets/<subtype>.json`) — business (teal-green + terracotta),
blog (warm editorial reds), portfolio (high-contrast neutral + vivid accent),
shop. Palettes are derived on **perceptually-uniform OKLCH ramps** (even lightness
/ chroma steps), not ad-hoc hex — when you add a color, generate it the same way and
re-check contrast. `accent` darkens for AA where needed; a lighter
`--wp--custom--accent-on-dark` is provided for accent-on-dark links.

### Typography

- Font families are generic slugs — `heading`, `body`, `mono` — so patterns use
  `var:preset|font-family|heading` regardless of subtype. The preset swaps the
  actual face (business: Geist/Inter; blog: Fraunces/Newsreader; portfolio &
  shop: Space Grotesk/Inter). All are self-hosted OFL variable woff2 (`100 900`,
  `display: swap`), GDPR-clean — never hotlink Google Fonts.
- Sizes are a fluid `clamp()` modular scale (~1.25 ratio): `small`, `medium`
  (body), `large`, `x-large`, `xx-large`, `huge` (display). `customFontSize` is
  locked off for clients.

### Spacing, radius, shadow

- Spacing is one fluid rhythm: `10` (2xs) … `80` (3xl). `blockGap` and root padding
  default to `40`. Use `var:preset|spacing|NN` — never a raw px gap.
- `var:custom|radius|sm|md|lg|pill` and `var:custom|shadow|sm|md|lg` (also exposed
  as native `theme.json` shadow presets) give a consistent radius/elevation language.
- Two tasteful gradients (`brand-fade`, `warm-surface`) — both token-derived, no
  default purple.

## Composing a page (the workflow)

1. **wp-designer** picks ONE aesthetic direction + one defensible risk, rejects the
   AI-slop defaults, and writes the token spec + which patterns compose each
   template. (See `skills/design-review/reference/design-principles.md`.)
2. **wp-engineer** composes the page from the bundled patterns and applies a
   **section style** (`Section: Inverse` / `Brand` / `Soft`) to a Group/Columns
   block for rhythm and contrast between bands. Only author a new pattern when
   nothing composes — token-driven, client-safe (`lock` the wrapper, leave content
   editable), like the existing ones.
3. **design-review loop** renders it, screenshots 3 viewports, scores the rubric +
   objective checks, and returns token/pattern fixes until it PASSes.

## Bundled assets

- `patterns/` — hero (centered/split), features grid, pricing, testimonials, CTA,
  logo cloud, footer; blog (post list, newsletter CTA); portfolio (project gallery,
  case-study hero). All token-driven, no external images.
- `styles/` — `section-inverse`, `section-brand`, `section-soft` (block style
  variations for Group/Columns) + an optional bold global variation.
- `fonts/` — Inter, Geist, Geist Mono, Space Grotesk, Fraunces, Newsreader (OFL-1.1,
  each with its `OFL.txt`).

## Licensing

The design assets (`theme.json`, `patterns/`, `styles/`, the `app.css` block,
`mu-plugins/claudepress-design.php`) are **GPL-2.0-or-later** — they adapt
core-block markup and live in a WordPress theme. The fonts are **OFL-1.1** (each
ships its license). The rest of the kit's tooling/agents remains MIT.
