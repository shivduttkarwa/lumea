/**
 * Lumea main JavaScript.
 */

(function () {
  'use strict';

  document.documentElement.classList.add('lumea-js-ready');

  var WISHLIST_STORAGE_KEY = 'lumeaWishlist';

  function i18n(key, fallback) {
    if (window.lumeaData && window.lumeaData.i18n && window.lumeaData.i18n[key]) {
      return String(window.lumeaData.i18n[key]);
    }
    return fallback;
  }

  function i18nWithName(templateKey, fallbackTemplate, name) {
    var template = i18n(templateKey, fallbackTemplate);
    return template.indexOf('%s') !== -1 ? template.replace('%s', name) : (template + ' ' + name);
  }

  function toPositiveInt(value) {
    var parsed = parseInt(value, 10);
    return Number.isFinite(parsed) && parsed > 0 ? parsed : 0;
  }

  function normalizeWishlistIds(ids) {
    var map = {};
    var clean = [];

    (ids || []).forEach(function (id) {
      var normalized = toPositiveInt(id);
      if (!normalized || map[normalized]) {
        return;
      }
      map[normalized] = true;
      clean.push(normalized);
    });

    return clean;
  }

  function getWishlistIds() {
    try {
      var stored = window.localStorage.getItem(WISHLIST_STORAGE_KEY);
      if (!stored) {
        return [];
      }
      var parsed = JSON.parse(stored);
      return normalizeWishlistIds(Array.isArray(parsed) ? parsed : []);
    } catch (error) {
      return [];
    }
  }

  function setWishlistIds(ids) {
    var normalized = normalizeWishlistIds(ids);
    try {
      window.localStorage.setItem(WISHLIST_STORAGE_KEY, JSON.stringify(normalized));
    } catch (error) {
      return normalized;
    }
    return normalized;
  }

  function escapeHtml(value) {
    return String(value || '')
      .replace(/&/g, '&amp;')
      .replace(/</g, '&lt;')
      .replace(/>/g, '&gt;')
      .replace(/"/g, '&quot;')
      .replace(/'/g, '&#39;');
  }

  function sanitizeClassToken(value) {
    return String(value || '').toLowerCase().replace(/[^a-z0-9_-]/g, '') || 'simple';
  }

  function getWishlistButtonProductId(button) {
    if (!button) {
      return 0;
    }

    var directId = button.getAttribute('data-product_id') || button.getAttribute('data-wishlist-toggle');
    if (directId) {
      return toPositiveInt(directId);
    }

    var productRoot = button.closest('.lumea-best-card, .lumea-lp-card, .lumea-shop-card, .product, .type-product');
    if (!productRoot) {
      return 0;
    }

    var productButton = productRoot.querySelector('[data-product_id]');
    if (productButton) {
      return toPositiveInt(productButton.getAttribute('data-product_id'));
    }

    return 0;
  }

  function getAllWishlistButtons() {
    return document.querySelectorAll('[data-lumea-wish], [data-wishlist-toggle]');
  }

  function setWishlistButtonState(button, isActive) {
    var activeClass = button.hasAttribute('data-wishlist-toggle') ? 'is-active' : 'is-wished';
    button.classList.toggle(activeClass, isActive);
    button.setAttribute('aria-pressed', isActive ? 'true' : 'false');
    button.setAttribute('aria-label', isActive ? i18n('removeFromWishlist', 'Remove from wishlist') : i18n('addToWishlist', 'Add to wishlist'));
  }

  function syncWishlistButtons() {
    var ids = getWishlistIds();

    getAllWishlistButtons().forEach(function (button) {
      var productId = getWishlistButtonProductId(button);
      if (!productId) {
        setWishlistButtonState(button, false);
        return;
      }
      setWishlistButtonState(button, ids.indexOf(productId) !== -1);
    });
  }

  function updateWishlistCountBadge() {
    var count = getWishlistIds().length;
    var badges = document.querySelectorAll('.lumea-wishlist-count');

    badges.forEach(function (badge) {
      if (!badge) {
        return;
      }
      if (count > 0) {
        badge.textContent = String(count);
        badge.classList.add('lumea-wishlist-count--visible');
      } else {
        badge.textContent = '';
        badge.classList.remove('lumea-wishlist-count--visible');
      }
    });
  }

  function setWishlistCountText(count) {
    document.querySelectorAll('[data-lumea-wishlist-count-text]').forEach(function (node) {
      node.textContent = String(count);
    });
  }

  function renderWishlistDrawer(items) {
    var list = document.querySelector('[data-lumea-wishlist-items]');
    var empty = document.querySelector('[data-lumea-wishlist-empty]');

    if (!list || !empty) {
      return;
    }

    if (!items.length) {
      list.innerHTML = '';
      empty.hidden = false;
      return;
    }

    empty.hidden = true;

    list.innerHTML = items.map(function (item) {
      var actionLabel = item.can_add_to_cart ? (item.cart_text || i18n('addToCart', 'Add to Cart')) : i18n('viewProduct', 'View Product');
      var actionUrl = item.can_add_to_cart ? item.cart_url : item.url;
      var actionAria = item.cart_aria || actionLabel;
      var buttonClass = 'lumea-wishlist-item-btn';
      var removeLabel = i18nWithName('removeFromWishlistOf', 'Remove %s from wishlist', item.name);

      if (item.can_add_to_cart) {
        buttonClass += ' add_to_cart_button button product_type_' + sanitizeClassToken(item.type);
        if (item.supports_ajax) {
          buttonClass += ' ajax_add_to_cart';
        }
      }

      return [
        '<article class="lumea-wishlist-item">',
          item.image ? '<a href="' + escapeHtml(item.url) + '"><img class="lumea-wishlist-item-img" src="' + escapeHtml(item.image) + '" alt="' + escapeHtml(item.name) + '" loading="lazy"></a>' : '',
          '<div class="lumea-wishlist-item-info">',
            '<h3 class="lumea-wishlist-item-name"><a href="' + escapeHtml(item.url) + '">' + escapeHtml(item.name) + '</a></h3>',
            '<p class="lumea-wishlist-item-price">' + escapeHtml(item.price) + '</p>',
            '<a href="' + escapeHtml(actionUrl) + '" class="' + escapeHtml(buttonClass) + '"' + (item.can_add_to_cart ? ' data-product_id="' + item.id + '" data-product_type="' + escapeHtml(sanitizeClassToken(item.type)) + '" data-quantity="1" rel="nofollow"' : '') + ' aria-label="' + escapeHtml(actionAria) + '">',
              escapeHtml(actionLabel),
            '</a>',
          '</div>',
          '<button class="lumea-wishlist-item-remove" type="button" data-lumea-wishlist-remove="' + item.id + '" aria-label="' + escapeHtml(removeLabel) + '">',
            '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>',
          '</button>',
        '</article>'
      ].join('');
    }).join('');
  }

  function renderWishlistPage(items) {
    var list = document.querySelector('[data-lumea-wishlist-page-items]');
    var empty = document.querySelector('[data-lumea-wishlist-page-empty]');

    if (!list || !empty) {
      return;
    }

    if (!items.length) {
      list.innerHTML = '';
      empty.hidden = false;
      return;
    }

    empty.hidden = true;

    list.innerHTML = items.map(function (item) {
      var actionLabel = item.can_add_to_cart ? (item.cart_text || i18n('addToCart', 'Add to Cart')) : i18n('viewProduct', 'View Product');
      var actionAria = item.cart_aria || actionLabel;
      var removeLabel = i18nWithName('removeFromWishlistOf', 'Remove %s from wishlist', item.name);
      var cartUrl = (window.lumeaData && window.lumeaData.cartUrl) ? window.lumeaData.cartUrl : '#';
      var removeText = i18n('remove', 'Remove');
      var qtyLabel = i18n('quantity', 'Quantity');
      var decreaseLabel = i18n('decrease', 'Decrease');
      var increaseLabel = i18n('increase', 'Increase');
      var viewCartLabel = i18n('viewCart', 'View Cart');
      var productType = sanitizeClassToken(item.type);
      var atcButtonClass = 'lumea-btn btn-black add_to_cart_button button product_type_' + productType;
      var actionMarkup = '';

      if (item.can_add_to_cart) {
        if (item.supports_ajax) {
          atcButtonClass += ' ajax_add_to_cart';
        }
        actionMarkup = [
          '<div class="lumea-card-actions lumea-wishlist-page-card-actions">',
            '<div class="lumea-card-atc-wrap">',
              '<a href="' + escapeHtml(item.cart_url) + '" class="' + escapeHtml(atcButtonClass) + '" data-product_id="' + item.id + '" data-product_type="' + escapeHtml(productType) + '" data-quantity="1" rel="nofollow" aria-label="' + escapeHtml(actionAria) + '">',
                escapeHtml(actionLabel),
              '</a>',
              '<div class="lumea-qty-stepper" aria-label="' + escapeHtml(qtyLabel) + '" data-lumea-qty>',
                '<button class="lumea-qty-btn lumea-qty-minus" type="button" aria-label="' + escapeHtml(decreaseLabel) + '">&#8722;</button>',
                '<span class="lumea-qty-num">1</span>',
                '<button class="lumea-qty-btn lumea-qty-plus" type="button" aria-label="' + escapeHtml(increaseLabel) + '" data-product_id="' + item.id + '">&#43;</button>',
              '</div>',
            '</div>',
            '<a href="' + escapeHtml(cartUrl) + '" class="lumea-view-cart-btn" data-lumea-view-cart>',
              '<svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"></path><line x1="3" y1="6" x2="21" y2="6"></line><path d="M16 10a4 4 0 01-8 0"></path></svg>',
              '<span>' + escapeHtml(viewCartLabel) + '</span>',
            '</a>',
          '</div>'
        ].join('');
      } else {
        actionMarkup = '<a href="' + escapeHtml(item.url) + '" class="lumea-btn btn-black lumea-wishlist-page-plain-btn" aria-label="' + escapeHtml(actionAria) + '">' + escapeHtml(actionLabel) + '</a>';
      }

      return [
        '<article class="lumea-wishlist-page-item">',
          '<button class="lumea-wishlist-page-remove" type="button" data-lumea-wishlist-remove="' + item.id + '" aria-label="' + escapeHtml(removeLabel) + '">',
            '<svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>',
            '<span>' + escapeHtml(removeText) + '</span>',
          '</button>',
          '<a class="lumea-wishlist-page-media" href="' + escapeHtml(item.url) + '">',
            item.image ? '<img src="' + escapeHtml(item.image) + '" alt="' + escapeHtml(item.name) + '" loading="lazy">' : '<span class="lumea-wishlist-page-placeholder" aria-hidden="true"></span>',
          '</a>',
          '<div class="lumea-wishlist-page-main">',
            '<div class="lumea-wishlist-page-info">',
              '<h2 class="lumea-wishlist-page-item-title"><a href="' + escapeHtml(item.url) + '">' + escapeHtml(item.name) + '</a></h2>',
              '<p class="lumea-wishlist-page-item-price">' + escapeHtml(item.price) + '</p>',
            '</div>',
            actionMarkup,
          '</div>',
        '</article>'
      ].join('');
    }).join('');
  }

  function renderWishlistLoadingState() {
    var drawerList = document.querySelector('[data-lumea-wishlist-items]');
    var pageList = document.querySelector('[data-lumea-wishlist-page-items]');

    if (drawerList) {
      drawerList.innerHTML = '<p class="lumea-wishlist-loading">' + escapeHtml(i18n('loadingFavourites', 'Loading favourites...')) + '</p>';
    }

    if (pageList) {
      pageList.innerHTML = '<p class="lumea-wishlist-loading">' + escapeHtml(i18n('loadingFavourites', 'Loading favourites...')) + '</p>';
    }
  }

  function fetchWishlistItems(ids) {
    if (typeof window.lumeaData === 'undefined' || !window.lumeaData.ajaxUrl || !window.lumeaData.nonce) {
      return Promise.resolve([]);
    }

    var body = 'action=lumea_wishlist_items&nonce=' + encodeURIComponent(window.lumeaData.nonce);
    ids.forEach(function (id) {
      body += '&ids[]=' + encodeURIComponent(String(id));
    });

    return fetch(window.lumeaData.ajaxUrl, {
      method: 'POST',
      credentials: 'same-origin',
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded'
      },
      body: body
    })
      .then(function (response) {
        return response.json();
      })
      .then(function (payload) {
        if (!payload || !payload.success || !Array.isArray(payload.data)) {
          return [];
        }
        return payload.data;
      })
      .catch(function () {
        return [];
      });
  }

  function refreshWishlistPanels() {
    var ids = getWishlistIds();

    setWishlistCountText(ids.length);

    if (!ids.length) {
      renderWishlistDrawer([]);
      renderWishlistPage([]);
      return;
    }

    renderWishlistLoadingState();

    fetchWishlistItems(ids).then(function (items) {
      renderWishlistDrawer(items);
      renderWishlistPage(items);
    });
  }

  function refreshWishlistUI() {
    syncWishlistButtons();
    updateWishlistCountBadge();
    refreshWishlistPanels();
  }

  function toggleWishlistById(productId) {
    if (!productId) {
      return;
    }

    var ids = getWishlistIds();
    var index = ids.indexOf(productId);

    if (index === -1) {
      ids.push(productId);
    } else {
      ids.splice(index, 1);
    }

    setWishlistIds(ids);
    refreshWishlistUI();
  }

  function removeFromWishlist(productId) {
    var ids = getWishlistIds().filter(function (id) {
      return id !== productId;
    });
    setWishlistIds(ids);
    refreshWishlistUI();
  }

  /* Sticky Header */
  var header = document.getElementById('lumeaHeader');

  if (header) {
    function updateHeader() {
      var current = window.scrollY;
      header.classList.toggle('is-scrolled', current > 40);
    }

    updateHeader();
    window.addEventListener('scroll', updateHeader, { passive: true });
  }

  /* Mobile Nav */
  var mobileNav = document.querySelector('[data-lumea-mobile-nav]');
  var navToggle = document.querySelector('[data-lumea-nav-toggle]');

  if (navToggle && mobileNav) {
    navToggle.addEventListener('click', function () {
      var isOpen = mobileNav.classList.toggle('is-open');
      navToggle.classList.toggle('is-open', isOpen);
      navToggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
      mobileNav.setAttribute('aria-hidden', isOpen ? 'false' : 'true');
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

  /* Search Overlay */
  var searchOverlay = document.querySelector('[data-lumea-search-overlay]');
  var searchTriggers = document.querySelectorAll('[data-lumea-search-trigger]');
  var searchCloses = document.querySelectorAll('[data-lumea-search-close]');

  function openSearchOverlay() {
    if (!searchOverlay) {
      return;
    }
    searchOverlay.classList.add('is-open');
    searchOverlay.setAttribute('aria-hidden', 'false');
    document.body.style.overflow = 'hidden';

    var input = searchOverlay.querySelector('input[type="search"]');
    if (input) {
      window.setTimeout(function () {
        input.focus();
      }, 50);
    }
  }

  function closeSearchOverlay() {
    if (!searchOverlay) {
      return;
    }
    searchOverlay.classList.remove('is-open');
    searchOverlay.setAttribute('aria-hidden', 'true');
    document.body.style.overflow = '';
  }

  if (searchOverlay && searchTriggers.length) {
    searchTriggers.forEach(function (trigger) {
      trigger.addEventListener('click', function (event) {
        event.preventDefault();
        openSearchOverlay();
      });
    });

    searchCloses.forEach(function (closeBtn) {
      closeBtn.addEventListener('click', closeSearchOverlay);
    });

    searchOverlay.addEventListener('click', function (event) {
      if (event.target === searchOverlay) {
        closeSearchOverlay();
      }
    });
  }

  /* Account dropdown */
  var accountWrap = document.querySelector('[data-lumea-account-wrap]');
  var accountTrigger = document.querySelector('[data-lumea-account-trigger]');
  var accountDropdown = document.querySelector('[data-lumea-account-dropdown]');

  function closeAccountDropdown() {
    if (!accountTrigger || !accountDropdown) {
      return;
    }
    accountTrigger.setAttribute('aria-expanded', 'false');
    accountDropdown.classList.remove('is-open');
    accountDropdown.setAttribute('aria-hidden', 'true');
  }

  function toggleAccountDropdown() {
    if (!accountTrigger || !accountDropdown) {
      return;
    }

    var willOpen = accountTrigger.getAttribute('aria-expanded') !== 'true';
    accountTrigger.setAttribute('aria-expanded', willOpen ? 'true' : 'false');
    accountDropdown.classList.toggle('is-open', willOpen);
    accountDropdown.setAttribute('aria-hidden', willOpen ? 'false' : 'true');
  }

  if (accountTrigger && accountDropdown) {
    accountTrigger.addEventListener('click', function (event) {
      event.preventDefault();
      event.stopPropagation();
      toggleAccountDropdown();
    });

    document.addEventListener('click', function (event) {
      if (!accountWrap || accountWrap.contains(event.target)) {
        return;
      }
      closeAccountDropdown();
    });
  }

  /* Auth tabs (login/register) */
  var authTabButtons = document.querySelectorAll('[data-lumea-auth-tab]');
  var authPanels = document.querySelectorAll('.lumea-login-pane[role="tabpanel"]');

  function setActiveAuthTab(targetTab) {
    if (!targetTab) {
      return;
    }

    authTabButtons.forEach(function (button) {
      var isMatch = button.getAttribute('data-lumea-auth-tab') === targetTab;
      button.classList.toggle('is-active', isMatch);
      button.setAttribute('aria-selected', isMatch ? 'true' : 'false');
      button.setAttribute('tabindex', isMatch ? '0' : '-1');
    });

    authPanels.forEach(function (panel) {
      var panelId = panel.id || '';
      var isPanelMatch = (targetTab === 'login' && panelId === 'lumeaLoginPanel') || (targetTab === 'register' && panelId === 'lumeaRegisterPanel');
      panel.classList.toggle('is-active', isPanelMatch);
      panel.hidden = !isPanelMatch;
    });
  }

  if (authTabButtons.length && authPanels.length) {
    var initialActiveTab = null;
    var authHash = window.location.hash ? window.location.hash.toLowerCase() : '';

    authTabButtons.forEach(function (button) {
      if (button.classList.contains('is-active') && !initialActiveTab) {
        initialActiveTab = button.getAttribute('data-lumea-auth-tab');
      }
    });

    if (!initialActiveTab && (authHash === '#lumearegistercard' || authHash === '#lumearegisterpanel')) {
      initialActiveTab = 'register';
    }

    if (!initialActiveTab) {
      initialActiveTab = authTabButtons[0].getAttribute('data-lumea-auth-tab');
    }

    setActiveAuthTab(initialActiveTab);

    authTabButtons.forEach(function (button) {
      button.addEventListener('click', function () {
        var requestedTab = button.getAttribute('data-lumea-auth-tab');
        setActiveAuthTab(requestedTab);
      });
    });
  }

  /* Exact auth reference switch (b.html behavior) */
  var authRefContainer = document.querySelector('[data-lumea-auth-ref-container]');
  var authRefButtons = document.querySelectorAll('[data-lumea-auth-ref-open]');

  if (authRefContainer && authRefButtons.length) {
    authRefButtons.forEach(function (button) {
      button.addEventListener('click', function () {
        var target = button.getAttribute('data-lumea-auth-ref-open');
        if (target === 'register') {
          authRefContainer.classList.remove('close');
          authRefContainer.classList.add('active');
          return;
        }

        authRefContainer.classList.remove('active');
        authRefContainer.classList.add('close');
      });
    });
  }

  /* Password visibility toggle */
  var passwordToggleButtons = document.querySelectorAll('[data-lumea-password-toggle]');

  if (passwordToggleButtons.length) {
    passwordToggleButtons.forEach(function (button) {
      var inputId = button.getAttribute('aria-controls');
      var input = inputId ? document.getElementById(inputId) : null;

      if (!input) {
        return;
      }

      button.addEventListener('click', function () {
        var shouldReveal = input.type === 'password';
        var showLabel = button.getAttribute('data-label-show') || 'Show password';
        var hideLabel = button.getAttribute('data-label-hide') || 'Hide password';

        input.type = shouldReveal ? 'text' : 'password';
        button.setAttribute('aria-pressed', shouldReveal ? 'true' : 'false');
        button.setAttribute('aria-label', shouldReveal ? hideLabel : showLabel);
      });
    });
  }

  /* Cart Drawer */
  var drawer = document.querySelector('[data-lumea-cart-drawer]');
  var overlay = document.querySelector('[data-lumea-cart-overlay]');
  var cartTriggers = document.querySelectorAll('[data-lumea-cart-trigger]');
  var cartCloses = document.querySelectorAll('[data-lumea-cart-close]');

  function openCartDrawer() {
    if (!drawer || !overlay) {
      return;
    }
    drawer.classList.add('is-open');
    overlay.classList.add('is-open');
    drawer.setAttribute('aria-hidden', 'false');
    overlay.setAttribute('aria-hidden', 'false');
    document.body.style.overflow = 'hidden';
  }

  function closeCartDrawer() {
    if (!drawer || !overlay) {
      return;
    }
    drawer.classList.remove('is-open');
    overlay.classList.remove('is-open');
    drawer.setAttribute('aria-hidden', 'true');
    overlay.setAttribute('aria-hidden', 'true');
    document.body.style.overflow = '';
  }

  if (drawer && overlay) {
    cartTriggers.forEach(function (btn) {
      btn.addEventListener('click', openCartDrawer);
    });

    cartCloses.forEach(function (btn) {
      btn.addEventListener('click', closeCartDrawer);
    });

    overlay.addEventListener('click', closeCartDrawer);

    document.body.addEventListener('added_to_cart', function () {
      openCartDrawer();
    });
  }

  /* Swap each fragment selector in the DOM with the server-rendered HTML. */
  function applyFragments(fragments) {
    if (!fragments || typeof fragments !== 'object') {
      return;
    }

    Object.keys(fragments).forEach(function (selector) {
      var element = document.querySelector(selector);
      if (!element) {
        return;
      }

      var temp = document.createElement('div');
      temp.innerHTML = fragments[selector];
      if (temp.firstChild) {
        element.parentNode.replaceChild(temp.firstChild, element);
      }
    });
  }

  /* Sync all on-page product card steppers for a product to the given qty. */
  function syncPageCards(productId, newQty) {
    document.querySelectorAll('[data-lumea-qty]').forEach(function (stepper) {
      if (stepper.closest('.lumea-drawer-item')) {
        return;
      }

      var plus = stepper.querySelector('.lumea-qty-plus');
      if (!plus || plus.getAttribute('data-product_id') !== String(productId)) {
        return;
      }

      var quantityText = stepper.querySelector('.lumea-qty-num');
      var atcWrap = stepper.closest('.lumea-card-atc-wrap');
      var cartLink = atcWrap && atcWrap.closest('.lumea-card-actions') && atcWrap.closest('.lumea-card-actions').querySelector('[data-lumea-view-cart]');

      if (newQty <= 0) {
        quantityText.textContent = '1';
        if (atcWrap) {
          atcWrap.classList.remove('is-added');
        }
        if (cartLink) {
          cartLink.classList.remove('is-active');
        }
        return;
      }

      quantityText.textContent = String(newQty);
      if (atcWrap) {
        atcWrap.classList.add('is-added');
      }
      if (cartLink) {
        cartLink.classList.add('is-active');
      }
    });
  }

  /* POST qty change; calls done(true|false) when the request settles. */
  function updateCartQty(productId, quantity, done) {
    if (typeof window.lumeaData === 'undefined') {
      done(false);
      return;
    }

    fetch(window.lumeaData.ajaxUrl, {
      method: 'POST',
      credentials: 'same-origin',
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded'
      },
      body: 'action=lumea_update_cart_qty&nonce=' + encodeURIComponent(window.lumeaData.nonce) + '&product_id=' + encodeURIComponent(productId) + '&quantity=' + encodeURIComponent(quantity)
    })
      .then(function (response) {
        return response.json();
      })
      .then(function (data) {
        if (data && data.success) {
          applyFragments(data.data.fragments);
          done(true);
          return;
        }
        done(false);
      })
      .catch(function () {
        done(false);
      });
  }

  document.addEventListener('click', function (event) {
    var wishButton = event.target.closest('[data-lumea-wish], [data-wishlist-toggle]');
    if (wishButton) {
      event.preventDefault();
      var wishProductId = getWishlistButtonProductId(wishButton);
      if (wishProductId) {
        toggleWishlistById(wishProductId);
      }
      return;
    }

    var removeButton = event.target.closest('[data-lumea-wishlist-remove]');
    if (removeButton) {
      event.preventDefault();
      removeFromWishlist(toPositiveInt(removeButton.getAttribute('data-lumea-wishlist-remove')));
      return;
    }

    var drawerRemoveButton = event.target.closest('.lumea-drawer-item-remove[data-product_id]');
    if (drawerRemoveButton) {
      event.preventDefault();

      var removeProductId = toPositiveInt(drawerRemoveButton.getAttribute('data-product_id'));
      if (!removeProductId) {
        return;
      }

      if (drawerRemoveButton.dataset.busy) {
        return;
      }
      drawerRemoveButton.dataset.busy = '1';

      updateCartQty(removeProductId, 0, function (ok) {
        delete drawerRemoveButton.dataset.busy;

        if (ok) {
          syncPageCards(removeProductId, 0);
          openCartDrawer();
          return;
        }

        var fallbackUrl = drawerRemoveButton.getAttribute('href');
        if (fallbackUrl) {
          window.location.href = fallbackUrl;
        }
      });
      return;
    }

    var addToCartButton = event.target.closest('.lumea-card-atc-wrap .add_to_cart_button');
    if (addToCartButton) {
      var addWrap = addToCartButton.closest('.lumea-card-atc-wrap');
      var addCartLink = addToCartButton.closest('.lumea-card-actions') && addToCartButton.closest('.lumea-card-actions').querySelector('[data-lumea-view-cart]');
      if (addWrap) {
        addWrap.classList.add('is-added');
      }
      if (addCartLink) {
        addCartLink.classList.add('is-active');
      }
      return;
    }

    var stepperButton = event.target.closest('.lumea-qty-plus, .lumea-qty-minus');
    if (!stepperButton) {
      return;
    }

    var stepper = stepperButton.closest('[data-lumea-qty]');
    if (!stepper || stepper.dataset.busy) {
      return;
    }

    var isPlus = stepperButton.classList.contains('lumea-qty-plus');
    var quantityNode = stepper.querySelector('.lumea-qty-num');
    var plusButton = stepper.querySelector('.lumea-qty-plus');
    var productId = plusButton && plusButton.getAttribute('data-product_id');

    if (!productId || !quantityNode) {
      return;
    }

    var currentQuantity = parseInt(quantityNode.textContent, 10) || 1;
    var newQuantity = isPlus ? currentQuantity + 1 : currentQuantity - 1;
    var atcWrap = stepper.closest('.lumea-card-atc-wrap');
    var cartLink = atcWrap && atcWrap.closest('.lumea-card-actions') && atcWrap.closest('.lumea-card-actions').querySelector('[data-lumea-view-cart]');

    if (newQuantity === 0) {
      quantityNode.textContent = '1';
      if (atcWrap) {
        atcWrap.classList.remove('is-added');
      }
      if (cartLink) {
        cartLink.classList.remove('is-active');
      }
    } else {
      quantityNode.textContent = String(newQuantity);
    }

    stepper.dataset.busy = '1';

    updateCartQty(productId, newQuantity, function (ok) {
      delete stepper.dataset.busy;

      if (ok) {
        syncPageCards(productId, newQuantity);
        return;
      }

      quantityNode.textContent = String(currentQuantity);
      if (newQuantity === 0) {
        if (atcWrap) {
          atcWrap.classList.add('is-added');
        }
        if (cartLink) {
          cartLink.classList.add('is-active');
        }
      }
    });
  });

  document.addEventListener('keydown', function (event) {
    if (event.key !== 'Escape') {
      return;
    }

    closeCartDrawer();
    closeSearchOverlay();
    closeAccountDropdown();

    if (mobileNav && navToggle && mobileNav.classList.contains('is-open')) {
      mobileNav.classList.remove('is-open');
      navToggle.classList.remove('is-open');
      navToggle.setAttribute('aria-expanded', 'false');
      mobileNav.setAttribute('aria-hidden', 'true');
      document.body.style.overflow = '';
    }
  });

  /* Shop filter dropdowns */
  var dropdowns = document.querySelectorAll('[data-lumea-dropdown]');

  if (dropdowns.length) {
    function closeAllDropdowns(except) {
      dropdowns.forEach(function (dropdown) {
        if (dropdown !== except) {
          dropdown.classList.remove('is-open');
        }
      });
    }

    dropdowns.forEach(function (dropdown) {
      var trigger = dropdown.querySelector('[data-lumea-dropdown-trigger]');
      if (!trigger) {
        return;
      }

      trigger.addEventListener('click', function (event) {
        event.stopPropagation();
        var wasOpen = dropdown.classList.contains('is-open');
        closeAllDropdowns();
        dropdown.classList.toggle('is-open', !wasOpen);
      });
    });

    document.addEventListener('click', function () {
      closeAllDropdowns();
    });
  }

  window.addEventListener('storage', function (event) {
    if (event.key === WISHLIST_STORAGE_KEY) {
      refreshWishlistUI();
    }
  });

  refreshWishlistUI();
})();
