<?php
/**
 * Title: Loamkit — Product Grid
 * Slug: loamkit/product-grid
 * Categories: loamkit, woocommerce, featured, query
 * Block Types:
 * Inserter: true
 * Description: A premium Product Collection grid of three columns with portrait product images, each card showing an accent sale badge, left-aligned title, rating, primary price, and a pill add-to-cart button.
 * Keywords: products, shop, grid, store, woocommerce, collection, catalog
 * Viewport Width: 1280
 */
?>
<!-- wp:group {"tagName":"section","lock":{"move":true,"remove":true},"align":"full","backgroundColor":"base","style":{"spacing":{"padding":{"top":"var:preset|spacing|70","bottom":"var:preset|spacing|70","left":"var:preset|spacing|40","right":"var:preset|spacing|40"}}},"layout":{"type":"constrained"}} -->
<section class="wp-block-group alignfull has-base-background-color has-background" style="padding-top:var(--wp--preset--spacing--70);padding-right:var(--wp--preset--spacing--40);padding-bottom:var(--wp--preset--spacing--70);padding-left:var(--wp--preset--spacing--40)">
	<!-- wp:group {"className":"lk-reveal","style":{"spacing":{"margin":{"bottom":"var:preset|spacing|50"},"blockGap":"var:preset|spacing|20"}},"layout":{"type":"constrained","contentSize":"640px","justifyContent":"left"}} -->
	<div class="wp-block-group lk-reveal" style="margin-bottom:var(--wp--preset--spacing--50)">
		<!-- wp:paragraph {"textColor":"secondary","style":{"typography":{"textTransform":"uppercase","letterSpacing":"0.1em"},"elements":{"link":{"color":{"text":"var:preset|color|secondary"}}}},"fontSize":"small","fontFamily":"mono"} -->
		<p class="has-secondary-color has-text-color has-link-color has-small-font-size has-mono-font-family" style="letter-spacing:0.1em;text-transform:uppercase">The collection</p>
		<!-- /wp:paragraph -->

		<!-- wp:heading {"textColor":"contrast","fontSize":"xx-large","fontFamily":"heading"} -->
		<h2 class="wp-block-heading has-contrast-color has-text-color has-xx-large-font-size has-heading-font-family">Made to be lived with</h2>
		<!-- /wp:heading -->

		<!-- wp:paragraph {"textColor":"contrast-2","style":{"elements":{"link":{"color":{"text":"var:preset|color|contrast-2"}}}},"fontSize":"large","fontFamily":"body"} -->
		<p class="has-contrast-2-color has-text-color has-link-color has-large-font-size has-body-font-family">Honest materials, quietly considered details — pieces our makers are proud to put their name to.</p>
		<!-- /wp:paragraph -->
	</div>
	<!-- /wp:group -->

	<!-- wp:woocommerce/product-collection {"queryId":0,"query":{"perPage":9,"pages":0,"offset":0,"postType":"product","order":"desc","orderBy":"date","search":"","exclude":[],"inherit":false,"taxQuery":{},"isProductCollectionBlock":true,"featured":false,"woocommerceOnSale":false,"woocommerceStockStatus":["instock","onbackorder"],"woocommerceAttributes":[],"woocommerceHandPickedProducts":[]},"tagName":"div","displayLayout":{"type":"flex","columns":3,"shrinkColumns":true},"dimensions":{"widthType":"fill"},"collection":"woocommerce/product-collection/product-catalog","hideControls":[],"queryContextIncludes":["collection"]} -->
	<div class="wp-block-woocommerce-product-collection">
		<!-- wp:woocommerce/product-template -->
		<!-- wp:woocommerce/product-image {"imageSizing":"single","aspectRatio":"3/4","scale":"cover","showSaleBadge":false,"style":{"border":{"radius":"var:custom|radius|lg"}}} -->
		<!-- wp:woocommerce/product-sale-badge {"align":"left","style":{"color":{"background":"var:preset|color|accent","text":"var:preset|color|base"},"typography":{"textTransform":"uppercase","letterSpacing":"0.04em"},"border":{"radius":"var:custom|radius|pill"}},"fontSize":"small"} /-->
		<!-- /wp:woocommerce/product-image -->

		<!-- wp:core/post-title {"level":3,"isLink":true,"__woocommerceNamespace":"woocommerce/product-collection/product-title","textColor":"contrast","style":{"spacing":{"margin":{"top":"var:preset|spacing|30","bottom":"var:preset|spacing|10"}}},"fontSize":"medium","fontFamily":"heading"} /-->

		<!-- wp:woocommerce/product-rating {"style":{"spacing":{"margin":{"bottom":"var:preset|spacing|10"}}},"fontSize":"small"} /-->

		<!-- wp:woocommerce/product-price {"textColor":"primary","style":{"spacing":{"margin":{"bottom":"var:preset|spacing|20"}}},"fontSize":"medium","fontFamily":"heading"} /-->

		<!-- wp:woocommerce/product-button {"fontSize":"small","style":{"border":{"radius":"var:custom|radius|pill"}}} /-->
		<!-- /wp:woocommerce/product-template -->

		<!-- wp:query-pagination {"layout":{"type":"flex","justifyContent":"center"},"style":{"spacing":{"margin":{"top":"var:preset|spacing|50"}}}} -->
		<!-- wp:query-pagination-previous /-->
		<!-- wp:query-pagination-numbers /-->
		<!-- wp:query-pagination-next /-->
		<!-- /wp:query-pagination -->

		<!-- wp:woocommerce/product-collection-no-results -->
		<!-- wp:paragraph {"align":"center","textColor":"contrast-2","fontFamily":"body"} -->
		<p class="has-text-align-center has-contrast-2-color has-text-color has-body-font-family">No products were found. Please check back soon.</p>
		<!-- /wp:paragraph -->
		<!-- /wp:woocommerce/product-collection-no-results -->
	</div>
	<!-- /wp:woocommerce/product-collection -->
</section>
<!-- /wp:group -->
