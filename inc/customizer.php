<?php
/**
 * Theme Customizer settings.
 *
 * @package Lumea
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register Customizer settings.
 *
 * @param WP_Customize_Manager $wp_customize Customizer instance.
 */
function lumea_customize_register( $wp_customize ) {

	/* ── Hero Section ─────────────────────────────── */
	$wp_customize->add_section(
		'lumea_hero',
		array(
			'title'    => esc_html__( 'Hero Section', 'lumea' ),
			'priority' => 30,
		)
	);

	/* Hero background image */
	$wp_customize->add_setting(
		'lumea_hero_image',
		array(
			'default'           => '',
			'sanitize_callback' => 'esc_url_raw',
			'transport'         => 'refresh',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize,
			'lumea_hero_image',
			array(
				'label'    => esc_html__( 'Hero Background Image', 'lumea' ),
				'section'  => 'lumea_hero',
				'settings' => 'lumea_hero_image',
			)
		)
	);
}
add_action( 'customize_register', 'lumea_customize_register' );
