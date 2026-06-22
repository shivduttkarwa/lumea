<?php
/**
 * Product card — shop loop.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 9.4.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

if ( ! $product || ! $product->is_visible() ) {
	return;
}

$can_add_to_cart = $product->is_purchasable() && $product->is_in_stock();

?>
<li class="<?php echo esc_attr( implode( ' ', wc_get_product_class( 'lumea-shop-card', $product ) ) ); ?>">
	<?php if ( function_exists( 'lumea_render_product_card' ) ) : ?>
		<?php
		lumea_render_product_card(
			$product,
			array(
				'button_class'   => 'lumea-btn btn-black',
				'button_label'   => $can_add_to_cart ? __( 'Add to Cart', 'lumea' ) : __( 'View Product', 'lumea' ),
				'fallback_label' => __( 'View Product', 'lumea' ),
				'card_class'     => 'lumea-lp-card',
			)
		);
		?>
	<?php endif; ?>
</li>
