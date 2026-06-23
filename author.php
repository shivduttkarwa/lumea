<?php
/**
 * Author archive template.
 *
 * @package Lumea
 */

defined( 'ABSPATH' ) || exit;

get_header();

$lumea_author     = get_queried_object();
$lumea_avatar_url = get_avatar_url( $lumea_author->ID, array( 'size' => 120 ) );
$lumea_bio        = get_the_author_meta( 'description', $lumea_author->ID );
?>

<main class="lumea-author-page" id="lumeaPage">

	<div class="lumea-shop-hero" style="--shop-bg: url('<?php echo esc_url( get_theme_mod( 'lumea_blog_hero_bg', LUMEA_THEME_URI . '/assets/images/hero/blog-hero.jpg' ) ); ?>')">
		<div class="lumea-shop-hero-overlay"></div>
		<div class="lumea-shop-hero-inner">
			<?php if ( $lumea_avatar_url ) : ?>
			<img src="<?php echo esc_url( $lumea_avatar_url ); ?>"
				alt="<?php echo esc_attr( $lumea_author->display_name ); ?>"
				class="lumea-author-avatar"
				width="80" height="80">
			<?php endif; ?>
			<h1 class="lumea-shop-hero-title"><?php echo esc_html( $lumea_author->display_name ); ?></h1>
			<?php if ( $lumea_bio ) : ?>
			<p class="lumea-shop-hero-desc"><?php echo esc_html( $lumea_bio ); ?></p>
			<?php endif; ?>
		</div>
	</div>

	<div class="lumea-archive-body">
		<div class="container-fluid px-3 px-sm-4 px-lg-5">

			<?php if ( have_posts() ) : ?>

			<div class="lumea-blog-grid">
				<?php
				while ( have_posts() ) :
					the_post();
					$cats         = get_the_category();
					$cat_name     = $cats ? $cats[0]->name : '';
					$reading_time = max( 1, round( str_word_count( wp_strip_all_tags( get_the_content() ) ) / 200 ) );
					?>
				<article <?php post_class( 'lumea-blog-card' ); ?>>
					<a href="<?php the_permalink(); ?>" class="lumea-blog-card-img-wrap" tabindex="-1" aria-hidden="true">
						<?php
						$card_image = lumea_get_post_card_image( get_the_ID() );
						if ( $card_image ) :
							echo wp_kses_post( $card_image );
							?>
						<?php else : ?>
							<div class="lumea-blog-card-img-placeholder"></div>
						<?php endif; ?>
					</a>
					<div class="lumea-blog-card-body">
						<?php if ( $cat_name ) : ?>
						<p class="lumea-blog-card-cat"><?php echo esc_html( $cat_name ); ?></p>
						<?php endif; ?>
						<h2 class="lumea-blog-card-title">
							<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
						</h2>
						<div class="lumea-blog-card-meta">
							<time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time>
							<span aria-hidden="true">&middot;</span>
							<span>
							<?php
							/* translators: %d: estimated reading time in minutes */
							printf( esc_html__( '%d min read', 'lumea' ), absint( $reading_time ) );
							?>
							</span>
						</div>
						<p class="lumea-blog-card-excerpt"><?php echo wp_kses_post( wp_trim_words( get_the_excerpt(), 18, '&hellip;' ) ); ?></p>
						<a href="<?php the_permalink(); ?>" class="lumea-blog-card-link">
							<?php esc_html_e( 'Read', 'lumea' ); ?>
							<svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" aria-hidden="true"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
						</a>
					</div>
				</article>
				<?php endwhile; ?>
			</div>

			<div class="lumea-pagination">
				<?php
				the_posts_pagination(
					array(
						'mid_size'           => 2,
						'prev_text'          => esc_html__( 'Previous', 'lumea' ),
						'next_text'          => esc_html__( 'Next', 'lumea' ),
						'screen_reader_text' => esc_html__( 'Posts navigation', 'lumea' ),
					)
				);
				?>
			</div>

			<?php else : ?>
			<p class="lumea-no-posts"><?php esc_html_e( 'No posts found.', 'lumea' ); ?></p>
			<?php endif; ?>

		</div>
	</div>

</main>

<?php get_footer(); ?>
