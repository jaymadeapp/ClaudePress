<?php
/**
 * ClaudePress — classic get_footer() bridge (see header.php).
 *
 * Renders the Terra Blade site footer for WooCommerce / plugin pages that call
 * get_footer() directly, then prints wp_footer() and closes the document.
 */
if (function_exists('Roots\\view')) {
    echo \Roots\view('sections.footer')->render();
}
?>
<?php wp_footer(); ?>
</body>
</html>
