<?php
/**
 * Title: ClaudePress — Project Gallery
 * Slug: claudepress/project-gallery
 * Categories: claudepress, featured, gallery
 * Block Types:
 * Inserter: true
 * Description: A responsive gallery grid of project tiles, each a colored placeholder with a caption ready to swap for real work.
 * Keywords: portfolio, gallery, projects, grid, work, showcase
 * Viewport Width: 1280
 */
?>
<!-- wp:group {"tagName":"section","lock":{"move":true,"remove":true},"align":"full","backgroundColor":"base","style":{"spacing":{"padding":{"top":"var:preset|spacing|70","bottom":"var:preset|spacing|70","left":"var:preset|spacing|40","right":"var:preset|spacing|40"}}},"layout":{"type":"constrained"}} -->
<section class="wp-block-group alignfull has-base-background-color has-background" style="padding-top:var(--wp--preset--spacing--70);padding-right:var(--wp--preset--spacing--40);padding-bottom:var(--wp--preset--spacing--70);padding-left:var(--wp--preset--spacing--40)">
	<!-- wp:heading {"textColor":"contrast","style":{"spacing":{"margin":{"bottom":"var:preset|spacing|20"}}},"fontSize":"xx-large","fontFamily":"heading"} -->
	<h2 class="wp-block-heading has-contrast-color has-text-color has-xx-large-font-size has-heading-font-family" style="margin-bottom:var(--wp--preset--spacing--20)">Selected work</h2>
	<!-- /wp:heading -->

	<!-- wp:paragraph {"textColor":"contrast-2","style":{"spacing":{"margin":{"bottom":"var:preset|spacing|50"}},"elements":{"link":{"color":{"text":"var:preset|color|contrast-2"}}}},"fontSize":"large","fontFamily":"body"} -->
	<p class="has-contrast-2-color has-text-color has-link-color has-large-font-size has-body-font-family" style="margin-bottom:var(--wp--preset--spacing--50)">A few recent projects. Replace each tile with your own images and captions.</p>
	<!-- /wp:paragraph -->

	<!-- wp:columns {"style":{"spacing":{"blockGap":{"left":"var:preset|spacing|30","top":"var:preset|spacing|30"}}}} -->
	<div class="wp-block-columns">
		<!-- wp:column -->
		<div class="wp-block-column">
			<!-- wp:group {"backgroundColor":"surface","style":{"border":{"radius":"var:custom|radius|lg"},"spacing":{"padding":{"top":"var:preset|spacing|70","bottom":"var:preset|spacing|70"}},"dimensions":{"minHeight":"260px"}},"layout":{"type":"constrained","justifyContent":"center"}} -->
			<div class="wp-block-group has-surface-background-color has-background" style="border-radius:var(--wp--custom--radius--lg);min-height:260px;padding-top:var(--wp--preset--spacing--70);padding-bottom:var(--wp--preset--spacing--70)">
				<!-- wp:paragraph {"align":"center","textColor":"contrast-2","fontSize":"medium","fontFamily":"heading"} -->
				<p class="has-text-align-center has-contrast-2-color has-text-color has-medium-font-size has-heading-font-family">Project One</p>
				<!-- /wp:paragraph -->
			</div>
			<!-- /wp:group -->

			<!-- wp:paragraph {"textColor":"contrast","style":{"spacing":{"margin":{"top":"var:preset|spacing|20"}},"elements":{"link":{"color":{"text":"var:preset|color|contrast"}}}},"fontSize":"medium","fontFamily":"heading"} -->
			<p class="has-contrast-color has-text-color has-link-color has-medium-font-size has-heading-font-family" style="margin-top:var(--wp--preset--spacing--20)">Brand identity · 2025</p>
			<!-- /wp:paragraph -->
		</div>
		<!-- /wp:column -->

		<!-- wp:column -->
		<div class="wp-block-column">
			<!-- wp:group {"backgroundColor":"surface-2","style":{"border":{"radius":"var:custom|radius|lg"},"spacing":{"padding":{"top":"var:preset|spacing|70","bottom":"var:preset|spacing|70"}},"dimensions":{"minHeight":"260px"}},"layout":{"type":"constrained","justifyContent":"center"}} -->
			<div class="wp-block-group has-surface-2-background-color has-background" style="border-radius:var(--wp--custom--radius--lg);min-height:260px;padding-top:var(--wp--preset--spacing--70);padding-bottom:var(--wp--preset--spacing--70)">
				<!-- wp:paragraph {"align":"center","textColor":"base","fontSize":"medium","fontFamily":"heading"} -->
				<p class="has-text-align-center has-base-color has-text-color has-medium-font-size has-heading-font-family">Project Two</p>
				<!-- /wp:paragraph -->
			</div>
			<!-- /wp:group -->

			<!-- wp:paragraph {"textColor":"contrast","style":{"spacing":{"margin":{"top":"var:preset|spacing|20"}},"elements":{"link":{"color":{"text":"var:preset|color|contrast"}}}},"fontSize":"medium","fontFamily":"heading"} -->
			<p class="has-contrast-color has-text-color has-link-color has-medium-font-size has-heading-font-family" style="margin-top:var(--wp--preset--spacing--20)">Web design · 2025</p>
			<!-- /wp:paragraph -->
		</div>
		<!-- /wp:column -->

		<!-- wp:column -->
		<div class="wp-block-column">
			<!-- wp:group {"backgroundColor":"primary","style":{"border":{"radius":"var:custom|radius|lg"},"spacing":{"padding":{"top":"var:preset|spacing|70","bottom":"var:preset|spacing|70"}},"dimensions":{"minHeight":"260px"}},"layout":{"type":"constrained","justifyContent":"center"}} -->
			<div class="wp-block-group has-primary-background-color has-background" style="border-radius:var(--wp--custom--radius--lg);min-height:260px;padding-top:var(--wp--preset--spacing--70);padding-bottom:var(--wp--preset--spacing--70)">
				<!-- wp:paragraph {"align":"center","textColor":"base","fontSize":"medium","fontFamily":"heading"} -->
				<p class="has-text-align-center has-base-color has-text-color has-medium-font-size has-heading-font-family">Project Three</p>
				<!-- /wp:paragraph -->
			</div>
			<!-- /wp:group -->

			<!-- wp:paragraph {"textColor":"contrast","style":{"spacing":{"margin":{"top":"var:preset|spacing|20"}},"elements":{"link":{"color":{"text":"var:preset|color|contrast"}}}},"fontSize":"medium","fontFamily":"heading"} -->
			<p class="has-contrast-color has-text-color has-link-color has-medium-font-size has-heading-font-family" style="margin-top:var(--wp--preset--spacing--20)">Art direction · 2024</p>
			<!-- /wp:paragraph -->
		</div>
		<!-- /wp:column -->
	</div>
	<!-- /wp:columns -->

	<!-- wp:columns {"style":{"spacing":{"blockGap":{"left":"var:preset|spacing|30","top":"var:preset|spacing|30"},"margin":{"top":"var:preset|spacing|30"}}}} -->
	<div class="wp-block-columns" style="margin-top:var(--wp--preset--spacing--30)">
		<!-- wp:column -->
		<div class="wp-block-column">
			<!-- wp:group {"backgroundColor":"secondary","style":{"border":{"radius":"var:custom|radius|lg"},"spacing":{"padding":{"top":"var:preset|spacing|70","bottom":"var:preset|spacing|70"}},"dimensions":{"minHeight":"260px"}},"layout":{"type":"constrained","justifyContent":"center"}} -->
			<div class="wp-block-group has-secondary-background-color has-background" style="border-radius:var(--wp--custom--radius--lg);min-height:260px;padding-top:var(--wp--preset--spacing--70);padding-bottom:var(--wp--preset--spacing--70)">
				<!-- wp:paragraph {"align":"center","textColor":"base","fontSize":"medium","fontFamily":"heading"} -->
				<p class="has-text-align-center has-base-color has-text-color has-medium-font-size has-heading-font-family">Project Four</p>
				<!-- /wp:paragraph -->
			</div>
			<!-- /wp:group -->

			<!-- wp:paragraph {"textColor":"contrast","style":{"spacing":{"margin":{"top":"var:preset|spacing|20"}},"elements":{"link":{"color":{"text":"var:preset|color|contrast"}}}},"fontSize":"medium","fontFamily":"heading"} -->
			<p class="has-contrast-color has-text-color has-link-color has-medium-font-size has-heading-font-family" style="margin-top:var(--wp--preset--spacing--20)">Packaging · 2024</p>
			<!-- /wp:paragraph -->
		</div>
		<!-- /wp:column -->

		<!-- wp:column -->
		<div class="wp-block-column">
			<!-- wp:group {"backgroundColor":"accent","style":{"border":{"radius":"var:custom|radius|lg"},"spacing":{"padding":{"top":"var:preset|spacing|70","bottom":"var:preset|spacing|70"}},"dimensions":{"minHeight":"260px"}},"layout":{"type":"constrained","justifyContent":"center"}} -->
			<div class="wp-block-group has-accent-background-color has-background" style="border-radius:var(--wp--custom--radius--lg);min-height:260px;padding-top:var(--wp--preset--spacing--70);padding-bottom:var(--wp--preset--spacing--70)">
				<!-- wp:paragraph {"align":"center","textColor":"base","fontSize":"medium","fontFamily":"heading"} -->
				<p class="has-text-align-center has-base-color has-text-color has-medium-font-size has-heading-font-family">Project Five</p>
				<!-- /wp:paragraph -->
			</div>
			<!-- /wp:group -->

			<!-- wp:paragraph {"textColor":"contrast","style":{"spacing":{"margin":{"top":"var:preset|spacing|20"}},"elements":{"link":{"color":{"text":"var:preset|color|contrast"}}}},"fontSize":"medium","fontFamily":"heading"} -->
			<p class="has-contrast-color has-text-color has-link-color has-medium-font-size has-heading-font-family" style="margin-top:var(--wp--preset--spacing--20)">Motion · 2024</p>
			<!-- /wp:paragraph -->
		</div>
		<!-- /wp:column -->

		<!-- wp:column -->
		<div class="wp-block-column">
			<!-- wp:group {"backgroundColor":"surface","style":{"border":{"radius":"var:custom|radius|lg","color":"var:preset|color|border","width":"1px"},"spacing":{"padding":{"top":"var:preset|spacing|70","bottom":"var:preset|spacing|70"}},"dimensions":{"minHeight":"260px"}},"layout":{"type":"constrained","justifyContent":"center"}} -->
			<div class="wp-block-group has-surface-background-color has-background has-border-color" style="border-color:var(--wp--preset--color--border);border-width:1px;border-radius:var(--wp--custom--radius--lg);min-height:260px;padding-top:var(--wp--preset--spacing--70);padding-bottom:var(--wp--preset--spacing--70)">
				<!-- wp:paragraph {"align":"center","textColor":"contrast-2","fontSize":"medium","fontFamily":"heading"} -->
				<p class="has-text-align-center has-contrast-2-color has-text-color has-medium-font-size has-heading-font-family">Project Six</p>
				<!-- /wp:paragraph -->
			</div>
			<!-- /wp:group -->

			<!-- wp:paragraph {"textColor":"contrast","style":{"spacing":{"margin":{"top":"var:preset|spacing|20"}},"elements":{"link":{"color":{"text":"var:preset|color|contrast"}}}},"fontSize":"medium","fontFamily":"heading"} -->
			<p class="has-contrast-color has-text-color has-link-color has-medium-font-size has-heading-font-family" style="margin-top:var(--wp--preset--spacing--20)">Editorial · 2023</p>
			<!-- /wp:paragraph -->
		</div>
		<!-- /wp:column -->
	</div>
	<!-- /wp:columns -->
</section>
<!-- /wp:group -->
