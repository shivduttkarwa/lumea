/**
 * Luméa main JavaScript.
 */

(function () {
  'use strict';

  document.documentElement.classList.add('lumea-js-ready');

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
