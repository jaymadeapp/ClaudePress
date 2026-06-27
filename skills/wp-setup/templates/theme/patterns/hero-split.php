<?php
/**
 * Title: ClaudePress — Hero (Split)
 * Slug: claudepress/hero-split
 * Categories: claudepress, featured, banner
 * Block Types:
 * Inserter: true
 * Description: A two-column hero with copy and call-to-action buttons on the left and a colored media placeholder on the right.
 * Keywords: hero, header, banner, split, two column
 * Viewport Width: 1280
 */
?>
<!-- wp:group {"tagName":"section","lock":{"move":true,"remove":true},"align":"full","backgroundColor":"base","style":{"spacing":{"padding":{"top":"var:preset|spacing|70","bottom":"var:preset|spacing|70","left":"var:preset|spacing|40","right":"var:preset|spacing|40"}}},"layout":{"type":"constrained"}} -->
<section class="wp-block-group alignfull has-base-background-color has-background" style="padding-top:var(--wp--preset--spacing--70);padding-right:var(--wp--preset--spacing--40);padding-bottom:var(--wp--preset--spacing--70);padding-left:var(--wp--preset--spacing--40)">
	<!-- wp:columns {"verticalAlignment":"center","style":{"spacing":{"blockGap":{"left":"var:preset|spacing|60"}}}} -->
	<div class="wp-block-columns are-vertically-aligned-center">
		<!-- wp:column {"verticalAlignment":"center","width":"50%"} -->
		<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:50%">
			<!-- wp:paragraph {"textColor":"primary","style":{"typography":{"textTransform":"uppercase","letterSpacing":"0.08em"},"elements":{"link":{"color":{"text":"var:preset|color|primary"}}}},"fontSize":"small","fontFamily":"heading"} -->
			<p class="has-primary-color has-text-color has-link-color has-small-font-size has-heading-font-family" style="letter-spacing:0.08em;text-transform:uppercase">Why teams choose us</p>
			<!-- /wp:paragraph -->

			<!-- wp:heading {"level":1,"textColor":"contrast","fontSize":"xx-large","fontFamily":"heading"} -->
			<h1 class="wp-block-heading has-contrast-color has-text-color has-xx-large-font-size has-heading-font-family">A faster path from idea to live website</h1>
			<!-- /wp:heading -->

			<!-- wp:paragraph {"textColor":"contrast-2","style":{"spacing":{"margin":{"top":"var:preset|spacing|30"}},"elements":{"link":{"color":{"text":"var:preset|color|contrast-2"}}}},"fontSize":"large","fontFamily":"body"} -->
			<p class="has-contrast-2-color has-text-color has-link-color has-large-font-size has-body-font-family" style="margin-top:var(--wp--preset--spacing--30)">Combine thoughtful design, reliable hosting, and content you can edit yourself. Everything works together so you can focus on your customers.</p>
			<!-- /wp:paragraph -->

			<!-- wp:buttons {"style":{"spacing":{"margin":{"top":"var:preset|spacing|40"},"blockGap":"var:preset|spacing|20"}}} -->
			<div class="wp-block-buttons" style="margin-top:var(--wp--preset--spacing--40)">
				<!-- wp:button {"backgroundColor":"primary","textColor":"base","style":{"elements":{"link":{"color":{"text":"var:preset|color|base"}}}}} -->
				<div class="wp-block-button"><a class="wp-block-button__link has-base-color has-primary-background-color has-text-color has-background has-link-color wp-element-button">Start your project</a></div>
				<!-- /wp:button -->

				<!-- wp:button {"textColor":"primary","className":"is-style-outline","style":{"elements":{"link":{"color":{"text":"var:preset|color|primary"}}}}} -->
				<div class="wp-block-button is-style-outline"><a class="wp-block-button__link has-primary-color has-text-color has-link-color wp-element-button">Talk to us</a></div>
				<!-- /wp:button -->
			</div>
			<!-- /wp:buttons -->
		</div>
		<!-- /wp:column -->

		<!-- wp:column {"verticalAlignment":"center","width":"50%"} -->
		<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:50%">
			<!-- wp:group {"backgroundColor":"surface-2","style":{"border":{"radius":"var:custom|radius|lg"},"spacing":{"padding":{"top":"var:preset|spacing|70","bottom":"var:preset|spacing|70","left":"var:preset|spacing|50","right":"var:preset|spacing|50"}},"dimensions":{"minHeight":"360px"}},"layout":{"type":"constrained","justifyContent":"center"}} -->
			<div class="wp-block-group has-surface-2-background-color has-background" style="border-radius:var(--wp--custom--radius--lg);min-height:360px;padding-top:var(--wp--preset--spacing--70);padding-right:var(--wp--preset--spacing--50);padding-bottom:var(--wp--preset--spacing--70);padding-left:var(--wp--preset--spacing--50)">
				<!-- wp:paragraph {"align":"center","textColor":"base","style":{"elements":{"link":{"color":{"text":"var:preset|color|base"}}}},"fontSize":"medium","fontFamily":"heading"} -->
				<p class="has-text-align-center has-base-color has-text-color has-link-color has-medium-font-size has-heading-font-family">Replace with your product screenshot or photo</p>
				<!-- /wp:paragraph -->
			</div>
			<!-- /wp:group -->
		</div>
		<!-- /wp:column -->
	</div>
	<!-- /wp:columns -->
</section>
<!-- /wp:group -->
