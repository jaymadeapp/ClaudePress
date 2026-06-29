<?php
/**
 * Title: ClaudePress — Feature Rows
 * Slug: claudepress/feature-rows
 * Categories: claudepress, featured
 * Block Types:
 * Inserter: true
 * Description: Two alternating feature rows — an organic blob-masked image on one side, an eyebrow, headline and copy on the other, mirrored row to row.
 * Keywords: features, rows, alternating, zigzag, benefits, story
 * Viewport Width: 1280
 */
?>
<!-- wp:group {"tagName":"section","lock":{"move":true,"remove":true},"align":"full","backgroundColor":"base","style":{"spacing":{"padding":{"top":"var:preset|spacing|70","bottom":"var:preset|spacing|70","left":"var:preset|spacing|40","right":"var:preset|spacing|40"},"blockGap":"var:preset|spacing|70"}},"layout":{"type":"constrained"}} -->
<section class="wp-block-group alignfull has-base-background-color has-background" style="padding-top:var(--wp--preset--spacing--70);padding-right:var(--wp--preset--spacing--40);padding-bottom:var(--wp--preset--spacing--70);padding-left:var(--wp--preset--spacing--40)">
	<!-- wp:columns {"verticalAlignment":"center","style":{"spacing":{"blockGap":{"left":"var:preset|spacing|60"}}}} -->
	<div class="wp-block-columns are-vertically-aligned-center">
		<!-- wp:column {"verticalAlignment":"center","width":"50%"} -->
		<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:50%">
			<!-- wp:image {"className":"cp-blob-img cp-reveal","sizeSlug":"large","style":{"dimensions":{"aspectRatio":"1"}}} -->
			<figure class="wp-block-image size-large cp-blob-img cp-reveal"><img src="<?php echo esc_url( get_theme_file_uri( 'images/product-2.webp' ) ); ?>" alt="A row of stoneware mugs in warm earth tones" style="aspect-ratio:1;object-fit:cover"/></figure>
			<!-- /wp:image -->
		</div>
		<!-- /wp:column -->

		<!-- wp:column {"verticalAlignment":"center","width":"50%"} -->
		<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:50%">
			<!-- wp:paragraph {"className":"cp-reveal","style":{"typography":{"textTransform":"uppercase","letterSpacing":"0.1em"},"elements":{"link":{"color":{"text":"var:preset|color|secondary"}}}},"textColor":"secondary","fontSize":"small","fontFamily":"mono"} -->
			<p class="cp-reveal has-secondary-color has-text-color has-link-color has-small-font-size has-mono-font-family" style="letter-spacing:0.1em;text-transform:uppercase">The table</p>
			<!-- /wp:paragraph -->

			<!-- wp:heading {"className":"cp-reveal","style":{"spacing":{"margin":{"top":"var:preset|spacing|20"}}},"textColor":"contrast","fontSize":"x-large","fontFamily":"heading"} -->
			<h2 class="wp-block-heading cp-reveal has-contrast-color has-text-color has-x-large-font-size has-heading-font-family" style="margin-top:var(--wp--preset--spacing--20)">Tableware that earns its <em class="has-display-font-family" style="font-weight:400;color:var(--wp--custom--color--accent-ink, var(--wp--preset--color--accent))">keep</em>.</h2>
			<!-- /wp:heading -->

			<!-- wp:paragraph {"className":"cp-reveal","style":{"spacing":{"margin":{"top":"var:preset|spacing|30"}},"typography":{"lineHeight":"1.6"},"elements":{"link":{"color":{"text":"var:preset|color|contrast-2"}}}},"textColor":"contrast-2","fontSize":"medium","fontFamily":"body"} -->
			<p class="cp-reveal has-contrast-2-color has-text-color has-link-color has-medium-font-size has-body-font-family" style="margin-top:var(--wp--preset--spacing--30);line-height:1.6">Plates, bowls and cups weighted to feel good in the hand and built to go from oven to table to dishwasher, year after year.</p>
			<!-- /wp:paragraph -->
		</div>
		<!-- /wp:column -->
	</div>
	<!-- /wp:columns -->

	<!-- wp:columns {"verticalAlignment":"center","style":{"spacing":{"blockGap":{"left":"var:preset|spacing|60"}}}} -->
	<div class="wp-block-columns are-vertically-aligned-center">
		<!-- wp:column {"verticalAlignment":"center","width":"50%"} -->
		<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:50%">
			<!-- wp:paragraph {"className":"cp-reveal","style":{"typography":{"textTransform":"uppercase","letterSpacing":"0.1em"},"elements":{"link":{"color":{"text":"var:preset|color|secondary"}}}},"textColor":"secondary","fontSize":"small","fontFamily":"mono"} -->
			<p class="cp-reveal has-secondary-color has-text-color has-link-color has-small-font-size has-mono-font-family" style="letter-spacing:0.1em;text-transform:uppercase">The bath</p>
			<!-- /wp:paragraph -->

			<!-- wp:heading {"className":"cp-reveal","style":{"spacing":{"margin":{"top":"var:preset|spacing|20"}}},"textColor":"contrast","fontSize":"x-large","fontFamily":"heading"} -->
			<h2 class="wp-block-heading cp-reveal has-contrast-color has-text-color has-x-large-font-size has-heading-font-family" style="margin-top:var(--wp--preset--spacing--20)">A softer end to the <em class="has-display-font-family" style="font-weight:400;color:var(--wp--custom--color--accent-ink, var(--wp--preset--color--accent))">day</em>.</h2>
			<!-- /wp:heading -->

			<!-- wp:paragraph {"className":"cp-reveal","style":{"spacing":{"margin":{"top":"var:preset|spacing|30"}},"typography":{"lineHeight":"1.6"},"elements":{"link":{"color":{"text":"var:preset|color|contrast-2"}}}},"textColor":"contrast-2","fontSize":"medium","fontFamily":"body"} -->
			<p class="cp-reveal has-contrast-2-color has-text-color has-link-color has-medium-font-size has-body-font-family" style="margin-top:var(--wp--preset--spacing--30);line-height:1.6">Stonewashed linen towels, botanical balms and a single unscented soap. The small rituals that turn a bathroom into somewhere to slow down.</p>
			<!-- /wp:paragraph -->
		</div>
		<!-- /wp:column -->

		<!-- wp:column {"verticalAlignment":"center","width":"50%"} -->
		<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:50%">
			<!-- wp:image {"className":"cp-blob-img cp-reveal","sizeSlug":"large","style":{"dimensions":{"aspectRatio":"1"}}} -->
			<figure class="wp-block-image size-large cp-blob-img cp-reveal"><img src="<?php echo esc_url( get_theme_file_uri( 'images/lifestyle-2.webp' ) ); ?>" alt="Folded linen towels beside a bar of soap" style="aspect-ratio:1;object-fit:cover"/></figure>
			<!-- /wp:image -->
		</div>
		<!-- /wp:column -->
	</div>
	<!-- /wp:columns -->
</section>
<!-- /wp:group -->
