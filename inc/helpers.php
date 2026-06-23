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
		return esc_url_raw( $custom );
	}
	return lumea_get_shop_url();
}


function lumea_lines( $str ) {
	return array_filter( array_map( 'trim', explode( "\n", $str ) ) );
}

/**
 * Format a numeric or legacy currency-string value using WooCommerce settings.
 *
 * @param mixed $value Price value.
 * @return string
 */
function lumea_format_price_value( $value ) {
	if ( '' === $value || null === $value ) {
		return '';
	}

	$plain = html_entity_decode( wp_strip_all_tags( (string) $value ), ENT_QUOTES, get_bloginfo( 'charset' ) );
	$plain = preg_replace( '/[^0-9,.\-]/', '', $plain );

	if ( function_exists( 'wc_format_decimal' ) && function_exists( 'wc_price' ) ) {
		$amount = wc_format_decimal( $plain );
		return '' !== $amount ? wc_price( $amount ) : '';
	}

	return sanitize_text_field( (string) $value );
}

function lumea_get_page_by_title( $title ) {
	$pages = get_posts(
		array(
			'post_type'      => 'page',
			'title'          => $title,
			'posts_per_page' => 1,
			'no_found_rows'  => true,
			'orderby'        => 'post_date',
			'order'          => 'ASC',
		)
	);
	return ! empty( $pages ) ? $pages[0] : null;
}

/**
 * Return a page URL by path with a local fallback.
 *
 * @param string $path Page path.
 * @return string
 */
function lumea_get_page_url( $path ) {
	$page = get_page_by_path( sanitize_title( $path ) );
	if ( $page ) {
		return get_permalink( $page );
	}

	return home_url( '/' . trim( $path, '/' ) . '/' );
}

/**
 * Return the default navigation links used before a menu is assigned.
 *
 * @return array
 */
function lumea_get_default_navigation_links() {
	$shop_url       = lumea_get_shop_url();
	$blog_page_id   = (int) get_option( 'page_for_posts' );
	$blog_url       = $blog_page_id ? get_permalink( $blog_page_id ) : lumea_get_page_url( 'blog' );
	$bestseller_url = $shop_url;

	if ( taxonomy_exists( 'product_cat' ) ) {
		$bestseller_term = get_term_by( 'slug', 'bestseller', 'product_cat' );
		if ( ! $bestseller_term ) {
			$bestseller_term = get_term_by( 'name', 'Bestseller', 'product_cat' );
		}

		if ( $bestseller_term ) {
			$term_link = get_term_link( $bestseller_term );
			if ( ! is_wp_error( $term_link ) ) {
				$bestseller_url = $term_link;
			}
		}
	}

	return array(
		array(
			'label' => __( 'Home', 'lumea' ),
			'url'   => home_url( '/' ),
		),
		array(
			'label' => __( 'Shop', 'lumea' ),
			'url'   => $shop_url,
		),
		array(
			'label' => __( 'Bestsellers', 'lumea' ),
			'url'   => $bestseller_url,
		),
		array(
			'label' => __( 'Blog', 'lumea' ),
			'url'   => $blog_url,
		),
		array(
			'label' => __( 'About', 'lumea' ),
			'url'   => lumea_get_page_url( 'about' ),
		),
		array(
			'label' => __( 'Contact', 'lumea' ),
			'url'   => lumea_get_page_url( 'contact' ),
		),
	);
}


/**
 * Find the first usable image in post content.
 *
 * Featured images remain the preferred source for archive cards. This helper
 * provides a graceful fallback for posts that only contain an Image or Cover
 * block in their article content.
 *
 * @param int $post_id Post ID.
 * @return array{attachment_id:int,url:string}
 */
function lumea_get_first_post_content_image( $post_id ) {
	$content = (string) get_post_field( 'post_content', $post_id );
	$result  = array(
		'attachment_id' => 0,
		'url'           => '',
	);

	if ( '' === trim( $content ) ) {
		return $result;
	}

	$find_image = static function ( $blocks ) use ( &$find_image ) {
		foreach ( $blocks as $block ) {
			$block_name = isset( $block['blockName'] ) ? $block['blockName'] : '';
			$attrs      = isset( $block['attrs'] ) && is_array( $block['attrs'] ) ? $block['attrs'] : array();

			if ( in_array( $block_name, array( 'core/image', 'core/cover', 'core/media-text' ), true ) ) {
				$attachment_id = isset( $attrs['id'] ) ? absint( $attrs['id'] ) : 0;
				$image_url     = isset( $attrs['url'] ) ? esc_url_raw( $attrs['url'] ) : '';

				if ( $attachment_id || $image_url ) {
					return array(
						'attachment_id' => $attachment_id,
						'url'           => $image_url,
					);
				}
			}

			if ( ! empty( $block['innerHTML'] ) && preg_match( '/<img[^>]+src=["\']([^"\']+)["\']/i', $block['innerHTML'], $matches ) ) {
				$attachment_id = 0;
				if ( preg_match( '/wp-image-([0-9]+)/', $block['innerHTML'], $id_matches ) ) {
					$attachment_id = absint( $id_matches[1] );
				}

				return array(
					'attachment_id' => $attachment_id,
					'url'           => esc_url_raw( html_entity_decode( $matches[1] ) ),
				);
			}

			if ( ! empty( $block['innerBlocks'] ) ) {
				$nested_result = $find_image( $block['innerBlocks'] );
				if ( ! empty( $nested_result['attachment_id'] ) || ! empty( $nested_result['url'] ) ) {
					return $nested_result;
				}
			}
		}

		return array(
			'attachment_id' => 0,
			'url'           => '',
		);
	};

	$result = $find_image( parse_blocks( $content ) );

	if ( ! $result['attachment_id'] && ! $result['url'] && preg_match( '/<img[^>]+src=["\']([^"\']+)["\']/i', $content, $matches ) ) {
		$result['url'] = esc_url_raw( html_entity_decode( $matches[1] ) );
	}

	return $result;
}


/**
 * Return an archive-card image, falling back to the first article image.
 *
 * @param int          $post_id Post ID.
 * @param string|int[] $size    Registered image size or dimensions.
 * @param array        $attr    Image attributes.
 * @return string
 */
function lumea_get_post_card_image( $post_id, $size = 'medium_large', $attr = array() ) {
	$post_id = absint( $post_id );
	$attr    = wp_parse_args(
		$attr,
		array(
			'class'   => 'lumea-blog-card-img',
			'loading' => 'lazy',
		)
	);

	if ( has_post_thumbnail( $post_id ) ) {
		return get_the_post_thumbnail( $post_id, $size, $attr );
	}

	$content_image = lumea_get_first_post_content_image( $post_id );
	if ( $content_image['attachment_id'] ) {
		return wp_get_attachment_image( $content_image['attachment_id'], $size, false, $attr );
	}

	if ( $content_image['url'] ) {
		$attributes = '';
		$attr       = array_merge(
			array(
				'src' => $content_image['url'],
				'alt' => get_the_title( $post_id ),
			),
			$attr
		);

		foreach ( $attr as $name => $value ) {
			$attributes .= sprintf( ' %s="%s"', esc_attr( $name ), esc_attr( $value ) );
		}

		return '<img' . $attributes . '>';
	}

	return '';
}

/**
 * Render navigation links when no menu has been assigned to a location.
 *
 * @param array $args Menu display arguments.
 * @return void
 */
function lumea_nav_menu_fallback( $args ) {
	$menu_class = ! empty( $args['menu_class'] ) ? $args['menu_class'] : 'menu';

	echo '<ul class="' . esc_attr( $menu_class ) . '">';
	foreach ( lumea_get_default_navigation_links() as $link ) {
		echo '<li><a href="' . esc_url( $link['url'] ) . '">' . esc_html( $link['label'] ) . '</a></li>';
	}
	echo '</ul>';
}


function lumea_filter_url( $base, $params ) {
	$current = array();
	$query   = wp_unslash( (array) $_GET ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended
	foreach ( $query as $key => $value ) {
		if ( is_scalar( $value ) ) {
			$current[ sanitize_key( $key ) ] = sanitize_text_field( (string) $value );
		}
	}
	unset( $current['paged'], $current['page'] );
	$merged = array_merge( $current, $params );
	$merged = array_filter(
		$merged,
		function ( $v ) {
			return '' !== $v;
		}
	);
	return add_query_arg( $merged, $base );
}
