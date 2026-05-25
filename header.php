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

<header class="lumea-site-header" role="banner">
	<div class="lumea-container lumea-header-inner">

		<!-- Logo -->
		<a class="lumea-logo-text"
		   href="<?php echo esc_url( home_url( '/' ) ); ?>"
		   aria-label="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?> — <?php esc_attr_e( 'Home', 'lumea' ); ?>">
			<?php bloginfo( 'name' ); ?>
		</a>

		<!-- Primary Navigation -->
		<nav class="lumea-site-nav" aria-label="<?php esc_attr_e( 'Primary navigation', 'lumea' ); ?>">
			<a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>"
			   class="lumea-nav-link">
				<?php esc_html_e( 'Shop', 'lumea' ); ?>
			</a>
			<a href="<?php echo esc_url( get_permalink( get_page_by_path( 'collections' ) ) ?: wc_get_page_permalink( 'shop' ) ); ?>"
			   class="lumea-nav-link">
				<?php esc_html_e( 'Collections', 'lumea' ); ?>
			</a>
			<a href="<?php echo esc_url( get_permalink( get_page_by_path( 'ingredients' ) ) ?: home_url( '/ingredients/' ) ); ?>"
			   class="lumea-nav-link">
				<?php esc_html_e( 'Ingredients', 'lumea' ); ?>
			</a>
			<a href="<?php echo esc_url( get_permalink( get_page_by_path( 'about' ) ) ?: home_url( '/about/' ) ); ?>"
			   class="lumea-nav-link">
				<?php esc_html_e( 'About', 'lumea' ); ?>
			</a>
		</nav>

		<!-- Header Actions -->
		<div class="lumea-header-actions">
			<!-- Search -->
			<a href="<?php echo esc_url( get_search_link() ); ?>"
			   class="lumea-header-icon-btn"
			   aria-label="<?php esc_attr_e( 'Search', 'lumea' ); ?>">
				<svg width="18" height="18" viewBox="0 0 24 24" fill="none"
				     stroke="currentColor" stroke-width="1.5" aria-hidden="true">
					<circle cx="11" cy="11" r="8"/>
					<path d="m21 21-4.35-4.35"/>
				</svg>
			</a>

			<!-- Account -->
			<a href="<?php echo esc_url( class_exists( 'WooCommerce' ) ? wc_get_page_permalink( 'myaccount' ) : wp_login_url() ); ?>"
			   class="lumea-header-icon-btn"
			   aria-label="<?php esc_attr_e( 'My account', 'lumea' ); ?>">
				<svg width="18" height="18" viewBox="0 0 24 24" fill="none"
				     stroke="currentColor" stroke-width="1.5" aria-hidden="true">
					<circle cx="12" cy="8" r="4"/>
					<path d="M4 20c0-4 3.582-7 8-7s8 3 8 7"/>
				</svg>
			</a>

			<!-- Cart -->
			<?php if ( class_exists( 'WooCommerce' ) ) : ?>
				<a href="<?php echo esc_url( wc_get_cart_url() ); ?>"
				   class="lumea-header-icon-btn"
				   aria-label="<?php
					$lumea_cart_count = WC()->cart ? WC()->cart->get_cart_contents_count() : 0;
					echo esc_attr(
						sprintf(
							_n( 'Cart — %d item', 'Cart — %d items', $lumea_cart_count, 'lumea' ),
							$lumea_cart_count
						)
					);
					?>">
					<svg width="18" height="18" viewBox="0 0 24 24" fill="none"
					     stroke="currentColor" stroke-width="1.5" aria-hidden="true">
						<path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/>
						<line x1="3" y1="6" x2="21" y2="6"/>
						<path d="M16 10a4 4 0 0 1-8 0"/>
					</svg>
					<?php if ( $lumea_cart_count > 0 ) : ?>
						<span style="position:absolute;top:6px;right:6px;width:8px;height:8px;border-radius:50%;background:var(--lumea-accent);font-size:0;"
						      aria-hidden="true"></span>
					<?php endif; ?>
				</a>
			<?php endif; ?>

			<!-- Mobile menu toggle -->
			<button class="lumea-mobile-menu-btn"
			        aria-label="<?php esc_attr_e( 'Open menu', 'lumea' ); ?>"
			        aria-expanded="false"
			        aria-controls="lumea-mobile-nav">
				<span></span>
				<span></span>
				<span></span>
			</button>
		</div>
	</div>
</header>

<!-- Mobile Navigation -->
<nav id="lumea-mobile-nav"
     class="lumea-mobile-nav"
     aria-label="<?php esc_attr_e( 'Mobile navigation', 'lumea' ); ?>"
     aria-hidden="true">
	<a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>"
	   class="lumea-nav-link">
		<?php esc_html_e( 'Shop', 'lumea' ); ?>
	</a>
	<a href="<?php echo esc_url( get_permalink( get_page_by_path( 'collections' ) ) ?: wc_get_page_permalink( 'shop' ) ); ?>"
	   class="lumea-nav-link">
		<?php esc_html_e( 'Collections', 'lumea' ); ?>
	</a>
	<a href="<?php echo esc_url( get_permalink( get_page_by_path( 'ingredients' ) ) ?: home_url( '/ingredients/' ) ); ?>"
	   class="lumea-nav-link">
		<?php esc_html_e( 'Ingredients', 'lumea' ); ?>
	</a>
	<a href="<?php echo esc_url( get_permalink( get_page_by_path( 'about' ) ) ?: home_url( '/about/' ) ); ?>"
	   class="lumea-nav-link">
		<?php esc_html_e( 'About', 'lumea' ); ?>
	</a>
</nav>

<main class="lumea-site-main" id="main-content">
