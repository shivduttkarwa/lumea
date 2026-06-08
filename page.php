<?php
/**
 * Default page template — wraps all WordPress pages.
 *
 * @package Lumea
 */

defined( 'ABSPATH' ) || exit;

$lumea_posts_page_id = (int) get_option( 'page_for_posts' );
if ( $lumea_posts_page_id && is_page( $lumea_posts_page_id ) || ( ! $lumea_posts_page_id && is_page( 'blog' ) ) ) {
	global $wp_query, $post;

	$lumea_original_query = $wp_query;
	$lumea_original_post  = $post;
	$lumea_paged          = max( 1, get_query_var( 'paged' ), get_query_var( 'page' ) );

	$wp_query = new WP_Query(
		array(
			'post_type'           => 'post',
			'post_status'         => 'publish',
			'posts_per_page'      => (int) get_option( 'posts_per_page', 10 ),
			'paged'               => $lumea_paged,
			'ignore_sticky_posts' => false,
		)
	);
	$post = null;

	include get_theme_file_path( 'archive.php' );

	$wp_query = $lumea_original_query;
	$post     = $lumea_original_post;
	wp_reset_postdata();
	return;
}

get_header();
?>

<main class="lumea-page" id="lumeaPage">
	<?php while ( have_posts() ) : the_post(); ?>
		<?php the_content(); ?>
	<?php endwhile; ?>
</main>

<?php get_footer(); ?>
