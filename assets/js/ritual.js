

( function () {
  'use strict';

  if ( typeof gsap === 'undefined' || typeof ScrollTrigger === 'undefined' ) return;

  const section = document.getElementById( 'lumeaRitual' );
  if ( ! section ) return;

  gsap.registerPlugin( ScrollTrigger );

  const accordions  = Array.from( section.querySelectorAll( '.lumea-ritual-acc' ) );
  const imageGroups = Array.from( section.querySelectorAll( '.lumea-ritual-image-group' ) );

  if ( ! accordions.length || ! imageGroups.length ) return;

  

  accordions.forEach( function ( item ) {
    var panel = item.querySelector( '.lumea-ritual-panel' );
    if ( ! panel ) return;
    if ( item.classList.contains( 'is-active' ) ) {
      gsap.set( panel, { height: 'auto', opacity: 1 } );
    } else {
      gsap.set( panel, { height: 0, opacity: 0 } );
    }
  } );

  

  function setActive( id ) {
    accordions.forEach( function ( item ) {
      var isActive  = item.dataset.target === id;
      var wasActive = item.classList.contains( 'is-active' );
      var panel     = item.querySelector( '.lumea-ritual-panel' );

      item.classList.toggle( 'is-active', isActive );

      if ( ! panel ) return;

      if ( isActive && ! wasActive ) {
        
        gsap.to( panel, {
          height: 'auto',
          opacity: 1,
          duration: 0.65,
          ease: 'expo.out',
          overwrite: true,
        } );
      } else if ( ! isActive && wasActive ) {
        
        gsap.to( panel, {
          height: 0,
          opacity: 0,
          duration: 0.4,
          ease: 'power3.inOut',
          overwrite: true,
        } );
      }
    } );

    
    var active = section.querySelector( '.lumea-ritual-acc[data-target="' + id + '"]' );
    if ( ! active ) return;

    var title = active.querySelector( '.lumea-ritual-acc-title' );
    var text  = active.querySelector( '.lumea-ritual-panel p' );

    if ( title ) {
      gsap.fromTo( title,
        { x: -20, opacity: 0.3 },
        { x: 0, opacity: 1, duration: 0.6, ease: 'expo.out', overwrite: true }
      );
    }
    if ( text ) {
      gsap.fromTo( text,
        { y: 18, opacity: 0 },
        { y: 0, opacity: 1, duration: 0.7, delay: 0.07, ease: 'expo.out', overwrite: true }
      );
    }
  }

  

  imageGroups.forEach( function ( group ) {
    ScrollTrigger.create( {
      trigger: group,
      start: 'top center',
      end: 'bottom center',
      onEnter:     function () { setActive( group.id ); },
      onEnterBack: function () { setActive( group.id ); },
    } );
  } );

  

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

  

  gsap.utils.toArray( '.lumea-ritual-image-wrap' ).forEach( function ( wrap ) {
    var img = wrap.querySelector( 'img' );
    if ( ! img ) return;
    gsap.fromTo( img,
      { scale: 1.06, y: 40, opacity: 0.85 },
      {
        scale: 1, y: 0, opacity: 1,
        duration: 1.2, ease: 'expo.out',
        scrollTrigger: { trigger: wrap, start: 'top 88%', once: true },
      }
    );
  } );

  window.addEventListener( 'load', function () {
    ScrollTrigger.refresh();
  } );

} )();
