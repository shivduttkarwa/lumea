

( function () {
  'use strict';

  const section = document.querySelector( '.lumea-manifest' );
  if ( ! section ) return;

  const splitLines = section.querySelectorAll( '[data-split]' );
  if ( ! splitLines.length ) return;

  
  function splitLineToLetters( line, baseDelay, speed ) {
    const text = line.textContent;
    line.textContent = '';

    let charCount = 0;
    const words   = text.split( ' ' );

    words.forEach( function ( word, wordIndex ) {
      const wordSpan     = document.createElement( 'span' );
      wordSpan.className = 'lumea-word';

      word.split( '' ).forEach( function ( letter ) {
        const char                = document.createElement( 'span' );
        char.className            = 'lumea-char';
        char.textContent          = letter;
        char.style.animationDelay = ( baseDelay + charCount * speed ) + 's';
        wordSpan.appendChild( char );
        charCount++;
      } );

      line.appendChild( wordSpan );

      if ( wordIndex !== words.length - 1 ) {
        const space     = document.createElement( 'span' );
        space.className = 'lumea-space';
        space.textContent = '\u00a0';
        line.appendChild( space );
      }
    } );
  }

  splitLines.forEach( function ( line, index ) {
    const isTitle   = !! line.closest( '.lumea-title' );
    const baseDelay = isTitle ? 0.5 + index * 0.1 : 0.16 + index * 0.06;
    const speed     = isTitle ? 0.022 : 0.014;
    splitLineToLetters( line, baseDelay, speed );
  } );

  
  const bgImage = section.querySelector( '.lumea-manifest-bg img' );

  if ( bgImage ) {
    window.addEventListener( 'scroll', function () {
      const rect     = section.getBoundingClientRect();
      const progress = Math.min( Math.max( -rect.top / window.innerHeight, 0 ), 1 );
      bgImage.style.transform =
        'translate3d(0, ' + ( 4 - progress * 5 ) + '%, 0) scale(' + ( 1.17 - progress * 0.04 ) + ')';
    }, { passive: true } );
  }

  
  const observer = new IntersectionObserver( function ( entries, obs ) {
    entries.forEach( function ( entry ) {
      if ( ! entry.isIntersecting ) return;
      section.classList.add( 'is-animated' );
      obs.unobserve( section );
    } );
  }, {
    threshold: 0.12
  } );

  observer.observe( section );

} )();
