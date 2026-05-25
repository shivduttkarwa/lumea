/**
 * Luméa Journey — editorial pinned scroll.
 * Large PNG product is the fixed centrepiece; backgrounds dissolve around it.
 */
( function () {
  'use strict';

  if ( typeof gsap === 'undefined' || typeof ScrollTrigger === 'undefined' ) return;

  gsap.registerPlugin( ScrollTrigger );

  const journey = document.getElementById( 'lumeaJourney' );
  if ( ! journey ) return;

  const obj    = document.getElementById( 'lumeaObj' );
  const bg1    = journey.querySelector( '.lj-bg--1' );
  const bg2    = journey.querySelector( '.lj-bg--2' );
  const bg3    = journey.querySelector( '.lj-bg--3' );
  const idx    = journey.querySelector( '.lj-index' );
  const idxNum = journey.querySelector( '.lj-index-num' );

  if ( ! obj || ! bg1 || ! bg2 || ! bg3 ) return;

  let vw = window.innerWidth;
  let vh = window.innerHeight;

  /* ─── Initial states ─────────────────────────────── */

  // Product below viewport, ready to rise
  gsap.set( obj, {
    xPercent: -50,
    yPercent: -50,
    x: vw * 0.67,
    y: vh * 0.84,
    scale: 0.30,
    rotation: 8,
    opacity: 0,
  } );

  // All copy hidden
  gsap.set( [
    '.lj-panel--1 .lj-tag',
    '.lj-panel--1 .lj-headline',
    '.lj-panel--1 .lj-body',
    '.lj-panel--2 .lj-tag',
    '.lj-panel--2 .lj-headline',
    '.lj-panel--3 .lj-tag',
    '.lj-panel--3 .lj-headline',
    '.lj-panel--3 .lj-btn',
  ], { opacity: 0, y: 64 } );

  gsap.set( '.lj-list li', { opacity: 0, x: -28 } );

  /* ─── Master scrubbed timeline ────────────────────── */

  const tl = gsap.timeline( {
    scrollTrigger: {
      trigger:      journey,
      pin:          true,
      start:        'top top',
      end:          '+=3600',
      scrub:        2.6,
      anticipatePin: 1,
      onUpdate: function ( self ) {
        const p       = self.progress;
        const isLight = p > 0.25 && p < 0.64;

        obj.classList.toggle( 'is-light-bg', isLight );
        if ( idx ) idx.classList.toggle( 'is-light-bg', isLight );

        if ( idxNum ) {
          if ( p > 0.62 )      idxNum.textContent = '03';
          else if ( p > 0.24 ) idxNum.textContent = '02';
          else                  idxNum.textContent = '01';
        }
      },
    },
  } );

  /* ═══════════════════════════════════════════════════
     PANEL 1 — ORIGINS  (deep forest dark)
  ═══════════════════════════════════════════════════ */

  // Product rises in from below — slow, cinematic
  tl.to( obj, {
    x: vw * 0.67, y: vh * 0.50,
    scale: 1.0, rotation: 3, opacity: 1,
    duration: 2.4, ease: 'power2.out',
  }, 0 );

  // Copy staggers in
  tl.to( '.lj-panel--1 .lj-tag',      { opacity: 1, y: 0, duration: 0.55, ease: 'power2.out' }, 1.1 );
  tl.to( '.lj-panel--1 .lj-headline', { opacity: 1, y: 0, duration: 1.15, ease: 'power3.out' }, 1.28 );
  tl.to( '.lj-panel--1 .lj-body',     { opacity: 1, y: 0, duration: 0.80, ease: 'power2.out' }, 1.58 );

  // Product breathes — very subtle
  tl.to( obj, { y: vh * 0.47, rotation: 2, duration: 1.3, ease: 'sine.inOut' }, 2.6 );

  /* ═══════════════════════════════════════════════════
     TRANSITION 1 → 2
  ═══════════════════════════════════════════════════ */

  tl.to( '.lj-panel--1', { opacity: 0, duration: 0.60, ease: 'power1.in' }, 3.4 );
  tl.to( bg1, { opacity: 0, duration: 1.0, ease: 'power1.inOut' }, 3.55 );
  tl.to( bg2, { opacity: 1, duration: 1.0, ease: 'power1.inOut' }, 3.55 );

  // Product slides slightly left, shrinks a touch — respects the light bg
  tl.to( obj, {
    x: vw * 0.62, y: vh * 0.50,
    scale: 0.88, rotation: -2,
    duration: 1.7, ease: 'power2.inOut',
  }, 3.65 );

  /* ═══════════════════════════════════════════════════
     PANEL 2 — FORMULA  (warm ivory)
  ═══════════════════════════════════════════════════ */

  tl.to( '.lj-panel--2 .lj-tag',      { opacity: 1, y: 0, duration: 0.55, ease: 'power2.out' }, 4.9 );
  tl.to( '.lj-panel--2 .lj-headline', { opacity: 1, y: 0, duration: 1.15, ease: 'power3.out' }, 5.08 );
  tl.to( '.lj-list li', { opacity: 1, x: 0, duration: 0.55, stagger: 0.11, ease: 'power2.out' }, 5.4 );

  // Product breathes on cream
  tl.to( obj, { x: vw * 0.61, y: vh * 0.48, rotation: -3, duration: 1.1, ease: 'sine.inOut' }, 5.5 );

  /* ═══════════════════════════════════════════════════
     TRANSITION 2 → 3
  ═══════════════════════════════════════════════════ */

  tl.to( '.lj-panel--2', { opacity: 0, duration: 0.60, ease: 'power1.in' }, 6.5 );
  tl.to( bg2, { opacity: 0, duration: 1.0, ease: 'power1.inOut' }, 6.65 );
  tl.to( bg3, { opacity: 1, duration: 1.0, ease: 'power1.inOut' }, 6.65 );

  // Product returns to right — more centered, commanding
  tl.to( obj, {
    x: vw * 0.67, y: vh * 0.47,
    scale: 0.83, rotation: 5,
    duration: 1.8, ease: 'power2.inOut',
  }, 6.75 );

  /* ═══════════════════════════════════════════════════
     PANEL 3 — RITUAL  (deep black)
  ═══════════════════════════════════════════════════ */

  tl.to( '.lj-panel--3 .lj-tag',      { opacity: 1, y: 0, duration: 0.55, ease: 'power2.out' }, 8.0 );
  tl.to( '.lj-panel--3 .lj-headline', { opacity: 1, y: 0, duration: 1.2,  ease: 'power3.out' }, 8.18 );
  tl.to( '.lj-panel--3 .lj-btn',      { opacity: 1, y: 0, duration: 0.72, ease: 'power2.out' }, 8.58 );

  // Final micro-drift
  tl.to( obj, { y: vh * 0.45, rotation: 6, duration: 1.3, ease: 'sine.inOut' }, 8.6 );

  // Hold panel 3 visible
  tl.to( {}, { duration: 2.2 }, 9.9 );

  /* ─── Resize ─────────────────────────────────────── */

  let rTimer;
  window.addEventListener( 'resize', function () {
    clearTimeout( rTimer );
    rTimer = setTimeout( function () {
      vw = window.innerWidth;
      vh = window.innerHeight;
      ScrollTrigger.refresh();
    }, 220 );
  } );

} )();
