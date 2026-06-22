<?php
/**
 * Template helper utilities.
 *
 * @package Lumea
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


function lumea_get_shop_url() {
	if ( function_exists( 'wc_get_page_permalink' ) ) {
		$shop_url = wc_get_page_permalink( 'shop' );
		if ( $shop_url ) {
			return $shop_url;
		}
	}

	return home_url( '/shop/' );
}


function lumea_get_cart_url() {
	if ( function_exists( 'wc_get_cart_url' ) ) {
		$cart_url = wc_get_cart_url();
		if ( $cart_url ) {
			return $cart_url;
		}
	}

	return home_url( '/cart/' );
}


function lumea_get_checkout_url() {
	if ( function_exists( 'wc_get_checkout_url' ) ) {
		$checkout_url = wc_get_checkout_url();
		if ( $checkout_url ) {
			return $checkout_url;
		}
	}

	return home_url( '/checkout/' );
}


function lumea_get_myaccount_url() {
	if ( function_exists( 'wc_get_page_permalink' ) ) {
		$account_url = wc_get_page_permalink( 'myaccount' );
		if ( $account_url ) {
			return $account_url;
		}
	}

	return wp_login_url();
}


function lumea_get_wishlist_url() {
	$page = get_page_by_path( 'wishlist', OBJECT, 'page' );
	if ( $page ) {
		return get_permalink( $page );
	}

	return home_url( '/wishlist/' );
}


function lumea_product_url( $setting_key ) {
	$custom = get_theme_mod( $setting_key, '' );
	if ( $custom ) {
		return esc_url( $custom );
	}
	return esc_url( lumea_get_shop_url() );
}


function lumea_lines( $str ) {
	return array_filter( array_map( 'trim', explode( "\n", $str ) ) );
}

function lumea_get_page_by_title( $title ) {
	$pages = get_posts( array(
		'post_type'      => 'page',
		'title'          => $title,
		'posts_per_page' => 1,
		'no_found_rows'  => true,
		'orderby'        => 'post_date',
		'order'          => 'ASC',
	) );
	return ! empty( $pages ) ? $pages[0] : null;
}


function lumea_filter_url( $base, $params ) {
	$current = array_map( 'sanitize_text_field', wp_unslash( (array) $_GET ) ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended
	unset( $current['paged'], $current['page'] );
	$merged = array_merge( $current, $params );
	$merged = array_filter( $merged, function( $v ) { return $v !== ''; } );
	return esc_url( add_query_arg( $merged, $base ) );
}
