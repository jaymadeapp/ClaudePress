<?php
/**
 * Title: ClaudePress — Product CTA Band
 * Slug: claudepress/product-cta
 * Categories: claudepress, woocommerce, featured, call-to-action
 * Block Types:
 * Inserter: true
 * Description: A full-width brand-colored conversion band for landing pages, with a headline, short supporting line, and a shop call-to-action button.
 * Keywords: cta, call to action, shop, conversion, promo, woocommerce, landing
 * Viewport Width: 1280
 */
?>
<!-- wp:group {"tagName":"section","lock":{"move":true,"remove":true},"align":"full","backgroundColor":"primary","style":{"spacing":{"padding":{"top":"var:preset|spacing|70","bottom":"var:preset|spacing|70","left":"var:preset|spacing|40","right":"var:preset|spacing|40"}}},"layout":{"type":"constrained","contentSize":"720px"}} -->
<section class="wp-block-group alignfull has-primary-background-color has-background" style="padding-top:var(--wp--preset--spacing--70);padding-right:var(--wp--preset--spacing--40);padding-bottom:var(--wp--preset--spacing--70);padding-left:var(--wp--preset--spacing--40)">
	<!-- wp:paragraph {"align":"center","textColor":"surface","style":{"typography":{"textTransform":"uppercase","letterSpacing":"0.08em"},"elements":{"link":{"color":{"text":"var:preset|color|surface"}}}},"fontSize":"small","fontFamily":"heading"} -->
	<p class="has-text-align-center has-surface-color has-text-color has-link-color has-small-font-size has-heading-font-family" style="letter-spacing:0.08em;text-transform:uppercase">Limited release</p>
	<!-- /wp:paragraph -->

	<!-- wp:heading {"textAlign":"center","textColor":"base","fontSize":"xx-large","fontFamily":"heading"} -->
	<h2 class="wp-block-heading has-text-align-center has-base-color has-text-color has-xx-large-font-size has-heading-font-family">The new collection just dropped</h2>
	<!-- /wp:heading -->

	<!-- wp:paragraph {"align":"center","textColor":"surface","style":{"spacing":{"margin":{"top":"var:preset|spacing|20"}},"elements":{"link":{"color":{"text":"var:preset|color|surface"}}}},"fontSize":"large","fontFamily":"body"} -->
	<p class="has-text-align-center has-surface-color has-text-color has-link-color has-large-font-size has-body-font-family" style="margin-top:var(--wp--preset--spacing--20)">Explore the pieces everyone has been waiting for, with free shipping on your first order.</p>
	<!-- /wp:paragraph -->

	<!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"},"style":{"spacing":{"margin":{"top":"var:preset|spacing|40"}}}} -->
	<div class="wp-block-buttons" style="margin-top:var(--wp--preset--spacing--40)">
		<!-- wp:button {"backgroundColor":"base","textColor":"primary","style":{"elements":{"link":{"color":{"text":"var:preset|color|primary"}}}}} -->
		<div class="wp-block-button"><a class="wp-block-button__link has-primary-color has-base-background-color has-text-color has-background has-link-color wp-element-button">Shop the collection</a></div>
		<!-- /wp:button -->
	</div>
	<!-- /wp:buttons -->
</section>
<!-- /wp:group -->
