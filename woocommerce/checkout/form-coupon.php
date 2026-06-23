<?php
/**
 * Checkout coupon form.
 *
 * @package Lumea
 * @version 9.8.0
 */

defined( 'ABSPATH' ) || exit;

if ( ! wc_coupons_enabled() ) {
	return;
}

$lumea_coupon_message = apply_filters(
	'woocommerce_checkout_coupon_message',
	esc_html__( 'Have a coupon?', 'woocommerce' ) . ' <a href="#" role="button" aria-label="' . esc_attr__( 'Enter your coupon code', 'woocommerce' ) . '" aria-controls="woocommerce-checkout-form-coupon" aria-expanded="false" class="showcoupon">' . esc_html__( 'Enter your code', 'lumea' ) . '</a>'
);
?>

<div class="woocommerce-form-coupon-toggle lumea-checkout-coupon-toggle">
	<div class="lumea-checkout-coupon-callout">
		<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
			<path d="M20.59 13.41 11 3.83V3H4v7h.83l9.58 9.59a2 2 0 0 0 2.82 0l3.36-3.36a2 2 0 0 0 0-2.82Z"/>
			<circle cx="7.5" cy="6.5" r=".75" fill="currentColor" stroke="none"/>
		</svg>
		<p><?php echo wp_kses_post( $lumea_coupon_message ); ?></p>
	</div>
</div>

<form class="checkout_coupon woocommerce-form-coupon lumea-checkout-coupon" method="post" style="display:none" id="woocommerce-checkout-form-coupon">
	<div class="lumea-checkout-coupon-inner">
		<label for="coupon_code" class="screen-reader-text"><?php esc_html_e( 'Coupon code', 'lumea' ); ?></label>
		<input type="text" name="coupon_code" class="input-text lumea-checkout-coupon-input" placeholder="<?php esc_attr_e( 'Coupon code', 'lumea' ); ?>" id="coupon_code" value="">
		<button type="submit" class="lumea-btn btn-black" name="apply_coupon" value="<?php esc_attr_e( 'Apply coupon', 'lumea' ); ?>"><?php esc_html_e( 'Apply coupon', 'lumea' ); ?></button>
	</div>
</form>
