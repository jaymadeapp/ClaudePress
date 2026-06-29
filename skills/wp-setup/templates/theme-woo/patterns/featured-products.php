<?php
/**
 * Title: Loamkit — Featured Products
 * Slug: loamkit/featured-products
 * Categories: loamkit, woocommerce, featured, query
 * Block Types:
 * Inserter: true
 * Description: A premium best-sellers row on a soft surface band with a left-aligned editorial intro, portrait product cards showing image, title, rating, and primary price.
 * Keywords: featured, best sellers, products, row, woocommerce, collection
 * Viewport Width: 1280
 */
?>
<!-- wp:group {"tagName":"section","lock":{"move":true,"remove":true},"align":"full","backgroundColor":"surface","style":{"spacing":{"padding":{"top":"var:preset|spacing|70","bottom":"var:preset|spacing|70","left":"var:preset|spacing|40","right":"var:preset|spacing|40"}}},"layout":{"type":"constrained"}} -->
<section class="wp-block-group alignfull has-surface-background-color has-background" style="padding-top:var(--wp--preset--spacing--70);padding-right:var(--wp--preset--spacing--40);padding-bottom:var(--wp--preset--spacing--70);padding-left:var(--wp--preset--spacing--40)">
	<!-- wp:group {"className":"cp-reveal","style":{"spacing":{"margin":{"bottom":"var:preset|spacing|50"},"blockGap":"var:preset|spacing|20"}},"layout":{"type":"constrained","contentSize":"640px","justifyContent":"left"}} -->
	<div class="wp-block-group cp-reveal" style="margin-bottom:var(--wp--preset--spacing--50)">
		<!-- wp:paragraph {"textColor":"secondary","style":{"typography":{"textTransform":"uppercase","letterSpacing":"0.1em"},"elements":{"link":{"color":{"text":"var:preset|color|secondary"}}}},"fontSize":"small","fontFamily":"mono"} -->
		<p class="has-secondary-color has-text-color has-link-color has-small-font-size has-mono-font-family" style="letter-spacing:0.1em;text-transform:uppercase">Customer favorites</p>
		<!-- /wp:paragraph -->

		<!-- wp:heading {"textColor":"contrast","fontSize":"xx-large","fontFamily":"heading"} -->
		<h2 class="wp-block-heading has-contrast-color has-text-color has-xx-large-font-size has-heading-font-family">The ones they reorder</h2>
		<!-- /wp:heading -->

		<!-- wp:paragraph {"textColor":"contrast-2","style":{"elements":{"link":{"color":{"text":"var:preset|color|contrast-2"}}}},"fontSize":"large","fontFamily":"body"} -->
		<p class="has-contrast-2-color has-text-color has-link-color has-large-font-size has-body-font-family">A short list of pieces that have earned their place — the quiet staples our regulars keep coming back for.</p>
		<!-- /wp:paragraph -->
	</div>
	<!-- /wp:group -->

	<!-- wp:woocommerce/product-collection {"queryId":0,"query":{"perPage":4,"pages":0,"offset":0,"postType":"product","order":"desc","orderBy":"popularity","search":"","exclude":[],"inherit":false,"taxQuery":{},"isProductCollectionBlock":true,"featured":false,"woocommerceOnSale":false,"woocommerceStockStatus":["instock","onbackorder"],"woocommerceAttributes":[],"woocommerceHandPickedProducts":[]},"tagName":"div","displayLayout":{"type":"flex","columns":4,"shrinkColumns":true},"dimensions":{"widthType":"fill"},"collection":"woocommerce/product-collection/best-sellers","hideControls":["inherit"],"queryContextIncludes":["collection"]} -->
	<div class="wp-block-woocommerce-product-collection">
		<!-- wp:woocommerce/product-template -->
		<!-- wp:woocommerce/product-image {"imageSizing":"single","aspectRatio":"3/4","scale":"cover","showSaleBadge":false,"style":{"border":{"radius":"var:custom|radius|lg"}}} -->
		<!-- wp:woocommerce/product-sale-badge {"align":"left","style":{"color":{"background":"var:preset|color|accent","text":"var:preset|color|base"},"typography":{"textTransform":"uppercase","letterSpacing":"0.04em"},"border":{"radius":"var:custom|radius|pill"}},"fontSize":"small"} /-->
		<!-- /wp:woocommerce/product-image -->

		<!-- wp:core/post-title {"level":3,"isLink":true,"__woocommerceNamespace":"woocommerce/product-collection/product-title","textColor":"contrast","style":{"spacing":{"margin":{"top":"var:preset|spacing|30","bottom":"var:preset|spacing|10"}}},"fontSize":"medium","fontFamily":"heading"} /-->

		<!-- wp:woocommerce/product-rating {"style":{"spacing":{"margin":{"bottom":"var:preset|spacing|10"}}},"fontSize":"small"} /-->

		<!-- wp:woocommerce/product-price {"textColor":"primary","fontSize":"medium","fontFamily":"heading"} /-->
		<!-- /wp:woocommerce/product-template -->
	</div>
	<!-- /wp:woocommerce/product-collection -->
</section>
<!-- /wp:group -->
