

( function () {
  'use strict';

  const slider      = document.getElementById( 'lumeaSlider' );
  if ( ! slider ) return;

  const slidesData  = ( typeof lumea_slider !== 'undefined' && Array.isArray( lumea_slider.slides ) )
    ? lumea_slider.slides
    : [];

  const slidesRoot  = document.getElementById( 'lumeaSlides' );
  const card        = document.getElementById( 'lumeaCard' );
  const numberEl    = document.getElementById( 'lumeaNumber' );
  const textEl      = document.getElementById( 'lumeaText' );
  const cardButton  = document.getElementById( 'lumeaCardButton' );
  const cursorArrow = document.getElementById( 'lumeaCursorArrow' );

  let activeIndex      = 0;
  let isAnimating      = false;
  let cursorSide       = 'right';
  let isCursorBlocked  = false;
  let activeAnimations = [];
  let lastMouseX       = -1;
  let lastMouseY       = -1;

  function createSlides() {
    slidesData.forEach( function ( slide, index ) {
      const slideEl         = document.createElement( 'div' );
      slideEl.className     = 'lumea-slide';
      slideEl.dataset.index = index;
      slideEl.innerHTML     =
        '<div class="lumea-slide-inner">' +
          '<img src="' + slide.image + '" alt="Luméa slide ' + ( index + 1 ) + '" draggable="false">' +
        '</div>';
      slidesRoot.appendChild( slideEl );
    } );
  }

  function preloadImages() {
    return Promise.all(
      slidesData.map( function ( slide ) {
        return new Promise( function ( resolve ) {
          const image   = new Image();
          image.onload  = resolve;
          image.onerror = resolve;
          image.src     = slide.image;
        } );
      } )
    );
  }

  function getWrappedIndex( index ) {
    const total = slidesData.length;
    return ( ( index % total ) + total ) % total;
  }

  function getShortestDelta( index, active ) {
    const total = slidesData.length;
    let delta   = index - active;
    if ( delta >  total / 2 ) delta -= total;
    if ( delta < -total / 2 ) delta += total;
    return delta;
  }

  function updateSlides() {
    document.querySelectorAll( '.lumea-slide' ).forEach( function ( slide ) {
      const index = Number( slide.dataset.index );
      const delta = getShortestDelta( index, activeIndex );
      slide.classList.remove( 'is-active', 'is-prev', 'is-next', 'is-hidden-left', 'is-hidden-right' );
      if      ( delta === 0  ) slide.classList.add( 'is-active' );
      else if ( delta === -1 ) slide.classList.add( 'is-prev' );
      else if ( delta === 1  ) slide.classList.add( 'is-next' );
      else if ( delta < 0    ) slide.classList.add( 'is-hidden-left' );
      else                     slide.classList.add( 'is-hidden-right' );
    } );
  }

  function updateCard() {
    const currentSlide = slidesData[ activeIndex ];
    card.classList.add( 'is-changing' );
    window.setTimeout( function () {
      numberEl.textContent = currentSlide.number;
      textEl.textContent   = currentSlide.text;
      if ( cardButton && currentSlide.url ) {
        cardButton.setAttribute( 'href', currentSlide.url );
      }
      requestAnimationFrame( function () {
        card.classList.remove( 'is-changing' );
      } );
    }, 250 );
  }

  function clearZoomAnimations() {
    activeAnimations.forEach( function ( animation ) {
      try { animation.cancel(); } catch ( e ) {}
    } );
    activeAnimations = [];
  }

  function animateSlideZoom( currentIndex ) {
    clearZoomAnimations();
    const currentInner = document.querySelector(
      '.lumea-slide[data-index="' + currentIndex + '"] .lumea-slide-inner'
    );
    const timing = { duration: 1280, easing: 'cubic-bezier(0.19, 1, 0.22, 1)', fill: 'both' };
    if ( currentInner ) {
      const animation = currentInner.animate(
        [
          { transform: 'translate3d(0, 0, 0) scale(1.16)' },
          { transform: 'translate3d(0, 0, 0) scale(1)' }
        ],
        timing
      );
      activeAnimations.push( animation );
    }
  }

  function goToSlide( direction ) {
    if ( isAnimating ) return;
    isAnimating = true;
    activeIndex = getWrappedIndex( direction === 'next' ? activeIndex + 1 : activeIndex - 1 );
    updateSlides();
    requestAnimationFrame( function () {
      animateSlideZoom( activeIndex );
      updateCard();
    } );
    window.setTimeout( function () { isAnimating = false; }, 1320 );
  }

  function moveCursor( event ) {
    if ( isCursorBlocked || event.target.closest( '.lumea-card-button' ) ) {
      cursorArrow.classList.remove( 'is-visible', 'is-left', 'is-right' );
      return;
    }

    const rect   = slider.getBoundingClientRect();
    const isLeft = ( event.clientX - rect.left ) < rect.width / 2;
    cursorSide   = isLeft ? 'left' : 'right';
    cursorArrow.style.left = ( event.clientX - rect.left ) + 'px';
    cursorArrow.style.top  = ( event.clientY - rect.top )  + 'px';
    cursorArrow.classList.add( 'is-visible' );
    cursorArrow.classList.toggle( 'is-left',  isLeft );
    cursorArrow.classList.toggle( 'is-right', ! isLeft );
  }

  document.addEventListener( 'mousemove', function ( e ) {
    lastMouseX = e.clientX;
    lastMouseY = e.clientY;
  } );

  window.addEventListener( 'scroll', function () {
    if ( lastMouseX < 0 ) return;
    const rect = slider.getBoundingClientRect();
    if (
      lastMouseX >= rect.left && lastMouseX <= rect.right &&
      lastMouseY >= rect.top  && lastMouseY <= rect.bottom
    ) {
      moveCursor( { clientX: lastMouseX, clientY: lastMouseY, target: slider } );
    } else {
      cursorArrow.classList.remove( 'is-visible', 'is-left', 'is-right' );
    }
  }, { passive: true } );

  slider.addEventListener( 'mousemove', moveCursor );

  slider.addEventListener( 'mouseleave', function () {
    cursorArrow.classList.remove( 'is-visible', 'is-left', 'is-right' );
  } );

  if ( cardButton ) {
    cardButton.addEventListener( 'mouseenter', function () {
      isCursorBlocked = true;
      cursorArrow.classList.remove( 'is-visible', 'is-left', 'is-right' );
    } );
    cardButton.addEventListener( 'mouseleave', function () {
      isCursorBlocked = false;
    } );
  }

  slider.addEventListener( 'click', function ( event ) {
    if ( event.target.closest( '.lumea-content-card, .lumea-mobile-arrows' ) ) return;
    goToSlide( cursorSide === 'left' ? 'prev' : 'next' );
  } );

  slider.querySelectorAll( '[data-direction]' ).forEach( function ( button ) {
    button.addEventListener( 'click', function ( event ) {
      event.stopPropagation();
      goToSlide( button.dataset.direction );
    } );
  } );

  createSlides();
  updateSlides();
  updateCard();

  preloadImages().then( function () {
    requestAnimationFrame( function () {
      slider.classList.remove( 'is-loading' );
      lumeaSliderEntrance();
    } );
  } );

  function lumeaSliderEntrance() {
    if ( typeof gsap === 'undefined' ) return;
    const visible = slidesRoot.querySelectorAll( '.lumea-slide.is-prev, .lumea-slide.is-active, .lumea-slide.is-next' );
    if ( ! visible.length ) return;

    gsap.set( visible, { autoAlpha: 0 } );

    const io = new IntersectionObserver( function ( entries ) {
      if ( ! entries[ 0 ].isIntersecting ) return;
      gsap.to( visible, { autoAlpha: 1, duration: 1.0, ease: 'power2.out', stagger: 0.15 } );
      io.disconnect();
    }, { threshold: 0.35 } );

    io.observe( slider );
  }

} )();
