<?php
/**
 * Title: ClaudePress — Blog Post List
 * Slug: claudepress/post-list
 * Categories: claudepress, featured, posts
 * Block Types:
 * Inserter: true
 * Description: A three-column grid of recent posts with featured image, title, date, and excerpt, driven by the query loop.
 * Keywords: blog, posts, query, loop, grid, archive
 * Viewport Width: 1280
 */
?>
<!-- wp:group {"tagName":"section","lock":{"move":true,"remove":true},"align":"full","backgroundColor":"base","style":{"spacing":{"padding":{"top":"var:preset|spacing|60","bottom":"var:preset|spacing|60","left":"var:preset|spacing|40","right":"var:preset|spacing|40"}}},"layout":{"type":"constrained"}} -->
<section class="wp-block-group alignfull has-base-background-color has-background" style="padding-top:var(--wp--preset--spacing--60);padding-right:var(--wp--preset--spacing--40);padding-bottom:var(--wp--preset--spacing--60);padding-left:var(--wp--preset--spacing--40)">
	<!-- wp:paragraph {"className":"cp-reveal","style":{"typography":{"textTransform":"uppercase","letterSpacing":"0.1em"},"elements":{"link":{"color":{"text":"var:preset|color|secondary"}}}},"textColor":"secondary","fontSize":"small","fontFamily":"mono"} -->
	<p class="cp-reveal has-secondary-color has-text-color has-link-color has-small-font-size has-mono-font-family" style="letter-spacing:0.1em;text-transform:uppercase">The journal</p>
	<!-- /wp:paragraph -->

	<!-- wp:heading {"className":"cp-reveal","textColor":"contrast","style":{"spacing":{"margin":{"top":"var:preset|spacing|20","bottom":"var:preset|spacing|50"}}},"fontSize":"xx-large","fontFamily":"heading"} -->
	<h2 class="wp-block-heading cp-reveal has-contrast-color has-text-color has-xx-large-font-size has-heading-font-family" style="margin-top:var(--wp--preset--spacing--20);margin-bottom:var(--wp--preset--spacing--50)">Notes on a <em class="has-display-font-family" style="font-weight:400;color:var(--wp--preset--color--accent)">slower</em> life</h2>
	<!-- /wp:heading -->

	<!-- Featured lead post — one wide card breaks the even grid before the rest -->
	<!-- wp:query {"queryId":2,"query":{"perPage":1,"pages":0,"offset":0,"postType":"post","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"","inherit":false},"style":{"spacing":{"margin":{"bottom":"var:preset|spacing|40"}}},"layout":{"type":"default"}} -->
	<div class="wp-block-query" style="margin-bottom:var(--wp--preset--spacing--40)">
		<!-- wp:post-template {"layout":{"type":"default"}} -->
			<!-- wp:group {"className":"cp-reveal","backgroundColor":"surface","style":{"border":{"radius":"var:custom|radius|xl","color":"var:preset|color|border","width":"1px"},"spacing":{"padding":{"top":"var:preset|spacing|40","bottom":"var:preset|spacing|40","left":"var:preset|spacing|40","right":"var:preset|spacing|40"},"blockGap":"var:preset|spacing|40"}},"layout":{"type":"flex","flexWrap":"wrap","verticalAlignment":"center"}} -->
			<div class="wp-block-group cp-reveal has-surface-background-color has-background has-border-color" style="border-color:var(--wp--preset--color--border);border-width:1px;border-radius:var(--wp--custom--radius--xl);padding-top:var(--wp--preset--spacing--40);padding-right:var(--wp--preset--spacing--40);padding-bottom:var(--wp--preset--spacing--40);padding-left:var(--wp--preset--spacing--40)">
				<!-- wp:post-featured-image {"isLink":true,"aspectRatio":"16/9","width":"55%","style":{"border":{"radius":"var:custom|radius|lg"}}} /-->

				<!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|20"},"layout":{"flexSize":"min(100%, 22rem)"}},"layout":{"type":"constrained"}} -->
				<div class="wp-block-group" style="flex-basis:min(100%, 22rem)">
					<!-- wp:post-date {"textColor":"contrast-2","fontSize":"small","fontFamily":"body"} /-->

					<!-- wp:post-title {"isLink":true,"textColor":"contrast","style":{"elements":{"link":{"color":{"text":"var:preset|color|contrast"}}}},"fontSize":"x-large","fontFamily":"heading"} /-->

					<!-- wp:post-excerpt {"textColor":"contrast-2","fontSize":"medium","fontFamily":"body"} /-->
				</div>
				<!-- /wp:group -->
			</div>
			<!-- /wp:group -->
		<!-- /wp:post-template -->
	</div>
	<!-- /wp:query -->

	<!-- The rest of the journal in a responsive grid (offset past the featured lead) -->
	<!-- wp:query {"queryId":1,"query":{"perPage":6,"pages":0,"offset":1,"postType":"post","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"","inherit":false},"layout":{"type":"default"}} -->
	<div class="wp-block-query">
		<!-- wp:post-template {"style":{"spacing":{"blockGap":"var:preset|spacing|40"}},"layout":{"type":"grid","minimumColumnWidth":"18rem"}} -->
			<!-- wp:group {"className":"cp-reveal","backgroundColor":"surface","style":{"border":{"radius":"var:custom|radius|xl","color":"var:preset|color|border","width":"1px"},"spacing":{"padding":{"top":"var:preset|spacing|30","bottom":"var:preset|spacing|40","left":"var:preset|spacing|30","right":"var:preset|spacing|30"},"blockGap":"var:preset|spacing|20"}},"layout":{"type":"constrained"}} -->
			<div class="wp-block-group cp-reveal has-surface-background-color has-background has-border-color" style="border-color:var(--wp--preset--color--border);border-width:1px;border-radius:var(--wp--custom--radius--xl);padding-top:var(--wp--preset--spacing--30);padding-right:var(--wp--preset--spacing--30);padding-bottom:var(--wp--preset--spacing--40);padding-left:var(--wp--preset--spacing--30)">
				<!-- wp:post-featured-image {"isLink":true,"aspectRatio":"16/9","style":{"border":{"radius":"var:custom|radius|lg"},"spacing":{"margin":{"bottom":"var:preset|spacing|20"}}}} /-->

				<!-- wp:post-date {"textColor":"contrast-2","fontSize":"small","fontFamily":"body"} /-->

				<!-- wp:post-title {"isLink":true,"textColor":"contrast","style":{"elements":{"link":{"color":{"text":"var:preset|color|contrast"}}}},"fontSize":"large","fontFamily":"heading"} /-->

				<!-- wp:post-excerpt {"textColor":"contrast-2","fontSize":"medium","fontFamily":"body"} /-->
			</div>
			<!-- /wp:group -->
		<!-- /wp:post-template -->

		<!-- wp:query-pagination {"layout":{"type":"flex","justifyContent":"center"},"style":{"spacing":{"margin":{"top":"var:preset|spacing|50"}}}} -->
			<!-- wp:query-pagination-previous {"fontFamily":"heading"} /-->
			<!-- wp:query-pagination-numbers /-->
			<!-- wp:query-pagination-next {"fontFamily":"heading"} /-->
		<!-- /wp:query-pagination -->

		<!-- wp:query-no-results -->
			<!-- wp:paragraph {"textColor":"contrast-2","fontSize":"medium","fontFamily":"body"} -->
			<p class="has-contrast-2-color has-text-color has-medium-font-size has-body-font-family">Nothing here just yet. Check back soon — we write when there's something worth slowing down for.</p>
			<!-- /wp:paragraph -->
		<!-- /wp:query-no-results -->
	</div>
	<!-- /wp:query -->
</section>
<!-- /wp:group -->
