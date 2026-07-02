<?php
/**
 * Title: Loamkit — Project Gallery
 * Slug: loamkit/project-gallery
 * Categories: loamkit, featured, gallery
 * Block Types:
 * Inserter: true
 * Description: A responsive gallery of framed project tiles with warm captions — real subjects in soft frames, ready to swap for your own work.
 * Keywords: portfolio, gallery, projects, grid, work, showcase
 * Viewport Width: 1280
 */
?>
<!-- wp:group {"tagName":"section","lock":{"move":true,"remove":true},"align":"full","backgroundColor":"base","style":{"spacing":{"padding":{"top":"var:preset|spacing|70","bottom":"var:preset|spacing|70","left":"var:preset|spacing|40","right":"var:preset|spacing|40"}}},"layout":{"type":"constrained"}} -->
<section class="wp-block-group alignfull has-base-background-color has-background" style="padding-top:var(--wp--preset--spacing--70);padding-right:var(--wp--preset--spacing--40);padding-bottom:var(--wp--preset--spacing--70);padding-left:var(--wp--preset--spacing--40)">
	<!-- wp:paragraph {"className":"lk-reveal","style":{"typography":{"textTransform":"uppercase","letterSpacing":"0.1em"},"elements":{"link":{"color":{"text":"var:preset|color|secondary"}}}},"textColor":"secondary","fontSize":"small","fontFamily":"mono"} -->
	<p class="lk-reveal has-secondary-color has-text-color has-link-color has-small-font-size has-mono-font-family" style="letter-spacing:0.1em;text-transform:uppercase">Selected work</p>
	<!-- /wp:paragraph -->

	<!-- wp:heading {"className":"lk-reveal","textColor":"contrast","style":{"spacing":{"margin":{"top":"var:preset|spacing|20","bottom":"var:preset|spacing|20"}}},"fontSize":"xx-large","fontFamily":"heading"} -->
	<h2 class="wp-block-heading lk-reveal has-contrast-color has-text-color has-xx-large-font-size has-heading-font-family" style="margin-top:var(--wp--preset--spacing--20);margin-bottom:var(--wp--preset--spacing--20)">Things made by <em class="has-display-font-family" style="font-weight:400;color:var(--wp--custom--color--accent-ink, var(--wp--preset--color--accent))">hand</em></h2>
	<!-- /wp:heading -->

	<!-- wp:paragraph {"className":"lk-reveal","textColor":"contrast-2","style":{"spacing":{"margin":{"bottom":"var:preset|spacing|50"}},"typography":{"lineHeight":"1.6"},"elements":{"link":{"color":{"text":"var:preset|color|contrast-2"}}}},"fontSize":"large","fontFamily":"body"} -->
	<p class="lk-reveal has-contrast-2-color has-text-color has-link-color has-large-font-size has-body-font-family" style="margin-bottom:var(--wp--preset--spacing--50);line-height:1.6">A few recent pieces from the studio. Swap each frame and caption for your own work.</p>
	<!-- /wp:paragraph -->

	<!-- wp:gallery {"columns":3,"imageCrop":true,"linkTo":"none","className":"lk-reveal","style":{"spacing":{"blockGap":{"left":"var:preset|spacing|40","top":"var:preset|spacing|40"}}}} -->
	<figure class="wp-block-gallery has-nested-images columns-3 is-cropped lk-reveal">
		<!-- wp:image {"className":"lk-frame","sizeSlug":"large","style":{"dimensions":{"aspectRatio":"4/5"}}} -->
		<figure class="wp-block-image size-large lk-frame"><img src="<?php echo esc_url( get_theme_file_uri( 'images/product-1.webp' ) ); ?>" alt="Terracotta vessels drying on a wooden shelf" style="aspect-ratio:4/5;object-fit:cover"/><figcaption class="wp-element-caption">Clay vessels · 2025</figcaption></figure>
		<!-- /wp:image -->

		<!-- wp:image {"className":"lk-frame","sizeSlug":"large","style":{"dimensions":{"aspectRatio":"4/5"}}} -->
		<figure class="wp-block-image size-large lk-frame"><img src="<?php echo esc_url( get_theme_file_uri( 'images/product-3.webp' ) ); ?>" alt="Stonewashed linen folded in a basket" style="aspect-ratio:4/5;object-fit:cover"/><figcaption class="wp-element-caption">Flax linens · 2025</figcaption></figure>
		<!-- /wp:image -->

		<!-- wp:image {"className":"lk-frame","sizeSlug":"large","style":{"dimensions":{"aspectRatio":"4/5"}}} -->
		<figure class="wp-block-image size-large lk-frame"><img src="<?php echo esc_url( get_theme_file_uri( 'images/lifestyle-4.webp' ) ); ?>" alt="Botanical soap bars on a stone tray" style="aspect-ratio:4/5;object-fit:cover"/><figcaption class="wp-element-caption">Botanical bath · 2024</figcaption></figure>
		<!-- /wp:image -->

		<!-- wp:image {"className":"lk-frame","sizeSlug":"large","style":{"dimensions":{"aspectRatio":"4/5"}}} -->
		<figure class="wp-block-image size-large lk-frame"><img src="<?php echo esc_url( get_theme_file_uri( 'images/lifestyle-1.webp' ) ); ?>" alt="Hand-thrown mugs in warm earth glazes" style="aspect-ratio:4/5;object-fit:cover"/><figcaption class="wp-element-caption">Glazed mugs · 2024</figcaption></figure>
		<!-- /wp:image -->

		<!-- wp:image {"className":"lk-frame","sizeSlug":"large","style":{"dimensions":{"aspectRatio":"4/5"}}} -->
		<figure class="wp-block-image size-large lk-frame"><img src="<?php echo esc_url( get_theme_file_uri( 'images/product-2.webp' ) ); ?>" alt="A dried-flower arrangement in a ceramic vase" style="aspect-ratio:4/5;object-fit:cover"/><figcaption class="wp-element-caption">Still life · 2024</figcaption></figure>
		<!-- /wp:image -->

		<!-- wp:image {"className":"lk-frame","sizeSlug":"large","style":{"dimensions":{"aspectRatio":"4/5"}}} -->
		<figure class="wp-block-image size-large lk-frame"><img src="<?php echo esc_url( get_theme_file_uri( 'images/lifestyle-3.webp' ) ); ?>" alt="A potter's hands trimming a bowl on the wheel" style="aspect-ratio:4/5;object-fit:cover"/><figcaption class="wp-element-caption">At the wheel · 2023</figcaption></figure>
		<!-- /wp:image -->
	</figure>
	<!-- /wp:gallery -->
</section>
<!-- /wp:group -->
