<?php
/**
 * Title: ClaudePress — Shop Hero
 * Slug: claudepress/shop-hero
 * Categories: claudepress, woocommerce, featured, banner
 * Block Types:
 * Inserter: true
 * Description: A storefront hero with eyebrow, large headline, supporting paragraph, and two call-to-action buttons on a soft surface band.
 * Keywords: shop, store, hero, banner, woocommerce, headline
 * Viewport Width: 1280
 */
?>
<!-- wp:group {"tagName":"section","lock":{"move":true,"remove":true},"align":"full","backgroundColor":"surface","style":{"spacing":{"padding":{"top":"var:preset|spacing|70","bottom":"var:preset|spacing|70","left":"var:preset|spacing|40","right":"var:preset|spacing|40"}}},"layout":{"type":"constrained","contentSize":"760px"}} -->
<section class="wp-block-group alignfull has-surface-background-color has-background" style="padding-top:var(--wp--preset--spacing--70);padding-right:var(--wp--preset--spacing--40);padding-bottom:var(--wp--preset--spacing--70);padding-left:var(--wp--preset--spacing--40)">
	<!-- wp:paragraph {"align":"center","textColor":"primary","style":{"typography":{"textTransform":"uppercase","letterSpacing":"0.08em"},"elements":{"link":{"color":{"text":"var:preset|color|primary"}}}},"fontSize":"small","fontFamily":"heading"} -->
	<p class="has-text-align-center has-primary-color has-text-color has-link-color has-small-font-size has-heading-font-family" style="letter-spacing:0.08em;text-transform:uppercase">New season is here</p>
	<!-- /wp:paragraph -->

	<!-- wp:heading {"textAlign":"center","level":1,"textColor":"contrast","fontSize":"huge","fontFamily":"heading"} -->
	<h1 class="wp-block-heading has-text-align-center has-contrast-color has-text-color has-huge-font-size has-heading-font-family">Everyday essentials, thoughtfully made</h1>
	<!-- /wp:heading -->

	<!-- wp:paragraph {"align":"center","textColor":"contrast-2","style":{"spacing":{"margin":{"top":"var:preset|spacing|30"}},"elements":{"link":{"color":{"text":"var:preset|color|contrast-2"}}}},"fontSize":"large","fontFamily":"body"} -->
	<p class="has-text-align-center has-contrast-2-color has-text-color has-link-color has-large-font-size has-body-font-family" style="margin-top:var(--wp--preset--spacing--30)">Browse a curated collection built to last, with free shipping over your first order and easy 30-day returns.</p>
	<!-- /wp:paragraph -->

	<!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"},"style":{"spacing":{"margin":{"top":"var:preset|spacing|40"},"blockGap":"var:preset|spacing|20"}}} -->
	<div class="wp-block-buttons" style="margin-top:var(--wp--preset--spacing--40)">
		<!-- wp:button {"backgroundColor":"primary","textColor":"base","style":{"elements":{"link":{"color":{"text":"var:preset|color|base"}}}}} -->
		<div class="wp-block-button"><a class="wp-block-button__link has-base-color has-primary-background-color has-text-color has-background has-link-color wp-element-button">Shop the collection</a></div>
		<!-- /wp:button -->

		<!-- wp:button {"textColor":"primary","className":"is-style-outline","style":{"elements":{"link":{"color":{"text":"var:preset|color|primary"}}}}} -->
		<div class="wp-block-button is-style-outline"><a class="wp-block-button__link has-primary-color has-text-color has-link-color wp-element-button">View new arrivals</a></div>
		<!-- /wp:button -->
	</div>
	<!-- /wp:buttons -->
</section>
<!-- /wp:group -->
