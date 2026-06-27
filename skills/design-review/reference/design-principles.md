# Design principles — the design brief Claude can act on

This is the taste the **wp-designer** reads before setting a brief and before scoring. It
encodes *which* choices read as crafted vs. generic, and the rules every choice obeys. It
is opinionated on purpose: stock WordPress and generic AI output are the **failure state**.

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
