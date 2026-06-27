# Website branch — reference

The website branch produces a content-focused WordPress site on Bedrock + Sage
11, with native block editing constrained for safe client self-editing. It does
**not** install WooCommerce.

## Subtypes

The `subtype` answer (`business` | `blog` | `portfolio`) only changes content
presets — the stack, security and quality gates are identical.

| Subtype | Content model | Suggested CPTs / taxonomies | theme.json emphasis |
|---|---|---|---|
| `business` | Marketing/company site: services, about, contact | `service` CPT (optional), page templates for landing/contact | Brand palette, clear heading scale, CTA spacing |
| `blog` | Editorial: posts, categories, tags, RSS | Core `post` + `category`/`post_tag` | Reading measure (`contentSize`), prose typography scale |
| `portfolio` | Showcase/case studies, galleries | `project` CPT, `project_type` taxonomy | Wide/full image layouts, gallery spacing, large media |

The render step picks a small set of starter blocks and a `theme.json` preset per
subtype; everything else is shared.

## Blocks

- Prefer **native block themes / block patterns** over page builders. Sage 11
  supports both Blade-rendered dynamic blocks and `theme.json`-driven static
  blocks.
- Ship a small library of **block patterns** per subtype (hero, services grid,
  post list, project gallery). Patterns are the client-facing building units.
- Custom dynamic blocks (ACF blocks or native `register_block_type`) live under
  the theme; render templates are Blade where dynamic, `block.json` + `render`
  where native.
- Editable regions are exposed as **patterns with locked structure** (see Client
  editing).

## theme.json mapping (Sage 11 generator)

Sage 11's improved `theme.json` generator maps the theme's design tokens
(Tailwind-style scales) into WordPress design tokens. The base `theme.json`
(template `templates/theme.json`, schema version 3) defines:

- **Color palette** — named tokens (`base`, `contrast`, `primary`,
  `secondary`, `accent`, plus neutrals). `settings.color.custom: false` and
  `customGradient: false` so clients can only choose from the palette.
- **Fluid typography** — font sizes via `clamp()` (`fluid: true`), a bounded
  size scale, `customFontSize: false` to prevent arbitrary sizes.
- **Spacing** — a `spacingScale`/`spacingSizes` preset, `customSpacingSize:
  false`.
- **Layout** — `contentSize` and `wideSize` so width is consistent and not
  client-editable.

Mapping rule of thumb: a Tailwind token like `--color-primary` becomes a
`settings.color.palette` entry with `slug: "primary"`, surfaced in the editor as
the "Primary" swatch and as the `var(--wp--preset--color--primary)` CSS variable.

## Client-safe editing (templateLock / contentOnly)

Two complementary mechanisms keep clients editing **content**, not **structure**:

1. **`templateLock`** on a block's `InnerBlocks` (or via
   `block.json`/template definition):
   - `templateLock: "all"` — children cannot be added, removed or reordered.
   - `templateLock: "insert"` — children cannot be added/removed but can be
     reordered.
   - `templateLock: "contentOnly"` — only text/media content is editable; block
     structure and most settings are hidden. This is the default for
     client-facing patterns.
2. **`contentOnly` editing mode** at the template/pattern level locks layout and
   exposes only content fields in the inspector — ideal for marketing pages where
   the agency owns the layout and the client owns the copy/images.

Combine with the restricted client role (`mu-plugins/claudepress-roles.php`):
the client role has `edit_theme_options` removed and the Site Editor / theme
file editor hidden, so they cannot alter global styles or templates even outside
locked blocks.

## Quality gates (same as all branches)

- PHPCS (WPCS) on every edit (fast), PHPStan at the gate, PHPUnit, and — only on
  the e-shop branch — Playwright E2E. The website branch ships
  `tests/phpunit.xml.dist` + `ExampleTest` but no `e2e/checkout.spec.ts`.
