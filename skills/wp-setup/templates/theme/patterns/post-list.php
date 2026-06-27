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
<!-- wp:group {"tagName":"section","lock":{"move":true,"remove":true},"align":"full","backgroundColor":"base","style":{"spacing":{"padding":{"top":"var:preset|spacing|70","bottom":"var:preset|spacing|70","left":"var:preset|spacing|40","right":"var:preset|spacing|40"}}},"layout":{"type":"constrained"}} -->
<section class="wp-block-group alignfull has-base-background-color has-background" style="padding-top:var(--wp--preset--spacing--70);padding-right:var(--wp--preset--spacing--40);padding-bottom:var(--wp--preset--spacing--70);padding-left:var(--wp--preset--spacing--40)">
	<!-- wp:heading {"textColor":"contrast","style":{"spacing":{"margin":{"bottom":"var:preset|spacing|50"}}},"fontSize":"xx-large","fontFamily":"heading"} -->
	<h2 class="wp-block-heading has-contrast-color has-text-color has-xx-large-font-size has-heading-font-family" style="margin-bottom:var(--wp--preset--spacing--50)">From the blog</h2>
	<!-- /wp:heading -->

	<!-- wp:query {"queryId":1,"query":{"perPage":6,"pages":0,"offset":0,"postType":"post","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"","inherit":false},"layout":{"type":"default"}} -->
	<div class="wp-block-query">
		<!-- wp:post-template {"style":{"spacing":{"blockGap":"var:preset|spacing|40"}},"layout":{"type":"grid","columnCount":3}} -->
			<!-- wp:group {"backgroundColor":"surface","style":{"border":{"radius":"var:custom|radius|lg"},"spacing":{"padding":{"top":"var:preset|spacing|30","bottom":"var:preset|spacing|40","left":"var:preset|spacing|30","right":"var:preset|spacing|30"},"blockGap":"var:preset|spacing|20"}},"layout":{"type":"constrained"}} -->
			<div class="wp-block-group has-surface-background-color has-background" style="border-radius:var(--wp--custom--radius--lg);padding-top:var(--wp--preset--spacing--30);padding-right:var(--wp--preset--spacing--30);padding-bottom:var(--wp--preset--spacing--40);padding-left:var(--wp--preset--spacing--30)">
				<!-- wp:post-featured-image {"isLink":true,"aspectRatio":"16/9","style":{"border":{"radius":"var:custom|radius|md"},"spacing":{"margin":{"bottom":"var:preset|spacing|20"}}}} /-->

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
			<p class="has-contrast-2-color has-text-color has-medium-font-size has-body-font-family">No posts found. Check back soon for new stories.</p>
			<!-- /wp:paragraph -->
		<!-- /wp:query-no-results -->
	</div>
	<!-- /wp:query -->
</section>
<!-- /wp:group -->
