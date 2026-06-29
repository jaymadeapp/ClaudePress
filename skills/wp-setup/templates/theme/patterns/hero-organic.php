<?php
/**
 * Title: ClaudePress — Hero (Organic)
 * Slug: claudepress/hero-organic
 * Categories: claudepress, featured, banner
 * Block Types:
 * Inserter: true
 * Description: An asymmetric, left-aligned hero — eyebrow, big headline with a Fraunces-italic accent word, warm sub, a pill button and a text link, paired with a large organic clay blob and an overlapping sage blob.
 * Keywords: hero, header, banner, intro, headline, organic, blob
 * Viewport Width: 1280
 */
?>
<!-- wp:group {"tagName":"section","lock":{"move":true,"remove":true},"align":"full","backgroundColor":"base","style":{"spacing":{"padding":{"top":"var:preset|spacing|70","bottom":"var:preset|spacing|70","left":"var:preset|spacing|40","right":"var:preset|spacing|40"}}},"layout":{"type":"constrained"}} -->
<section class="wp-block-group alignfull has-base-background-color has-background" style="padding-top:var(--wp--preset--spacing--70);padding-right:var(--wp--preset--spacing--40);padding-bottom:var(--wp--preset--spacing--70);padding-left:var(--wp--preset--spacing--40)">
	<!-- wp:columns {"verticalAlignment":"center","style":{"spacing":{"blockGap":{"left":"var:preset|spacing|60"}}}} -->
	<div class="wp-block-columns are-vertically-aligned-center">
		<!-- wp:column {"verticalAlignment":"center","width":"56%"} -->
		<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:56%">
			<!-- wp:paragraph {"className":"cp-reveal","style":{"typography":{"textTransform":"uppercase","letterSpacing":"0.1em"},"elements":{"link":{"color":{"text":"var:preset|color|secondary"}}}},"textColor":"secondary","fontSize":"small","fontFamily":"mono"} -->
			<p class="cp-reveal has-secondary-color has-text-color has-link-color has-small-font-size has-mono-font-family" style="letter-spacing:0.1em;text-transform:uppercase;--i:0">Rooted in care</p>
			<!-- /wp:paragraph -->

			<!-- wp:heading {"level":1,"className":"cp-reveal","style":{"spacing":{"margin":{"top":"var:preset|spacing|30"}}},"textColor":"contrast","fontSize":"huge","fontFamily":"heading"} -->
			<h1 class="wp-block-heading cp-reveal has-contrast-color has-text-color has-huge-font-size has-heading-font-family" style="margin-top:var(--wp--preset--spacing--30);--i:1">A calmer way to <em class="has-display-font-family" style="font-weight:400;color:var(--wp--custom--color--accent-ink, var(--wp--preset--color--accent))">live well</em>.</h1>
			<!-- /wp:heading -->

			<!-- wp:paragraph {"className":"cp-reveal","style":{"spacing":{"margin":{"top":"var:preset|spacing|30"}},"typography":{"lineHeight":"1.6"},"elements":{"link":{"color":{"text":"var:preset|color|contrast-2"}}}},"textColor":"contrast-2","fontSize":"large","fontFamily":"body"} -->
			<p class="cp-reveal has-contrast-2-color has-text-color has-link-color has-large-font-size has-body-font-family" style="margin-top:var(--wp--preset--spacing--30);line-height:1.6;--i:2">Thoughtful essentials, made from honest materials — for a slower, warmer everyday.</p>
			<!-- /wp:paragraph -->

			<!-- wp:buttons {"className":"cp-reveal","style":{"spacing":{"margin":{"top":"var:preset|spacing|40"},"blockGap":"var:preset|spacing|40"}}} -->
			<div class="wp-block-buttons cp-reveal" style="margin-top:var(--wp--preset--spacing--40);--i:3">
				<!-- wp:button {"backgroundColor":"primary","textColor":"base","style":{"border":{"radius":"var:custom|radius|pill"},"spacing":{"padding":{"top":"var:preset|spacing|30","bottom":"var:preset|spacing|30","left":"var:preset|spacing|50","right":"var:preset|spacing|50"}},"elements":{"link":{"color":{"text":"var:preset|color|base"}}}},"fontFamily":"heading"} -->
				<div class="wp-block-button has-custom-font-size has-heading-font-family"><a class="wp-block-button__link has-base-color has-primary-background-color has-text-color has-background has-link-color wp-element-button" style="border-radius:var(--wp--custom--radius--pill);padding-top:var(--wp--preset--spacing--30);padding-right:var(--wp--preset--spacing--50);padding-bottom:var(--wp--preset--spacing--30);padding-left:var(--wp--preset--spacing--50)">Discover the ritual</a></div>
				<!-- /wp:button -->

				<!-- wp:button {"textColor":"primary","className":"is-style-outline cp-link-plain","style":{"border":{"width":"0px","style":"none"},"spacing":{"padding":{"top":"var:preset|spacing|30","bottom":"var:preset|spacing|30","left":"0","right":"0"}},"elements":{"link":{"color":{"text":"var:preset|color|primary"}}}},"fontFamily":"heading"} -->
				<div class="wp-block-button is-style-outline cp-link-plain has-custom-font-size has-heading-font-family"><a class="wp-block-button__link has-primary-color has-text-color has-link-color wp-element-button" style="border-style:none;border-width:0px;padding-top:var(--wp--preset--spacing--30);padding-right:0;padding-bottom:var(--wp--preset--spacing--30);padding-left:0">Read our story →</a></div>
				<!-- /wp:button -->
			</div>
			<!-- /wp:buttons -->
		</div>
		<!-- /wp:column -->

		<!-- wp:column {"verticalAlignment":"center","width":"44%"} -->
		<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:44%">
			<!-- wp:group {"className":"cp-reveal","style":{"dimensions":{"aspectRatio":"1"},"position":{"type":"relative"}},"layout":{"type":"constrained","justifyContent":"center"}} -->
			<div class="wp-block-group cp-reveal" style="position:relative;aspect-ratio:1">
				<!-- wp:group {"className":"cp-blob","style":{"dimensions":{"aspectRatio":"1"},"background":{"backgroundImage":{"ref":""},"backgroundGradient":"var:preset|gradient|clay"}},"gradient":"clay","layout":{"type":"constrained"}} -->
				<div class="wp-block-group cp-blob has-clay-gradient-background has-background" style="aspect-ratio:1"></div>
				<!-- /wp:group -->

				<!-- wp:group {"className":"cp-blob-2","style":{"dimensions":{"aspectRatio":"1"},"position":{"type":"absolute","right":"2%","bottom":"4%"},"width":"42%"},"backgroundColor":"secondary","layout":{"type":"constrained"}} -->
				<div class="wp-block-group cp-blob-2 has-secondary-background-color has-background" style="position:absolute;right:2%;bottom:4%;aspect-ratio:1;width:42%"></div>
				<!-- /wp:group -->
			</div>
			<!-- /wp:group -->
		</div>
		<!-- /wp:column -->
	</div>
	<!-- /wp:columns -->
</section>
<!-- /wp:group -->
