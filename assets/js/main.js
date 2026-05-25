/**
 * Luméa — Main JavaScript
 * Scroll reveal, sticky header, mobile menu, marquee pause on hover.
 */
( function () {
	'use strict';

	document.documentElement.classList.add( 'lumea-js-ready' );

	/* ─────────────────────────────────────────
	   Scroll Reveal (IntersectionObserver)
	───────────────────────────────────────── */
	function initReveal() {
		if ( ! ( 'IntersectionObserver' in window ) ) {
			document.querySelectorAll( '.lumea-reveal' ).forEach( function ( el ) {
				el.classList.add( 'is-visible' );
			} );
			return;
		}

		var observer = new IntersectionObserver(
			function ( entries ) {
				entries.forEach( function ( entry ) {
					if ( entry.isIntersecting ) {
						entry.target.classList.add( 'is-visible' );
						observer.unobserve( entry.target );
					}
				} );
			},
			{ threshold: 0.12, rootMargin: '0px 0px -40px 0px' }
		);

		document.querySelectorAll( '.lumea-reveal' ).forEach( function ( el ) {
			observer.observe( el );
		} );
	}

	/* ─────────────────────────────────────────
	   Sticky Header — add class on scroll
	───────────────────────────────────────── */
	function initStickyHeader() {
		var header = document.querySelector( '.lumea-site-header' );
		if ( ! header ) return;

		var ticking = false;

		function onScroll() {
			if ( ! ticking ) {
				requestAnimationFrame( function () {
					header.classList.toggle( 'is-scrolled', window.scrollY > 40 );
					ticking = false;
				} );
				ticking = true;
			}
		}

		window.addEventListener( 'scroll', onScroll, { passive: true } );
		onScroll();
	}

	/* ─────────────────────────────────────────
	   Mobile Menu Toggle
	───────────────────────────────────────── */
	function initMobileMenu() {
		var btn = document.querySelector( '.lumea-mobile-menu-btn' );
		var nav = document.querySelector( '.lumea-mobile-nav' );
		if ( ! btn || ! nav ) return;

		btn.addEventListener( 'click', function () {
			var isOpen = nav.classList.toggle( 'is-open' );
			btn.setAttribute( 'aria-expanded', String( isOpen ) );
			document.body.style.overflow = isOpen ? 'hidden' : '';
		} );

		// Close on nav link click
		nav.querySelectorAll( '.lumea-nav-link' ).forEach( function ( link ) {
			link.addEventListener( 'click', function () {
				nav.classList.remove( 'is-open' );
				btn.setAttribute( 'aria-expanded', 'false' );
				document.body.style.overflow = '';
			} );
		} );

		// Close on Escape
		document.addEventListener( 'keydown', function ( e ) {
			if ( e.key === 'Escape' && nav.classList.contains( 'is-open' ) ) {
				nav.classList.remove( 'is-open' );
				btn.setAttribute( 'aria-expanded', 'false' );
				document.body.style.overflow = '';
				btn.focus();
			}
		} );
	}

	/* ─────────────────────────────────────────
	   Marquee — pause on hover / focus
	───────────────────────────────────────── */
	function initMarquee() {
		var strip = document.querySelector( '.lumea-marquee-strip' );
		var track = document.querySelector( '.lumea-marquee-track' );
		if ( ! strip || ! track ) return;

		strip.addEventListener( 'mouseenter', function () {
			track.style.animationPlayState = 'paused';
		} );
		strip.addEventListener( 'mouseleave', function () {
			track.style.animationPlayState = 'running';
		} );
		strip.addEventListener( 'focusin', function () {
			track.style.animationPlayState = 'paused';
		} );
		strip.addEventListener( 'focusout', function () {
			track.style.animationPlayState = 'running';
		} );
	}

	/* ─────────────────────────────────────────
	   Newsletter Form — basic client validation
	───────────────────────────────────────── */
	function initNewsletter() {
		var form = document.querySelector( '.lumea-newsletter-form' );
		if ( ! form ) return;

		form.addEventListener( 'submit', function ( e ) {
			e.preventDefault();
			var input  = form.querySelector( '.lumea-newsletter-input' );
			var submit = form.querySelector( '.lumea-newsletter-submit' );
			if ( ! input || ! input.value.trim() ) return;

			submit.disabled    = true;
			submit.textContent = submit.getAttribute( 'data-sending' ) || 'Sending…';

			// Replace with real submission (Mailchimp / Klaviyo / etc.)
			setTimeout( function () {
				form.innerHTML =
					'<p style="color:var(--lumea-text-light);font-size:15px;font-weight:300;text-align:center;">' +
					( form.getAttribute( 'data-success' ) || 'Thank you! Check your inbox for your 15% discount.' ) +
					'</p>';
			}, 900 );
		} );
	}

	/* ─────────────────────────────────────────
	   Smooth anchor scroll (supplement html { scroll-behavior })
	───────────────────────────────────────── */
	function initSmoothAnchors() {
		var header = document.querySelector( '.lumea-site-header' );
		document.querySelectorAll( 'a[href^="#"]' ).forEach( function ( anchor ) {
			anchor.addEventListener( 'click', function ( e ) {
				var targetId = anchor.getAttribute( 'href' ).slice( 1 );
				var target   = document.getElementById( targetId );
				if ( ! target ) return;
				e.preventDefault();
				var offset = header ? header.offsetHeight + 16 : 80;
				window.scrollTo( {
					top:      target.getBoundingClientRect().top + window.scrollY - offset,
					behavior: 'smooth',
				} );
			} );
		} );
	}

	/* ─────────────────────────────────────────
	   Init
	───────────────────────────────────────── */
	function init() {
		initReveal();
		initStickyHeader();
		initMobileMenu();
		initMarquee();
		initNewsletter();
		initSmoothAnchors();
	}

	if ( document.readyState === 'loading' ) {
		document.addEventListener( 'DOMContentLoaded', init );
	} else {
		init();
	}
} )();
