<?php
/**
 * Lost password form.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-lost-password.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 9.2.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

do_action( 'woocommerce_before_lost_password_form' );
?>

<div class="lumea-login-page lumea-login-page--reset">

	<nav class="lumea-pdp-breadcrumb" aria-label="<?php esc_attr_e( 'Breadcrumb', 'lumea' ); ?>">
		<div class="lumea-pdp-bc-inner">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'lumea' ); ?></a>
			<svg class="lumea-pdp-bc-arrow" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="9 18 15 12 9 6"/></svg>
			<a href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>"><?php esc_html_e( 'My Account', 'lumea' ); ?></a>
			<svg class="lumea-pdp-bc-arrow" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="9 18 15 12 9 6"/></svg>
			<span aria-current="page"><?php esc_html_e( 'Reset Password', 'lumea' ); ?></span>
		</div>
	</nav>

	<div class="lumea-login-hero">
		<div class="lumea-login-hero-inner">
			<p class="lumea-cart-eyebrow"><?php esc_html_e( 'Account Access', 'lumea' ); ?></p>
			<h1 class="lumea-login-title"><?php esc_html_e( 'Reset your password', 'lumea' ); ?></h1>
			<p class="lumea-login-subtitle"><?php esc_html_e( 'Enter your email and we will send you a secure reset link.', 'lumea' ); ?></p>
		</div>
	</div>

	<div class="lumea-login-body">
		<div class="lumea-login-body-inner lumea-login-body-inner--single">

			<div class="lumea-login-card lumea-login-card--reset">
				<form method="post" class="woocommerce-ResetPassword lost_reset_password lumea-login-form">

					<p class="lumea-login-helper">
						<?php
						echo wp_kses_post(
							apply_filters(
								'woocommerce_lost_password_message',
								esc_html__( 'Lost your password? Please enter your username or email address. You will receive a link to create a new password via email.', 'woocommerce' )
							)
						);
						?>
					</p>

					<p class="woocommerce-form-row woocommerce-form-row--first form-row form-row-first lumea-login-field">
						<label for="user_login"><?php esc_html_e( 'Username or email', 'woocommerce' ); ?>&nbsp;<span class="required" aria-hidden="true">*</span><span class="screen-reader-text"><?php esc_html_e( 'Required', 'woocommerce' ); ?></span></label>
						<input class="lumea-login-input woocommerce-Input woocommerce-Input--text input-text" type="text" name="user_login" id="user_login" autocomplete="username" required aria-required="true" />
					</p>

					<div class="clear"></div>

					<?php do_action( 'woocommerce_lostpassword_form' ); ?>

					<p class="woocommerce-form-row form-row">
						<input type="hidden" name="wc_reset_password" value="true" />
						<button type="submit" class="lumea-login-submit woocommerce-Button button<?php echo esc_attr( wc_wp_theme_get_element_class_name( 'button' ) ? ' ' . wc_wp_theme_get_element_class_name( 'button' ) : '' ); ?>" value="<?php esc_attr_e( 'Reset password', 'woocommerce' ); ?>"><?php esc_html_e( 'Reset password', 'woocommerce' ); ?></button>
					</p>

					<?php wp_nonce_field( 'lost_password', 'woocommerce-lost-password-nonce' ); ?>

				</form>

				<a href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>" class="lumea-login-back"><?php esc_html_e( 'Back to sign in', 'lumea' ); ?></a>
			</div>

		</div>
	</div>

</div>

<?php do_action( 'woocommerce_after_lost_password_form' ); ?>
