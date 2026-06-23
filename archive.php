<?php
/**
 * Blog / Journal archive — Luméa premium edition.
 *
 * @package Lumea
 */

defined( 'ABSPATH' ) || exit;

get_header();

$posts_page_id  = (int) get_option( 'page_for_posts' );
$blog_page      = get_page_by_path( 'blog' );
$blog_index_url = $posts_page_id
	? get_permalink( $posts_page_id )
	: ( $blog_page ? get_permalink( $blog_page ) : home_url( '/' ) );

$hero_bg_image      = get_theme_mod( 'lumea_blog_hero_bg', LUMEA_THEME_URI . '/assets/images/bestsellers/cta-bg.jpg' );
$blog_hero_title    = get_theme_mod( 'lumea_blog_hero_title', __( 'The Journal', 'lumea' ) );
$blog_hero_subtitle = get_theme_mod( 'lumea_blog_hero_subtitle', __( 'Rituals, ingredients, and the science of radiant skin.', 'lumea' ) );
?>

<main class="lumea-blog-page" id="lumeaPage">

	<!-- Hero — aligned with shop hero design -->
	<div class="lumea-shop-hero" style="--shop-bg: url('<?php echo esc_url( $hero_bg_image ); ?>')">
		<div class="lumea-shop-hero-overlay"></div>
		<div class="lumea-shop-hero-inner">
			<h1 class="lumea-shop-hero-title lumea-reveal-js lumea-reveal--fade-js lumea-reveal--hero-js">
				<?php
				if ( is_category() ) {
					echo esc_html( single_cat_title( '', false ) );
				} elseif ( is_tag() ) {
					echo esc_html( single_tag_title( '', false ) );
				} else {
					echo esc_html( $blog_hero_title );
				}
				?>
			</h1>
			<p class="lumea-shop-hero-desc lumea-reveal-js lumea-reveal--fade-js lumea-reveal--hero-js"><?php echo esc_html( $blog_hero_subtitle ); ?></p>
		</div>
	</div>

	<!-- Category filter -->
	<?php
	$blog_cats = get_categories(
		array(
			'hide_empty' => true,
			'number'     => 8,
		)
	);
	if ( $blog_cats ) :
		?>
	<div class="lumea-blog-cats lumea-reveal-js lumea-reveal--static-js">
		<div class="lumea-blog-cats-inner">
			<a href="<?php echo esc_url( $blog_index_url ); ?>"
				class="lumea-filter-pill <?php echo esc_attr( ! is_category() && ! is_tag() ? 'is-active' : '' ); ?>">
				<?php esc_html_e( 'All', 'lumea' ); ?>
			</a>
			<?php foreach ( $blog_cats as $blog_cat ) : ?>
			<a href="<?php echo esc_url( get_category_link( $blog_cat->term_id ) ); ?>"
				class="lumea-filter-pill <?php echo esc_attr( is_category( $blog_cat->term_id ) ? 'is-active' : '' ); ?>">
				<?php echo esc_html( $blog_cat->name ); ?>
			</a>
			<?php endforeach; ?>
		</div>
	</div>
	<?php endif; ?>

	<!-- Posts grid -->
	<div class="lumea-blog-body">
		<div class="lumea-blog-body-inner">

			<?php if ( have_posts() ) : ?>

			<!-- Featured first post (large) -->
				<?php
				the_post();
				$feat_cats = get_the_category();
				$feat_cat  = $feat_cats ? $feat_cats[0]->name : '';
				$feat_read = max( 1, round( str_word_count( wp_strip_all_tags( get_the_content() ) ) / 200 ) );
				?>
			<article <?php post_class( 'lumea-blog-featured lumea-reveal-js lumea-reveal--static-js' ); ?>>
				<a href="<?php the_permalink(); ?>" class="lumea-blog-featured-img-wrap" tabindex="-1" aria-hidden="true">
					<?php
					$featured_image = lumea_get_post_card_image(
						get_the_ID(),
						'large',
						array(
							'class'         => 'lumea-blog-featured-img',
							'loading'       => 'eager',
							'fetchpriority' => 'high',
						)
					);
					if ( $featured_image ) :
						echo wp_kses_post( $featured_image );
						?>
					<?php else : ?>
					<div class="lumea-blog-featured-img-placeholder"></div>
					<?php endif; ?>
				</a>
				<div class="lumea-blog-featured-body">
					<?php if ( $feat_cat ) : ?>
					<p class="lumea-blog-card-cat"><?php echo esc_html( $feat_cat ); ?></p>
					<?php endif; ?>
					<h2 class="lumea-blog-featured-title">
						<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
					</h2>
					<p class="lumea-blog-featured-excerpt"><?php echo wp_kses_post( wp_trim_words( get_the_excerpt(), 28, '&hellip;' ) ); ?></p>
					<div class="lumea-blog-featured-meta">
						<span><?php echo esc_html( get_the_author() ); ?></span>
						<span aria-hidden="true">&middot;</span>
						<time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time>
						<span aria-hidden="true">&middot;</span>
						<span>
						<?php
						/* translators: %d: estimated reading time in minutes */
						printf( esc_html__( '%d min', 'lumea' ), absint( $feat_read ) );
						?>
						</span>
					</div>
					<a href="<?php the_permalink(); ?>" class="lumea-blog-featured-btn">
						<?php esc_html_e( 'Read Article', 'lumea' ); ?>
						<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" aria-hidden="true"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
					</a>
				</div>
			</article>

			<!-- Remaining posts grid -->
				<?php if ( have_posts() ) : ?>
			<div class="lumea-blog-grid">
					<?php
					while ( have_posts() ) :
						the_post();
						$cats      = get_the_category();
						$cat_name  = $cats ? $cats[0]->name : '';
						$read_time = max( 1, round( str_word_count( wp_strip_all_tags( get_the_content() ) ) / 200 ) );
						?>
				<article <?php post_class( 'lumea-blog-card lumea-reveal-js lumea-reveal--static-js' ); ?>>
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
						<p class="lumea-blog-card-excerpt"><?php echo wp_kses_post( wp_trim_words( get_the_excerpt(), 18, '&hellip;' ) ); ?></p>
						<div class="lumea-blog-card-footer">
							<div class="lumea-blog-card-meta">
								<time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>" class="lumea-blog-card-date"><?php echo esc_html( get_the_date( 'M j, Y' ) ); ?></time>
								<span aria-hidden="true">&middot;</span>
								<span class="lumea-blog-card-read">
								<?php
								/* translators: %d: estimated reading time in minutes */
								printf( esc_html__( '%d min', 'lumea' ), (int) $read_time );
								?>
								</span>
							</div>
							<a href="<?php the_permalink(); ?>" class="lumea-blog-card-link">
								<?php esc_html_e( 'Read', 'lumea' ); ?>
								<svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" aria-hidden="true"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
							</a>
						</div>
					</div>
				</article>
					<?php endwhile; ?>
			</div>
			<?php endif; ?>

			<!-- Pagination -->
			<div class="lumea-blog-pagination">
				<?php
				echo wp_kses_post(
					paginate_links(
						array(
							'prev_text' => '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="15 18 9 12 15 6"/></svg>',
							'next_text' => '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="9 18 15 12 9 6"/></svg>',
							'type'      => 'list',
						)
					)
				);
				?>
			</div>

			<?php else : ?>

			<div class="lumea-blog-empty">
				<p><?php esc_html_e( 'No articles found. Check back soon.', 'lumea' ); ?></p>
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="lumea-404-btn lumea-404-btn--outline"><?php esc_html_e( 'Back to Home', 'lumea' ); ?></a>
			</div>

			<?php endif; ?>

		</div>
	</div>

</main>

<?php get_footer(); ?>
