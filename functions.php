<?php
/**
 * Luméa functions and definitions.
 *
 * @package Lumea
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Theme constants.
 */
define( 'LUMEA_VERSION', '1.0.8' );
define( 'LUMEA_THEME_DIR', get_template_directory() );
define( 'LUMEA_THEME_URI', get_template_directory_uri() );

/**
 * Core theme files.
 */
require LUMEA_THEME_DIR . '/inc/setup.php';
require LUMEA_THEME_DIR . '/inc/enqueue.php';
require LUMEA_THEME_DIR . '/inc/block-styles.php';
require LUMEA_THEME_DIR . '/inc/customizer.php';

if ( class_exists( 'WooCommerce' ) ) {
	require LUMEA_THEME_DIR . '/inc/woocommerce.php';
}
