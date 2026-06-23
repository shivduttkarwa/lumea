( function () {
  'use strict';

  if ( typeof gsap === 'undefined' || typeof ScrollTrigger === 'undefined' ) return;

  gsap.registerPlugin( ScrollTrigger );
  if ( typeof SplitText !== 'undefined' ) gsap.registerPlugin( SplitText );

  

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

  

  var _fade   = gsap.utils.toArray( '.lumea-reveal--fade-js' );
  var _static = gsap.utils.toArray( '.lumea-reveal--static-js' );
  var _right  = gsap.utils.toArray( '.lumea-reveal--right-js' );
  var _left   = gsap.utils.toArray( '.lumea-reveal--left-js' );
  var _lines  = gsap.utils.toArray( '.lumea-reveal--text-js.lumea-split--lines-js .lumea-st-line' );
  var _chars  = gsap.utils.toArray( '.lumea-reveal--text-js.lumea-split--chars-js .lumea-st-char' );

  if ( _fade.length   ) gsap.set( _fade,   { y: 30,     autoAlpha: 0 } );
  if ( _static.length ) gsap.set( _static, {             autoAlpha: 0 } );
  if ( _right.length  ) gsap.set( _right,  { x: '15%',  autoAlpha: 0 } );
  if ( _left.length   ) gsap.set( _left,   { x: '-15%', autoAlpha: 0 } );
  if ( _lines.length  ) gsap.set( _lines,  { y: 30,     autoAlpha: 0 } );
  if ( _chars.length  ) gsap.set( _chars,  {             autoAlpha: 0 } );

  

  function animateDef( el, index, isStatic ) {
    var ease  = 'power1.out';
    var delay = index * 0.1;
    if ( ! isStatic ) {
      gsap.to( el, { x: 0, y: 0, duration: 0.7, ease: ease, delay: delay } );
    }
    gsap.to( el, { autoAlpha: 1, duration: 0.5, ease: ease, delay: delay + 0.1 } );
  }

  

  function animateBatch( batch ) {
    batch.forEach( function ( el, index ) {

      
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

      
      if ( el.classList.contains( 'lumea-reveal--static-js' ) ) {
        animateDef( el, index, true );
        return;
      }

      

      animateDef( el, index, false );
    } );
  }

  

  ScrollTrigger.batch( '.lumea-reveal-js:not(.lumea-reveal--hero-js)', {
    start:   'top bottom-=50',
    once:    true,
    onEnter: animateBatch,
  } );

  ScrollTrigger.batch( '.lumea-reveal--hero-js', {
    start:   'top bottom',
    once:    true,
    onEnter: animateBatch,
  } );

  

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

  

  ( function initIntroAnim() {

    

    if ( window.wp && window.wp.customize ) return;

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

    
    var naturalLS = ( hero && heroTitle )
      ? window.getComputedStyle( heroTitle ).letterSpacing
      : '0px';

    
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

    
    var tl = gsap.timeline( { delay: 0.05, defaults: { ease: 'power3.out' } } );

    if ( logo ) {
      tl.to( logo, { autoAlpha: 1, duration: 0.4, ease: 'power2.out' }, 0.1 );
    }
    if ( navItems.length ) {
      tl.to( navItems, { autoAlpha: 1, duration: 0.35, ease: 'power2.out', stagger: 0.04 }, 0.15 );
    }
    if ( actions.length ) {
      tl.to( actions, { autoAlpha: 1, duration: 0.3, ease: 'power2.out', stagger: 0.03 }, 0.18 );
    }

    if ( ! hero ) return;

    
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

    
    if ( ctaWrap ) {
      tl.to( ctaWrap, { autoAlpha: 1, duration: 1.0, ease: 'power2.out' }, 1.55 );
    }

  } )();

  

  ( function initCuratedMosaicReveal() {

    var section = document.querySelector( '.lumea-curated' );
    if ( ! section ) return;

    var tiles_count = 24;
    var productTiles = section.querySelectorAll( '.lumea-product-tile' );
    if ( ! productTiles.length ) return;

    
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

    
    var productImgs = section.querySelectorAll( '.lumea-product-image' );
    gsap.set( productImgs, { scale: 1.18, filter: 'blur(8px)' } );

    
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

  


  ( function initSectionIntroReveal() {

    var hasSplit = typeof SplitText !== 'undefined';

    document.querySelectorAll( '.lumea-section-intro-js' ).forEach( function ( intro ) {
      var eyebrow = intro.querySelector( '.lumea-eyebrow' );
      var title   = intro.querySelector( '.lumea-section-title' );
      var desc    = intro.querySelector( '.lumea-section-desc' );

      if ( ! title ) return;

      
      var titleTargets;

      if ( hasSplit ) {
        // Split into lines and wrap each in its own mask
        var split = new SplitText( title, { type: 'lines', linesClass: 'lumea-si-line' } );
        split.lines.forEach( function ( line ) {
          var mask = document.createElement( 'div' );
          mask.className = 'lumea-si-mask';
          line.parentNode.insertBefore( mask, line );
          mask.appendChild( line );
        } );
        titleTargets = split.lines;
      } else {
        // No SplitText — wrap the whole title in one mask and reveal as a single unit
        var mask = document.createElement( 'div' );
        mask.className = 'lumea-si-mask';
        title.parentNode.insertBefore( mask, title );
        mask.appendChild( title );
        titleTargets = [ title ];
      }

      // Start below the mask edge — pure positional reveal, no opacity or skew
      gsap.set( titleTargets, { yPercent: 110 } );


      if ( eyebrow ) {
        gsap.set( eyebrow, { autoAlpha: 0, y: 8, filter: 'blur(5px)' } );
      }


      if ( desc ) {
        gsap.set( desc, { autoAlpha: 0 } );
      }


      var tl = gsap.timeline( {
        scrollTrigger: {
          trigger: intro,
          start:   'top 65%',
          once:    true,
        },
        defaults: { ease: 'power4.out' },
      } );


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

      tl.to( titleTargets, {
        yPercent: 0,
        duration: 1.05,
        stagger:  hasSplit ? 0.12 : 0,
      }, titlePos );

      
      if ( desc ) {
        tl.to( desc, {
          autoAlpha: 1,
          duration:  0.7,
          ease:      'power2.out',
        }, '-=0.55' );
      }

    } );

  } )();

  /* ── Manifesto quote — line-by-line slide-up reveal ── */
  ( function initManifestoLineReveal() {

    var mq   = document.querySelector( '.lumea-about-manifesto-q' );
    var cite = document.querySelector( '.lumea-about-manifesto-cite' );
    if ( ! mq || typeof SplitText === 'undefined' ) return;

    var split = new SplitText( mq, { type: 'lines', linesClass: 'lumea-si-line' } );

    split.lines.forEach( function ( line ) {
      var mask = document.createElement( 'div' );
      mask.className = 'lumea-si-mask';
      line.parentNode.insertBefore( mask, line );
      mask.appendChild( line );
    } );

    gsap.set( split.lines, { yPercent: 110 } );
    if ( cite ) gsap.set( cite, { autoAlpha: 0, y: 8 } );

    ScrollTrigger.create( {
      trigger: mq,
      start:   'top 80%',
      once:    true,
      onEnter: function () {
        var tl = gsap.timeline();
        tl.to( split.lines, {
          yPercent: 0,
          duration: 1.0,
          ease:     'power4.out',
          stagger:  0.16,
        } );
        if ( cite ) {
          tl.to( cite, {
            autoAlpha: 1,
            y:         0,
            duration:  0.6,
            ease:      'power2.out',
          }, '-=0.2' );
        }
      },
    } );

  } )();

  /* ── About hero title — line-by-line slide-up on load ── */
  ( function initAboutHeroTitleReveal() {

    var h1 = document.querySelector( '.lumea-about-hero-reveal-js' );
    if ( ! h1 ) return;

    var lines = h1.querySelectorAll( '.lumea-about-hero-line' );
    if ( ! lines.length ) return;

    lines.forEach( function ( line ) {
      var mask = document.createElement( 'div' );
      mask.className = 'lumea-si-mask';
      line.parentNode.insertBefore( mask, line );
      mask.appendChild( line );
    } );

    gsap.set( lines, { yPercent: 110 } );
    h1.style.visibility = 'visible';

    gsap.to( lines, {
      yPercent: 0,
      duration: 1.0,
      ease:     'power4.out',
      stagger:  0.16,
      delay:    0.2,
    } );

  } )();


  /* ── About stats — staggered slide-up reveal ── */
  ( function initAboutStatsReveal() {

    var cells = gsap.utils.toArray( '.lumea-about-stat-reveal-js' );
    if ( ! cells.length ) return;

    var inners = cells.map( function ( cell ) {
      var children = Array.prototype.slice.call( cell.childNodes );
      var mask  = document.createElement( 'div' );
      var inner = document.createElement( 'div' );
      mask.className = 'lumea-stat-mask';
      children.forEach( function ( child ) { inner.appendChild( child ); } );
      mask.appendChild( inner );
      cell.appendChild( mask );
      return inner;
    } );

    gsap.set( inners, { yPercent: 110 } );

    ScrollTrigger.create( {
      trigger: '.lumea-about-stats-row',
      start:   'top 85%',
      once:    true,
      onEnter: function () {
        gsap.to( inners, {
          yPercent: 0,
          duration: 1.0,
          ease:     'power4.out',
          stagger:  0.12,
        } );
      },
    } );

  } )();


  /* ── About story image — mosaic scatter reveal (same as curated product tiles) ── */
  ( function initAboutStoryMosaicReveal() {

    var col = document.querySelector( '.lumea-about-story-img-col' );
    var pin = document.querySelector( '.lumea-about-story-img-pin' );
    if ( ! col || ! pin ) return;

    var img = pin.querySelector( 'img' );
    if ( ! img ) return;

    /* Position column so absolute mosaic grid sits inside it */
    col.style.position = 'relative';

    var grid = document.createElement( 'div' );
    grid.className = 'lumea-mosaic-grid';
    for ( var i = 0; i < 24; i++ ) {
      var span = document.createElement( 'span' );
      span.className = 'lumea-mosaic-tile';
      grid.appendChild( span );
    }
    col.appendChild( grid );

    var tiles = grid.querySelectorAll( '.lumea-mosaic-tile' );
    gsap.set( img, { scale: 1.18, filter: 'blur(8px)' } );

    ScrollTrigger.create( {
      trigger: pin,
      start:   'top 80%',
      once:    true,
      onEnter: function () {

        gsap.to( tiles, {
          opacity:  0,
          scale:    0.4,
          rotate:   function () { return gsap.utils.random( -18, 18 ); },
          yPercent: function () { return gsap.utils.random( -80, 80 ); },
          xPercent: function () { return gsap.utils.random( -80, 80 ); },
          duration: 0.9,
          ease:     'power4.inOut',
          stagger:  { amount: 0.65, from: 'random' },
          onComplete: function () { gsap.set( grid, { display: 'none' } ); },
        } );

        gsap.to( img, {
          scale:    1,
          filter:   'blur(0px)',
          duration: 1.35,
          ease:     'power4.out',
        } );

      },
    } );

  } )();


  /* ── About story panels — staggered children reveal per panel ── */
  ( function initAboutStoryPanelReveal() {

    document.querySelectorAll( '.lumea-about-story-panel-js' ).forEach( function ( panel ) {
      var children = Array.prototype.slice.call( panel.children );
      if ( ! children.length ) return;

      gsap.set( children, { autoAlpha: 0, y: 24 } );

      ScrollTrigger.create( {
        trigger: panel,
        start:   'top 65%',
        once:    true,
        onEnter: function () {
          gsap.to( children, {
            autoAlpha: 1,
            y:         0,
            duration:  0.7,
            ease:      'power3.out',
            stagger:   0.12,
          } );
        },
      } );
    } );

  } )();

} )();