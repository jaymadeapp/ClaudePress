<?php
/**
 * Title: ClaudePress — Featured Products
 * Slug: claudepress/featured-products
 * Categories: claudepress, woocommerce, featured, query
 * Block Types:
 * Inserter: true
 * Description: A compact Product Collection row of best-selling products on a soft surface band, each card showing image, title, price, and rating.
 * Keywords: featured, best sellers, products, row, woocommerce, collection
 * Viewport Width: 1280
 */
?>
<!-- wp:group {"tagName":"section","lock":{"move":true,"remove":true},"align":"full","backgroundColor":"surface","style":{"spacing":{"padding":{"top":"var:preset|spacing|70","bottom":"var:preset|spacing|70","left":"var:preset|spacing|40","right":"var:preset|spacing|40"}}},"layout":{"type":"constrained"}} -->
<section class="wp-block-group alignfull has-surface-background-color has-background" style="padding-top:var(--wp--preset--spacing--70);padding-right:var(--wp--preset--spacing--40);padding-bottom:var(--wp--preset--spacing--70);padding-left:var(--wp--preset--spacing--40)">
	<!-- wp:paragraph {"align":"center","textColor":"primary","style":{"typography":{"textTransform":"uppercase","letterSpacing":"0.08em"},"elements":{"link":{"color":{"text":"var:preset|color|primary"}}}},"fontSize":"small","fontFamily":"heading"} -->
	<p class="has-text-align-center has-primary-color has-text-color has-link-color has-small-font-size has-heading-font-family" style="letter-spacing:0.08em;text-transform:uppercase">Customer favorites</p>
	<!-- /wp:paragraph -->

	<!-- wp:heading {"textAlign":"center","textColor":"contrast","style":{"spacing":{"margin":{"bottom":"var:preset|spacing|50"}}},"fontSize":"xx-large","fontFamily":"heading"} -->
	<h2 class="wp-block-heading has-text-align-center has-contrast-color has-text-color has-xx-large-font-size has-heading-font-family" style="margin-bottom:var(--wp--preset--spacing--50)">Best sellers</h2>
	<!-- /wp:heading -->

	<!-- wp:woocommerce/product-collection {"queryId":0,"query":{"perPage":4,"pages":0,"offset":0,"postType":"product","order":"desc","orderBy":"popularity","search":"","exclude":[],"inherit":false,"taxQuery":{},"isProductCollectionBlock":true,"featured":false,"woocommerceOnSale":false,"woocommerceStockStatus":["instock","onbackorder"],"woocommerceAttributes":[],"woocommerceHandPickedProducts":[]},"tagName":"div","displayLayout":{"type":"flex","columns":4,"shrinkColumns":true},"dimensions":{"widthType":"fill"},"collection":"woocommerce/product-collection/best-sellers","hideControls":["inherit"],"queryContextIncludes":["collection"]} -->
	<div class="wp-block-woocommerce-product-collection">
		<!-- wp:woocommerce/product-template -->
		<!-- wp:woocommerce/product-image {"imageSizing":"thumbnail","showSaleBadge":false,"style":{"border":{"radius":"var:custom|radius|md"}}} -->
		<!-- wp:woocommerce/product-sale-badge {"align":"right","style":{"color":{"background":"var:preset|color|accent","text":"var:preset|color|base"},"typography":{"textTransform":"uppercase","letterSpacing":"0.04em"}},"fontSize":"small"} /-->
		<!-- /wp:woocommerce/product-image -->

		<!-- wp:core/post-title {"textAlign":"center","level":3,"isLink":true,"__woocommerceNamespace":"woocommerce/product-collection/product-title","textColor":"contrast","style":{"spacing":{"margin":{"top":"var:preset|spacing|20","bottom":"var:preset|spacing|10"}}},"fontSize":"medium","fontFamily":"heading"} /-->

		<!-- wp:woocommerce/product-rating {"textAlign":"center","style":{"spacing":{"margin":{"bottom":"var:preset|spacing|10"}}},"fontSize":"small"} /-->

		<!-- wp:woocommerce/product-price {"textAlign":"center","textColor":"primary","fontSize":"medium","fontFamily":"heading"} /-->
		<!-- /wp:woocommerce/product-template -->
	</div>
	<!-- /wp:woocommerce/product-collection -->
</section>
<!-- /wp:group -->
