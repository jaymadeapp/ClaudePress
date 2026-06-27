<?php
/**
 * Title: ClaudePress — Reviews & Social Proof
 * Slug: claudepress/reviews-social-proof
 * Categories: claudepress, woocommerce, featured
 * Block Types:
 * Inserter: true
 * Description: A social-proof section with an aggregate star rating and three short customer testimonial cards, each with a star row, quote, and name.
 * Keywords: reviews, ratings, testimonials, social proof, stars, woocommerce, customers
 * Viewport Width: 1280
 */
?>
<!-- wp:group {"tagName":"section","lock":{"move":true,"remove":true},"align":"full","backgroundColor":"base","style":{"spacing":{"padding":{"top":"var:preset|spacing|70","bottom":"var:preset|spacing|70","left":"var:preset|spacing|40","right":"var:preset|spacing|40"}}},"layout":{"type":"constrained"}} -->
<section class="wp-block-group alignfull has-base-background-color has-background" style="padding-top:var(--wp--preset--spacing--70);padding-right:var(--wp--preset--spacing--40);padding-bottom:var(--wp--preset--spacing--70);padding-left:var(--wp--preset--spacing--40)">
	<!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|10","margin":{"bottom":"var:preset|spacing|50"}}},"layout":{"type":"flex","orientation":"vertical","justifyContent":"center"}} -->
	<div class="wp-block-group" style="margin-bottom:var(--wp--preset--spacing--50)">
		<!-- wp:html -->
		<svg xmlns="http://www.w3.org/2000/svg" width="148" height="28" viewBox="0 0 148 28" fill="currentColor" style="color:var(--wp--preset--color--accent)" role="img" aria-label="Rated 4.8 out of 5 stars" focusable="false"><path d="M14 2l3.09 6.26L24 9.27l-5 4.87 1.18 6.88L14 17.77 7.82 21l1.18-6.88-5-4.87 6.91-1.01z"/><path d="M44 2l3.09 6.26L54 9.27l-5 4.87 1.18 6.88L44 17.77 37.82 21 39 14.14l-5-4.87 6.91-1.01z"/><path d="M74 2l3.09 6.26L84 9.27l-5 4.87 1.18 6.88L74 17.77 67.82 21 69 14.14l-5-4.87 6.91-1.01z"/><path d="M104 2l3.09 6.26L114 9.27l-5 4.87 1.18 6.88L104 17.77 97.82 21 99 14.14l-5-4.87 6.91-1.01z"/><path d="M134 2l3.09 6.26L144 9.27l-5 4.87 1.18 6.88L134 17.77 127.82 21 129 14.14l-5-4.87 6.91-1.01z"/></svg>
		<!-- /wp:html -->

		<!-- wp:paragraph {"align":"center","textColor":"contrast","style":{"spacing":{"margin":{"top":"0","bottom":"0"}}},"fontSize":"large","fontFamily":"heading"} -->
		<p class="has-text-align-center has-contrast-color has-text-color has-large-font-size has-heading-font-family" style="margin-top:0;margin-bottom:0">Rated 4.8 out of 5</p>
		<!-- /wp:paragraph -->

		<!-- wp:paragraph {"align":"center","textColor":"contrast-2","style":{"spacing":{"margin":{"top":"0"}}},"fontSize":"small","fontFamily":"body"} -->
		<p class="has-text-align-center has-contrast-2-color has-text-color has-small-font-size has-body-font-family" style="margin-top:0">Based on verified customer reviews</p>
		<!-- /wp:paragraph -->
	</div>
	<!-- /wp:group -->

	<!-- wp:columns {"style":{"spacing":{"blockGap":{"left":"var:preset|spacing|40"}}}} -->
	<div class="wp-block-columns">
		<!-- wp:column -->
		<div class="wp-block-column">
			<!-- wp:group {"backgroundColor":"surface","style":{"border":{"radius":"var:custom|radius|lg"},"spacing":{"padding":{"top":"var:preset|spacing|40","bottom":"var:preset|spacing|40","left":"var:preset|spacing|40","right":"var:preset|spacing|40"},"blockGap":"var:preset|spacing|20"}},"layout":{"type":"constrained"}} -->
			<div class="wp-block-group has-surface-background-color has-background" style="border-radius:var(--wp--custom--radius--lg);padding-top:var(--wp--preset--spacing--40);padding-right:var(--wp--preset--spacing--40);padding-bottom:var(--wp--preset--spacing--40);padding-left:var(--wp--preset--spacing--40)">
				<!-- wp:html -->
				<svg xmlns="http://www.w3.org/2000/svg" width="110" height="20" viewBox="0 0 148 28" fill="currentColor" style="color:var(--wp--preset--color--accent)" role="img" aria-label="Five stars" focusable="false"><path d="M14 2l3.09 6.26L24 9.27l-5 4.87 1.18 6.88L14 17.77 7.82 21l1.18-6.88-5-4.87 6.91-1.01z"/><path d="M44 2l3.09 6.26L54 9.27l-5 4.87 1.18 6.88L44 17.77 37.82 21 39 14.14l-5-4.87 6.91-1.01z"/><path d="M74 2l3.09 6.26L84 9.27l-5 4.87 1.18 6.88L74 17.77 67.82 21 69 14.14l-5-4.87 6.91-1.01z"/><path d="M104 2l3.09 6.26L114 9.27l-5 4.87 1.18 6.88L104 17.77 97.82 21 99 14.14l-5-4.87 6.91-1.01z"/><path d="M134 2l3.09 6.26L144 9.27l-5 4.87 1.18 6.88L134 17.77 127.82 21 129 14.14l-5-4.87 6.91-1.01z"/></svg>
				<!-- /wp:html -->

				<!-- wp:paragraph {"textColor":"contrast","style":{"elements":{"link":{"color":{"text":"var:preset|color|contrast"}}}},"fontSize":"medium","fontFamily":"body"} -->
				<p class="has-contrast-color has-text-color has-link-color has-medium-font-size has-body-font-family">"Exactly as pictured and the quality is excellent. Shipping was quick and everything arrived neatly packaged."</p>
				<!-- /wp:paragraph -->

				<!-- wp:paragraph {"textColor":"contrast","style":{"spacing":{"margin":{"top":"0"}},"elements":{"link":{"color":{"text":"var:preset|color|contrast"}}}},"fontSize":"small","fontFamily":"heading"} -->
				<p class="has-contrast-color has-text-color has-link-color has-small-font-size has-heading-font-family" style="margin-top:0">Maya C. — Verified buyer</p>
				<!-- /wp:paragraph -->
			</div>
			<!-- /wp:group -->
		</div>
		<!-- /wp:column -->

		<!-- wp:column -->
		<div class="wp-block-column">
			<!-- wp:group {"backgroundColor":"surface","style":{"border":{"radius":"var:custom|radius|lg"},"spacing":{"padding":{"top":"var:preset|spacing|40","bottom":"var:preset|spacing|40","left":"var:preset|spacing|40","right":"var:preset|spacing|40"},"blockGap":"var:preset|spacing|20"}},"layout":{"type":"constrained"}} -->
			<div class="wp-block-group has-surface-background-color has-background" style="border-radius:var(--wp--custom--radius--lg);padding-top:var(--wp--preset--spacing--40);padding-right:var(--wp--preset--spacing--40);padding-bottom:var(--wp--preset--spacing--40);padding-left:var(--wp--preset--spacing--40)">
				<!-- wp:html -->
				<svg xmlns="http://www.w3.org/2000/svg" width="110" height="20" viewBox="0 0 148 28" fill="currentColor" style="color:var(--wp--preset--color--accent)" role="img" aria-label="Five stars" focusable="false"><path d="M14 2l3.09 6.26L24 9.27l-5 4.87 1.18 6.88L14 17.77 7.82 21l1.18-6.88-5-4.87 6.91-1.01z"/><path d="M44 2l3.09 6.26L54 9.27l-5 4.87 1.18 6.88L44 17.77 37.82 21 39 14.14l-5-4.87 6.91-1.01z"/><path d="M74 2l3.09 6.26L84 9.27l-5 4.87 1.18 6.88L74 17.77 67.82 21 69 14.14l-5-4.87 6.91-1.01z"/><path d="M104 2l3.09 6.26L114 9.27l-5 4.87 1.18 6.88L104 17.77 97.82 21 99 14.14l-5-4.87 6.91-1.01z"/><path d="M134 2l3.09 6.26L144 9.27l-5 4.87 1.18 6.88L134 17.77 127.82 21 129 14.14l-5-4.87 6.91-1.01z"/></svg>
				<!-- /wp:html -->

				<!-- wp:paragraph {"textColor":"contrast","style":{"elements":{"link":{"color":{"text":"var:preset|color|contrast"}}}},"fontSize":"medium","fontFamily":"body"} -->
				<p class="has-contrast-color has-text-color has-link-color has-medium-font-size has-body-font-family">"I ordered a second one a week later. Comfortable, well made, and the checkout was simple and fast."</p>
				<!-- /wp:paragraph -->

				<!-- wp:paragraph {"textColor":"contrast","style":{"spacing":{"margin":{"top":"0"}},"elements":{"link":{"color":{"text":"var:preset|color|contrast"}}}},"fontSize":"small","fontFamily":"heading"} -->
				<p class="has-contrast-color has-text-color has-link-color has-small-font-size has-heading-font-family" style="margin-top:0">Daniel O. — Verified buyer</p>
				<!-- /wp:paragraph -->
			</div>
			<!-- /wp:group -->
		</div>
		<!-- /wp:column -->

		<!-- wp:column -->
		<div class="wp-block-column">
			<!-- wp:group {"backgroundColor":"surface","style":{"border":{"radius":"var:custom|radius|lg"},"spacing":{"padding":{"top":"var:preset|spacing|40","bottom":"var:preset|spacing|40","left":"var:preset|spacing|40","right":"var:preset|spacing|40"},"blockGap":"var:preset|spacing|20"}},"layout":{"type":"constrained"}} -->
			<div class="wp-block-group has-surface-background-color has-background" style="border-radius:var(--wp--custom--radius--lg);padding-top:var(--wp--preset--spacing--40);padding-right:var(--wp--preset--spacing--40);padding-bottom:var(--wp--preset--spacing--40);padding-left:var(--wp--preset--spacing--40)">
				<!-- wp:html -->
				<svg xmlns="http://www.w3.org/2000/svg" width="110" height="20" viewBox="0 0 148 28" fill="currentColor" style="color:var(--wp--preset--color--accent)" role="img" aria-label="Five stars" focusable="false"><path d="M14 2l3.09 6.26L24 9.27l-5 4.87 1.18 6.88L14 17.77 7.82 21l1.18-6.88-5-4.87 6.91-1.01z"/><path d="M44 2l3.09 6.26L54 9.27l-5 4.87 1.18 6.88L44 17.77 37.82 21 39 14.14l-5-4.87 6.91-1.01z"/><path d="M74 2l3.09 6.26L84 9.27l-5 4.87 1.18 6.88L74 17.77 67.82 21 69 14.14l-5-4.87 6.91-1.01z"/><path d="M104 2l3.09 6.26L114 9.27l-5 4.87 1.18 6.88L104 17.77 97.82 21 99 14.14l-5-4.87 6.91-1.01z"/><path d="M134 2l3.09 6.26L144 9.27l-5 4.87 1.18 6.88L134 17.77 127.82 21 129 14.14l-5-4.87 6.91-1.01z"/></svg>
				<!-- /wp:html -->

				<!-- wp:paragraph {"textColor":"contrast","style":{"elements":{"link":{"color":{"text":"var:preset|color|contrast"}}}},"fontSize":"medium","fontFamily":"body"} -->
				<p class="has-contrast-color has-text-color has-link-color has-medium-font-size has-body-font-family">"Great value for the price. Had a quick question and support replied the same day. Would buy again."</p>
				<!-- /wp:paragraph -->

				<!-- wp:paragraph {"textColor":"contrast","style":{"spacing":{"margin":{"top":"0"}},"elements":{"link":{"color":{"text":"var:preset|color|contrast"}}}},"fontSize":"small","fontFamily":"heading"} -->
				<p class="has-contrast-color has-text-color has-link-color has-small-font-size has-heading-font-family" style="margin-top:0">Priya N. — Verified buyer</p>
				<!-- /wp:paragraph -->
			</div>
			<!-- /wp:group -->
		</div>
		<!-- /wp:column -->
	</div>
	<!-- /wp:columns -->
</section>
<!-- /wp:group -->
