/**
 * Luméa main JavaScript.
 */

(function () {
  'use strict';

  document.documentElement.classList.add('lumea-js-ready');

  /* ── Sticky Header ─────────────────────────────────────── */

  var header    = document.getElementById('lumeaHeader');
  var mobileNav = document.querySelector('[data-lumea-mobile-nav]');
  var navToggle = document.querySelector('[data-lumea-nav-toggle]');

  if (header) {
    var lastScroll = 0;

    function updateHeader() {
      var current = window.scrollY;

      /* Scrolled state (solid bg) */
      header.classList.toggle('is-scrolled', current > 40);

      /* Hide on scroll down, show on scroll up */
      if (current > 60) {
        if (current > lastScroll) {
          header.classList.add('is-hidden');
        } else {
          header.classList.remove('is-hidden');
        }
      } else {
        header.classList.remove('is-hidden');
      }

      lastScroll = current;
    }

    updateHeader();
    window.addEventListener('scroll', updateHeader, { passive: true });
  }

  /* ── Mobile Nav ─────────────────────────────────────────── */

  if (navToggle && mobileNav) {
    navToggle.addEventListener('click', function () {
      var isOpen = mobileNav.classList.toggle('is-open');
      navToggle.classList.toggle('is-open', isOpen);
      navToggle.setAttribute('aria-expanded', isOpen);
      mobileNav.setAttribute('aria-hidden', !isOpen);
      document.body.style.overflow = isOpen ? 'hidden' : '';
    });

    mobileNav.querySelectorAll('a').forEach(function (link) {
      link.addEventListener('click', function () {
        mobileNav.classList.remove('is-open');
        navToggle.classList.remove('is-open');
        navToggle.setAttribute('aria-expanded', 'false');
        mobileNav.setAttribute('aria-hidden', 'true');
        document.body.style.overflow = '';
      });
    });
  }

  /* ── Cart Drawer ────────────────────────────────────────── */

  var drawer   = document.querySelector('[data-lumea-cart-drawer]');
  var overlay  = document.querySelector('[data-lumea-cart-overlay]');
  var triggers = document.querySelectorAll('[data-lumea-cart-trigger]');
  var closes   = document.querySelectorAll('[data-lumea-cart-close]');

  if (!drawer) return;

  function openDrawer() {
    drawer.classList.add('is-open');
    overlay.classList.add('is-open');
    drawer.setAttribute('aria-hidden', 'false');
    overlay.setAttribute('aria-hidden', 'false');
    document.body.style.overflow = 'hidden';
  }

  function closeDrawer() {
    drawer.classList.remove('is-open');
    overlay.classList.remove('is-open');
    drawer.setAttribute('aria-hidden', 'true');
    overlay.setAttribute('aria-hidden', 'true');
    document.body.style.overflow = '';
  }

  triggers.forEach(function (btn) {
    btn.addEventListener('click', openDrawer);
  });

  closes.forEach(function (btn) {
    btn.addEventListener('click', closeDrawer);
  });

  overlay.addEventListener('click', closeDrawer);

  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape') closeDrawer();
  });

  /* Open drawer automatically after WooCommerce AJAX add to cart */
  document.body.addEventListener('added_to_cart', function () {
    openDrawer();
  });

})();

/* ── Product card: wishlist toggle + qty stepper ────────────── */
(function () {
  'use strict';

  /* Wishlist toggle */
  document.addEventListener('click', function (e) {
    var btn = e.target.closest('[data-lumea-wish]');
    if (!btn) return;
    e.preventDefault();
    btn.classList.toggle('is-wished');
    btn.setAttribute(
      'aria-label',
      btn.classList.contains('is-wished') ? 'Remove from wishlist' : 'Add to wishlist'
    );
  });

  /* Show qty stepper after first add-to-cart, then handle +/- */
  document.addEventListener('click', function (e) {

    /* Add to Cart clicked → morph button into stepper + show View Cart */
    var addBtn = e.target.closest('.lumea-card-atc-wrap .add_to_cart_button');
    if (addBtn) {
      var atcWrap  = addBtn.closest('.lumea-card-atc-wrap');
      var viewCart = addBtn.closest('.lumea-card-actions').querySelector('[data-lumea-view-cart]');
      if (atcWrap)  atcWrap.classList.add('is-added');
      if (viewCart) viewCart.classList.add('is-active');
      return;
    }

    /* + button → increment display + add 1 more via WC AJAX */
    var plusBtn = e.target.closest('.lumea-qty-plus');
    if (plusBtn) {
      var numEl   = plusBtn.closest('[data-lumea-qty]').querySelector('.lumea-qty-num');
      var current = parseInt(numEl.textContent, 10) || 1;
      numEl.textContent = current + 1;

      var productId = plusBtn.getAttribute('data-product_id');
      if (productId && typeof wc_add_to_cart_params !== 'undefined') {
        var url  = wc_add_to_cart_params.wc_ajax_url.replace('%%endpoint%%', 'add_to_cart');
        var body = 'product_id=' + encodeURIComponent(productId) + '&quantity=1';
        fetch(url, {
          method:  'POST',
          headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
          body:    body
        })
          .then(function (r) { return r.json(); })
          .then(function (data) {
            if (!data.error && typeof jQuery !== 'undefined') {
              jQuery(document.body).trigger('wc_fragment_refresh');
            }
          });
      }
      return;
    }

    /* − button → decrement; at 0 revert to Add to Cart */
    var minusBtn = e.target.closest('.lumea-qty-minus');
    if (minusBtn) {
      var atcWrap2 = minusBtn.closest('.lumea-card-atc-wrap');
      var numEl2   = minusBtn.closest('[data-lumea-qty]').querySelector('.lumea-qty-num');
      var current2 = parseInt(numEl2.textContent, 10) || 1;
      if (current2 > 1) {
        numEl2.textContent = current2 - 1;
      } else {
        numEl2.textContent = '1';
        if (atcWrap2) {
          atcWrap2.classList.remove('is-added');
          var viewCart2 = atcWrap2.closest('.lumea-card-actions').querySelector('[data-lumea-view-cart]');
          if (viewCart2) viewCart2.classList.remove('is-active');
        }
      }
      return;
    }

  });


})();

/* ── Shop filter dropdowns ──────────────────────────────────── */
(function () {
  'use strict';

  var dropdowns = document.querySelectorAll('[data-lumea-dropdown]');
  if (!dropdowns.length) return;

  function closeAll(except) {
    dropdowns.forEach(function (d) {
      if (d !== except) d.classList.remove('is-open');
    });
  }

  dropdowns.forEach(function (dropdown) {
    var trigger = dropdown.querySelector('[data-lumea-dropdown-trigger]');
    if (!trigger) return;

    trigger.addEventListener('click', function (e) {
      e.stopPropagation();
      var wasOpen = dropdown.classList.contains('is-open');
      closeAll();
      dropdown.classList.toggle('is-open', !wasOpen);
    });
  });

  document.addEventListener('click', function () {
    closeAll();
  });

  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape') closeAll();
  });

})();
