( function () {
	'use strict';

	var couponBtn   = document.getElementById( 'lumeaApplyCoupon' );
	var couponInput = document.getElementById( 'lumeaCouponCode' );

	if ( ! couponBtn || ! couponInput ) {
		return;
	}

	couponBtn.addEventListener( 'click', function () {
		var code = couponInput.value.trim();
		if ( ! code ) {
			return;
		}

		var params = typeof wc_checkout_params !== 'undefined' ? wc_checkout_params : null;
		if ( ! params ) {
			return;
		}

		var data = new URLSearchParams();
		data.append( 'security', params.apply_coupon_nonce );
		data.append( 'coupon_code', code );

		fetch( params.ajax_url + '?action=apply_coupon', {
			method: 'POST',
			body: data,
			headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
		} ).then( function () {
			window.location.reload();
		} );
	} );
} )();
