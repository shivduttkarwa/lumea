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

	function parseComment( markup ) {
		var template = document.createElement( 'template' );
		template.innerHTML = String( markup || '' ).trim();
		return template.content.querySelector( 'li.comment, li.pingback, li.trackback' );
	}

	function bindReplyLink( commentNode ) {
		var link = commentNode && commentNode.querySelector( '.comment-reply-link' );
		if ( ! link || ! window.addComment || 'function' !== typeof window.addComment.moveForm ) {
			return;
		}

		link.addEventListener( 'click', function ( event ) {
			event.preventDefault();
			window.addComment.moveForm(
				link.getAttribute( 'data-belowelement' ),
				link.getAttribute( 'data-commentid' ),
				link.getAttribute( 'data-respondelement' ),
				link.getAttribute( 'data-postid' ),
				link.getAttribute( 'data-replyto' )
			);
		} );
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
				bindReplyLink( commentNode );
				return;
			}
		}

		list.appendChild( commentNode );
		bindReplyLink( commentNode );
	}

	function resetReplyPosition() {
		var cancel = document.querySelector( '#cancel-comment-reply-link' );
		if ( cancel && 'none' !== window.getComputedStyle( cancel ).display ) {
			cancel.click();
		}
	}

	function bindCommentForm() {
		var form = document.querySelector( '.lumea-comment-form' );
		var commentsRoot = document.querySelector( '.lumea-comments' );
		if ( ! form || ! commentsRoot || form.dataset.lumeaAjaxBound ) {
			return;
		}

		form.dataset.lumeaAjaxBound = '1';
		form.addEventListener( 'submit', function ( event ) {
			if ( ! form.reportValidity() ) {
				return;
			}

			event.preventDefault();

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

					resetReplyPosition();
					insertComment( commentsRoot, commentNode, Number( data.parentId ) || 0, data.countLabel );

					var title = commentsRoot.querySelector( '.lumea-comments-title' );
					if ( title ) {
						title.textContent = data.countLabel;
					}

					var commentField = form.querySelector( '[name="comment"]' );
					if ( commentField ) {
						commentField.value = '';
					}

					showFeedback( form, data.successText || config.successText || 'Your comment has been posted.', 'success' );
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
