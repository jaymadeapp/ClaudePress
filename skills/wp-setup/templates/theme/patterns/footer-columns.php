<?php
/**
 * Title: ClaudePress — Footer (Columns)
 * Slug: claudepress/footer-columns
 * Categories: claudepress, featured
 * Block Types: core/template-part/footer
 * Inserter: true
 * Description: A dark multi-column footer with a brand blurb, two link columns, and a bottom copyright row.
 * Keywords: footer, columns, links, sitemap, copyright
 * Viewport Width: 1280
 */
?>
<!-- wp:group {"tagName":"footer","lock":{"move":true,"remove":true},"align":"full","backgroundColor":"surface-2","style":{"spacing":{"padding":{"top":"var:preset|spacing|70","bottom":"var:preset|spacing|50","left":"var:preset|spacing|40","right":"var:preset|spacing|40"},"blockGap":"var:preset|spacing|50"}},"layout":{"type":"constrained"}} -->
<footer class="wp-block-group alignfull has-surface-2-background-color has-background" style="padding-top:var(--wp--preset--spacing--70);padding-right:var(--wp--preset--spacing--40);padding-bottom:var(--wp--preset--spacing--50);padding-left:var(--wp--preset--spacing--40)">
	<!-- wp:columns {"style":{"spacing":{"blockGap":{"left":"var:preset|spacing|50"}}}} -->
	<div class="wp-block-columns">
		<!-- wp:column {"width":"40%"} -->
		<div class="wp-block-column" style="flex-basis:40%">
			<!-- wp:heading {"level":3,"textColor":"base","fontSize":"large","fontFamily":"heading"} -->
			<h3 class="wp-block-heading has-base-color has-text-color has-large-font-size has-heading-font-family">Your Brand</h3>
			<!-- /wp:heading -->

			<!-- wp:paragraph {"textColor":"surface","style":{"spacing":{"margin":{"top":"var:preset|spacing|20"}},"elements":{"link":{"color":{"text":"var:preset|color|surface"}}}},"fontSize":"medium","fontFamily":"body"} -->
			<p class="has-surface-color has-text-color has-link-color has-medium-font-size has-body-font-family" style="margin-top:var(--wp--preset--spacing--20)">Helping businesses launch fast, reliable websites they can manage themselves. Built with care, made to last.</p>
			<!-- /wp:paragraph -->
		</div>
		<!-- /wp:column -->

		<!-- wp:column -->
		<div class="wp-block-column">
			<!-- wp:heading {"level":4,"textColor":"base","fontSize":"medium","fontFamily":"heading"} -->
			<h4 class="wp-block-heading has-base-color has-text-color has-medium-font-size has-heading-font-family">Company</h4>
			<!-- /wp:heading -->

			<!-- wp:paragraph {"textColor":"surface","style":{"spacing":{"margin":{"top":"var:preset|spacing|20"}},"elements":{"link":{"color":{"text":"var:preset|color|surface"}}}},"fontSize":"medium","fontFamily":"body"} -->
			<p class="has-surface-color has-text-color has-link-color has-medium-font-size has-body-font-family" style="margin-top:var(--wp--preset--spacing--20)"><a href="#">About</a><br>Careers<br>Contact<br>Blog</p>
			<!-- /wp:paragraph -->
		</div>
		<!-- /wp:column -->

		<!-- wp:column -->
		<div class="wp-block-column">
			<!-- wp:heading {"level":4,"textColor":"base","fontSize":"medium","fontFamily":"heading"} -->
			<h4 class="wp-block-heading has-base-color has-text-color has-medium-font-size has-heading-font-family">Resources</h4>
			<!-- /wp:heading -->

			<!-- wp:paragraph {"textColor":"surface","style":{"spacing":{"margin":{"top":"var:preset|spacing|20"}},"elements":{"link":{"color":{"text":"var:preset|color|surface"}}}},"fontSize":"medium","fontFamily":"body"} -->
			<p class="has-surface-color has-text-color has-link-color has-medium-font-size has-body-font-family" style="margin-top:var(--wp--preset--spacing--20)">Documentation<br>Support<br>Privacy<br>Terms</p>
			<!-- /wp:paragraph -->
		</div>
		<!-- /wp:column -->
	</div>
	<!-- /wp:columns -->

	<!-- wp:separator {"backgroundColor":"contrast-2","className":"is-style-wide"} -->
	<hr class="wp-block-separator has-text-color has-contrast-2-color has-alpha-channel-opacity has-contrast-2-background-color has-background is-style-wide"/>
	<!-- /wp:separator -->

	<!-- wp:paragraph {"align":"center","textColor":"contrast-2","style":{"elements":{"link":{"color":{"text":"var:preset|color|contrast-2"}}}},"fontSize":"small","fontFamily":"body"} -->
	<p class="has-text-align-center has-contrast-2-color has-text-color has-link-color has-small-font-size has-body-font-family">© 2026 Your Brand. All rights reserved.</p>
	<!-- /wp:paragraph -->
</footer>
<!-- /wp:group -->
