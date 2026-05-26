<?php
/**
 * Login / Register page — Luméa premium edition.
 *
 * @package Lumea
 */

defined( 'ABSPATH' ) || exit;

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

			<!-- Login form -->
			<div class="lumea-login-card">
				<h2 class="lumea-login-card-title"><?php esc_html_e( 'Sign In', 'lumea' ); ?></h2>

				<form class="lumea-login-form woocommerce-form woocommerce-form-login login" method="post">

					<?php do_action( 'woocommerce_login_form_start' ); ?>

					<div class="lumea-login-field">
						<label for="username"><?php esc_html_e( 'Email address', 'lumea' ); ?></label>
						<input type="text" class="lumea-login-input woocommerce-Input woocommerce-Input--text input-text" name="username" id="username" autocomplete="username email" value="<?php echo ( ! empty( $_POST['username'] ) ) ? esc_attr( wp_unslash( $_POST['username'] ) ) : ''; ?>" placeholder="<?php esc_attr_e( 'you@example.com', 'lumea' ); ?>" required>
					</div>

					<div class="lumea-login-field">
						<label for="password"><?php esc_html_e( 'Password', 'lumea' ); ?></label>
						<input class="lumea-login-input woocommerce-Input woocommerce-Input--text input-text" type="password" name="password" id="password" autocomplete="current-password" placeholder="<?php esc_attr_e( '••••••••', 'lumea' ); ?>" required>
						<a href="<?php echo esc_url( wp_lostpassword_url() ); ?>" class="lumea-login-forgot"><?php esc_html_e( 'Forgot password?', 'lumea' ); ?></a>
					</div>

					<div class="lumea-login-remember">
						<label class="lumea-login-check">
							<input class="woocommerce-form__input woocommerce-form__input-checkbox" name="rememberme" type="checkbox" id="rememberme" value="forever">
							<span><?php esc_html_e( 'Remember me', 'lumea' ); ?></span>
						</label>
					</div>

					<?php do_action( 'woocommerce_login_form' ); ?>

					<?php wp_nonce_field( 'woocommerce-login', 'woocommerce-login-nonce' ); ?>
					<input type="hidden" name="redirect" value="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>">

					<button type="submit" class="lumea-login-submit" name="login" value="<?php esc_attr_e( 'Sign in', 'lumea' ); ?>">
						<?php esc_html_e( 'Sign In', 'lumea' ); ?>
					</button>

					<?php do_action( 'woocommerce_login_form_end' ); ?>

				</form>
			</div>

			<!-- Register form -->
			<?php if ( get_option( 'woocommerce_enable_myaccount_registration' ) === 'yes' ) : ?>
			<div class="lumea-login-card lumea-login-card--register">
				<h2 class="lumea-login-card-title"><?php esc_html_e( 'New to Luméa?', 'lumea' ); ?></h2>
				<p class="lumea-login-register-text"><?php esc_html_e( 'Create an account for faster checkout, exclusive rewards, and your personal skin profile.', 'lumea' ); ?></p>

				<form method="post" class="lumea-login-form woocommerce-form woocommerce-form-register register">

					<?php do_action( 'woocommerce_register_form_start' ); ?>

					<?php if ( 'no' === get_option( 'woocommerce_registration_generate_username' ) ) : ?>
					<div class="lumea-login-field">
						<label for="reg_username"><?php esc_html_e( 'Username', 'lumea' ); ?></label>
						<input type="text" class="lumea-login-input woocommerce-Input woocommerce-Input--text input-text" name="username" id="reg_username" autocomplete="username" value="<?php echo ( ! empty( $_POST['username'] ) ) ? esc_attr( wp_unslash( $_POST['username'] ) ) : ''; ?>" placeholder="<?php esc_attr_e( 'Choose a username', 'lumea' ); ?>">
					</div>
					<?php endif; ?>

					<div class="lumea-login-field">
						<label for="reg_email"><?php esc_html_e( 'Email address', 'lumea' ); ?></label>
						<input type="email" class="lumea-login-input woocommerce-Input woocommerce-Input--text input-text" name="email" id="reg_email" autocomplete="email" value="<?php echo ( ! empty( $_POST['email'] ) ) ? esc_attr( wp_unslash( $_POST['email'] ) ) : ''; ?>" placeholder="<?php esc_attr_e( 'you@example.com', 'lumea' ); ?>" required>
					</div>

					<?php if ( 'no' === get_option( 'woocommerce_registration_generate_password' ) ) : ?>
					<div class="lumea-login-field">
						<label for="reg_password"><?php esc_html_e( 'Password', 'lumea' ); ?></label>
						<input type="password" class="lumea-login-input woocommerce-Input woocommerce-Input--text input-text" name="password" id="reg_password" autocomplete="new-password" placeholder="<?php esc_attr_e( 'Create a password', 'lumea' ); ?>">
					</div>
					<?php endif; ?>

					<?php do_action( 'woocommerce_register_form' ); ?>

					<?php wp_nonce_field( 'woocommerce-register', 'woocommerce-register-nonce' ); ?>

					<button type="submit" class="lumea-login-submit lumea-login-submit--outline" name="register" value="<?php esc_attr_e( 'Register', 'lumea' ); ?>">
						<?php esc_html_e( 'Create Account', 'lumea' ); ?>
					</button>

					<?php do_action( 'woocommerce_register_form_end' ); ?>

				</form>
			</div>
			<?php endif; ?>

		</div>
	</div><!-- /.lumea-login-body -->

</div><!-- /.lumea-login-page -->

<?php do_action( 'woocommerce_after_customer_login_form' ); ?>
