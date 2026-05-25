/**
 * Luméa Hero — Canvas cursor deformation animation.
 * Image URL is passed from PHP via wp_localize_script as lumea_hero.imageUrl.
 */
( function () {
  'use strict';

  const canvas   = document.getElementById( 'heroCanvas' );
  const ctx      = canvas.getContext( '2d', { alpha: false } );
  const hero     = document.querySelector( '.hero' );
  const baseLayer = document.createElement( 'canvas' );
  const baseCtx  = baseLayer.getContext( '2d', { alpha: false } );

  const imageUrl = ( typeof lumea_hero !== 'undefined' && lumea_hero.imageUrl )
    ? lumea_hero.imageUrl
    : '';

  const img = new Image();
  img.src = imageUrl;

  let width  = 0;
  let height = 0;
  let dpr    = Math.min( window.devicePixelRatio || 1, 2 );

  const pointer = {
    x: 0,
    y: 0,
    tx: 0,
    ty: 0,
    inside: false,
    moved: false,
    radiusRatio: 0.11,
    radius: 0,
    strength: 0,
    lastX: 0,
    lastY: 0,
    velocityX: 0,
    velocityY: 0,
    lastMoveTime: -Infinity
  };

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

  function getCoverRect( image, canvasW, canvasH ) {
    const imageRatio  = image.width / image.height;
    const canvasRatio = canvasW / canvasH;

    let drawW, drawH, drawX, drawY;

    if ( imageRatio > canvasRatio ) {
      drawH = canvasH;
      drawW = drawH * imageRatio;
      drawX = ( canvasW - drawW ) / 2;
      drawY = 0;
    } else {
      drawW = canvasW;
      drawH = drawW / imageRatio;
      drawX = 0;
      drawY = ( canvasH - drawH ) / 2;
    }

    return { drawX, drawY, drawW, drawH };
  }

  function drawBaseImage( targetCtx ) {
    const cover = getCoverRect( img, width, height );

    targetCtx.save();
    targetCtx.clearRect( 0, 0, width, height );
    targetCtx.drawImage( img, cover.drawX, cover.drawY, cover.drawW, cover.drawH );

    const gradient = targetCtx.createLinearGradient( 0, 0, width, height );
    gradient.addColorStop( 0,    'rgba(11, 42, 31, 0.42)' );
    gradient.addColorStop( 0.45, 'rgba(0, 0, 0, 0.02)' );
    gradient.addColorStop( 1,    'rgba(0, 0, 0, 0.34)' );

    targetCtx.fillStyle = gradient;
    targetCtx.fillRect( 0, 0, width, height );
    targetCtx.restore();

    return cover;
  }

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

    const rx             = pointer.radius * ( 1    + 0.04 * pointer.strength );
    const ry             = pointer.radius * ( 0.9  + 0.02 * Math.sin( time * 1.1 ) );
    const stripH         = 1;
    const swirlStrength  = rx * ( 0.028 + 0.01 * pointer.strength );
    const pressureStrength = rx * ( 0.017 + 0.01 * flow );
    const trailStrength  = 0.28 + flow * 0.34;

    ctx.save();
    ctx.imageSmoothingEnabled = true;
    if ( 'imageSmoothingQuality' in ctx ) {
      ctx.imageSmoothingQuality = 'high';
    }

    for ( let y = pointer.y - ry; y <= pointer.y + ry; y += stripH ) {
      const dy = y - pointer.y;
      const ny = dy / ry;

      if ( Math.abs( ny ) >= 1 ) continue;

      const core   = Math.max( 0, 1 - ny * ny );
      const halfW  = rx * Math.sqrt( core );

      if ( halfW < 1.2 ) continue;

      const stripX = pointer.x - halfW;
      const stripW = halfW * 2;
      const falloff = Math.pow( core, 2.5 );

      const swirl =
        Math.sin( dy * 0.018 - time * 2.4 + pointer.x * 0.0018 ) *
        swirlStrength *
        falloff;

      const pressure =
        Math.cos( dy * 0.031 + time * 1.55 ) *
        pressureStrength *
        falloff;

      const microRipple =
        Math.sin( dy * 0.011 - time * 1.15 ) *
        ( pressureStrength * 0.35 ) *
        falloff;

      const trailX = pointer.velocityX * trailStrength * falloff;
      const trailY = pointer.velocityY * ( trailStrength * 0.1 ) * falloff;
      const shear  = ny * pointer.velocityX * 0.06 * falloff;

      const offsetX = swirl + pressure + microRipple + trailX + shear;
      const offsetY =
        Math.sin( dy * 0.02 - time * 2.1 ) *
          ( ry * 0.012 ) *
          falloff +
        trailY;

      const sourceX = ( stripX - offsetX ) * sourceScaleX;
      const sourceY = ( y      - offsetY ) * sourceScaleY;
      const sourceW = stripW * sourceScaleX;
      const sourceH = stripH * sourceScaleY;

      if (
        sourceX < 0 ||
        sourceY < 0 ||
        sourceX + sourceW > baseLayer.width ||
        sourceY + sourceH > baseLayer.height
      ) {
        continue;
      }

      ctx.globalAlpha = 0.92 + falloff * 0.08;

      ctx.drawImage(
        baseLayer,
        sourceX, sourceY, sourceW, sourceH,
        stripX,  y,       stripW,  stripH + 0.2
      );
    }

    ctx.restore();
  }

  function drawNoise() {
    const amount = 90;

    ctx.save();
    ctx.globalAlpha = 0.03;
    ctx.fillStyle   = '#fff';

    for ( let i = 0; i < amount; i++ ) {
      const x = Math.random() * width;
      const y = Math.random() * height;
      const s = Math.random() * 1.1;
      ctx.fillRect( x, y, s, s );
    }

    ctx.restore();
  }

  function render() {
    if ( img.complete && img.naturalWidth ) {
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

  function setPointer( event ) {
    const rect = canvas.getBoundingClientRect();
    pointer.tx           = event.clientX - rect.left;
    pointer.ty           = event.clientY - rect.top;
    pointer.moved        = true;
    pointer.lastMoveTime = performance.now();
  }

  window.addEventListener( 'resize', resizeCanvas );

  hero.addEventListener( 'pointermove', setPointer );

  hero.addEventListener( 'pointerenter', function ( event ) {
    pointer.inside = true;
    const rect = canvas.getBoundingClientRect();
    pointer.tx = event.clientX - rect.left;
    pointer.ty = event.clientY - rect.top;
  } );

  hero.addEventListener( 'pointerleave', function () {
    pointer.inside = false;
  } );

  img.onload = function () {
    resizeCanvas();
  };

  resizeCanvas();
  render();
} )();
