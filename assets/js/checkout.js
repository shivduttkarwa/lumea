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
		data.append( 'billing_email', document.getElementById( 'billing_email' ) ? document.getElementById( 'billing_email' ).value : '' );

		var couponUrl = params.wc_ajax_url
			? params.wc_ajax_url.toString().replace( '%%endpoint%%', 'apply_coupon' )
			: params.ajax_url + '?action=apply_coupon';

		fetch( couponUrl, {
			method: 'POST',
			body: data,
			headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
		} ).then( function () {
			window.location.reload();
		} );
	} );
} )();
