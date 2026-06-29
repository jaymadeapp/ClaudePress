# WooCommerce (e-shop) branch — reference

The e-shop branch adds WooCommerce on top of the website stack, with a hard
data-safety gate around orders and payments. Subtypes are `small-shop` (real
checkout) and `catalog` (browsing, checkout optional/disabled).

## HPOS (High-Performance Order Storage)

- **HPOS is enabled.** Orders live in dedicated tables (`wc_orders`,
  `wc_orders_meta`, `wc_order_addresses`, `wc_order_operational_data`), not in
  `wp_posts`/`wp_postmeta`.
- HPOS behavior is **engine-specific**: it relies on MySQL/MariaDB transactional
  and indexing semantics. This is why the e-shop branch **forbids SQLite** and
  requires `db_engine ∈ {mysql, mariadb}` with `db_requirement: "mysql"`.
- Declare HPOS compatibility for any custom plugin/theme code via
  `FeaturesUtil::declare_compatibility( 'custom_order_tables', ... )`.

## CRUD-only access to orders

- Read/write orders **only through the WooCommerce CRUD API**: `wc_get_order()`,
  `wc_get_orders()`, `$order->save()`, `WC_Order` / `WC_Order_Query`,
  `wc_create_order()`. Never run raw SQL against the order tables — raw SQL
  bypasses HPOS sync, hooks and data integrity.
- `wp-engineer` and `wp-security-reviewer` enforce this: any raw SQL touching
  `wc_orders*` / `wp_woocommerce_order*` is a critical finding.

## Orders & payment data are NEVER deployed

- Orders, customers and payment data are **never committed and never deployed**.
  They are production-only content and follow the two-lane invariant: **DB goes
  DOWN only** (pull from production to local), never up.
- `guard-woo-data.sh` (PreToolUse, fail-closed) blocks any Bash/Write/Edit that
  touches order tables, exported `orders.csv`/`orders.sql`, or payment-gateway
  data. See `reference/two-lane.md`.

## MySQL-only CI

- CI runs against **MySQL/MariaDB only**. SQLite is never used for the e-shop —
  order/HPOS behavior would diverge and give false green builds.
- `phpstan.neon` and the CI notes in `CLAUDE.md` state the engine requirement
  explicitly. `wp-tester` verifies the active engine before trusting results.

## Payment / checkout human-gate

- **Any change to checkout, cart totals or payment gateways requires an explicit
  HUMAN GATE before merge.** `wp-security-reviewer` must sign off; an automated
  merge of such a change is forbidden.
- `guard-woo-data.sh` matches `payment(s)?[ _-]?gateway` and checkout paths and
  blocks the action, surfacing the human-gate requirement.
- The Playwright E2E spec (`tests/e2e/checkout.spec.ts`) runs the cart→checkout
  flow against **MySQL + Stripe test mode** so checkout regressions are caught
  without touching real payments.

## Shop Manager role restriction

- The default WooCommerce `shop_manager` role is **restricted**: on `init` the
  MU-plugin removes `edit_theme_options` from `shop_manager` (and from the
  custom client role), and hides the Site Editor / theme-file editor submenus, so
  store staff cannot alter global theme structure.
- The restricted client role registered by `mu-plugins/loamkit-roles.php`
  has no order-management or payment capabilities beyond what the project
  explicitly grants.
- The local WordPress MCP server runs **STDIO via WP-CLI** (the `WordPress/mcp-adapter`
  plugin, `ddev wp mcp-adapter serve ... --user=loamkit-mcp`) and authenticates
  **AS** the user `loamkit-mcp`. There is **no application password** locally;
  that user's role `loamkit_mcp` is the only boundary, so it is **content-only**
  and **must exclude order/payment capabilities** (no `manage_woocommerce`,
  `edit_shop_orders`, order read/refund). `scripts/setup-mcp.sh` provisions this
  role/user automatically and defensively strips any forbidden cap. No agent flow
  may read or mutate payment data (see `templates/mcp/woocommerce.json`). A remote
  site would instead use the HTTP-proxy + Application Password fallback — but the
  autonomous agent works against LOCAL only, never prod.
