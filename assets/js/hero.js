/**
 * Luméa Hero — Canvas cursor deformation + fluid background slider.
 * Transition: wavy clip-path sweep alternating left/right for a liquid reveal.
 * Image URLs passed from PHP via lumea_hero.images[].
 */
( function () {
  'use strict';

  const canvas    = document.getElementById( 'heroCanvas' );
  const ctx       = canvas.getContext( '2d', { alpha: false } );
  const hero      = document.querySelector( '.hero' );
  const heroLabel = document.querySelector( '[data-lumea-hero-label]' );
  const baseLayer = document.createElement( 'canvas' );
  const baseCtx   = baseLayer.getContext( '2d', { alpha: false } );

  /* ── GSAP + SplitText label setup ───────────────────────────── */
  const gsapOk    = typeof gsap !== 'undefined';
  const stOk      = gsapOk && typeof SplitText !== 'undefined';
  let   labelSplit = null;   /* SplitText instance, rebuilt on each text swap */
  let   labelAnimTriggered = false; /* guard: fire GSAP only once per transition */
  let   pendingLabelIndex  = -1;    /* next label value, staged before wave arrives */
  let   pendingLabelDir    = 0;

  /* Pre-split on load so chars exist immediately */
  function splitLabel() {
    if ( ! heroLabel || ! stOk ) return;
    if ( labelSplit ) { try { labelSplit.revert(); } catch(e){} }
    labelSplit = new SplitText( heroLabel, { type: 'chars,words' } );
    gsap.set( labelSplit.chars, { transformOrigin: 'bottom center' } );
  }

  /* Stage the new label text (hidden) so it's ready the moment the
     wave arrives. The actual GSAP play is deferred to fireWaveLabelAnim(). */
  function setHeroLabel( index, dir ) {
    if ( ! heroLabel ) return;

    pendingLabelIndex    = index;
    pendingLabelDir      = dir || 0;
    labelAnimTriggered   = false;

    if ( ! gsapOk ) {
      /* Fallback: just update text immediately */
      heroLabel.textContent = getHeroLabelValue( index );
    }
    /* With GSAP: text + animation are applied in fireWaveLabelAnim()
       triggered from the render loop when the wave crosses the label. */
  }

  /* Called from render loop at the exact frame the wave edge passes
     the label element — gives pixel-accurate sync with the wave.     */
  function fireWaveLabelAnim() {
    if ( labelAnimTriggered || pendingLabelIndex < 0 ) return;
    labelAnimTriggered = true;

    if ( ! gsapOk ) return;

    const dir   = pendingLabelDir;
    const value = getHeroLabelValue( pendingLabelIndex );

    /* Kill any running tween on the label */
    gsap.killTweensOf( heroLabel );
    if ( labelSplit ) gsap.killTweensOf( labelSplit.chars );

    /* Swap text and rebuild split */
    heroLabel.textContent = value;
    splitLabel();

    if ( ! labelSplit || ! labelSplit.chars.length ) return;

    const chars  = labelSplit.chars;
    const fromX  = dir === 1 ? -28 : 28;   /* slide in from wave direction */

    /* Exit: instantly hide chars (they just appeared with new text) */
    gsap.set( chars, { opacity: 0, y: 18, x: fromX, rotateX: -55, filter: 'blur(6px)' } );

    /* Enter: stagger each character in */
    gsap.to( chars, {
      opacity:  1,
      y:        0,
      x:        0,
      rotateX:  0,
      filter:   'blur(0px)',
      duration: 0.55,
      ease:     'power3.out',
      stagger: {
        each:   0.045,
        from:   dir === 1 ? 'start' : 'end',
      },
    } );
  }

  /* ── Resolve image list ──────────────────────────────────────── */

  const rawUrls = ( function () {
    if ( typeof lumea_hero === 'undefined' ) return [];
    if ( Array.isArray( lumea_hero.images ) && lumea_hero.images.length ) {
      return lumea_hero.images.filter( Boolean );
    }
    return lumea_hero.imageUrl ? [ lumea_hero.imageUrl ] : [];
  } )();

  if ( ! rawUrls.length ) return;

  const rawLabels = ( function () {
    if ( typeof lumea_hero === 'undefined' ) return [];
    if ( Array.isArray( lumea_hero.labels ) && lumea_hero.labels.length ) {
      return lumea_hero.labels.map( function ( label ) {
        return String( label || '' ).trim();
      } );
    }
    return [];
  } )();

  function getHeroLabelValue( index ) {
    if ( ! heroLabel ) return '';
    const fallback = String( rawLabels[0] || heroLabel.textContent || '' ).trim();
    return String( rawLabels[ index ] || fallback ).trim() || fallback;
  }

  /* ── Preload ─────────────────────────────────────────────────── */

  const imgs = new Array( rawUrls.length ).fill( null );
  let readyCount = 0;

  rawUrls.forEach( function ( url, i ) {
    const image   = new Image();
    image.onload  = function () { imgs[i] = image; readyCount++; if ( i === 0 ) resizeCanvas(); };
    image.onerror = function () { readyCount++; };
    image.src     = url;
  } );

  /* ── Slide state ─────────────────────────────────────────────── */

  let currentIndex    = 0;
  let nextIndex       = 1;
  let crossfade       = 0;     // 0 = fully current, 1 = fully next
  let isTransitioning = false;
  let lastSlideTime   = -1;    // -1 triggers init on first frame
  let fadeStartTime   = 0;
  let transitionCount = 0;     // alternates entry side every transition
  let transitionDir   = 1;     // 1 = from left, -1 = from right

  const SLIDE_DURATION = 6000;   // ms each image is displayed
  const FADE_DURATION  = 2400;   // ms for the fluid transition

  function easeInOut( t ) {
    return t < 0.5 ? 2 * t * t : -1 + ( 4 - 2 * t ) * t;
  }

  /* ── Canvas state ────────────────────────────────────────────── */

  let width  = 0;
  let height = 0;
  let dpr    = Math.min( window.devicePixelRatio || 1, 2 );

  const pointer = {
    x: 0, y: 0, tx: 0, ty: 0,
    inside: false, moved: false,
    radiusRatio: 0.11, radius: 0, strength: 0,
    lastX: 0, lastY: 0, velocityX: 0, velocityY: 0,
    lastMoveTime: -Infinity,
  };

  /* ── Resize ──────────────────────────────────────────────────── */

  function resizeCanvas() {
    const rect  = canvas.getBoundingClientRect();
    width       = rect.width;
    height      = rect.height;
    dpr         = Math.min( window.devicePixelRatio || 1, 2 );

    canvas.width  = Math.floor( width  * dpr );
    canvas.height = Math.floor( height * dpr );
    ctx.setTransform( dpr, 0, 0, dpr, 0, 0 );

    baseLayer.width  = canvas.width;
    baseLayer.height = canvas.height;
    baseCtx.setTransform( dpr, 0, 0, dpr, 0, 0 );

    pointer.radius = Math.min( width, height ) * pointer.radiusRatio;
  }

  /* ── Cover-fit helper ────────────────────────────────────────── */

  function getCoverRect( image, cw, ch ) {
    const ir = image.width / image.height;
    const cr = cw / ch;
    let dw, dh, dx, dy;
    if ( ir > cr ) { dh = ch; dw = dh * ir; dx = ( cw - dw ) / 2; dy = 0; }
    else           { dw = cw; dh = dw / ir; dx = 0; dy = ( ch - dh ) / 2; }
    return { dx, dy, dw, dh };
  }

  /* ── Tone overlay ────────────────────────────────────────────── */

  function applyOverlay( tCtx ) {
    const g = tCtx.createLinearGradient( 0, 0, width, height );
    g.addColorStop( 0,    'rgba(11, 42, 31, 0.42)' );
    g.addColorStop( 0.45, 'rgba(0,  0,  0,  0.02)' );
    g.addColorStop( 1,    'rgba(0,  0,  0,  0.34)' );
    tCtx.fillStyle = g;
    tCtx.fillRect( 0, 0, width, height );
  }

  /* ── Base image with fluid transition ────────────────────────── */

  function drawBaseImage( tCtx ) {
    const curr = imgs[ currentIndex ];
    if ( ! curr ) return;

    const c = getCoverRect( curr, width, height );

    tCtx.save();
    tCtx.clearRect( 0, 0, width, height );

    if ( ! isTransitioning ) {
      /* ── Static display ─────────────────────────────────────── */
      tCtx.drawImage( curr, c.dx, c.dy, c.dw, c.dh );

    } else {
      /* ── Fluid transition ───────────────────────────────────── */
      const next = imgs[ nextIndex ];
      const t    = performance.now() * 0.001;

      /*  Wave amplitude peaks at the midpoint of the transition,
          zero at start and end — so the edge is straight when still,
          most wavy when the images are evenly blended.             */
      const amp = height * 0.092 * Math.sin( Math.PI * crossfade );

      /*  Sweep position alternates each transition:
          dir=1:  left  → right
          dir=-1: right → left
          We over-travel by ±amp so the wave never gets clamped. */
      const sweepX = transitionDir === 1
        ? crossfade * ( width + amp * 2 ) - amp
        : ( 1 - crossfade ) * ( width + amp * 2 ) - amp;

      const getWaveX = function ( y ) {
        return sweepX + amp * (
          0.65 * Math.sin( y * 0.010 + t * 1.9 ) +
          0.35 * Math.sin( y * 0.025 - t * 2.3 )
        );
      };

      /* ── Wave-position label trigger ──────────────────────────
         Fire the GSAP animation the exact frame the wave edge
         passes the label element's leading edge.                */
      if ( ! labelAnimTriggered && heroLabel ) {
        const heroRect  = hero.getBoundingClientRect();
        const lRect     = heroLabel.getBoundingClientRect();
        const lLeading  = transitionDir === 1
          ? lRect.left  - heroRect.left   /* LTR: wave approaches from left */
          : lRect.right - heroRect.left;  /* RTL: wave approaches from right */
        const waveAtLabel = getWaveX( lRect.top - heroRect.top + lRect.height / 2 );
        const crossed = transitionDir === 1
          ? waveAtLabel >= lLeading
          : waveAtLabel <= lLeading;
        if ( crossed ) fireWaveLabelAnim();
      }

      /* Draw old image as the base layer */
      tCtx.drawImage( curr, c.dx, c.dy, c.dw, c.dh );

      if ( next && next.naturalWidth ) {
        const n = getCoverRect( next, width, height );

        /*  Build a wavy clip path for the new image side. */
        tCtx.save();
        tCtx.beginPath();
        if ( transitionDir === 1 ) {
          /* New image is LEFT of the wave. */
          tCtx.moveTo( -2, -2 );
          tCtx.lineTo( getWaveX( 0 ), -2 );
          for ( let y = 0; y <= height + 2; y += 2 ) {
            tCtx.lineTo( getWaveX( y ), y );
          }
          tCtx.lineTo( -2, height + 2 );
        } else {
          /* New image is RIGHT of the wave. */
          tCtx.moveTo( width + 2, -2 );
          tCtx.lineTo( getWaveX( 0 ), -2 );
          for ( let y = 0; y <= height + 2; y += 2 ) {
            tCtx.lineTo( getWaveX( y ), y );
          }
          tCtx.lineTo( width + 2, height + 2 );
        }
        tCtx.closePath();
        tCtx.clip();

        tCtx.drawImage( next, n.dx, n.dy, n.dw, n.dh );
        tCtx.restore();

        /*  Soft luminance glow along the seam.
            A narrow semi-transparent white strip gives the impression
            of light refracting through moving water.                */
        const glowW = Math.max( 12, height * 0.04 * Math.sin( Math.PI * crossfade ) );
        for ( let y = 0; y < height; y += 2 ) {
          const wx = getWaveX( y );
          const glowGrad = tCtx.createLinearGradient( wx - glowW, y, wx + glowW, y );
          glowGrad.addColorStop( 0,   'rgba(255,255,255,0)' );
          glowGrad.addColorStop( 0.5, 'rgba(255,255,255,0.07)' );
          glowGrad.addColorStop( 1,   'rgba(255,255,255,0)' );
          tCtx.fillStyle = glowGrad;
          tCtx.fillRect( wx - glowW, y, glowW * 2, 2 );
        }
      }
    }

    applyOverlay( tCtx );
    tCtx.restore();
  }

  /* ── Cursor deformation (unchanged from original) ────────────── */

  function drawCursorDeformation() {
    if ( ! pointer.moved ) return;

    pointer.x += ( pointer.tx - pointer.x ) * 0.16;
    pointer.y += ( pointer.ty - pointer.y ) * 0.16;
    pointer.velocityX = pointer.x - pointer.lastX;
    pointer.velocityY = pointer.y - pointer.lastY;
    pointer.lastX = pointer.x;
    pointer.lastY = pointer.y;

    const now      = performance.now();
    const isMoving = pointer.inside && ( now - pointer.lastMoveTime < 72 );

    pointer.strength += ( ( isMoving ? 1 : 0 ) - pointer.strength ) * 0.14;
    if ( pointer.strength < 0.01 ) return;

    const time = now * 0.0012;
    const ssx  = baseLayer.width  / width;
    const ssy  = baseLayer.height / height;
    const speed = Math.hypot( pointer.velocityX, pointer.velocityY );
    const flow  = Math.min( 1, speed / 36 );

    const rx             = pointer.radius * ( 1   + 0.04 * pointer.strength );
    const ry             = pointer.radius * ( 0.9 + 0.02 * Math.sin( time * 1.1 ) );
    const stripH         = 1;
    const swirlS         = rx * ( 0.028 + 0.01 * pointer.strength );
    const pressureS      = rx * ( 0.017 + 0.01 * flow );
    const trailS         = 0.28 + flow * 0.34;

    ctx.save();
    ctx.imageSmoothingEnabled = true;
    if ( 'imageSmoothingQuality' in ctx ) ctx.imageSmoothingQuality = 'high';

    for ( let y = pointer.y - ry; y <= pointer.y + ry; y += stripH ) {
      const dy = y - pointer.y;
      const ny = dy / ry;
      if ( Math.abs( ny ) >= 1 ) continue;

      const core  = Math.max( 0, 1 - ny * ny );
      const halfW = rx * Math.sqrt( core );
      if ( halfW < 1.2 ) continue;

      const stripX  = pointer.x - halfW;
      const stripW  = halfW * 2;
      const falloff = Math.pow( core, 2.5 );

      const swirl       = Math.sin( dy * 0.018 - time * 2.4 + pointer.x * 0.0018 ) * swirlS * falloff;
      const pressure    = Math.cos( dy * 0.031 + time * 1.55 ) * pressureS * falloff;
      const microRipple = Math.sin( dy * 0.011 - time * 1.15 ) * ( pressureS * 0.35 ) * falloff;
      const trailX      = pointer.velocityX * trailS * falloff;
      const trailY      = pointer.velocityY * ( trailS * 0.1 ) * falloff;
      const shear       = ny * pointer.velocityX * 0.06 * falloff;

      const offsetX = swirl + pressure + microRipple + trailX + shear;
      const offsetY = Math.sin( dy * 0.02 - time * 2.1 ) * ( ry * 0.012 ) * falloff + trailY;

      const srcX = ( stripX - offsetX ) * ssx;
      const srcY = ( y      - offsetY ) * ssy;
      const srcW = stripW  * ssx;
      const srcH = stripH  * ssy;

      if ( srcX < 0 || srcY < 0 || srcX + srcW > baseLayer.width || srcY + srcH > baseLayer.height ) continue;

      ctx.globalAlpha = 0.92 + falloff * 0.08;
      ctx.drawImage( baseLayer, srcX, srcY, srcW, srcH, stripX, y, stripW, stripH + 0.2 );
    }

    ctx.restore();
  }

  /* ── Noise grain ─────────────────────────────────────────────── */

  function drawNoise() {
    ctx.save();
    ctx.globalAlpha = 0.03;
    ctx.fillStyle   = '#fff';
    for ( let i = 0; i < 90; i++ ) {
      ctx.fillRect( Math.random() * width, Math.random() * height, Math.random() * 1.1, Math.random() * 1.1 );
    }
    ctx.restore();
  }

  /* ── Render loop ─────────────────────────────────────────────── */

  function render( timestamp ) {

    /* Initialise slide timer on very first frame */
    if ( lastSlideTime < 0 ) lastSlideTime = timestamp;

    if ( imgs[0] && imgs[0].naturalWidth ) {

      /* ── Slide timing ──────────────────────────────────────── */
      const activeCount = imgs.filter( Boolean ).length;
      if ( activeCount > 1 ) {

        if ( ! isTransitioning && ( timestamp - lastSlideTime ) > SLIDE_DURATION ) {
          isTransitioning = true;
          fadeStartTime   = timestamp;
          transitionDir   = ( transitionCount % 2 === 0 ) ? 1 : -1;
          transitionCount++;
          nextIndex       = ( currentIndex + 1 ) % activeCount;
          setHeroLabel( nextIndex, transitionDir );
        }

        if ( isTransitioning ) {
          const raw  = Math.min( 1, ( timestamp - fadeStartTime ) / FADE_DURATION );
          crossfade  = easeInOut( raw );

          if ( raw >= 1 ) {
            currentIndex    = nextIndex;
            isTransitioning = false;
            crossfade       = 0;
            lastSlideTime   = timestamp;

          }
        }
      }

      /* ── Composite ─────────────────────────────────────────── */
      drawBaseImage( baseCtx );

      ctx.clearRect( 0, 0, width, height );
      ctx.drawImage( baseLayer, 0, 0, baseLayer.width, baseLayer.height, 0, 0, width, height );

      drawCursorDeformation();
      drawNoise();

    } else {
      ctx.fillStyle = '#183b2e';
      ctx.fillRect( 0, 0, width, height );
    }

    requestAnimationFrame( render );
  }

  /* ── Pointer events ──────────────────────────────────────────── */

  function setPointer( e ) {
    const rect        = canvas.getBoundingClientRect();
    pointer.tx        = e.clientX - rect.left;
    pointer.ty        = e.clientY - rect.top;
    pointer.moved     = true;
    pointer.lastMoveTime = performance.now();
  }

  window.addEventListener( 'resize', resizeCanvas );
  hero.addEventListener( 'pointermove',  setPointer );
  hero.addEventListener( 'pointerenter', function ( e ) {
    pointer.inside = true;
    const rect = canvas.getBoundingClientRect();
    pointer.tx = e.clientX - rect.left;
    pointer.ty = e.clientY - rect.top;
  } );
  hero.addEventListener( 'pointerleave', function () { pointer.inside = false; } );

  resizeCanvas();

  /* Set initial label text and split it for GSAP */
  heroLabel && ( heroLabel.textContent = getHeroLabelValue( 0 ) );
  splitLabel();

  requestAnimationFrame( render );

} )();
