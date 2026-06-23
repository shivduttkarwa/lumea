<?php
/**
 * Single blog post template — Luméa premium edition.
 *
 * @package Lumea
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>

<main class="lumea-single-page" id="lumeaPage">

	<?php
	while ( have_posts() ) :
		the_post();
		$categories      = get_the_category();
		$cat_name        = $categories ? $categories[0]->name : '';
		$reading_time    = max( 1, round( str_word_count( wp_strip_all_tags( get_the_content() ) ) / 200 ) );
		$posts_page_id   = (int) get_option( 'page_for_posts' );
		$blog_page       = get_page_by_path( 'blog' );
		$journal_url     = $posts_page_id
			? get_permalink( $posts_page_id )
			: ( $blog_page ? get_permalink( $blog_page ) : home_url( '/blog/' ) );
		$single_hero_bg  = get_theme_mod( 'lumea_blog_single_hero_bg', LUMEA_THEME_URI . '/assets/images/bestsellers/cta-bg.jpg' );
		$single_hero_sub = get_theme_mod( 'lumea_blog_single_hero_subtitle', __( 'Rituals, ingredients, and the science of radiant skin.', 'lumea' ) );
		?>

	<!-- Post hero — same structure as shop/blog listing hero -->
	<div class="lumea-shop-hero" style="--shop-bg: url('<?php echo esc_url( $single_hero_bg ); ?>')">
		<div class="lumea-shop-hero-overlay"></div>
		<div class="lumea-shop-hero-inner">
			<h1 class="lumea-shop-hero-title lumea-post-hero-title lumea-reveal-js lumea-reveal--fade-js lumea-reveal--hero-js"><?php the_title(); ?></h1>
			<?php if ( $single_hero_sub ) : ?>
			<p class="lumea-shop-hero-desc lumea-reveal-js lumea-reveal--fade-js lumea-reveal--hero-js"><?php echo esc_html( $single_hero_sub ); ?></p>
			<?php endif; ?>
		</div>
	</div>

	<!-- Content -->
	<div class="lumea-post-body">
		<div class="lumea-post-body-inner">
			<div class="lumea-post-meta-row lumea-reveal-js lumea-reveal--static-js">
				<?php if ( $cat_name ) : ?>
				<span class="lumea-post-meta-pill"><?php echo esc_html( $cat_name ); ?></span>
				<?php endif; ?>
				<span class="lumea-post-meta-item"><?php echo esc_html( get_the_author() ); ?></span>
				<span class="lumea-post-meta-sep" aria-hidden="true">&middot;</span>
				<time class="lumea-post-meta-item" datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>">
					<?php echo esc_html( get_the_date() ); ?>
				</time>
				<span class="lumea-post-meta-sep" aria-hidden="true">&middot;</span>
				<span class="lumea-post-meta-item">
					<?php
					/* translators: %d: estimated reading time in minutes. */
					printf( esc_html__( '%d min read', 'lumea' ), absint( $reading_time ) );
					?>
				</span>
			</div>

			<article id="post-<?php the_ID(); ?>" <?php post_class( 'lumea-post-content entry-content' ); ?>>
				<?php the_content(); ?>
				<?php
				wp_link_pages(
					array(
						'before' => '<nav class="page-links">',
						'after'  => '</nav>',
					)
				);
				?>
			</article>

			<!-- Tags -->
			<?php $tags = get_the_tags(); if ( $tags ) : ?>
			<div class="lumea-post-tags">
				<?php foreach ( $tags as $post_tag ) : ?>
				<a href="<?php echo esc_url( get_tag_link( $post_tag->term_id ) ); ?>" class="lumea-post-tag"><?php echo esc_html( $post_tag->name ); ?></a>
				<?php endforeach; ?>
			</div>
			<?php endif; ?>

			<?php do_action( 'lumea_post_share_actions' ); ?>

			<div class="lumea-post-back-wrap">
				<a href="<?php echo esc_url( $journal_url ); ?>" class="lumea-btn btn-black lumea-post-back-link">
					<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.1" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M19 12H5"/><path d="m12 19-7-7 7-7"/></svg>
					<?php esc_html_e( 'Back to Journal', 'lumea' ); ?>
				</a>
			</div>

			<!-- Author box -->
			<div class="lumea-post-author-box lumea-reveal-js lumea-reveal--static-js">
				<?php echo wp_kses_post( get_avatar( get_the_author_meta( 'user_email' ), 64, '', '', array( 'class' => 'lumea-post-author-avatar' ) ) ); ?>
				<div>
					<p class="lumea-post-author-name"><?php echo esc_html( get_the_author() ); ?></p>
					<?php $bio = get_the_author_meta( 'description' ); if ( $bio ) : ?>
					<p class="lumea-post-author-bio"><?php echo wp_kses_post( $bio ); ?></p>
					<?php endif; ?>
				</div>
			</div>

			<?php
			$lumea_prev_post = get_previous_post();
			$lumea_next_post = get_next_post();
			if ( $lumea_prev_post || $lumea_next_post ) :
				?>
			<nav class="lumea-post-nav" aria-label="<?php esc_attr_e( 'Article navigation', 'lumea' ); ?>">
				<?php if ( $lumea_prev_post ) : ?>
				<a class="lumea-post-nav-item lumea-post-nav-item--prev" href="<?php echo esc_url( get_permalink( $lumea_prev_post->ID ) ); ?>">
					<span class="lumea-post-nav-label"><?php esc_html_e( 'Previous', 'lumea' ); ?></span>
					<span class="lumea-post-nav-title"><?php echo esc_html( get_the_title( $lumea_prev_post->ID ) ); ?></span>
				</a>
				<?php endif; ?>

				<?php if ( $lumea_next_post ) : ?>
				<a class="lumea-post-nav-item lumea-post-nav-item--next" href="<?php echo esc_url( get_permalink( $lumea_next_post->ID ) ); ?>">
					<span class="lumea-post-nav-label"><?php esc_html_e( 'Next', 'lumea' ); ?></span>
					<span class="lumea-post-nav-title"><?php echo esc_html( get_the_title( $lumea_next_post->ID ) ); ?></span>
				</a>
				<?php endif; ?>
			</nav>
			<?php endif; ?>

		</div>
	</div>

	<!-- Related posts -->
		<?php
		$related = get_posts(
			array(
				'category__in'   => wp_get_post_categories( get_the_ID() ),
				'post__not_in'   => array( get_the_ID() ),
				'posts_per_page' => 3,
				'orderby'        => 'rand',
			)
		);
		if ( $related ) :
			?>
	<div class="lumea-post-related">
		<div class="lumea-post-related-inner">
			<h2 class="lumea-post-related-title lumea-reveal-js lumea-reveal--static-js"><?php esc_html_e( 'You Might Also Like', 'lumea' ); ?></h2>
			<div class="lumea-post-related-grid">
				<?php
				foreach ( $related as $related_post ) :
					$related_id      = $related_post->ID;
					$related_url     = get_permalink( $related_id );
					$related_title   = get_the_title( $related_id );
					$related_excerpt = get_the_excerpt( $related_post );
					$rcat            = get_the_category( $related_id );
					$rcat_name       = $rcat ? $rcat[0]->name : '';
					?>
				<article <?php post_class( 'lumea-blog-card lumea-reveal-js lumea-reveal--static-js', $related_id ); ?>>
					<a href="<?php echo esc_url( $related_url ); ?>" class="lumea-blog-card-img-wrap" tabindex="-1" aria-hidden="true">
						<?php
						$related_image = lumea_get_post_card_image( $related_id );
						if ( $related_image ) :
							echo wp_kses_post( $related_image );
							?>
						<?php else : ?>
						<div class="lumea-blog-card-img-placeholder"></div>
						<?php endif; ?>
					</a>
					<div class="lumea-blog-card-body">
						<?php if ( $rcat_name ) : ?>
						<p class="lumea-blog-card-cat"><?php echo esc_html( $rcat_name ); ?></p>
						<?php endif; ?>
						<h3 class="lumea-blog-card-title">
							<a href="<?php echo esc_url( $related_url ); ?>"><?php echo esc_html( $related_title ); ?></a>
						</h3>
						<p class="lumea-blog-card-excerpt"><?php echo wp_kses_post( wp_trim_words( $related_excerpt, 18, '&hellip;' ) ); ?></p>
						<a href="<?php echo esc_url( $related_url ); ?>" class="lumea-blog-card-link"><?php esc_html_e( 'Read', 'lumea' ); ?>
							<svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" aria-hidden="true"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
						</a>
					</div>
				</article>
					<?php
				endforeach;
				?>
			</div>
		</div>
	</div>
		<?php endif; ?>

		<?php
		if ( comments_open() || get_comments_number() ) {
			echo '<div class="lumea-post-body"><div class="lumea-post-body-inner">';
			comments_template();
			echo '</div></div>';
		}
		?>

	<?php endwhile; ?>

</main>

<?php get_footer(); ?>
