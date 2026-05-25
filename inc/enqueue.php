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

	/* Hero canvas script — front page only */
	if ( is_front_page() ) {
		wp_enqueue_script(
			'lumea-hero',
			LUMEA_THEME_URI . '/assets/js/hero.js',
			array(),
			LUMEA_VERSION,
			true
		);

		wp_localize_script(
			'lumea-hero',
			'lumea_hero',
			array(
				'imageUrl' => LUMEA_THEME_URI . '/assets/images/hero1.jpg',
			)
		);
	}
}
add_action( 'wp_enqueue_scripts', 'lumea_enqueue_assets' );
