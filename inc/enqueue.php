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

	/* Main stylesheet */
	wp_enqueue_style(
		'lumea-main',
		LUMEA_THEME_URI . '/assets/css/main.css',
		array( 'lumea-clash-display', 'lumea-inter' ),
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

	/* Hero canvas script + editorial slider — front page only */
	if ( is_front_page() ) {
		wp_enqueue_script(
			'lumea-hero',
			LUMEA_THEME_URI . '/assets/js/hero.js',
			array(),
			LUMEA_VERSION,
			true
		);

		$lumea_hero_image = get_theme_mod( 'lumea_hero_image', LUMEA_THEME_URI . '/assets/images/hero1.jpg' );

		wp_localize_script(
			'lumea-hero',
			'lumea_hero',
			array(
				'imageUrl' => esc_url( $lumea_hero_image ),
			)
		);

		wp_enqueue_script(
			'lumea-slider',
			LUMEA_THEME_URI . '/assets/js/slider.js',
			array(),
			LUMEA_VERSION,
			true
		);

		wp_localize_script(
			'lumea-slider',
			'lumea_slider',
			array(
				'slides' => array(
					array(
						'number' => '01',
						'text'   => 'Botanical skincare rituals designed for luminous skin, soft texture, and everyday radiance.',
						'image'  => esc_url( LUMEA_THEME_URI . '/assets/images/1.jpg' ),
					),
					array(
						'number' => '02',
						'text'   => 'Clean formulas, soft botanicals, and refined essentials for a calm beauty routine.',
						'image'  => esc_url( LUMEA_THEME_URI . '/assets/images/2.jpg' ),
					),
					array(
						'number' => '03',
						'text'   => 'A curated edit of everyday glow products made for modern skincare rituals.',
						'image'  => esc_url( LUMEA_THEME_URI . '/assets/images/hero.jpg' ),
					),
					array(
						'number' => '04',
						'text'   => 'Soft hydration, botanical balance, and skin-first essentials for natural radiance.',
						'image'  => esc_url( LUMEA_THEME_URI . '/assets/images/4.jpg' ),
					),
					array(
						'number' => '05',
						'text'   => 'A fresh beauty wardrobe made for skin that feels balanced, bright, and alive.',
						'image'  => esc_url( LUMEA_THEME_URI . '/assets/images/he.jpg' ),
					),
					array(
						'number' => '06',
						'text'   => 'Glow-focused skincare where timeless botanicals meet a modern beauty edge.',
						'image'  => esc_url( LUMEA_THEME_URI . '/assets/images/6.jpg' ),
					),
				),
			)
		);
	}
}
add_action( 'wp_enqueue_scripts', 'lumea_enqueue_assets' );
