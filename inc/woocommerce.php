<?php
/**
 * WooCommerce integration — cart fragments, AJAX, mini-cart.
 *
 * @package Lumea
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Update cart count and mini-cart HTML via WooCommerce AJAX fragments.
 */
function lumea_cart_fragments( $fragments ) {

	/* Cart count bubble */
	$count = WC()->cart->get_cart_contents_count();

	$fragments['span.lumea-cart-count'] = '<span class="lumea-cart-count' . ( $count ? ' lumea-cart-count--visible' : '' ) . '">' . $count . '</span>';

	/* Mini-cart drawer body */
	ob_start();
	lumea_mini_cart_items();
	$fragments['div.lumea-drawer-items'] = ob_get_clean();

	return $fragments;
}
add_filter( 'woocommerce_add_to_cart_fragments', 'lumea_cart_fragments' );

/**
 * Render mini-cart items list (used in fragment + initial render).
 */
function lumea_mini_cart_items() {
	$cart = WC()->cart;
	echo '<div class="lumea-drawer-items">';

	if ( $cart->is_empty() ) {
		echo '<p class="lumea-drawer-empty">' . esc_html__( 'Your cart is empty.', 'lumea' ) . '</p>';
	} else {
		foreach ( $cart->get_cart() as $key => $item ) {
			$product   = $item['data'];
			$name      = $product->get_name();
			$qty       = $item['quantity'];
			$price     = wc_price( $product->get_price() * $qty );
			$img       = wp_get_attachment_image_url( $product->get_image_id(), 'thumbnail' );
			$remove    = wc_get_cart_remove_url( $key );
			?>
			<div class="lumea-drawer-item">
				<?php if ( $img ) : ?>
				<img src="<?php echo esc_url( $img ); ?>" alt="<?php echo esc_attr( $name ); ?>" class="lumea-drawer-item-img" />
				<?php endif; ?>
				<div class="lumea-drawer-item-info">
					<p class="lumea-drawer-item-name"><?php echo esc_html( $name ); ?></p>
					<p class="lumea-drawer-item-meta">Qty: <?php echo esc_html( $qty ); ?></p>
					<p class="lumea-drawer-item-price"><?php echo wp_kses_post( $price ); ?></p>
				</div>
				<a href="<?php echo esc_url( $remove ); ?>" class="lumea-drawer-item-remove" aria-label="<?php esc_attr_e( 'Remove item', 'lumea' ); ?>">
					<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
				</a>
			</div>
			<?php
		}
	}

	echo '</div>';
}

/**
 * Add WooCommerce body classes for AJAX cart to work.
 */
function lumea_wc_body_class( $classes ) {
	if ( function_exists( 'is_woocommerce' ) ) {
		$classes[] = 'woocommerce-js';
	}
	return $classes;
}
add_filter( 'body_class', 'lumea_wc_body_class' );
