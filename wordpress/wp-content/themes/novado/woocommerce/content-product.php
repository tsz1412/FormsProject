<?php
/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.6.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

// Ensure visibility.
if ( empty( $product ) || ! $product->is_visible() ) {
	return;
}
?>

<div <?php wc_product_class( '', $product ); ?>>
    <div class="product ">
        <div class="product-type"><h5 class="-new">New</h5></div>
        <div class="product-thumb"><a class="product-thumb__image" href="<?php echo get_permalink( $post_id ) ?>">
                <?php do_action( 'woocommerce_before_shop_loop_item_title' ); ?>
            </a>
            <div class="product-thumb__actions">
                <div class="product-btn">
                    <?php
//                    echo apply_filters(
//                        'woocommerce_loop_add_to_cart_link', // WPCS: XSS ok.
//                        sprintf(
//                            '<a href="%s" data-quantity="%s" class="btn -white product__actions__item -round product-atc" %s><i class="fas fa-shopping-bag"></i></a>',
//                            esc_url( $product->add_to_cart_url() ),
//                            esc_attr( isset( $args['quantity'] ) ? $args['quantity'] : 1 ),
//                            isset( $args['attributes'] ) ? wc_implode_html_attributes( $args['attributes'] ) : '',
//                        ),
//                        $product,
//                        $args
//                    );
                    do_action( 'woocommerce_after_shop_loop_item' );

                    ?>
                </div>
                <div class="product-btn"><a class="btn -white product__actions__item -round product-qv" href="#"><i class="fas fa-eye"></i></a>
                </div>
            </div>
        </div>
        <div class="product-content">
            <div class="product-content__header">
                <div class="product-category">Category</div>
            </div>
            <?php do_action( 'woocommerce_shop_loop_item_title' ); ?>
            <div class="product-content__footer">
                <?php do_action( 'woocommerce_after_shop_loop_item_title' ); ?>
            </div>
        </div>
    </div>

    <?php
	/**
	 * Hook: woocommerce_before_shop_loop_item.
	 *
	 * @hooked woocommerce_template_loop_product_link_open - 10
	 */
	do_action( 'woocommerce_before_shop_loop_item' );
//
//	/**
//	 * Hook: woocommerce_before_shop_loop_item_title.
//	 *
//	 * @hooked woocommerce_show_product_loop_sale_flash - 10
//	 * @hooked woocommerce_template_loop_product_thumbnail - 10
//	 */
//	do_action( 'woocommerce_before_shop_loop_item_title' );
//
//	/**
//	 * Hook: woocommerce_shop_loop_item_title.
//	 *
//	 * @hooked woocommerce_template_loop_product_title - 10
//	 */
//	do_action( 'woocommerce_shop_loop_item_title' );
//
//	/**
//	 * Hook: woocommerce_after_shop_loop_item_title.
//	 *
//	 * @hooked woocommerce_template_loop_rating - 5
//	 * @hooked woocommerce_template_loop_price - 10
//	 */
//	do_action( 'woocommerce_after_shop_loop_item_title' );
//
//	/**
//	 * Hook: woocommerce_after_shop_loop_item.
//	 *
//	 * @hooked woocommerce_template_loop_product_link_close - 5
//	 * @hooked woocommerce_template_loop_add_to_cart - 10
//	 */
//	do_action( 'woocommerce_after_shop_loop_item' );
	?>
</div>
