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
 * Force WooCommerce store currency to USD.
 *
 * Note: This changes displayed/charged currency code and symbol only.
 * Existing product numeric prices are not converted automatically.
 */
function lumea_woocommerce_currency_usd() {
	return 'USD';
}
add_filter( 'woocommerce_currency', 'lumea_woocommerce_currency_usd' );

/**
 * Ensure USD symbol output remains "$" across WooCommerce price renderers.
 */
function lumea_woocommerce_usd_symbol( $symbol, $currency ) {
	if ( 'USD' === $currency ) {
		return '$';
	}
	return $symbol;
}
add_filter( 'woocommerce_currency_symbol', 'lumea_woocommerce_usd_symbol', 10, 2 );

/**
 * Build normalized card data from a WooCommerce product.
 *
 * @param mixed $product WC_Product object or product ID.
 * @return array
 */
function lumea_get_product_card_data( $product ) {
	if ( ! class_exists( 'WooCommerce' ) ) {
		return array();
	}

	$wc_product = null;
	if ( $product instanceof WC_Product ) {
		$wc_product = $product;
	} elseif ( is_numeric( $product ) ) {
		$wc_product = wc_get_product( absint( $product ) );
	}

	if ( ! $wc_product ) {
		return array();
	}

	$product_id       = $wc_product->get_id();
	$gallery_ids      = $wc_product->get_gallery_image_ids();
	$product_terms    = get_the_terms( $product_id, 'product_cat' );
	$is_sale          = $wc_product->is_on_sale();
	$can_add_to_cart  = $wc_product->is_purchasable() && $wc_product->is_in_stock();
	$product_name     = $wc_product->get_name();
	$product_category = ( ! is_wp_error( $product_terms ) && ! empty( $product_terms ) ) ? $product_terms[0]->name : '';

	return array(
		'product_id'       => $product_id,
		'name'             => $product_name,
		'url'              => get_permalink( $product_id ),
		'price_html'       => $wc_product->get_price_html(),
		'old_price_html'   => $is_sale ? wc_price( $wc_product->get_regular_price() ) : '',
		'is_sale'          => $is_sale,
		'badge'            => $is_sale ? __( 'Sale', 'lumea' ) : __( 'New', 'lumea' ),
		'main_image'       => get_the_post_thumbnail_url( $product_id, 'woocommerce_single' ),
		'hover_image'      => ! empty( $gallery_ids ) ? wp_get_attachment_image_url( $gallery_ids[0], 'woocommerce_single' ) : '',
		'category'         => $product_category,
		'product_type'     => $wc_product->get_type(),
		'can_add_to_cart'  => $can_add_to_cart,
		'supports_ajax'    => $can_add_to_cart && $wc_product->supports( 'ajax_add_to_cart' ),
		'button_label'     => __( 'Add to Cart', 'lumea' ),
		'fallback_label'   => __( 'Shop Now', 'lumea' ),
		'button_class'     => 'lumea-lp-btn',
		'card_class'       => 'lumea-lp-card',
	);
}

/**
 * Render reusable latest-style product card component.
 *
 * @param mixed $product Product ID, WC_Product object, or prepared card-data array.
 * @param array $overrides Values to override card data.
 */
function lumea_render_product_card( $product, $overrides = array() ) {
	$data = array();

	if ( is_array( $product ) ) {
		$data = $product;

		$legacy_map = array(
			'price'     => 'price_html',
			'old_price' => 'old_price_html',
			'image'     => 'main_image',
			'hover'     => 'hover_image',
			'type'      => 'product_type',
		);
		foreach ( $legacy_map as $legacy_key => $new_key ) {
			if ( ! isset( $data[ $new_key ] ) && isset( $data[ $legacy_key ] ) ) {
				$data[ $new_key ] = $data[ $legacy_key ];
			}
		}

		if ( empty( $data['product_id'] ) && ! empty( $data['id'] ) ) {
			$data['product_id'] = absint( $data['id'] );
		}

		if ( ! empty( $data['product_id'] ) ) {
			$has_core_data = ! empty( $data['name'] ) && ! empty( $data['url'] ) && isset( $data['price_html'] );
			if ( ! $has_core_data ) {
				$base = lumea_get_product_card_data( absint( $data['product_id'] ) );
				$data = array_merge( $base, $data );
			}
		}
	} else {
		$data = lumea_get_product_card_data( $product );
	}

	if ( empty( $data ) ) {
		return;
	}

	if ( ! empty( $overrides ) ) {
		$data = array_merge( $data, $overrides );
	}

	get_template_part( 'template-parts/components/product-card', null, $data );
}

/**
 * Render reusable product card purchase actions.
 *
 * Output includes:
 * - Add to cart button
 * - Qty stepper
 * - View cart button
 * Or a fallback CTA when product cannot be directly added.
 *
 * @param array $args Rendering options.
 */
function lumea_render_product_card_actions( $args = array() ) {
	if ( ! class_exists( 'WooCommerce' ) ) {
		return;
	}

	$defaults = array(
		'product_id'      => 0,
		'product_url'     => '',
		'product_name'    => '',
		'product_type'    => 'simple',
		'button_class'    => 'lumea-lp-btn',
		'button_label'    => __( 'Add to Cart', 'lumea' ),
		'fallback_label'  => __( 'Shop Now', 'lumea' ),
		'can_add_to_cart' => true,
		'supports_ajax'   => true,
	);
	$args = wp_parse_args( $args, $defaults );

	$product_id    = absint( $args['product_id'] );
	$product_url   = $args['product_url'] ? esc_url_raw( $args['product_url'] ) : ( $product_id ? get_permalink( $product_id ) : '' );
	$product_name  = wp_strip_all_tags( (string) $args['product_name'] );
	$product_type  = sanitize_html_class( (string) $args['product_type'] );
	$button_class  = sanitize_text_field( (string) $args['button_class'] );
	$button_label  = (string) $args['button_label'];
	$fallback_text = (string) $args['fallback_label'];
	$can_add       = (bool) $args['can_add_to_cart'] && $product_id > 0;
	$supports_ajax = (bool) $args['supports_ajax'];

	echo '<div class="lumea-card-actions">';

	if ( $can_add ) {
		$atc_classes = array(
			$button_class,
			'button',
			'add_to_cart_button',
			'product_type_' . $product_type,
		);
		if ( $supports_ajax ) {
			$atc_classes[] = 'ajax_add_to_cart';
		}

		$atc_url  = add_query_arg( 'add-to-cart', $product_id, $product_url );
		$atc_aria = sprintf( __( 'Add %s to cart', 'lumea' ), $product_name );
		?>
		<div class="lumea-card-atc-wrap">
			<a href="<?php echo esc_url( $atc_url ); ?>"
			   class="<?php echo esc_attr( implode( ' ', array_filter( $atc_classes ) ) ); ?>"
			   data-product_id="<?php echo esc_attr( $product_id ); ?>"
			   data-product_type="<?php echo esc_attr( $product_type ); ?>"
			   data-quantity="1"
			   aria-label="<?php echo esc_attr( $atc_aria ); ?>"
			   rel="nofollow"><?php echo esc_html( $button_label ); ?></a>
			<div class="lumea-qty-stepper" aria-label="<?php esc_attr_e( 'Quantity', 'lumea' ); ?>" data-lumea-qty>
				<button class="lumea-qty-btn lumea-qty-minus" type="button" aria-label="<?php esc_attr_e( 'Decrease', 'lumea' ); ?>">&#8722;</button>
				<span class="lumea-qty-num">1</span>
				<button class="lumea-qty-btn lumea-qty-plus" type="button" aria-label="<?php esc_attr_e( 'Increase', 'lumea' ); ?>" data-product_id="<?php echo esc_attr( $product_id ); ?>">&#43;</button>
			</div>
		</div>
		<a href="<?php echo esc_url( wc_get_cart_url() ); ?>" class="lumea-view-cart-btn" data-lumea-view-cart>
			<svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 01-8 0"/></svg>
			<span><?php esc_html_e( 'View Cart', 'lumea' ); ?></span>
		</a>
		<?php
	} else {
		echo '<a href="' . esc_url( $product_url ) . '" class="' . esc_attr( $button_class ) . '">' . esc_html( $fallback_text ) . '</a>';
	}

	echo '</div>';
}

/**
 * Update cart count and mini-cart HTML via WooCommerce AJAX fragments.
 */
function lumea_cart_fragments( $fragments ) {

	/* Cart count bubble */
	$count = WC()->cart->get_cart_contents_count();
	$fragments['span.lumea-cart-count'] = '<span class="lumea-cart-count' . ( $count ? ' lumea-cart-count--visible' : '' ) . '">' . $count . '</span>';

	/* Items list */
	ob_start();
	lumea_mini_cart_items();
	$fragments['div.lumea-drawer-items'] = ob_get_clean();

	/* Footer (subtotal + buttons) */
	ob_start();
	lumea_drawer_footer();
	$fragments['div.lumea-drawer-footer'] = ob_get_clean();

	return $fragments;
}
add_filter( 'woocommerce_add_to_cart_fragments', 'lumea_cart_fragments' );

/**
 * Render the scrollable items list inside the cart drawer.
 */
function lumea_mini_cart_items() {
	$cart = WC()->cart;
	echo '<div class="lumea-drawer-items">';

	if ( $cart->is_empty() ) {
		$shop_url = wc_get_page_permalink( 'shop' );
		echo '<div class="lumea-drawer-empty-state">';
		echo '<p class="lumea-drawer-empty">' . esc_html__( 'Your cart is empty.', 'lumea' ) . '</p>';
		echo '<a href="' . esc_url( $shop_url ) . '" class="lumea-drawer-empty-btn">' . esc_html__( 'Shop Products', 'lumea' ) . '</a>';
		echo '</div>';
	} else {
		foreach ( $cart->get_cart() as $key => $item ) {
			$product    = $item['data'];
			$product_id = $product->get_id();
			$name       = $product->get_name();
			$qty        = $item['quantity'];
			$unit_price = wc_price( $product->get_price() );
			$img        = wp_get_attachment_image_url( $product->get_image_id(), 'thumbnail' );
			$remove     = wc_get_cart_remove_url( $key );
			?>
			<div class="lumea-drawer-item">
				<?php if ( $img ) : ?>
				<img src="<?php echo esc_url( $img ); ?>" alt="<?php echo esc_attr( $name ); ?>" class="lumea-drawer-item-img" />
				<?php endif; ?>
				<div class="lumea-drawer-item-info">
					<p class="lumea-drawer-item-name"><?php echo esc_html( $name ); ?></p>
					<p class="lumea-drawer-item-price"><?php echo wp_kses_post( $unit_price ); ?></p>
					<div class="lumea-drawer-item-qty" data-lumea-qty>
						<button class="lumea-drawer-qty-btn lumea-qty-minus" type="button" aria-label="<?php esc_attr_e( 'Decrease quantity', 'lumea' ); ?>">&#8722;</button>
						<span class="lumea-qty-num"><?php echo esc_html( $qty ); ?></span>
						<button class="lumea-drawer-qty-btn lumea-qty-plus" type="button" aria-label="<?php esc_attr_e( 'Increase quantity', 'lumea' ); ?>" data-product_id="<?php echo esc_attr( $product_id ); ?>">&#43;</button>
					</div>
				</div>
				<a href="<?php echo esc_url( $remove ); ?>" class="lumea-drawer-item-remove" data-product_id="<?php echo esc_attr( $product_id ); ?>" aria-label="<?php esc_attr_e( 'Remove item', 'lumea' ); ?>">
					<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
				</a>
			</div>
			<?php
		}
	}

	echo '</div>';
}

/**
 * Render the cart drawer footer (subtotal + buttons). Always wrapped by a div.lumea-drawer-footer in the template.
 */
function lumea_drawer_footer() {
	$cart = WC()->cart;
	echo '<div class="lumea-drawer-footer">';
	if ( ! $cart->is_empty() ) :
		?>
		<div class="lumea-drawer-subtotal">
			<span><?php esc_html_e( 'Subtotal', 'lumea' ); ?></span>
			<span><?php echo $cart->get_cart_subtotal(); ?></span>
		</div>
		<a href="<?php echo esc_url( wc_get_cart_url() ); ?>" class="lumea-drawer-cart-btn"><?php esc_html_e( 'View Cart', 'lumea' ); ?></a>
		<a href="<?php echo esc_url( wc_get_checkout_url() ); ?>" class="lumea-drawer-checkout-btn"><?php esc_html_e( 'Checkout', 'lumea' ); ?></a>
		<?php
	endif;
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
 * Ensure the Wishlist page exists and uses the Wishlist template.
 */
function lumea_ensure_wishlist_page() {
	$page    = get_page_by_path( 'wishlist', OBJECT, 'page' );
	$page_id = $page ? (int) $page->ID : 0;

	if ( ! $page_id ) {
		$page_id = wp_insert_post(
			array(
				'post_type'    => 'page',
				'post_status'  => 'publish',
				'post_title'   => __( 'Wishlist', 'lumea' ),
				'post_name'    => 'wishlist',
				'post_content' => '',
			),
			true
		);

		if ( is_wp_error( $page_id ) ) {
			return;
		}
	}

	if ( $page_id > 0 ) {
		update_post_meta( $page_id, '_wp_page_template', 'page-wishlist.php' );
		update_option( 'lumea_wishlist_page_id', absint( $page_id ) );
	}
}
add_action( 'after_switch_theme', 'lumea_ensure_wishlist_page' );
add_action( 'admin_init',         'lumea_ensure_wishlist_page' );

/**
 * AJAX handler — update cart item quantity for a product.
 */
function lumea_update_cart_qty() {
	check_ajax_referer( 'lumea_wishlist', 'nonce' );

	$product_id = absint( $_POST['product_id'] ?? 0 );
	$quantity   = intval( $_POST['quantity'] ?? 0 );

	if ( ! $product_id ) {
		wp_send_json_error( 'missing_product_id' );
	}

	$cart_item_key = null;
	foreach ( WC()->cart->get_cart() as $key => $item ) {
		if ( (int) $item['product_id'] === $product_id ) {
			$cart_item_key = $key;
			break;
		}
	}

	if ( ! $cart_item_key ) {
		wp_send_json_error( 'not_in_cart' );
	}

	if ( $quantity <= 0 ) {
		WC()->cart->remove_cart_item( $cart_item_key );
	} else {
		WC()->cart->set_quantity( $cart_item_key, $quantity, true );
	}

	WC()->cart->calculate_totals();

	$count     = WC()->cart->get_cart_contents_count();
	$fragments = apply_filters( 'woocommerce_add_to_cart_fragments', array() );

	wp_send_json_success( array(
		'count'     => $count,
		'fragments' => $fragments,
	) );
}
add_action( 'wp_ajax_lumea_update_cart_qty',        'lumea_update_cart_qty' );
add_action( 'wp_ajax_nopriv_lumea_update_cart_qty', 'lumea_update_cart_qty' );

/**
 * AJAX handler — return product data for wishlist IDs stored in localStorage.
 */
function lumea_get_wishlist_items() {
	check_ajax_referer( 'lumea_wishlist', 'nonce' );

	$ids   = isset( $_POST['ids'] ) ? array_map( 'absint', (array) $_POST['ids'] ) : array();
	$items = array();

	foreach ( $ids as $id ) {
		$product = wc_get_product( $id );
		if ( ! $product || ! $product->is_visible() ) {
			continue;
		}
		$can_add_to_cart = $product->is_purchasable() && $product->is_in_stock();
		$product_type    = $product->get_type();
		$cart_text       = $can_add_to_cart ? $product->add_to_cart_text() : __( 'View product', 'lumea' );
		$cart_aria       = $can_add_to_cart
			? sprintf( __( 'Add %s to cart', 'lumea' ), $product->get_name() )
			: sprintf( __( 'View %s', 'lumea' ), $product->get_name() );

		$items[] = array(
			'id'              => $id,
			'name'            => $product->get_name(),
			'url'             => get_permalink( $id ),
			'price'           => wp_strip_all_tags( $product->get_price_html() ),
			'image'           => wp_get_attachment_image_url( $product->get_image_id(), 'woocommerce_thumbnail' ) ?: '',
			'type'            => $product_type,
			'can_add_to_cart' => $can_add_to_cart,
			'supports_ajax'   => $can_add_to_cart && $product->supports( 'ajax_add_to_cart' ),
			'cart_url'        => $can_add_to_cart ? $product->add_to_cart_url() : get_permalink( $id ),
			'cart_text'       => $cart_text,
			'cart_aria'       => $cart_aria,
		);
	}

	wp_send_json_success( $items );
}
add_action( 'wp_ajax_lumea_wishlist_items',        'lumea_get_wishlist_items' );
add_action( 'wp_ajax_nopriv_lumea_wishlist_items', 'lumea_get_wishlist_items' );

/**
 * Product admin: Luméa tab with homepage placement checkboxes.
 */
add_filter( 'woocommerce_product_data_tabs', function ( $tabs ) {
	$tabs['lumea'] = array(
		'label'  => 'Luméa',
		'target' => 'lumea_product_data',
		'class'  => array(),
	);
	return $tabs;
} );

add_action( 'woocommerce_product_data_panels', function () {
	echo '<div id="lumea_product_data" class="panel woocommerce_options_panel">';
	woocommerce_wp_checkbox( array(
		'id'          => '_lumea_is_bestseller',
		'label'       => __( 'Show in Bestsellers', 'lumea' ),
		'description' => __( 'Display on the homepage Bestsellers section.', 'lumea' ),
	) );
	woocommerce_wp_checkbox( array(
		'id'          => '_lumea_is_latest',
		'label'       => __( 'Show in Latest Products', 'lumea' ),
		'description' => __( 'Display on the homepage Latest Products section.', 'lumea' ),
	) );
	echo '</div>';
} );

add_action( 'woocommerce_process_product_meta', function ( $post_id ) {
	update_post_meta( $post_id, '_lumea_is_bestseller', isset( $_POST['_lumea_is_bestseller'] ) ? 'yes' : 'no' );
	update_post_meta( $post_id, '_lumea_is_latest',     isset( $_POST['_lumea_is_latest'] )     ? 'yes' : 'no' );
} );

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
