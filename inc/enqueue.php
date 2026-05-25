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
		'lumea-main',
		LUMEA_THEME_URI . '/assets/css/main.css',
		array(),
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
