# E-shop store design

How Loamkit makes a WooCommerce store look **designed**, not stock — while staying
out of the human-gated payment path. This is the store layer on top of the Phase-1
[design system](design-system.md); it inherits the same token contract (one palette,
one font set). Read this for any storefront/PDP/cart visual work.

## Rendering reality (why we style, not template-override)

Sage 11 is a **classic theme** (`app/setup.php` does `remove_theme_support('block-templates')`;
there is no `templates/index.html`, so `wp_is_block_theme()` is false). WooCommerce therefore
renders store pages through the **classic PHP template hierarchy**, not block templates. So:

- We do **NOT** override WooCommerce templates and do **NOT** add a Blade-bridge dependency.
  "Designed" comes from styling + theme.json + patterns + hooks — all self-contained and
  update-safe (no overridden templates to go stale).
- The **checkout stays the stock WooCommerce block, styled only.** Its inner blocks (Payment,
  Shipping, Express, Place Order) are hard-locked by WooCommerce; we never restructure or
  template-override them. This is what keeps the agent out of the `guard-woo-data.sh`
  human-gated path. **Never create `resources/views/woocommerce/checkout/*`.**

## The four levers (all token-driven, scaffolded on the e-shop branch)

1. **theme.json — the `shop` preset** (rendered in scaffold Step 4e). Palette + fonts +
   spacing are inherited. WooCommerce bug [#49739](https://github.com/woocommerce/woocommerce/issues/49739)
   is **fixed (WC 9.4)**, so standalone catalog/product blocks (price, rating, sale badge,
   button) honor `theme.json` `styles.blocks["woocommerce/…"]` — set in `theme-presets/shop.json`.
2. **`woo.css`** (`templates/theme-woo/css/woo.css` → the theme's `assets/css/`, **enqueued by
   the `loamkit-woo.php` mu-plugin AFTER WooCommerce's own stylesheet** — `deps:
   woocommerce-general` — so the brand styling reliably wins without fighting load order or Vite,
   Step 4f). The workhorse: styles the classic shop loop (designed product
   cards, prices, sale badges, add-to-cart, star rating, an image-less placeholder), the
   single-product layout (gallery/summary, tabs, related), breadcrumbs, result-count/ordering,
   notices, **and** the block Cart/Checkout **components** (`.wc-block-components-button`,
   text inputs, totals/order-summary) — every value a token CSS var. The WC Blocks button
   `.wc-block-components-button` is a separate component class from core `.wp-element-button`,
   so it is styled explicitly. Only documented component classes / stable block wrappers are
   targeted — never private nested internals.
3. **`loamkit-woo.php` mu-plugin** (`mu-plugins/loamkit-woo.php.tmpl`, Step 4f).
   Declares `add_theme_support('woocommerce')` + the `wc-product-gallery-*` features, declares
   **HPOS** compatibility (`FeaturesUtil::declare_compatibility('custom_order_tables', …)`), and
   adds display-only conversion touches via hooks — a USP bar (`woocommerce_before_main_content`),
   PDP trust badges (`woocommerce_after_add_to_cart_form`), and a sensible 3-column / 9-per-page
   grid. All output escaped; it touches **no** order/customer/cart-total/gateway data.
4. **Store block patterns** (`templates/theme-woo/patterns/` → theme `/patterns/`, Step 4f).
   Built on the canonical `woocommerce/product-collection` block (card = product-image +
   `core/post-title` + price + rating + sale-badge + button): `shop-hero`, `product-grid`,
   `featured-products`, `category-tiles`, `trust-badges`, `product-cta`, `reviews-social-proof`.
   For designed storefront / category-landing / merchandising **pages** (page content — no
   template override). Token-driven, client-safe (locked wrappers).

## Conversion, done honestly

The patterns and hooks follow evidence-based conversion practice (clear product cards with
review counts, struck-through sale prices, reassurance near add-to-cart, trust signals) but
ship **no dark patterns** — no fake countdowns, no fabricated "X people viewing", no fake
low-stock. (EU Digital Fairness Act + FTC enforcement, 2026.) Keep it that way.

## Two-lane / order-data safety

Everything here is **code (lane UP via git)**: theme.json, CSS, patterns, the theme-support
mu-plugin. None of it reads, writes, or deploys orders, customers, or payment data — so the
`guard-two-lane.sh` / `guard-woo-data.sh` gates are unaffected. Demo products come only from
the dev/staging-only content seeder (`wp loamkit seed`, create-if-absent). Any real change
to checkout, cart totals, or a payment gateway remains a **human gate + `wp-security-reviewer`
sign-off** — design it, flag it, never wave it through.

## Performance (recommended, optional)

E-commerce conversion is speed-sensitive (target CWV: LCP ≤ 2.5s, INP ≤ 200ms, CLS < 0.1). For
a production store, add the WordPress Performance Team's standalone plugins (not bundled, to
keep the install lean — install per project): **Modern Image Formats** (AVIF/WebP),
**Image Prioritizer** (accurate LCP `fetchpriority`) and **Speculative Loading** (instant
category→product nav). Register sensible catalog (~300–400px) and single-product (~600–800px)
image sizes, and keep cart/checkout/my-account excluded from full-page caching.

## Gotchas

- **"Coming Soon" mode.** WooCommerce (Launch Your Store) can hide the storefront behind a
  coming-soon page on a fresh install. Disable it to see the design:
  `wp option update woocommerce_coming_soon no` (scaffold prints this as a next step).
- **Rebuild after token/CSS changes.** `theme.json` + `app.css` (incl. `woo.css`) only take
  effect after the Sage build — `cd <theme> && npm run build`.
- **Specificity.** WooCommerce's component stylesheet loads late; `woo.css` selectors are
  scoped to win. The `design-review` loop asserts the computed add-to-cart background equals
  the `primary` token.

## Advanced (not shipped): deep template overrides

If a specific project needs structural PDP/archive changes beyond CSS, the classic Sage path is
Blade overrides via `generoi/sage-woocommerce` (`wp acorn vendor:publish --tag="woocommerce-template-views"`
→ `resources/views/woocommerce/*.blade.php`). Loamkit does **not** ship this dependency
(it's third-party and historically Sage-10-oriented) — add it deliberately per project, and
still **never** override `checkout/*` (the gated path).
