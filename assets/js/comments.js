( function () {
	'use strict';

	var config = window.lumeaComments || {};

	function getMessage( response, fallback ) {
		if ( response && response.data && response.data.message ) {
			return String( response.data.message );
		}
		return fallback;
	}

	function createFeedback( form ) {
		var feedback = form.querySelector( '.lumea-comment-feedback' );
		if ( feedback ) {
			return feedback;
		}

		feedback = document.createElement( 'div' );
		feedback.className = 'lumea-comment-feedback';
		feedback.setAttribute( 'role', 'status' );
		feedback.setAttribute( 'aria-live', 'polite' );
		form.prepend( feedback );
		return feedback;
	}

	function showFeedback( form, message, type ) {
		var feedback = createFeedback( form );
		feedback.textContent = message;
		feedback.classList.remove( 'is-success', 'is-error' );
		feedback.classList.add( 'is-visible', 'success' === type ? 'is-success' : 'is-error' );
	}

	function clearFeedback( form ) {
		var feedback = form.querySelector( '.lumea-comment-feedback' );
		if ( ! feedback ) {
			return;
		}
		feedback.textContent = '';
		feedback.classList.remove( 'is-visible', 'is-success', 'is-error' );
	}

	function parseComment( markup ) {
		var template = document.createElement( 'template' );
		template.innerHTML = String( markup || '' ).trim();
		return template.content.querySelector( 'li.comment, li.pingback, li.trackback' );
	}

	function getCommentList( commentsRoot, countLabel ) {
		var list = commentsRoot.querySelector( '.lumea-comment-list' );
		if ( list ) {
			return list;
		}

		var title = commentsRoot.querySelector( '.lumea-comments-title' );
		if ( ! title ) {
			title = document.createElement( 'h2' );
			title.className = 'lumea-comments-title';
			title.textContent = countLabel;
			commentsRoot.prepend( title );
		}

		list = document.createElement( 'ol' );
		list.className = 'lumea-comment-list';
		title.insertAdjacentElement( 'afterend', list );
		return list;
	}

	function insertComment( commentsRoot, commentNode, parentId, countLabel ) {
		var list = getCommentList( commentsRoot, countLabel );

		if ( parentId > 0 ) {
			var parent = commentsRoot.querySelector( '#li-comment-' + parentId );
			if ( parent ) {
				var children = Array.prototype.find.call( parent.children, function ( child ) {
					return child.classList && child.classList.contains( 'children' );
				} );

				if ( ! children ) {
					children = document.createElement( 'ol' );
					children.className = 'children';
					parent.appendChild( children );
				}

				children.appendChild( commentNode );
				return;
			}
		}

		list.appendChild( commentNode );
	}

	function resizeTextarea( textarea ) {
		if ( ! textarea ) {
			return;
		}
		textarea.style.height = 'auto';
		textarea.style.height = Math.min( textarea.scrollHeight, 112 ) + 'px';
	}

	function clearReplyMode( form ) {
		var parentInput = form.querySelector( '[name="comment_parent"]' );
		var context = form.querySelector( '.lumea-comment-reply-context' );
		var textarea = form.querySelector( '[name="comment"]' );

		if ( parentInput ) {
			parentInput.value = '0';
		}
		if ( context ) {
			context.hidden = true;
			var label = context.querySelector( 'span' );
			if ( label ) {
				label.textContent = '';
			}
		}
		if ( textarea ) {
			textarea.placeholder = config.placeholderText || 'Add a comment…';
		}
	}

	function setReplyMode( form, link ) {
		var parentInput = form.querySelector( '[name="comment_parent"]' );
		var context = form.querySelector( '.lumea-comment-reply-context' );
		var textarea = form.querySelector( '[name="comment"]' );
		var comment = link.closest( 'li.comment' );
		var author = comment && comment.querySelector( '.lumea-comment-author-name' );
		var authorName = author ? author.textContent.trim() : '';

		if ( parentInput ) {
			parentInput.value = link.getAttribute( 'data-commentid' ) || '0';
		}
		if ( context ) {
			context.hidden = false;
			var label = context.querySelector( 'span' );
			if ( label ) {
				label.textContent = ( config.replyingText || 'Replying to %s' ).replace( '%s', authorName );
			}
		}
		if ( textarea ) {
			textarea.placeholder = authorName ? 'Reply to ' + authorName + '…' : ( config.placeholderText || 'Add a comment…' );
			textarea.focus();
			resizeTextarea( textarea );
		}

		var composer = form.querySelector( '.lumea-comment-composer' );
		if ( composer ) {
			composer.scrollIntoView( { behavior: 'smooth', block: 'center' } );
		}
	}

	function prepareComposer( form ) {
		var composer = form.querySelector( '.lumea-comment-composer' );
		var submitWrap = form.querySelector( '.form-submit' );
		var replyContext = form.querySelector( '.lumea-comment-reply-context' );
		var lastIdentityField = form.querySelector( '.comment-form-url' ) || form.querySelector( '.comment-form-email' ) || form.querySelector( '.comment-form-author' );
		var textarea = form.querySelector( '[name="comment"]' );

		if ( lastIdentityField && replyContext && composer ) {
			lastIdentityField.insertAdjacentElement( 'afterend', replyContext );
			replyContext.insertAdjacentElement( 'afterend', composer );
		}
		if ( composer && submitWrap ) {
			composer.appendChild( submitWrap );
		}
		if ( textarea ) {
			textarea.addEventListener( 'input', function () {
				resizeTextarea( textarea );
			} );
			resizeTextarea( textarea );
		}
	}

	function bindCommentForm() {
		var form = document.querySelector( '.lumea-comment-form' );
		var commentsRoot = document.querySelector( '.lumea-comments' );
		if ( ! form || ! commentsRoot || form.dataset.lumeaAjaxBound ) {
			return;
		}

		form.dataset.lumeaAjaxBound = '1';
		prepareComposer( form );

		commentsRoot.addEventListener( 'click', function ( event ) {
			var replyLink = event.target.closest( '.comment-reply-link' );
			var cancelButton = event.target.closest( '.lumea-comment-reply-cancel' );

			if ( replyLink ) {
				event.preventDefault();
				event.stopPropagation();
				event.stopImmediatePropagation();
				setReplyMode( form, replyLink );
				return;
			}

			if ( cancelButton ) {
				event.preventDefault();
				clearReplyMode( form );
			}
		}, true );

		form.addEventListener( 'submit', function ( event ) {
			if ( ! form.reportValidity() ) {
				return;
			}

			event.preventDefault();
			clearFeedback( form );

			var submit = form.querySelector( '[type="submit"]' );
			var originalLabel = submit ? submit.textContent : '';
			var formData = new FormData( form );
			formData.append( 'action', 'lumea_submit_comment' );
			formData.append( 'nonce', config.nonce || '' );

			if ( submit ) {
				submit.disabled = true;
				submit.setAttribute( 'aria-busy', 'true' );
				submit.textContent = config.postingText || 'Posting...';
			}

			fetch( config.ajaxUrl, {
				method: 'POST',
				body: formData,
				credentials: 'same-origin',
				headers: {
					'X-Requested-With': 'XMLHttpRequest'
				}
			} )
				.then( function ( response ) {
					return response.json().then( function ( json ) {
						if ( ! response.ok || ! json.success ) {
							throw new Error( getMessage( json, config.errorText || 'Could not post your comment.' ) );
						}
						return json.data;
					} );
				} )
				.then( function ( data ) {
					var commentNode = parseComment( data.html );
					if ( ! commentNode ) {
						throw new Error( config.errorText || 'Could not display your comment.' );
					}

					insertComment( commentsRoot, commentNode, Number( data.parentId ) || 0, data.countLabel );

					var title = commentsRoot.querySelector( '.lumea-comments-title' );
					if ( title ) {
						title.textContent = data.countLabel;
					}

					var commentField = form.querySelector( '[name="comment"]' );
					if ( commentField ) {
						commentField.value = '';
						resizeTextarea( commentField );
					}

					clearReplyMode( form );
					commentNode.scrollIntoView( { behavior: 'smooth', block: 'center' } );
				} )
				.catch( function ( error ) {
					showFeedback( form, error.message || config.errorText || 'Could not post your comment.', 'error' );
				} )
				.finally( function () {
					if ( submit ) {
						submit.disabled = false;
						submit.removeAttribute( 'aria-busy' );
						submit.textContent = originalLabel;
					}
				} );
		} );
	}

	if ( 'loading' === document.readyState ) {
		document.addEventListener( 'DOMContentLoaded', bindCommentForm );
	} else {
		bindCommentForm();
	}
}() );
