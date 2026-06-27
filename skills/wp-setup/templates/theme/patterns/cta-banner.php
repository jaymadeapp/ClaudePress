<?php
/**
 * Title: ClaudePress — CTA Banner
 * Slug: claudepress/cta-banner
 * Categories: claudepress, featured, call-to-action
 * Block Types:
 * Inserter: true
 * Description: A full-width brand-colored call-to-action band with a headline, short paragraph, and a button.
 * Keywords: cta, call to action, banner, conversion, signup
 * Viewport Width: 1280
 */
?>
<!-- wp:group {"tagName":"section","lock":{"move":true,"remove":true},"align":"full","backgroundColor":"primary","style":{"spacing":{"padding":{"top":"var:preset|spacing|70","bottom":"var:preset|spacing|70","left":"var:preset|spacing|40","right":"var:preset|spacing|40"}}},"layout":{"type":"constrained","contentSize":"720px"}} -->
<section class="wp-block-group alignfull has-primary-background-color has-background" style="padding-top:var(--wp--preset--spacing--70);padding-right:var(--wp--preset--spacing--40);padding-bottom:var(--wp--preset--spacing--70);padding-left:var(--wp--preset--spacing--40)">
	<!-- wp:heading {"textAlign":"center","textColor":"base","fontSize":"xx-large","fontFamily":"heading"} -->
	<h2 class="wp-block-heading has-text-align-center has-base-color has-text-color has-xx-large-font-size has-heading-font-family">Ready to launch your website?</h2>
	<!-- /wp:heading -->

	<!-- wp:paragraph {"align":"center","textColor":"surface","style":{"spacing":{"margin":{"top":"var:preset|spacing|20"}},"elements":{"link":{"color":{"text":"var:preset|color|surface"}}}},"fontSize":"large","fontFamily":"body"} -->
	<p class="has-text-align-center has-surface-color has-text-color has-link-color has-large-font-size has-body-font-family" style="margin-top:var(--wp--preset--spacing--20)">Join the businesses already growing online with a site they are proud of. It only takes a few minutes to get started.</p>
	<!-- /wp:paragraph -->

	<!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"},"style":{"spacing":{"margin":{"top":"var:preset|spacing|40"}}}} -->
	<div class="wp-block-buttons" style="margin-top:var(--wp--preset--spacing--40)">
		<!-- wp:button {"backgroundColor":"base","textColor":"primary","style":{"elements":{"link":{"color":{"text":"var:preset|color|primary"}}}}} -->
		<div class="wp-block-button"><a class="wp-block-button__link has-primary-color has-base-background-color has-text-color has-background has-link-color wp-element-button">Get started today</a></div>
		<!-- /wp:button -->
	</div>
	<!-- /wp:buttons -->
</section>
<!-- /wp:group -->
