<?php
/**
 * Checkout page — Luméa premium edition.
 *
 * @package Lumea
 */

defined( 'ABSPATH' ) || exit;

if ( ! is_checkout() ) return;

do_action( 'woocommerce_before_checkout_form', $checkout );

$checkout = WC()->checkout();
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
							<?php woocommerce_form_field( 'billing_email', array(
								'type'        => 'email',
								'label'       => __( 'Email address', 'lumea' ),
								'placeholder' => __( 'you@example.com', 'lumea' ),
								'required'    => true,
								'class'       => array( 'lumea-field-full' ),
							), $checkout->get_value( 'billing_email' ) ); ?>
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
							<span class="lumea-checkout-block-num"><?php echo WC()->cart->needs_shipping() && WC()->cart->show_shipping() ? '04' : '03'; ?></span>
							<?php esc_html_e( 'Payment', 'lumea' ); ?>
						</h2>
						<div class="lumea-checkout-payment-wrap">
							<?php do_action( 'woocommerce_checkout_payment' ); ?>
						</div>
					</div>

					<?php do_action( 'woocommerce_checkout_after_customer_details' ); ?>

					<?php endif; ?>

				</div><!-- /.lumea-checkout-left -->

				<!-- Right: order summary -->
				<div class="lumea-checkout-right">
					<div class="lumea-checkout-summary">

						<h2 class="lumea-checkout-summary-title"><?php esc_html_e( 'Order Summary', 'lumea' ); ?></h2>

						<!-- Items list -->
						<div class="lumea-checkout-items">
							<?php foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) :
								$_product  = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
								if ( ! $_product || ! $_product->exists() ) continue;
								$img_id    = $_product->get_image_id();
								$img_url   = $img_id ? wp_get_attachment_image_url( $img_id, 'thumbnail' ) : '';
								$item_name = apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key );
								$subtotal  = apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key );
							?>
							<div class="lumea-checkout-item">
								<div class="lumea-checkout-item-img">
									<?php if ( $img_url ) : ?>
									<img src="<?php echo esc_url( $img_url ); ?>" alt="<?php echo esc_attr( wp_strip_all_tags( $item_name ) ); ?>" loading="lazy">
									<?php endif; ?>
									<span class="lumea-checkout-item-qty"><?php echo esc_html( $cart_item['quantity'] ); ?></span>
								</div>
								<div class="lumea-checkout-item-info">
									<p class="lumea-checkout-item-name"><?php echo wp_kses_post( $item_name ); ?></p>
									<?php echo wc_get_formatted_cart_item_data( $cart_item ); ?>
								</div>
								<div class="lumea-checkout-item-price"><?php echo wp_kses_post( $subtotal ); ?></div>
							</div>
							<?php endforeach; ?>
						</div>

						<!-- Coupon -->
						<?php if ( wc_coupons_enabled() ) : ?>
						<div class="lumea-checkout-coupon">
							<input type="text" name="lumea_coupon_code" id="lumeaCouponCode" class="lumea-checkout-coupon-input" placeholder="<?php esc_attr_e( 'Gift or discount code', 'lumea' ); ?>">
							<button type="button" class="lumea-checkout-coupon-btn" id="lumeaApplyCoupon"><?php esc_html_e( 'Apply', 'lumea' ); ?></button>
						</div>
						<?php endif; ?>

						<!-- Totals -->
						<div class="lumea-checkout-totals">
							<div class="lumea-checkout-total-row">
								<span><?php esc_html_e( 'Subtotal', 'lumea' ); ?></span>
								<span><?php echo WC()->cart->get_cart_subtotal(); ?></span>
							</div>
							<?php if ( WC()->cart->needs_shipping() && WC()->cart->show_shipping() ) : ?>
							<div class="lumea-checkout-total-row">
								<span><?php esc_html_e( 'Shipping', 'lumea' ); ?></span>
								<span><?php echo WC()->cart->get_shipping_total() > 0 ? wc_price( WC()->cart->get_shipping_total() ) : esc_html__( 'Free', 'lumea' ); ?></span>
							</div>
							<?php endif; ?>
							<?php foreach ( WC()->cart->get_coupons() as $code => $coupon ) : ?>
							<div class="lumea-checkout-total-row lumea-checkout-total-row--discount">
								<span><?php echo esc_html( wc_cart_totals_coupon_label( $coupon, false ) ); ?></span>
								<span>-<?php echo WC()->cart->get_coupon_discount_amount( $code ); ?></span>
							</div>
							<?php endforeach; ?>
							<div class="lumea-checkout-total-row lumea-checkout-total-row--grand">
								<strong><?php esc_html_e( 'Total', 'lumea' ); ?></strong>
								<strong><?php echo WC()->cart->get_total(); ?></strong>
							</div>
						</div>

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

<script>
(function () {
  /* Coupon apply via AJAX */
  var couponBtn   = document.getElementById('lumeaApplyCoupon');
  var couponInput = document.getElementById('lumeaCouponCode');
  if (!couponBtn || !couponInput) return;

  couponBtn.addEventListener('click', function () {
    var code = couponInput.value.trim();
    if (!code) return;
    var data = new URLSearchParams();
    data.append('security', wc_checkout_params ? wc_checkout_params.apply_coupon_nonce : '');
    data.append('coupon_code', code);
    fetch(wc_checkout_params.ajax_url + '?action=apply_coupon', {
      method: 'POST', body: data,
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
    }).then(function () { window.location.reload(); });
  });
})();
</script>
