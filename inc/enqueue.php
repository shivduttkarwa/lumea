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
		'https://api.fontshare.com/v2/css?f[]=clash-display@400,500,600&display=swap',
		array(),
		null
	);

	
	wp_enqueue_style(
		'lumea-inter',
		'https://fonts.googleapis.com/css2?family=Inter:wght@500;600;700;800&display=swap',
		array(),
		null
	);

	
	wp_enqueue_style(
		'lumea-bootstrap',
		'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css',
		array(),
		'5.3.3'
	);

	wp_enqueue_script(
		'lumea-bootstrap',
		'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js',
		array(),
		'5.3.3',
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

	
	wp_enqueue_script(
		'gsap',
		'https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/gsap.min.js',
		array(),
		'3.12.5',
		true
	);

	
	wp_enqueue_script(
		'gsap-scrolltrigger',
		'https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/ScrollTrigger.min.js',
		array( 'gsap' ),
		'3.12.5',
		true
	);

	
	wp_enqueue_script(
		'gsap-drawsvg',
		'https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/DrawSVGPlugin.min.js',
		array( 'gsap' ),
		'3.12.5',
		true
	);

	
	wp_enqueue_script(
		'gsap-splittext',
		'https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/SplitText.min.js',
		array( 'gsap' ),
		'3.12.5',
		true
	);

	
	wp_enqueue_script(
		'lumea-main',
		LUMEA_THEME_URI . '/assets/js/main.js',
		array( 'gsap', 'gsap-scrolltrigger', 'gsap-drawsvg', 'gsap-splittext' ),
		LUMEA_VERSION,
		true
	);

	
	wp_enqueue_script(
		'lumea-animations',
		LUMEA_THEME_URI . '/assets/js/animations.js',
		array( 'gsap', 'gsap-scrolltrigger', 'gsap-splittext' ),
		LUMEA_VERSION,
		true
	);

	wp_localize_script(
		'lumea-main',
		'lumeaData',
		array(
			'ajaxUrl' => admin_url( 'admin-ajax.php' ),
			'nonce'   => wp_create_nonce( 'lumea_wishlist' ),
			'shopUrl' => function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'shop' ) : home_url( '/shop/' ),
			'cartUrl' => function_exists( 'wc_get_cart_url' ) ? wc_get_cart_url() : home_url( '/cart/' ),
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
			1 => array( 'lumea_hero_image',   LUMEA_THEME_URI . '/assets/images/hero1.jpg' ),
			2 => array( 'lumea_hero_image_2', '' ),
			3 => array( 'lumea_hero_image_3', '' ),
			4 => array( 'lumea_hero_image_4', '' ),
			5 => array( 'lumea_hero_image_5', '' ),
		);

		$hero_label_defaults = array(
			1 => 'Glow',
			2 => 'Hydrate',
			3 => 'Nourish',
			4 => 'Protect',
			5 => 'Renew',
		);

		foreach ( $lumea_hero_image_keys as $slide_num => $slot ) {
			$url = get_theme_mod( $slot[0], $slot[1] );
			if ( $url ) {
				$lumea_hero_images[] = esc_url( $url );

				$label_key = ( 1 === $slide_num ) ? 'lumea_hero_label' : 'lumea_hero_label_' . $slide_num;
				$label_default = isset( $hero_label_defaults[ $slide_num ] ) ? $hero_label_defaults[ $slide_num ] : $hero_label_defaults[1];
				$label         = sanitize_text_field( get_theme_mod( $label_key, $label_default ) );
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
			1 => array( LUMEA_THEME_URI . '/assets/images/1.jpg',    'Botanical skincare rituals designed for luminous skin, soft texture, and everyday radiance.' ),
			2 => array( LUMEA_THEME_URI . '/assets/images/2.jpg',    'Clean formulas, soft botanicals, and refined essentials for a calm beauty routine.' ),
			3 => array( LUMEA_THEME_URI . '/assets/images/hero.jpg', 'A curated edit of everyday glow products made for modern skincare rituals.' ),
			4 => array( LUMEA_THEME_URI . '/assets/images/4.jpg',    'Soft hydration, botanical balance, and skin-first essentials for natural radiance.' ),
			5 => array( LUMEA_THEME_URI . '/assets/images/he.jpg',   'A fresh beauty wardrobe made for skin that feels balanced, bright, and alive.' ),
			6 => array( LUMEA_THEME_URI . '/assets/images/6.jpg',    'Glow-focused skincare where timeless botanicals meet a modern beauty edge.' ),
		);

		$lumea_slides = array();
		$lumea_shop_fallback = function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'shop' ) : home_url( '/shop/' );
		foreach ( $lumea_slide_defaults as $n => $d ) {
			$lumea_slides[] = array(
				'number' => str_pad( $n, 2, '0', STR_PAD_LEFT ),
				'text'   => sanitize_textarea_field( get_theme_mod( 'lumea_slide_' . $n . '_text',  $d[1] ) ),
				'image'  => esc_url( get_theme_mod( 'lumea_slide_' . $n . '_image', $d[0] ) ),
				'url'    => esc_url( get_theme_mod( 'lumea_slide_' . $n . '_url', $lumea_shop_fallback ) ),
			);
		}

		wp_localize_script( 'lumea-slider', 'lumea_slider', array( 'slides' => $lumea_slides ) );

		
		wp_enqueue_style(
			'swiper',
			'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css',
			array(),
			'11.0.0'
		);
		wp_enqueue_script(
			'swiper',
			'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js',
			array(),
			'11.0.0',
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

	
	if ( function_exists( 'is_checkout' ) && is_checkout() ) {
		wp_enqueue_script(
			'lumea-checkout',
			LUMEA_THEME_URI . '/assets/js/checkout.js',
			array(),
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
				'heroImage' => esc_url( get_theme_mod( 'lumea_hero_image', LUMEA_THEME_URI . '/assets/images/hero1.jpg' ) ),
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
}
add_action( 'wp_enqueue_scripts', 'lumea_enqueue_assets' );


function lumea_enqueue_editor_assets() {
	wp_enqueue_style(
		'lumea-editor-bootstrap',
		'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css',
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
