<?php
/**
 * Gutenberg block styles.
 *
 * @package Lumea
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register reusable button styles for the core Button block.
 */
function lumea_register_block_styles() {
	register_block_style(
		'core/button',
		array(
			'name'  => 'lumea-btn-black',
			'label' => esc_html__( 'Lumea Black', 'lumea' ),
		)
	);

	register_block_style(
		'core/button',
		array(
			'name'  => 'lumea-btn-white',
			'label' => esc_html__( 'Lumea White', 'lumea' ),
		)
	);

	register_block_style(
		'core/button',
		array(
			'name'  => 'lumea-btn-outline',
			'label' => esc_html__( 'Lumea Outline', 'lumea' ),
		)
	);
}
add_action( 'init', 'lumea_register_block_styles' );
