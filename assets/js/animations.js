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

  /* ── Page intro animation ────────────────────────────────────
     Header  : slides down; logo, nav, actions fade in cleanly.
     LUMÉA   : letters start spread (letter-spacing wide) and
               contract to their natural tight-set position.
               This is the only "trick" — everything else is
               pure opacity and precise clip-path reveals.
     Label   : wipes in from the right (clip-path).
     Subtitles: wipe from the left, staggered (clip-path).
     CTA     : fades in last.
  */
  ( function initIntroAnim() {

    var header    = document.querySelector( '.lumea-header' );
    if ( ! header ) return;

    var logo      = document.querySelector( '.lumea-header-logo' );
    var navItems  = document.querySelectorAll( '.lumea-nav-list li' );
    var actions   = document.querySelectorAll( '.lumea-header-actions > *' );
    var hero      = document.querySelector( '.hero' );
    var heroTitle = document.querySelector( '.hero-title' );
    var heroLabel = document.querySelector( '.hero-label' );
    var subtitles = document.querySelectorAll( '.subtitles span' );
    var ctaWrap   = document.querySelector( '.cta-wrap' );

    /* Capture natural letter-spacing BEFORE we alter anything */
    var naturalLS = ( hero && heroTitle )
      ? window.getComputedStyle( heroTitle ).letterSpacing
      : '0px';

    /* ── Initial states ────────────────────────────────────── */
    gsap.set( header, { yPercent: -100 } );
    if ( logo        ) gsap.set( logo,     { autoAlpha: 0 } );
    if ( navItems.length ) gsap.set( navItems, { autoAlpha: 0 } );
    if ( actions.length  ) gsap.set( actions,  { autoAlpha: 0 } );

    if ( hero ) {
      if ( heroTitle ) {
        gsap.set( heroTitle, {
          letterSpacing:   '0.28em',
          scale:           1.03,
          autoAlpha:       0,
          transformOrigin: 'left center',
        } );
      }
      if ( heroLabel ) {
        gsap.set( heroLabel, { clipPath: 'inset(0% 0% 0% 100%)', autoAlpha: 0 } );
      }
      if ( subtitles.length ) {
        gsap.set( subtitles, { clipPath: 'inset(0% 100% 0% 0%)', autoAlpha: 0 } );
      }
      if ( ctaWrap ) {
        gsap.set( ctaWrap, { autoAlpha: 0 } );
      }
    }

    /* ── Timeline ──────────────────────────────────────────── */
    var tl = gsap.timeline( { delay: 0.15, defaults: { ease: 'power3.out' } } );

    /* Header drops into place */
    tl.to( header, { yPercent: 0, duration: 1.0 }, 0 );

    if ( logo ) {
      tl.to( logo, { autoAlpha: 1, duration: 0.7, ease: 'power2.out' }, 0.42 );
    }
    if ( navItems.length ) {
      tl.to( navItems, { autoAlpha: 1, duration: 0.55, ease: 'power2.out', stagger: 0.07 }, 0.5 );
    }
    if ( actions.length ) {
      tl.to( actions, { autoAlpha: 1, duration: 0.5, ease: 'power2.out', stagger: 0.055 }, 0.58 );
    }

    if ( ! hero ) return;

    /* LUMÉA — letters contract from wide tracking to natural */
    if ( heroTitle ) {
      tl.to( heroTitle, {
        letterSpacing: naturalLS,
        scale:         1,
        autoAlpha:     1,
        duration:      2.4,
        ease:          'power3.inOut',
        onComplete: function () {
          gsap.set( heroTitle, { clearProps: 'letterSpacing,scale,transform' } );
        },
      }, 0.06 );
    }

    /* Label — precision wipe from right */
    if ( heroLabel ) {
      tl.to( heroLabel, {
        clipPath:  'inset(0% 0% 0% 0%)',
        autoAlpha: 1,
        duration:  1.0,
        ease:      'power4.out',
        onComplete: function () {
          gsap.set( heroLabel, { clearProps: 'clipPath' } );
        },
      }, 1.05 );
    }

    /* Subtitles — three horizontal wipes, left to right */
    if ( subtitles.length ) {
      tl.to( subtitles, {
        clipPath:  'inset(0% 0% 0% 0%)',
        autoAlpha: 1,
        duration:  0.8,
        stagger:   0.14,
        ease:      'power4.out',
        onComplete: function () {
          gsap.set( '.subtitles span', { clearProps: 'clipPath' } );
        },
      }, 1.2 );
    }

    /* CTA — appears last, no movement */
    if ( ctaWrap ) {
      tl.to( ctaWrap, { autoAlpha: 1, duration: 1.0, ease: 'power2.out' }, 1.55 );
    }

  } )();

} )();