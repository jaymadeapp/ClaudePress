# Design-review rubric

Eight dimensions, each scored **0–3**. **PASS bar = every dimension ≥ 2, all objective
checks green, zero Critical findings**, and the accessibility floor clear. The critic
(wp-designer) scores the **subjective** dimensions; the **objective** ones are measured in
the browser / Lighthouse and read as fact — the critic never re-judges a measured number.

**Score scale (subjective dims):** 0 = stock-WP / AI-slop failure state · 1 = generic, no
point of view · 2 = intentional and clean, defensible · 3 = distinctive, crafted, on-brief.

**Defect format (mandatory for every defect):** `screen@viewport: defect → token/pattern fix`.
Every defect names a **token or pattern** change for the engineer — never "make it nicer".
Good: `home@375: H1 fell back to system font → engineer: enqueue display font in theme.json`.
Good: `pricing@1440: cards sit on a flat even grid, no emphasis → apply section-soft + raise
featured card to var:custom|shadow|lg`. Bad: `home: hero looks boring`.

**Severity:** **Critical** = blocks PASS on its own (any objective hard-fail, or a dimension
at 0). **Major** = drags a dimension to 1. **Minor** = polish nit, note it but it alone
won't fail the bar.

---

## 1 — Visual hierarchy  · SUBJECTIVE (critic)
The eye lands where it should: one clear focal point per section, deliberate size/weight/
color contrast between H1 → H2 → body → meta, primary action obvious.
- **3 looks like:** instant focal point; type scale steps read as a designed system; the
  primary CTA is unmistakable without being loud; secondary content recedes on purpose.
- **Checked by:** critic, against desktop + mobile screenshots. Cross-check the type-scale
  steps against the `huge/xx-large/x-large/large/medium/small` size slugs.
- **Anchor — this is a 3:** hero H1 at `huge`, eyebrow at `small`/`contrast-2`, body at
  `medium`, one solid `primary` CTA — clear 1-2-3 read.
  **this is a 1:** H1, subhead, and body all near the same size/weight; CTA is a plain link;
  nothing pulls the eye first.

## 2 — Spacing rhythm  · SUBJECTIVE (critic)
Spacing comes from the scale, not eyeballed: consistent section padding, related elements
grouped, a vertical rhythm you can feel.
- **3 looks like:** every gap maps to a `spacing` slug; sections breathe consistently;
  proximity groups related items and separates unrelated ones; no cramped or random gaps.
- **Checked by:** critic for rhythm; **objective token-leak scan** catches off-scale inline
  spacing (those are defects regardless of the critic's read).

## 3 — Typography  · SUBJECTIVE (critic) + OBJECTIVE font-fallback gate
Real pairing, modular scale, comfortable measure (45–75ch), tuned line-height and leading.
- **3 looks like:** a deliberate `heading`/`body` pairing with clear contrast; sizes step on
  the modular scale; body measure ~45–75ch; headings get the slight negative tracking and
  ~1.1–1.15 line-height the contract specifies; `text-wrap: balance/pretty` in effect.
- **Checked by:** critic for craft; **objective** confirms the intended `heading`/`body`
  families actually rendered — a silent system-font fallback is a **Critical** (caps this
  dimension at 0 until fixed).
- **Anchor — this is a 3:** Fraunces display H1 over Newsreader body, sizes clearly stepped,
  paragraphs capped near 65ch — reads like a designed editorial page.
  **this is a 1:** everything in the body font at one size, full-bleed 120ch lines, default
  1.5 leading everywhere — a wall of undifferentiated text.

## 4 — Color & contrast  · OBJECTIVE (measured — hard fail below threshold)
Cohesive palette from the token slugs, accent used sparingly, **and** WCAG contrast met.
- **OBJECTIVE gate (hard fail):** body/normal text ≥ **4.5:1**; large text and UI/non-text
  (icons, borders, button edges) ≥ **3:1**. Anything below is **Critical** — no PASS,
  darken the token (not the rule). Measured per `screen@viewport`.
- **3 also looks like:** palette reads as one intentional system (the warm OKLCH set, not
  random hues); `accent` (terracotta) used sparingly as a highlight, not everywhere; no
  AI-slop purple/blue gradient.
- **Checked by:** objective contrast ratios (gate) + critic for palette cohesion/accent
  discipline (the look).

## 5 — Consistency  · SUBJECTIVE (critic)
One design language site-wide: buttons, cards, links, radii, shadows, and section styles
behave the same everywhere.
- **3 looks like:** buttons share shape/`radius`/hover; cards share `shadow`/padding; the
  three section styles (`section-inverse/brand/soft`) are applied to a consistent intent;
  no one-off component that ignores the system.
- **Checked by:** critic across all templates; token-leak scan flags off-system one-offs.

## 6 — Whitespace / composition  · SUBJECTIVE (critic)
Confident use of negative space and layout: alignment, grouping, and balance — not a
timid centered single column nor a cramped wall.
- **3 looks like:** generous, intentional whitespace; a clear grid with at least one
  confident compositional move (asymmetry, an offset, a full-bleed section) rather than
  everything centered and evenly spaced; alignment is crisp.
- **Checked by:** critic, desktop primarily, sanity-checked at tablet.

## 7 — Responsive  · OBJECTIVE (measured) + critic for reflow quality
Layout holds at every viewport: no overflow, no overlap, touch-friendly.
- **OBJECTIVE gate (hard fail):** **no horizontal overflow and no overlap at 375 and 768**;
  interactive touch targets ≥ **44×44px**. A measured overflow/overlap or an undersized
  target is **Critical**.
- **3 also looks like:** the layout genuinely re-composes for mobile (not just shrunk);
  stacking order makes sense; nothing important is clipped or buried.
- **Checked by:** objective overflow/target measurement (gate) + critic for reflow quality.

## 8 — Polish / details  · SUBJECTIVE (critic) + OBJECTIVE console gate
The finishing pass: hover/focus states, consistent iconography, image treatment, no
visual glitches, **no console errors**.
- **3 looks like:** considered hover/focus on every interactive element; aligned, optically
  balanced details; consistent corner radii and shadows; clean console.
- **Checked by:** critic for the details; **objective** JS console must be clean — console
  **errors are Critical** (warnings are Major/Minor at the critic's read).

---

## Accessibility floor — GATE, not scored
Must all be clear for PASS (a miss is **Critical**, independent of the 8 scores):
- **Heading order** — no skipped levels; one `h1` per page (from the a11y snapshot).
- **Labeled inputs** — every form control has an associated label / accessible name.
- **Focus-visible** — visible focus ring on all interactive elements (no bare `outline:none`).
- **Alt text** — meaningful images have alt; decorative images are empty-alt, not missing.
- **Reduced motion** — animations respect `prefers-reduced-motion`.

---

## Verdict
- **PASS** — every dimension ≥ 2 · all objective checks green · zero Critical · a11y floor
  clear. Exit the loop.
- **FAIL** — emit the defect list (every line `screen@viewport: defect → token/pattern fix`),
  ordered Critical → Major → Minor, and hand it to the orchestrator for an engineer fix
  pass. Repeat up to the loop's 3-iteration cap, then stop and report.
