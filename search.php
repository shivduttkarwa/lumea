<?php
/**
 * Search results page — Luméa premium edition.
 *
 * @package Lumea
 */

defined( 'ABSPATH' ) || exit;
get_header();

$query_term = get_search_query();
$count      = $wp_query->found_posts;
?>

<main class="lumea-search-page" id="lumeaPage">

	<!-- Breadcrumb -->
	<nav class="lumea-pdp-breadcrumb" aria-label="<?php esc_attr_e( 'Breadcrumb', 'lumea' ); ?>">
		<div class="lumea-pdp-bc-inner">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'lumea' ); ?></a>
			<svg class="lumea-pdp-bc-arrow" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="9 18 15 12 9 6"/></svg>
			<span aria-current="page"><?php esc_html_e( 'Search', 'lumea' ); ?></span>
		</div>
	</nav>

	<!-- Hero -->
	<div class="lumea-search-hero">
		<div class="lumea-search-hero-inner">
			<p class="lumea-cart-eyebrow">
				<?php if ( $query_term ) :
					printf( esc_html( _n( '%s result for', '%s results for', $count, 'lumea' ) ), number_format_i18n( $count ) );
				endif; ?>
			</p>
			<h1 class="lumea-search-title">
				<?php if ( $query_term ) :
					printf( esc_html__( '"%s"', 'lumea' ), esc_html( $query_term ) );
				else :
					esc_html_e( 'Search', 'lumea' );
				endif; ?>
			</h1>
			<!-- Inline search form -->
			<form class="lumea-search-form" role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
				<input type="search" class="lumea-search-input" name="s" value="<?php echo esc_attr( $query_term ); ?>" placeholder="<?php esc_attr_e( 'Search products, articles…', 'lumea' ); ?>" aria-label="<?php esc_attr_e( 'Search', 'lumea' ); ?>">
				<button type="submit" class="lumea-search-submit" aria-label="<?php esc_attr_e( 'Submit search', 'lumea' ); ?>">
					<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
				</button>
			</form>
		</div>
	</div>

	<!-- Results -->
	<div class="lumea-search-body">
		<div class="lumea-search-body-inner">

			<?php if ( have_posts() ) : ?>
			<div class="lumea-search-grid">
				<?php while ( have_posts() ) : the_post();
					$type        = get_post_type();
					$is_product  = $type === 'product';
					$is_post     = $type === 'post';
					$cats        = $is_product ? get_the_terms( get_the_ID(), 'product_cat' ) : get_the_category();
					$cat_name    = ( $cats && ! is_wp_error( $cats ) ) ? $cats[0]->name : '';
				?>
				<article class="lumea-search-card" <?php post_class( '' ); ?>>
					<a href="<?php the_permalink(); ?>" class="lumea-search-card-img-wrap" tabindex="-1" aria-hidden="true">
						<?php if ( has_post_thumbnail() ) : ?>
						<?php the_post_thumbnail( 'medium_large', array( 'class' => 'lumea-search-card-img', 'loading' => 'lazy' ) ); ?>
						<?php else : ?>
						<div class="lumea-search-card-img-placeholder">
							<svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
						</div>
						<?php endif; ?>
						<?php if ( $is_product ) : ?>
						<span class="lumea-search-card-badge"><?php esc_html_e( 'Product', 'lumea' ); ?></span>
						<?php elseif ( $is_post ) : ?>
						<span class="lumea-search-card-badge lumea-search-card-badge--article"><?php esc_html_e( 'Article', 'lumea' ); ?></span>
						<?php endif; ?>
					</a>
					<div class="lumea-search-card-body">
						<?php if ( $cat_name ) : ?>
						<p class="lumea-blog-card-cat"><?php echo esc_html( $cat_name ); ?></p>
						<?php endif; ?>
						<h2 class="lumea-search-card-title">
							<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
						</h2>
						<p class="lumea-search-card-excerpt"><?php echo wp_trim_words( get_the_excerpt(), 20, '&hellip;' ); ?></p>
						<a href="<?php the_permalink(); ?>" class="lumea-blog-card-link">
							<?php echo $is_product ? esc_html__( 'View Product', 'lumea' ) : esc_html__( 'Read', 'lumea' ); ?>
							<svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" aria-hidden="true"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
						</a>
					</div>
				</article>
				<?php endwhile; ?>
			</div>

			<!-- Pagination -->
			<div class="lumea-blog-pagination">
				<?php echo paginate_links( array(
					'prev_text' => '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="15 18 9 12 15 6"/></svg>',
					'next_text' => '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="9 18 15 12 9 6"/></svg>',
					'type'      => 'list',
				) ); ?>
			</div>

			<?php else : ?>
			<div class="lumea-search-empty">
				<div class="lumea-404-visual">
					<svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
				</div>
				<h2 class="lumea-search-empty-title"><?php esc_html_e( 'No results found', 'lumea' ); ?></h2>
				<p class="lumea-search-empty-text"><?php esc_html_e( 'Try a different search term, or browse our collection.', 'lumea' ); ?></p>
				<a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>" class="lumea-404-btn lumea-404-btn--primary">
					<?php esc_html_e( 'Shop All', 'lumea' ); ?>
				</a>
			</div>
			<?php endif; ?>

		</div>
	</div>

</main>

<?php get_footer(); ?>
