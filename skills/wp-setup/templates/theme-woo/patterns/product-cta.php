<?php
/**
 * Title: Loamkit — Product CTA Band
 * Slug: loamkit/product-cta
 * Categories: loamkit, woocommerce, featured, call-to-action
 * Block Types:
 * Inserter: true
 * Description: A full-width brand-colored conversion band — the one centered moment — with an eyebrow, a headline carrying a Fraunces italic accent, a short supporting line, and a pill shop call-to-action.
 * Keywords: cta, call to action, shop, conversion, promo, woocommerce, landing
 * Viewport Width: 1280
 */
?>
<!-- wp:group {"tagName":"section","lock":{"move":true,"remove":true},"align":"full","backgroundColor":"primary","style":{"spacing":{"padding":{"top":"var:preset|spacing|70","bottom":"var:preset|spacing|70","left":"var:preset|spacing|40","right":"var:preset|spacing|40"}}},"layout":{"type":"constrained","contentSize":"720px"}} -->
<section class="wp-block-group alignfull has-primary-background-color has-background" style="padding-top:var(--wp--preset--spacing--70);padding-right:var(--wp--preset--spacing--40);padding-bottom:var(--wp--preset--spacing--70);padding-left:var(--wp--preset--spacing--40)">
	<!-- wp:paragraph {"align":"center","textColor":"secondary","style":{"typography":{"textTransform":"uppercase","letterSpacing":"0.1em"},"elements":{"link":{"color":{"text":"var:preset|color|secondary"}}}},"fontSize":"small","fontFamily":"mono"} -->
	<p class="has-secondary-color has-text-color has-link-color has-small-font-size has-mono-font-family" style="letter-spacing:0.1em;text-transform:uppercase">A small new ritual</p>
	<!-- /wp:paragraph -->

	<!-- wp:heading {"textAlign":"center","textColor":"base","fontSize":"xx-large","fontFamily":"heading"} -->
	<h2 class="wp-block-heading has-text-align-center has-base-color has-text-color has-xx-large-font-size has-heading-font-family">Begin something <em class="has-display-font-family" style="font-style:italic;font-weight:400;color:var(--wp--custom--color--accent-ink, var(--wp--preset--color--accent))">slower</em> today</h2>
	<!-- /wp:heading -->

	<!-- wp:paragraph {"align":"center","textColor":"surface","style":{"spacing":{"margin":{"top":"var:preset|spacing|20"}},"elements":{"link":{"color":{"text":"var:preset|color|surface"}}}},"fontSize":"large","fontFamily":"body"} -->
	<p class="has-surface-color has-text-color has-link-color has-large-font-size has-body-font-family" style="margin-top:var(--wp--preset--spacing--20)">Pieces worth living with, made to last. Free shipping on your first order, and 30 days to change your mind.</p>
	<!-- /wp:paragraph -->

	<!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"},"style":{"spacing":{"margin":{"top":"var:preset|spacing|40"}}}} -->
	<div class="wp-block-buttons" style="margin-top:var(--wp--preset--spacing--40)">
		<!-- wp:button {"backgroundColor":"base","textColor":"primary","style":{"elements":{"link":{"color":{"text":"var:preset|color|primary"}}},"border":{"radius":"var:custom|radius|pill"}}} -->
		<div class="wp-block-button"><a class="wp-block-button__link has-primary-color has-base-background-color has-text-color has-background has-link-color wp-element-button" style="border-radius:var(--wp--custom--radius--pill)">Shop the collection</a></div>
		<!-- /wp:button -->
	</div>
	<!-- /wp:buttons -->
</section>
<!-- /wp:group -->
