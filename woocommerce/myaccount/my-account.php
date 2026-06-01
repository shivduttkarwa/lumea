<?php
/**
 * My Account page.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/my-account.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.5.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<div class="lumea-account-page">

	<!-- Breadcrumb -->
	<nav class="lumea-pdp-breadcrumb" aria-label="<?php esc_attr_e( 'Breadcrumb', 'lumea' ); ?>">
		<div class="lumea-pdp-bc-inner">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'lumea' ); ?></a>
			<svg class="lumea-pdp-bc-arrow" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="9 18 15 12 9 6"/></svg>
			<span aria-current="page"><?php esc_html_e( 'My Account', 'lumea' ); ?></span>
		</div>
	</nav>

	<!-- Hero -->
	<div class="lumea-account-hero">
		<div class="lumea-account-hero-inner">
			<?php if ( is_user_logged_in() ) :
				$current_user = wp_get_current_user();
				$first_name   = $current_user->first_name ?: $current_user->display_name;
			?>
			<p class="lumea-cart-eyebrow"><?php esc_html_e( 'Welcome back', 'lumea' ); ?></p>
			<h1 class="lumea-account-title"><?php echo esc_html( $first_name ); ?></h1>
			<?php else : ?>
			<p class="lumea-cart-eyebrow"><?php esc_html_e( 'My Account', 'lumea' ); ?></p>
			<h1 class="lumea-account-title"><?php esc_html_e( 'Sign in to your account', 'lumea' ); ?></h1>
			<?php endif; ?>
		</div>
	</div>

	<!-- Body -->
	<div class="lumea-account-body">
		<div class="lumea-account-body-inner">

			<!-- Sidebar navigation -->
			<aside class="lumea-account-nav" aria-label="<?php esc_attr_e( 'Account navigation', 'lumea' ); ?>">
				<?php do_action( 'woocommerce_before_account_navigation' ); ?>
				<nav>
					<?php foreach ( wc_get_account_menu_items() as $endpoint => $label ) : ?>
					<?php
					$wc_menu_classes = function_exists( 'wc_get_account_menu_item_classes' ) ? wc_get_account_menu_item_classes( $endpoint ) : '';
					$is_current      = false !== strpos( (string) $wc_menu_classes, 'is-active' );
					?>
					<a href="<?php echo esc_url( wc_get_account_endpoint_url( $endpoint ) ); ?>"
					   class="<?php echo esc_attr( trim( 'lumea-account-nav-item ' . $wc_menu_classes ) ); ?>"
					   <?php echo $is_current ? 'aria-current="page"' : ''; ?>>
						<?php echo esc_html( $label ); ?>
						<svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="9 18 15 12 9 6"/></svg>
					</a>
					<?php endforeach; ?>
				</nav>
				<?php do_action( 'woocommerce_after_account_navigation' ); ?>
			</aside>

			<!-- Main content -->
			<div class="lumea-account-content">
				<?php
				do_action( 'woocommerce_account_content' );
				?>
			</div>

		</div>
	</div><!-- /.lumea-account-body -->

</div><!-- /.lumea-account-page -->
