<?php
/**
 * Loamkit — classic get_header() bridge.
 *
 * Sage 11 renders normal routes through resources/views/layouts/app.blade.php and
 * never loads this file. But WooCommerce (and some plugins) call get_header() /
 * get_footer() directly; without a header.php / footer.php WordPress falls back to
 * its minimal theme-compat chrome, so the store would lose the Terra header/footer.
 * These bridge files render the SAME Blade sections so WooCommerce pages get the
 * identical site chrome as the rest of the site. The Blade partials use only WP
 * functions (no view-composer data) so they render standalone here.
 */
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?php wp_head(); ?>
  <?php
  /*
   * Sage 11 injects its Vite-built stylesheet via the @vite directive INSIDE the
   * Blade layout, which classic WooCommerce pages bypass — so the theme stylesheet
   * (Terra tokens + .cp-site-header / .cp-site-footer chrome) isn't loaded here.
   * Load the built app CSS straight from the build dir so WooCommerce pages get
   * the same chrome + design tokens. (Only runs on classic get_header() pages, so
   * there is no double-load on normal Sage routes.)
   */
  foreach (glob(get_theme_file_path('public/build/assets/app-*.css')) ?: array() as $cp_css) {
      printf("\n  <link rel=\"stylesheet\" href=\"%s\">", esc_url(get_theme_file_uri('public/build/assets/' . basename($cp_css))));
  }
  ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<?php
if (function_exists('Roots\\view')) {
    echo \Roots\view('sections.header')->render();
}
