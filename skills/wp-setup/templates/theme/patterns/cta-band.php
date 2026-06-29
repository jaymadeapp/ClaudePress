<?php
/**
 * Title: ClaudePress — CTA Band
 * Slug: claudepress/cta-band
 * Categories: claudepress, featured, call-to-action
 * Block Types:
 * Inserter: true
 * Description: The single centered moment — a deep brand band with a big headline, a warm supporting line and a pill call-to-action.
 * Keywords: cta, call to action, banner, conversion, signup, brand
 * Viewport Width: 1280
 */
?>
<!-- wp:group {"tagName":"section","lock":{"move":true,"remove":true},"align":"full","backgroundColor":"primary","style":{"spacing":{"padding":{"top":"var:preset|spacing|80","bottom":"var:preset|spacing|80","left":"var:preset|spacing|40","right":"var:preset|spacing|40"}}},"layout":{"type":"constrained"}} -->
<section class="wp-block-group alignfull has-primary-background-color has-background" style="padding-top:var(--wp--preset--spacing--80);padding-right:var(--wp--preset--spacing--40);padding-bottom:var(--wp--preset--spacing--80);padding-left:var(--wp--preset--spacing--40)">
	<!-- Editorial spine kept: left-aligned copy column with the button trailing, an organic clay blob bleeding off the right edge. Layout wrapper locked; text + button stay editable. -->
	<!-- wp:group {"lock":{"move":true,"remove":true},"align":"wide","style":{"position":{"type":"relative"},"spacing":{"blockGap":"var:preset|spacing|40"}},"layout":{"type":"flex","flexWrap":"wrap","justifyContent":"space-between","verticalAlignment":"center"}} -->
	<div class="wp-block-group alignwide" style="position:relative">
		<!-- wp:html -->
		<span class="cp-blob-2" style="position:absolute;right:-6%;top:-32%;z-index:0;width:clamp(140px,18vw,260px);aspect-ratio:1;background:var(--wp--custom--color--on-primary, var(--wp--preset--color--base));opacity:.14;pointer-events:none" aria-hidden="true"></span>
		<!-- /wp:html -->

		<!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|20"},"layout":{"flexSize":"min(100%, 36rem)"}},"layout":{"type":"constrained"}} -->
		<div class="wp-block-group" style="flex-basis:min(100%, 36rem)">
			<!-- wp:paragraph {"className":"cp-reveal","style":{"typography":{"textTransform":"uppercase","letterSpacing":"0.1em"},"elements":{"link":{"color":{"text":"var:preset|color|secondary"}}}},"textColor":"secondary","fontSize":"small","fontFamily":"mono"} -->
			<p class="cp-reveal has-secondary-color has-text-color has-link-color has-small-font-size has-mono-font-family" style="letter-spacing:0.1em;text-transform:uppercase">Begin the ritual</p>
			<!-- /wp:paragraph -->

			<!-- wp:heading {"className":"cp-reveal","style":{"spacing":{"margin":{"top":"var:preset|spacing|20"}}},"textColor":"base","fontSize":"xx-large","fontFamily":"heading"} -->
			<h2 class="wp-block-heading cp-reveal has-base-color has-text-color has-xx-large-font-size has-heading-font-family" style="margin-top:var(--wp--preset--spacing--20)">Bring a little more calm <em class="has-display-font-family" style="font-weight:400;color:var(--wp--custom--color--on-primary, var(--wp--preset--color--base))">home</em>.</h2>
			<!-- /wp:heading -->

			<!-- wp:paragraph {"className":"cp-reveal","style":{"spacing":{"margin":{"top":"var:preset|spacing|30"}},"typography":{"lineHeight":"1.6"},"elements":{"link":{"color":{"text":"var:preset|color|surface"}}}},"textColor":"surface","fontSize":"large","fontFamily":"body"} -->
			<p class="cp-reveal has-surface-color has-text-color has-link-color has-large-font-size has-body-font-family" style="margin-top:var(--wp--preset--spacing--30);line-height:1.6">Start with one piece you'll use every day. We'll take it from there.</p>
			<!-- /wp:paragraph -->
		</div>
		<!-- /wp:group -->

		<!-- wp:buttons {"className":"cp-reveal","layout":{"type":"flex"}} -->
		<div class="wp-block-buttons cp-reveal">
			<!-- Inverse pill: an on-primary fill with primary-coloured text. Always contrasts
			     the primary band (on-primary is legible-on-primary by definition), so it stays
			     a visible button on every direction — even where accent === primary (Linen). -->
			<!-- wp:button {"className":"cp-cta-pill","style":{"border":{"radius":"var:custom|radius|pill"},"spacing":{"padding":{"top":"var:preset|spacing|30","bottom":"var:preset|spacing|30","left":"var:preset|spacing|50","right":"var:preset|spacing|50"}}},"fontFamily":"heading"} -->
			<div class="wp-block-button cp-cta-pill has-custom-font-size has-heading-font-family"><a class="wp-block-button__link wp-element-button cp-cta-pill" style="border-radius:var(--wp--custom--radius--pill);padding-top:var(--wp--preset--spacing--30);padding-right:var(--wp--preset--spacing--50);padding-bottom:var(--wp--preset--spacing--30);padding-left:var(--wp--preset--spacing--50);background-color:var(--wp--custom--color--on-primary, var(--wp--preset--color--base));color:var(--wp--preset--color--primary)">Shop the collection</a></div>
			<!-- /wp:button -->
		</div>
		<!-- /wp:buttons -->
	</div>
	<!-- /wp:group -->
</section>
<!-- /wp:group -->
