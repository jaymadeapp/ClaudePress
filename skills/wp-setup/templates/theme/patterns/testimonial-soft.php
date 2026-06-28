<?php
/**
 * Title: ClaudePress — Testimonial (Soft)
 * Slug: claudepress/testimonial-soft
 * Categories: claudepress, featured
 * Block Types:
 * Inserter: true
 * Description: A warm, generously spaced testimonial band — a lead quote in display type plus two supporting voices on soft cards, on a sand surface.
 * Keywords: testimonials, reviews, quotes, social proof, customers
 * Viewport Width: 1280
 */
?>
<!-- wp:group {"tagName":"section","lock":{"move":true,"remove":true},"align":"full","backgroundColor":"surface","style":{"spacing":{"padding":{"top":"var:preset|spacing|70","bottom":"var:preset|spacing|70","left":"var:preset|spacing|40","right":"var:preset|spacing|40"}}},"layout":{"type":"constrained"}} -->
<section class="wp-block-group alignfull has-surface-background-color has-background" style="padding-top:var(--wp--preset--spacing--70);padding-right:var(--wp--preset--spacing--40);padding-bottom:var(--wp--preset--spacing--70);padding-left:var(--wp--preset--spacing--40)">
	<!-- wp:paragraph {"className":"cp-reveal","style":{"typography":{"textTransform":"uppercase","letterSpacing":"0.1em"},"elements":{"link":{"color":{"text":"var:preset|color|secondary"}}}},"textColor":"secondary","fontSize":"small","fontFamily":"mono"} -->
	<p class="cp-reveal has-secondary-color has-text-color has-link-color has-small-font-size has-mono-font-family" style="letter-spacing:0.1em;text-transform:uppercase">Kind words</p>
	<!-- /wp:paragraph -->

	<!-- wp:quote {"className":"cp-reveal","style":{"spacing":{"margin":{"top":"var:preset|spacing|40","bottom":"var:preset|spacing|60"}},"typography":{"lineHeight":"1.3"},"border":{"width":"0px","style":"none"}}} -->
	<blockquote class="wp-block-quote cp-reveal" style="border-style:none;border-width:0px;margin-top:var(--wp--preset--spacing--40);margin-bottom:var(--wp--preset--spacing--60);line-height:1.3">
		<!-- wp:paragraph {"style":{"typography":{"lineHeight":"1.3"}},"textColor":"contrast","fontSize":"x-large","fontFamily":"display"} -->
		<p class="has-contrast-color has-text-color has-x-large-font-size has-display-font-family" style="line-height:1.3">"It's the only mug I reach for. Two years in, the glaze has worn into something even better than the day it arrived."</p>
		<!-- /wp:paragraph -->

		<!-- wp:paragraph {"style":{"spacing":{"margin":{"top":"var:preset|spacing|30"}},"elements":{"link":{"color":{"text":"var:preset|color|primary"}}}},"textColor":"primary","fontSize":"medium","fontFamily":"heading"} -->
		<p class="has-primary-color has-text-color has-link-color has-medium-font-size has-heading-font-family" style="margin-top:var(--wp--preset--spacing--30)"><strong>Elena Marsh</strong> · Keeps the diffuser by her desk</p>
		<!-- /wp:paragraph -->
	</blockquote>
	<!-- /wp:quote -->

	<!-- wp:columns {"className":"cp-reveal","style":{"spacing":{"blockGap":{"left":"var:preset|spacing|40"}}}} -->
	<div class="wp-block-columns cp-reveal">
		<!-- wp:column -->
		<div class="wp-block-column">
			<!-- wp:group {"style":{"border":{"radius":"var:custom|radius|xl","color":"var:preset|color|border","width":"1px"},"spacing":{"padding":{"top":"var:preset|spacing|50","bottom":"var:preset|spacing|50","left":"var:preset|spacing|50","right":"var:preset|spacing|50"},"blockGap":"var:preset|spacing|30"}},"backgroundColor":"base","layout":{"type":"constrained"}} -->
			<div class="wp-block-group has-base-background-color has-background has-border-color" style="border-color:var(--wp--preset--color--border);border-width:1px;border-radius:var(--wp--custom--radius--xl);padding-top:var(--wp--preset--spacing--50);padding-right:var(--wp--preset--spacing--50);padding-bottom:var(--wp--preset--spacing--50);padding-left:var(--wp--preset--spacing--50)">
				<!-- wp:paragraph {"style":{"typography":{"lineHeight":"1.6"},"elements":{"link":{"color":{"text":"var:preset|color|contrast"}}}},"textColor":"contrast","fontSize":"large","fontFamily":"body"} -->
				<p class="has-contrast-color has-text-color has-link-color has-large-font-size has-body-font-family" style="line-height:1.6">"The linen robe gets softer every wash. It feels like an heirloom I happened to buy new."</p>
				<!-- /wp:paragraph -->

				<!-- wp:paragraph {"style":{"spacing":{"margin":{"top":"0"}},"elements":{"link":{"color":{"text":"var:preset|color|contrast-2"}}}},"textColor":"contrast-2","fontSize":"small","fontFamily":"heading"} -->
				<p class="has-contrast-2-color has-text-color has-link-color has-small-font-size has-heading-font-family" style="margin-top:0">Theo Nakamura · Portland</p>
				<!-- /wp:paragraph -->
			</div>
			<!-- /wp:group -->
		</div>
		<!-- /wp:column -->

		<!-- wp:column -->
		<div class="wp-block-column">
			<!-- wp:group {"style":{"border":{"radius":"var:custom|radius|xl","color":"var:preset|color|border","width":"1px"},"spacing":{"padding":{"top":"var:preset|spacing|50","bottom":"var:preset|spacing|50","left":"var:preset|spacing|50","right":"var:preset|spacing|50"},"blockGap":"var:preset|spacing|30"}},"backgroundColor":"base","layout":{"type":"constrained"}} -->
			<div class="wp-block-group has-base-background-color has-background has-border-color" style="border-color:var(--wp--preset--color--border);border-width:1px;border-radius:var(--wp--custom--radius--xl);padding-top:var(--wp--preset--spacing--50);padding-right:var(--wp--preset--spacing--50);padding-bottom:var(--wp--preset--spacing--50);padding-left:var(--wp--preset--spacing--50)">
				<!-- wp:paragraph {"style":{"typography":{"lineHeight":"1.6"},"elements":{"link":{"color":{"text":"var:preset|color|contrast"}}}},"textColor":"contrast","fontSize":"large","fontFamily":"body"} -->
				<p class="has-contrast-color has-text-color has-link-color has-large-font-size has-body-font-family" style="line-height:1.6">"I ordered one bowl to try. Three months later I've quietly replaced the whole cupboard."</p>
				<!-- /wp:paragraph -->

				<!-- wp:paragraph {"style":{"spacing":{"margin":{"top":"0"}},"elements":{"link":{"color":{"text":"var:preset|color|contrast-2"}}}},"textColor":"contrast-2","fontSize":"small","fontFamily":"heading"} -->
				<p class="has-contrast-2-color has-text-color has-link-color has-small-font-size has-heading-font-family" style="margin-top:0">Priya Raman · Bristol</p>
				<!-- /wp:paragraph -->
			</div>
			<!-- /wp:group -->
		</div>
		<!-- /wp:column -->
	</div>
	<!-- /wp:columns -->
</section>
<!-- /wp:group -->
