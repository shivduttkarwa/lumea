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
					'avatar_size' => 48,
					'callback'    => null,
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
	comment_form(
		array(
			'title_reply'         => esc_html__( 'Leave a Comment', 'lumea' ),
			'title_reply_before'  => '<h2 class="lumea-comment-reply-title" id="reply-title">',
			'title_reply_after'   => '</h2>',
			'cancel_reply_before' => ' ',
			'cancel_reply_after'  => '',
			'label_submit'        => esc_html__( 'Post Comment', 'lumea' ),
			'class_submit'        => 'lumea-btn btn-black',
			'class_form'          => 'lumea-comment-form',
			'class_container'     => 'lumea-comment-form-wrap',
			'comment_field'       => '<p class="comment-form-comment"><label for="comment">' . esc_html__( 'Comment', 'lumea' ) . ' <span class="required" aria-hidden="true">*</span></label><textarea id="comment" name="comment" cols="45" rows="7" maxlength="65525" required></textarea></p>',
			'fields'              => array(
				'author' => '<p class="comment-form-author"><label for="author">' . esc_html__( 'Name', 'lumea' ) . ' <span class="required" aria-hidden="true">*</span></label><input id="author" name="author" type="text" value="' . esc_attr( isset( $commenter['comment_author'] ) ? $commenter['comment_author'] : '' ) . '" size="30" maxlength="245" autocomplete="name" required /></p>',
				'email'  => '<p class="comment-form-email"><label for="email">' . esc_html__( 'Email', 'lumea' ) . ' <span class="required" aria-hidden="true">*</span></label><input id="email" name="email" type="email" value="' . esc_attr( isset( $commenter['comment_author_email'] ) ? $commenter['comment_author_email'] : '' ) . '" size="30" maxlength="100" autocomplete="email" required /></p>',
			),
		)
	);
	?>

</div>
