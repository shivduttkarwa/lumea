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

	<?php while ( have_posts() ) : the_post();
		$categories       = get_the_category();
		$cat_name         = $categories ? $categories[0]->name : '';
		$reading_time     = max( 1, round( str_word_count( strip_tags( get_the_content() ) ) / 200 ) );
		$posts_page_id    = (int) get_option( 'page_for_posts' );
		$blog_page        = get_page_by_path( 'blog' );
		$journal_url      = $posts_page_id
			? get_permalink( $posts_page_id )
			: ( $blog_page ? get_permalink( $blog_page ) : home_url( '/blog/' ) );
		$single_hero_bg   = get_theme_mod( 'lumea_blog_single_hero_bg', LUMEA_THEME_URI . '/assets/images/bestsellers/cta-bg.jpg' );
		$single_hero_sub  = get_theme_mod( 'lumea_blog_single_hero_subtitle', 'Rituals, ingredients, and the science of radiant skin.' );
	?>

	<!-- Post hero — same structure as shop/blog listing hero -->
	<div class="lumea-shop-hero" style="--shop-bg: url('<?php echo esc_url( $single_hero_bg ); ?>')">
		<div class="lumea-shop-hero-overlay"></div>
		<div class="lumea-shop-hero-inner">
			<h1 class="lumea-shop-hero-title lumea-reveal-js lumea-reveal--fade-js lumea-reveal--hero-js"><?php the_title(); ?></h1>
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
				<span class="lumea-post-meta-item"><?php printf( esc_html__( '%d min read', 'lumea' ), $reading_time ); ?></span>
			</div>

			<article class="lumea-post-content entry-content">
				<?php the_content(); ?>
				<?php wp_link_pages( array( 'before' => '<nav class="page-links">', 'after' => '</nav>' ) ); ?>
			</article>

			<!-- Tags -->
			<?php $tags = get_the_tags(); if ( $tags ) : ?>
			<div class="lumea-post-tags">
				<?php foreach ( $tags as $tag ) : ?>
				<a href="<?php echo esc_url( get_tag_link( $tag->term_id ) ); ?>" class="lumea-post-tag"><?php echo esc_html( $tag->name ); ?></a>
				<?php endforeach; ?>
			</div>
			<?php endif; ?>

			<!-- Share -->
			<div class="lumea-post-share">
				<span class="lumea-post-share-label"><?php esc_html_e( 'Share', 'lumea' ); ?></span>
				<a href="https://twitter.com/intent/tweet?url=<?php echo rawurlencode( get_permalink() ); ?>&text=<?php echo rawurlencode( get_the_title() ); ?>" target="_blank" rel="noopener noreferrer" class="lumea-post-share-btn" aria-label="<?php esc_attr_e( 'Share on X', 'lumea' ); ?>">
					<svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-4.714-6.231-5.401 6.231H2.744l7.73-8.835L1.254 2.25H8.08l4.258 5.63zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
				</a>
				<a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo rawurlencode( get_permalink() ); ?>" target="_blank" rel="noopener noreferrer" class="lumea-post-share-btn" aria-label="<?php esc_attr_e( 'Share on Facebook', 'lumea' ); ?>">
					<svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z"/></svg>
				</a>
			</div>

			<div class="lumea-post-back-wrap">
				<a href="<?php echo esc_url( $journal_url ); ?>" class="lumea-post-back-link">
					<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.1" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M19 12H5"/><path d="m12 19-7-7 7-7"/></svg>
					<?php esc_html_e( 'Back to Journal', 'lumea' ); ?>
				</a>
			</div>

			<!-- Author box -->
			<div class="lumea-post-author-box lumea-reveal-js lumea-reveal--static-js">
				<?php echo get_avatar( get_the_author_meta( 'user_email' ), 64, '', '', array( 'class' => 'lumea-post-author-avatar' ) ); ?>
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
	$related = get_posts( array(
		'category__in'   => wp_get_post_categories( get_the_ID() ),
		'post__not_in'   => array( get_the_ID() ),
		'posts_per_page' => 3,
		'orderby'        => 'rand',
	) );
	if ( $related ) :
	?>
	<div class="lumea-post-related">
		<div class="lumea-post-related-inner">
			<h2 class="lumea-post-related-title lumea-reveal-js lumea-reveal--static-js"><?php esc_html_e( 'You Might Also Like', 'lumea' ); ?></h2>
			<div class="lumea-post-related-grid">
				<?php foreach ( $related as $post ) : setup_postdata( $post );
					$rcat = get_the_category( $post->ID );
					$rcat_name = $rcat ? $rcat[0]->name : '';
				?>
				<article class="lumea-blog-card lumea-reveal-js lumea-reveal--static-js">
					<a href="<?php the_permalink(); ?>" class="lumea-blog-card-img-wrap" tabindex="-1" aria-hidden="true">
						<?php if ( has_post_thumbnail( $post->ID ) ) : ?>
						<?php echo get_the_post_thumbnail( $post->ID, 'medium_large', array( 'class' => 'lumea-blog-card-img', 'loading' => 'lazy' ) ); ?>
						<?php else : ?>
						<div class="lumea-blog-card-img-placeholder"></div>
						<?php endif; ?>
					</a>
					<div class="lumea-blog-card-body">
						<?php if ( $rcat_name ) : ?>
						<p class="lumea-blog-card-cat"><?php echo esc_html( $rcat_name ); ?></p>
						<?php endif; ?>
						<h3 class="lumea-blog-card-title">
							<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
						</h3>
						<p class="lumea-blog-card-excerpt"><?php echo wp_trim_words( get_the_excerpt(), 18, '&hellip;' ); ?></p>
						<a href="<?php the_permalink(); ?>" class="lumea-blog-card-link"><?php esc_html_e( 'Read', 'lumea' ); ?>
							<svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" aria-hidden="true"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
						</a>
					</div>
				</article>
				<?php endforeach; wp_reset_postdata(); ?>
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
