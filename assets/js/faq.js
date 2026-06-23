( function () {
  'use strict';

  var tabs = document.querySelectorAll( '[data-faq-tab]' );
  var panels = document.querySelectorAll( '.lumea-faq-panel' );

  tabs.forEach( function ( tab ) {
    tab.addEventListener( 'click', function () {
      var key = tab.getAttribute( 'data-faq-tab' );

      tabs.forEach( function ( item ) {
        var selected = item === tab;
        item.classList.toggle( 'is-active', selected );
        item.setAttribute( 'aria-selected', selected ? 'true' : 'false' );
        item.setAttribute( 'tabindex', selected ? '0' : '-1' );
      } );

      panels.forEach( function ( panel ) {
        var active = panel.id === 'lumea-faq-panel-' + key;
        panel.classList.toggle( 'is-active', active );
        panel.hidden = ! active;
      } );
    } );

    tab.addEventListener( 'keydown', function ( event ) {
      if ( event.key !== 'ArrowLeft' && event.key !== 'ArrowRight' ) {
        return;
      }

      event.preventDefault();
      var current = Array.prototype.indexOf.call( tabs, tab );
      var offset = event.key === 'ArrowRight' ? 1 : -1;
      var next = ( current + offset + tabs.length ) % tabs.length;
      tabs[ next ].focus();
      tabs[ next ].click();
    } );
  } );

  document.querySelectorAll( '[data-faq-item]' ).forEach( function ( item ) {
    var button = item.querySelector( '.lumea-faq-question' );
    var answer = item.querySelector( '.lumea-faq-answer' );

    if ( ! button || ! answer ) {
      return;
    }

    button.addEventListener( 'click', function () {
      var isOpen = ! answer.hidden;

      item.closest( '.lumea-faq-panel' ).querySelectorAll( '[data-faq-item]' ).forEach( function ( sibling ) {
        var siblingAnswer = sibling.querySelector( '.lumea-faq-answer' );
        var siblingButton = sibling.querySelector( '.lumea-faq-question' );

        if ( siblingAnswer && siblingButton ) {
          siblingAnswer.hidden = true;
          siblingButton.setAttribute( 'aria-expanded', 'false' );
          sibling.classList.remove( 'is-open' );
        }
      } );

      if ( ! isOpen ) {
        answer.hidden = false;
        button.setAttribute( 'aria-expanded', 'true' );
        item.classList.add( 'is-open' );
      }
    } );
  } );
} )();
