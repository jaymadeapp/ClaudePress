<?php
/**
 * Title: Loamkit — Image Band
 * Slug: loamkit/image-band
 * Categories: loamkit, featured
 * Block Types:
 * Inserter: true
 * Description: An asymmetric full-width band — a framed lifestyle image on one side, an eyebrow, headline, copy and a text link on the other, on a warm surface background.
 * Keywords: image, band, split, feature, about, story
 * Viewport Width: 1280
 */
?>
<!-- wp:group {"tagName":"section","lock":{"move":true,"remove":true},"align":"full","backgroundColor":"surface","style":{"spacing":{"padding":{"top":"var:preset|spacing|70","bottom":"var:preset|spacing|70","left":"var:preset|spacing|40","right":"var:preset|spacing|40"}}},"layout":{"type":"constrained"}} -->
<section class="wp-block-group alignfull has-surface-background-color has-background" style="padding-top:var(--wp--preset--spacing--70);padding-right:var(--wp--preset--spacing--40);padding-bottom:var(--wp--preset--spacing--70);padding-left:var(--wp--preset--spacing--40)">
	<!-- wp:columns {"verticalAlignment":"center","style":{"spacing":{"blockGap":{"left":"var:preset|spacing|60"}}}} -->
	<div class="wp-block-columns are-vertically-aligned-center">
		<!-- wp:column {"verticalAlignment":"center","width":"54%"} -->
		<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:54%">
			<!-- wp:image {"className":"lk-frame lk-reveal","sizeSlug":"large","style":{"dimensions":{"aspectRatio":"4/3"}}} -->
			<figure class="wp-block-image size-large lk-frame lk-reveal"><img src="<?php echo esc_url( get_theme_file_uri( 'images/lifestyle-1.webp' ) ); ?>" alt="Hands shaping clay on a potter's wheel" style="aspect-ratio:4/3;object-fit:cover"/></figure>
			<!-- /wp:image -->
		</div>
		<!-- /wp:column -->

		<!-- wp:column {"verticalAlignment":"center","width":"46%"} -->
		<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:46%">
			<!-- wp:paragraph {"className":"lk-reveal","style":{"typography":{"textTransform":"uppercase","letterSpacing":"0.1em"},"elements":{"link":{"color":{"text":"var:preset|color|secondary"}}}},"textColor":"secondary","fontSize":"small","fontFamily":"mono"} -->
			<p class="lk-reveal has-secondary-color has-text-color has-link-color has-small-font-size has-mono-font-family" style="letter-spacing:0.1em;text-transform:uppercase">Made by hand</p>
			<!-- /wp:paragraph -->

			<!-- wp:heading {"className":"lk-reveal","style":{"spacing":{"margin":{"top":"var:preset|spacing|20"}}},"textColor":"contrast","fontSize":"x-large","fontFamily":"heading"} -->
			<h2 class="wp-block-heading lk-reveal has-contrast-color has-text-color has-x-large-font-size has-heading-font-family" style="margin-top:var(--wp--preset--spacing--20)">Every piece begins on a <em class="has-display-font-family" style="font-weight:400;color:var(--wp--custom--color--accent-ink, var(--wp--preset--color--accent))">wheel</em>.</h2>
			<!-- /wp:heading -->

			<!-- wp:paragraph {"className":"lk-reveal","style":{"spacing":{"margin":{"top":"var:preset|spacing|30"}},"typography":{"lineHeight":"1.6"},"elements":{"link":{"color":{"text":"var:preset|color|contrast-2"}}}},"textColor":"contrast-2","fontSize":"medium","fontFamily":"body"} -->
			<p class="lk-reveal has-contrast-2-color has-text-color has-link-color has-medium-font-size has-body-font-family" style="margin-top:var(--wp--preset--spacing--30);line-height:1.6">Our small studio still throws, trims and glazes by hand, in a converted barn outside the city. No two pieces are quite alike — and we like it that way.</p>
			<!-- /wp:paragraph -->

			<!-- wp:paragraph {"className":"lk-reveal","style":{"spacing":{"margin":{"top":"var:preset|spacing|30"}},"elements":{"link":{"color":{"text":"var:preset|color|primary"}}}},"textColor":"primary","fontSize":"medium","fontFamily":"heading"} -->
			<p class="lk-reveal has-primary-color has-text-color has-link-color has-medium-font-size has-heading-font-family" style="margin-top:var(--wp--preset--spacing--30)"><a href="#">Visit the studio →</a></p>
			<!-- /wp:paragraph -->
		</div>
		<!-- /wp:column -->
	</div>
	<!-- /wp:columns -->
</section>
<!-- /wp:group -->
