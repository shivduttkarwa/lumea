<?php
/**
 * Product card — shop loop.
 *
 * @package Lumea
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
