/**
 * Luméa — The Ritual Section
 * Sticky left accordion driven by right-column scroll position.
 * Requires GSAP + ScrollTrigger (loaded via enqueue.php on front-page).
 */
( function () {
  'use strict';

  if ( typeof gsap === 'undefined' || typeof ScrollTrigger === 'undefined' ) return;

  const section = document.getElementById( 'lumeaRitual' );
  if ( ! section ) return;

  gsap.registerPlugin( ScrollTrigger );

  const accordions  = Array.from( section.querySelectorAll( '.lumea-ritual-acc' ) );
  const imageGroups = Array.from( section.querySelectorAll( '.lumea-ritual-image-group' ) );

  if ( ! accordions.length || ! imageGroups.length ) return;

  function setActive( id ) {
    accordions.forEach( function ( item ) {
      item.classList.toggle( 'is-active', item.dataset.target === id );
    } );

    const active = section.querySelector( '.lumea-ritual-acc[data-target="' + id + '"]' );
    if ( ! active ) return;

    const title = active.querySelector( '.lumea-ritual-acc-title' );
    const text  = active.querySelector( '.lumea-ritual-panel p' );

    if ( title ) {
      gsap.fromTo( title,
        { x: -14, opacity: 0.4 },
        { x: 0, opacity: 1, duration: 0.45, ease: 'power3.out', overwrite: true }
      );
    }
    if ( text ) {
      gsap.fromTo( text,
        { y: 12, opacity: 0 },
        { y: 0, opacity: 1, duration: 0.5, delay: 0.05, ease: 'power3.out', overwrite: true }
      );
    }
  }

  /* Scroll-driven activation */
  imageGroups.forEach( function ( group ) {
    ScrollTrigger.create( {
      trigger: group,
      start: 'top center',
      end: 'bottom center',
      onEnter:     function () { setActive( group.id ); },
      onEnterBack: function () { setActive( group.id ); },
    } );
  } );

  /* Click to scroll */
  accordions.forEach( function ( item ) {
    var btn = item.querySelector( '.lumea-ritual-acc-head' );
    if ( ! btn ) return;
    btn.addEventListener( 'click', function () {
      var id     = item.dataset.target;
      var target = document.getElementById( id );
      setActive( id );
      if ( target ) {
        var top = target.getBoundingClientRect().top + window.pageYOffset - 100;
        window.scrollTo( { top: top, behavior: 'smooth' } );
      }
    } );
  } );

  /* Image reveal on scroll */
  gsap.utils.toArray( '.lumea-ritual-image-wrap' ).forEach( function ( wrap ) {
    var img = wrap.querySelector( 'img' );
    if ( ! img ) return;
    gsap.fromTo( img,
      { scale: 1.055, y: 34, opacity: 0.88 },
      {
        scale: 1, y: 0, opacity: 1,
        duration: 1.15, ease: 'power3.out',
        scrollTrigger: { trigger: wrap, start: 'top 86%', once: true },
      }
    );
  } );

  window.addEventListener( 'load', function () {
    ScrollTrigger.refresh();
  } );

} )();
