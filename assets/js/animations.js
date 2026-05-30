( function () {
  'use strict';

  if ( typeof gsap === 'undefined' || typeof ScrollTrigger === 'undefined' ) return;

  gsap.registerPlugin( ScrollTrigger );
  if ( typeof SplitText !== 'undefined' ) gsap.registerPlugin( SplitText );

  /* ── Text splitting ──────────────────────────────────────────
     Elements opt in via:
       .lumea-split-js               — required on the text element
       .lumea-split--lines-js        — split into lines
       .lumea-split--chars-js        — split into chars (also wraps lines)
  */
  if ( typeof SplitText !== 'undefined' ) {
    document.querySelectorAll( '.lumea-split-js' ).forEach( function ( el ) {
      if ( el.classList.contains( 'lumea-split--chars-js' ) ) {
        new SplitText( el, {
          type:       'chars,lines',
          linesClass: 'lumea-st-line',
          charsClass: 'lumea-st-char',
          aria:       'none',
        } );
      } else {
        new SplitText( el, {
          type:       'lines',
          linesClass: 'lumea-st-line',
          aria:       'none',
        } );
      }
    } );
  }

  /* ── Initial hidden states ───────────────────────────────────
     Set before the first paint so nothing flashes visible.
     Each modifier class sets its own starting transform/opacity.
  */
  gsap.set( '.lumea-reveal--fade-js',   { y: 30,    autoAlpha: 0 } );
  gsap.set( '.lumea-reveal--static-js', {           autoAlpha: 0 } );
  gsap.set( '.lumea-reveal--right-js',  { x: '15%', autoAlpha: 0 } );
  gsap.set( '.lumea-reveal--left-js',   { x: '-15%',autoAlpha: 0 } );

  gsap.set(
    '.lumea-reveal--text-js.lumea-split--lines-js .lumea-st-line',
    { y: 30, autoAlpha: 0 }
  );
  gsap.set(
    '.lumea-reveal--text-js.lumea-split--chars-js .lumea-st-char',
    { autoAlpha: 0 }
  );

  /* ── Core fade/move animation ────────────────────────────────
     Always animates back to the natural resting position
     (x:0, y:0, autoAlpha:1) regardless of starting state.
     Pass isStatic=true to skip the positional tween.
  */
  function animateDef( el, index, isStatic ) {
    var ease  = 'power1.out';
    var delay = index * 0.1;
    if ( ! isStatic ) {
      gsap.to( el, { x: 0, y: 0, duration: 0.7, ease: ease, delay: delay } );
    }
    gsap.to( el, { autoAlpha: 1, duration: 0.5, ease: ease, delay: delay + 0.1 } );
  }

  /* ── Batch animation handler ─────────────────────────────────
     Called by ScrollTrigger.batch() with the array of elements
     that entered the viewport together.
  */
  function animateBatch( batch ) {
    batch.forEach( function ( el, index ) {

      /* Clip-path reveal — tweens the CSS custom property */
      if ( el.classList.contains( 'lumea-reveal--clip-js' ) ) {
        gsap.fromTo( el,
          { '--lumea-clip': '100%' },
          {
            '--lumea-clip': '0%',
            duration:       1.1,
            ease:           'power3.out',
            delay:          index * 0.2,
            onComplete:     function () { el.classList.add( 'lumea-clip-done' ); },
          }
        );
        return;
      }

      /* Text reveal — chars or lines via SplitText */
      if ( el.classList.contains( 'lumea-reveal--text-js' ) ) {
        var chars = el.querySelectorAll( '.lumea-st-char' );
        var lines = el.querySelectorAll( '.lumea-st-line' );
        var delay = index * 0.1;

        if ( chars.length ) {
          gsap.to( chars, {
            autoAlpha: 1,
            duration:  0.4,
            ease:      'power3.inOut',
            stagger:   0.05,
            delay:     delay,
          } );
        } else if ( lines.length ) {
          gsap.to( lines, {
            y:        0,
            duration: 0.6,
            ease:     'power1.out',
            stagger:  0.15,
            delay:    delay,
          } );
          gsap.to( lines, {
            autoAlpha: 1,
            duration:  0.5,
            ease:      'power1.out',
            stagger:   0.15,
            delay:     delay + 0.1,
          } );
        } else {
          animateDef( el, index, false );
        }
        return;
      }

      /* Fade-in only, no positional movement */
      if ( el.classList.contains( 'lumea-reveal--static-js' ) ) {
        animateDef( el, index, true );
        return;
      }

      /* Default: fade-up, slide-from-right, slide-from-left
         all animate back to x:0, y:0 from their gsap.set state */
      animateDef( el, index, false );
    } );
  }

  /* ── Scroll batch triggers ───────────────────────────────────
     Standard elements: trigger 100px before bottom of viewport.
     Hero elements:     trigger at bottom of viewport (earlier).
     once:true means each element only ever animates in once.
  */
  ScrollTrigger.batch( '.lumea-reveal-js:not(.lumea-reveal--hero-js)', {
    start:   'top bottom-=100',
    once:    true,
    onEnter: animateBatch,
  } );

  ScrollTrigger.batch( '.lumea-reveal--hero-js', {
    start:   'top bottom',
    once:    true,
    onEnter: animateBatch,
  } );

  /* ── Parallax ────────────────────────────────────────────────
     Opt-in classes:
       .lumea-parallax-js               — base, required
       .lumea-parallax--img-js          — image translate (oversized)
       .lumea-parallax--x-js            — horizontal translate
       .lumea-parallax--scale-js        — scale effect
       .lumea-parallax--reverse-js      — flip the direction
       (default with none of the above) — vertical translate

     Data attributes:
       data-parallax-value="15"         — translate/scale amount
       data-parallax-scrub="1"          — ScrollTrigger scrub value
       data-parallax-trigger-start      — custom start (default: "top bottom")
       data-parallax-trigger-end        — custom end   (default: "bottom top")
  */
  document.querySelectorAll( '.lumea-parallax-js' ).forEach( function ( el ) {
    var value = parseFloat( el.dataset.parallaxValue        ) || 15;
    var scrub = parseFloat( el.dataset.parallaxScrub        ) || 1;
    var start =             el.dataset.parallaxTriggerStart   || 'top bottom';
    var end   =             el.dataset.parallaxTriggerEnd     || 'bottom top';
    var isRev = el.classList.contains( 'lumea-parallax--reverse-js' );

    var trig = { trigger: el, start: start, end: end, scrub: scrub };

    if ( el.classList.contains( 'lumea-parallax--img-js' ) ) {
      el.style.height = 'calc(100% + ' + value + '%)';
      el.style.top    = '-' + ( value / 2 ) + '%';
      gsap.to( el, { yPercent: isRev ? value : -value, ease: 'none', scrollTrigger: trig } );

    } else if ( el.classList.contains( 'lumea-parallax--x-js' ) ) {
      gsap.to( el, { xPercent: isRev ? -value : value, ease: 'none', scrollTrigger: trig } );

    } else if ( el.classList.contains( 'lumea-parallax--scale-js' ) ) {
      gsap.to( el, { scale: 1 + value / 100, ease: 'none', scrollTrigger: trig } );

    } else {
      gsap.to( el, { yPercent: isRev ? -value : value, ease: 'none', scrollTrigger: trig } );
    }
  } );

  /* ── Hero / pinned parallax ──────────────────────────────────
     Wrap the image in .lumea-parallax-wrap-js and tag the image
     itself with .lumea-parallax--hero-js. The wrap becomes the
     ScrollTrigger reference so the effect runs from entry to exit.

       data-parallax-value="20"   — yPercent travel amount
  */
  document.querySelectorAll( '.lumea-parallax-wrap-js' ).forEach( function ( wrap ) {
    var img = wrap.querySelector( '.lumea-parallax--hero-js' );
    if ( ! img ) return;
    var value = parseFloat( img.dataset.parallaxValue ) || 20;

    gsap.to( img, {
      yPercent:      value,
      ease:          'none',
      scrollTrigger: { trigger: wrap, start: 'top top', end: 'bottom top', scrub: true },
    } );
  } );

} )();
