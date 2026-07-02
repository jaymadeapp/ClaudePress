<?php
/**
 * Title: Loamkit — Case Study Hero
 * Slug: loamkit/case-study-hero
 * Categories: loamkit, featured, banner
 * Block Types:
 * Inserter: true
 * Description: A bold case-study header with client eyebrow, project title, summary, a meta row (role, year, services) and a large media placeholder.
 * Keywords: case study, project, hero, portfolio, header
 * Viewport Width: 1280
 */
?>
<!-- wp:group {"tagName":"section","lock":{"move":true,"remove":true},"align":"full","backgroundColor":"base","style":{"spacing":{"padding":{"top":"var:preset|spacing|70","bottom":"var:preset|spacing|70","left":"var:preset|spacing|40","right":"var:preset|spacing|40"}}},"layout":{"type":"constrained"}} -->
<section class="wp-block-group alignfull has-base-background-color has-background" style="padding-top:var(--wp--preset--spacing--70);padding-right:var(--wp--preset--spacing--40);padding-bottom:var(--wp--preset--spacing--70);padding-left:var(--wp--preset--spacing--40)">
	<!-- wp:paragraph {"className":"lk-reveal","textColor":"secondary","style":{"typography":{"textTransform":"uppercase","letterSpacing":"0.1em"},"elements":{"link":{"color":{"text":"var:preset|color|secondary"}}}},"fontSize":"small","fontFamily":"mono"} -->
	<p class="lk-reveal has-secondary-color has-text-color has-link-color has-small-font-size has-mono-font-family" style="letter-spacing:0.1em;text-transform:uppercase">Case study · Meridian</p>
	<!-- /wp:paragraph -->

	<!-- wp:heading {"level":1,"className":"lk-reveal","textColor":"contrast","style":{"spacing":{"margin":{"top":"var:preset|spacing|20"}}},"fontSize":"huge","fontFamily":"heading"} -->
	<h1 class="wp-block-heading lk-reveal has-contrast-color has-text-color has-huge-font-size has-heading-font-family" style="margin-top:var(--wp--preset--spacing--20)">Rebuilding a brand for its next <em class="has-display-font-family" style="font-weight:400;color:var(--wp--custom--color--accent-ink, var(--wp--preset--color--accent))">decade</em></h1>
	<!-- /wp:heading -->

	<!-- wp:paragraph {"className":"lk-reveal","textColor":"contrast-2","style":{"spacing":{"margin":{"top":"var:preset|spacing|30"}},"typography":{"lineHeight":"1.6"},"elements":{"link":{"color":{"text":"var:preset|color|contrast-2"}}}},"fontSize":"large","fontFamily":"body"} -->
	<p class="lk-reveal has-contrast-2-color has-text-color has-link-color has-large-font-size has-body-font-family" style="margin-top:var(--wp--preset--spacing--30);line-height:1.6">We worked with Meridian to rebuild their identity from the ground up — a clearer story, a warmer visual system, and a site that finally matches the care behind their work.</p>
	<!-- /wp:paragraph -->

	<!-- wp:columns {"style":{"spacing":{"margin":{"top":"var:preset|spacing|50"},"blockGap":{"left":"var:preset|spacing|50"}}}} -->
	<div class="wp-block-columns" style="margin-top:var(--wp--preset--spacing--50)">
		<!-- wp:column -->
		<div class="wp-block-column">
			<!-- wp:paragraph {"textColor":"contrast-2","style":{"typography":{"textTransform":"uppercase","letterSpacing":"0.06em"},"elements":{"link":{"color":{"text":"var:preset|color|contrast-2"}}}},"fontSize":"small","fontFamily":"heading"} -->
			<p class="has-contrast-2-color has-text-color has-link-color has-small-font-size has-heading-font-family" style="letter-spacing:0.06em;text-transform:uppercase">Role</p>
			<!-- /wp:paragraph -->

			<!-- wp:paragraph {"textColor":"contrast","style":{"spacing":{"margin":{"top":"0"}},"elements":{"link":{"color":{"text":"var:preset|color|contrast"}}}},"fontSize":"medium","fontFamily":"body"} -->
			<p class="has-contrast-color has-text-color has-link-color has-medium-font-size has-body-font-family" style="margin-top:0">Brand &amp; web design</p>
			<!-- /wp:paragraph -->
		</div>
		<!-- /wp:column -->

		<!-- wp:column -->
		<div class="wp-block-column">
			<!-- wp:paragraph {"textColor":"contrast-2","style":{"typography":{"textTransform":"uppercase","letterSpacing":"0.06em"},"elements":{"link":{"color":{"text":"var:preset|color|contrast-2"}}}},"fontSize":"small","fontFamily":"heading"} -->
			<p class="has-contrast-2-color has-text-color has-link-color has-small-font-size has-heading-font-family" style="letter-spacing:0.06em;text-transform:uppercase">Year</p>
			<!-- /wp:paragraph -->

			<!-- wp:paragraph {"textColor":"contrast","style":{"spacing":{"margin":{"top":"0"}},"elements":{"link":{"color":{"text":"var:preset|color|contrast"}}}},"fontSize":"medium","fontFamily":"body"} -->
			<p class="has-contrast-color has-text-color has-link-color has-medium-font-size has-body-font-family" style="margin-top:0">2025</p>
			<!-- /wp:paragraph -->
		</div>
		<!-- /wp:column -->

		<!-- wp:column -->
		<div class="wp-block-column">
			<!-- wp:paragraph {"textColor":"contrast-2","style":{"typography":{"textTransform":"uppercase","letterSpacing":"0.06em"},"elements":{"link":{"color":{"text":"var:preset|color|contrast-2"}}}},"fontSize":"small","fontFamily":"heading"} -->
			<p class="has-contrast-2-color has-text-color has-link-color has-small-font-size has-heading-font-family" style="letter-spacing:0.06em;text-transform:uppercase">Services</p>
			<!-- /wp:paragraph -->

			<!-- wp:paragraph {"textColor":"contrast","style":{"spacing":{"margin":{"top":"0"}},"elements":{"link":{"color":{"text":"var:preset|color|contrast"}}}},"fontSize":"medium","fontFamily":"body"} -->
			<p class="has-contrast-color has-text-color has-link-color has-medium-font-size has-body-font-family" style="margin-top:0">Strategy, Identity, Web</p>
			<!-- /wp:paragraph -->
		</div>
		<!-- /wp:column -->
	</div>
	<!-- /wp:columns -->

	<!-- wp:image {"className":"lk-frame lk-reveal","sizeSlug":"large","style":{"spacing":{"margin":{"top":"var:preset|spacing|50"}},"dimensions":{"aspectRatio":"16/9"}}} -->
	<figure class="wp-block-image size-large lk-frame lk-reveal" style="margin-top:var(--wp--preset--spacing--50)"><img src="<?php echo esc_url( get_theme_file_uri( 'images/hero.webp' ) ); ?>" alt="Meridian brand collateral laid out on a warm desk" style="aspect-ratio:16/9;object-fit:cover"/></figure>
	<!-- /wp:image -->
</section>
<!-- /wp:group -->
