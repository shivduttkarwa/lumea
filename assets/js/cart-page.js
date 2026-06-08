( function () {
	'use strict';

	var cartData = window.lumeaCartData || {};
	var i18n     = cartData.i18n || {};

	function applyFragments( fragments ) {
		if ( ! fragments || typeof fragments !== 'object' ) return;
		Object.keys( fragments ).forEach( function ( selector ) {
			var el = document.querySelector( selector );
			if ( ! el ) return;
			var tmp = document.createElement( 'div' );
			tmp.innerHTML = fragments[ selector ];
			if ( tmp.firstChild ) {
				el.parentNode.replaceChild( tmp.firstChild, el );
			}
		} );
	}

	function bindCartInteractions( cartPage ) {
		var root = cartPage || document.querySelector( '.lumea-cart-page' );
		if ( ! root ) return;

		var cartForm = root.querySelector( '.lumea-cart-form' );
		if ( ! cartForm || cartForm.dataset.lumeaBound === '1' ) return;
		cartForm.dataset.lumeaBound = '1';

		var totalsWrap = root.querySelector( '[data-lumea-cart-summary-totals]' );
		var titleNode  = root.querySelector( '.lumea-cart-title' );
		var rowState   = new WeakMap();
		var errorTimer = null;

		function updateTotalsMarkup( markup ) {
			if ( ! totalsWrap || ! markup ) return;
			var tmp  = document.createElement( 'div' );
			tmp.innerHTML = markup;
			var curTable  = totalsWrap.querySelector( '.shop_table.shop_table_responsive' );
			var nextTable = tmp.querySelector( '.shop_table.shop_table_responsive' );
			if ( ! curTable || ! nextTable ) {
				totalsWrap.innerHTML = markup;
				return;
			}
			var curBody  = curTable.querySelector( 'tbody' );
			var nextBody = nextTable.querySelector( 'tbody' );
			if ( curBody && nextBody ) {
				curBody.innerHTML = nextBody.innerHTML;
			} else {
				totalsWrap.innerHTML = markup;
			}
		}

		function showTransientError() {
			var notice = root.querySelector( '.lumea-cart-live-error' );
			if ( ! notice ) {
				notice = document.createElement( 'div' );
				notice.className = 'lumea-cart-live-error';
				notice.setAttribute( 'role', 'status' );
				notice.setAttribute( 'aria-live', 'polite' );
				notice.textContent = i18n.qtyError || '';
				var hero = root.querySelector( '.lumea-cart-hero-inner' );
				if ( hero ) { hero.appendChild( notice ); } else { root.prepend( notice ); }
			}
			notice.classList.add( 'is-visible' );
			if ( errorTimer ) window.clearTimeout( errorTimer );
			errorTimer = window.setTimeout( function () {
				notice.classList.remove( 'is-visible' );
			}, 2200 );
		}

		function getState( row ) {
			var state = rowState.get( row );
			if ( ! state ) {
				state = { timer: null, busy: false, pendingQty: null, lastSentQty: null };
				rowState.set( row, state );
			}
			return state;
		}

		function clampQty( input, rawValue ) {
			var qty = parseInt( rawValue, 10 );
			var min = parseInt( input.min, 10 );
			var max = parseInt( input.max, 10 );
			if ( ! Number.isFinite( qty ) ) qty = Number.isFinite( min ) ? min : 1;
			if ( Number.isFinite( min ) && qty < min ) qty = min;
			if ( Number.isFinite( max ) && max > 0 && qty > max ) qty = max;
			return qty;
		}

		function queueRowUpdate( row, immediate ) {
			if ( ! row ) return;
			var state = getState( row );
			if ( state.timer ) window.clearTimeout( state.timer );
			state.timer = window.setTimeout( function () {
				submitRowUpdate( row );
			}, immediate ? 0 : 220 );
		}

		function replaceWithEmptyState() {
			var body = root.querySelector( '.lumea-cart-body' );
			if ( body ) body.remove();

			var existing = root.querySelector( '.lumea-cart-empty' );
			if ( existing ) {
				existing.hidden = false;
				return;
			}

			var shopUrl  = ( window.lumeaData && window.lumeaData.shopUrl ) ? window.lumeaData.shopUrl : '';
			var heroImg  = cartData.heroImage || '';

			var markup =
				'<div class="lumea-cart-empty">' +
					'<div class="lumea-cart-empty-stage">' +
						'<div class="lumea-cart-empty-copy">' +
							'<div class="lumea-cart-empty-icon" aria-hidden="true">' +
								'<svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.1" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 01-8 0"/></svg>' +
							'</div>' +
							'<p class="lumea-cart-empty-eyebrow">' + ( i18n.yourBag || '' ) + '</p>' +
							'<h2 class="lumea-cart-empty-title">' + ( i18n.nothingYet || '' ) + '</h2>' +
							'<p class="lumea-cart-empty-text">' + ( i18n.emptyText || '' ) + '</p>' +
							'<div class="lumea-cart-empty-actions">' +
								'<a href="' + shopUrl + '" class="lumea-cart-empty-btn-primary">' + ( i18n.shopAll || '' ) + '</a>' +
							'</div>' +
						'</div>' +
						'<div class="lumea-cart-empty-visual" aria-hidden="true">' +
							'<img src="' + heroImg + '" alt="" class="lumea-cart-empty-img" loading="lazy">' +
							'<div class="lumea-cart-empty-visual-badge">' +
								'<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>' +
								( i18n.freeReturns || '' ) +
							'</div>' +
						'</div>' +
					'</div>' +
				'</div>';

			root.insertAdjacentHTML( 'beforeend', markup );
		}

		function submitRowUpdate( row ) {
			if ( ! row ) return;
			var state     = getState( row );
			var input     = row.querySelector( '.lumea-qty-input' );
			var key       = row.getAttribute( 'data-key' );
			var nonceNode = cartForm.querySelector( 'input[name="woocommerce-cart-nonce"]' );
			if ( ! input || ! key || ! nonceNode || typeof window.lumeaData === 'undefined' ) return;

			var qty = clampQty( input, input.value );
			input.value = String( qty );

			if ( state.busy ) { state.pendingQty = qty; return; }
			if ( state.lastSentQty === qty ) return;

			state.busy        = true;
			state.lastSentQty = qty;
			var didSucceed    = false;
			row.classList.add( 'is-updating' );

			fetch( window.lumeaData.ajaxUrl, {
				method: 'POST',
				credentials: 'same-origin',
				headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
				body:
					'action=lumea_update_cart_line_qty' +
					'&cart_nonce=' + encodeURIComponent( nonceNode.value || '' ) +
					'&cart_item_key=' + encodeURIComponent( key ) +
					'&quantity=' + encodeURIComponent( String( qty ) ),
			} )
				.then( function ( response ) {
					if ( ! response.ok ) throw new Error( 'network_error' );
					return response.json();
				} )
				.then( function ( payload ) {
					if ( ! payload || ! payload.success || ! payload.data ) throw new Error( 'failed' );
					var data = payload.data;
					if ( data.removed ) {
						row.remove();
					} else {
						var totalNode = row.querySelector( '.lumea-cart-row-total' );
						if ( totalNode && typeof data.row_subtotal_html !== 'undefined' ) {
							totalNode.innerHTML = data.row_subtotal_html;
						}
						if ( typeof data.quantity !== 'undefined' ) {
							input.value = String( data.quantity );
						}
					}
					if ( data.cart_totals_html ) updateTotalsMarkup( data.cart_totals_html );
					if ( titleNode && data.hero_title ) titleNode.textContent = data.hero_title;
					applyFragments( data.fragments || {} );
					didSucceed = true;
					if ( data.cart_empty ) replaceWithEmptyState();
				} )
				.catch( function () { showTransientError(); } )
				.finally( function () {
					state.busy = false;
					if ( ! didSucceed ) state.lastSentQty = null;
					row.classList.remove( 'is-updating' );
					if ( state.pendingQty !== null && state.pendingQty !== state.lastSentQty ) {
						input.value = String( state.pendingQty );
						state.pendingQty = null;
						submitRowUpdate( row );
					} else {
						state.pendingQty = null;
					}
				} );
		}

		cartForm.querySelectorAll( '.lumea-cart-row' ).forEach( function ( row ) {
			var input = row.querySelector( '.lumea-qty-input' );
			var minus = row.querySelector( '.lumea-qty-minus' );
			var plus  = row.querySelector( '.lumea-qty-plus' );
			if ( ! input ) return;

			input.addEventListener( 'keydown', function ( e ) {
				if ( e.key === 'Enter' ) e.preventDefault();
			} );
			input.addEventListener( 'input',  function () { queueRowUpdate( row, false ); } );
			input.addEventListener( 'change', function () { queueRowUpdate( row, true ); } );

			if ( minus ) {
				minus.addEventListener( 'click', function ( e ) {
					e.preventDefault();
					var v = parseInt( input.value, 10 );
					var m = parseInt( input.min, 10 ) || 1;
					if ( v > m ) { input.value = v - 1; queueRowUpdate( row, true ); }
				} );
			}
			if ( plus ) {
				plus.addEventListener( 'click', function ( e ) {
					e.preventDefault();
					var v = parseInt( input.value, 10 );
					var x = parseInt( input.max, 10 ) || 999;
					if ( v < x ) { input.value = v + 1; queueRowUpdate( row, true ); }
				} );
			}
		} );

		cartForm.addEventListener( 'submit', function ( e ) {
			e.preventDefault();
			cartForm.querySelectorAll( '.lumea-cart-row' ).forEach( function ( row ) {
				queueRowUpdate( row, true );
			} );
		} );
	}

	bindCartInteractions( document.querySelector( '.lumea-cart-page' ) );
} )();
