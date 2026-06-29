<?php
/**
 * Title: Loamkit — Category Tiles
 * Slug: loamkit/category-tiles
 * Categories: loamkit, woocommerce, featured
 * Block Types:
 * Inserter: true
 * Description: A row of premium image-led category tiles — each a soft rounded cover over a warm lifestyle photo with a label and a shop link, for browsing the store by collection.
 * Keywords: categories, tiles, navigation, shop, store, collections, woocommerce
 * Viewport Width: 1280
 */
?>
<!-- wp:group {"tagName":"section","lock":{"move":true,"remove":true},"align":"full","backgroundColor":"base","style":{"spacing":{"padding":{"top":"var:preset|spacing|70","bottom":"var:preset|spacing|70","left":"var:preset|spacing|40","right":"var:preset|spacing|40"}}},"layout":{"type":"constrained"}} -->
<section class="wp-block-group alignfull has-base-background-color has-background" style="padding-top:var(--wp--preset--spacing--70);padding-right:var(--wp--preset--spacing--40);padding-bottom:var(--wp--preset--spacing--70);padding-left:var(--wp--preset--spacing--40)">
	<!-- wp:group {"className":"cp-reveal","style":{"spacing":{"margin":{"bottom":"var:preset|spacing|50"},"blockGap":"var:preset|spacing|20"}},"layout":{"type":"constrained","contentSize":"640px","justifyContent":"left"}} -->
	<div class="wp-block-group cp-reveal" style="margin-bottom:var(--wp--preset--spacing--50)">
		<!-- wp:paragraph {"textColor":"secondary","style":{"typography":{"textTransform":"uppercase","letterSpacing":"0.1em"},"elements":{"link":{"color":{"text":"var:preset|color|secondary"}}}},"fontSize":"small","fontFamily":"mono"} -->
		<p class="has-secondary-color has-text-color has-link-color has-small-font-size has-mono-font-family" style="letter-spacing:0.1em;text-transform:uppercase">Find your corner</p>
		<!-- /wp:paragraph -->

		<!-- wp:heading {"textColor":"contrast","fontSize":"xx-large","fontFamily":"heading"} -->
		<h2 class="wp-block-heading has-contrast-color has-text-color has-xx-large-font-size has-heading-font-family">Shop by collection</h2>
		<!-- /wp:heading -->
	</div>
	<!-- /wp:group -->

	<!-- wp:columns {"className":"cp-reveal","style":{"spacing":{"blockGap":{"left":"var:preset|spacing|40"}}}} -->
	<div class="wp-block-columns cp-reveal">
		<!-- wp:column -->
		<div class="wp-block-column">
			<!-- wp:cover {"url":"<?php echo esc_url( get_theme_file_uri( 'images/lifestyle-2.webp' ) ); ?>","dimRatio":40,"overlayColor":"surface-2","isUserOverlayColor":true,"minHeight":340,"contentPosition":"bottom left","style":{"border":{"radius":"var:custom|radius|xl"},"spacing":{"padding":{"top":"var:preset|spacing|40","bottom":"var:preset|spacing|40","left":"var:preset|spacing|40","right":"var:preset|spacing|40"}}},"layout":{"type":"constrained"}} -->
			<div class="wp-block-cover has-custom-content-position is-position-bottom-left" style="border-radius:var(--wp--custom--radius--xl);padding-top:var(--wp--preset--spacing--40);padding-right:var(--wp--preset--spacing--40);padding-bottom:var(--wp--preset--spacing--40);padding-left:var(--wp--preset--spacing--40);min-height:340px"><span aria-hidden="true" class="wp-block-cover__background has-surface-2-background-color has-background-dim-40 has-background-dim"></span><img class="wp-block-cover__image-background" alt="New arrivals collection" src="<?php echo esc_url( get_theme_file_uri( 'images/lifestyle-2.webp' ) ); ?>" data-object-fit="cover"/><div class="wp-block-cover__inner-container">
				<!-- wp:heading {"level":3,"textColor":"base","fontSize":"large","fontFamily":"heading"} -->
				<h3 class="wp-block-heading has-base-color has-text-color has-large-font-size has-heading-font-family">New arrivals</h3>
				<!-- /wp:heading -->

				<!-- wp:paragraph {"textColor":"base","style":{"elements":{"link":{"color":{"text":"var:preset|color|base"}}},"spacing":{"margin":{"top":"var:preset|spacing|10"}}},"fontSize":"small","fontFamily":"body"} -->
				<p class="has-base-color has-text-color has-link-color has-small-font-size has-body-font-family" style="margin-top:var(--wp--preset--spacing--10)"><a href="#">Shop now →</a></p>
				<!-- /wp:paragraph -->
			</div></div>
			<!-- /wp:cover -->
		</div>
		<!-- /wp:column -->

		<!-- wp:column -->
		<div class="wp-block-column">
			<!-- wp:cover {"url":"<?php echo esc_url( get_theme_file_uri( 'images/lifestyle-3.webp' ) ); ?>","dimRatio":40,"overlayColor":"surface-2","isUserOverlayColor":true,"minHeight":340,"contentPosition":"bottom left","style":{"border":{"radius":"var:custom|radius|xl"},"spacing":{"padding":{"top":"var:preset|spacing|40","bottom":"var:preset|spacing|40","left":"var:preset|spacing|40","right":"var:preset|spacing|40"}}},"layout":{"type":"constrained"}} -->
			<div class="wp-block-cover has-custom-content-position is-position-bottom-left" style="border-radius:var(--wp--custom--radius--xl);padding-top:var(--wp--preset--spacing--40);padding-right:var(--wp--preset--spacing--40);padding-bottom:var(--wp--preset--spacing--40);padding-left:var(--wp--preset--spacing--40);min-height:340px"><span aria-hidden="true" class="wp-block-cover__background has-surface-2-background-color has-background-dim-40 has-background-dim"></span><img class="wp-block-cover__image-background" alt="Best sellers collection" src="<?php echo esc_url( get_theme_file_uri( 'images/lifestyle-3.webp' ) ); ?>" data-object-fit="cover"/><div class="wp-block-cover__inner-container">
				<!-- wp:heading {"level":3,"textColor":"base","fontSize":"large","fontFamily":"heading"} -->
				<h3 class="wp-block-heading has-base-color has-text-color has-large-font-size has-heading-font-family">Best sellers</h3>
				<!-- /wp:heading -->

				<!-- wp:paragraph {"textColor":"base","style":{"elements":{"link":{"color":{"text":"var:preset|color|base"}}},"spacing":{"margin":{"top":"var:preset|spacing|10"}}},"fontSize":"small","fontFamily":"body"} -->
				<p class="has-base-color has-text-color has-link-color has-small-font-size has-body-font-family" style="margin-top:var(--wp--preset--spacing--10)"><a href="#">Shop now →</a></p>
				<!-- /wp:paragraph -->
			</div></div>
			<!-- /wp:cover -->
		</div>
		<!-- /wp:column -->

		<!-- wp:column -->
		<div class="wp-block-column">
			<!-- wp:cover {"url":"<?php echo esc_url( get_theme_file_uri( 'images/lifestyle-4.webp' ) ); ?>","dimRatio":40,"overlayColor":"surface-2","isUserOverlayColor":true,"minHeight":340,"contentPosition":"bottom left","style":{"border":{"radius":"var:custom|radius|xl"},"spacing":{"padding":{"top":"var:preset|spacing|40","bottom":"var:preset|spacing|40","left":"var:preset|spacing|40","right":"var:preset|spacing|40"}}},"layout":{"type":"constrained"}} -->
			<div class="wp-block-cover has-custom-content-position is-position-bottom-left" style="border-radius:var(--wp--custom--radius--xl);padding-top:var(--wp--preset--spacing--40);padding-right:var(--wp--preset--spacing--40);padding-bottom:var(--wp--preset--spacing--40);padding-left:var(--wp--preset--spacing--40);min-height:340px"><span aria-hidden="true" class="wp-block-cover__background has-surface-2-background-color has-background-dim-40 has-background-dim"></span><img class="wp-block-cover__image-background" alt="On sale collection" src="<?php echo esc_url( get_theme_file_uri( 'images/lifestyle-4.webp' ) ); ?>" data-object-fit="cover"/><div class="wp-block-cover__inner-container">
				<!-- wp:heading {"level":3,"textColor":"base","fontSize":"large","fontFamily":"heading"} -->
				<h3 class="wp-block-heading has-base-color has-text-color has-large-font-size has-heading-font-family">On sale</h3>
				<!-- /wp:heading -->

				<!-- wp:paragraph {"textColor":"base","style":{"elements":{"link":{"color":{"text":"var:preset|color|base"}}},"spacing":{"margin":{"top":"var:preset|spacing|10"}}},"fontSize":"small","fontFamily":"body"} -->
				<p class="has-base-color has-text-color has-link-color has-small-font-size has-body-font-family" style="margin-top:var(--wp--preset--spacing--10)"><a href="#">Shop now →</a></p>
				<!-- /wp:paragraph -->
			</div></div>
			<!-- /wp:cover -->
		</div>
		<!-- /wp:column -->
	</div>
	<!-- /wp:columns -->
</section>
<!-- /wp:group -->
