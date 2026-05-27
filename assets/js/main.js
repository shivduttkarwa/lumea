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
    btn.setAttribute('aria-label',
      btn.classList.contains('is-wished') ? 'Remove from wishlist' : 'Add to wishlist');
  });

  /* Swap each fragment selector in the DOM with the server-rendered HTML. */
  function applyFragments(fragments) {
    if (!fragments || typeof fragments !== 'object') return;
    Object.keys(fragments).forEach(function (sel) {
      var el = document.querySelector(sel);
      if (!el) return;
      var tmp = document.createElement('div');
      tmp.innerHTML = fragments[sel];
      if (tmp.firstChild) el.parentNode.replaceChild(tmp.firstChild, el);
    });
  }

  /* POST qty change; calls done(true|false) when the request settles. */
  function updateCartQty(productId, qty, done) {
    if (typeof lumeaData === 'undefined') { done(false); return; }
    fetch(lumeaData.ajaxUrl, {
      method: 'POST', credentials: 'same-origin',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
      body: 'action=lumea_update_cart_qty&nonce=' + encodeURIComponent(lumeaData.nonce) +
            '&product_id=' + encodeURIComponent(productId) + '&quantity=' + encodeURIComponent(qty)
    })
      .then(function (r) { return r.json(); })
      .then(function (data) { if (data.success) applyFragments(data.data.fragments); done(!!data.success); })
      .catch(function () { done(false); });
  }

  document.addEventListener('click', function (e) {

    /* Add to Cart → morph to stepper */
    var addBtn = e.target.closest('.lumea-card-atc-wrap .add_to_cart_button');
    if (addBtn) {
      var wrap     = addBtn.closest('.lumea-card-atc-wrap');
      var viewCart = addBtn.closest('.lumea-card-actions').querySelector('[data-lumea-view-cart]');
      if (wrap)     wrap.classList.add('is-added');
      if (viewCart) viewCart.classList.add('is-active');
      return;
    }

    /* + / − stepper buttons */
    var btn = e.target.closest('.lumea-qty-plus, .lumea-qty-minus');
    if (!btn) return;

    var stepper   = btn.closest('[data-lumea-qty]');
    if (!stepper || stepper.dataset.busy) return;   /* block while request is in-flight */

    var isPlus    = btn.classList.contains('lumea-qty-plus');
    var numEl     = stepper.querySelector('.lumea-qty-num');
    var plusBtn   = stepper.querySelector('.lumea-qty-plus');
    var productId = plusBtn && plusBtn.getAttribute('data-product_id');
    if (!productId) return;

    var current  = parseInt(numEl.textContent, 10) || 1;
    var newQty   = isPlus ? current + 1 : current - 1;
    var atcWrap  = stepper.closest('.lumea-card-atc-wrap');
    var cartLink = atcWrap && atcWrap.closest('.lumea-card-actions').querySelector('[data-lumea-view-cart]');

    /* Optimistic UI update */
    if (newQty === 0) {
      numEl.textContent = '1';
      if (atcWrap)  atcWrap.classList.remove('is-added');
      if (cartLink) cartLink.classList.remove('is-active');
    } else {
      numEl.textContent = newQty;
    }

    stepper.dataset.busy = '1';
    updateCartQty(productId, newQty, function (ok) {
      delete stepper.dataset.busy;
      if (ok) return;
      /* Rollback on failure */
      numEl.textContent = current;
      if (newQty === 0) {
        if (atcWrap)  atcWrap.classList.add('is-added');
        if (cartLink) cartLink.classList.add('is-active');
      }
    });
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
