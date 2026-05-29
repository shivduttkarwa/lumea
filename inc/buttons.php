<?php
/**
 * Lumea reusable button component.
 *
 * Usage:
 *   lumea_btn( array(
 *     'label' => 'Shop Now',
 *     'href'  => get_permalink(),
 *     'style' => 'dark',        // dark | black | white | outline | soft | accent | arrow-right | arrow-left
 *     'tag'   => 'a',           // a | button
 *     'class' => '',            // additional classes
 *     'attrs' => array(),       // extra HTML attributes as key => value pairs
 *     'echo'  => true,          // false to return HTML string instead
 *   ) );
 *
 * @package Lumea
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Render or return a Lumea button.
 *
 * @param array $args Button arguments.
 * @return string|void HTML string when echo is false.
 */
function lumea_btn( $args = array() ) {
	$defaults = array(
		'label' => '',
		'href'  => '#',
		'style' => 'dark',
		'tag'   => 'a',
		'class' => '',
		'attrs' => array(),
		'echo'  => true,
	);
	$args = wp_parse_args( $args, $defaults );

	$valid_styles = array( 'dark', 'black', 'white', 'outline', 'soft', 'accent', 'arrow-right', 'arrow-left' );
	$style        = in_array( $args['style'], $valid_styles, true ) ? $args['style'] : 'dark';
	$tag          = in_array( $args['tag'], array( 'a', 'button' ), true ) ? $args['tag'] : 'a';
	$label        = esc_html( $args['label'] );
	$extra_cls    = $args['class'] ? ' ' . sanitize_text_field( $args['class'] ) : '';

	// Build modifier classes (with aliases for backwards compatibility).
	$style_class_map = array(
		'dark'        => 'btn-dark btn-black',
		'black'       => 'btn-black btn-dark',
		'white'       => 'btn-white',
		'outline'     => 'btn-outline',
		'soft'        => 'btn-soft',
		'accent'      => 'btn-accent',
		'arrow-right' => 'btn-arrow btn-arrow-right',
		'arrow-left'  => 'btn-arrow btn-arrow-left',
	);
	$modifier = isset( $style_class_map[ $style ] ) ? $style_class_map[ $style ] : 'btn-dark btn-black';

	// Build attributes
	$attr_str = '';
	if ( 'a' === $tag ) {
		$attr_str .= ' href="' . esc_url( $args['href'] ) . '"';
	} else {
		$attr_str .= ' type="button"';
	}
	if ( is_array( $args['attrs'] ) ) {
		foreach ( $args['attrs'] as $key => $val ) {
			$attr_str .= ' ' . sanitize_key( $key ) . '="' . esc_attr( $val ) . '"';
		}
	}

	// Arrow SVG icons
	$arrow_right_svg = '<svg viewBox="0 0 24 24" fill="none" aria-hidden="true">'
		. '<path d="M5 12H19"/>'
		. '<path d="M13 6L19 12L13 18"/>'
		. '</svg>';

	$arrow_left_svg = '<svg viewBox="0 0 24 24" fill="none" aria-hidden="true">'
		. '<path d="M19 12H5"/>'
		. '<path d="M11 6L5 12L11 18"/>'
		. '</svg>';

	// Build inner content
	$inner = '';
	if ( 'arrow-left' === $style ) {
		$inner = $arrow_left_svg . $label;
	} elseif ( 'arrow-right' === $style ) {
		$inner = $label . $arrow_right_svg;
	} else {
		$inner = $label;
	}

	$html = sprintf(
		'<%1$s class="lumea-btn %2$s%3$s"%4$s>%5$s</%1$s>',
		$tag,
		esc_attr( $modifier ),
		$extra_cls,
		$attr_str,
		$inner
	);

	if ( $args['echo'] ) {
		echo $html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		return;
	}

	return $html;
}
