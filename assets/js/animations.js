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

  /* ── Curated section — random mosaic tile reveal ─────────────
     Mirrors effect-03 (random mosaic) from b2.html.
     A 6×4 grid of tiles covers each product card; tiles scatter
     randomly as the section enters view, revealing the image
     beneath. Both cards stagger so the second blooms 220ms later.
  */
  ( function initCuratedMosaicReveal() {

    var section = document.querySelector( '.lumea-curated' );
    if ( ! section ) return;

    var tiles_count = 24;
    var productTiles = section.querySelectorAll( '.lumea-product-tile' );
    if ( ! productTiles.length ) return;

    /* Inject mosaic grid into each product tile */
    productTiles.forEach( function ( tile ) {
      var grid = document.createElement( 'div' );
      grid.className = 'lumea-mosaic-grid';
      for ( var i = 0; i < tiles_count; i++ ) {
        var span = document.createElement( 'span' );
        span.className = 'lumea-mosaic-tile';
        grid.appendChild( span );
      }
      tile.appendChild( grid );
    } );

    /* Initial image states — slightly zoomed + softly blurred */
    var productImgs = section.querySelectorAll( '.lumea-product-image' );
    gsap.set( productImgs, { scale: 1.18, filter: 'blur(8px)' } );

    /* One ScrollTrigger per card so they stagger naturally */
    productTiles.forEach( function ( tile, index ) {
      var mosaic = tile.querySelector( '.lumea-mosaic-grid' );
      var tiles  = mosaic.querySelectorAll( '.lumea-mosaic-tile' );
      var img    = tile.querySelector( '.lumea-product-image' );
      var delay  = index * 0.55;

      ScrollTrigger.create( {
        trigger: tile,
        start:   'top 80%',
        once:    true,
        onEnter: function () {

          /* Tiles scatter in random directions simultaneously */
          gsap.to( tiles, {
            opacity:  0,
            scale:    0.4,
            rotate:   function () { return gsap.utils.random( -18, 18 ); },
            yPercent: function () { return gsap.utils.random( -80, 80 ); },
            xPercent: function () { return gsap.utils.random( -80, 80 ); },
            duration: 0.9,
            ease:     'power4.inOut',
            delay:    delay,
            stagger:  { amount: 0.65, from: 'random' },
            onComplete: function () { gsap.set( mosaic, { display: 'none' } ); },
          } );

          /* Image sharpens as tiles scatter */
          gsap.to( img, {
            scale:    1,
            filter:   'blur(0px)',
            duration: 1.35,
            ease:     'power4.out',
            delay:    delay,
          } );

        },
      } );
    } );

  } )();

  /* ── Editorial slider — luxury blind strips reveal ───────────
     Mirrors effect-03 (blind strips) from image.html.
     5 vertical strips alternate up/down to reveal the first
     slide as the section enters the viewport.
     Uses MutationObserver because slider.js runs after
     animations.js in the WordPress enqueue chain and the
     .lumea-slide elements don't exist yet when this runs.
  */
  ( function initEditorialBlindReveal() {

    var sliderEl = document.getElementById( 'lumeaSlider' );
    if ( ! sliderEl ) return;

    function setup( firstSlide ) {
      /* Inject 5 strips into the slide (sibling of .lumea-slide-inner) */
      var stripsWrap = document.createElement( 'div' );
      stripsWrap.className = 'lumea-blind-strips';
      for ( var i = 0; i < 5; i++ ) {
        var s = document.createElement( 'div' );
        s.className = 'lumea-blind-strip';
        stripsWrap.appendChild( s );
      }
      firstSlide.appendChild( stripsWrap );

      var strips = stripsWrap.querySelectorAll( '.lumea-blind-strip' );
      var img    = firstSlide.querySelector( 'img' );

      if ( img ) gsap.set( img, { scale: 1.18 } );

      ScrollTrigger.create( {
        trigger: sliderEl,
        start:   'top 75%',
        once:    true,
        onEnter: function () {
          var tl = gsap.timeline( {
            onComplete: function () { stripsWrap.remove(); },
          } );

          /* Alternate strips fly up / down */
          tl.to( strips, {
            yPercent: function ( i ) { return i % 2 === 0 ? -105 : 105; },
            duration: 1.1,
            stagger:  0.08,
            ease:     'power4.inOut',
          } );

          /* Image settles from zoom as strips depart */
          if ( img ) {
            tl.to( img, { scale: 1, duration: 1.45, ease: 'power4.out' }, 0 );
          }
        },
      } );
    }

    /* Slides may not exist yet — use MutationObserver to wait */
    var existing = sliderEl.querySelector( '.lumea-slide[data-index="0"]' );
    if ( existing ) {
      setup( existing );
    } else {
      var observer = new MutationObserver( function () {
        var slide = sliderEl.querySelector( '.lumea-slide[data-index="0"]' );
        if ( slide ) {
          observer.disconnect();
          setup( slide );
        }
      } );
      observer.observe( sliderEl, { childList: true, subtree: true } );
    }

  } )();

  /* ── Section intro — eyebrow / title / desc reveal ──────────────
     Opt-in: add .lumea-section-intro-js to any wrapper that contains
     .lumea-eyebrow, .lumea-section-title, and .lumea-section-desc.

     Eyebrow  : blur-fade — drifts up while snapping into focus.
     Title    : per-line skewed slide — each line shears as it rises
                and straightens on arrival (luxury editorial style).
     Desc     : blur-focus reveal — soft focus pulls in last.
  */
  ( function initSectionIntroReveal() {

    var hasSplit = typeof SplitText !== 'undefined';

    document.querySelectorAll( '.lumea-section-intro-js' ).forEach( function ( intro ) {
      var eyebrow = intro.querySelector( '.lumea-eyebrow' );
      var title   = intro.querySelector( '.lumea-section-title' );
      var desc    = intro.querySelector( '.lumea-section-desc' );

      if ( ! title ) return;

      /* ── Split lines or fall back to whole-title tween ──────── */
      var titleTargets;

      if ( hasSplit ) {
        var split = new SplitText( title, { type: 'lines', linesClass: 'lumea-si-line' } );

        split.lines.forEach( function ( line ) {
          var mask = document.createElement( 'div' );
          mask.className = 'lumea-si-mask';
          line.parentNode.insertBefore( mask, line );
          mask.appendChild( line );
        } );

        titleTargets = split.lines;
        /* Start: hidden below + sheared — the mask clips the overhang */
        gsap.set( titleTargets, { yPercent: 112, skewY: 7 } );

      } else {
        titleTargets = [ title ];
        gsap.set( title, { autoAlpha: 0, y: 40, skewY: 4 } );
      }

      /* Eyebrow: blurred and drifted up */
      if ( eyebrow ) {
        gsap.set( eyebrow, { autoAlpha: 0, y: 8, filter: 'blur(5px)' } );
      }

      /* Desc: blurred and offset */
      if ( desc ) {
        gsap.set( desc, { autoAlpha: 0, y: 16, filter: 'blur(8px)' } );
      }

      /* ── Scroll-triggered timeline ──────────────────────────── */
      var tl = gsap.timeline( {
        scrollTrigger: {
          trigger: intro,
          start:   'top 82%',
          once:    true,
        },
        defaults: { ease: 'power4.out' },
      } );

      /* Eyebrow: snap into focus from above */
      if ( eyebrow ) {
        tl.to( eyebrow, {
          autoAlpha: 1,
          y:         0,
          filter:    'blur(0px)',
          duration:  0.85,
          ease:      'power3.out',
        }, 0 );
      }

      var titlePos = eyebrow ? 0.18 : 0;

      /* Title: skewed upward slide, each line straightens on landing */
      if ( hasSplit ) {
        tl.to( titleTargets, {
          yPercent: 0,
          skewY:    0,
          duration: 1.05,
          stagger:  0.1,
        }, titlePos );
      } else {
        tl.to( titleTargets, {
          autoAlpha: 1,
          y:         0,
          skewY:     0,
          duration:  1.05,
        }, titlePos );
      }

      /* Desc: blur-focus pull, overlaps last line landing */
      if ( desc ) {
        tl.to( desc, {
          autoAlpha: 1,
          y:         0,
          filter:    'blur(0px)',
          duration:  0.9,
          ease:      'power3.out',
        }, '-=0.55' );
      }

    } );

  } )();

} )();