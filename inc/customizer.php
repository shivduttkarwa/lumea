<?php
/**
 * Theme Customizer — all front-page content and images.
 *
 * @package Lumea
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function lumea_customize_register( $wp_customize ) {

	
	$wp_customize->add_panel(
		'lumea_theme',
		array(
			'title'    => esc_html__( 'Luméa Theme', 'lumea' ),
			'priority' => 10,
		)
	);

	
	$wp_customize->add_section(
		'lumea_hero',
		array(
			'title' => esc_html__( 'Hero', 'lumea' ),
			'panel' => 'lumea_theme',
		)
	);

	
	$hero_image_defaults = array(
		1 => LUMEA_THEME_URI . '/assets/images/hero-slide-1.jpg',
		2 => '',
		3 => '',
		4 => '',
		5 => '',
	);

	foreach ( $hero_image_defaults as $n => $default ) {
		$key   = ( $n === 1 ) ? 'lumea_hero_image' : 'lumea_hero_image_' . $n;
		$label = ( $n === 1 )
			? esc_html__( 'Slide 1 Image (required)', 'lumea' )
			/* translators: %d: slide number */
			: sprintf( esc_html__( 'Slide %d Image (optional)', 'lumea' ), $n );

		$wp_customize->add_setting( $key, array(
			'default'           => $default,
			'sanitize_callback' => 'esc_url_raw',
			'transport'         => 'refresh',
		) );
		$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, $key, array(
			'label'   => $label,
			'section' => 'lumea_hero',
		) ) );
	}

	
	$wp_customize->add_setting( 'lumea_hero_label', array(
		'default'           => 'Glow',
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'refresh',
	) );
	$wp_customize->add_control( 'lumea_hero_label', array(
		'label'   => esc_html__( 'Label (above title)', 'lumea' ),
		'section' => 'lumea_hero',
		'type'    => 'text',
	) );

	
	$hero_label_defaults = array(
		2 => 'Hydrate',
		3 => 'Nourish',
		4 => 'Protect',
		5 => 'Renew',
	);

	for ( $n = 2; $n <= 5; $n++ ) {
		$key = 'lumea_hero_label_' . $n;

		$wp_customize->add_setting( $key, array(
			'default'           => $hero_label_defaults[ $n ],
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => 'refresh',
		) );
		$wp_customize->add_control( $key, array(
			/* translators: %d: slide number */
			'label'       => sprintf( esc_html__( 'Slide %d Label (above title)', 'lumea' ), $n ),
			'description' => esc_html__( 'Use a short word like Glow, Hydrate, Protect.', 'lumea' ),
			'section'     => 'lumea_hero',
			'type'        => 'text',
		) );
	}

	
	foreach ( array(
		'lumea_hero_subtitle_1' => array( 'Skincare', 'Subtitle 1' ),
		'lumea_hero_subtitle_2' => array( 'Cosmetics', 'Subtitle 2' ),
		'lumea_hero_subtitle_3' => array( 'Beauty', 'Subtitle 3' ),
	) as $key => $info ) {
		$wp_customize->add_setting( $key, array(
			'default'           => $info[0],
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => 'refresh',
		) );
		$wp_customize->add_control( $key, array(
			'label'   => esc_html__( $info[1], 'lumea' ),
			'section' => 'lumea_hero',
			'type'    => 'text',
		) );
	}

	
	$wp_customize->add_setting( 'lumea_hero_cta_text', array(
		'default'           => 'Shop Collection',
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'refresh',
	) );
	$wp_customize->add_control( 'lumea_hero_cta_text', array(
		'label'   => esc_html__( 'CTA Button Text', 'lumea' ),
		'section' => 'lumea_hero',
		'type'    => 'text',
	) );

	
	$wp_customize->add_section(
		'lumea_slider',
		array(
			'title' => esc_html__( 'Editorial Slider', 'lumea' ),
			'panel' => 'lumea_theme',
		)
	);

	
	foreach ( array(
		'lumea_slider_eyebrow' => array( 'Editorial Collection', 'Eyebrow Label' ),
		'lumea_slider_title'   => array( 'The Edit', 'Section Title' ),
	) as $key => $info ) {
		$wp_customize->add_setting( $key, array(
			'default'           => $info[0],
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => 'refresh',
		) );
		$wp_customize->add_control( $key, array(
			'label'   => esc_html__( $info[1], 'lumea' ),
			'section' => 'lumea_slider',
			'type'    => 'text',
		) );
	}

	$wp_customize->add_setting( 'lumea_slider_desc', array(
		'default'           => 'Curated botanicals and skin-first formulas for luminous, everyday beauty.',
		'sanitize_callback' => 'sanitize_textarea_field',
		'transport'         => 'refresh',
	) );
	$wp_customize->add_control( 'lumea_slider_desc', array(
		'label'   => esc_html__( 'Section Description', 'lumea' ),
		'section' => 'lumea_slider',
		'type'    => 'textarea',
	) );

	
	$wp_customize->add_setting( 'lumea_slider_cta_text', array(
		'default'           => 'Shop All',
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'refresh',
	) );
	$wp_customize->add_control( 'lumea_slider_cta_text', array(
		'label'   => esc_html__( '"Shop All" Button Text', 'lumea' ),
		'section' => 'lumea_slider',
		'type'    => 'text',
	) );

	
	$slide_defaults = array(
		1 => array(
			'text'  => 'Botanical skincare rituals designed for luminous skin, soft texture, and everyday radiance.',
			'image' => LUMEA_THEME_URI . '/assets/images/editorial-slide-1.jpg',
		),
		2 => array(
			'text'  => 'Clean formulas, soft botanicals, and refined essentials for a calm beauty routine.',
			'image' => LUMEA_THEME_URI . '/assets/images/editorial-slide-2.jpg',
		),
		3 => array(
			'text'  => 'A curated edit of everyday glow products made for modern skincare rituals.',
			'image' => LUMEA_THEME_URI . '/assets/images/editorial-slide-3.jpg',
		),
		4 => array(
			'text'  => 'Soft hydration, botanical balance, and skin-first essentials for natural radiance.',
			'image' => LUMEA_THEME_URI . '/assets/images/editorial-slide-4.jpg',
		),
		5 => array(
			'text'  => 'A fresh beauty wardrobe made for skin that feels balanced, bright, and alive.',
			'image' => LUMEA_THEME_URI . '/assets/images/editorial-slide-5.jpg',
		),
		6 => array(
			'text'  => 'Glow-focused skincare where timeless botanicals meet a modern beauty edge.',
			'image' => LUMEA_THEME_URI . '/assets/images/editorial-slide-6.jpg',
		),
	);

	foreach ( $slide_defaults as $n => $defaults ) {
		$img_key  = 'lumea_slide_' . $n . '_image';
		$text_key = 'lumea_slide_' . $n . '_text';
		$url_key  = 'lumea_slide_' . $n . '_url';

		$wp_customize->add_setting( $img_key, array(
			'default'           => $defaults['image'],
			'sanitize_callback' => 'esc_url_raw',
			'transport'         => 'refresh',
		) );
		$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, $img_key, array(
			/* translators: %d: slide number */
			'label'   => sprintf( esc_html__( 'Slide %d Image', 'lumea' ), $n ),
			'section' => 'lumea_slider',
		) ) );

		$wp_customize->add_setting( $text_key, array(
			'default'           => $defaults['text'],
			'sanitize_callback' => 'sanitize_textarea_field',
			'transport'         => 'refresh',
		) );
		$wp_customize->add_control( $text_key, array(
			/* translators: %d: slide number */
			'label'   => sprintf( esc_html__( 'Slide %d Caption', 'lumea' ), $n ),
			'section' => 'lumea_slider',
			'type'    => 'textarea',
		) );

		$wp_customize->add_setting( $url_key, array(
			'default'           => '',
			'sanitize_callback' => 'esc_url_raw',
			'transport'         => 'refresh',
		) );
		$wp_customize->add_control( $url_key, array(
			/* translators: %d: slide number */
			'label'   => sprintf( esc_html__( 'Slide %d Product URL (blank = shop)', 'lumea' ), $n ),
			'section' => 'lumea_slider',
			'type'    => 'url',
		) );
	}

	
	$wp_customize->add_section(
		'lumea_curated',
		array(
			'title' => esc_html__( 'Curated Glow', 'lumea' ),
			'panel' => 'lumea_theme',
		)
	);

	
	$wp_customize->add_setting( 'lumea_curated_eyebrow', array(
		'default'           => 'Bestsellers',
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'refresh',
	) );
	$wp_customize->add_control( 'lumea_curated_eyebrow', array(
		'label'   => esc_html__( 'Eyebrow Label', 'lumea' ),
		'section' => 'lumea_curated',
		'type'    => 'text',
	) );

	$wp_customize->add_setting( 'lumea_curated_title', array(
		'default'           => 'Curated Glow',
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'refresh',
	) );
	$wp_customize->add_control( 'lumea_curated_title', array(
		'label'   => esc_html__( 'Section Title', 'lumea' ),
		'section' => 'lumea_curated',
		'type'    => 'text',
	) );

	$wp_customize->add_setting( 'lumea_curated_desc', array(
		'default'           => 'Handpicked essentials for a luminous, skin-first daily ritual.',
		'sanitize_callback' => 'sanitize_textarea_field',
		'transport'         => 'refresh',
	) );
	$wp_customize->add_control( 'lumea_curated_desc', array(
		'label'   => esc_html__( 'Section Description', 'lumea' ),
		'section' => 'lumea_curated',
		'type'    => 'textarea',
	) );

	
	$product_defaults = array(
		1 => array(
			'image' => LUMEA_THEME_URI . '/assets/images/hero-slide-1.jpg',
			'name'  => 'Radiance Serum',
			'price' => '$48.00',
			'desc'  => 'A lightweight botanical serum for dewy, luminous, everyday skin.',
			'url'   => '',
		),
		2 => array(
			'image' => LUMEA_THEME_URI . '/assets/images/model-portrait.jpg',
			'name'  => 'Velvet Cream',
			'price' => '$42.00',
			'desc'  => 'Rich daily moisture with a soft-touch finish and botanical comfort.',
			'url'   => '',
		),
	);

	foreach ( $product_defaults as $n => $defaults ) {
		$prefix = 'lumea_product' . $n;

		$wp_customize->add_setting( $prefix . '_image', array(
			'default'           => $defaults['image'],
			'sanitize_callback' => 'esc_url_raw',
			'transport'         => 'refresh',
		) );
		$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, $prefix . '_image', array(
			/* translators: %d: product number */
			'label'   => sprintf( esc_html__( 'Product %d Image', 'lumea' ), $n ),
			'section' => 'lumea_curated',
		) ) );

		$wp_customize->add_setting( $prefix . '_name', array(
			'default'           => $defaults['name'],
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => 'refresh',
		) );
		$wp_customize->add_control( $prefix . '_name', array(
			/* translators: %d: product number */
			'label'   => sprintf( esc_html__( 'Product %d Name', 'lumea' ), $n ),
			'section' => 'lumea_curated',
			'type'    => 'text',
		) );

		$wp_customize->add_setting( $prefix . '_price', array(
			'default'           => $defaults['price'],
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => 'refresh',
		) );
		$wp_customize->add_control( $prefix . '_price', array(
			/* translators: %d: product number */
			'label'   => sprintf( esc_html__( 'Product %d Price', 'lumea' ), $n ),
			'section' => 'lumea_curated',
			'type'    => 'text',
		) );

		$wp_customize->add_setting( $prefix . '_desc', array(
			'default'           => $defaults['desc'],
			'sanitize_callback' => 'sanitize_textarea_field',
			'transport'         => 'refresh',
		) );
		$wp_customize->add_control( $prefix . '_desc', array(
			/* translators: %d: product number */
			'label'   => sprintf( esc_html__( 'Product %d Description', 'lumea' ), $n ),
			'section' => 'lumea_curated',
			'type'    => 'textarea',
		) );

		$wp_customize->add_setting( $prefix . '_url', array(
			'default'           => $defaults['url'],
			'sanitize_callback' => 'esc_url_raw',
			'transport'         => 'refresh',
		) );
		$wp_customize->add_control( $prefix . '_url', array(
			/* translators: %d: product number */
			'label'       => sprintf( esc_html__( 'Product %d Link URL (leave blank for shop)', 'lumea' ), $n ),
			'section'     => 'lumea_curated',
			'type'        => 'url',
		) );
	}

	
	$wp_customize->add_section(
		'lumea_bestsellers',
		array(
			'title' => esc_html__( 'Shop Bestsellers', 'lumea' ),
			'panel' => 'lumea_theme',
		)
	);

	
	foreach ( array(
		'lumea_best_eyebrow' => array( 'Customer Favourites', 'Eyebrow Label' ),
		'lumea_best_title'   => array( 'Shop Bestsellers',    'Section Title' ),
	) as $key => $info ) {
		$wp_customize->add_setting( $key, array(
			'default'           => $info[0],
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => 'refresh',
		) );
		$wp_customize->add_control( $key, array(
			'label'   => esc_html__( $info[1], 'lumea' ),
			'section' => 'lumea_bestsellers',
			'type'    => 'text',
		) );
	}

	$wp_customize->add_setting( 'lumea_best_desc', array(
		'default'           => 'Our most-loved formulas, trusted by thousands worldwide.',
		'sanitize_callback' => 'sanitize_textarea_field',
		'transport'         => 'refresh',
	) );
	$wp_customize->add_control( 'lumea_best_desc', array(
		'label'   => esc_html__( 'Section Description', 'lumea' ),
		'section' => 'lumea_bestsellers',
		'type'    => 'textarea',
	) );

	
	$best_defaults = array(
		1 => array( 'Radiance Serum',          '$48.00', 'No. 1' ),
		2 => array( 'Velvet Face Cream',        '$42.00', 'No. 2' ),
		3 => array( 'Botanical Cleansing Oil',  '$38.00', 'No. 3' ),
		4 => array( 'Luminous Glow Toner',      '$34.00', 'No. 4' ),
		5 => array( 'Skin Glow Face Oil',       '$52.00', 'No. 5' ),
	);

	foreach ( $best_defaults as $n => $d ) {
		$p = 'lumea_best' . $n;

		$wp_customize->add_setting( $p . '_name', array(
			'default'           => $d[0],
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => 'refresh',
		) );
		$wp_customize->add_control( $p . '_name', array(
			/* translators: %d: product number */
			'label'   => sprintf( esc_html__( 'Product %d Name', 'lumea' ), $n ),
			'section' => 'lumea_bestsellers',
			'type'    => 'text',
		) );

		$wp_customize->add_setting( $p . '_price', array(
			'default'           => $d[1],
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => 'refresh',
		) );
		$wp_customize->add_control( $p . '_price', array(
			/* translators: %d: product number */
			'label'   => sprintf( esc_html__( 'Product %d Price', 'lumea' ), $n ),
			'section' => 'lumea_bestsellers',
			'type'    => 'text',
		) );

		$wp_customize->add_setting( $p . '_badge', array(
			'default'           => $d[2],
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => 'refresh',
		) );
		$wp_customize->add_control( $p . '_badge', array(
			/* translators: %d: product number */
			'label'       => sprintf( esc_html__( 'Product %d Badge (leave blank to hide)', 'lumea' ), $n ),
			'section'     => 'lumea_bestsellers',
			'type'        => 'text',
		) );

		$wp_customize->add_setting( $p . '_main_image', array(
			'default'           => '',
			'sanitize_callback' => 'esc_url_raw',
			'transport'         => 'refresh',
		) );
		$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, $p . '_main_image', array(
			/* translators: %d: product number */
			'label'   => sprintf( esc_html__( 'Product %d — Main Image', 'lumea' ), $n ),
			'section' => 'lumea_bestsellers',
		) ) );

		$wp_customize->add_setting( $p . '_hover_image', array(
			'default'           => '',
			'sanitize_callback' => 'esc_url_raw',
			'transport'         => 'refresh',
		) );
		$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, $p . '_hover_image', array(
			/* translators: %d: product number */
			'label'   => sprintf( esc_html__( 'Product %d — Hover Image', 'lumea' ), $n ),
			'section' => 'lumea_bestsellers',
		) ) );

		$wp_customize->add_setting( $p . '_url', array(
			'default'           => '',
			'sanitize_callback' => 'esc_url_raw',
			'transport'         => 'refresh',
		) );
		$wp_customize->add_control( $p . '_url', array(
			/* translators: %d: product number */
			'label'   => sprintf( esc_html__( 'Product %d Link URL (blank = shop)', 'lumea' ), $n ),
			'section' => 'lumea_bestsellers',
			'type'    => 'url',
		) );
	}

	$wp_customize->add_section(
		'lumea_latest',
		array(
			'title' => esc_html__( 'Latest Products', 'lumea' ),
			'panel' => 'lumea_theme',
		)
	);

	foreach ( array(
		'lumea_latest_eyebrow' => array( 'Just Arrived',    'Eyebrow Label' ),
		'lumea_latest_title'   => array( 'Latest Products', 'Section Title' ),
	) as $key => $info ) {
		$wp_customize->add_setting( $key, array(
			'default'           => $info[0],
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => 'refresh',
		) );
		$wp_customize->add_control( $key, array(
			'label'   => esc_html__( $info[1], 'lumea' ),
			'section' => 'lumea_latest',
			'type'    => 'text',
		) );
	}

	$wp_customize->add_setting( 'lumea_latest_desc', array(
		'default'           => 'Freshly launched formulas and seasonal essentials selected for your next skin ritual.',
		'sanitize_callback' => 'sanitize_textarea_field',
		'transport'         => 'refresh',
	) );
	$wp_customize->add_control( 'lumea_latest_desc', array(
		'label'   => esc_html__( 'Section Description', 'lumea' ),
		'section' => 'lumea_latest',
		'type'    => 'textarea',
	) );

	
	$wp_customize->add_section(
		'lumea_ritual',
		array(
			'title' => esc_html__( 'The Ritual', 'lumea' ),
			'panel' => 'lumea_theme',
		)
	);

	
	$wp_customize->add_setting( 'lumea_ritual_heading_1', array(
		'default'           => 'your daily',
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'refresh',
	) );
	$wp_customize->add_control( 'lumea_ritual_heading_1', array(
		'label'   => esc_html__( 'Heading Line 1', 'lumea' ),
		'section' => 'lumea_ritual',
		'type'    => 'text',
	) );

	$wp_customize->add_setting( 'lumea_ritual_heading_2', array(
		'default'           => 'skin ritual',
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'refresh',
	) );
	$wp_customize->add_control( 'lumea_ritual_heading_2', array(
		'label'   => esc_html__( 'Heading Line 2 (faded)', 'lumea' ),
		'section' => 'lumea_ritual',
		'type'    => 'text',
	) );

	
	$wp_customize->add_setting( 'lumea_ritual_intro', array(
		'default'           => 'Four intentional steps, one luminous result. A complete routine designed around the skin you have.',
		'sanitize_callback' => 'sanitize_textarea_field',
		'transport'         => 'refresh',
	) );
	$wp_customize->add_control( 'lumea_ritual_intro', array(
		'label'   => esc_html__( 'Intro Paragraph', 'lumea' ),
		'section' => 'lumea_ritual',
		'type'    => 'textarea',
	) );

	
	$ritual_step_defaults = array(
		1 => array(
			'title'  => 'Cleanse',
			'text'   => 'Begin with pure intention. Our gentle botanical cleansers dissolve impurities without stripping the skin\'s natural balance, leaving a fresh, receptive canvas.',
			'image1' => LUMEA_THEME_URI . '/assets/images/ritual/ritual-cleanse-1.jpg',
			'image2' => LUMEA_THEME_URI . '/assets/images/ritual/ritual-cleanse-2.jpg',
		),
		2 => array(
			'title'  => 'Tone & Prep',
			'text'   => 'Restore skin\'s equilibrium. Botanical tonics and essence waters refine pores, balance pH, and prime skin to absorb every active that follows.',
			'image1' => LUMEA_THEME_URI . '/assets/images/editorial-slide-3.jpg',
			'image2' => LUMEA_THEME_URI . '/assets/images/editorial-slide-4.jpg',
		),
		3 => array(
			'title'  => 'Treat & Correct',
			'text'   => 'Targeted actives where they matter most. Concentrated serums address luminosity, firmness, and even tone at the cellular level.',
			'image1' => LUMEA_THEME_URI . '/assets/images/editorial-slide-6.jpg',
			'image2' => LUMEA_THEME_URI . '/assets/images/model-portrait.jpg',
		),
		4 => array(
			'title'  => 'Restore & Protect',
			'text'   => 'Seal the ritual with nourishment. Rich creams and facial oils lock in actives, rebuild the moisture barrier, and leave skin visibly calm, plump, and glowing.',
			'image1' => LUMEA_THEME_URI . '/assets/images/editorial-slide-5.jpg',
			'image2' => LUMEA_THEME_URI . '/assets/images/hero-slide-1.jpg',
		),
	);

	foreach ( $ritual_step_defaults as $n => $defaults ) {
		$prefix = 'lumea_ritual_step' . $n;

		$wp_customize->add_setting( $prefix . '_title', array(
			'default'           => $defaults['title'],
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => 'refresh',
		) );
		$wp_customize->add_control( $prefix . '_title', array(
			/* translators: %d: step number */
			'label'   => sprintf( esc_html__( 'Step %d Title', 'lumea' ), $n ),
			'section' => 'lumea_ritual',
			'type'    => 'text',
		) );

		$wp_customize->add_setting( $prefix . '_text', array(
			'default'           => $defaults['text'],
			'sanitize_callback' => 'sanitize_textarea_field',
			'transport'         => 'refresh',
		) );
		$wp_customize->add_control( $prefix . '_text', array(
			/* translators: %d: step number */
			'label'   => sprintf( esc_html__( 'Step %d Description', 'lumea' ), $n ),
			'section' => 'lumea_ritual',
			'type'    => 'textarea',
		) );

		$wp_customize->add_setting( $prefix . '_image1', array(
			'default'           => $defaults['image1'],
			'sanitize_callback' => 'esc_url_raw',
			'transport'         => 'refresh',
		) );
		$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, $prefix . '_image1', array(
			/* translators: %d: step number */
			'label'   => sprintf( esc_html__( 'Step %d — Image 1', 'lumea' ), $n ),
			'section' => 'lumea_ritual',
		) ) );

		$wp_customize->add_setting( $prefix . '_image2', array(
			'default'           => $defaults['image2'],
			'sanitize_callback' => 'esc_url_raw',
			'transport'         => 'refresh',
		) );
		$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, $prefix . '_image2', array(
			/* translators: %d: step number */
			'label'   => sprintf( esc_html__( 'Step %d — Image 2', 'lumea' ), $n ),
			'section' => 'lumea_ritual',
		) ) );
	}

	
	$wp_customize->add_section(
		'lumea_manifest',
		array(
			'title' => esc_html__( 'Manifest Section', 'lumea' ),
			'panel' => 'lumea_theme',
		)
	);

	
	$wp_customize->add_setting( 'lumea_manifest_image', array(
		'default'           => LUMEA_THEME_URI . '/assets/images/editorial-slide-5.jpg',
		'sanitize_callback' => 'esc_url_raw',
		'transport'         => 'refresh',
	) );
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'lumea_manifest_image', array(
		'label'   => esc_html__( 'Background Image', 'lumea' ),
		'section' => 'lumea_manifest',
	) ) );

	
	$kicker_defaults = array(
		1 => '.make your skin comfortable',
		2 => 'trust your glow and feel calm',
		3 => 'in every skincare ritual+',
	);
	foreach ( $kicker_defaults as $n => $default ) {
		$wp_customize->add_setting( 'lumea_manifest_kicker_' . $n, array(
			'default'           => $default,
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => 'refresh',
		) );
		$wp_customize->add_control( 'lumea_manifest_kicker_' . $n, array(
			/* translators: %d: line number */
			'label'   => sprintf( esc_html__( 'Kicker Line %d', 'lumea' ), $n ),
			'section' => 'lumea_manifest',
			'type'    => 'text',
		) );
	}

	
	$title_defaults = array(
		1 => 'modern ritual',
		2 => 'for timeless',
		3 => 'radiance',
	);
	foreach ( $title_defaults as $n => $default ) {
		$wp_customize->add_setting( 'lumea_manifest_title_' . $n, array(
			'default'           => $default,
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => 'refresh',
		) );
		$wp_customize->add_control( 'lumea_manifest_title_' . $n, array(
			/* translators: %d: line number */
			'label'   => sprintf( esc_html__( 'Heading Line %d', 'lumea' ), $n ),
			'section' => 'lumea_manifest',
			'type'    => 'text',
		) );
	}
	
	$wp_customize->add_section(
		'lumea_footer',
		array(
			'title' => esc_html__( 'Footer', 'lumea' ),
			'panel' => 'lumea_theme',
		)
	);

	
	$wp_customize->add_setting( 'lumea_footer_headline', array(
		'default'           => "Discover your skin\xe2\x80\x99s new ritual. Start today.",
		'sanitize_callback' => 'wp_kses_post',
		'transport'         => 'refresh',
	) );
	$wp_customize->add_control( 'lumea_footer_headline', array(
		'label'   => esc_html__( 'CTA Headline', 'lumea' ),
		'section' => 'lumea_footer',
		'type'    => 'textarea',
	) );

	
	$wp_customize->add_setting( 'lumea_footer_cta_text', array(
		'default'           => 'Shop Collection',
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'refresh',
	) );
	$wp_customize->add_control( 'lumea_footer_cta_text', array(
		'label'   => esc_html__( 'CTA Button Label', 'lumea' ),
		'section' => 'lumea_footer',
		'type'    => 'text',
	) );

	
	$wp_customize->add_setting( 'lumea_footer_connect_heading', array(
		'default'           => 'Connect',
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'refresh',
	) );
	$wp_customize->add_control( 'lumea_footer_connect_heading', array(
		'label'   => esc_html__( 'Connect Column Heading', 'lumea' ),
		'section' => 'lumea_footer',
		'type'    => 'text',
	) );

	
	$wp_customize->add_setting( 'lumea_footer_address', array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_textarea_field',
		'transport'         => 'refresh',
	) );
	$wp_customize->add_control( 'lumea_footer_address', array(
		'label'       => esc_html__( 'Address (one line per row)', 'lumea' ),
		'section'     => 'lumea_footer',
		'type'        => 'textarea',
	) );

	
	$wp_customize->add_setting( 'lumea_footer_email', array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_email',
		'transport'         => 'refresh',
	) );
	$wp_customize->add_control( 'lumea_footer_email', array(
		'label'   => esc_html__( 'Contact Email', 'lumea' ),
		'section' => 'lumea_footer',
		'type'    => 'email',
	) );

	
	$wp_customize->add_setting( 'lumea_support_email', array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_email',
		'transport'         => 'refresh',
	) );
	$wp_customize->add_control( 'lumea_support_email', array(
		'label'       => esc_html__( 'Support Email (Contact & FAQ pages)', 'lumea' ),
		'description' => esc_html__( 'Displayed as a clickable mailto link on the Contact page and in FAQ answers.', 'lumea' ),
		'section'     => 'lumea_footer',
		'type'        => 'email',
	) );

	
	$wp_customize->add_setting( 'lumea_footer_video', array(
		'default'           => LUMEA_THEME_URI . '/assets/images/hero/footer-video.mp4',
		'sanitize_callback' => 'esc_url_raw',
		'transport'         => 'refresh',
	) );
	$wp_customize->add_control( 'lumea_footer_video', array(
		'label'       => esc_html__( 'Brand Video URL (.mp4) — shows through "LUMÉA" letters', 'lumea' ),
		'description' => esc_html__( 'Upload an MP4 to Media Library, paste its URL here. Leave blank to use the fallback image instead.', 'lumea' ),
		'section'     => 'lumea_footer',
		'type'        => 'url',
	) );

	
	$wp_customize->add_setting( 'lumea_footer_video_poster', array(
		'default'           => LUMEA_THEME_URI . '/assets/images/hero/latest-hero.jpg',
		'sanitize_callback' => 'esc_url_raw',
		'transport'         => 'refresh',
	) );
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'lumea_footer_video_poster', array(
		'label'   => esc_html__( 'Brand Fallback Image (shows if no video)', 'lumea' ),
		'section' => 'lumea_footer',
	) ) );

	
	$wp_customize->add_setting( 'lumea_footer_copy', array(
		'default'           => 'Lumea Botanical Skincare',
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'refresh',
	) );
	$wp_customize->add_control( 'lumea_footer_copy', array(
		'label'   => esc_html__( 'Copyright Text (after the year)', 'lumea' ),
		'section' => 'lumea_footer',
		'type'    => 'text',
	) );

	
	$footer_link_defaults = array(
		1 => array( 'Shop',    '#' ),
		2 => array( 'Journal', '#' ),
		3 => array( 'About',   '#' ),
		4 => array( 'Contact', '#' ),
	);
	foreach ( $footer_link_defaults as $n => $defaults ) {
		$wp_customize->add_setting( 'lumea_footer_link' . $n . '_label', array(
			'default'           => $defaults[0],
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => 'refresh',
		) );
		$wp_customize->add_control( 'lumea_footer_link' . $n . '_label', array(
			/* translators: %d: link number */
			'label'   => sprintf( esc_html__( 'Nav Link %d Label', 'lumea' ), $n ),
			'section' => 'lumea_footer',
			'type'    => 'text',
		) );
		$wp_customize->add_setting( 'lumea_footer_link' . $n . '_url', array(
			'default'           => $defaults[1],
			'sanitize_callback' => 'esc_url_raw',
			'transport'         => 'refresh',
		) );
		$wp_customize->add_control( 'lumea_footer_link' . $n . '_url', array(
			/* translators: %d: link number */
			'label'   => sprintf( esc_html__( 'Nav Link %d URL', 'lumea' ), $n ),
			'section' => 'lumea_footer',
			'type'    => 'url',
		) );
	}

	
	foreach ( array(
		'lumea_footer_instagram'  => 'Instagram URL',
		'lumea_footer_tiktok'     => 'TikTok URL',
		'lumea_footer_pinterest'  => 'Pinterest URL',
	) as $key => $label ) {
		$wp_customize->add_setting( $key, array(
			'default'           => '',
			'sanitize_callback' => 'esc_url_raw',
			'transport'         => 'refresh',
		) );
		$wp_customize->add_control( $key, array(
			'label'   => esc_html__( $label, 'lumea' ),
			'section' => 'lumea_footer',
			'type'    => 'url',
		) );
	}
	
	/* ── Per-page hero sections (all inside lumea_theme panel) ── */

	// --- Shop Page ---
	$wp_customize->add_section( 'lumea_hero_shop', array(
		'title'    => esc_html__( 'Shop Page Hero', 'lumea' ),
		'panel'    => 'lumea_theme',
		'priority' => 60,
	) );
	$wp_customize->add_setting( 'lumea_shop_hero_bg', array(
		'default'           => LUMEA_THEME_URI . '/assets/images/bestsellers/cta-bg.jpg',
		'sanitize_callback' => 'esc_url_raw',
		'transport'         => 'refresh',
	) );
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'lumea_shop_hero_bg', array(
		'label'   => esc_html__( 'Hero Image', 'lumea' ),
		'section' => 'lumea_hero_shop',
	) ) );

	// --- Bestseller Category ---
	$wp_customize->add_section( 'lumea_hero_bestseller', array(
		'title'    => esc_html__( 'Bestseller Category Hero', 'lumea' ),
		'panel'    => 'lumea_theme',
		'priority' => 61,
	) );
	$wp_customize->add_setting( 'lumea_cat_bestseller_hero_bg', array(
		'default'           => LUMEA_THEME_URI . '/assets/images/bestsellers/bestsellers-hover3.jpg',
		'sanitize_callback' => 'esc_url_raw',
		'transport'         => 'refresh',
	) );
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'lumea_cat_bestseller_hero_bg', array(
		'label'   => esc_html__( 'Hero Image', 'lumea' ),
		'section' => 'lumea_hero_bestseller',
	) ) );

	// --- Latest Category ---
	$wp_customize->add_section( 'lumea_hero_latest', array(
		'title'    => esc_html__( 'Latest Category Hero', 'lumea' ),
		'panel'    => 'lumea_theme',
		'priority' => 62,
	) );
	$wp_customize->add_setting( 'lumea_cat_latest_hero_bg', array(
		'default'           => LUMEA_THEME_URI . '/assets/images/bestsellers/bestsellers-hover5.jpg',
		'sanitize_callback' => 'esc_url_raw',
		'transport'         => 'refresh',
	) );
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'lumea_cat_latest_hero_bg', array(
		'label'   => esc_html__( 'Hero Image', 'lumea' ),
		'section' => 'lumea_hero_latest',
	) ) );

	// --- Wishlist Page ---
	$wp_customize->add_section( 'lumea_hero_wishlist', array(
		'title'    => esc_html__( 'Wishlist Page Hero', 'lumea' ),
		'panel'    => 'lumea_theme',
		'priority' => 63,
	) );
	$wp_customize->add_setting( 'lumea_wishlist_hero_bg', array(
		'default'           => LUMEA_THEME_URI . '/assets/images/ritual/wishlist-hero.png',
		'sanitize_callback' => 'esc_url_raw',
		'transport'         => 'refresh',
	) );
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'lumea_wishlist_hero_bg', array(
		'label'   => esc_html__( 'Hero Image', 'lumea' ),
		'section' => 'lumea_hero_wishlist',
	) ) );
	$wp_customize->add_setting( 'lumea_wishlist_hero_eyebrow', array(
		'default'           => 'Saved Favourites',
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'refresh',
	) );
	$wp_customize->add_control( 'lumea_wishlist_hero_eyebrow', array(
		'label'   => esc_html__( 'Eyebrow Text', 'lumea' ),
		'section' => 'lumea_hero_wishlist',
		'type'    => 'text',
	) );
	$wp_customize->add_setting( 'lumea_wishlist_hero_title', array(
		'default'           => 'Your Wishlist',
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'refresh',
	) );
	$wp_customize->add_control( 'lumea_wishlist_hero_title', array(
		'label'   => esc_html__( 'Title', 'lumea' ),
		'section' => 'lumea_hero_wishlist',
		'type'    => 'text',
	) );
	$wp_customize->add_setting( 'lumea_wishlist_hero_desc', array(
		'default'           => 'Products you saved for your next ritual.',
		'sanitize_callback' => 'sanitize_textarea_field',
		'transport'         => 'refresh',
	) );
	$wp_customize->add_control( 'lumea_wishlist_hero_desc', array(
		'label'   => esc_html__( 'Description', 'lumea' ),
		'section' => 'lumea_hero_wishlist',
		'type'    => 'textarea',
	) );

	// --- Contact Page ---
	$wp_customize->add_section( 'lumea_hero_contact', array(
		'title'    => esc_html__( 'Contact Page Hero', 'lumea' ),
		'panel'    => 'lumea_theme',
		'priority' => 64,
	) );
	$wp_customize->add_setting( 'lumea_contact_hero_bg', array(
		'default'           => LUMEA_THEME_URI . '/assets/images/bestsellers/cta-bg.jpg',
		'sanitize_callback' => 'esc_url_raw',
		'transport'         => 'refresh',
	) );
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'lumea_contact_hero_bg', array(
		'label'   => esc_html__( 'Hero Image', 'lumea' ),
		'section' => 'lumea_hero_contact',
	) ) );
	$wp_customize->add_setting( 'lumea_contact_hero_eyebrow', array(
		'default'           => "We'd Love to Hear From You",
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'refresh',
	) );
	$wp_customize->add_control( 'lumea_contact_hero_eyebrow', array(
		'label'   => esc_html__( 'Eyebrow Text', 'lumea' ),
		'section' => 'lumea_hero_contact',
		'type'    => 'text',
	) );
	$wp_customize->add_setting( 'lumea_contact_hero_title', array(
		'default'           => 'Get in Touch',
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'refresh',
	) );
	$wp_customize->add_control( 'lumea_contact_hero_title', array(
		'label'   => esc_html__( 'Title', 'lumea' ),
		'section' => 'lumea_hero_contact',
		'type'    => 'text',
	) );

	// --- Journal (Blog) Page ---
	$wp_customize->add_section( 'lumea_hero_journal', array(
		'title'    => esc_html__( 'Journal Page Hero', 'lumea' ),
		'panel'    => 'lumea_theme',
		'priority' => 65,
	) );
	$wp_customize->add_setting( 'lumea_blog_hero_bg', array(
		'default'           => LUMEA_THEME_URI . '/assets/images/bestsellers/cta-bg.jpg',
		'sanitize_callback' => 'esc_url_raw',
		'transport'         => 'refresh',
	) );
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'lumea_blog_hero_bg', array(
		'label'   => esc_html__( 'Hero Image', 'lumea' ),
		'section' => 'lumea_hero_journal',
	) ) );
	$wp_customize->add_setting( 'lumea_blog_hero_title', array(
		'default'           => 'The Journal',
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'refresh',
	) );
	$wp_customize->add_control( 'lumea_blog_hero_title', array(
		'label'   => esc_html__( 'Title', 'lumea' ),
		'section' => 'lumea_hero_journal',
		'type'    => 'text',
	) );
	$wp_customize->add_setting( 'lumea_blog_hero_subtitle', array(
		'default'           => 'Rituals, ingredients, and the science of radiant skin.',
		'sanitize_callback' => 'sanitize_textarea_field',
		'transport'         => 'refresh',
	) );
	$wp_customize->add_control( 'lumea_blog_hero_subtitle', array(
		'label'   => esc_html__( 'Subtitle', 'lumea' ),
		'section' => 'lumea_hero_journal',
		'type'    => 'textarea',
	) );

	// --- Journal Post (single blog post) ---
	$wp_customize->add_section( 'lumea_hero_journal_post', array(
		'title'    => esc_html__( 'Journal Post Hero', 'lumea' ),
		'panel'    => 'lumea_theme',
		'priority' => 66,
	) );
	$wp_customize->add_setting( 'lumea_blog_single_hero_bg', array(
		'default'           => LUMEA_THEME_URI . '/assets/images/bestsellers/cta-bg.jpg',
		'sanitize_callback' => 'esc_url_raw',
		'transport'         => 'refresh',
	) );
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'lumea_blog_single_hero_bg', array(
		'label'       => esc_html__( 'Hero Image', 'lumea' ),
		'description' => esc_html__( 'Used on individual blog post pages.', 'lumea' ),
		'section'     => 'lumea_hero_journal_post',
	) ) );
	$wp_customize->add_setting( 'lumea_blog_single_hero_subtitle', array(
		'default'           => 'Rituals, ingredients, and the science of radiant skin.',
		'sanitize_callback' => 'sanitize_textarea_field',
		'transport'         => 'refresh',
	) );
	$wp_customize->add_control( 'lumea_blog_single_hero_subtitle', array(
		'label'   => esc_html__( 'Subtitle', 'lumea' ),
		'section' => 'lumea_hero_journal_post',
		'type'    => 'textarea',
	) );
	
	$wp_customize->add_section( 'lumea_about', array(
		'title'    => esc_html__( 'About Page', 'lumea' ),
		'panel'    => 'lumea_theme',
		'priority' => 70,
	) );

	
	$about_controls = array(

		
		'lumea_about_hero_bg'       => array( 'image',    'Hero — Background Image',       LUMEA_THEME_URI . '/assets/images/editorial-slide-3.jpg' ),
		'lumea_about_hero_label'    => array( 'text',     'Hero — Eyebrow Label',           'Est. 2018 &middot; Paris' ),
		'lumea_about_hero_h1_1'     => array( 'text',     'Hero — Heading Line 1',          'Skincare' ),
		'lumea_about_hero_h1_2'     => array( 'text',     'Hero — Heading Line 2 (outline)', 'as ritual.' ),
		'lumea_about_hero_sub'      => array( 'textarea', 'Hero — Subtitle',                'Every Luméa formula begins with a single question — what does your skin truly need?' ),
		'lumea_about_hero_cta'      => array( 'text',     'Hero — CTA Button Text',         'Discover the Collection' ),
		'lumea_about_stat1_n'       => array( 'text',     'Stat 1 — Number',                '48+' ),
		'lumea_about_stat1_l'       => array( 'text',     'Stat 1 — Label',                 'Botanical actives' ),
		'lumea_about_stat2_n'       => array( 'text',     'Stat 2 — Number',                '12' ),
		'lumea_about_stat2_l'       => array( 'text',     'Stat 2 — Label',                 'Countries sourced' ),
		'lumea_about_stat3_n'       => array( 'text',     'Stat 3 — Number',                '100%' ),
		'lumea_about_stat3_l'       => array( 'text',     'Stat 3 — Label',                 'Clean formulas' ),
		'lumea_about_stat4_n'       => array( 'text',     'Stat 4 — Number',                '2018' ),
		'lumea_about_stat4_l'       => array( 'text',     'Stat 4 — Label',                 'Founded in Paris' ),

		
		'lumea_about_ticker'        => array( 'textarea', 'Ticker — Items (one per line)',   "BOTANICAL PURITY\nSCIENTIFIC PRECISION\nMINDFUL LUXURY\nCLEAN BEAUTY\nCRUELTY FREE\nSINCE 2018" ),

		
		'lumea_about_manifesto_q'   => array( 'textarea', 'Manifesto — Quote',              'The most transformative skincare is the kind you actually look forward to. Not a routine — a ritual.' ),
		'lumea_about_manifesto_cite'=> array( 'text',     'Manifesto — Attribution',        'Sophie Laurent, Founder & Cosmetic Chemist' ),

		
		'lumea_about_story_image' => array( 'image',    'Story — Image',                  LUMEA_THEME_URI . '/assets/images/model-portrait.jpg' ),
		'lumea_about_story1_label'  => array( 'text',     'Story Panel 1 — Eyebrow',        'The Beginning' ),
		'lumea_about_story1_h2'     => array( 'text',     'Story Panel 1 — Heading',        'A skincare line rooted in botanical science' ),
		'lumea_about_story1_body'   => array( 'textarea', 'Story Panel 1 — Body',           'Luméa was born in a small Paris apartment, from years of frustration with formulas full of synthetic fillers and empty promises.' ),
		'lumea_about_story1_link'   => array( 'text',     'Story Panel 1 — Link Text',      'Explore formulas' ),
		'lumea_about_story2_label'  => array( 'text',     'Story Panel 2 — Eyebrow',        'Our Process' ),
		'lumea_about_story2_h2'     => array( 'text',     'Story Panel 2 — Heading',        'From field to formula' ),
		'lumea_about_story2_body1'  => array( 'textarea', 'Story Panel 2 — Body Paragraph 1', 'We partner directly with farmers and distilleries across twelve countries — from Bulgarian rose valleys to Japanese forest bathing reserves.' ),
		'lumea_about_story2_body2'  => array( 'textarea', 'Story Panel 2 — Body Paragraph 2', 'Every formula is stress-tested at the cellular level before it reaches you, with clinically measurable results visible within 28 days.' ),

		
		'lumea_about_values_bg'     => array( 'image',    'Values — Background Image',      LUMEA_THEME_URI . '/assets/images/editorial-slide-2.jpg' ),
		'lumea_about_values_label'  => array( 'text',     'Values — Eyebrow',               'What We Stand For' ),
		'lumea_about_values_h2'     => array( 'text',     'Values — Heading',               'Three principles. Every decision.' ),
		'lumea_about_val1_h3'       => array( 'text',     'Value 1 — Title',                'Botanical Purity' ),
		'lumea_about_val1_p'        => array( 'textarea', 'Value 1 — Description',          "We exclude over 1,400 controversial ingredients. If it isn't found in nature or proven safe by independent research, it doesn't enter our lab." ),
		'lumea_about_val2_h3'       => array( 'text',     'Value 2 — Title',                'Scientific Precision' ),
		'lumea_about_val2_p'        => array( 'textarea', 'Value 2 — Description',          "Botanicals alone aren't enough. Each formula is stress-tested at the cellular level to deliver clinically measurable results — visible within 28 days." ),
		'lumea_about_val3_h3'       => array( 'text',     'Value 3 — Title',                'Mindful Luxury' ),
		'lumea_about_val3_p'        => array( 'textarea', 'Value 3 — Description',          "Premium shouldn't cost the planet. We use ocean-bound glass packaging, carbon-neutral shipping, and donate 1% of every sale to reforestation." ),

		
		'lumea_about_ing_label'     => array( 'text',     'Ingredients — Eyebrow',          'Ingredient Philosophy' ),
		'lumea_about_ing_h2'        => array( 'text',     'Ingredients — Heading',          'We believe in ingredients you can pronounce' ),
		'lumea_about_ing_body'      => array( 'textarea', 'Ingredients — Body',             'Our ingredient selection starts in the field, not the lab. We work backwards from the plant — understanding its native habitat, harvest season, and traditional therapeutic uses before evaluating its bioactive potential.' ),
		'lumea_about_ing_bullets'   => array( 'textarea', 'Ingredients — Bullet Points (one per line)', "No synthetic fragrance\nNo parabens or sulfates\nCruelty-free, Leaping Bunny certified\nSustainably sourced, traceable supply chain" ),
		'lumea_about_ing1_name'     => array( 'text',     'Ingredient 1 — Name',            'Bulgarian Rose Otto' ),
		'lumea_about_ing1_desc'     => array( 'textarea', 'Ingredient 1 — Description',     'Sourced from the Rose Valley at peak bloom. 3.5 tonnes of petals yield one kilogram of oil.' ),
		'lumea_about_ing2_name'     => array( 'text',     'Ingredient 2 — Name',            'Bakuchiol' ),
		'lumea_about_ing2_desc'     => array( 'textarea', 'Ingredient 2 — Description',     "Nature's retinol alternative. Clinically proven to reduce fine lines without sensitivity." ),
		'lumea_about_ing3_name'     => array( 'text',     'Ingredient 3 — Name',            'Snow Mushroom' ),
		'lumea_about_ing3_desc'     => array( 'textarea', 'Ingredient 3 — Description',     'Japanese forest extract. Holds 500× its weight in water — superior to hyaluronic acid.' ),

		
		'lumea_about_press_pubs'    => array( 'textarea', 'Press — Publications (one per line)', "Vogue\nHarper's Bazaar\nByrdie\nInto The Gloss\nRefinery29\nElle\nAllure" ),

		
		'lumea_about_cta_bg'        => array( 'image',    'CTA — Background Image',         LUMEA_THEME_URI . '/assets/images/bestsellers/cta-bg.jpg' ),
		'lumea_about_cta_label'     => array( 'text',     'CTA — Eyebrow',                  'Begin Your Ritual' ),
		'lumea_about_cta_h2'        => array( 'textarea', 'CTA — Heading (use newline for line break)', "Ready to meet\nyour skin's new favourites?" ),
		'lumea_about_cta_btn1'      => array( 'text',     'CTA — Primary Button Text',      'Shop All Products' ),
		'lumea_about_cta_btn2'      => array( 'text',     'CTA — Secondary Button Text',    'Get In Touch' ),
	);

	foreach ( $about_controls as $key => $cfg ) {
		list( $type, $label, $default ) = $cfg;

		$wp_customize->add_setting( $key, array(
			'default'           => $default,
			'sanitize_callback' => ( $type === 'image' ) ? 'esc_url_raw' : 'wp_kses_post',
			'transport'         => 'refresh',
		) );

		if ( $type === 'image' ) {
			$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, $key, array(
				'label'   => esc_html__( $label, 'lumea' ),
				'section' => 'lumea_about',
			) ) );
		} elseif ( $type === 'textarea' ) {
			$wp_customize->add_control( $key, array(
				'label'   => esc_html__( $label, 'lumea' ),
				'section' => 'lumea_about',
				'type'    => 'textarea',
			) );
		} else {
			$wp_customize->add_control( $key, array(
				'label'   => esc_html__( $label, 'lumea' ),
				'section' => 'lumea_about',
				'type'    => 'text',
			) );
		}
	}

	
	$wp_customize->add_section(
		'lumea_shop_sections',
		array(
			'title'       => esc_html__( 'Shop Sections', 'lumea' ),
			'description' => esc_html__( 'Configure the product category names used for homepage sections.', 'lumea' ),
			'panel'       => 'lumea_theme',
		)
	);

	$wp_customize->add_setting(
		'lumea_bestseller_cat_name',
		array(
			'default'           => 'Bestseller',
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		'lumea_bestseller_cat_name',
		array(
			'label'       => esc_html__( 'Bestsellers Category Name', 'lumea' ),
			'description' => esc_html__( 'Exact name of the WooCommerce product category used for the Bestsellers section.', 'lumea' ),
			'section'     => 'lumea_shop_sections',
			'type'        => 'text',
		)
	);

	$wp_customize->add_setting(
		'lumea_latest_cat_name',
		array(
			'default'           => 'Latest',
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		'lumea_latest_cat_name',
		array(
			'label'       => esc_html__( 'Latest Products Category Name', 'lumea' ),
			'description' => esc_html__( 'Exact name of the WooCommerce product category used for the Latest Products section.', 'lumea' ),
			'section'     => 'lumea_shop_sections',
			'type'        => 'text',
		)
	);
}
add_action( 'customize_register', 'lumea_customize_register' );
