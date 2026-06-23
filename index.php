<?php
/**
 * Main template file.
 *
 * @package Lumea
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<main class="lumea-page-section" id="lumeaPage">
	<div class="lumea-container">

		<?php if ( have_posts() ) : ?>

			<div class="lumea-post-grid">
				<?php
				while ( have_posts() ) :
					the_post();
					?>

					<article <?php post_class( 'lumea-post-card' ); ?>>
						<h2 class="lumea-post-title">
							<a href="<?php echo esc_url( get_permalink() ); ?>">
								<?php the_title(); ?>
							</a>
						</h2>

						<div class="lumea-post-excerpt">
							<?php the_excerpt(); ?>
						</div>
					</article>

					<?php
				endwhile;
				?>
			</div>

			<?php the_posts_pagination(); ?>

		<?php else : ?>

			<div class="lumea-empty-state">
				<h1><?php esc_html_e( 'Nothing found', 'lumea' ); ?></h1>
				<p><?php esc_html_e( 'No posts are available yet.', 'lumea' ); ?></p>
			</div>
		<?php endif; ?>

	</div>
</main>
<?php
get_footer();
