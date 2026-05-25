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

	wp_enqueue_style(
		'lumea-fonts',
		'https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500&display=swap',
		array(),
		null
	);

	wp_enqueue_style(
		'lumea-main',
		LUMEA_THEME_URI . '/assets/css/main.css',
		array( 'lumea-fonts' ),
		LUMEA_VERSION
	);

	wp_enqueue_script(
		'lumea-main',
		LUMEA_THEME_URI . '/assets/js/main.js',
		array(),
		LUMEA_VERSION,
		true
	);
}
add_action( 'wp_enqueue_scripts', 'lumea_enqueue_assets' );