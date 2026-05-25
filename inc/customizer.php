<?php
/**
 * Theme Customizer — all front-page content and images.
 *
 * @package Lumea
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register Customizer settings.
 *
 * @param WP_Customize_Manager $wp_customize
 */
function lumea_customize_register( $wp_customize ) {

	/* ── Master panel ─────────────────────────────────────── */
	$wp_customize->add_panel(
		'lumea_theme',
		array(
			'title'    => esc_html__( 'Luméa Theme', 'lumea' ),
			'priority' => 10,
		)
	);

	/* ════════════════════════════════════════════════════════
	   1. HERO SECTION
	   ════════════════════════════════════════════════════════ */
	$wp_customize->add_section(
		'lumea_hero',
		array(
			'title' => esc_html__( 'Hero', 'lumea' ),
			'panel' => 'lumea_theme',
		)
	);

	// Background images — slide 1 (required) + slides 2–5 (optional)
	$hero_image_defaults = array(
		1 => LUMEA_THEME_URI . '/assets/images/hero1.jpg',
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

	// Label ("Glow")
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

	// Subtitle pills
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

	// CTA button text
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

	/* ════════════════════════════════════════════════════════
	   2. EDITORIAL SLIDER
	   ════════════════════════════════════════════════════════ */
	$wp_customize->add_section(
		'lumea_slider',
		array(
			'title' => esc_html__( 'Editorial Slider', 'lumea' ),
			'panel' => 'lumea_theme',
		)
	);

	// Section intro
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

	// "Shop All" button text
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

	// Slides 1–6
	$slide_defaults = array(
		1 => array(
			'text'  => 'Botanical skincare rituals designed for luminous skin, soft texture, and everyday radiance.',
			'image' => LUMEA_THEME_URI . '/assets/images/1.jpg',
		),
		2 => array(
			'text'  => 'Clean formulas, soft botanicals, and refined essentials for a calm beauty routine.',
			'image' => LUMEA_THEME_URI . '/assets/images/2.jpg',
		),
		3 => array(
			'text'  => 'A curated edit of everyday glow products made for modern skincare rituals.',
			'image' => LUMEA_THEME_URI . '/assets/images/hero.jpg',
		),
		4 => array(
			'text'  => 'Soft hydration, botanical balance, and skin-first essentials for natural radiance.',
			'image' => LUMEA_THEME_URI . '/assets/images/4.jpg',
		),
		5 => array(
			'text'  => 'A fresh beauty wardrobe made for skin that feels balanced, bright, and alive.',
			'image' => LUMEA_THEME_URI . '/assets/images/he.jpg',
		),
		6 => array(
			'text'  => 'Glow-focused skincare where timeless botanicals meet a modern beauty edge.',
			'image' => LUMEA_THEME_URI . '/assets/images/6.jpg',
		),
	);

	foreach ( $slide_defaults as $n => $defaults ) {
		$img_key  = 'lumea_slide_' . $n . '_image';
		$text_key = 'lumea_slide_' . $n . '_text';

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
	}

	/* ════════════════════════════════════════════════════════
	   3. CURATED GLOW
	   ════════════════════════════════════════════════════════ */
	$wp_customize->add_section(
		'lumea_curated',
		array(
			'title' => esc_html__( 'Curated Glow', 'lumea' ),
			'panel' => 'lumea_theme',
		)
	);

	// Section intro
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

	// Products 1 & 2
	$product_defaults = array(
		1 => array(
			'image' => LUMEA_THEME_URI . '/assets/images/hero1.jpg',
			'name'  => 'Radiance Serum',
			'price' => '$48.00',
			'desc'  => 'A lightweight botanical serum for dewy, luminous, everyday skin.',
			'url'   => '',
		),
		2 => array(
			'image' => LUMEA_THEME_URI . '/assets/images/her02.jpg',
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

	/* ════════════════════════════════════════════════════════
	   4. SHOP BESTSELLERS
	   ════════════════════════════════════════════════════════ */
	$wp_customize->add_section(
		'lumea_bestsellers',
		array(
			'title' => esc_html__( 'Shop Bestsellers', 'lumea' ),
			'panel' => 'lumea_theme',
		)
	);

	// Section intro
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

	// Products 1–5
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

	/* ════════════════════════════════════════════════════════
	   5. THE RITUAL SECTION
	   ════════════════════════════════════════════════════════ */
	$wp_customize->add_section(
		'lumea_ritual',
		array(
			'title' => esc_html__( 'The Ritual', 'lumea' ),
			'panel' => 'lumea_theme',
		)
	);

	// Heading lines
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

	// Intro paragraph
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

	// Steps 1–4
	$ritual_step_defaults = array(
		1 => array(
			'title'  => 'Cleanse',
			'text'   => 'Begin with pure intention. Our gentle botanical cleansers dissolve impurities without stripping the skin\'s natural balance, leaving a fresh, receptive canvas.',
			'image1' => LUMEA_THEME_URI . '/assets/images/ritual/a1.jpg',
			'image2' => LUMEA_THEME_URI . '/assets/images/ritual/a2.jpg',
		),
		2 => array(
			'title'  => 'Tone & Prep',
			'text'   => 'Restore skin\'s equilibrium. Botanical tonics and essence waters refine pores, balance pH, and prime skin to absorb every active that follows.',
			'image1' => LUMEA_THEME_URI . '/assets/images/hero.jpg',
			'image2' => LUMEA_THEME_URI . '/assets/images/4.jpg',
		),
		3 => array(
			'title'  => 'Treat & Correct',
			'text'   => 'Targeted actives where they matter most. Concentrated serums address luminosity, firmness, and even tone at the cellular level.',
			'image1' => LUMEA_THEME_URI . '/assets/images/6.jpg',
			'image2' => LUMEA_THEME_URI . '/assets/images/her02.jpg',
		),
		4 => array(
			'title'  => 'Restore & Protect',
			'text'   => 'Seal the ritual with nourishment. Rich creams and facial oils lock in actives, rebuild the moisture barrier, and leave skin visibly calm, plump, and glowing.',
			'image1' => LUMEA_THEME_URI . '/assets/images/he.jpg',
			'image2' => LUMEA_THEME_URI . '/assets/images/hero1.jpg',
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

	/* ════════════════════════════════════════════════════════
	   5. MANIFEST SECTION
	   ════════════════════════════════════════════════════════ */
	$wp_customize->add_section(
		'lumea_manifest',
		array(
			'title' => esc_html__( 'Manifest Section', 'lumea' ),
			'panel' => 'lumea_theme',
		)
	);

	// Background image
	$wp_customize->add_setting( 'lumea_manifest_image', array(
		'default'           => LUMEA_THEME_URI . '/assets/images/he.jpg',
		'sanitize_callback' => 'esc_url_raw',
		'transport'         => 'refresh',
	) );
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'lumea_manifest_image', array(
		'label'   => esc_html__( 'Background Image', 'lumea' ),
		'section' => 'lumea_manifest',
	) ) );

	// Kicker lines
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

	// Title lines
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
	/* ════════════════════════════════════════════════════════
	   6. FOOTER
	   ════════════════════════════════════════════════════════ */
	$wp_customize->add_section(
		'lumea_footer',
		array(
			'title' => esc_html__( 'Footer', 'lumea' ),
			'panel' => 'lumea_theme',
		)
	);

	// Tagline
	$wp_customize->add_setting( 'lumea_footer_tagline', array(
		'default'           => 'Botanical skincare for luminous living.',
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'refresh',
	) );
	$wp_customize->add_control( 'lumea_footer_tagline', array(
		'label'   => esc_html__( 'Brand Tagline', 'lumea' ),
		'section' => 'lumea_footer',
		'type'    => 'text',
	) );

	// Copyright text
	$wp_customize->add_setting( 'lumea_footer_copy', array(
		'default'           => 'Luméa. All rights reserved.',
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'refresh',
	) );
	$wp_customize->add_control( 'lumea_footer_copy', array(
		'label'       => esc_html__( 'Copyright Text (year prepended automatically)', 'lumea' ),
		'section'     => 'lumea_footer',
		'type'        => 'text',
	) );

	// Nav links
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

	// Social links
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
}
add_action( 'customize_register', 'lumea_customize_register' );
