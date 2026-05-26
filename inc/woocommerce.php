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

/**
 * Remove default WooCommerce styles — we use our own.
 */
add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );

/**
 * Remove default WooCommerce breadcrumb on shop — we have the banner.
 */
add_action( 'init', function () {
	remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );
	remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
	remove_action( 'woocommerce_after_main_content',  'woocommerce_output_content_wrapper_end', 10 );
} );

/**
 * Set 4 products per row on archive pages.
 */
add_filter( 'loop_shop_columns', function () {
	return 4;
} );

/**
 * Ensure WooCommerce cart and checkout pages use classic PHP template files.
 *
 * WooCommerce 7+ ships with block-based cart/checkout by default, which
 * bypasses our custom template overrides in woocommerce/cart/cart.php and
 * woocommerce/checkout/form-checkout.php.
 *
 * This runs once on first admin visit (or theme activation) and converts
 * any block-based WC pages to the classic shortcode equivalent so our
 * premium templates are rendered correctly.
 */
function lumea_ensure_classic_wc_pages() {
	if ( get_option( 'lumea_classic_wc_v1' ) || ! function_exists( 'wc_get_page_id' ) ) {
		return;
	}

	$pages = array(
		wc_get_page_id( 'checkout' ) => '<!-- wp:shortcode -->[woocommerce_checkout]<!-- /wp:shortcode -->',
		wc_get_page_id( 'cart' )     => '<!-- wp:shortcode -->[woocommerce_cart]<!-- /wp:shortcode -->',
	);

	foreach ( $pages as $page_id => $content ) {
		if ( $page_id <= 0 ) {
			continue;
		}
		$post = get_post( $page_id );
		if ( $post && has_blocks( $post->post_content ) ) {
			wp_update_post( array(
				'ID'           => $page_id,
				'post_content' => $content,
			) );
		}
	}

	update_option( 'lumea_classic_wc_v1', 1 );
}
add_action( 'after_switch_theme', 'lumea_ensure_classic_wc_pages' );
add_action( 'admin_init',         'lumea_ensure_classic_wc_pages' );

/**
 * Front-end fallback: if cart/checkout pages still have blocks on the
 * first front-end visit (before any admin visit), convert and redirect once.
 */
add_action( 'template_redirect', function () {
	if ( get_option( 'lumea_classic_wc_v1' ) ) {
		return;
	}
	if ( ! is_cart() && ! is_checkout() ) {
		return;
	}
	lumea_ensure_classic_wc_pages();
	if ( is_cart() ) {
		wp_safe_redirect( wc_get_cart_url() );
	} else {
		wp_safe_redirect( wc_get_checkout_url() );
	}
	exit;
} );
