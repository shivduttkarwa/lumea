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
		'lumea_homepage',
		array(
			'title'    => esc_html__( 'Home Page', 'lumea' ),
			'priority' => 10,
		)
	);

	$wp_customize->add_panel(
		'lumea_theme',
		array(
			'title'    => esc_html__( 'Luméa Theme', 'lumea' ),
			'priority' => 11,
		)
	);

	$wp_customize->add_section(
		'lumea_hero',
		array(
			'title'    => esc_html__( 'Hero Slider', 'lumea' ),
			'panel'    => 'lumea_homepage',
			'priority' => 10,
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
		$key   = ( 1 === $n ) ? 'lumea_hero_image' : 'lumea_hero_image_' . $n;
		$label = ( 1 === $n )
			? esc_html__( 'Slide 1 Image (required)', 'lumea' )
			/* translators: %d: slide number */
			: sprintf( esc_html__( 'Slide %d Image (optional)', 'lumea' ), $n );

		$wp_customize->add_setting(
			$key,
			array(
				'default'           => $default,
				'sanitize_callback' => 'esc_url_raw',
				'transport'         => 'refresh',
			)
		);
		$wp_customize->add_control(
			new WP_Customize_Image_Control(
				$wp_customize,
				$key,
				array(
					'label'   => $label,
					'section' => 'lumea_hero',
				)
			)
		);
	}

	$wp_customize->add_setting(
		'lumea_hero_label',
		array(
			'default'           => __( 'Glow', 'lumea' ),
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		'lumea_hero_label',
		array(
			'label'   => esc_html__( 'Label (above title)', 'lumea' ),
			'section' => 'lumea_hero',
			'type'    => 'text',
		)
	);

	$hero_label_defaults = array(
		2 => __( 'Hydrate', 'lumea' ),
		3 => __( 'Nourish', 'lumea' ),
		4 => __( 'Protect', 'lumea' ),
		5 => __( 'Renew', 'lumea' ),
	);

	for ( $n = 2; $n <= 5; $n++ ) {
		$key = 'lumea_hero_label_' . $n;

		$wp_customize->add_setting(
			$key,
			array(
				'default'           => $hero_label_defaults[ $n ],
				'sanitize_callback' => 'sanitize_text_field',
				'transport'         => 'refresh',
			)
		);
		$wp_customize->add_control(
			$key,
			array(
				/* translators: %d: slide number */
				'label'       => sprintf( esc_html__( 'Slide %d Label (above title)', 'lumea' ), $n ),
				'description' => esc_html__( 'Use a short word like Glow, Hydrate, Protect.', 'lumea' ),
				'section'     => 'lumea_hero',
				'type'        => 'text',
			)
		);
	}

	foreach ( array(
		'lumea_hero_subtitle_1' => array( __( 'Skincare', 'lumea' ), __( 'Subtitle 1', 'lumea' ) ),
		'lumea_hero_subtitle_2' => array( __( 'Cosmetics', 'lumea' ), __( 'Subtitle 2', 'lumea' ) ),
		'lumea_hero_subtitle_3' => array( __( 'Beauty', 'lumea' ), __( 'Subtitle 3', 'lumea' ) ),
	) as $key => $info ) {
		$wp_customize->add_setting(
			$key,
			array(
				'default'           => $info[0],
				'sanitize_callback' => 'sanitize_text_field',
				'transport'         => 'refresh',
			)
		);
		$wp_customize->add_control(
			$key,
			array(
				'label'   => esc_html( $info[1] ),
				'section' => 'lumea_hero',
				'type'    => 'text',
			)
		);
	}

	$wp_customize->add_setting(
		'lumea_hero_cta_text',
		array(
			'default'           => __( 'Shop Collection', 'lumea' ),
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		'lumea_hero_cta_text',
		array(
			'label'   => esc_html__( 'CTA Button Text', 'lumea' ),
			'section' => 'lumea_hero',
			'type'    => 'text',
		)
	);

	$wp_customize->add_section(
		'lumea_slider',
		array(
			'title'    => esc_html__( 'Editorial Slider', 'lumea' ),
			'panel'    => 'lumea_homepage',
			'priority' => 20,
		)
	);

	foreach ( array(
		'lumea_slider_eyebrow' => array( __( 'Editorial Collection', 'lumea' ), __( 'Eyebrow Label', 'lumea' ) ),
		'lumea_slider_title'   => array( __( 'The Edit', 'lumea' ), __( 'Section Title', 'lumea' ) ),
	) as $key => $info ) {
		$wp_customize->add_setting(
			$key,
			array(
				'default'           => $info[0],
				'sanitize_callback' => 'sanitize_text_field',
				'transport'         => 'refresh',
			)
		);
		$wp_customize->add_control(
			$key,
			array(
				'label'   => esc_html( $info[1] ),
				'section' => 'lumea_slider',
				'type'    => 'text',
			)
		);
	}

	$wp_customize->add_setting(
		'lumea_slider_desc',
		array(
			'default'           => __( 'Curated botanicals and skin-first formulas for luminous, everyday beauty.', 'lumea' ),
			'sanitize_callback' => 'sanitize_textarea_field',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		'lumea_slider_desc',
		array(
			'label'   => esc_html__( 'Section Description', 'lumea' ),
			'section' => 'lumea_slider',
			'type'    => 'textarea',
		)
	);

	$wp_customize->add_setting(
		'lumea_slider_cta_text',
		array(
			'default'           => __( 'Shop All', 'lumea' ),
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		'lumea_slider_cta_text',
		array(
			'label'   => esc_html__( '"Shop All" Button Text', 'lumea' ),
			'section' => 'lumea_slider',
			'type'    => 'text',
		)
	);

	$slide_defaults = array(
		1 => array(
			'text'  => __( 'Botanical skincare rituals designed for luminous skin, soft texture, and everyday radiance.', 'lumea' ),
			'image' => LUMEA_THEME_URI . '/assets/images/editorial-slide-1.jpg',
		),
		2 => array(
			'text'  => __( 'Clean formulas, soft botanicals, and refined essentials for a calm beauty routine.', 'lumea' ),
			'image' => LUMEA_THEME_URI . '/assets/images/editorial-slide-2.jpg',
		),
		3 => array(
			'text'  => __( 'A curated edit of everyday glow products made for modern skincare rituals.', 'lumea' ),
			'image' => LUMEA_THEME_URI . '/assets/images/editorial-slide-3.jpg',
		),
		4 => array(
			'text'  => __( 'Soft hydration, botanical balance, and skin-first essentials for natural radiance.', 'lumea' ),
			'image' => LUMEA_THEME_URI . '/assets/images/editorial-slide-4.jpg',
		),
		5 => array(
			'text'  => __( 'A fresh beauty wardrobe made for skin that feels balanced, bright, and alive.', 'lumea' ),
			'image' => LUMEA_THEME_URI . '/assets/images/editorial-slide-5.jpg',
		),
		6 => array(
			'text'  => __( 'Glow-focused skincare where timeless botanicals meet a modern beauty edge.', 'lumea' ),
			'image' => LUMEA_THEME_URI . '/assets/images/editorial-slide-6.jpg',
		),
	);

	foreach ( $slide_defaults as $n => $defaults ) {
		$img_key  = 'lumea_slide_' . $n . '_image';
		$text_key = 'lumea_slide_' . $n . '_text';
		$url_key  = 'lumea_slide_' . $n . '_url';

		$wp_customize->add_setting(
			$img_key,
			array(
				'default'           => $defaults['image'],
				'sanitize_callback' => 'esc_url_raw',
				'transport'         => 'refresh',
			)
		);
		$wp_customize->add_control(
			new WP_Customize_Image_Control(
				$wp_customize,
				$img_key,
				array(
					/* translators: %d: slide number */
					'label'   => sprintf( esc_html__( 'Slide %d Image', 'lumea' ), $n ),
					'section' => 'lumea_slider',
				)
			)
		);

		$wp_customize->add_setting(
			$text_key,
			array(
				'default'           => $defaults['text'],
				'sanitize_callback' => 'sanitize_textarea_field',
				'transport'         => 'refresh',
			)
		);
		$wp_customize->add_control(
			$text_key,
			array(
				/* translators: %d: slide number */
				'label'   => sprintf( esc_html__( 'Slide %d Caption', 'lumea' ), $n ),
				'section' => 'lumea_slider',
				'type'    => 'textarea',
			)
		);

		$wp_customize->add_setting(
			$url_key,
			array(
				'default'           => '',
				'sanitize_callback' => 'esc_url_raw',
				'transport'         => 'refresh',
			)
		);
		$wp_customize->add_control(
			$url_key,
			array(
				/* translators: %d: slide number */
				'label'   => sprintf( esc_html__( 'Slide %d Product URL (blank = shop)', 'lumea' ), $n ),
				'section' => 'lumea_slider',
				'type'    => 'url',
			)
		);
	}

	$wp_customize->add_section(
		'lumea_curated',
		array(
			'title'    => esc_html__( 'Curated Glow', 'lumea' ),
			'panel'    => 'lumea_homepage',
			'priority' => 30,
		)
	);

	$wp_customize->add_setting(
		'lumea_curated_eyebrow',
		array(
			'default'           => __( 'Bestsellers', 'lumea' ),
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		'lumea_curated_eyebrow',
		array(
			'label'   => esc_html__( 'Eyebrow Label', 'lumea' ),
			'section' => 'lumea_curated',
			'type'    => 'text',
		)
	);

	$wp_customize->add_setting(
		'lumea_curated_title',
		array(
			'default'           => __( 'Curated Glow', 'lumea' ),
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		'lumea_curated_title',
		array(
			'label'   => esc_html__( 'Section Title', 'lumea' ),
			'section' => 'lumea_curated',
			'type'    => 'text',
		)
	);

	$wp_customize->add_setting(
		'lumea_curated_desc',
		array(
			'default'           => __( 'Handpicked essentials for a luminous, skin-first daily ritual.', 'lumea' ),
			'sanitize_callback' => 'sanitize_textarea_field',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		'lumea_curated_desc',
		array(
			'label'   => esc_html__( 'Section Description', 'lumea' ),
			'section' => 'lumea_curated',
			'type'    => 'textarea',
		)
	);

	$product_defaults = array(
		1 => array(
			'image' => LUMEA_THEME_URI . '/assets/images/hero-slide-1.jpg',
			'name'  => __( 'Radiance Serum', 'lumea' ),
			'price' => '$48.00',
			'desc'  => __( 'A lightweight botanical serum for dewy, luminous, everyday skin.', 'lumea' ),
			'url'   => '',
		),
		2 => array(
			'image' => LUMEA_THEME_URI . '/assets/images/model-portrait.jpg',
			'name'  => __( 'Velvet Cream', 'lumea' ),
			'price' => '$42.00',
			'desc'  => __( 'Rich daily moisture with a soft-touch finish and botanical comfort.', 'lumea' ),
			'url'   => '',
		),
	);

	foreach ( $product_defaults as $n => $defaults ) {
		$prefix = 'lumea_product' . $n;

		$wp_customize->add_setting(
			$prefix . '_image',
			array(
				'default'           => $defaults['image'],
				'sanitize_callback' => 'esc_url_raw',
				'transport'         => 'refresh',
			)
		);
		$wp_customize->add_control(
			new WP_Customize_Image_Control(
				$wp_customize,
				$prefix . '_image',
				array(
					/* translators: %d: product number */
					'label'   => sprintf( esc_html__( 'Product %d Image', 'lumea' ), $n ),
					'section' => 'lumea_curated',
				)
			)
		);

		$wp_customize->add_setting(
			$prefix . '_name',
			array(
				'default'           => $defaults['name'],
				'sanitize_callback' => 'sanitize_text_field',
				'transport'         => 'refresh',
			)
		);
		$wp_customize->add_control(
			$prefix . '_name',
			array(
				/* translators: %d: product number */
				'label'   => sprintf( esc_html__( 'Product %d Name', 'lumea' ), $n ),
				'section' => 'lumea_curated',
				'type'    => 'text',
			)
		);

		$wp_customize->add_setting(
			$prefix . '_price',
			array(
				'default'           => $defaults['price'],
				'sanitize_callback' => 'sanitize_text_field',
				'transport'         => 'refresh',
			)
		);
		$wp_customize->add_control(
			$prefix . '_price',
			array(
				/* translators: %d: product number */
				'label'   => sprintf( esc_html__( 'Product %d Price', 'lumea' ), $n ),
				'section' => 'lumea_curated',
				'type'    => 'text',
			)
		);

		$wp_customize->add_setting(
			$prefix . '_desc',
			array(
				'default'           => $defaults['desc'],
				'sanitize_callback' => 'sanitize_textarea_field',
				'transport'         => 'refresh',
			)
		);
		$wp_customize->add_control(
			$prefix . '_desc',
			array(
				/* translators: %d: product number */
				'label'   => sprintf( esc_html__( 'Product %d Description', 'lumea' ), $n ),
				'section' => 'lumea_curated',
				'type'    => 'textarea',
			)
		);

		$wp_customize->add_setting(
			$prefix . '_url',
			array(
				'default'           => $defaults['url'],
				'sanitize_callback' => 'esc_url_raw',
				'transport'         => 'refresh',
			)
		);
		$wp_customize->add_control(
			$prefix . '_url',
			array(
				/* translators: %d: product number */
				'label'   => sprintf( esc_html__( 'Product %d Link URL (leave blank for shop)', 'lumea' ), $n ),
				'section' => 'lumea_curated',
				'type'    => 'url',
			)
		);
	}

	$wp_customize->add_section(
		'lumea_bestsellers',
		array(
			'title'    => esc_html__( 'Shop Bestsellers', 'lumea' ),
			'panel'    => 'lumea_homepage',
			'priority' => 40,
		)
	);

	foreach ( array(
		'lumea_best_eyebrow' => array( __( 'Customer Favourites', 'lumea' ), __( 'Eyebrow Label', 'lumea' ) ),
		'lumea_best_title'   => array( __( 'Shop Bestsellers', 'lumea' ), __( 'Section Title', 'lumea' ) ),
	) as $key => $info ) {
		$wp_customize->add_setting(
			$key,
			array(
				'default'           => $info[0],
				'sanitize_callback' => 'sanitize_text_field',
				'transport'         => 'refresh',
			)
		);
		$wp_customize->add_control(
			$key,
			array(
				'label'   => esc_html( $info[1] ),
				'section' => 'lumea_bestsellers',
				'type'    => 'text',
			)
		);
	}

	$wp_customize->add_setting(
		'lumea_best_desc',
		array(
			'default'           => __( 'Our most-loved formulas, trusted by thousands worldwide.', 'lumea' ),
			'sanitize_callback' => 'sanitize_textarea_field',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		'lumea_best_desc',
		array(
			'label'   => esc_html__( 'Section Description', 'lumea' ),
			'section' => 'lumea_bestsellers',
			'type'    => 'textarea',
		)
	);

	$best_defaults = array(
		1 => array( __( 'Radiance Serum', 'lumea' ), '$48.00', __( 'No. 1', 'lumea' ) ),
		2 => array( __( 'Velvet Face Cream', 'lumea' ), '$42.00', __( 'No. 2', 'lumea' ) ),
		3 => array( __( 'Botanical Cleansing Oil', 'lumea' ), '$38.00', __( 'No. 3', 'lumea' ) ),
		4 => array( __( 'Luminous Glow Toner', 'lumea' ), '$34.00', __( 'No. 4', 'lumea' ) ),
		5 => array( __( 'Skin Glow Face Oil', 'lumea' ), '$52.00', __( 'No. 5', 'lumea' ) ),
	);

	foreach ( $best_defaults as $n => $d ) {
		$p = 'lumea_best' . $n;

		$wp_customize->add_setting(
			$p . '_name',
			array(
				'default'           => $d[0],
				'sanitize_callback' => 'sanitize_text_field',
				'transport'         => 'refresh',
			)
		);
		$wp_customize->add_control(
			$p . '_name',
			array(
				/* translators: %d: product number */
				'label'   => sprintf( esc_html__( 'Product %d Name', 'lumea' ), $n ),
				'section' => 'lumea_bestsellers',
				'type'    => 'text',
			)
		);

		$wp_customize->add_setting(
			$p . '_price',
			array(
				'default'           => $d[1],
				'sanitize_callback' => 'sanitize_text_field',
				'transport'         => 'refresh',
			)
		);
		$wp_customize->add_control(
			$p . '_price',
			array(
				/* translators: %d: product number */
				'label'   => sprintf( esc_html__( 'Product %d Price', 'lumea' ), $n ),
				'section' => 'lumea_bestsellers',
				'type'    => 'text',
			)
		);

		$wp_customize->add_setting(
			$p . '_badge',
			array(
				'default'           => $d[2],
				'sanitize_callback' => 'sanitize_text_field',
				'transport'         => 'refresh',
			)
		);
		$wp_customize->add_control(
			$p . '_badge',
			array(
				/* translators: %d: product number */
				'label'   => sprintf( esc_html__( 'Product %d Badge (leave blank to hide)', 'lumea' ), $n ),
				'section' => 'lumea_bestsellers',
				'type'    => 'text',
			)
		);

		$wp_customize->add_setting(
			$p . '_main_image',
			array(
				'default'           => '',
				'sanitize_callback' => 'esc_url_raw',
				'transport'         => 'refresh',
			)
		);
		$wp_customize->add_control(
			new WP_Customize_Image_Control(
				$wp_customize,
				$p . '_main_image',
				array(
					/* translators: %d: product number */
					'label'   => sprintf( esc_html__( 'Product %d — Main Image', 'lumea' ), $n ),
					'section' => 'lumea_bestsellers',
				)
			)
		);

		$wp_customize->add_setting(
			$p . '_hover_image',
			array(
				'default'           => '',
				'sanitize_callback' => 'esc_url_raw',
				'transport'         => 'refresh',
			)
		);
		$wp_customize->add_control(
			new WP_Customize_Image_Control(
				$wp_customize,
				$p . '_hover_image',
				array(
					/* translators: %d: product number */
					'label'   => sprintf( esc_html__( 'Product %d — Hover Image', 'lumea' ), $n ),
					'section' => 'lumea_bestsellers',
				)
			)
		);

		$wp_customize->add_setting(
			$p . '_url',
			array(
				'default'           => '',
				'sanitize_callback' => 'esc_url_raw',
				'transport'         => 'refresh',
			)
		);
		$wp_customize->add_control(
			$p . '_url',
			array(
				/* translators: %d: product number */
				'label'   => sprintf( esc_html__( 'Product %d Link URL (blank = shop)', 'lumea' ), $n ),
				'section' => 'lumea_bestsellers',
				'type'    => 'url',
			)
		);
	}

	$wp_customize->add_section(
		'lumea_latest',
		array(
			'title'    => esc_html__( 'Latest Products', 'lumea' ),
			'panel'    => 'lumea_homepage',
			'priority' => 50,
		)
	);

	foreach ( array(
		'lumea_latest_eyebrow' => array( __( 'Just Arrived', 'lumea' ), __( 'Eyebrow Label', 'lumea' ) ),
		'lumea_latest_title'   => array( __( 'Latest Products', 'lumea' ), __( 'Section Title', 'lumea' ) ),
	) as $key => $info ) {
		$wp_customize->add_setting(
			$key,
			array(
				'default'           => $info[0],
				'sanitize_callback' => 'sanitize_text_field',
				'transport'         => 'refresh',
			)
		);
		$wp_customize->add_control(
			$key,
			array(
				'label'   => esc_html( $info[1] ),
				'section' => 'lumea_latest',
				'type'    => 'text',
			)
		);
	}

	$wp_customize->add_setting(
		'lumea_latest_desc',
		array(
			'default'           => __( 'Freshly launched formulas and seasonal essentials selected for your next skin ritual.', 'lumea' ),
			'sanitize_callback' => 'sanitize_textarea_field',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		'lumea_latest_desc',
		array(
			'label'   => esc_html__( 'Section Description', 'lumea' ),
			'section' => 'lumea_latest',
			'type'    => 'textarea',
		)
	);

	$wp_customize->add_section(
		'lumea_ritual',
		array(
			'title'    => esc_html__( 'The Ritual', 'lumea' ),
			'panel'    => 'lumea_homepage',
			'priority' => 60,
		)
	);

	$wp_customize->add_setting(
		'lumea_ritual_heading_1',
		array(
			'default'           => __( 'your daily', 'lumea' ),
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		'lumea_ritual_heading_1',
		array(
			'label'   => esc_html__( 'Heading Line 1', 'lumea' ),
			'section' => 'lumea_ritual',
			'type'    => 'text',
		)
	);

	$wp_customize->add_setting(
		'lumea_ritual_heading_2',
		array(
			'default'           => __( 'skin ritual', 'lumea' ),
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		'lumea_ritual_heading_2',
		array(
			'label'   => esc_html__( 'Heading Line 2 (faded)', 'lumea' ),
			'section' => 'lumea_ritual',
			'type'    => 'text',
		)
	);

	$wp_customize->add_setting(
		'lumea_ritual_intro',
		array(
			'default'           => __( 'Four intentional steps, one luminous result. A complete routine designed around the skin you have.', 'lumea' ),
			'sanitize_callback' => 'sanitize_textarea_field',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		'lumea_ritual_intro',
		array(
			'label'   => esc_html__( 'Intro Paragraph', 'lumea' ),
			'section' => 'lumea_ritual',
			'type'    => 'textarea',
		)
	);

	$ritual_step_defaults = array(
		1 => array(
			'title'  => __( 'Cleanse', 'lumea' ),
			'text'   => __( 'Begin with pure intention. Our gentle botanical cleansers dissolve impurities without stripping the skin’s natural balance, leaving a fresh, receptive canvas.', 'lumea' ),
			'image1' => LUMEA_THEME_URI . '/assets/images/ritual/ritual-cleanse-1.jpg',
			'image2' => LUMEA_THEME_URI . '/assets/images/ritual/ritual-cleanse-2.jpg',
		),
		2 => array(
			'title'  => __( 'Tone & Prep', 'lumea' ),
			'text'   => __( 'Restore skin’s equilibrium. Botanical tonics and essence waters refine pores, balance pH, and prime skin to absorb every active that follows.', 'lumea' ),
			'image1' => LUMEA_THEME_URI . '/assets/images/editorial-slide-3.jpg',
			'image2' => LUMEA_THEME_URI . '/assets/images/editorial-slide-4.jpg',
		),
		3 => array(
			'title'  => __( 'Treat & Correct', 'lumea' ),
			'text'   => __( 'Targeted actives where they matter most. Concentrated serums address luminosity, firmness, and even tone at the cellular level.', 'lumea' ),
			'image1' => LUMEA_THEME_URI . '/assets/images/editorial-slide-6.jpg',
			'image2' => LUMEA_THEME_URI . '/assets/images/model-portrait.jpg',
		),
		4 => array(
			'title'  => __( 'Restore & Protect', 'lumea' ),
			'text'   => __( 'Seal the ritual with nourishment. Rich creams and facial oils lock in actives, rebuild the moisture barrier, and leave skin visibly calm, plump, and glowing.', 'lumea' ),
			'image1' => LUMEA_THEME_URI . '/assets/images/editorial-slide-5.jpg',
			'image2' => LUMEA_THEME_URI . '/assets/images/hero-slide-1.jpg',
		),
	);

	foreach ( $ritual_step_defaults as $n => $defaults ) {
		$prefix = 'lumea_ritual_step' . $n;

		$wp_customize->add_setting(
			$prefix . '_title',
			array(
				'default'           => $defaults['title'],
				'sanitize_callback' => 'sanitize_text_field',
				'transport'         => 'refresh',
			)
		);
		$wp_customize->add_control(
			$prefix . '_title',
			array(
				/* translators: %d: step number */
				'label'   => sprintf( esc_html__( 'Step %d Title', 'lumea' ), $n ),
				'section' => 'lumea_ritual',
				'type'    => 'text',
			)
		);

		$wp_customize->add_setting(
			$prefix . '_text',
			array(
				'default'           => $defaults['text'],
				'sanitize_callback' => 'sanitize_textarea_field',
				'transport'         => 'refresh',
			)
		);
		$wp_customize->add_control(
			$prefix . '_text',
			array(
				/* translators: %d: step number */
				'label'   => sprintf( esc_html__( 'Step %d Description', 'lumea' ), $n ),
				'section' => 'lumea_ritual',
				'type'    => 'textarea',
			)
		);

		$wp_customize->add_setting(
			$prefix . '_image1',
			array(
				'default'           => $defaults['image1'],
				'sanitize_callback' => 'esc_url_raw',
				'transport'         => 'refresh',
			)
		);
		$wp_customize->add_control(
			new WP_Customize_Image_Control(
				$wp_customize,
				$prefix . '_image1',
				array(
					/* translators: %d: step number */
					'label'   => sprintf( esc_html__( 'Step %d — Image 1', 'lumea' ), $n ),
					'section' => 'lumea_ritual',
				)
			)
		);

		$wp_customize->add_setting(
			$prefix . '_image2',
			array(
				'default'           => $defaults['image2'],
				'sanitize_callback' => 'esc_url_raw',
				'transport'         => 'refresh',
			)
		);
		$wp_customize->add_control(
			new WP_Customize_Image_Control(
				$wp_customize,
				$prefix . '_image2',
				array(
					/* translators: %d: step number */
					'label'   => sprintf( esc_html__( 'Step %d — Image 2', 'lumea' ), $n ),
					'section' => 'lumea_ritual',
				)
			)
		);
	}

	$wp_customize->add_section(
		'lumea_manifest',
		array(
			'title'    => esc_html__( 'Manifest Section', 'lumea' ),
			'panel'    => 'lumea_homepage',
			'priority' => 70,
		)
	);

	$wp_customize->add_setting(
		'lumea_manifest_image',
		array(
			'default'           => LUMEA_THEME_URI . '/assets/images/editorial-slide-5.jpg',
			'sanitize_callback' => 'esc_url_raw',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize,
			'lumea_manifest_image',
			array(
				'label'   => esc_html__( 'Background Image', 'lumea' ),
				'section' => 'lumea_manifest',
			)
		)
	);

	$kicker_defaults = array(
		1 => __( '.make your skin comfortable', 'lumea' ),
		2 => __( 'trust your glow and feel calm', 'lumea' ),
		3 => __( 'in every skincare ritual+', 'lumea' ),
	);
	foreach ( $kicker_defaults as $n => $default ) {
		$wp_customize->add_setting(
			'lumea_manifest_kicker_' . $n,
			array(
				'default'           => $default,
				'sanitize_callback' => 'sanitize_text_field',
				'transport'         => 'refresh',
			)
		);
		$wp_customize->add_control(
			'lumea_manifest_kicker_' . $n,
			array(
				/* translators: %d: line number */
				'label'   => sprintf( esc_html__( 'Kicker Line %d', 'lumea' ), $n ),
				'section' => 'lumea_manifest',
				'type'    => 'text',
			)
		);
	}

	$title_defaults = array(
		1 => __( 'modern ritual', 'lumea' ),
		2 => __( 'for timeless', 'lumea' ),
		3 => __( 'radiance', 'lumea' ),
	);
	foreach ( $title_defaults as $n => $default ) {
		$wp_customize->add_setting(
			'lumea_manifest_title_' . $n,
			array(
				'default'           => $default,
				'sanitize_callback' => 'sanitize_text_field',
				'transport'         => 'refresh',
			)
		);
		$wp_customize->add_control(
			'lumea_manifest_title_' . $n,
			array(
				/* translators: %d: line number */
				'label'   => sprintf( esc_html__( 'Heading Line %d', 'lumea' ), $n ),
				'section' => 'lumea_manifest',
				'type'    => 'text',
			)
		);
	}

	$wp_customize->add_section(
		'lumea_footer',
		array(
			'title' => esc_html__( 'Footer', 'lumea' ),
			'panel' => 'lumea_theme',
		)
	);

	$wp_customize->add_setting(
		'lumea_footer_headline',
		array(
			'default'           => __( 'Discover your skin’s new ritual. Start today.', 'lumea' ),
			'sanitize_callback' => 'wp_kses_post',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		'lumea_footer_headline',
		array(
			'label'   => esc_html__( 'CTA Headline', 'lumea' ),
			'section' => 'lumea_footer',
			'type'    => 'textarea',
		)
	);

	$wp_customize->add_setting(
		'lumea_footer_cta_text',
		array(
			'default'           => __( 'Shop Collection', 'lumea' ),
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		'lumea_footer_cta_text',
		array(
			'label'   => esc_html__( 'CTA Button Label', 'lumea' ),
			'section' => 'lumea_footer',
			'type'    => 'text',
		)
	);

	$wp_customize->add_setting(
		'lumea_footer_connect_heading',
		array(
			'default'           => __( 'Connect', 'lumea' ),
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		'lumea_footer_connect_heading',
		array(
			'label'   => esc_html__( 'Connect Column Heading', 'lumea' ),
			'section' => 'lumea_footer',
			'type'    => 'text',
		)
	);

	$wp_customize->add_setting(
		'lumea_footer_address',
		array(
			'default'           => '',
			'sanitize_callback' => 'sanitize_textarea_field',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		'lumea_footer_address',
		array(
			'label'   => esc_html__( 'Address (one line per row)', 'lumea' ),
			'section' => 'lumea_footer',
			'type'    => 'textarea',
		)
	);

	$wp_customize->add_setting(
		'lumea_footer_email',
		array(
			'default'           => '',
			'sanitize_callback' => 'sanitize_email',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		'lumea_footer_email',
		array(
			'label'   => esc_html__( 'Contact Email', 'lumea' ),
			'section' => 'lumea_footer',
			'type'    => 'email',
		)
	);

	$wp_customize->add_setting(
		'lumea_support_email',
		array(
			'default'           => '',
			'sanitize_callback' => 'sanitize_email',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		'lumea_support_email',
		array(
			'label'       => esc_html__( 'Support Email (Contact & FAQ pages)', 'lumea' ),
			'description' => esc_html__( 'Displayed as a clickable mailto link on the Contact page and in FAQ answers.', 'lumea' ),
			'section'     => 'lumea_footer',
			'type'        => 'email',
		)
	);

	$wp_customize->add_setting(
		'lumea_footer_video',
		array(
			'default'           => LUMEA_THEME_URI . '/assets/images/hero/footer-video.mp4',
			'sanitize_callback' => 'esc_url_raw',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		'lumea_footer_video',
		array(
			'label'       => esc_html__( 'Brand Video URL (.mp4) — shows through "LUMÉA" letters', 'lumea' ),
			'description' => esc_html__( 'Upload an MP4 to Media Library, paste its URL here. Leave blank to use the fallback image instead.', 'lumea' ),
			'section'     => 'lumea_footer',
			'type'        => 'url',
		)
	);

	$wp_customize->add_setting(
		'lumea_footer_video_poster',
		array(
			'default'           => LUMEA_THEME_URI . '/assets/images/hero/latest-hero.jpg',
			'sanitize_callback' => 'esc_url_raw',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize,
			'lumea_footer_video_poster',
			array(
				'label'   => esc_html__( 'Brand Fallback Image (shows if no video)', 'lumea' ),
				'section' => 'lumea_footer',
			)
		)
	);

	$wp_customize->add_setting(
		'lumea_footer_copy',
		array(
			'default'           => __( 'Lumea Botanical Skincare', 'lumea' ),
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		'lumea_footer_copy',
		array(
			'label'   => esc_html__( 'Copyright Text (after the year)', 'lumea' ),
			'section' => 'lumea_footer',
			'type'    => 'text',
		)
	);

	foreach ( array(
		'lumea_footer_instagram' => __( 'Instagram URL', 'lumea' ),
		'lumea_footer_tiktok'    => __( 'TikTok URL', 'lumea' ),
		'lumea_footer_pinterest' => __( 'Pinterest URL', 'lumea' ),
	) as $key => $label ) {
		$wp_customize->add_setting(
			$key,
			array(
				'default'           => '',
				'sanitize_callback' => 'esc_url_raw',
				'transport'         => 'refresh',
			)
		);
		$wp_customize->add_control(
			$key,
			array(
				'label'   => esc_html( $label ),
				'section' => 'lumea_footer',
				'type'    => 'url',
			)
		);
	}

	/* ── Per-page hero sections (all inside lumea_theme panel) ── */

	// --- Shop Page ---
	$wp_customize->add_section(
		'lumea_hero_shop',
		array(
			'title'    => esc_html__( 'Shop Page Hero', 'lumea' ),
			'panel'    => 'lumea_theme',
			'priority' => 60,
		)
	);
	$wp_customize->add_setting(
		'lumea_shop_hero_bg',
		array(
			'default'           => LUMEA_THEME_URI . '/assets/images/bestsellers/cta-bg.jpg',
			'sanitize_callback' => 'esc_url_raw',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize,
			'lumea_shop_hero_bg',
			array(
				'label'   => esc_html__( 'Hero Image', 'lumea' ),
				'section' => 'lumea_hero_shop',
			)
		)
	);

	// --- Bestseller Category ---
	$wp_customize->add_section(
		'lumea_hero_bestseller',
		array(
			'title'    => esc_html__( 'Bestseller Category Hero', 'lumea' ),
			'panel'    => 'lumea_theme',
			'priority' => 61,
		)
	);
	$wp_customize->add_setting(
		'lumea_cat_bestseller_hero_bg',
		array(
			'default'           => LUMEA_THEME_URI . '/assets/images/bestsellers/bestsellers-hover3.jpg',
			'sanitize_callback' => 'esc_url_raw',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize,
			'lumea_cat_bestseller_hero_bg',
			array(
				'label'   => esc_html__( 'Hero Image', 'lumea' ),
				'section' => 'lumea_hero_bestseller',
			)
		)
	);

	// --- Latest Category ---
	$wp_customize->add_section(
		'lumea_hero_latest',
		array(
			'title'    => esc_html__( 'Latest Category Hero', 'lumea' ),
			'panel'    => 'lumea_theme',
			'priority' => 62,
		)
	);
	$wp_customize->add_setting(
		'lumea_cat_latest_hero_bg',
		array(
			'default'           => LUMEA_THEME_URI . '/assets/images/bestsellers/bestsellers-hover5.jpg',
			'sanitize_callback' => 'esc_url_raw',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize,
			'lumea_cat_latest_hero_bg',
			array(
				'label'   => esc_html__( 'Hero Image', 'lumea' ),
				'section' => 'lumea_hero_latest',
			)
		)
	);

	// --- Wishlist Page ---
	$wp_customize->add_section(
		'lumea_hero_wishlist',
		array(
			'title'    => esc_html__( 'Wishlist Page Hero', 'lumea' ),
			'panel'    => 'lumea_theme',
			'priority' => 63,
		)
	);
	$wp_customize->add_setting(
		'lumea_wishlist_hero_bg',
		array(
			'default'           => LUMEA_THEME_URI . '/assets/images/ritual/wishlist-hero.jpg',
			'sanitize_callback' => 'esc_url_raw',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize,
			'lumea_wishlist_hero_bg',
			array(
				'label'   => esc_html__( 'Hero Image', 'lumea' ),
				'section' => 'lumea_hero_wishlist',
			)
		)
	);
	$wp_customize->add_setting(
		'lumea_wishlist_hero_eyebrow',
		array(
			'default'           => __( 'Saved Favourites', 'lumea' ),
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		'lumea_wishlist_hero_eyebrow',
		array(
			'label'   => esc_html__( 'Eyebrow Text', 'lumea' ),
			'section' => 'lumea_hero_wishlist',
			'type'    => 'text',
		)
	);
	$wp_customize->add_setting(
		'lumea_wishlist_hero_title',
		array(
			'default'           => __( 'Your Wishlist', 'lumea' ),
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		'lumea_wishlist_hero_title',
		array(
			'label'   => esc_html__( 'Title', 'lumea' ),
			'section' => 'lumea_hero_wishlist',
			'type'    => 'text',
		)
	);
	$wp_customize->add_setting(
		'lumea_wishlist_hero_desc',
		array(
			'default'           => __( 'Products you saved for your next ritual.', 'lumea' ),
			'sanitize_callback' => 'sanitize_textarea_field',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		'lumea_wishlist_hero_desc',
		array(
			'label'   => esc_html__( 'Description', 'lumea' ),
			'section' => 'lumea_hero_wishlist',
			'type'    => 'textarea',
		)
	);

	// --- FAQ Page ---
	$wp_customize->add_section(
		'lumea_hero_faq',
		array(
			'title'    => esc_html__( 'FAQ Page Hero', 'lumea' ),
			'panel'    => 'lumea_theme',
			'priority' => 64,
		)
	);
	$wp_customize->add_setting(
		'lumea_faq_hero_bg',
		array(
			'default'           => LUMEA_THEME_URI . '/assets/images/bestsellers/cta-bg.jpg',
			'sanitize_callback' => 'esc_url_raw',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize,
			'lumea_faq_hero_bg',
			array(
				'label'   => esc_html__( 'Hero Image', 'lumea' ),
				'section' => 'lumea_hero_faq',
			)
		)
	);
	$wp_customize->add_setting(
		'lumea_faq_hero_eyebrow',
		array(
			'default'           => __( 'Help Centre', 'lumea' ),
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		'lumea_faq_hero_eyebrow',
		array(
			'label'   => esc_html__( 'Eyebrow Text', 'lumea' ),
			'section' => 'lumea_hero_faq',
			'type'    => 'text',
		)
	);
	$wp_customize->add_setting(
		'lumea_faq_hero_title',
		array(
			'default'           => __( 'Frequently Asked Questions', 'lumea' ),
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		'lumea_faq_hero_title',
		array(
			'label'   => esc_html__( 'Title', 'lumea' ),
			'section' => 'lumea_hero_faq',
			'type'    => 'text',
		)
	);

	// --- Contact Page ---
	$wp_customize->add_section(
		'lumea_hero_contact',
		array(
			'title'    => esc_html__( 'Contact Page Hero', 'lumea' ),
			'panel'    => 'lumea_theme',
			'priority' => 64,
		)
	);
	$wp_customize->add_setting(
		'lumea_contact_hero_bg',
		array(
			'default'           => LUMEA_THEME_URI . '/assets/images/bestsellers/cta-bg.jpg',
			'sanitize_callback' => 'esc_url_raw',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize,
			'lumea_contact_hero_bg',
			array(
				'label'   => esc_html__( 'Hero Image', 'lumea' ),
				'section' => 'lumea_hero_contact',
			)
		)
	);
	$wp_customize->add_setting(
		'lumea_contact_hero_eyebrow',
		array(
			'default'           => __( "We'd Love to Hear From You", 'lumea' ),
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		'lumea_contact_hero_eyebrow',
		array(
			'label'   => esc_html__( 'Eyebrow Text', 'lumea' ),
			'section' => 'lumea_hero_contact',
			'type'    => 'text',
		)
	);
	$wp_customize->add_setting(
		'lumea_contact_hero_title',
		array(
			'default'           => __( 'Get in Touch', 'lumea' ),
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		'lumea_contact_hero_title',
		array(
			'label'   => esc_html__( 'Title', 'lumea' ),
			'section' => 'lumea_hero_contact',
			'type'    => 'text',
		)
	);

	// --- Journal (Blog) Page ---
	$wp_customize->add_section(
		'lumea_hero_journal',
		array(
			'title'    => esc_html__( 'Journal Page Hero', 'lumea' ),
			'panel'    => 'lumea_theme',
			'priority' => 65,
		)
	);
	$wp_customize->add_setting(
		'lumea_blog_hero_bg',
		array(
			'default'           => LUMEA_THEME_URI . '/assets/images/bestsellers/cta-bg.jpg',
			'sanitize_callback' => 'esc_url_raw',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize,
			'lumea_blog_hero_bg',
			array(
				'label'   => esc_html__( 'Hero Image', 'lumea' ),
				'section' => 'lumea_hero_journal',
			)
		)
	);
	$wp_customize->add_setting(
		'lumea_blog_hero_title',
		array(
			'default'           => __( 'The Journal', 'lumea' ),
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		'lumea_blog_hero_title',
		array(
			'label'   => esc_html__( 'Title', 'lumea' ),
			'section' => 'lumea_hero_journal',
			'type'    => 'text',
		)
	);
	$wp_customize->add_setting(
		'lumea_blog_hero_subtitle',
		array(
			'default'           => __( 'Rituals, ingredients, and the science of radiant skin.', 'lumea' ),
			'sanitize_callback' => 'sanitize_textarea_field',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		'lumea_blog_hero_subtitle',
		array(
			'label'   => esc_html__( 'Subtitle', 'lumea' ),
			'section' => 'lumea_hero_journal',
			'type'    => 'textarea',
		)
	);

	// --- Journal Post (single blog post) ---
	$wp_customize->add_section(
		'lumea_hero_journal_post',
		array(
			'title'    => esc_html__( 'Journal Post Hero', 'lumea' ),
			'panel'    => 'lumea_theme',
			'priority' => 66,
		)
	);
	$wp_customize->add_setting(
		'lumea_blog_single_hero_bg',
		array(
			'default'           => LUMEA_THEME_URI . '/assets/images/bestsellers/cta-bg.jpg',
			'sanitize_callback' => 'esc_url_raw',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize,
			'lumea_blog_single_hero_bg',
			array(
				'label'       => esc_html__( 'Hero Image', 'lumea' ),
				'description' => esc_html__( 'Used on individual blog post pages.', 'lumea' ),
				'section'     => 'lumea_hero_journal_post',
			)
		)
	);
	$wp_customize->add_setting(
		'lumea_blog_single_hero_subtitle',
		array(
			'default'           => __( 'Rituals, ingredients, and the science of radiant skin.', 'lumea' ),
			'sanitize_callback' => 'sanitize_textarea_field',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		'lumea_blog_single_hero_subtitle',
		array(
			'label'   => esc_html__( 'Subtitle', 'lumea' ),
			'section' => 'lumea_hero_journal_post',
			'type'    => 'textarea',
		)
	);

	$wp_customize->add_section(
		'lumea_about',
		array(
			'title'    => esc_html__( 'About Page', 'lumea' ),
			'panel'    => 'lumea_theme',
			'priority' => 70,
		)
	);

	$about_controls = array(

		'lumea_about_hero_bg'        => array( 'image', __( 'Hero — Background Image', 'lumea' ), LUMEA_THEME_URI . '/assets/images/editorial-slide-3.jpg' ),
		'lumea_about_hero_label'     => array( 'text', __( 'Hero — Eyebrow Label', 'lumea' ), __( 'Est. 2018 · Paris', 'lumea' ) ),
		'lumea_about_hero_h1_1'      => array( 'text', __( 'Hero — Heading Line 1', 'lumea' ), __( 'Pure ritual.', 'lumea' ) ),
		'lumea_about_hero_h1_2'      => array( 'text', __( 'Hero — Heading Line 2 (outline)', 'lumea' ), __( 'Real results.', 'lumea' ) ),
		'lumea_about_hero_sub'       => array( 'textarea', __( 'Hero — Subtitle', 'lumea' ), __( 'Every Luméa formula begins with a single question — what does your skin truly need?', 'lumea' ) ),
		'lumea_about_hero_cta'       => array( 'text', __( 'Hero — CTA Button Text', 'lumea' ), __( 'Discover the Collection', 'lumea' ) ),
		'lumea_about_stat1_n'        => array( 'text', __( 'Stat 1 — Number', 'lumea' ), __( '48+', 'lumea' ) ),
		'lumea_about_stat1_l'        => array( 'text', __( 'Stat 1 — Label', 'lumea' ), __( 'Botanical actives', 'lumea' ) ),
		'lumea_about_stat2_n'        => array( 'text', __( 'Stat 2 — Number', 'lumea' ), __( '12', 'lumea' ) ),
		'lumea_about_stat2_l'        => array( 'text', __( 'Stat 2 — Label', 'lumea' ), __( 'Countries sourced', 'lumea' ) ),
		'lumea_about_stat3_n'        => array( 'text', __( 'Stat 3 — Number', 'lumea' ), __( '100%', 'lumea' ) ),
		'lumea_about_stat3_l'        => array( 'text', __( 'Stat 3 — Label', 'lumea' ), __( 'Clean formulas', 'lumea' ) ),
		'lumea_about_stat4_n'        => array( 'text', __( 'Stat 4 — Number', 'lumea' ), __( '2018', 'lumea' ) ),
		'lumea_about_stat4_l'        => array( 'text', __( 'Stat 4 — Label', 'lumea' ), __( 'Founded in Paris', 'lumea' ) ),

		'lumea_about_ticker'         => array( 'textarea', __( 'Ticker — Items (one per line)', 'lumea' ), __( "BOTANICAL PURITY\nSCIENTIFIC PRECISION\nMINDFUL LUXURY\nCLEAN BEAUTY\nCRUELTY FREE\nSINCE 2018", 'lumea' ) ),

		'lumea_about_manifesto_q'    => array( 'textarea', __( 'Manifesto — Quote', 'lumea' ), __( 'The most transformative skincare is the kind you actually look forward to. Not a routine — a ritual.', 'lumea' ) ),
		'lumea_about_manifesto_cite' => array( 'text', __( 'Manifesto — Attribution', 'lumea' ), __( 'Sophie Laurent, Founder & Cosmetic Chemist', 'lumea' ) ),

		'lumea_about_story_image'    => array( 'image', __( 'Story — Image', 'lumea' ), LUMEA_THEME_URI . '/assets/images/model-portrait.jpg' ),
		'lumea_about_story1_label'   => array( 'text', __( 'Story Panel 1 — Eyebrow', 'lumea' ), __( 'The Beginning', 'lumea' ) ),
		'lumea_about_story1_h2'      => array( 'text', __( 'Story Panel 1 — Heading', 'lumea' ), __( 'A skincare line rooted in botanical science', 'lumea' ) ),
		'lumea_about_story1_body'    => array( 'textarea', __( 'Story Panel 1 — Body', 'lumea' ), __( 'Luméa was born in a small Paris apartment, from years of frustration with formulas full of synthetic fillers and empty promises.', 'lumea' ) ),
		'lumea_about_story1_link'    => array( 'text', __( 'Story Panel 1 — Link Text', 'lumea' ), __( 'Explore formulas', 'lumea' ) ),
		'lumea_about_story2_label'   => array( 'text', __( 'Story Panel 2 — Eyebrow', 'lumea' ), __( 'Our Process', 'lumea' ) ),
		'lumea_about_story2_h2'      => array( 'text', __( 'Story Panel 2 — Heading', 'lumea' ), __( 'From field to formula', 'lumea' ) ),
		'lumea_about_story2_body1'   => array( 'textarea', __( 'Story Panel 2 — Body Paragraph 1', 'lumea' ), __( 'We partner directly with farmers and distilleries across twelve countries — from Bulgarian rose valleys to Japanese forest bathing reserves.', 'lumea' ) ),
		'lumea_about_story2_body2'   => array( 'textarea', __( 'Story Panel 2 — Body Paragraph 2', 'lumea' ), __( 'Every formula is stress-tested at the cellular level before it reaches you, with clinically measurable results visible within 28 days.', 'lumea' ) ),

		'lumea_about_values_bg'      => array( 'image', __( 'Values — Background Image', 'lumea' ), LUMEA_THEME_URI . '/assets/images/editorial-slide-2.jpg' ),
		'lumea_about_values_label'   => array( 'text', __( 'Values — Eyebrow', 'lumea' ), __( 'What We Stand For', 'lumea' ) ),
		'lumea_about_values_h2'      => array( 'text', __( 'Values — Heading', 'lumea' ), __( 'Three principles. Every decision.', 'lumea' ) ),
		'lumea_about_val1_h3'        => array( 'text', __( 'Value 1 — Title', 'lumea' ), __( 'Botanical Purity', 'lumea' ) ),
		'lumea_about_val1_p'         => array( 'textarea', __( 'Value 1 — Description', 'lumea' ), __( "We exclude over 1,400 controversial ingredients. If it isn't found in nature or proven safe by independent research, it doesn't enter our lab.", 'lumea' ) ),
		'lumea_about_val2_h3'        => array( 'text', __( 'Value 2 — Title', 'lumea' ), __( 'Scientific Precision', 'lumea' ) ),
		'lumea_about_val2_p'         => array( 'textarea', __( 'Value 2 — Description', 'lumea' ), __( 'Botanicals alone are not enough. Each formula is stress-tested at the cellular level to deliver clinically measurable results — visible within 28 days.', 'lumea' ) ),
		'lumea_about_val3_h3'        => array( 'text', __( 'Value 3 — Title', 'lumea' ), __( 'Mindful Luxury', 'lumea' ) ),
		'lumea_about_val3_p'         => array( 'textarea', __( 'Value 3 — Description', 'lumea' ), __( 'Premium should not cost the planet. We use ocean-bound glass packaging, carbon-neutral shipping, and donate 1% of every sale to reforestation.', 'lumea' ) ),

		'lumea_about_ing_label'      => array( 'text', __( 'Ingredients — Eyebrow', 'lumea' ), __( 'Ingredient Philosophy', 'lumea' ) ),
		'lumea_about_ing_h2'         => array( 'text', __( 'Ingredients — Heading', 'lumea' ), __( 'We believe in ingredients you can pronounce', 'lumea' ) ),
		'lumea_about_ing_body'       => array( 'textarea', __( 'Ingredients — Body', 'lumea' ), __( 'Our ingredient selection starts in the field, not the lab. We work backwards from the plant — understanding its native habitat, harvest season, and traditional therapeutic uses before evaluating its bioactive potential.', 'lumea' ) ),
		'lumea_about_ing_bullets'    => array( 'textarea', __( 'Ingredients — Bullet Points (one per line)', 'lumea' ), __( "No synthetic fragrance\nNo parabens or sulfates\nCruelty-free formulation standard\nSustainably sourced, traceable supply chain", 'lumea' ) ),
		'lumea_about_ing1_name'      => array( 'text', __( 'Ingredient 1 — Name', 'lumea' ), __( 'Bulgarian Rose Otto', 'lumea' ) ),
		'lumea_about_ing1_desc'      => array( 'textarea', __( 'Ingredient 1 — Description', 'lumea' ), __( 'Sourced from the Rose Valley at peak bloom. 3.5 tonnes of petals yield one kilogram of oil.', 'lumea' ) ),
		'lumea_about_ing2_name'      => array( 'text', __( 'Ingredient 2 — Name', 'lumea' ), __( 'Bakuchiol', 'lumea' ) ),
		'lumea_about_ing2_desc'      => array( 'textarea', __( 'Ingredient 2 — Description', 'lumea' ), __( "Nature's retinol alternative. Clinically proven to reduce fine lines without sensitivity.", 'lumea' ) ),
		'lumea_about_ing3_name'      => array( 'text', __( 'Ingredient 3 — Name', 'lumea' ), __( 'Snow Mushroom', 'lumea' ) ),
		'lumea_about_ing3_desc'      => array( 'textarea', __( 'Ingredient 3 — Description', 'lumea' ), __( 'Japanese forest extract. Holds 500× its weight in water — superior to hyaluronic acid.', 'lumea' ) ),

		'lumea_about_press_pubs'     => array( 'textarea', __( 'Press — Publications (one per line)', 'lumea' ), __( "The Beauty Edit\nModern Ritual\nSkin Journal\nThe Glow Report\nBotanical Living\nDaily Formulas\nThe Wellness Review", 'lumea' ) ),

		'lumea_about_cta_bg'         => array( 'image', __( 'CTA — Background Image', 'lumea' ), LUMEA_THEME_URI . '/assets/images/bestsellers/cta-bg.jpg' ),
		'lumea_about_cta_label'      => array( 'text', __( 'CTA — Eyebrow', 'lumea' ), __( 'Begin Your Ritual', 'lumea' ) ),
		'lumea_about_cta_h2'         => array( 'textarea', __( 'CTA — Heading (use newline for line break)', 'lumea' ), __( "Ready to meet\nyour skin's new favourites?", 'lumea' ) ),
		'lumea_about_cta_btn1'       => array( 'text', __( 'CTA — Primary Button Text', 'lumea' ), __( 'Shop All Products', 'lumea' ) ),
		'lumea_about_cta_btn2'       => array( 'text', __( 'CTA — Secondary Button Text', 'lumea' ), __( 'Get In Touch', 'lumea' ) ),
	);

	foreach ( $about_controls as $key => $cfg ) {
		list( $type, $label, $default ) = $cfg;

		$wp_customize->add_setting(
			$key,
			array(
				'default'           => $default,
				'sanitize_callback' => 'image' === $type
				? 'esc_url_raw'
				: ( 'textarea' === $type ? 'sanitize_textarea_field' : 'sanitize_text_field' ),
				'transport'         => 'refresh',
			)
		);

		if ( 'image' === $type ) {
			$wp_customize->add_control(
				new WP_Customize_Image_Control(
					$wp_customize,
					$key,
					array(
						'label'   => esc_html( $label ),
						'section' => 'lumea_about',
					)
				)
			);
		} elseif ( 'textarea' === $type ) {
			$wp_customize->add_control(
				$key,
				array(
					'label'   => esc_html( $label ),
					'section' => 'lumea_about',
					'type'    => 'textarea',
				)
			);
		} else {
			$wp_customize->add_control(
				$key,
				array(
					'label'   => esc_html( $label ),
					'section' => 'lumea_about',
					'type'    => 'text',
				)
			);
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
			'default'           => __( 'Bestseller', 'lumea' ),
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
			'default'           => __( 'Latest', 'lumea' ),
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
