<?php
/**
 * Title: Loamkit — Contact Split
 * Slug: loamkit/contact-split
 * Categories: loamkit, featured, contact
 * Block Types:
 * Inserter: true
 * Description: A two-column contact band — eyebrow, headline, contact details (email, studio, hours) and a mailto button on one side; a framed, keyless OpenStreetMap embed on the other. Token-driven, on a warm surface background.
 * Keywords: contact, map, address, email, studio, get in touch
 * Viewport Width: 1280
 */
?>
<!-- wp:group {"tagName":"section","lock":{"move":true,"remove":true},"align":"full","backgroundColor":"surface","style":{"spacing":{"padding":{"top":"var:preset|spacing|70","bottom":"var:preset|spacing|70","left":"var:preset|spacing|40","right":"var:preset|spacing|40"}}},"layout":{"type":"constrained"}} -->
<section class="wp-block-group alignfull has-surface-background-color has-background" style="padding-top:var(--wp--preset--spacing--70);padding-right:var(--wp--preset--spacing--40);padding-bottom:var(--wp--preset--spacing--70);padding-left:var(--wp--preset--spacing--40)">
	<!-- wp:columns {"style":{"spacing":{"blockGap":{"left":"var:preset|spacing|60"}}}} -->
	<div class="wp-block-columns">
		<!-- wp:column {"width":"44%"} -->
		<div class="wp-block-column" style="flex-basis:44%">
			<!-- wp:paragraph {"className":"lk-reveal","style":{"typography":{"textTransform":"uppercase","letterSpacing":"0.1em"},"elements":{"link":{"color":{"text":"var:preset|color|secondary"}}}},"textColor":"secondary","fontSize":"small","fontFamily":"mono"} -->
			<p class="lk-reveal has-secondary-color has-text-color has-link-color has-small-font-size has-mono-font-family" style="letter-spacing:0.1em;text-transform:uppercase">Get in touch</p>
			<!-- /wp:paragraph -->

			<!-- wp:heading {"className":"lk-reveal","style":{"spacing":{"margin":{"top":"var:preset|spacing|20"}}},"textColor":"contrast","fontSize":"x-large","fontFamily":"heading"} -->
			<h2 class="wp-block-heading lk-reveal has-contrast-color has-text-color has-x-large-font-size has-heading-font-family" style="margin-top:var(--wp--preset--spacing--20)">Let’s <em class="has-display-font-family" style="font-weight:400;color:var(--wp--custom--color--accent-ink, var(--wp--preset--color--accent))">talk</em>.</h2>
			<!-- /wp:heading -->

			<!-- wp:paragraph {"className":"lk-reveal","style":{"spacing":{"margin":{"top":"var:preset|spacing|30"}},"typography":{"lineHeight":"1.6"},"elements":{"link":{"color":{"text":"var:preset|color|contrast-2"}}}},"textColor":"contrast-2","fontSize":"medium","fontFamily":"body"} -->
			<p class="lk-reveal has-contrast-2-color has-text-color has-link-color has-medium-font-size has-body-font-family" style="margin-top:var(--wp--preset--spacing--30);line-height:1.6">Commissions, wholesale, or just to say hello — we read every message and reply within two working days.</p>
			<!-- /wp:paragraph -->

			<!-- wp:group {"className":"lk-contact-details lk-reveal","style":{"spacing":{"margin":{"top":"var:preset|spacing|40"},"blockGap":"var:preset|spacing|30"}},"layout":{"type":"flex","orientation":"vertical","flexWrap":"nowrap"}} -->
			<div class="wp-block-group lk-contact-details lk-reveal" style="margin-top:var(--wp--preset--spacing--40)">
				<!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|10"}},"layout":{"type":"flex","orientation":"vertical","flexWrap":"nowrap"}} -->
				<div class="wp-block-group">
					<!-- wp:paragraph {"style":{"typography":{"textTransform":"uppercase","letterSpacing":"0.1em"}},"textColor":"secondary","fontSize":"small","fontFamily":"mono"} -->
					<p class="has-secondary-color has-text-color has-small-font-size has-mono-font-family" style="letter-spacing:0.1em;text-transform:uppercase">Email</p>
					<!-- /wp:paragraph -->
					<!-- wp:paragraph {"style":{"elements":{"link":{"color":{"text":"var:preset|color|contrast"}}}},"textColor":"contrast","fontSize":"medium","fontFamily":"heading"} -->
					<p class="has-contrast-color has-text-color has-link-color has-medium-font-size has-heading-font-family"><a href="mailto:hello@example.com">hello@example.com</a></p>
					<!-- /wp:paragraph -->
				</div>
				<!-- /wp:group -->

				<!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|10"}},"layout":{"type":"flex","orientation":"vertical","flexWrap":"nowrap"}} -->
				<div class="wp-block-group">
					<!-- wp:paragraph {"style":{"typography":{"textTransform":"uppercase","letterSpacing":"0.1em"}},"textColor":"secondary","fontSize":"small","fontFamily":"mono"} -->
					<p class="has-secondary-color has-text-color has-small-font-size has-mono-font-family" style="letter-spacing:0.1em;text-transform:uppercase">Studio</p>
					<!-- /wp:paragraph -->
					<!-- wp:paragraph {"textColor":"contrast","fontSize":"medium","fontFamily":"heading"} -->
					<p class="has-contrast-color has-text-color has-medium-font-size has-heading-font-family">12 Kiln Lane, Bristol BS1 4DJ</p>
					<!-- /wp:paragraph -->
				</div>
				<!-- /wp:group -->

				<!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|10"}},"layout":{"type":"flex","orientation":"vertical","flexWrap":"nowrap"}} -->
				<div class="wp-block-group">
					<!-- wp:paragraph {"style":{"typography":{"textTransform":"uppercase","letterSpacing":"0.1em"}},"textColor":"secondary","fontSize":"small","fontFamily":"mono"} -->
					<p class="has-secondary-color has-text-color has-small-font-size has-mono-font-family" style="letter-spacing:0.1em;text-transform:uppercase">Hours</p>
					<!-- /wp:paragraph -->
					<!-- wp:paragraph {"textColor":"contrast","fontSize":"medium","fontFamily":"heading"} -->
					<p class="has-contrast-color has-text-color has-medium-font-size has-heading-font-family">Mon–Fri, 9–5 · Weekends by appointment</p>
					<!-- /wp:paragraph -->
				</div>
				<!-- /wp:group -->
			</div>
			<!-- /wp:group -->

			<!-- wp:buttons {"className":"lk-reveal","style":{"spacing":{"margin":{"top":"var:preset|spacing|40"}}}} -->
			<div class="wp-block-buttons lk-reveal" style="margin-top:var(--wp--preset--spacing--40)">
				<!-- wp:button {"backgroundColor":"primary","textColor":"base","style":{"border":{"radius":"var:custom|radius|pill"},"spacing":{"padding":{"top":"var:preset|spacing|30","bottom":"var:preset|spacing|30","left":"var:preset|spacing|50","right":"var:preset|spacing|50"}},"elements":{"link":{"color":{"text":"var:preset|color|base"}}}},"fontFamily":"heading"} -->
				<div class="wp-block-button has-custom-font-size has-heading-font-family"><a class="wp-block-button__link has-base-color has-primary-background-color has-text-color has-background has-link-color wp-element-button" style="border-radius:var(--wp--custom--radius--pill);padding-top:var(--wp--preset--spacing--30);padding-right:var(--wp--preset--spacing--50);padding-bottom:var(--wp--preset--spacing--30);padding-left:var(--wp--preset--spacing--50)" href="mailto:hello@example.com">Email the studio</a></div>
				<!-- /wp:button -->
			</div>
			<!-- /wp:buttons -->
		</div>
		<!-- /wp:column -->

		<!-- wp:column {"width":"56%"} -->
		<div class="wp-block-column" style="flex-basis:56%">
			<!-- wp:html -->
			<figure class="lk-frame lk-map lk-reveal" style="margin:0">
				<iframe
					title="Map showing the Terra Goods studio in Bristol"
					src="https://www.openstreetmap.org/export/embed.html?bbox=-2.6210%2C51.4448%2C-2.5548%2C51.4642&amp;layer=mapnik&amp;marker=51.4545%2C-2.5879"
					loading="lazy"
					referrerpolicy="no-referrer-when-downgrade"
					style="width:100%;height:100%;border:0;display:block"
				></iframe>
			</figure>
			<!-- /wp:html -->
		</div>
		<!-- /wp:column -->
	</div>
	<!-- /wp:columns -->
</section>
<!-- /wp:group -->
