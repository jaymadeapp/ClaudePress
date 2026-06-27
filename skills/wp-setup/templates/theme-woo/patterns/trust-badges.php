<?php
/**
 * Title: ClaudePress — Trust Badges
 * Slug: claudepress/trust-badges
 * Categories: claudepress, woocommerce, featured
 * Block Types:
 * Inserter: true
 * Description: A four-column reassurance strip — free shipping, secure payment, easy returns, and friendly support — each with an inline icon and short label.
 * Keywords: trust, badges, shipping, secure, returns, support, woocommerce
 * Viewport Width: 1280
 */
?>
<!-- wp:group {"tagName":"section","lock":{"move":true,"remove":true},"align":"full","backgroundColor":"surface","style":{"spacing":{"padding":{"top":"var:preset|spacing|50","bottom":"var:preset|spacing|50","left":"var:preset|spacing|40","right":"var:preset|spacing|40"}},"border":{"top":{"color":"var:preset|color|border","width":"1px"},"bottom":{"color":"var:preset|color|border","width":"1px"}}},"layout":{"type":"constrained"}} -->
<section class="wp-block-group alignfull has-surface-background-color has-background" style="border-top-color:var(--wp--preset--color--border);border-top-width:1px;border-bottom-color:var(--wp--preset--color--border);border-bottom-width:1px;padding-top:var(--wp--preset--spacing--50);padding-right:var(--wp--preset--spacing--40);padding-bottom:var(--wp--preset--spacing--50);padding-left:var(--wp--preset--spacing--40)">
	<!-- wp:columns {"style":{"spacing":{"blockGap":{"left":"var:preset|spacing|40"}}}} -->
	<div class="wp-block-columns">
		<!-- wp:column -->
		<div class="wp-block-column">
			<!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|20"}},"layout":{"type":"flex","orientation":"vertical","justifyContent":"center"}} -->
			<div class="wp-block-group">
				<!-- wp:html -->
				<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" style="color:var(--wp--preset--color--primary)" role="img" aria-label="Free shipping" focusable="false"><path d="M3 7h11v8H3z"/><path d="M14 10h4l3 3v2h-7z"/><circle cx="7" cy="18" r="1.6"/><circle cx="17.5" cy="18" r="1.6"/></svg>
				<!-- /wp:html -->

				<!-- wp:paragraph {"align":"center","textColor":"contrast","style":{"spacing":{"margin":{"top":"0","bottom":"0"}}},"fontSize":"medium","fontFamily":"heading"} -->
				<p class="has-text-align-center has-contrast-color has-text-color has-medium-font-size has-heading-font-family" style="margin-top:0;margin-bottom:0">Free shipping</p>
				<!-- /wp:paragraph -->

				<!-- wp:paragraph {"align":"center","textColor":"contrast-2","style":{"spacing":{"margin":{"top":"0"}}},"fontSize":"small","fontFamily":"body"} -->
				<p class="has-text-align-center has-contrast-2-color has-text-color has-small-font-size has-body-font-family" style="margin-top:0">On orders over your first purchase</p>
				<!-- /wp:paragraph -->
			</div>
			<!-- /wp:group -->
		</div>
		<!-- /wp:column -->

		<!-- wp:column -->
		<div class="wp-block-column">
			<!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|20"}},"layout":{"type":"flex","orientation":"vertical","justifyContent":"center"}} -->
			<div class="wp-block-group">
				<!-- wp:html -->
				<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" style="color:var(--wp--preset--color--primary)" role="img" aria-label="Secure payment" focusable="false"><path d="M12 3l7 3v5c0 4.4-3 7.6-7 9-4-1.4-7-4.6-7-9V6z"/><path d="M9 12l2 2 4-4"/></svg>
				<!-- /wp:html -->

				<!-- wp:paragraph {"align":"center","textColor":"contrast","style":{"spacing":{"margin":{"top":"0","bottom":"0"}}},"fontSize":"medium","fontFamily":"heading"} -->
				<p class="has-text-align-center has-contrast-color has-text-color has-medium-font-size has-heading-font-family" style="margin-top:0;margin-bottom:0">Secure payment</p>
				<!-- /wp:paragraph -->

				<!-- wp:paragraph {"align":"center","textColor":"contrast-2","style":{"spacing":{"margin":{"top":"0"}}},"fontSize":"small","fontFamily":"body"} -->
				<p class="has-text-align-center has-contrast-2-color has-text-color has-small-font-size has-body-font-family" style="margin-top:0">Encrypted checkout you can trust</p>
				<!-- /wp:paragraph -->
			</div>
			<!-- /wp:group -->
		</div>
		<!-- /wp:column -->

		<!-- wp:column -->
		<div class="wp-block-column">
			<!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|20"}},"layout":{"type":"flex","orientation":"vertical","justifyContent":"center"}} -->
			<div class="wp-block-group">
				<!-- wp:html -->
				<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" style="color:var(--wp--preset--color--primary)" role="img" aria-label="Easy returns" focusable="false"><path d="M4 9a8 8 0 0 1 14-3"/><path d="M4 5v4h4"/><path d="M20 15a8 8 0 0 1-14 3"/><path d="M20 19v-4h-4"/></svg>
				<!-- /wp:html -->

				<!-- wp:paragraph {"align":"center","textColor":"contrast","style":{"spacing":{"margin":{"top":"0","bottom":"0"}}},"fontSize":"medium","fontFamily":"heading"} -->
				<p class="has-text-align-center has-contrast-color has-text-color has-medium-font-size has-heading-font-family" style="margin-top:0;margin-bottom:0">Easy returns</p>
				<!-- /wp:paragraph -->

				<!-- wp:paragraph {"align":"center","textColor":"contrast-2","style":{"spacing":{"margin":{"top":"0"}}},"fontSize":"small","fontFamily":"body"} -->
				<p class="has-text-align-center has-contrast-2-color has-text-color has-small-font-size has-body-font-family" style="margin-top:0">30 days to change your mind</p>
				<!-- /wp:paragraph -->
			</div>
			<!-- /wp:group -->
		</div>
		<!-- /wp:column -->

		<!-- wp:column -->
		<div class="wp-block-column">
			<!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|20"}},"layout":{"type":"flex","orientation":"vertical","justifyContent":"center"}} -->
			<div class="wp-block-group">
				<!-- wp:html -->
				<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" style="color:var(--wp--preset--color--primary)" role="img" aria-label="Friendly support" focusable="false"><path d="M21 15a2 2 0 0 1-2 2H8l-4 3V6a2 2 0 0 1 2-2h13a2 2 0 0 1 2 2z"/><path d="M8 10h8"/><path d="M8 13h5"/></svg>
				<!-- /wp:html -->

				<!-- wp:paragraph {"align":"center","textColor":"contrast","style":{"spacing":{"margin":{"top":"0","bottom":"0"}}},"fontSize":"medium","fontFamily":"heading"} -->
				<p class="has-text-align-center has-contrast-color has-text-color has-medium-font-size has-heading-font-family" style="margin-top:0;margin-bottom:0">Friendly support</p>
				<!-- /wp:paragraph -->

				<!-- wp:paragraph {"align":"center","textColor":"contrast-2","style":{"spacing":{"margin":{"top":"0"}}},"fontSize":"small","fontFamily":"body"} -->
				<p class="has-text-align-center has-contrast-2-color has-text-color has-small-font-size has-body-font-family" style="margin-top:0">Real people, ready to help</p>
				<!-- /wp:paragraph -->
			</div>
			<!-- /wp:group -->
		</div>
		<!-- /wp:column -->
	</div>
	<!-- /wp:columns -->
</section>
<!-- /wp:group -->
