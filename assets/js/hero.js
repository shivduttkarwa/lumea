

( function () {
  'use strict';

  const canvas    = document.getElementById( 'heroCanvas' );
  const ctx       = canvas.getContext( '2d', { alpha: false } );
  const hero      = document.querySelector( '.hero' );
  const heroLabel = document.querySelector( '[data-lumea-hero-label]' );
  const baseLayer = document.createElement( 'canvas' );
  const baseCtx   = baseLayer.getContext( '2d', { alpha: false } );

  
  const gsapOk = typeof gsap !== 'undefined';
  let   labelChars         = [];    
  let   labelAnimTriggered = false;
  let   pendingLabelIndex  = -1;
  let   pendingLabelDir    = 0;

  

  function splitIntoChars( el ) {
    const text = el.textContent.trim();
    el.innerHTML = '';
    return Array.from( text ).map( function ( ch ) {
      var s = document.createElement( 'span' );
      s.style.cssText = 'display:inline-block;will-change:transform,opacity,filter;opacity:0;';
      s.textContent   = ch === ' ' ? ' ' : ch;
      el.appendChild( s );
      return s;
    } );
  }

  
  function setHeroLabel( index, dir ) {
    if ( ! heroLabel ) return;
    pendingLabelIndex  = index;
    pendingLabelDir    = dir || 0;
    labelAnimTriggered = false;

    if ( ! gsapOk ) {
      heroLabel.textContent = getHeroLabelValue( index );
    }
  }

  
  function fireWaveLabelAnim() {
    if ( labelAnimTriggered || pendingLabelIndex < 0 ) return;
    labelAnimTriggered = true;

    if ( ! gsapOk ) return;

    var dir   = pendingLabelDir;
    var value = getHeroLabelValue( pendingLabelIndex );

    
    gsap.killTweensOf( labelChars );
    gsap.killTweensOf( heroLabel );

    
    heroLabel.textContent = value;
    labelChars = splitIntoChars( heroLabel );
    if ( ! labelChars.length ) return;

    var fromX = dir === 1 ? -22 : 22;

    

    gsap.fromTo( labelChars, {
      opacity:    0,
      y:          20,
      x:          fromX,
      rotationX:  -60,
      filter:     'blur(5px)',
      transformOrigin: '50% 100%',
    }, {
      opacity:   1,
      y:         0,
      x:         0,
      rotationX: 0,
      filter:    'blur(0px)',
      duration:  0.6,
      ease:      'power3.out',
      stagger: {
        each: 0.05,
        from: dir === 1 ? 'start' : 'end',
      },
    } );
  }

  

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

  

  const imgs = new Array( rawUrls.length ).fill( null );
  let readyCount = 0;

  rawUrls.forEach( function ( url, i ) {
    const image   = new Image();
    image.onload  = function () { imgs[i] = image; readyCount++; if ( i === 0 ) resizeCanvas(); };
    image.onerror = function () { readyCount++; };
    image.src     = url;
  } );

  

  let currentIndex    = 0;
  let nextIndex       = 1;
  let crossfade       = 0;     
  let isTransitioning = false;
  let lastSlideTime   = -1;    
  let fadeStartTime   = 0;
  let transitionCount = 0;     
  let transitionDir   = 1;     

  const SLIDE_DURATION = 6000;   
  const FADE_DURATION  = 2400;   

  function easeInOut( t ) {
    return t < 0.5 ? 2 * t * t : -1 + ( 4 - 2 * t ) * t;
  }

  

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

  

  function getCoverRect( image, cw, ch ) {
    const ir = image.width / image.height;
    const cr = cw / ch;
    let dw, dh, dx, dy;
    if ( ir > cr ) { dh = ch; dw = dh * ir; dx = ( cw - dw ) / 2; dy = 0; }
    else           { dw = cw; dh = dw / ir; dx = 0; dy = ( ch - dh ) / 2; }
    return { dx, dy, dw, dh };
  }

  

  function applyOverlay( tCtx ) {
    const g = tCtx.createLinearGradient( 0, 0, width, height );
    g.addColorStop( 0,    'rgba(11, 42, 31, 0.42)' );
    g.addColorStop( 0.45, 'rgba(0,  0,  0,  0.02)' );
    g.addColorStop( 1,    'rgba(0,  0,  0,  0.34)' );
    tCtx.fillStyle = g;
    tCtx.fillRect( 0, 0, width, height );
  }

  

  function drawBaseImage( tCtx ) {
    const curr = imgs[ currentIndex ];
    if ( ! curr ) return;

    const c = getCoverRect( curr, width, height );

    tCtx.save();
    tCtx.clearRect( 0, 0, width, height );

    if ( ! isTransitioning ) {
      
      tCtx.drawImage( curr, c.dx, c.dy, c.dw, c.dh );

    } else {
      
      const next = imgs[ nextIndex ];
      const t    = performance.now() * 0.001;

      

      const amp = height * 0.092 * Math.sin( Math.PI * crossfade );

      

      const sweepX = transitionDir === 1
        ? crossfade * ( width + amp * 2 ) - amp
        : ( 1 - crossfade ) * ( width + amp * 2 ) - amp;

      const getWaveX = function ( y ) {
        return sweepX + amp * (
          0.65 * Math.sin( y * 0.010 + t * 1.9 ) +
          0.35 * Math.sin( y * 0.025 - t * 2.3 )
        );
      };

      

      if ( ! labelAnimTriggered && heroLabel ) {
        const heroRect  = hero.getBoundingClientRect();
        const lRect     = heroLabel.getBoundingClientRect();
        const lLeading  = transitionDir === 1
          ? lRect.left  - heroRect.left   
          : lRect.right - heroRect.left;  
        const waveAtLabel = getWaveX( lRect.top - heroRect.top + lRect.height / 2 );
        const crossed = transitionDir === 1
          ? waveAtLabel >= lLeading
          : waveAtLabel <= lLeading;
        if ( crossed ) fireWaveLabelAnim();
      }

      
      tCtx.drawImage( curr, c.dx, c.dy, c.dw, c.dh );

      if ( next && next.naturalWidth ) {
        const n = getCoverRect( next, width, height );

        
        tCtx.save();
        tCtx.beginPath();
        if ( transitionDir === 1 ) {
          
          tCtx.moveTo( -2, -2 );
          tCtx.lineTo( getWaveX( 0 ), -2 );
          for ( let y = 0; y <= height + 2; y += 2 ) {
            tCtx.lineTo( getWaveX( y ), y );
          }
          tCtx.lineTo( -2, height + 2 );
        } else {
          
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

  

  function drawNoise() {
    ctx.save();
    ctx.globalAlpha = 0.03;
    ctx.fillStyle   = '#fff';
    for ( let i = 0; i < 90; i++ ) {
      ctx.fillRect( Math.random() * width, Math.random() * height, Math.random() * 1.1, Math.random() * 1.1 );
    }
    ctx.restore();
  }

  

  function render( timestamp ) {

    
    if ( lastSlideTime < 0 ) lastSlideTime = timestamp;

    if ( imgs[0] && imgs[0].naturalWidth ) {

      
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

  
  if ( heroLabel ) {
    heroLabel.textContent = getHeroLabelValue( 0 );
  }

  requestAnimationFrame( render );

} )();
