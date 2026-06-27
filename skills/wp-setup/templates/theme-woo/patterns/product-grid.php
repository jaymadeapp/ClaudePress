<?php
/**
 * Title: ClaudePress — Product Grid
 * Slug: claudepress/product-grid
 * Categories: claudepress, woocommerce, featured, query
 * Block Types:
 * Inserter: true
 * Description: A designed Product Collection grid of three columns, each card showing the product image with sale badge, title, price, rating, and an add-to-cart button.
 * Keywords: products, shop, grid, store, woocommerce, collection, catalog
 * Viewport Width: 1280
 */
?>
<!-- wp:group {"tagName":"section","lock":{"move":true,"remove":true},"align":"full","backgroundColor":"base","style":{"spacing":{"padding":{"top":"var:preset|spacing|70","bottom":"var:preset|spacing|70","left":"var:preset|spacing|40","right":"var:preset|spacing|40"}}},"layout":{"type":"constrained"}} -->
<section class="wp-block-group alignfull has-base-background-color has-background" style="padding-top:var(--wp--preset--spacing--70);padding-right:var(--wp--preset--spacing--40);padding-bottom:var(--wp--preset--spacing--70);padding-left:var(--wp--preset--spacing--40)">
	<!-- wp:heading {"textAlign":"center","textColor":"contrast","fontSize":"xx-large","fontFamily":"heading"} -->
	<h2 class="wp-block-heading has-text-align-center has-contrast-color has-text-color has-xx-large-font-size has-heading-font-family">Shop our latest</h2>
	<!-- /wp:heading -->

	<!-- wp:paragraph {"align":"center","textColor":"contrast-2","style":{"spacing":{"margin":{"top":"var:preset|spacing|20","bottom":"var:preset|spacing|50"}},"elements":{"link":{"color":{"text":"var:preset|color|contrast-2"}}}},"fontSize":"large","fontFamily":"body"} -->
	<p class="has-text-align-center has-contrast-2-color has-text-color has-link-color has-large-font-size has-body-font-family" style="margin-top:var(--wp--preset--spacing--20);margin-bottom:var(--wp--preset--spacing--50)">A handpicked selection of pieces our customers keep coming back for.</p>
	<!-- /wp:paragraph -->

	<!-- wp:woocommerce/product-collection {"queryId":0,"query":{"perPage":9,"pages":0,"offset":0,"postType":"product","order":"desc","orderBy":"date","search":"","exclude":[],"inherit":false,"taxQuery":{},"isProductCollectionBlock":true,"featured":false,"woocommerceOnSale":false,"woocommerceStockStatus":["instock","onbackorder"],"woocommerceAttributes":[],"woocommerceHandPickedProducts":[]},"tagName":"div","displayLayout":{"type":"flex","columns":3,"shrinkColumns":true},"dimensions":{"widthType":"fill"},"collection":"woocommerce/product-collection/product-catalog","hideControls":[],"queryContextIncludes":["collection"]} -->
	<div class="wp-block-woocommerce-product-collection">
		<!-- wp:woocommerce/product-template -->
		<!-- wp:woocommerce/product-image {"imageSizing":"thumbnail","showSaleBadge":false,"style":{"border":{"radius":"var:custom|radius|md"}}} -->
		<!-- wp:woocommerce/product-sale-badge {"align":"right","style":{"color":{"background":"var:preset|color|accent","text":"var:preset|color|base"},"typography":{"textTransform":"uppercase","letterSpacing":"0.04em"}},"fontSize":"small"} /-->
		<!-- /wp:woocommerce/product-image -->

		<!-- wp:core/post-title {"textAlign":"center","level":3,"isLink":true,"__woocommerceNamespace":"woocommerce/product-collection/product-title","textColor":"contrast","style":{"spacing":{"margin":{"top":"var:preset|spacing|20","bottom":"var:preset|spacing|10"}}},"fontSize":"medium","fontFamily":"heading"} /-->

		<!-- wp:woocommerce/product-rating {"textAlign":"center","style":{"spacing":{"margin":{"bottom":"var:preset|spacing|10"}}},"fontSize":"small"} /-->

		<!-- wp:woocommerce/product-price {"textAlign":"center","textColor":"primary","style":{"spacing":{"margin":{"bottom":"var:preset|spacing|20"}}},"fontSize":"medium","fontFamily":"heading"} /-->

		<!-- wp:woocommerce/product-button {"textAlign":"center","fontSize":"small"} /-->
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
