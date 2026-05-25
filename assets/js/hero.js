/**
 * Luméa Hero — Canvas cursor deformation + background slider.
 * Image URLs passed from PHP via lumea_hero.images[] (or legacy .imageUrl).
 */
( function () {
  'use strict';

  const canvas    = document.getElementById( 'heroCanvas' );
  const ctx       = canvas.getContext( '2d', { alpha: false } );
  const hero      = document.querySelector( '.hero' );
  const baseLayer = document.createElement( 'canvas' );
  const baseCtx   = baseLayer.getContext( '2d', { alpha: false } );

  /* ── Resolve image list ────────────────────────────────── */

  const rawUrls = ( function () {
    if ( typeof lumea_hero === 'undefined' ) return [];
    if ( Array.isArray( lumea_hero.images ) && lumea_hero.images.length ) {
      return lumea_hero.images.filter( Boolean );
    }
    return lumea_hero.imageUrl ? [ lumea_hero.imageUrl ] : [];
  } )();

  if ( ! rawUrls.length ) return;

  /* ── Preload all images ─────────────────────────────────── */

  const imgs       = new Array( rawUrls.length ).fill( null );
  let   readyCount = 0;

  rawUrls.forEach( function ( url, i ) {
    const image   = new Image();
    image.onload  = function () {
      imgs[ i ] = image;
      readyCount++;
      if ( i === 0 ) resizeCanvas();
    };
    image.onerror = function () { readyCount++; };
    image.src = url;
  } );

  /* ── Slide state ────────────────────────────────────────── */

  let currentIndex    = 0;
  let nextIndex       = 1;
  let crossfade       = 0;
  let isTransitioning = false;
  let lastSlideTime   = 0;
  let fadeStartTime   = 0;

  const SLIDE_DURATION = 5500;   // ms each image is shown
  const FADE_DURATION  = 1600;   // ms for the crossfade

  function easeInOut( t ) {
    return t < 0.5 ? 2 * t * t : -1 + ( 4 - 2 * t ) * t;
  }

  /* ── Canvas + pointer state ─────────────────────────────── */

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

  /* ── Resize ─────────────────────────────────────────────── */

  function resizeCanvas() {
    const rect = canvas.getBoundingClientRect();
    width  = rect.width;
    height = rect.height;
    dpr    = Math.min( window.devicePixelRatio || 1, 2 );

    canvas.width  = Math.floor( width  * dpr );
    canvas.height = Math.floor( height * dpr );
    ctx.setTransform( dpr, 0, 0, dpr, 0, 0 );

    baseLayer.width  = canvas.width;
    baseLayer.height = canvas.height;
    baseCtx.setTransform( dpr, 0, 0, dpr, 0, 0 );

    pointer.radius = Math.min( width, height ) * pointer.radiusRatio;
  }

  /* ── Helpers ────────────────────────────────────────────── */

  function getCoverRect( image, cw, ch ) {
    const ir = image.width / image.height;
    const cr = cw / ch;
    let dw, dh, dx, dy;
    if ( ir > cr ) { dh = ch; dw = dh * ir; dx = ( cw - dw ) / 2; dy = 0; }
    else           { dw = cw; dh = dw / ir; dx = 0; dy = ( ch - dh ) / 2; }
    return { dx, dy, dw, dh };
  }

  function applyOverlay( targetCtx ) {
    const g = targetCtx.createLinearGradient( 0, 0, width, height );
    g.addColorStop( 0,    'rgba(11, 42, 31, 0.42)' );
    g.addColorStop( 0.45, 'rgba(0,  0,  0,  0.02)' );
    g.addColorStop( 1,    'rgba(0,  0,  0,  0.34)' );
    targetCtx.fillStyle = g;
    targetCtx.fillRect( 0, 0, width, height );
  }

  /* ── Draw base layer with crossfade ─────────────────────── */

  function drawBaseImage( targetCtx ) {
    const curr = imgs[ currentIndex ];
    if ( ! curr ) return;

    const c = getCoverRect( curr, width, height );

    targetCtx.save();
    targetCtx.clearRect( 0, 0, width, height );

    // Current image (full opacity)
    targetCtx.globalAlpha = 1;
    targetCtx.drawImage( curr, c.dx, c.dy, c.dw, c.dh );

    // Blend next image on top during transition
    if ( isTransitioning ) {
      const next = imgs[ nextIndex ];
      if ( next && next.naturalWidth ) {
        const n = getCoverRect( next, width, height );
        targetCtx.globalAlpha = crossfade;
        targetCtx.drawImage( next, n.dx, n.dy, n.dw, n.dh );
      }
    }

    targetCtx.globalAlpha = 1;
    applyOverlay( targetCtx );
    targetCtx.restore();
  }

  /* ── Cursor deformation (unchanged) ────────────────────── */

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
    const sourceScaleX = baseLayer.width  / width;
    const sourceScaleY = baseLayer.height / height;
    const speed  = Math.hypot( pointer.velocityX, pointer.velocityY );
    const flow   = Math.min( 1, speed / 36 );

    const rx             = pointer.radius * ( 1   + 0.04 * pointer.strength );
    const ry             = pointer.radius * ( 0.9 + 0.02 * Math.sin( time * 1.1 ) );
    const stripH         = 1;
    const swirlStrength  = rx * ( 0.028 + 0.01 * pointer.strength );
    const pressureStrength = rx * ( 0.017 + 0.01 * flow );
    const trailStrength  = 0.28 + flow * 0.34;

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

      const stripX = pointer.x - halfW;
      const stripW = halfW * 2;
      const falloff = Math.pow( core, 2.5 );

      const swirl = Math.sin( dy * 0.018 - time * 2.4 + pointer.x * 0.0018 ) * swirlStrength * falloff;
      const pressure = Math.cos( dy * 0.031 + time * 1.55 ) * pressureStrength * falloff;
      const microRipple = Math.sin( dy * 0.011 - time * 1.15 ) * ( pressureStrength * 0.35 ) * falloff;
      const trailX = pointer.velocityX * trailStrength * falloff;
      const trailY = pointer.velocityY * ( trailStrength * 0.1 ) * falloff;
      const shear  = ny * pointer.velocityX * 0.06 * falloff;

      const offsetX = swirl + pressure + microRipple + trailX + shear;
      const offsetY = Math.sin( dy * 0.02 - time * 2.1 ) * ( ry * 0.012 ) * falloff + trailY;

      const sourceX = ( stripX - offsetX ) * sourceScaleX;
      const sourceY = ( y      - offsetY ) * sourceScaleY;
      const sourceW = stripW * sourceScaleX;
      const sourceH = stripH * sourceScaleY;

      if ( sourceX < 0 || sourceY < 0 || sourceX + sourceW > baseLayer.width || sourceY + sourceH > baseLayer.height ) continue;

      ctx.globalAlpha = 0.92 + falloff * 0.08;
      ctx.drawImage( baseLayer, sourceX, sourceY, sourceW, sourceH, stripX, y, stripW, stripH + 0.2 );
    }

    ctx.restore();
  }

  /* ── Noise grain ────────────────────────────────────────── */

  function drawNoise() {
    ctx.save();
    ctx.globalAlpha = 0.03;
    ctx.fillStyle   = '#fff';
    for ( let i = 0; i < 90; i++ ) {
      ctx.fillRect( Math.random() * width, Math.random() * height, Math.random() * 1.1, Math.random() * 1.1 );
    }
    ctx.restore();
  }

  /* ── Render loop ────────────────────────────────────────── */

  function render( timestamp ) {
    if ( imgs[0] && imgs[0].naturalWidth ) {

      /* ── Advance slide timing ────────────────────────── */
      const activeCount = imgs.filter( Boolean ).length;
      if ( activeCount > 1 ) {
        if ( ! isTransitioning && ( timestamp - lastSlideTime ) > SLIDE_DURATION ) {
          isTransitioning = true;
          fadeStartTime   = timestamp;
          nextIndex       = ( currentIndex + 1 ) % activeCount;
        }

        if ( isTransitioning ) {
          const raw = Math.min( 1, ( timestamp - fadeStartTime ) / FADE_DURATION );
          crossfade = easeInOut( raw );

          if ( raw >= 1 ) {
            currentIndex    = nextIndex;
            isTransitioning = false;
            crossfade       = 0;
            lastSlideTime   = timestamp;
          }
        }
      }

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

  /* ── Pointer events ─────────────────────────────────────── */

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
  requestAnimationFrame( render );

} )();
