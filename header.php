<?php
/**
 * Header template.
 *
 * @package Lumea
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$lumea_wishlist_page = get_page_by_path( 'wishlist' );
$lumea_wishlist_url  = $lumea_wishlist_page ? get_permalink( $lumea_wishlist_page ) : home_url( '/wishlist/' );
$lumea_contact_page  = get_page_by_path( 'contact' );
$lumea_contact_url   = $lumea_contact_page ? get_permalink( $lumea_contact_page ) : home_url( '/contact/' );
$lumea_has_wc        = class_exists( 'WooCommerce' );
$lumea_is_logged_in  = is_user_logged_in();

$lumea_account_url = $lumea_has_wc ? wc_get_page_permalink( 'myaccount' ) : wp_login_url();

if ( ! $lumea_account_url ) {
	$lumea_account_url = home_url( '/my-account/' );
}

$lumea_orders_url = $lumea_has_wc ? wc_get_account_endpoint_url( 'orders' ) : $lumea_account_url;
$lumea_details_url = $lumea_has_wc ? wc_get_account_endpoint_url( 'edit-account' ) : $lumea_account_url;
$lumea_addresses_url = $lumea_has_wc ? wc_get_account_endpoint_url( 'edit-address' ) : $lumea_account_url;
$lumea_bag_url = $lumea_has_wc ? wc_get_cart_url() : home_url( '/cart/' );

$lumea_register_url = $lumea_account_url;
if ( $lumea_has_wc ) {
	$lumea_register_url = add_query_arg( 'register', '1', $lumea_account_url ) . '#lumeaRegisterCard';
} elseif ( ! $lumea_has_wc ) {
	$lumea_register_url = wp_registration_url();
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
	<div class="lumea-header-inner container-fluid px-3 px-sm-4 px-lg-5">
		<div class="row w-100 g-0 align-items-center">
			<div class="col-6 col-lg-3">

		<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="lumea-header-logo">LUMÉA</a>
			</div>

			<div class="d-none d-lg-flex col-lg-6 justify-content-center">
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
			</div>

			<div class="col-6 col-lg-3">
		<div class="lumea-header-actions d-flex align-items-center justify-content-end">

			<!-- Search -->
			<button class="lumea-header-icon-btn" aria-label="<?php esc_attr_e( 'Search', 'lumea' ); ?>" data-lumea-search-trigger>
				<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
			</button>

			<!-- Account -->
			<div class="lumea-account-wrap" data-lumea-account-wrap>
				<button class="lumea-header-icon-btn" aria-label="<?php esc_attr_e( 'My account', 'lumea' ); ?>" aria-expanded="false" aria-haspopup="true" aria-controls="lumeaAccountDropdown" data-lumea-account-trigger>
					<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
				</button>
				<div class="lumea-account-dropdown" id="lumeaAccountDropdown" aria-hidden="true" data-lumea-account-dropdown>
					<div class="lumea-account-panel">
						<p class="lumea-account-panel-eyebrow"><?php esc_html_e( 'Welcome', 'lumea' ); ?></p>

						<?php if ( $lumea_is_logged_in ) : ?>
						<?php $lumea_user = wp_get_current_user(); ?>
						<p class="lumea-account-panel-text">
							<?php
							printf(
								/* translators: %s: customer first name. */
								esc_html__( 'Hi %s, manage your profile and orders.', 'lumea' ),
								esc_html( $lumea_user->first_name ? $lumea_user->first_name : $lumea_user->display_name )
							);
							?>
						</p>
						<a href="<?php echo esc_url( $lumea_account_url ); ?>" class="lumea-account-panel-cta"><?php esc_html_e( 'View Profile', 'lumea' ); ?></a>
					<?php else : ?>
						<p class="lumea-account-panel-text"><?php esc_html_e( 'To access your account and manage orders', 'lumea' ); ?></p>
						<a href="<?php echo esc_url( $lumea_register_url ); ?>" class="lumea-account-panel-cta"><?php esc_html_e( 'Login / Signup', 'lumea' ); ?></a>
						<?php endif; ?>

						<div class="lumea-account-divider"></div>

						<nav class="lumea-account-panel-links" aria-label="<?php esc_attr_e( 'Account quick links', 'lumea' ); ?>">
							<a href="<?php echo esc_url( $lumea_orders_url ); ?>"><?php esc_html_e( 'Orders', 'lumea' ); ?></a>
							<a href="<?php echo esc_url( $lumea_wishlist_url ); ?>"><?php esc_html_e( 'Wishlist', 'lumea' ); ?></a>
							<a href="<?php echo esc_url( $lumea_bag_url ); ?>"><?php esc_html_e( 'Bag', 'lumea' ); ?></a>
							<a href="<?php echo esc_url( $lumea_addresses_url ); ?>"><?php esc_html_e( 'Saved Addresses', 'lumea' ); ?></a>
							<a href="<?php echo esc_url( $lumea_contact_url ); ?>"><?php esc_html_e( 'Contact Us', 'lumea' ); ?></a>
							<?php if ( $lumea_is_logged_in ) : ?>
							<a href="<?php echo esc_url( $lumea_details_url ); ?>"><?php esc_html_e( 'Account Details', 'lumea' ); ?></a>
							<?php endif; ?>
						</nav>

						<?php if ( $lumea_is_logged_in ) : ?>
						<div class="lumea-account-divider"></div>
						<a href="<?php echo esc_url( wp_logout_url( home_url( '/' ) ) ); ?>" class="lumea-account-panel-logout"><?php esc_html_e( 'Sign Out', 'lumea' ); ?></a>
						<?php endif; ?>
					</div>
				</div>
			</div>

			<!-- Wishlist -->
			<div class="lumea-wishlist-wrap">
				<a class="lumea-header-icon-btn" aria-label="<?php esc_attr_e( 'Favourites', 'lumea' ); ?>" href="<?php echo esc_url( $lumea_wishlist_url ); ?>">
					<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20.84 4.61a5.5 5.5 0 00-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 00-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 000-7.78z"/></svg>
					<span class="lumea-wishlist-count" aria-hidden="true"></span>
				</a>
			</div>

			<!-- Cart -->
			<?php if ( class_exists( 'WooCommerce' ) ) : ?>
			<button class="lumea-cart-trigger" aria-label="<?php esc_attr_e( 'Open cart', 'lumea' ); ?>" data-lumea-cart-trigger>
				<svg class="lumea-cart-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.95" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
					<path d="M2 5.25h2.4a1.2 1.2 0 0 1 1.14.86l2.3 7.73"></path>
					<path d="M6.95 7.2h15.15l-1.25 4.75a2.45 2.45 0 0 1-2.34 1.82l-10.67.95"></path>
					<path d="M8.1 15.8a1.85 1.85 0 0 0 1.74 2.45h8.56"></path>
					<circle cx="9.4" cy="19.1" r="1.9"></circle>
					<circle cx="17.9" cy="19.1" r="1.9"></circle>
				</svg>
				<span class="lumea-cart-count<?php echo WC()->cart->get_cart_contents_count() ? ' lumea-cart-count--visible' : ''; ?>"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
			</button>
			<?php endif; ?>

			<button class="lumea-nav-toggle" aria-label="<?php esc_attr_e( 'Open menu', 'lumea' ); ?>" aria-expanded="false" aria-controls="lumeaMobileNav" data-lumea-nav-toggle>
				<span class="lumea-nav-toggle-bar"></span>
				<span class="lumea-nav-toggle-bar"></span>
			</button>
		</div>
			</div>
		</div>

	</div>
</header>

<!-- Search Overlay -->
<div class="lumea-search-overlay" id="lumeaSearchOverlay" aria-hidden="true" data-lumea-search-overlay>

	<button class="lumea-search-overlay-close" aria-label="<?php esc_attr_e( 'Close search', 'lumea' ); ?>" data-lumea-search-close>
		<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
		<span class="lumea-search-overlay-close-esc" aria-hidden="true">ESC</span>
	</button>

	<div class="lumea-search-overlay-inner">

		<p class="lumea-search-overlay-label"><?php esc_html_e( 'What are you looking for?', 'lumea' ); ?></p>

		<form class="lumea-search-overlay-form" role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
			<input
				type="search"
				class="lumea-search-overlay-input"
				name="s"
				placeholder="<?php esc_attr_e( 'Search products, articles\xe2\x80\xa6', 'lumea' ); ?>"
				autocomplete="off"
				aria-label="<?php esc_attr_e( 'Search', 'lumea' ); ?>"
			>
			<button type="submit" class="lumea-search-overlay-submit" aria-label="<?php esc_attr_e( 'Search', 'lumea' ); ?>">
				<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
			</button>
		</form>

		<?php
		$overlay_cats = get_terms( array(
			'taxonomy'   => 'product_cat',
			'number'     => 6,
			'hide_empty' => true,
			'orderby'    => 'count',
			'order'      => 'DESC',
			'exclude'    => array( get_option( 'default_product_cat' ) ),
		) );
		if ( ! empty( $overlay_cats ) && ! is_wp_error( $overlay_cats ) ) :
		?>
		<div class="lumea-search-overlay-quick">
			<span class="lumea-search-overlay-quick-label"><?php esc_html_e( 'Popular', 'lumea' ); ?></span>
			<div class="lumea-search-overlay-chips">
				<?php foreach ( $overlay_cats as $cat ) : ?>
				<a href="<?php echo esc_url( get_term_link( $cat ) ); ?>" class="lumea-search-overlay-chip">
					<?php echo esc_html( $cat->name ); ?>
				</a>
				<?php endforeach; ?>
			</div>
		</div>
		<?php endif; ?>

	</div>
</div>

<!-- Wishlist Drawer -->
<div class="lumea-wishlist-drawer" id="lumeaWishlistDrawer" aria-hidden="true" data-lumea-wishlist-drawer>
	<div class="lumea-wishlist-drawer-header">
		<h2 class="lumea-wishlist-drawer-title"><?php esc_html_e( 'Favourites', 'lumea' ); ?></h2>
		<button class="lumea-wishlist-drawer-close" aria-label="<?php esc_attr_e( 'Close favourites', 'lumea' ); ?>" data-lumea-wishlist-close>
			<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
		</button>
	</div>
	<div class="lumea-wishlist-body">
		<div class="lumea-wishlist-items" data-lumea-wishlist-items></div>
		<div class="lumea-wishlist-empty-state" data-lumea-wishlist-empty hidden>
			<svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20.84 4.61a5.5 5.5 0 00-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 00-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 000-7.78z"/></svg>
			<p class="lumea-wishlist-empty-title"><?php esc_html_e( 'No saved items yet', 'lumea' ); ?></p>
			<p class="lumea-wishlist-empty-text"><?php esc_html_e( 'Save products you love and find them here.', 'lumea' ); ?></p>
			<?php if ( class_exists( 'WooCommerce' ) ) : ?>
			<a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>" class="lumea-404-btn lumea-404-btn--primary"><?php esc_html_e( 'Shop All', 'lumea' ); ?></a>
			<?php endif; ?>
		</div>
	</div>
</div>
<div class="lumea-wishlist-overlay" data-lumea-wishlist-overlay aria-hidden="true"></div>

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
