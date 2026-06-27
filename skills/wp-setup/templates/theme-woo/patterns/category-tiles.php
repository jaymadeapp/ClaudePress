<?php
/**
 * Title: ClaudePress — Category Tiles
 * Slug: claudepress/category-tiles
 * Categories: claudepress, woocommerce, featured
 * Block Types:
 * Inserter: true
 * Description: A row of token-colored category navigation tiles, each a tappable card with a label and a shop link, for browsing the store by collection.
 * Keywords: categories, tiles, navigation, shop, store, collections, woocommerce
 * Viewport Width: 1280
 */
?>
<!-- wp:group {"tagName":"section","lock":{"move":true,"remove":true},"align":"full","backgroundColor":"base","style":{"spacing":{"padding":{"top":"var:preset|spacing|70","bottom":"var:preset|spacing|70","left":"var:preset|spacing|40","right":"var:preset|spacing|40"}}},"layout":{"type":"constrained"}} -->
<section class="wp-block-group alignfull has-base-background-color has-background" style="padding-top:var(--wp--preset--spacing--70);padding-right:var(--wp--preset--spacing--40);padding-bottom:var(--wp--preset--spacing--70);padding-left:var(--wp--preset--spacing--40)">
	<!-- wp:heading {"textAlign":"center","textColor":"contrast","style":{"spacing":{"margin":{"bottom":"var:preset|spacing|50"}}},"fontSize":"xx-large","fontFamily":"heading"} -->
	<h2 class="wp-block-heading has-text-align-center has-contrast-color has-text-color has-xx-large-font-size has-heading-font-family" style="margin-bottom:var(--wp--preset--spacing--50)">Shop by category</h2>
	<!-- /wp:heading -->

	<!-- wp:columns {"style":{"spacing":{"blockGap":{"left":"var:preset|spacing|30"}}}} -->
	<div class="wp-block-columns">
		<!-- wp:column -->
		<div class="wp-block-column">
			<!-- wp:cover {"overlayColor":"primary","dimRatio":100,"minHeight":260,"contentPosition":"bottom left","style":{"border":{"radius":"var:custom|radius|lg"},"spacing":{"padding":{"top":"var:preset|spacing|40","bottom":"var:preset|spacing|40","left":"var:preset|spacing|40","right":"var:preset|spacing|40"}}},"layout":{"type":"constrained"}} -->
			<div class="wp-block-cover has-custom-content-position is-position-bottom-left" style="border-radius:var(--wp--custom--radius--lg);padding-top:var(--wp--preset--spacing--40);padding-right:var(--wp--preset--spacing--40);padding-bottom:var(--wp--preset--spacing--40);padding-left:var(--wp--preset--spacing--40);min-height:260px"><span aria-hidden="true" class="wp-block-cover__background has-primary-background-color has-background-dim-100 has-background-dim"></span><div class="wp-block-cover__inner-container">
				<!-- wp:heading {"level":3,"textColor":"base","fontSize":"large","fontFamily":"heading"} -->
				<h3 class="wp-block-heading has-base-color has-text-color has-large-font-size has-heading-font-family">New Arrivals</h3>
				<!-- /wp:heading -->

				<!-- wp:paragraph {"textColor":"surface","style":{"elements":{"link":{"color":{"text":"var:preset|color|surface"}}}},"fontSize":"small","fontFamily":"body"} -->
				<p class="has-surface-color has-text-color has-link-color has-small-font-size has-body-font-family"><a href="#">Shop now →</a></p>
				<!-- /wp:paragraph -->
			</div></div>
			<!-- /wp:cover -->
		</div>
		<!-- /wp:column -->

		<!-- wp:column -->
		<div class="wp-block-column">
			<!-- wp:cover {"overlayColor":"secondary","dimRatio":100,"minHeight":260,"contentPosition":"bottom left","style":{"border":{"radius":"var:custom|radius|lg"},"spacing":{"padding":{"top":"var:preset|spacing|40","bottom":"var:preset|spacing|40","left":"var:preset|spacing|40","right":"var:preset|spacing|40"}}},"layout":{"type":"constrained"}} -->
			<div class="wp-block-cover has-custom-content-position is-position-bottom-left" style="border-radius:var(--wp--custom--radius--lg);padding-top:var(--wp--preset--spacing--40);padding-right:var(--wp--preset--spacing--40);padding-bottom:var(--wp--preset--spacing--40);padding-left:var(--wp--preset--spacing--40);min-height:260px"><span aria-hidden="true" class="wp-block-cover__background has-secondary-background-color has-background-dim-100 has-background-dim"></span><div class="wp-block-cover__inner-container">
				<!-- wp:heading {"level":3,"textColor":"base","fontSize":"large","fontFamily":"heading"} -->
				<h3 class="wp-block-heading has-base-color has-text-color has-large-font-size has-heading-font-family">Best Sellers</h3>
				<!-- /wp:heading -->

				<!-- wp:paragraph {"textColor":"surface","style":{"elements":{"link":{"color":{"text":"var:preset|color|surface"}}}},"fontSize":"small","fontFamily":"body"} -->
				<p class="has-surface-color has-text-color has-link-color has-small-font-size has-body-font-family"><a href="#">Shop now →</a></p>
				<!-- /wp:paragraph -->
			</div></div>
			<!-- /wp:cover -->
		</div>
		<!-- /wp:column -->

		<!-- wp:column -->
		<div class="wp-block-column">
			<!-- wp:cover {"overlayColor":"accent","dimRatio":100,"minHeight":260,"contentPosition":"bottom left","style":{"border":{"radius":"var:custom|radius|lg"},"spacing":{"padding":{"top":"var:preset|spacing|40","bottom":"var:preset|spacing|40","left":"var:preset|spacing|40","right":"var:preset|spacing|40"}}},"layout":{"type":"constrained"}} -->
			<div class="wp-block-cover has-custom-content-position is-position-bottom-left" style="border-radius:var(--wp--custom--radius--lg);padding-top:var(--wp--preset--spacing--40);padding-right:var(--wp--preset--spacing--40);padding-bottom:var(--wp--preset--spacing--40);padding-left:var(--wp--preset--spacing--40);min-height:260px"><span aria-hidden="true" class="wp-block-cover__background has-accent-background-color has-background-dim-100 has-background-dim"></span><div class="wp-block-cover__inner-container">
				<!-- wp:heading {"level":3,"textColor":"base","fontSize":"large","fontFamily":"heading"} -->
				<h3 class="wp-block-heading has-base-color has-text-color has-large-font-size has-heading-font-family">On Sale</h3>
				<!-- /wp:heading -->

				<!-- wp:paragraph {"textColor":"surface","style":{"elements":{"link":{"color":{"text":"var:preset|color|surface"}}}},"fontSize":"small","fontFamily":"body"} -->
				<p class="has-surface-color has-text-color has-link-color has-small-font-size has-body-font-family"><a href="#">Shop now →</a></p>
				<!-- /wp:paragraph -->
			</div></div>
			<!-- /wp:cover -->
		</div>
		<!-- /wp:column -->
	</div>
	<!-- /wp:columns -->
</section>
<!-- /wp:group -->
