<?php
/**
 * Luméa functions and definitions.
 *
 * @package Lumea
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


define( 'LUMEA_VERSION', '1.2.0' );
define( 'LUMEA_THEME_DIR', get_template_directory() );
define( 'LUMEA_THEME_URI', get_template_directory_uri() );


require LUMEA_THEME_DIR . '/inc/setup.php';
require LUMEA_THEME_DIR . '/inc/helpers.php';
require LUMEA_THEME_DIR . '/inc/enqueue.php';
require LUMEA_THEME_DIR . '/inc/block-styles.php';
require LUMEA_THEME_DIR . '/inc/buttons.php';
require LUMEA_THEME_DIR . '/inc/customizer.php';
require LUMEA_THEME_DIR . '/inc/comments.php';
require LUMEA_THEME_DIR . '/inc/class-tgm-plugin-activation.php';
require LUMEA_THEME_DIR . '/inc/required-plugins.php';
require LUMEA_THEME_DIR . '/inc/demo-import.php';

if ( class_exists( 'WooCommerce' ) ) {
	require LUMEA_THEME_DIR . '/inc/woocommerce.php';
}
