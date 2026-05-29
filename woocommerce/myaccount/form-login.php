<?php
/**
 * Login Form.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-login.php.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 9.9.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$lumea_login_username    = ( ! empty( $_POST['username'] ) && is_string( $_POST['username'] ) ) ? wp_unslash( $_POST['username'] ) : '';
$lumea_register_email    = ( ! empty( $_POST['email'] ) && is_string( $_POST['email'] ) ) ? wp_unslash( $_POST['email'] ) : '';
$lumea_register_username = ( ! empty( $_POST['username'] ) && is_string( $_POST['username'] ) ) ? wp_unslash( $_POST['username'] ) : '';
$lumea_login_redirect    = wc_get_page_permalink( 'myaccount' );
$lumea_open_register     = isset( $_POST['register'] );
$lumea_shell_class       = $lumea_open_register ? ' active' : '';

if ( ! empty( $_REQUEST['redirect'] ) && is_string( $_REQUEST['redirect'] ) ) {
	$requested_redirect = wp_unslash( $_REQUEST['redirect'] );
	$validated_redirect = wp_validate_redirect( $requested_redirect, false );
	if ( $validated_redirect ) {
		$lumea_login_redirect = $validated_redirect;
	}
}

do_action( 'woocommerce_before_customer_login_form' );
?>

<div class="lumea-auth-ref" id="lumeaAuthRef">
	<div class="lumea-auth-ref-container<?php echo esc_attr( $lumea_shell_class ); ?>" data-lumea-auth-ref-container>
		<div class="lumea-auth-ref-login">
			<div class="lumea-auth-ref-content">
				<h1><?php esc_html_e( 'Welcome Back', 'lumea' ); ?></h1>

				<form class="woocommerce-form woocommerce-form-login login" method="post" novalidate>
					<?php do_action( 'woocommerce_login_form_start' ); ?>

					<input type="text" class="lumea-auth-ref-input woocommerce-Input woocommerce-Input--text input-text" name="username" id="username" autocomplete="username email" value="<?php echo esc_attr( $lumea_login_username ); ?>" placeholder="<?php esc_attr_e( 'email', 'lumea' ); ?>" required aria-required="true">
					<input type="password" class="lumea-auth-ref-input woocommerce-Input woocommerce-Input--text input-text" name="password" id="password" autocomplete="current-password" placeholder="<?php esc_attr_e( 'password', 'lumea' ); ?>" required aria-required="true">

					<div class="lumea-auth-ref-row">
						<label class="lumea-auth-ref-check" for="rememberme">
							<input class="woocommerce-form__input woocommerce-form__input-checkbox" name="rememberme" type="checkbox" id="rememberme" value="forever">
							<span><?php esc_html_e( 'Remember me', 'lumea' ); ?></span>
						</label>
						<a href="<?php echo esc_url( function_exists( 'wc_lostpassword_url' ) ? wc_lostpassword_url() : wp_lostpassword_url() ); ?>" class="lumea-auth-ref-forget"><?php esc_html_e( 'Forgot password?', 'lumea' ); ?></a>
					</div>

					<?php do_action( 'woocommerce_login_form' ); ?>
					<?php wp_nonce_field( 'woocommerce-login', 'woocommerce-login-nonce' ); ?>
					<input type="hidden" name="redirect" value="<?php echo esc_url( $lumea_login_redirect ); ?>">

					<button type="submit" class="lumea-auth-ref-submit" name="login" value="<?php esc_attr_e( 'Log in', 'lumea' ); ?>"><?php esc_html_e( 'Log In', 'lumea' ); ?></button>
					<?php do_action( 'woocommerce_login_form_end' ); ?>
				</form>

				<span class="lumea-auth-ref-copy">&copy; <?php echo esc_html( date( 'Y' ) ); ?> Lumea</span>
			</div>
		</div>

		<div class="lumea-auth-ref-page lumea-auth-ref-page-front" aria-hidden="true">
			<div class="lumea-auth-ref-content">
				<svg xmlns="http://www.w3.org/2000/svg" width="96" height="96" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="8.5" cy="7" r="4"/><line x1="20" y1="8" x2="20" y2="14"/><line x1="23" y1="11" x2="17" y2="11"/></svg>
				<h1><?php esc_html_e( 'New here?', 'lumea' ); ?></h1>
				<p><?php esc_html_e( 'Create an account to track orders, save favourites, and enjoy a more personal experience.', 'lumea' ); ?></p>
				<button type="button" class="lumea-auth-ref-ghost" data-lumea-auth-ref-open="register"><?php esc_html_e( 'Create Account', 'lumea' ); ?></button>
			</div>
		</div>

		<div class="lumea-auth-ref-page lumea-auth-ref-page-back" aria-hidden="true">
			<div class="lumea-auth-ref-content">
				<svg xmlns="http://www.w3.org/2000/svg" width="96" height="96" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/></svg>
				<h1><?php esc_html_e( 'Welcome Back', 'lumea' ); ?></h1>
				<p><?php esc_html_e( 'Already have an account? Sign in to continue your journey with Lumea.', 'lumea' ); ?></p>
				<button type="button" class="lumea-auth-ref-ghost" data-lumea-auth-ref-open="login"><?php esc_html_e( 'Sign In', 'lumea' ); ?></button>
			</div>
		</div>

		<div class="lumea-auth-ref-register">
			<div class="lumea-auth-ref-content">
				<h1><?php esc_html_e( 'Sign Up', 'lumea' ); ?></h1>
				<span class="lumea-auth-ref-with lumea-auth-ref-with-register"><?php esc_html_e( 'Or sign up with email', 'lumea' ); ?></span>

				<form method="post" class="woocommerce-form woocommerce-form-register register" <?php do_action( 'woocommerce_register_form_tag' ); ?>>
					<?php do_action( 'woocommerce_register_form_start' ); ?>
					<input type="text" class="lumea-auth-ref-input woocommerce-Input woocommerce-Input--text input-text" name="username" id="reg_username" autocomplete="username" value="<?php echo esc_attr( $lumea_register_username ); ?>" placeholder="<?php esc_attr_e( 'name', 'lumea' ); ?>" required aria-required="true">
					<input type="email" class="lumea-auth-ref-input woocommerce-Input woocommerce-Input--text input-text" name="email" id="reg_email" autocomplete="email" value="<?php echo esc_attr( $lumea_register_email ); ?>" placeholder="<?php esc_attr_e( 'email', 'lumea' ); ?>" required aria-required="true">
					<input type="password" class="lumea-auth-ref-input woocommerce-Input woocommerce-Input--text input-text" name="password" id="reg_password" autocomplete="new-password" placeholder="<?php esc_attr_e( 'password', 'lumea' ); ?>" required aria-required="true">

					<label class="lumea-auth-ref-check" for="lumea_terms">
						<input type="checkbox" id="lumea_terms" required>
						<span><?php esc_html_e( 'I accept terms', 'lumea' ); ?></span>
					</label>

					<?php do_action( 'woocommerce_register_form' ); ?>
					<?php wp_nonce_field( 'woocommerce-register', 'woocommerce-register-nonce' ); ?>
					<input type="hidden" name="redirect" value="<?php echo esc_url( $lumea_login_redirect ); ?>">
					<button type="submit" class="lumea-auth-ref-submit" name="register" value="<?php esc_attr_e( 'Register', 'lumea' ); ?>"><?php esc_html_e( 'Register', 'lumea' ); ?></button>
					<?php do_action( 'woocommerce_register_form_end' ); ?>
				</form>
			</div>
		</div>
	</div>
</div>

<?php do_action( 'woocommerce_after_customer_login_form' ); ?>
