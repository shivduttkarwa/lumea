<?php
/**
 * WooCommerce presentation integration.
 *
 * @package Lumea
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Keep WooCommerce's public hook architecture while replacing only its
 * default visual callbacks with the theme's custom presentation.
 */
function lumea_woocommerce_presentation_setup() {
	// The theme supplies its own page wrappers and archive header.
	remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
	remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );
	remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );
	remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );
	remove_action( 'woocommerce_shop_loop_header', 'woocommerce_product_taxonomy_archive_header', 10 );
	remove_action( 'woocommerce_shop_loop_header', 'woocommerce_product_archive_description', 10 );

	// The custom filter bar and pagination replace these core visual callbacks.
	remove_action( 'woocommerce_before_shop_loop', 'woocommerce_output_all_notices', 10 );
	remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
	remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );
	remove_action( 'woocommerce_after_shop_loop', 'woocommerce_pagination', 10 );
	remove_action( 'woocommerce_no_products_found', 'wc_no_products_found', 10 );

	// Product cards provide their own visible markup; public actions remain in
	// the template so extensions can continue to attach content.
	remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10 );
	remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10 );
	remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );
	remove_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10 );
	remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );
	remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10 );
	remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 );
	remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );

	// The single-product template retains the same public actions but supplies
	// the visible gallery, summary, tabs/reviews, and related-product layout.
	remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10 );
	remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 20 );
	remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );
	remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );
	remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
	remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );
	remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
	remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
	remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 50 );
	remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10 );
	remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
	remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );

	// Keep the checkout order-review hook intact while placing its core payment
	// callback in the theme's visually designed payment panel.
	remove_action( 'woocommerce_checkout_order_review', 'woocommerce_checkout_payment', 20 );
	add_action( 'lumea_checkout_payment', 'woocommerce_checkout_payment', 20 );

	// The theme renders cart totals in its summary card; preserve the public
	// collaterals action for extension callbacks without duplicating totals.
	remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cart_totals', 10 );
}
add_action( 'wp', 'lumea_woocommerce_presentation_setup' );


function lumea_get_product_card_data( $product ) {
	if ( ! class_exists( 'WooCommerce' ) || ! function_exists( 'wc_get_product' ) ) {
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

	$product_id            = $wc_product->get_id();
	$gallery_ids           = $wc_product->get_gallery_image_ids();
	$product_terms         = get_the_terms( $product_id, 'product_cat' );
	$is_sale               = $wc_product->is_on_sale();
	$can_add_to_cart       = $wc_product->is_purchasable() && $wc_product->is_in_stock();
	$product_name          = $wc_product->get_name();
	$product_category      = ( ! is_wp_error( $product_terms ) && ! empty( $product_terms ) ) ? $product_terms[0]->name : '';
	$regular_price         = $wc_product->get_regular_price();
	$regular_price_display = ( $is_sale && '' !== $regular_price ) ? wc_price( $regular_price ) : '';

	return array(
		'product_id'      => $product_id,
		'name'            => $product_name,
		'url'             => get_permalink( $product_id ),
		'price_html'      => $wc_product->get_price_html(),
		'old_price_html'  => $regular_price_display,
		'is_sale'         => $is_sale,
		'badge'           => $is_sale ? __( 'Sale', 'lumea' ) : __( 'New', 'lumea' ),
		'main_image'      => get_the_post_thumbnail_url( $product_id, 'woocommerce_single' ),
		'hover_image'     => ! empty( $gallery_ids ) ? wp_get_attachment_image_url( $gallery_ids[0], 'woocommerce_single' ) : '',
		'category'        => $product_category,
		'product_type'    => $wc_product->get_type(),
		'can_add_to_cart' => $can_add_to_cart,
		'supports_ajax'   => $can_add_to_cart && $wc_product->supports( 'ajax_add_to_cart' ),
		'button_label'    => __( 'Add to Cart', 'lumea' ),
		'fallback_label'  => __( 'Shop Now', 'lumea' ),
		'button_class'    => 'lumea-btn btn-black',
		'card_class'      => 'lumea-lp-card',
	);
}


function lumea_render_product_card( $product, $overrides = array() ) {
	$data = array();

	if ( is_array( $product ) ) {
		$data       = $product;
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


function lumea_render_product_card_actions( $args = array() ) {
	if ( ! class_exists( 'WooCommerce' ) ) {
		return;
	}

	$defaults = array(
		'product_id'      => 0,
		'product_url'     => '',
		'product_name'    => '',
		'product_type'    => 'simple',
		'button_class'    => 'lumea-btn btn-black',
		'button_label'    => __( 'Add to Cart', 'lumea' ),
		'fallback_label'  => __( 'Shop Now', 'lumea' ),
		'can_add_to_cart' => true,
		'supports_ajax'   => true,
	);
	$args     = wp_parse_args( $args, $defaults );

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
		$atc_aria = sprintf(
			/* translators: %s: product name */
			__( 'Add %s to cart', 'lumea' ),
			$product_name
		);
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
		<a href="<?php echo esc_url( lumea_get_cart_url() ); ?>" class="lumea-view-cart-btn" data-lumea-view-cart>
			<svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 01-8 0"/></svg>
			<span><?php esc_html_e( 'View Cart', 'lumea' ); ?></span>
		</a>
		<?php
	} else {
		echo '<a href="' . esc_url( $product_url ) . '" class="' . esc_attr( $button_class ) . '">' . esc_html( $fallback_text ) . '</a>';
	}

	echo '</div>';
}


function lumea_cart_fragments( $fragments ) {
	if ( ! function_exists( 'WC' ) || ! WC()->cart ) {
		return $fragments;
	}

	$count                              = WC()->cart->get_cart_contents_count();
	$fragments['span.lumea-cart-count'] = '<span class="lumea-cart-count' . ( $count ? ' lumea-cart-count--visible' : '' ) . '">' . esc_html( $count ) . '</span>';

	ob_start();
	lumea_mini_cart_items();
	$fragments['div.lumea-drawer-items'] = ob_get_clean();

	ob_start();
	lumea_drawer_footer();
	$fragments['div.lumea-drawer-footer'] = ob_get_clean();

	return $fragments;
}
add_filter( 'woocommerce_add_to_cart_fragments', 'lumea_cart_fragments' );


function lumea_mini_cart_items() {
	$cart = ( function_exists( 'WC' ) && WC()->cart ) ? WC()->cart : null;

	echo '<div class="lumea-drawer-items">';

	if ( ! $cart || $cart->is_empty() ) {
		echo '<div class="lumea-drawer-empty-state">';
		echo '<p class="lumea-drawer-empty">' . esc_html__( 'Your cart is empty.', 'lumea' ) . '</p>';
		echo '<a href="' . esc_url( lumea_get_shop_url() ) . '" class="lumea-drawer-empty-btn">' . esc_html__( 'Shop Products', 'lumea' ) . '</a>';
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
					<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
				</a>
			</div>
			<?php
		}
	}

	echo '</div>';
}


function lumea_drawer_footer() {
	$cart = ( function_exists( 'WC' ) && WC()->cart ) ? WC()->cart : null;

	echo '<div class="lumea-drawer-footer">';
	if ( $cart && ! $cart->is_empty() ) :
		?>
		<div class="lumea-drawer-subtotal">
			<span><?php esc_html_e( 'Subtotal', 'lumea' ); ?></span>
			<span><?php echo wp_kses_post( $cart->get_cart_subtotal() ); ?></span>
		</div>
		<a href="<?php echo esc_url( lumea_get_cart_url() ); ?>" class="lumea-drawer-cart-btn"><?php esc_html_e( 'View Cart', 'lumea' ); ?></a>
		<a href="<?php echo esc_url( lumea_get_checkout_url() ); ?>" class="lumea-drawer-checkout-btn"><?php esc_html_e( 'Checkout', 'lumea' ); ?></a>
		<?php
	endif;
	echo '</div>';
}


function lumea_wc_body_class( $classes ) {
	if ( function_exists( 'is_woocommerce' ) ) {
		$classes[] = 'woocommerce-js';
	}

	return $classes;
}
add_filter( 'body_class', 'lumea_wc_body_class' );


add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );


add_filter( 'loop_shop_columns', 'lumea_loop_shop_columns' );
function lumea_loop_shop_columns() {
	return 4;
}
