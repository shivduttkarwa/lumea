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
 * Render one compact, social-style comment row.
 *
 * @param WP_Comment $comment Comment object.
 * @param array      $args    Comment display arguments.
 * @param int        $depth   Current reply depth.
 */
function lumea_comment_callback( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment; // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited

	$tag         = 'div' === $args['style'] ? 'div' : 'li';
	$author_name = get_comment_author( $comment );
	$time_ago    = human_time_diff( get_comment_time( 'U', false, true, $comment ), current_time( 'timestamp' ) );
	?>
	<<?php echo esc_html( $tag ); ?> id="li-comment-<?php comment_ID(); ?>" <?php comment_class( 'lumea-comment' ); ?>>
		<article id="comment-<?php comment_ID(); ?>" class="lumea-comment-row">
			<div class="lumea-comment-avatar">
				<?php echo wp_kses_post( get_avatar( $comment, 36, '', $author_name ) ); ?>
			</div>

			<div class="lumea-comment-main">
				<div class="lumea-comment-message">
					<span class="lumea-comment-author-name"><?php echo wp_kses_post( get_comment_author_link( $comment ) ); ?></span>
					<div class="lumea-comment-text"><?php comment_text( $comment ); ?></div>
				</div>

				<?php if ( '0' === (string) $comment->comment_approved ) : ?>
					<p class="lumea-comment-moderation"><?php esc_html_e( 'Awaiting moderation', 'lumea' ); ?></p>
				<?php endif; ?>

				<div class="lumea-comment-actions">
					<a href="<?php echo esc_url( get_comment_link( $comment ) ); ?>" class="lumea-comment-time">
						<?php
						printf(
							/* translators: %s: relative comment time, such as "5 minutes". */
							esc_html__( '%s ago', 'lumea' ),
							esc_html( $time_ago )
						);
						?>
					</a>
					<?php
					comment_reply_link(
						array_merge(
							$args,
							array(
								'depth'      => $depth,
								'max_depth'  => $args['max_depth'],
								'reply_text' => __( 'Reply', 'lumea' ),
							)
						),
						$comment
					);
					?>
				</div>
			</div>
		</article>
	<?php
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
			'avatar_size' => 36,
			'max_depth'   => (int) get_option( 'thread_comments_depth' ),
			'callback'    => 'lumea_comment_callback',
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
		)
	);
}
add_action( 'wp_ajax_lumea_submit_comment', 'lumea_ajax_submit_comment' );
add_action( 'wp_ajax_nopriv_lumea_submit_comment', 'lumea_ajax_submit_comment' );
