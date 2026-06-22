<?php
/**
 * Theme setup.
 *
 * @package Lumea
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! isset( $content_width ) ) {
	$content_width = 1200;
}


function lumea_theme_setup() {

	
	load_theme_textdomain( 'lumea', get_template_directory() . '/languages' );

	
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'align-wide' );
	add_theme_support( 'wp-block-styles' );

	
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 80,
			'width'       => 220,
			'flex-height' => true,
			'flex-width'  => true,
		)
	);

	
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	
	add_theme_support(
		'woocommerce',
		array(
			'thumbnail_image_width' => 600,
			'single_image_width'    => 900,
			'product_grid'          => array(
				'default_rows'    => 4,
				'min_rows'        => 2,
				'max_rows'        => 8,
				'default_columns' => 4,
				'min_columns'     => 2,
				'max_columns'     => 5,
			),
		)
	);


	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );


	add_theme_support( 'post-formats', array( 'aside', 'gallery', 'quote', 'image', 'video' ) );


	add_editor_style( 'assets/css/editor-style.css' );

	
	register_nav_menus(
		array(
			'primary' => esc_html__( 'Primary Menu', 'lumea' ),
			'footer'  => esc_html__( 'Footer Menu', 'lumea' ),
		)
	);
}
add_action( 'after_setup_theme', 'lumea_theme_setup' );


function lumea_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'lumea' ),
			'id'            => 'lumea-sidebar',
			'description'   => esc_html__( 'Widgets in this area appear in the blog sidebar.', 'lumea' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);

	register_sidebar(
		array(
			'name'          => esc_html__( 'Footer Column', 'lumea' ),
			'id'            => 'lumea-footer',
			'description'   => esc_html__( 'Widgets in this area appear in the footer.', 'lumea' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'lumea_widgets_init' );


function lumea_about_body_class( $classes ) {
	if ( is_page_template( 'page-about.php' ) || is_page( 'about' ) ) {
		$classes[] = 'lumea-about-template';
	}
	return $classes;
}
add_filter( 'body_class', 'lumea_about_body_class' );
