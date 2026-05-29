<?php
/**
 * Login Form.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-login.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 9.9.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$lumea_login_username = ( ! empty( $_POST['username'] ) && is_string( $_POST['username'] ) ) ? wp_unslash( $_POST['username'] ) : '';
$lumea_register_email = ( ! empty( $_POST['email'] ) && is_string( $_POST['email'] ) ) ? wp_unslash( $_POST['email'] ) : '';
$lumea_login_redirect = wc_get_page_permalink( 'myaccount' );
$lumea_register_query = ( ! empty( $_GET['register'] ) && is_string( $_GET['register'] ) ) ? strtolower( sanitize_text_field( wp_unslash( $_GET['register'] ) ) ) : '';
$lumea_open_register  = isset( $_POST['register'] ) || in_array( $lumea_register_query, array( '1', 'yes', 'true' ), true );
$lumea_active_tab     = $lumea_open_register ? 'register' : 'login';

if ( ! empty( $_REQUEST['redirect'] ) && is_string( $_REQUEST['redirect'] ) ) {
	$requested_redirect = wp_unslash( $_REQUEST['redirect'] );
	$validated_redirect = wp_validate_redirect( $requested_redirect, false );
	if ( $validated_redirect ) {
		$lumea_login_redirect = $validated_redirect;
	}
}

do_action( 'woocommerce_before_customer_login_form' );
?>

<div class="lumea-login-page">

	<!-- Breadcrumb -->
	<nav class="lumea-pdp-breadcrumb" aria-label="<?php esc_attr_e( 'Breadcrumb', 'lumea' ); ?>">
		<div class="lumea-pdp-bc-inner">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'lumea' ); ?></a>
			<svg class="lumea-pdp-bc-arrow" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="9 18 15 12 9 6"/></svg>
			<span aria-current="page"><?php esc_html_e( 'My Account', 'lumea' ); ?></span>
		</div>
	</nav>

	<!-- Hero -->
	<div class="lumea-login-hero">
		<div class="lumea-login-hero-inner">
			<p class="lumea-cart-eyebrow"><?php esc_html_e( 'My Account', 'lumea' ); ?></p>
			<h1 class="lumea-login-title"><?php esc_html_e( 'Welcome to Luméa', 'lumea' ); ?></h1>
			<p class="lumea-login-subtitle"><?php esc_html_e( 'Sign in to manage your orders, rituals, and personal skin profile.', 'lumea' ); ?></p>
		</div>
	</div>

	<div class="lumea-login-body">
		<div class="lumea-login-body-inner">
			<aside class="lumea-login-story" aria-label="<?php esc_attr_e( 'Account benefits', 'lumea' ); ?>">
				<p class="lumea-login-story-eyebrow"><?php esc_html_e( 'Luméa Ritual Membership', 'lumea' ); ?></p>
				<h2 class="lumea-login-story-title"><?php esc_html_e( 'A better beauty journey starts with your account.', 'lumea' ); ?></h2>
				<p class="lumea-login-story-text"><?php esc_html_e( 'Track every order, save favourites, manage addresses, and reorder your skincare essentials in seconds.', 'lumea' ); ?></p>
				<ul class="lumea-login-story-list">
					<li><span>01</span><?php esc_html_e( 'One-tap reorders of your routine', 'lumea' ); ?></li>
					<li><span>02</span><?php esc_html_e( 'Live order and delivery updates', 'lumea' ); ?></li>
					<li><span>03</span><?php esc_html_e( 'Faster checkout with saved details', 'lumea' ); ?></li>
				</ul>
				<div class="lumea-login-story-tags">
					<span><?php esc_html_e( 'Secure Checkout', 'lumea' ); ?></span>
					<span><?php esc_html_e( 'Private Data', 'lumea' ); ?></span>
					<span><?php esc_html_e( 'Trusted Payments', 'lumea' ); ?></span>
				</div>
			</aside>

			<div class="lumea-login-card lumea-login-card--auth" id="lumeaRegisterCard">
				<div class="lumea-login-switch" role="tablist" aria-label="<?php esc_attr_e( 'Authentication forms', 'lumea' ); ?>">
					<button type="button" class="lumea-login-switch-btn<?php echo 'login' === $lumea_active_tab ? ' is-active' : ''; ?>" data-lumea-auth-tab="login" role="tab" aria-selected="<?php echo 'login' === $lumea_active_tab ? 'true' : 'false'; ?>" aria-controls="lumeaLoginPanel" id="lumeaLoginTab"><?php esc_html_e( 'Sign In', 'lumea' ); ?></button>
					<button type="button" class="lumea-login-switch-btn<?php echo 'register' === $lumea_active_tab ? ' is-active' : ''; ?>" data-lumea-auth-tab="register" role="tab" aria-selected="<?php echo 'register' === $lumea_active_tab ? 'true' : 'false'; ?>" aria-controls="lumeaRegisterPanel" id="lumeaRegisterTab"><?php esc_html_e( 'Create Account', 'lumea' ); ?></button>
				</div>

				<div class="lumea-login-pane<?php echo 'login' === $lumea_active_tab ? ' is-active' : ''; ?>" id="lumeaLoginPanel" role="tabpanel" aria-labelledby="lumeaLoginTab"<?php echo 'login' === $lumea_active_tab ? '' : ' hidden'; ?>>
					<p class="lumea-login-pane-text"><?php esc_html_e( 'Welcome back. Sign in to view orders and continue your routine.', 'lumea' ); ?></p>

					<form class="lumea-login-form woocommerce-form woocommerce-form-login login" method="post" novalidate>

						<?php do_action( 'woocommerce_login_form_start' ); ?>

						<div class="lumea-login-field">
							<label for="username"><?php esc_html_e( 'Email address', 'lumea' ); ?></label>
							<input type="text" class="lumea-login-input woocommerce-Input woocommerce-Input--text input-text" name="username" id="username" autocomplete="username email" value="<?php echo esc_attr( $lumea_login_username ); ?>" placeholder="<?php esc_attr_e( 'you@example.com', 'lumea' ); ?>" required aria-required="true">
						</div>

						<div class="lumea-login-field">
							<label for="password"><?php esc_html_e( 'Password', 'lumea' ); ?></label>
							<div class="lumea-login-password-wrap">
								<input class="lumea-login-input woocommerce-Input woocommerce-Input--text input-text" type="password" name="password" id="password" autocomplete="current-password" placeholder="<?php esc_attr_e( '••••••••', 'lumea' ); ?>" required aria-required="true" data-lumea-password-input>
								<button
									type="button"
									class="lumea-login-password-toggle"
									data-lumea-password-toggle
									aria-controls="password"
									aria-label="<?php esc_attr_e( 'Show password', 'lumea' ); ?>"
									aria-pressed="false"
									data-label-show="<?php esc_attr_e( 'Show password', 'lumea' ); ?>"
									data-label-hide="<?php esc_attr_e( 'Hide password', 'lumea' ); ?>">
									<svg class="lumea-login-password-toggle-icon lumea-login-password-toggle-icon--show" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.85" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M2.5 12s3.5-6.5 9.5-6.5 9.5 6.5 9.5 6.5-3.5 6.5-9.5 6.5S2.5 12 2.5 12Z"/><circle cx="12" cy="12" r="3"/></svg>
									<svg class="lumea-login-password-toggle-icon lumea-login-password-toggle-icon--hide" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.85" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M3 3l18 18"/><path d="M10.58 10.58A2 2 0 0 0 12 14a2 2 0 0 0 1.42-.58"/><path d="M9.88 5.09A10.94 10.94 0 0 1 12 4.9c6 0 9.5 6.5 9.5 6.5a17.4 17.4 0 0 1-2.16 3.02"/><path d="M6.15 6.2A16.2 16.2 0 0 0 2.5 12s3.5 6.5 9.5 6.5a10.8 10.8 0 0 0 4.03-.79"/></svg>
								</button>
							</div>
						</div>

						<div class="lumea-login-remember-row">
							<label class="lumea-login-check" for="rememberme">
								<input class="woocommerce-form__input woocommerce-form__input-checkbox" name="rememberme" type="checkbox" id="rememberme" value="forever">
								<span><?php esc_html_e( 'Remember me', 'lumea' ); ?></span>
							</label>
							<a href="<?php echo esc_url( function_exists( 'wc_lostpassword_url' ) ? wc_lostpassword_url() : wp_lostpassword_url() ); ?>" class="lumea-login-forgot"><?php esc_html_e( 'Forgot password?', 'lumea' ); ?></a>
						</div>

						<?php do_action( 'woocommerce_login_form' ); ?>

						<?php wp_nonce_field( 'woocommerce-login', 'woocommerce-login-nonce' ); ?>
						<input type="hidden" name="redirect" value="<?php echo esc_url( $lumea_login_redirect ); ?>">

						<button type="submit" class="lumea-login-submit" name="login" value="<?php esc_attr_e( 'Sign in', 'lumea' ); ?>">
							<?php esc_html_e( 'Sign In', 'lumea' ); ?>
						</button>

						<?php do_action( 'woocommerce_login_form_end' ); ?>

					</form>
				</div>

				<div class="lumea-login-pane<?php echo 'register' === $lumea_active_tab ? ' is-active' : ''; ?>" id="lumeaRegisterPanel" role="tabpanel" aria-labelledby="lumeaRegisterTab"<?php echo 'register' === $lumea_active_tab ? '' : ' hidden'; ?>>
					<p class="lumea-login-pane-text"><?php esc_html_e( 'Create your Luméa account for faster checkout and personalized care.', 'lumea' ); ?></p>

					<form method="post" class="lumea-login-form woocommerce-form woocommerce-form-register register" <?php do_action( 'woocommerce_register_form_tag' ); ?>>

						<?php do_action( 'woocommerce_register_form_start' ); ?>

						<?php if ( 'no' === get_option( 'woocommerce_registration_generate_username' ) ) : ?>
						<div class="lumea-login-field">
							<label for="reg_username"><?php esc_html_e( 'Username', 'lumea' ); ?></label>
							<input type="text" class="lumea-login-input woocommerce-Input woocommerce-Input--text input-text" name="username" id="reg_username" autocomplete="username" value="<?php echo esc_attr( $lumea_login_username ); ?>" placeholder="<?php esc_attr_e( 'Choose a username', 'lumea' ); ?>" required aria-required="true">
						</div>
						<?php endif; ?>

						<div class="lumea-login-field">
							<label for="reg_email"><?php esc_html_e( 'Email address', 'lumea' ); ?></label>
							<input type="email" class="lumea-login-input woocommerce-Input woocommerce-Input--text input-text" name="email" id="reg_email" autocomplete="email" value="<?php echo esc_attr( $lumea_register_email ); ?>" placeholder="<?php esc_attr_e( 'you@example.com', 'lumea' ); ?>" required aria-required="true">
						</div>

						<?php if ( 'no' === get_option( 'woocommerce_registration_generate_password' ) ) : ?>
						<div class="lumea-login-field">
							<label for="reg_password"><?php esc_html_e( 'Password', 'lumea' ); ?></label>
							<div class="lumea-login-password-wrap">
								<input type="password" class="lumea-login-input woocommerce-Input woocommerce-Input--text input-text" name="password" id="reg_password" autocomplete="new-password" placeholder="<?php esc_attr_e( 'Create a password', 'lumea' ); ?>" required aria-required="true" data-lumea-password-input>
								<button
									type="button"
									class="lumea-login-password-toggle"
									data-lumea-password-toggle
									aria-controls="reg_password"
									aria-label="<?php esc_attr_e( 'Show password', 'lumea' ); ?>"
									aria-pressed="false"
									data-label-show="<?php esc_attr_e( 'Show password', 'lumea' ); ?>"
									data-label-hide="<?php esc_attr_e( 'Hide password', 'lumea' ); ?>">
									<svg class="lumea-login-password-toggle-icon lumea-login-password-toggle-icon--show" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.85" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M2.5 12s3.5-6.5 9.5-6.5 9.5 6.5 9.5 6.5-3.5 6.5-9.5 6.5S2.5 12 2.5 12Z"/><circle cx="12" cy="12" r="3"/></svg>
									<svg class="lumea-login-password-toggle-icon lumea-login-password-toggle-icon--hide" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.85" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M3 3l18 18"/><path d="M10.58 10.58A2 2 0 0 0 12 14a2 2 0 0 0 1.42-.58"/><path d="M9.88 5.09A10.94 10.94 0 0 1 12 4.9c6 0 9.5 6.5 9.5 6.5a17.4 17.4 0 0 1-2.16 3.02"/><path d="M6.15 6.2A16.2 16.2 0 0 0 2.5 12s3.5 6.5 9.5 6.5a10.8 10.8 0 0 0 4.03-.79"/></svg>
								</button>
							</div>
						</div>
						<?php else : ?>
						<p class="lumea-login-helper"><?php esc_html_e( 'A secure setup link will be sent to your email after registration.', 'lumea' ); ?></p>
						<?php endif; ?>

						<?php do_action( 'woocommerce_register_form' ); ?>

						<?php wp_nonce_field( 'woocommerce-register', 'woocommerce-register-nonce' ); ?>
						<input type="hidden" name="redirect" value="<?php echo esc_url( $lumea_login_redirect ); ?>">

						<button type="submit" class="lumea-login-submit" name="register" value="<?php esc_attr_e( 'Register', 'lumea' ); ?>">
							<?php esc_html_e( 'Create Account', 'lumea' ); ?>
						</button>

						<?php do_action( 'woocommerce_register_form_end' ); ?>

					</form>
				</div>
			</div>

		</div>
	</div><!-- /.lumea-login-body -->

</div><!-- /.lumea-login-page -->

<?php do_action( 'woocommerce_after_customer_login_form' ); ?>
