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
		$categories   = get_the_category();
		$cat_name     = $categories ? $categories[0]->name : '';
		$reading_time = max( 1, round( str_word_count( strip_tags( get_the_content() ) ) / 200 ) );
	?>

	<!-- Breadcrumb -->
	<nav class="lumea-pdp-breadcrumb" aria-label="<?php esc_attr_e( 'Breadcrumb', 'lumea' ); ?>">
		<div class="lumea-pdp-bc-inner">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'lumea' ); ?></a>
			<svg class="lumea-pdp-bc-arrow" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="9 18 15 12 9 6"/></svg>
			<a href="<?php echo esc_url( get_permalink( get_option( 'page_for_posts' ) ) ?: home_url( '/journal/' ) ); ?>"><?php esc_html_e( 'Journal', 'lumea' ); ?></a>
			<svg class="lumea-pdp-bc-arrow" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="9 18 15 12 9 6"/></svg>
			<span aria-current="page"><?php the_title(); ?></span>
		</div>
	</nav>

	<!-- Post hero -->
	<div class="lumea-post-hero">
		<div class="lumea-post-hero-inner">
			<?php if ( $cat_name ) : ?>
			<p class="lumea-cart-eyebrow"><?php echo esc_html( $cat_name ); ?></p>
			<?php endif; ?>
			<h1 class="lumea-post-title"><?php the_title(); ?></h1>
			<div class="lumea-post-meta">
				<span class="lumea-post-author">
					<?php echo esc_html( get_the_author() ); ?>
				</span>
				<span class="lumea-post-sep" aria-hidden="true">&middot;</span>
				<time class="lumea-post-date" datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>">
					<?php echo esc_html( get_the_date() ); ?>
				</time>
				<span class="lumea-post-sep" aria-hidden="true">&middot;</span>
				<span class="lumea-post-read"><?php printf( esc_html__( '%d min read', 'lumea' ), $reading_time ); ?></span>
			</div>
		</div>
	</div>

	<!-- Featured image -->
	<?php if ( has_post_thumbnail() ) : ?>
	<div class="lumea-post-cover">
		<div class="lumea-post-cover-inner">
			<?php the_post_thumbnail( 'full', array( 'class' => 'lumea-post-cover-img', 'loading' => 'eager', 'fetchpriority' => 'high' ) ); ?>
		</div>
	</div>
	<?php endif; ?>

	<!-- Content -->
	<div class="lumea-post-body">
		<div class="lumea-post-body-inner">
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

			<!-- Author box -->
			<div class="lumea-post-author-box">
				<?php echo get_avatar( get_the_author_meta( 'user_email' ), 64, '', '', array( 'class' => 'lumea-post-author-avatar' ) ); ?>
				<div>
					<p class="lumea-post-author-name"><?php echo esc_html( get_the_author() ); ?></p>
					<?php $bio = get_the_author_meta( 'description' ); if ( $bio ) : ?>
					<p class="lumea-post-author-bio"><?php echo wp_kses_post( $bio ); ?></p>
					<?php endif; ?>
				</div>
			</div>

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
			<h2 class="lumea-post-related-title"><?php esc_html_e( 'You Might Also Like', 'lumea' ); ?></h2>
			<div class="lumea-post-related-grid">
				<?php foreach ( $related as $post ) : setup_postdata( $post );
					$rcat = get_the_category( $post->ID );
					$rcat_name = $rcat ? $rcat[0]->name : '';
				?>
				<article class="lumea-blog-card">
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

	<?php endwhile; ?>

</main>

<?php get_footer(); ?>
