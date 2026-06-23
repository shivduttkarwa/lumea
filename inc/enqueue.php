<?php
/**
 * Theme assets.
 *
 * @package Lumea
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


function lumea_enqueue_assets() {

	wp_enqueue_style(
		'lumea-clash-display',
		LUMEA_THEME_URI . '/assets/vendor/fonts/clash-display/clash-display.css',
		array(),
		'1.0.0'
	);

	wp_enqueue_style(
		'lumea-inter',
		LUMEA_THEME_URI . '/assets/vendor/fonts/inter/inter.css',
		array(),
		'20.0.0'
	);

	wp_enqueue_style(
		'lumea-bootstrap',
		LUMEA_THEME_URI . '/assets/vendor/bootstrap/bootstrap.min.css',
		array(),
		'5.3.8'
	);

	wp_enqueue_script(
		'lumea-bootstrap',
		LUMEA_THEME_URI . '/assets/vendor/bootstrap/bootstrap.bundle.min.js',
		array(),
		'5.3.8',
		true
	);

	wp_enqueue_style(
		'lumea-tokens',
		LUMEA_THEME_URI . '/assets/css/tokens.css',
		array( 'lumea-bootstrap', 'lumea-clash-display', 'lumea-inter' ),
		LUMEA_VERSION
	);

	wp_enqueue_style(
		'lumea-typography',
		LUMEA_THEME_URI . '/assets/css/typography.css',
		array( 'lumea-tokens' ),
		LUMEA_VERSION
	);

	wp_enqueue_style(
		'lumea-bootstrap-overrides',
		LUMEA_THEME_URI . '/assets/css/bootstrap-overrides.css',
		array( 'lumea-typography' ),
		LUMEA_VERSION
	);

	wp_enqueue_style(
		'lumea-main',
		LUMEA_THEME_URI . '/assets/css/main.css',
		array( 'lumea-bootstrap-overrides' ),
		LUMEA_VERSION
	);

	wp_enqueue_style(
		'lumea-buttons',
		LUMEA_THEME_URI . '/assets/css/buttons.css',
		array( 'lumea-main' ),
		LUMEA_VERSION
	);

	wp_enqueue_style(
		'lumea-animations',
		LUMEA_THEME_URI . '/assets/css/animations.css',
		array( 'lumea-tokens' ),
		LUMEA_VERSION
	);

	wp_enqueue_style(
		'lumea-blocks',
		LUMEA_THEME_URI . '/assets/css/blocks.css',
		array( 'lumea-tokens', 'lumea-typography' ),
		LUMEA_VERSION
	);

	wp_enqueue_style(
		'lumea-print',
		LUMEA_THEME_URI . '/assets/css/print.css',
		array( 'lumea-main' ),
		LUMEA_VERSION,
		'print'
	);

	wp_enqueue_script(
		'gsap',
		LUMEA_THEME_URI . '/assets/vendor/gsap/gsap.min.js',
		array(),
		'3.15.0',
		true
	);

	wp_enqueue_script(
		'gsap-scrolltrigger',
		LUMEA_THEME_URI . '/assets/vendor/gsap/ScrollTrigger.min.js',
		array( 'gsap' ),
		'3.15.0',
		true
	);

	wp_enqueue_script(
		'lumea-main',
		LUMEA_THEME_URI . '/assets/js/main.js',
		array( 'gsap', 'gsap-scrolltrigger' ),
		LUMEA_VERSION,
		true
	);

	wp_enqueue_script(
		'lumea-animations',
		LUMEA_THEME_URI . '/assets/js/animations.js',
		array( 'gsap', 'gsap-scrolltrigger' ),
		LUMEA_VERSION,
		true
	);

	wp_localize_script(
		'lumea-main',
		'lumeaData',
		array(
			'ajaxUrl' => admin_url( 'admin-ajax.php' ),
			'nonce'   => wp_create_nonce( 'lumea_wishlist' ),
			'shopUrl' => lumea_get_shop_url(),
			'cartUrl' => lumea_get_cart_url(),
			'i18n'    => array(
				'addToWishlist'        => __( 'Add to wishlist', 'lumea' ),
				'removeFromWishlist'   => __( 'Remove from wishlist', 'lumea' ),
				'addToCart'            => __( 'Add to Cart', 'lumea' ),
				'viewProduct'          => __( 'View Product', 'lumea' ),
				'viewCart'             => __( 'View Cart', 'lumea' ),
				'quantity'             => __( 'Quantity', 'lumea' ),
				'decrease'             => __( 'Decrease', 'lumea' ),
				'increase'             => __( 'Increase', 'lumea' ),
				'loadingFavourites'    => __( 'Loading favourites...', 'lumea' ),
				'remove'               => __( 'Remove', 'lumea' ),
				/* translators: %s: product name */
				'removeFromWishlistOf' => __( 'Remove %s from wishlist', 'lumea' ),

				'showPassword'         => __( 'Show password', 'lumea' ),
				'hidePassword'         => __( 'Hide password', 'lumea' ),
				'pwWeak'               => __( 'Weak', 'lumea' ),
				'pwFair'               => __( 'Fair', 'lumea' ),
				'pwGood'               => __( 'Good', 'lumea' ),
				'pwStrong'             => __( 'Strong', 'lumea' ),
			),
		)
	);

	if ( is_front_page() ) {
		wp_enqueue_script(
			'lumea-hero',
			LUMEA_THEME_URI . '/assets/js/hero.js',
			array( 'gsap' ),
			LUMEA_VERSION,
			true
		);

		$lumea_hero_images = array();
		$lumea_hero_labels = array();

		$lumea_hero_image_keys = array(
			1 => array( 'lumea_hero_image', LUMEA_THEME_URI . '/assets/images/hero-slide-1.jpg' ),
			2 => array( 'lumea_hero_image_2', '' ),
			3 => array( 'lumea_hero_image_3', '' ),
			4 => array( 'lumea_hero_image_4', '' ),
			5 => array( 'lumea_hero_image_5', '' ),
		);

		$hero_label_defaults = array(
			1 => __( 'Glow', 'lumea' ),
			2 => __( 'Hydrate', 'lumea' ),
			3 => __( 'Nourish', 'lumea' ),
			4 => __( 'Protect', 'lumea' ),
			5 => __( 'Renew', 'lumea' ),
		);

		foreach ( $lumea_hero_image_keys as $slide_num => $slot ) {
			$url = get_theme_mod( $slot[0], $slot[1] );
			if ( $url ) {
				$lumea_hero_images[] = esc_url( $url );

				$label_key           = ( 1 === $slide_num ) ? 'lumea_hero_label' : 'lumea_hero_label_' . $slide_num;
				$label_default       = isset( $hero_label_defaults[ $slide_num ] ) ? $hero_label_defaults[ $slide_num ] : $hero_label_defaults[1];
				$label               = sanitize_text_field( get_theme_mod( $label_key, $label_default ) );
				$lumea_hero_labels[] = '' !== $label ? $label : $label_default;
			}
		}

		wp_localize_script(
			'lumea-hero',
			'lumea_hero',
			array(
				'images' => $lumea_hero_images,
				'labels' => $lumea_hero_labels,
			)
		);

		wp_enqueue_script(
			'lumea-slider',
			LUMEA_THEME_URI . '/assets/js/slider.js',
			array(),
			LUMEA_VERSION,
			true
		);

		wp_enqueue_script(
			'lumea-manifest',
			LUMEA_THEME_URI . '/assets/js/manifest.js',
			array(),
			LUMEA_VERSION,
			true
		);

		$lumea_slide_defaults = array(
			1 => array( LUMEA_THEME_URI . '/assets/images/editorial-slide-1.jpg', __( 'Botanical skincare rituals designed for luminous skin, soft texture, and everyday radiance.', 'lumea' ) ),
			2 => array( LUMEA_THEME_URI . '/assets/images/editorial-slide-2.jpg', __( 'Clean formulas, soft botanicals, and refined essentials for a calm beauty routine.', 'lumea' ) ),
			3 => array( LUMEA_THEME_URI . '/assets/images/editorial-slide-3.jpg', __( 'A curated edit of everyday glow products made for modern skincare rituals.', 'lumea' ) ),
			4 => array( LUMEA_THEME_URI . '/assets/images/editorial-slide-4.jpg', __( 'Soft hydration, botanical balance, and skin-first essentials for natural radiance.', 'lumea' ) ),
			5 => array( LUMEA_THEME_URI . '/assets/images/editorial-slide-5.jpg', __( 'A fresh beauty wardrobe made for skin that feels balanced, bright, and alive.', 'lumea' ) ),
			6 => array( LUMEA_THEME_URI . '/assets/images/editorial-slide-6.jpg', __( 'Glow-focused skincare where timeless botanicals meet a modern beauty edge.', 'lumea' ) ),
		);

		$lumea_slides        = array();
		$lumea_shop_fallback = lumea_get_shop_url();
		foreach ( $lumea_slide_defaults as $n => $d ) {
			$lumea_slides[] = array(
				'number' => str_pad( $n, 2, '0', STR_PAD_LEFT ),
				'text'   => sanitize_textarea_field( get_theme_mod( 'lumea_slide_' . $n . '_text', $d[1] ) ),
				'image'  => esc_url( get_theme_mod( 'lumea_slide_' . $n . '_image', $d[0] ) ),
				'url'    => esc_url( get_theme_mod( 'lumea_slide_' . $n . '_url', $lumea_shop_fallback ) ),
			);
		}

		wp_localize_script( 'lumea-slider', 'lumea_slider', array( 'slides' => $lumea_slides ) );

		wp_enqueue_style(
			'swiper',
			LUMEA_THEME_URI . '/assets/vendor/swiper/swiper-bundle.min.css',
			array(),
			'12.2.0'
		);
		wp_enqueue_script(
			'swiper',
			LUMEA_THEME_URI . '/assets/vendor/swiper/swiper-bundle.min.js',
			array(),
			'12.2.0',
			true
		);
		wp_enqueue_script(
			'lumea-bestsellers',
			LUMEA_THEME_URI . '/assets/js/bestsellers.js',
			array( 'swiper' ),
			LUMEA_VERSION,
			true
		);

		wp_enqueue_script(
			'lumea-ritual',
			LUMEA_THEME_URI . '/assets/js/ritual.js',
			array( 'gsap-scrolltrigger' ),
			LUMEA_VERSION,
			true
		);
	}

	if ( function_exists( 'is_product' ) && is_product() ) {
		wp_enqueue_script(
			'lumea-single-product',
			LUMEA_THEME_URI . '/assets/js/single-product.js',
			array(),
			LUMEA_VERSION,
			true
		);
	}

	if ( is_page_template( 'page-faq.php' ) ) {
		wp_enqueue_script(
			'lumea-faq',
			LUMEA_THEME_URI . '/assets/js/faq.js',
			array(),
			LUMEA_VERSION,
			true
		);
	}

	if ( function_exists( 'is_cart' ) && is_cart() ) {
		wp_enqueue_script(
			'lumea-cart-page',
			LUMEA_THEME_URI . '/assets/js/cart-page.js',
			array( 'lumea-main' ),
			LUMEA_VERSION,
			true
		);
		wp_localize_script(
			'lumea-cart-page',
			'lumeaCartData',
			array(
				'heroImage' => esc_url( get_theme_mod( 'lumea_hero_image', LUMEA_THEME_URI . '/assets/images/hero-slide-1.jpg' ) ),
				'i18n'      => array(
					'qtyError'    => __( 'Could not update quantity. Please try again.', 'lumea' ),
					'yourBag'     => __( 'Your Bag', 'lumea' ),
					'nothingYet'  => __( 'Nothing here yet', 'lumea' ),
					'emptyText'   => __( 'Your bag is empty. Browse our botanical skincare collection and find your ritual.', 'lumea' ),
					'shopAll'     => __( 'Shop the Collection', 'lumea' ),
					'freeReturns' => __( 'Free returns on all orders', 'lumea' ),
				),
			)
		);
	}

	if ( function_exists( 'is_account_page' ) && is_account_page() ) {
		wp_enqueue_script(
			'lumea-account-edit',
			LUMEA_THEME_URI . '/assets/js/account-edit.js',
			array( 'lumea-main' ),
			LUMEA_VERSION,
			true
		);
	}

	if ( is_singular( 'post' ) && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'lumea_enqueue_assets' );


function lumea_enqueue_editor_assets() {
	wp_enqueue_style(
		'lumea-editor-bootstrap',
		LUMEA_THEME_URI . '/assets/vendor/bootstrap/bootstrap.min.css',
		array(),
		'5.3.3'
	);
	wp_enqueue_style(
		'lumea-editor-tokens',
		LUMEA_THEME_URI . '/assets/css/tokens.css',
		array( 'lumea-editor-bootstrap' ),
		LUMEA_VERSION
	);
	wp_enqueue_style(
		'lumea-editor-typography',
		LUMEA_THEME_URI . '/assets/css/typography.css',
		array( 'lumea-editor-tokens' ),
		LUMEA_VERSION
	);
	wp_enqueue_style(
		'lumea-editor-bootstrap-overrides',
		LUMEA_THEME_URI . '/assets/css/bootstrap-overrides.css',
		array( 'lumea-editor-typography' ),
		LUMEA_VERSION
	);
	wp_enqueue_style(
		'lumea-editor-main',
		LUMEA_THEME_URI . '/assets/css/main.css',
		array( 'lumea-editor-bootstrap-overrides' ),
		LUMEA_VERSION
	);

	wp_enqueue_style(
		'lumea-editor-blocks',
		LUMEA_THEME_URI . '/assets/css/blocks.css',
		array( 'lumea-editor-tokens', 'lumea-editor-typography' ),
		LUMEA_VERSION
	);
}
add_action( 'enqueue_block_editor_assets', 'lumea_enqueue_editor_assets' );
