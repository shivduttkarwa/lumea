<?php
/**
 * Gutenberg block styles.
 *
 * @package Lumea
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


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

	register_block_style(
		'core/button',
		array(
			'name'  => 'lumea-dark',
			'label' => esc_html__( 'Lumea Dark', 'lumea' ),
		)
	);

	register_block_style(
		'core/button',
		array(
			'name'  => 'lumea-outline',
			'label' => esc_html__( 'Lumea Outline Alt', 'lumea' ),
		)
	);

	register_block_style(
		'core/button',
		array(
			'name'  => 'lumea-soft',
			'label' => esc_html__( 'Lumea Soft', 'lumea' ),
		)
	);

	register_block_style(
		'core/button',
		array(
			'name'  => 'lumea-accent',
			'label' => esc_html__( 'Lumea Accent', 'lumea' ),
		)
	);

	register_block_style(
		'core/button',
		array(
			'name'  => 'lumea-arrow',
			'label' => esc_html__( 'Lumea Arrow', 'lumea' ),
		)
	);
}
add_action( 'init', 'lumea_register_block_styles' );
