<?php
/**
 * One Click Demo Import (OCDI) integration for Luméa.
 *
 * Registers the demo content pack and wires up the after-import callback that
 * sets the front page, blog page, permalink structure, nav menus, WooCommerce
 * page IDs, and key theme mods so the site matches the live preview immediately
 * after a one-click import.
 *
 * @package Lumea
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


add_filter( 'ocdi/import_files', 'lumea_ocdi_import_files' );
function lumea_ocdi_import_files() {
	return array(
		array(
			'import_file_name'             => __( 'Luméa Main Demo', 'lumea' ),
			'local_import_file'            => LUMEA_THEME_DIR . '/demo-import/content.xml',
			'local_import_widget_file'     => LUMEA_THEME_DIR . '/demo-import/widgets.wie',
			'local_import_customizer_file' => LUMEA_THEME_DIR . '/demo-import/customizer.dat',
			'import_preview_image_url'     => LUMEA_THEME_URI . '/screenshot.png',
			'import_notice'               => __( 'Import takes 1–2 minutes — please do not navigate away. Demo images are placeholders. Replace them with your own licensed photography before going live.', 'lumea' ),
			'preview_url'                  => 'https://themeforest.net/user/shivdutt/portfolio',
		),
	);
}


add_action( 'ocdi/after_import', 'lumea_ocdi_after_import' );
function lumea_ocdi_after_import() {
	lumea_ocdi_set_reading_options();
	lumea_ocdi_set_permalink();
	lumea_ocdi_create_menus();
	lumea_ocdi_set_wc_pages();
	lumea_ocdi_set_theme_mods();
}


function lumea_ocdi_set_reading_options() {
	$front_page = lumea_get_page_by_title( 'Home' );
	$blog_page  = lumea_get_page_by_title( 'Blog' );

	if ( $front_page ) {
		update_option( 'show_on_front', 'page' );
		update_option( 'page_on_front', $front_page->ID );
	}
	if ( $blog_page ) {
		update_option( 'page_for_posts', $blog_page->ID );
	}
}


function lumea_ocdi_set_permalink() {
	if ( '' === get_option( 'permalink_structure' ) ) {
		update_option( 'permalink_structure', '/%postname%/' );
		flush_rewrite_rules();
	}
}


function lumea_ocdi_create_menus() {
	$menu_defs = array(
		'Primary Menu' => array(
			'location' => 'primary',
			'pages'    => array(
				array( 'slug' => 'shop',        'label' => __( 'Shop', 'lumea' ) ),
				array( 'slug' => 'ingredients', 'label' => __( 'Ingredients', 'lumea' ) ),
				array( 'slug' => 'bundles',     'label' => __( 'Bundles', 'lumea' ) ),
				array( 'slug' => 'about',       'label' => __( 'About', 'lumea' ) ),
				array( 'slug' => 'blog',        'label' => __( 'Journal', 'lumea' ) ),
			),
		),
		'Footer Menu'  => array(
			'location' => 'footer',
			'pages'    => array(
				array( 'slug' => 'shipping-returns', 'label' => __( 'Shipping & Returns', 'lumea' ) ),
				array( 'slug' => 'ingredients',      'label' => __( 'Our Ingredients', 'lumea' ) ),
				array( 'slug' => 'faq',              'label' => __( 'FAQ', 'lumea' ) ),
				array( 'slug' => 'privacy-policy',   'label' => __( 'Privacy Policy', 'lumea' ) ),
				array( 'slug' => 'contact',          'label' => __( 'Contact', 'lumea' ) ),
			),
		),
	);

	$locations = array();

	foreach ( $menu_defs as $menu_name => $def ) {
		$existing = get_term_by( 'name', $menu_name, 'nav_menu' );
		$menu_id  = $existing ? $existing->term_id : wp_create_nav_menu( $menu_name );

		if ( is_wp_error( $menu_id ) ) {
			continue;
		}

		$position = 1;
		foreach ( $def['pages'] as $page_def ) {
			$page = get_page_by_path( $page_def['slug'] );
			if ( ! $page ) {
				$page = lumea_get_page_by_title( $page_def['label'] );
			}
			if ( ! $page ) {
				continue;
			}
			wp_update_nav_menu_item(
				$menu_id,
				0,
				array(
					'menu-item-title'     => $page_def['label'],
					'menu-item-object'    => 'page',
					'menu-item-object-id' => $page->ID,
					'menu-item-type'      => 'post_type',
					'menu-item-position'  => $position,
					'menu-item-status'    => 'publish',
				)
			);
			$position++;
		}

		$locations[ $def['location'] ] = $menu_id;
	}

	set_theme_mod( 'nav_menu_locations', $locations );
}


function lumea_ocdi_set_wc_pages() {
	if ( ! class_exists( 'WooCommerce' ) ) {
		return;
	}

	$wc_page_map = array(
		'woocommerce_shop_page_id'      => array( 'shop',       'Shop' ),
		'woocommerce_cart_page_id'      => array( 'cart',       'Cart' ),
		'woocommerce_checkout_page_id'  => array( 'checkout',   'Checkout' ),
		'woocommerce_myaccount_page_id' => array( 'my-account', 'My Account' ),
	);

	foreach ( $wc_page_map as $option => $slugs ) {
		$page = get_page_by_path( $slugs[0] ) ?: lumea_get_page_by_title( $slugs[1] );
		if ( $page ) {
			update_option( $option, $page->ID );
		}
	}
}


function lumea_ocdi_set_theme_mods() {
	$defaults = array(
		'lumea_footer_headline'         => __( 'Your Ritual Starts Here', 'lumea' ),
		'lumea_footer_cta_text'         => __( 'Shop the Collection', 'lumea' ),
		/* translators: %1$s is replaced with the four-digit current year */
		'lumea_footer_copyright'        => __( '© {year} Luméa Skincare. All rights reserved.', 'lumea' ),
		'lumea_hero_cta_text'           => __( 'Discover the Collection', 'lumea' ),
		'lumea_free_shipping_threshold' => '$75',
		'lumea_bestsellers_eyebrow'     => __( 'Our Best', 'lumea' ),
		'lumea_bestsellers_title'       => __( 'Bestsellers', 'lumea' ),
		'lumea_bestsellers_cat'         => 'bestseller',
	);

	foreach ( $defaults as $key => $value ) {
		if ( false === get_theme_mod( $key ) ) {
			set_theme_mod( $key, $value );
		}
	}
}


add_filter( 'ocdi/plugin_intro_text', '__return_empty_string' );


add_action( 'ocdi/before_content_import_execution', 'lumea_ocdi_extend_time_limit' );
function lumea_ocdi_extend_time_limit() {
	if ( function_exists( 'set_time_limit' ) ) {
		set_time_limit( 300 );
	}
}
