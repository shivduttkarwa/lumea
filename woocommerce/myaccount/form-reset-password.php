<?php
/**
 * Lost password reset form.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-reset-password.php.
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

do_action( 'woocommerce_before_reset_password_form' );
?>

<div class="lumea-login-page lumea-login-page--reset">

	<nav class="lumea-pdp-breadcrumb" aria-label="<?php esc_attr_e( 'Breadcrumb', 'lumea' ); ?>">
		<div class="lumea-pdp-bc-inner">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'lumea' ); ?></a>
			<svg class="lumea-pdp-bc-arrow" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="9 18 15 12 9 6"/></svg>
			<a href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>"><?php esc_html_e( 'My Account', 'lumea' ); ?></a>
			<svg class="lumea-pdp-bc-arrow" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="9 18 15 12 9 6"/></svg>
			<span aria-current="page"><?php esc_html_e( 'Create New Password', 'lumea' ); ?></span>
		</div>
	</nav>

	<div class="lumea-login-hero">
		<div class="lumea-login-hero-inner">
			<p class="lumea-cart-eyebrow"><?php esc_html_e( 'Account Security', 'lumea' ); ?></p>
			<h1 class="lumea-login-title"><?php esc_html_e( 'Create a new password', 'lumea' ); ?></h1>
			<p class="lumea-login-subtitle"><?php esc_html_e( 'Choose a strong password to keep your account safe.', 'lumea' ); ?></p>
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
								'woocommerce_reset_password_message',
								esc_html__( 'Enter a new password below.', 'woocommerce' )
							)
						);
						?>
					</p>

					<p class="woocommerce-form-row woocommerce-form-row--first form-row form-row-first lumea-login-field">
						<label for="password_1"><?php esc_html_e( 'New password', 'woocommerce' ); ?>&nbsp;<span class="required" aria-hidden="true">*</span><span class="screen-reader-text"><?php esc_html_e( 'Required', 'woocommerce' ); ?></span></label>
						<input type="password" class="lumea-login-input woocommerce-Input woocommerce-Input--text input-text" name="password_1" id="password_1" autocomplete="new-password" required aria-required="true" />
					</p>
					<p class="woocommerce-form-row woocommerce-form-row--last form-row form-row-last lumea-login-field">
						<label for="password_2"><?php esc_html_e( 'Re-enter new password', 'woocommerce' ); ?>&nbsp;<span class="required" aria-hidden="true">*</span><span class="screen-reader-text"><?php esc_html_e( 'Required', 'woocommerce' ); ?></span></label>
						<input type="password" class="lumea-login-input woocommerce-Input woocommerce-Input--text input-text" name="password_2" id="password_2" autocomplete="new-password" required aria-required="true" />
					</p>

					<input type="hidden" name="reset_key" value="<?php echo esc_attr( $args['key'] ); ?>" />
					<input type="hidden" name="reset_login" value="<?php echo esc_attr( $args['login'] ); ?>" />

					<div class="clear"></div>

					<?php do_action( 'woocommerce_resetpassword_form' ); ?>

					<p class="woocommerce-form-row form-row">
						<input type="hidden" name="wc_reset_password" value="true" />
						<button type="submit" class="lumea-login-submit woocommerce-Button button<?php echo esc_attr( wc_wp_theme_get_element_class_name( 'button' ) ? ' ' . wc_wp_theme_get_element_class_name( 'button' ) : '' ); ?>" value="<?php esc_attr_e( 'Save', 'woocommerce' ); ?>"><?php esc_html_e( 'Save new password', 'lumea' ); ?></button>
					</p>

					<?php wp_nonce_field( 'reset_password', 'woocommerce-reset-password-nonce' ); ?>

				</form>
			</div>

		</div>
	</div>

</div>

<?php do_action( 'woocommerce_after_reset_password_form' ); ?>
