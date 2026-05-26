<?php
/**
 * Theme assets.
 *
 * @package Lumea
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Enqueue theme styles and scripts.
 */
function lumea_enqueue_assets() {

	/* Clash Display — Fontshare */
	wp_enqueue_style(
		'lumea-clash-display',
		'https://api.fontshare.com/v2/css?f[]=clash-display@400,500,600&display=swap',
		array(),
		null
	);

	/* Inter — Google Fonts */
	wp_enqueue_style(
		'lumea-inter',
		'https://fonts.googleapis.com/css2?family=Inter:wght@500;600;700;800&display=swap',
		array(),
		null
	);

	/* Bootstrap 5.3 foundation */
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

	/* Theme tokens and typography layers */
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

	/* Main stylesheet */
	wp_enqueue_style(
		'lumea-main',
		LUMEA_THEME_URI . '/assets/css/main.css',
		array( 'lumea-bootstrap-overrides' ),
		LUMEA_VERSION
	);

	/* Main script */
	wp_enqueue_script(
		'lumea-main',
		LUMEA_THEME_URI . '/assets/js/main.js',
		array(),
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
		)
	);

	/* Hero canvas script + editorial slider — front page only */
	if ( is_front_page() ) {
		wp_enqueue_script(
			'lumea-hero',
			LUMEA_THEME_URI . '/assets/js/hero.js',
			array(),
			LUMEA_VERSION,
			true
		);

		// Collect hero slider images (slot 1 is required, 2–5 are optional)
		$lumea_hero_images = array();

		$lumea_hero_image_keys = array(
			1 => array( 'lumea_hero_image',   LUMEA_THEME_URI . '/assets/images/hero1.jpg' ),
			2 => array( 'lumea_hero_image_2', '' ),
			3 => array( 'lumea_hero_image_3', '' ),
			4 => array( 'lumea_hero_image_4', '' ),
			5 => array( 'lumea_hero_image_5', '' ),
		);

		foreach ( $lumea_hero_image_keys as $slot ) {
			$url = get_theme_mod( $slot[0], $slot[1] );
			if ( $url ) {
				$lumea_hero_images[] = esc_url( $url );
			}
		}

		wp_localize_script(
			'lumea-hero',
			'lumea_hero',
			array(
				'images' => $lumea_hero_images,
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

		/* Swiper (bestsellers section) */
		wp_enqueue_style(
			'swiper',
			'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css',
			array(),
			null
		);
		wp_enqueue_script(
			'swiper',
			'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js',
			array(),
			null,
			true
		);
		wp_enqueue_script(
			'lumea-bestsellers',
			LUMEA_THEME_URI . '/assets/js/bestsellers.js',
			array( 'swiper' ),
			LUMEA_VERSION,
			true
		);

		/* GSAP + ScrollTrigger (ritual section) */
		wp_enqueue_script(
			'gsap',
			'https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/gsap.min.js',
			array(),
			null,
			true
		);
		wp_enqueue_script(
			'gsap-scrolltrigger',
			'https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/ScrollTrigger.min.js',
			array( 'gsap' ),
			null,
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
}
add_action( 'wp_enqueue_scripts', 'lumea_enqueue_assets' );

/**
 * Load theme styles in block editor for consistent button previews.
 */
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
}
add_action( 'enqueue_block_editor_assets', 'lumea_enqueue_editor_assets' );
