<?php
/**
 * Display the checkout shortcode.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-checkout.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 9.4.0
 */

defined( 'ABSPATH' ) || exit;

if ( ! is_checkout() ) {
	return;
}

$checkout = WC()->checkout();
do_action( 'woocommerce_before_checkout_form', $checkout );
?>

<div class="lumea-checkout-page">

	<!-- Breadcrumb -->
	<nav class="lumea-pdp-breadcrumb" aria-label="<?php esc_attr_e( 'Breadcrumb', 'lumea' ); ?>">
		<div class="lumea-pdp-bc-inner">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'lumea' ); ?></a>
			<svg class="lumea-pdp-bc-arrow" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="9 18 15 12 9 6"/></svg>
			<a href="<?php echo esc_url( wc_get_cart_url() ); ?>"><?php esc_html_e( 'Your Bag', 'lumea' ); ?></a>
			<svg class="lumea-pdp-bc-arrow" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="9 18 15 12 9 6"/></svg>
			<span aria-current="page"><?php esc_html_e( 'Checkout', 'lumea' ); ?></span>
		</div>
	</nav>

	<!-- Header -->
	<div class="lumea-checkout-hero">
		<div class="lumea-checkout-hero-inner">
			<p class="lumea-cart-eyebrow"><?php esc_html_e( 'Almost There', 'lumea' ); ?></p>
			<h1 class="lumea-cart-title"><?php esc_html_e( 'Secure Checkout', 'lumea' ); ?></h1>
			<!-- Step indicator -->
			<div class="lumea-checkout-steps">
				<span class="lumea-checkout-step is-done">
					<span class="lumea-checkout-step-dot">
						<svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="20 6 9 17 4 12"/></svg>
					</span>
					<?php esc_html_e( 'Bag', 'lumea' ); ?>
				</span>
				<span class="lumea-checkout-step-line"></span>
				<span class="lumea-checkout-step is-active">
					<span class="lumea-checkout-step-dot"></span>
					<?php esc_html_e( 'Details', 'lumea' ); ?>
				</span>
				<span class="lumea-checkout-step-line"></span>
				<span class="lumea-checkout-step">
					<span class="lumea-checkout-step-dot"></span>
					<?php esc_html_e( 'Confirmation', 'lumea' ); ?>
				</span>
			</div>
		</div>
	</div>

	<form name="checkout" method="post" class="lumea-checkout-form checkout woocommerce-checkout" action="<?php echo esc_url( wc_get_checkout_url() ); ?>" enctype="multipart/form-data">

		<div class="lumea-checkout-body">
			<div class="lumea-checkout-body-inner">

				<!-- Left: details -->
				<div class="lumea-checkout-left">

					<?php if ( $checkout->get_checkout_fields() ) : ?>

						<?php do_action( 'woocommerce_checkout_before_customer_details' ); ?>

					<!-- Contact -->
					<div class="lumea-checkout-block">
						<h2 class="lumea-checkout-block-title">
							<span class="lumea-checkout-block-num">01</span>
							<?php esc_html_e( 'Contact', 'lumea' ); ?>
						</h2>
						<div class="lumea-checkout-fields">
							<?php
							woocommerce_form_field(
								'billing_email',
								array(
									'type'        => 'email',
									'label'       => __( 'Email address', 'lumea' ),
									'placeholder' => __( 'you@example.com', 'lumea' ),
									'required'    => true,
									'class'       => array( 'lumea-field-full' ),
								),
								$checkout->get_value( 'billing_email' )
							);
							?>
						</div>
					</div>

					<!-- Billing / Shipping -->
					<div class="lumea-checkout-block">
						<h2 class="lumea-checkout-block-title">
							<span class="lumea-checkout-block-num">02</span>
							<?php esc_html_e( 'Delivery Address', 'lumea' ); ?>
						</h2>
						<div class="lumea-checkout-fields">
							<?php do_action( 'woocommerce_checkout_billing' ); ?>
						</div>
					</div>

						<?php if ( WC()->cart->needs_shipping() && WC()->cart->show_shipping() ) : ?>
					<div class="lumea-checkout-block">
						<h2 class="lumea-checkout-block-title">
							<span class="lumea-checkout-block-num">03</span>
							<?php esc_html_e( 'Shipping Method', 'lumea' ); ?>
						</h2>
						<div class="lumea-checkout-shipping-wrap">
							<?php do_action( 'woocommerce_checkout_shipping' ); ?>
						</div>
					</div>
					<?php endif; ?>

					<!-- Payment -->
					<div class="lumea-checkout-block lumea-checkout-block--payment">
						<h2 class="lumea-checkout-block-title">
							<span class="lumea-checkout-block-num"><?php echo esc_html( WC()->cart->needs_shipping() && WC()->cart->show_shipping() ? '04' : '03' ); ?></span>
							<?php esc_html_e( 'Payment', 'lumea' ); ?>
						</h2>
						<div class="lumea-checkout-payment-wrap">
							<?php do_action( 'lumea_checkout_payment' ); ?>
						</div>
					</div>
						<?php do_action( 'woocommerce_checkout_after_customer_details' ); ?>

					<?php endif; ?>

				</div><!-- /.lumea-checkout-left -->

				<!-- Right: order summary -->
				<div class="lumea-checkout-right">
					<div class="lumea-checkout-summary">

						<?php do_action( 'woocommerce_checkout_before_order_review_heading' ); ?>
						<h2 class="lumea-checkout-summary-title"><?php esc_html_e( 'Order Summary', 'lumea' ); ?></h2>
						<?php do_action( 'woocommerce_checkout_before_order_review' ); ?>
						<div id="order_review" class="woocommerce-checkout-review-order">
							<?php do_action( 'woocommerce_checkout_order_review' ); ?>
						</div>
						<?php do_action( 'woocommerce_checkout_after_order_review' ); ?>

						<!-- Trust -->
						<div class="lumea-checkout-trust-row">
							<svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
							<span><?php esc_html_e( 'SSL encrypted · 256-bit secure checkout', 'lumea' ); ?></span>
						</div>

					</div>
				</div><!-- /.lumea-checkout-right -->

			</div>
		</div><!-- /.lumea-checkout-body -->

	</form>

	<?php do_action( 'woocommerce_after_checkout_form', $checkout ); ?>

</div><!-- /.lumea-checkout-page -->
