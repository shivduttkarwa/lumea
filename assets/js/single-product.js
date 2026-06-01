( function () {
	'use strict';

	/* ── Gallery ── */
	var mainImg = document.getElementById( 'lumeaPdpMainImg' );
	document.querySelectorAll( '.lumea-pdp-thumb' ).forEach( function ( btn ) {
		btn.addEventListener( 'click', function () {
			document.querySelectorAll( '.lumea-pdp-thumb' ).forEach( function ( b ) {
				b.classList.remove( 'is-active' );
			} );
			btn.classList.add( 'is-active' );
			if ( ! mainImg ) return;
			mainImg.style.opacity   = '0';
			mainImg.style.transform = 'scale(0.97)';
			setTimeout( function () {
				mainImg.removeAttribute( 'srcset' );
				mainImg.removeAttribute( 'sizes' );
				mainImg.src             = btn.dataset.full;
				mainImg.style.opacity   = '1';
				mainImg.style.transform = 'scale(1)';
			}, 160 );
		} );
	} );

	/* ── Lightbox ── */
	var lb      = document.getElementById( 'lumeaLightbox' );
	var lbImg   = document.getElementById( 'lumeaLightboxImg' );
	var lbClose = document.getElementById( 'lumeaLightboxClose' );
	var zoomBtn = document.getElementById( 'lumeaZoomBtn' );

	function openLb() {
		if ( ! mainImg || ! lb ) return;
		lbImg.src = mainImg.src;
		lb.classList.add( 'is-open' );
		lb.setAttribute( 'aria-hidden', 'false' );
		document.body.style.overflow = 'hidden';
	}
	function closeLb() {
		lb.classList.remove( 'is-open' );
		lb.setAttribute( 'aria-hidden', 'true' );
		document.body.style.overflow = '';
	}
	if ( zoomBtn ) zoomBtn.addEventListener( 'click', openLb );
	if ( lbClose ) lbClose.addEventListener( 'click', closeLb );
	if ( lb ) {
		lb.addEventListener( 'click', function ( e ) { if ( e.target === lb ) closeLb(); } );
		document.addEventListener( 'keydown', function ( e ) { if ( e.key === 'Escape' ) closeLb(); } );
	}

	/* ── Qty stepper ── */
	var qtyInput = document.querySelector( '.lumea-qty-input' );
	if ( qtyInput ) {
		var minusBtn = document.querySelector( '.lumea-qty-minus' );
		var plusBtn  = document.querySelector( '.lumea-qty-plus' );
		if ( minusBtn ) {
			minusBtn.addEventListener( 'click', function () {
				var v   = parseInt( qtyInput.value, 10 );
				var min = parseInt( qtyInput.min, 10 ) || 1;
				if ( v > min ) { qtyInput.value = v - 1; qtyInput.dispatchEvent( new Event( 'change' ) ); }
			} );
		}
		if ( plusBtn ) {
			plusBtn.addEventListener( 'click', function () {
				var v   = parseInt( qtyInput.value, 10 );
				var max = parseInt( qtyInput.max, 10 ) || 999;
				if ( v < max ) { qtyInput.value = v + 1; qtyInput.dispatchEvent( new Event( 'change' ) ); }
			} );
		}
	}

	/* ── Accordion ── */
	document.querySelectorAll( '[data-acc]' ).forEach( function ( acc ) {
		var trigger = acc.querySelector( '[data-acc-trigger]' );
		var body    = acc.querySelector( '[data-acc-body]' );
		if ( ! trigger || ! body ) return;
		if ( body.classList.contains( 'is-open' ) ) {
			body.style.maxHeight = body.scrollHeight + 'px';
		} else {
			body.style.maxHeight = '0';
		}
		trigger.addEventListener( 'click', function () {
			var open = body.classList.contains( 'is-open' );
			body.classList.toggle( 'is-open', ! open );
			trigger.classList.toggle( 'is-open', ! open );
			trigger.setAttribute( 'aria-expanded', String( ! open ) );
			body.style.maxHeight = open ? '0' : body.scrollHeight + 'px';
		} );
	} );

	/* ── Wishlist toggle (UI only) ── */
	document.querySelectorAll( '.lumea-pdp-wish-btn' ).forEach( function ( btn ) {
		btn.addEventListener( 'click', function () {
			btn.classList.toggle( 'is-active' );
		} );
	} );

	/* ── Sticky panel (desktop only) ── */
	var infoPanel = document.getElementById( 'lumeaPdpInfo' );
	if ( infoPanel && window.innerWidth >= 1024 ) {
		infoPanel.style.position  = 'sticky';
		infoPanel.style.top       = '96px';
		infoPanel.style.alignSelf = 'start';
	}

} )();
