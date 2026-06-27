<?php
/**
 * Title: ClaudePress — Newsletter CTA
 * Slug: claudepress/newsletter-cta
 * Categories: claudepress, featured, call-to-action
 * Block Types:
 * Inserter: true
 * Description: A soft-surface newsletter sign-up band with a headline, supporting line, and a subscribe button ready to wire to a form.
 * Keywords: newsletter, subscribe, email, signup, cta
 * Viewport Width: 1280
 */
?>
<!-- wp:group {"tagName":"section","lock":{"move":true,"remove":true},"align":"full","backgroundColor":"surface","style":{"spacing":{"padding":{"top":"var:preset|spacing|70","bottom":"var:preset|spacing|70","left":"var:preset|spacing|40","right":"var:preset|spacing|40"}}},"layout":{"type":"constrained","contentSize":"640px"}} -->
<section class="wp-block-group alignfull has-surface-background-color has-background" style="padding-top:var(--wp--preset--spacing--70);padding-right:var(--wp--preset--spacing--40);padding-bottom:var(--wp--preset--spacing--70);padding-left:var(--wp--preset--spacing--40)">
	<!-- wp:heading {"textAlign":"center","textColor":"contrast","fontSize":"xx-large","fontFamily":"heading"} -->
	<h2 class="wp-block-heading has-text-align-center has-contrast-color has-text-color has-xx-large-font-size has-heading-font-family">Get the best of our writing</h2>
	<!-- /wp:heading -->

	<!-- wp:paragraph {"align":"center","textColor":"contrast-2","style":{"spacing":{"margin":{"top":"var:preset|spacing|20"}},"elements":{"link":{"color":{"text":"var:preset|color|contrast-2"}}}},"fontSize":"large","fontFamily":"body"} -->
	<p class="has-text-align-center has-contrast-2-color has-text-color has-link-color has-large-font-size has-body-font-family" style="margin-top:var(--wp--preset--spacing--20)">One thoughtful email a month — new articles, ideas, and updates. No spam, unsubscribe anytime.</p>
	<!-- /wp:paragraph -->

	<!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"},"style":{"spacing":{"margin":{"top":"var:preset|spacing|40"}}}} -->
	<div class="wp-block-buttons" style="margin-top:var(--wp--preset--spacing--40)">
		<!-- wp:button {"backgroundColor":"primary","textColor":"base","style":{"elements":{"link":{"color":{"text":"var:preset|color|base"}}}}} -->
		<div class="wp-block-button"><a class="wp-block-button__link has-base-color has-primary-background-color has-text-color has-background has-link-color wp-element-button">Subscribe</a></div>
		<!-- /wp:button -->
	</div>
	<!-- /wp:buttons -->
</section>
<!-- /wp:group -->
