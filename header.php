<?php
/**
 * Header template.
 *
 * @package Lumea
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<!-- Sticky Header -->
<header class="lumea-header" id="lumeaHeader" role="banner">
	<div class="lumea-header-inner">

		<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="lumea-header-logo">LUMÉA</a>

		<nav class="lumea-header-nav" aria-label="<?php esc_attr_e( 'Primary navigation', 'lumea' ); ?>">
			<?php
			wp_nav_menu( array(
				'theme_location' => 'primary',
				'container'      => false,
				'menu_class'     => 'lumea-nav-list',
				'fallback_cb'    => function() {
					$shop_url    = function_exists( 'wc_get_page_id' ) && wc_get_page_id( 'shop' ) ? get_permalink( wc_get_page_id( 'shop' ) ) : home_url( '/shop/' );
					$blog_url    = get_option( 'page_for_posts' ) ? get_permalink( get_option( 'page_for_posts' ) ) : home_url( '/blog/' );
					$about_page  = get_page_by_path( 'about' );
					$about_url   = $about_page ? get_permalink( $about_page ) : home_url( '/about/' );
					$contact_page = get_page_by_path( 'contact' );
					$contact_url  = $contact_page ? get_permalink( $contact_page ) : home_url( '/contact/' );
					echo '<ul class="lumea-nav-list">';
					$links = array(
						array( esc_html__( 'Shop',       'lumea' ), $shop_url ),
						array( esc_html__( 'Bestsellers','lumea' ), home_url( '/#lumeaBest' ) ),
						array( esc_html__( 'Blog',       'lumea' ), $blog_url ),
						array( esc_html__( 'About',      'lumea' ), $about_url ),
						array( esc_html__( 'Contact',    'lumea' ), $contact_url ),
					);
					foreach ( $links as $l ) {
						echo '<li><a href="' . esc_url( $l[1] ) . '">' . $l[0] . '</a></li>';
					}
					echo '</ul>';
				},
			) );
			?>
		</nav>

		<div class="lumea-header-actions">
			<?php if ( class_exists( 'WooCommerce' ) ) : ?>
			<button class="lumea-cart-trigger" aria-label="<?php esc_attr_e( 'Open cart', 'lumea' ); ?>" data-lumea-cart-trigger>
				<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 01-8 0"/></svg>
				<span class="lumea-cart-count<?php echo WC()->cart->get_cart_contents_count() ? ' lumea-cart-count--visible' : ''; ?>"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
			</button>
			<?php endif; ?>
			<button class="lumea-nav-toggle" aria-label="<?php esc_attr_e( 'Open menu', 'lumea' ); ?>" aria-expanded="false" aria-controls="lumeaMobileNav" data-lumea-nav-toggle>
				<span class="lumea-nav-toggle-bar"></span>
				<span class="lumea-nav-toggle-bar"></span>
			</button>
		</div>

	</div>
</header>

<!-- Mobile Nav -->
<div class="lumea-mobile-nav" id="lumeaMobileNav" aria-hidden="true" data-lumea-mobile-nav>
	<div class="lumea-mobile-nav-inner">
		<nav aria-label="<?php esc_attr_e( 'Mobile navigation', 'lumea' ); ?>">
			<?php
			wp_nav_menu( array(
				'theme_location' => 'primary',
				'container'      => false,
				'menu_class'     => 'lumea-mobile-nav-list',
				'fallback_cb'    => function() {
					$shop_url    = function_exists( 'wc_get_page_id' ) && wc_get_page_id( 'shop' ) ? get_permalink( wc_get_page_id( 'shop' ) ) : home_url( '/shop/' );
					$blog_url    = get_option( 'page_for_posts' ) ? get_permalink( get_option( 'page_for_posts' ) ) : home_url( '/blog/' );
					$about_page  = get_page_by_path( 'about' );
					$about_url   = $about_page ? get_permalink( $about_page ) : home_url( '/about/' );
					$contact_page = get_page_by_path( 'contact' );
					$contact_url  = $contact_page ? get_permalink( $contact_page ) : home_url( '/contact/' );
					echo '<ul class="lumea-mobile-nav-list">';
					$links = array(
						array( esc_html__( 'Shop',       'lumea' ), $shop_url ),
						array( esc_html__( 'Bestsellers','lumea' ), home_url( '/#lumeaBest' ) ),
						array( esc_html__( 'Blog',       'lumea' ), $blog_url ),
						array( esc_html__( 'About',      'lumea' ), $about_url ),
						array( esc_html__( 'Contact',    'lumea' ), $contact_url ),
					);
					foreach ( $links as $l ) {
						echo '<li><a href="' . esc_url( $l[1] ) . '">' . $l[0] . '</a></li>';
					}
					echo '</ul>';
				},
			) );
			?>
		</nav>
	</div>
</div>
