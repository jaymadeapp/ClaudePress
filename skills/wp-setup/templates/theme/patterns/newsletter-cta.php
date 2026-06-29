<?php
/**
 * Title: Loamkit — Newsletter CTA
 * Slug: loamkit/newsletter-cta
 * Categories: loamkit, featured, call-to-action
 * Block Types:
 * Inserter: true
 * Description: An asymmetric newsletter sign-up band — eyebrow, headline and supporting line on one side, a left-aligned subscribe form on the other, on a warm surface background.
 * Keywords: newsletter, subscribe, email, signup, cta
 * Viewport Width: 1280
 */
?>
<!-- wp:group {"tagName":"section","lock":{"move":true,"remove":true},"align":"full","backgroundColor":"surface","style":{"spacing":{"padding":{"top":"var:preset|spacing|70","bottom":"var:preset|spacing|70","left":"var:preset|spacing|40","right":"var:preset|spacing|40"}}},"layout":{"type":"constrained"}} -->
<section class="wp-block-group alignfull has-surface-background-color has-background" style="padding-top:var(--wp--preset--spacing--70);padding-right:var(--wp--preset--spacing--40);padding-bottom:var(--wp--preset--spacing--70);padding-left:var(--wp--preset--spacing--40)">
	<!-- wp:columns {"verticalAlignment":"center","style":{"spacing":{"blockGap":{"left":"var:preset|spacing|60"}}}} -->
	<div class="wp-block-columns are-vertically-aligned-center">
		<!-- wp:column {"verticalAlignment":"center","width":"52%"} -->
		<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:52%">
			<!-- wp:paragraph {"className":"cp-reveal","style":{"typography":{"textTransform":"uppercase","letterSpacing":"0.1em"},"elements":{"link":{"color":{"text":"var:preset|color|secondary"}}}},"textColor":"secondary","fontSize":"small","fontFamily":"mono"} -->
			<p class="cp-reveal has-secondary-color has-text-color has-link-color has-small-font-size has-mono-font-family" style="letter-spacing:0.1em;text-transform:uppercase">The letter</p>
			<!-- /wp:paragraph -->

			<!-- wp:heading {"className":"cp-reveal","style":{"spacing":{"margin":{"top":"var:preset|spacing|20"}}},"textColor":"contrast","fontSize":"xx-large","fontFamily":"heading"} -->
			<h2 class="wp-block-heading cp-reveal has-contrast-color has-text-color has-xx-large-font-size has-heading-font-family" style="margin-top:var(--wp--preset--spacing--20)">A little more <em class="has-display-font-family" style="font-weight:400;color:var(--wp--custom--color--accent-ink, var(--wp--preset--color--accent))">calm</em>, monthly</h2>
			<!-- /wp:heading -->

			<!-- wp:paragraph {"className":"cp-reveal","style":{"spacing":{"margin":{"top":"var:preset|spacing|20"}},"typography":{"lineHeight":"1.6"},"elements":{"link":{"color":{"text":"var:preset|color|contrast-2"}}}},"textColor":"contrast-2","fontSize":"large","fontFamily":"body"} -->
			<p class="cp-reveal has-contrast-2-color has-text-color has-link-color has-large-font-size has-body-font-family" style="margin-top:var(--wp--preset--spacing--20);line-height:1.6">One unhurried email a month — slow living, small rituals, and the occasional new piece. No noise, unsubscribe anytime.</p>
			<!-- /wp:paragraph -->
		</div>
		<!-- /wp:column -->

		<!-- wp:column {"verticalAlignment":"center","width":"48%"} -->
		<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:48%">
			<!-- wp:html -->
			<form class="cp-newsletter cp-reveal" method="post" action="#" style="display:flex;flex-wrap:wrap;gap:var(--wp--preset--spacing--20);max-width:440px">
				<label for="cp-newsletter-email" class="screen-reader-text" style="position:absolute;width:1px;height:1px;overflow:hidden;clip:rect(0 0 0 0)">Email address</label>
				<input id="cp-newsletter-email" type="email" name="email" required placeholder="you@example.com" autocomplete="email" style="flex:1 1 220px;min-width:0;padding:14px 18px;font:inherit;color:var(--wp--preset--color--contrast);background:var(--wp--preset--color--base);border:1px solid var(--wp--preset--color--border);border-radius:var(--wp--custom--radius--pill)" />
				<button type="submit" style="flex:0 0 auto;padding:14px 30px;font:inherit;font-weight:600;cursor:pointer;color:var(--wp--preset--color--base);background:var(--wp--preset--color--primary);border:0;border-radius:var(--wp--custom--radius--pill)">Subscribe</button>
			</form>
			<!-- /wp:html -->
		</div>
		<!-- /wp:column -->
	</div>
	<!-- /wp:columns -->
</section>
<!-- /wp:group -->
