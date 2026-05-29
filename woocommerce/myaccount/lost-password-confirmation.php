<?php
/**
 * Lost password confirmation text.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/lost-password-confirmation.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.9.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<div class="lumea-login-page lumea-login-page--reset">

	<nav class="lumea-pdp-breadcrumb" aria-label="<?php esc_attr_e( 'Breadcrumb', 'lumea' ); ?>">
		<div class="lumea-pdp-bc-inner">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'lumea' ); ?></a>
			<svg class="lumea-pdp-bc-arrow" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="9 18 15 12 9 6"/></svg>
			<a href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>"><?php esc_html_e( 'My Account', 'lumea' ); ?></a>
			<svg class="lumea-pdp-bc-arrow" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="9 18 15 12 9 6"/></svg>
			<span aria-current="page"><?php esc_html_e( 'Check Your Email', 'lumea' ); ?></span>
		</div>
	</nav>

	<div class="lumea-login-hero">
		<div class="lumea-login-hero-inner">
			<p class="lumea-cart-eyebrow"><?php esc_html_e( 'Password Reset', 'lumea' ); ?></p>
			<h1 class="lumea-login-title"><?php esc_html_e( 'Check your inbox', 'lumea' ); ?></h1>
			<p class="lumea-login-subtitle"><?php esc_html_e( 'We sent a secure reset link to your email address.', 'lumea' ); ?></p>
		</div>
	</div>

	<div class="lumea-login-body">
		<div class="lumea-login-body-inner lumea-login-body-inner--single">
			<div class="lumea-login-card lumea-login-card--reset">

				<?php wc_print_notice( esc_html__( 'Password reset email has been sent.', 'woocommerce' ) ); ?>

				<?php do_action( 'woocommerce_before_lost_password_confirmation_message' ); ?>

				<p class="lumea-login-helper">
					<?php
					echo esc_html(
						apply_filters(
							'woocommerce_lost_password_confirmation_message',
							esc_html__( 'A password reset email has been sent to the email address on file for your account, but may take several minutes to show up in your inbox. Please wait at least 10 minutes before attempting another reset.', 'woocommerce' )
						)
					);
					?>
				</p>

				<?php do_action( 'woocommerce_after_lost_password_confirmation_message' ); ?>

				<a href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>" class="lumea-login-back"><?php esc_html_e( 'Return to sign in', 'lumea' ); ?></a>

			</div>
		</div>
	</div>

</div>
