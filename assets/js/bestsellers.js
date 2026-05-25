/**
 * Luméa — Shop Bestsellers Swiper
 */
( function () {
  'use strict';

  if ( typeof Swiper === 'undefined' ) return;

  new Swiper( '.lumea-best-swiper', {
    slidesPerView: 1.3,
    spaceBetween:  16,
    speed:         680,
    grabCursor:    true,

    navigation: {
      nextEl: '.lumea-best-next',
      prevEl: '.lumea-best-prev',
    },

    breakpoints: {
      600:  { slidesPerView: 2.2, spaceBetween: 16 },
      1024: { slidesPerView: 4,   spaceBetween: 24 },
    },
  } );

} )();
