<?php
/**
 * Title: Loamkit — Shop Hero
 * Slug: loamkit/shop-hero
 * Categories: loamkit, woocommerce, featured, banner
 * Block Types:
 * Inserter: true
 * Description: An asymmetric editorial storefront hero — eyebrow, large headline with a Fraunces italic accent, supporting paragraph, and pill CTAs on the left; a framed lifestyle image with an organic clay shape on the right.
 * Keywords: shop, store, hero, banner, woocommerce, headline, editorial
 * Viewport Width: 1280
 */
?>
<!-- wp:group {"tagName":"section","lock":{"move":true,"remove":true},"align":"full","backgroundColor":"base","style":{"spacing":{"padding":{"top":"var:preset|spacing|70","bottom":"var:preset|spacing|70","left":"var:preset|spacing|40","right":"var:preset|spacing|40"}}},"layout":{"type":"constrained","contentSize":"1200px"}} -->
<section class="wp-block-group alignfull has-base-background-color has-background" style="padding-top:var(--wp--preset--spacing--70);padding-right:var(--wp--preset--spacing--40);padding-bottom:var(--wp--preset--spacing--70);padding-left:var(--wp--preset--spacing--40)">
	<!-- wp:columns {"verticalAlignment":"center","className":"lk-reveal","style":{"spacing":{"blockGap":{"left":"var:preset|spacing|60"}}}} -->
	<div class="wp-block-columns are-vertically-aligned-center lk-reveal">
		<!-- wp:column {"verticalAlignment":"center","width":"56%"} -->
		<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:56%">
			<!-- wp:paragraph {"textColor":"secondary","style":{"typography":{"textTransform":"uppercase","letterSpacing":"0.1em"},"elements":{"link":{"color":{"text":"var:preset|color|secondary"}}},"spacing":{"margin":{"bottom":"var:preset|spacing|20"}}},"fontSize":"small","fontFamily":"mono"} -->
			<p class="has-secondary-color has-text-color has-link-color has-small-font-size has-mono-font-family" style="margin-bottom:var(--wp--preset--spacing--20);letter-spacing:0.1em;text-transform:uppercase">Rooted in care</p>
			<!-- /wp:paragraph -->

			<!-- wp:heading {"level":1,"textColor":"contrast","fontSize":"huge","fontFamily":"heading"} -->
			<h1 class="wp-block-heading has-contrast-color has-text-color has-huge-font-size has-heading-font-family">A calmer way to <em class="has-display-font-family" style="font-style:italic;font-weight:400;color:var(--wp--custom--color--accent-ink, var(--wp--preset--color--accent))">live well</em>.</h1>
			<!-- /wp:heading -->

			<!-- wp:paragraph {"textColor":"contrast-2","style":{"spacing":{"margin":{"top":"var:preset|spacing|30"}},"elements":{"link":{"color":{"text":"var:preset|color|contrast-2"}}}},"fontSize":"large","fontFamily":"body"} -->
			<p class="has-contrast-2-color has-text-color has-link-color has-large-font-size has-body-font-family" style="margin-top:var(--wp--preset--spacing--30)">Thoughtful essentials, made from honest materials — for a slower, warmer everyday. Free shipping on your first order, easy 30-day returns.</p>
			<!-- /wp:paragraph -->

			<!-- wp:buttons {"layout":{"type":"flex"},"style":{"spacing":{"margin":{"top":"var:preset|spacing|40"},"blockGap":"var:preset|spacing|20"}}} -->
			<div class="wp-block-buttons" style="margin-top:var(--wp--preset--spacing--40)">
				<!-- wp:button {"backgroundColor":"primary","textColor":"base","style":{"elements":{"link":{"color":{"text":"var:preset|color|base"}}},"border":{"radius":"var:custom|radius|pill"}}} -->
				<div class="wp-block-button"><a class="wp-block-button__link has-base-color has-primary-background-color has-text-color has-background has-link-color wp-element-button" style="border-radius:var(--wp--custom--radius--pill)">Discover the ritual</a></div>
				<!-- /wp:button -->

				<!-- wp:button {"textColor":"primary","className":"is-style-outline","style":{"elements":{"link":{"color":{"text":"var:preset|color|primary"}}},"border":{"radius":"var:custom|radius|pill"}}} -->
				<div class="wp-block-button is-style-outline"><a class="wp-block-button__link has-primary-color has-text-color has-link-color wp-element-button" style="border-radius:var(--wp--custom--radius--pill)">Shop new arrivals</a></div>
				<!-- /wp:button -->
			</div>
			<!-- /wp:buttons -->
		</div>
		<!-- /wp:column -->

		<!-- wp:column {"verticalAlignment":"center","width":"44%"} -->
		<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:44%">
			<!-- wp:group {"className":"lk-frame","style":{"dimensions":{"aspectRatio":"4/5"}},"layout":{"type":"default"}} -->
			<div class="wp-block-group lk-frame" style="aspect-ratio:4/5">
				<!-- wp:image {"sizeSlug":"large","style":{"color":{"duotone":"unset"}}} -->
				<figure class="wp-block-image size-large"><img src="<?php echo esc_url( get_theme_file_uri( 'images/lifestyle-1.webp' ) ); ?>" alt="A calm, warm-toned lifestyle still life"/></figure>
				<!-- /wp:image -->
			</div>
			<!-- /wp:group -->
		</div>
		<!-- /wp:column -->
	</div>
	<!-- /wp:columns -->
</section>
<!-- /wp:group -->
