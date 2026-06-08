<?php
/**
 * Template helper utilities.
 *
 * @package Lumea
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


function lumea_product_url( $setting_key ) {
	$custom = get_theme_mod( $setting_key, '' );
	if ( $custom ) {
		return esc_url( $custom );
	}
	return esc_url( class_exists( 'WooCommerce' ) ? wc_get_page_permalink( 'shop' ) : '#' );
}


function lma_lines( $str ) {
	return array_filter( array_map( 'trim', explode( "\n", $str ) ) );
}


function lumea_filter_url( $base, $params ) {
	$current = array_map( 'sanitize_text_field', wp_unslash( (array) $_GET ) ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended
	unset( $current['paged'], $current['page'] );
	$merged = array_merge( $current, $params );
	$merged = array_filter( $merged, function( $v ) { return $v !== ''; } );
	return esc_url( add_query_arg( $merged, $base ) );
}
