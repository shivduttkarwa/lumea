<?php
/**
 * Comment enhancements.
 *
 * @package Lumea
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


/**
 * Return the localized comments heading.
 *
 * @param int $count Comment count.
 * @return string
 */
function lumea_get_comments_heading( $count ) {
	$count = absint( $count );

	if ( 1 === $count ) {
		return __( 'One Comment', 'lumea' );
	}

	return sprintf(
		/* translators: %s: number of comments. */
		__( '%s Comments', 'lumea' ),
		number_format_i18n( $count )
	);
}


/**
 * Submit a post comment without a page refresh.
 */
function lumea_ajax_submit_comment() {
	check_ajax_referer( 'lumea_submit_comment', 'nonce' );

	$submission = wp_unslash( $_POST );
	unset( $submission['action'], $submission['nonce'] );

	$comment = wp_handle_comment_submission( $submission );
	if ( is_wp_error( $comment ) ) {
		wp_send_json_error(
			array(
				'message' => $comment->get_error_message(),
			),
			400
		);
	}

	$user = wp_get_current_user();
	do_action( 'set_comment_cookies', $comment, $user );

	$comment = get_comment( $comment->comment_ID );
	if ( ! $comment ) {
		wp_send_json_error(
			array(
				'message' => __( 'Your comment was received, but could not be displayed. Please refresh the page.', 'lumea' ),
			),
			500
		);
	}

	ob_start();
	wp_list_comments(
		array(
			'style'       => 'ol',
			'short_ping'  => true,
			'avatar_size' => 48,
			'max_depth'   => (int) get_option( 'thread_comments_depth' ),
		),
		array( $comment )
	);
	$comment_html = ob_get_clean();

	$comment_count = (int) get_comments_number( $comment->comment_post_ID );

	wp_send_json_success(
		array(
			'commentId'   => (int) $comment->comment_ID,
			'parentId'    => (int) $comment->comment_parent,
			'html'        => $comment_html,
			'count'       => $comment_count,
			'countLabel'  => lumea_get_comments_heading( $comment_count ),
			'unapproved'  => '1' !== (string) $comment->comment_approved,
			'successText' => '1' === (string) $comment->comment_approved
				? __( 'Your comment has been posted.', 'lumea' )
				: __( 'Your comment is awaiting moderation.', 'lumea' ),
		)
	);
}
add_action( 'wp_ajax_lumea_submit_comment', 'lumea_ajax_submit_comment' );
add_action( 'wp_ajax_nopriv_lumea_submit_comment', 'lumea_ajax_submit_comment' );
