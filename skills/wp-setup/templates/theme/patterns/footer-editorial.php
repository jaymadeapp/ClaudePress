<?php
/**
 * Title: Loamkit — Footer (Editorial)
 * Slug: loamkit/footer-editorial
 * Categories: loamkit, featured
 * Block Types: core/template-part/footer
 * Inserter: true
 * Description: A designed dark footer — a brand statement and newsletter capture beside real navigation list columns, a baseline rule, and small print.
 * Keywords: footer, newsletter, navigation, links, sitemap, editorial
 * Viewport Width: 1280
 */
?>
<!-- wp:group {"tagName":"footer","lock":{"move":true,"remove":true},"align":"full","backgroundColor":"surface-2","style":{"spacing":{"padding":{"top":"var:preset|spacing|70","bottom":"var:preset|spacing|50","left":"var:preset|spacing|40","right":"var:preset|spacing|40"},"blockGap":"var:preset|spacing|60"}},"layout":{"type":"constrained"}} -->
<footer class="wp-block-group alignfull has-surface-2-background-color has-background" style="padding-top:var(--wp--preset--spacing--70);padding-right:var(--wp--preset--spacing--40);padding-bottom:var(--wp--preset--spacing--50);padding-left:var(--wp--preset--spacing--40)">
	<!-- wp:columns {"style":{"spacing":{"blockGap":{"left":"var:preset|spacing|60"}}}} -->
	<div class="wp-block-columns">
		<!-- wp:column {"width":"42%"} -->
		<div class="wp-block-column" style="flex-basis:42%">
			<!-- wp:heading {"level":2,"textColor":"base","fontSize":"x-large","fontFamily":"heading"} -->
			<h2 class="wp-block-heading has-base-color has-text-color has-x-large-font-size has-heading-font-family">Stay a little <em class="has-display-font-family" style="font-weight:400;color:var(--wp--custom--color--accent-ink, var(--wp--preset--color--accent))">closer</em>.</h2>
			<!-- /wp:heading -->

			<!-- wp:paragraph {"style":{"spacing":{"margin":{"top":"var:preset|spacing|20"}},"typography":{"lineHeight":"1.6"},"elements":{"link":{"color":{"text":"var:preset|color|surface"}}}},"textColor":"surface","fontSize":"medium","fontFamily":"body"} -->
			<p class="has-surface-color has-text-color has-link-color has-medium-font-size has-body-font-family" style="margin-top:var(--wp--preset--spacing--20);line-height:1.6">One unhurried letter a season — new pieces, the stories behind them, and the occasional thing worth slowing down for.</p>
			<!-- /wp:paragraph -->

			<!-- wp:html -->
			<form class="cp-newsletter" method="post" action="#" style="display:flex;flex-wrap:wrap;gap:var(--wp--preset--spacing--20);margin-top:var(--wp--preset--spacing--30);max-width:420px">
				<label for="cp-footer-email" class="screen-reader-text" style="position:absolute;width:1px;height:1px;overflow:hidden;clip:rect(0 0 0 0)">Email address</label>
				<input id="cp-footer-email" type="email" name="email" required placeholder="you@example.com" autocomplete="email" style="flex:1 1 200px;min-width:0;padding:14px 18px;font:inherit;color:var(--wp--preset--color--contrast);background:var(--wp--preset--color--base);border:1px solid var(--wp--preset--color--border);border-radius:var(--wp--custom--radius--pill)" />
				<button type="submit" style="flex:0 0 auto;padding:14px 28px;font:inherit;font-weight:600;cursor:pointer;color:var(--wp--preset--color--base);background:var(--wp--preset--color--accent);border:0;border-radius:var(--wp--custom--radius--pill)">Subscribe</button>
			</form>
			<!-- /wp:html -->
		</div>
		<!-- /wp:column -->

		<!-- wp:column {"width":"19%"} -->
		<div class="wp-block-column" style="flex-basis:19%">
			<!-- wp:paragraph {"style":{"typography":{"textTransform":"uppercase","letterSpacing":"0.08em"},"elements":{"link":{"color":{"text":"var:preset|color|secondary"}}}},"textColor":"secondary","fontSize":"small","fontFamily":"mono"} -->
			<p class="has-secondary-color has-text-color has-link-color has-small-font-size has-mono-font-family" style="letter-spacing:0.08em;text-transform:uppercase">Shop</p>
			<!-- /wp:paragraph -->

			<!-- wp:list {"className":"cp-footer-nav","style":{"spacing":{"margin":{"top":"var:preset|spacing|20"}},"elements":{"link":{"color":{"text":"var:preset|color|surface"}}}},"textColor":"surface","fontSize":"medium","fontFamily":"body"} -->
			<ul class="wp-block-list cp-footer-nav has-surface-color has-text-color has-link-color has-medium-font-size has-body-font-family" style="margin-top:var(--wp--preset--spacing--20)"><!-- wp:list-item --><li><a href="#">Tableware</a></li><!-- /wp:list-item --><!-- wp:list-item --><li><a href="#">Bath &amp; body</a></li><!-- /wp:list-item --><!-- wp:list-item --><li><a href="#">Home textiles</a></li><!-- /wp:list-item --><!-- wp:list-item --><li><a href="#">Gift sets</a></li><!-- /wp:list-item --></ul>
			<!-- /wp:list -->
		</div>
		<!-- /wp:column -->

		<!-- wp:column {"width":"19%"} -->
		<div class="wp-block-column" style="flex-basis:19%">
			<!-- wp:paragraph {"style":{"typography":{"textTransform":"uppercase","letterSpacing":"0.08em"},"elements":{"link":{"color":{"text":"var:preset|color|secondary"}}}},"textColor":"secondary","fontSize":"small","fontFamily":"mono"} -->
			<p class="has-secondary-color has-text-color has-link-color has-small-font-size has-mono-font-family" style="letter-spacing:0.08em;text-transform:uppercase">Studio</p>
			<!-- /wp:paragraph -->

			<!-- wp:list {"className":"cp-footer-nav","style":{"spacing":{"margin":{"top":"var:preset|spacing|20"}},"elements":{"link":{"color":{"text":"var:preset|color|surface"}}}},"textColor":"surface","fontSize":"medium","fontFamily":"body"} -->
			<ul class="wp-block-list cp-footer-nav has-surface-color has-text-color has-link-color has-medium-font-size has-body-font-family" style="margin-top:var(--wp--preset--spacing--20)"><!-- wp:list-item --><li><a href="#">Our story</a></li><!-- /wp:list-item --><!-- wp:list-item --><li><a href="#">The makers</a></li><!-- /wp:list-item --><!-- wp:list-item --><li><a href="#">Journal</a></li><!-- /wp:list-item --><!-- wp:list-item --><li><a href="#">Stockists</a></li><!-- /wp:list-item --></ul>
			<!-- /wp:list -->
		</div>
		<!-- /wp:column -->

		<!-- wp:column {"width":"20%"} -->
		<div class="wp-block-column" style="flex-basis:20%">
			<!-- wp:paragraph {"style":{"typography":{"textTransform":"uppercase","letterSpacing":"0.08em"},"elements":{"link":{"color":{"text":"var:preset|color|secondary"}}}},"textColor":"secondary","fontSize":"small","fontFamily":"mono"} -->
			<p class="has-secondary-color has-text-color has-link-color has-small-font-size has-mono-font-family" style="letter-spacing:0.08em;text-transform:uppercase">Help</p>
			<!-- /wp:paragraph -->

			<!-- wp:list {"className":"cp-footer-nav","style":{"spacing":{"margin":{"top":"var:preset|spacing|20"}},"elements":{"link":{"color":{"text":"var:preset|color|surface"}}}},"textColor":"surface","fontSize":"medium","fontFamily":"body"} -->
			<ul class="wp-block-list cp-footer-nav has-surface-color has-text-color has-link-color has-medium-font-size has-body-font-family" style="margin-top:var(--wp--preset--spacing--20)"><!-- wp:list-item --><li><a href="#">Shipping &amp; returns</a></li><!-- /wp:list-item --><!-- wp:list-item --><li><a href="#">Care &amp; repair</a></li><!-- /wp:list-item --><!-- wp:list-item --><li><a href="#">Contact</a></li><!-- /wp:list-item --><!-- wp:list-item --><li><a href="#">FAQ</a></li><!-- /wp:list-item --></ul>
			<!-- /wp:list -->
		</div>
		<!-- /wp:column -->
	</div>
	<!-- /wp:columns -->

	<!-- wp:separator {"backgroundColor":"contrast-2","className":"is-style-wide"} -->
	<hr class="wp-block-separator has-text-color has-contrast-2-color has-alpha-channel-opacity has-contrast-2-background-color has-background is-style-wide"/>
	<!-- /wp:separator -->

	<!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|20"}},"layout":{"type":"flex","justifyContent":"space-between","flexWrap":"wrap"}} -->
	<div class="wp-block-group">
		<!-- wp:paragraph {"style":{"elements":{"link":{"color":{"text":"var:preset|color|contrast-2"}}}},"textColor":"contrast-2","fontSize":"small","fontFamily":"body"} -->
		<p class="has-contrast-2-color has-text-color has-link-color has-small-font-size has-body-font-family">© 2026 Terra Goods. Made slowly in the Cotswolds.</p>
		<!-- /wp:paragraph -->

		<!-- wp:paragraph {"style":{"elements":{"link":{"color":{"text":"var:preset|color|contrast-2"}}}},"textColor":"contrast-2","fontSize":"small","fontFamily":"body"} -->
		<p class="has-contrast-2-color has-text-color has-link-color has-small-font-size has-body-font-family"><a href="#">Privacy</a> · <a href="#">Terms</a> · <a href="#">Instagram</a></p>
		<!-- /wp:paragraph -->
	</div>
	<!-- /wp:group -->
</footer>
<!-- /wp:group -->
