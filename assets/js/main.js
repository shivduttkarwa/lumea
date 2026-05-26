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
