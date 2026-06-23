<?php
/**
 * Comments template.
 *
 * @package Lumea
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( post_password_required() ) {
	return;
}
?>

<div class="lumea-comments" id="comments">

	<?php if ( have_comments() ) : ?>
		<h2 class="lumea-comments-title">
			<?php echo esc_html( lumea_get_comments_heading( get_comments_number() ) ); ?>
		</h2>

		<ol class="lumea-comment-list">
			<?php
			wp_list_comments(
				array(
					'style'       => 'ol',
					'short_ping'  => true,
					'avatar_size' => 36,
					'callback'    => 'lumea_comment_callback',
				)
			);
			?>
		</ol>

		<?php the_comments_navigation(); ?>

	<?php endif; ?>

	<?php if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) : ?>
		<p class="lumea-no-comments"><?php esc_html_e( 'Comments are closed.', 'lumea' ); ?></p>
	<?php endif; ?>

	<?php
	$commenter = wp_get_current_commenter();
	$avatar_for = is_user_logged_in() ? get_current_user_id() : $commenter['comment_author_email'];
	$avatar     = get_avatar(
		$avatar_for,
		36,
		'',
		__( 'Your avatar', 'lumea' ),
		array(
			'class' => 'lumea-comment-composer-avatar',
		)
	);
	comment_form(
		array(
			'title_reply'         => esc_html__( 'Add a comment', 'lumea' ),
			'title_reply_before'  => '<h2 class="screen-reader-text lumea-comment-reply-title" id="reply-title">',
			'title_reply_after'   => '</h2>',
			'cancel_reply_before' => ' ',
			'cancel_reply_after'  => '',
			'label_submit'        => esc_html__( 'Post', 'lumea' ),
			'submit_button'       => '<button name="%1$s" type="submit" id="%2$s" class="lumea-comment-post-btn">%4$s</button>',
			'class_form'          => 'lumea-comment-form',
			'class_container'     => 'lumea-comment-form-wrap',
			'logged_in_as'        => '',
			'comment_notes_before' => '<p class="comment-notes">' . esc_html__( 'Your email address will not be published.', 'lumea' ) . '</p>',
			'comment_field'       => '<div class="lumea-comment-reply-context" hidden><span></span><button type="button" class="lumea-comment-reply-cancel" aria-label="' . esc_attr__( 'Cancel reply', 'lumea' ) . '">&times;</button></div><div class="lumea-comment-composer">' . wp_kses_post( $avatar ) . '<p class="comment-form-comment"><label for="comment" class="screen-reader-text">' . esc_html__( 'Comment', 'lumea' ) . '</label><textarea id="comment" name="comment" cols="45" rows="1" maxlength="65525" placeholder="' . esc_attr__( 'Add a comment…', 'lumea' ) . '" required></textarea></p></div>',
			'fields'              => array(
				'author' => '<p class="comment-form-author"><label for="author" class="screen-reader-text">' . esc_html__( 'Name', 'lumea' ) . '</label><input id="author" name="author" type="text" value="' . esc_attr( isset( $commenter['comment_author'] ) ? $commenter['comment_author'] : '' ) . '" placeholder="' . esc_attr__( 'Name', 'lumea' ) . '" maxlength="245" autocomplete="name" required /></p>',
				'email'  => '<p class="comment-form-email"><label for="email" class="screen-reader-text">' . esc_html__( 'Email', 'lumea' ) . '</label><input id="email" name="email" type="email" value="' . esc_attr( isset( $commenter['comment_author_email'] ) ? $commenter['comment_author_email'] : '' ) . '" placeholder="' . esc_attr__( 'Email', 'lumea' ) . '" maxlength="100" autocomplete="email" required /></p>',
			),
		)
	);
	?>

</div>
