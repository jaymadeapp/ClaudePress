# Design principles — the design brief Claude can act on

This is the taste the **wp-designer** reads before setting a brief and before scoring. It
encodes *which* choices read as crafted vs. generic, and the rules every choice obeys. It
is opinionated on purpose: stock WordPress and generic AI output are the **failure state**.

---

## 0 — HARD-FAIL gate (automatic Critical FAIL on sight)

These six rules sit **above** the 8-dimension rubric. They are not scored 0–3 — a render that
trips **any** of them is an **automatic FAIL** in the design-review verdict, even if every
rubric dimension would otherwise read ≥ 2. They exist because the AI-slop failure state can
hit "technically clean" numbers while still looking like generic template output. Check these
first, against the desktop **and** mobile screenshots, before scoring anything.

| # | HARD-FAIL — render is rejected if… | Why it fails | Fix direction (tokens/patterns) |
|---|---|---|---|
| **H1** | **Centered-symmetric hero.** The above-the-fold hero is a single centered column (centered headline + centered subhead + centered button stack, mirror-symmetric). | The default AI/stock-WP composition; signals "no point of view". The hero MUST be **asymmetric / editorial** — offset content, a split, an overlapping subject, a sidebar eyebrow. | Use `hero-split` (or an offset variant), not `hero-centered`, for the landing hero; lead with an asymmetric column ratio and one anchored visual subject. |
| **H2** | **Visible placeholder.** Any `replace me` / `lorem` / dashed-border box / empty colored rectangle / "image goes here" block is visible in the render. | Ships an unfinished page. Premium output never shows scaffolding. | Replace with a bundled image (`/images/*`), the framed-image component, or an organic shape token — never a bare box. |
| **H3** | **Single-weight headline wall.** Headings render at one uniform weight (typically `700`) with no weight/size/style contrast between H1 → H2 → eyebrow. | Flat hierarchy; the eye has no anchor; reads as undesigned. | Step the scale (`huge`→`x-large`→`small` eyebrow) AND contrast weight/style — e.g. display H1, lighter subhead, tracked-caps eyebrow. |
| **H4** | **Bordered-square-centered product/feature cards.** Cards are hard-bordered squares with centered content on a flat even grid (the stock Woo / bootstrap card). | The generic card; not premium. Cards must read **portrait / soft** — taller-than-wide, soft `radius` + `shadow`, image-led, content left-aligned. | Use the premium card pattern: portrait media, `var:custom|radius|md`+`shadow|sm`, no hard 1px square border; vary the grid (lead/featured card) rather than N identical squares. |
| **H5** | **No real visual subject above the fold.** The first viewport is type-on-flat-color only — no photographic image, illustration, framed media, or organic/geometric shape. | A wall of text with no focal material reads as a draft, not a designed page. | Anchor the fold with a bundled image, the framed-image/duotone component, or an organic shape token (the kit ships these) as the hero's visual subject. |
| **H6** | **Hotlinked external images.** Any `<img src>` / `background-image` points at an external/`http(s)://` host instead of a bundled local asset. | Breaks offline/privacy/perf and is a hotlink the site doesn't control; also the "generic stock photo" tell. | Use only bundled `/images/*` assets (the CC0 set) referenced by local/theme URL; never hotlink. |

A hard-fail is reported in the standard defect format and ordered **first** in the FAIL list,
e.g. `home@1440: centered-symmetric hero (HARD-FAIL H1) → recompose on hero-split, offset H1,
anchor the framed hero image left`. The engineer must clear **every** hard-fail before the
render can return to the rubric for a PASS attempt. These layer **on top of** the rubric and
objective gates below — they never replace them.

---

## 1 — Pick ONE named direction and commit
Choose a single direction, name it, justify it against the audience/brief, and hold the
whole site to it. Mixing two is how a site reads as generic.

- **editorial-serif** — a real display serif for headings (Fraunces) over a readable serif/
  humanist body (Newsreader). Large reading size, generous measure, strong article
  hierarchy. For blogs, writers, journalism. *Risk move:* an oversized `huge` drop-style H1.
- **warm-minimal** — restrained neutrals + one warm accent, lots of whitespace, quiet type
  (Geist/Inter), hairline `border` dividers. The kit's business default. For services,
  studios, B2B. *Risk move:* a single confident `accent` (terracotta) used once per view.
- **brutalist** — high contrast, heavy weights, visible grid, sharp `radius:sm` or none,
  oversized type, raw alignment. For portfolios, agencies, statements. *Risk move:*
  asymmetric layout and intentionally bare structure.
- **luxury** — deep `surface-2` backgrounds, fine type with airy tracking, sparing gold/warm
  accent, slow rhythm, lots of negative space. For premium brands, hospitality. *Risk
  move:* near-black `section-inverse` hero with a single small CTA.
- **retro-futuristic** — confident geometric sans (Space Grotesk), saturated-but-controlled
  accent, subtle gradient (from the contract's tokens only), mono (`Geist Mono`) labels. For
  tech/product. *Risk move:* a mono eyebrow + tracked-out caps labels.
- **technical / clean** — Space Grotesk/Inter, tight grid, mono for data, restrained color,
  precise spacing. For SaaS, docs, dashboards. *Risk move:* a data-dense section that still
  breathes.

After choosing, take **one defensible aesthetic risk** and be ready to defend it. Timid is
also a failure mode.

---

## 2 — The AI-slop reject-list (these are defects on sight)
- Predictable **purple/blue gradients** (the "AI startup" look). Use the contract's two
  token gradients (`brand-fade`, `warm-surface`) sparingly or not at all.
- **Unmodified system fonts** / silent system-font fallback. Intended `heading`/`body`
  must actually render (this is also an objective gate).
- **Perfectly even grids everywhere** — every section a 3-up of identical cards. Vary
  rhythm; let one element lead.
- **Default WP button shapes** — square, unstyled, default-blue. Buttons use `primary` bg,
  `base` text, `radius:md`, defined hover/focus.
- **16px-everything** — one size for all text. Step the modular scale.
- **Centered single column the whole way down** — no compositional point of view.
- **Stocky symmetrical hero with a generic stock photo** — prefer color/cover blocks or an
  intentional image treatment over a hotlinked stock image.

---

## 3 — Token discipline (only the contract's preset vars)
Every value is a **theme.json token from the design contract**. The engineer emits **only**
preset vars; the designer specs only in slugs. A literal px/hex in the render that didn't
resolve from a CSS var is a **token leak** = defect.
- **Color** (10 slugs): `base, surface, surface-2, contrast, contrast-2, primary,
  primary-hover, secondary, accent, border`. Text/UI must meet WCAG (objective).
- **Type families:** `heading, body, mono`. **Sizes:** `small, medium, large, x-large,
  xx-large, huge`.
- **Spacing:** `10, 20, 30, 40, 50, 60, 70, 80` (`var:preset|spacing|50`).
- **Radius:** `var:custom|radius|sm|md|lg|pill`. **Shadow:** `var:custom|shadow|sm|md|lg`.
- **Gradients:** the two named tokens only. No off-token hue.
If a needed value has no slug, the **token set is wrong** — fix the spec/contract, never
hardcode.

---

## 4 — Compose, don't generate
Specify pages as **compositions of the bundled patterns + section styles**, not bespoke
markup.
- **Patterns:** `hero-centered, hero-split, features-grid, pricing-table, testimonials,
  cta-banner, logo-cloud, footer-columns` (+ blog `post-list, newsletter-cta`; portfolio
  `project-gallery, case-study-hero`).
- **Apply a section style for rhythm** — this is the key cadence move. Alternate
  `section-soft` (warm `surface`), `section-brand` (`primary`), and `section-inverse`
  (deep `surface-2`) down the page so the scroll has a beat instead of one flat background.
  E.g. hero (base) → features (`section-soft`) → CTA (`section-brand`) → testimonials
  (base) → footer (`section-inverse`).
- Only spec a **NEW** pattern when nothing composes — then describe it in tokens + block
  structure with a one-line justification of why no existing pattern fits.

---

## 5 — Typography craft
- **Real pairings**, not one family doing everything: e.g. editorial Fraunces + Newsreader;
  warm-minimal Geist + Inter; technical Space Grotesk + Inter. Contrast the pair (display vs
  text, or geometric vs humanist) so hierarchy is legible.
- **Modular scale** — sizes step on a ratio (~1.25 major third per the contract); don't
  invent in-between sizes off-scale.
- **Measure 45–75ch** — cap body line length (the contract sets `max-width: ~70ch`); full-
  bleed paragraphs are a defect.
- **Leading & tracking** — headings ~1.1–1.15 line-height with slight negative letter-
  spacing on display sizes; body ~1.6. Use `text-wrap: balance` on headings, `pretty` on
  body.

---

## 6 — Spacing rhythm
- Everything off the `spacing` scale; consistent section padding; **proximity** groups
  related elements and separates unrelated ones.
- Establish a **vertical rhythm** you can feel — uniform section padding (`spacing|70/80`
  for major sections), tighter inner gaps (`spacing|30/40`). No random or cramped gaps.

---

## 7 — Color intent
- One **cohesive palette** — the warm OKLCH set reads as a single system; don't introduce
  hues outside the slugs.
- **Accent is sparing** — `accent` (terracotta) is a highlight: one CTA, one underline, one
  marker per view. Accent everywhere = no accent.
- **Contrast is non-negotiable** (objective gate). If a pairing fails WCAG, darken the
  *token*, never relax the rule.
- Use `secondary` for support, `contrast-2` for muted/meta text, `border` for hairlines —
  each slug to its role.

---

## 8 — Whitespace & composition
- Treat negative space as a material — generous, intentional, not leftover.
- Make at least **one confident compositional move** per page (asymmetry, an offset, a
  full-bleed `section-inverse` band) instead of everything centered and evenly spaced.
- Crisp alignment; a real grid; balance over symmetry.

---

## Using this as a brief
When directing: state the **named direction**, the **one risk**, the **token roles** (which
slug carries which job), and the **per-template composition** (pattern list + section-style
cadence). When critiquing: every gap from these principles becomes a defect in the form
`screen@viewport: defect → token/pattern fix` — always actionable, always in tokens.
