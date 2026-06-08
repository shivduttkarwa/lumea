<?php
/**
 * Required and recommended plugins for Luméa.
 *
 * Declares WooCommerce as required so buyers see a clear
 * install notice when it is missing after theme activation.
 *
 * @package Lumea
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function lumea_register_required_plugins() {
	$plugins = array(
		array(
			'name'     => 'WooCommerce',
			'slug'     => 'woocommerce',
			'required' => true,
			'version'  => '8.0',
		),
	);

	$config = array(
		'id'          => 'lumea',
		'parent_slug' => 'themes.php',
		'capability'  => 'edit_theme_options',
		'has_notices' => true,
		'dismissable' => false,
		'is_automatic' => false,
		'message'     => '',
	);

	tgmpa( $plugins, $config );
}
add_action( 'tgmpa_register', 'lumea_register_required_plugins' );
