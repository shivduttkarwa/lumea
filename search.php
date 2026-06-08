<?php
/**
 * Search results page.
 *
 * @package Lumea
 */

defined( 'ABSPATH' ) || exit;
get_header();

$query_term    = get_search_query();
$count         = $wp_query->found_posts;
$product_count = 0;
$post_count    = 0;

foreach ( $wp_query->posts as $p ) {
	if ( $p->post_type === 'product' ) {
		$product_count++;
	} elseif ( $p->post_type === 'post' ) {
		$post_count++;
	}
}
?>

<main class="lumea-search-page" id="lumeaPage">

	<!-- ── Hero ── -->
	<section class="lumea-search-hero">
		<div class="lumea-search-hero-inner">
			<?php if ( $query_term ) : ?>
			<p class="lumea-search-eyebrow">
				<?php printf(
					/* translators: %s: formatted number of results (e.g. "3") */
					wp_kses( _n( '%s result for', '%s results for', $count, 'lumea' ), array( 'strong' => array() ) ),
					'<strong>' . number_format_i18n( $count ) . '</strong>'
				); ?>
			</p>
			<?php endif; ?>

			<h1 class="lumea-search-title">
				<?php echo $query_term
					? '&#8220;' . esc_html( $query_term ) . '&#8221;'
					: esc_html__( 'Search', 'lumea' ); ?>
			</h1>

			<form class="lumea-search-form" role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
				<svg class="lumea-search-form-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
				<input
					type="search"
					class="lumea-search-input"
					name="s"
					value="<?php echo esc_attr( $query_term ); ?>"
					placeholder="<?php esc_attr_e( 'Search products, articles\xe2\x80\xa6', 'lumea' ); ?>"
					autocomplete="off"
					aria-label="<?php esc_attr_e( 'Search', 'lumea' ); ?>"
				>
				<button type="submit" class="lumea-search-submit">
					<?php esc_html_e( 'Search', 'lumea' ); ?>
				</button>
			</form>
		</div>
	</section>

	<!-- ── Results ── -->
	<div class="lumea-search-body">
		<div class="lumea-search-body-inner">

			<?php if ( have_posts() ) : ?>

			<!-- Filter tabs -->
			<div class="lumea-search-filters" data-lumea-search-filters>
				<button class="lumea-search-tab is-active" data-filter="all">
					<?php esc_html_e( 'All', 'lumea' ); ?>
					<span class="lumea-search-tab-count"><?php echo number_format_i18n( $count ); ?></span>
				</button>
				<?php if ( $product_count ) : ?>
				<button class="lumea-search-tab" data-filter="product">
					<?php esc_html_e( 'Products', 'lumea' ); ?>
					<span class="lumea-search-tab-count"><?php echo number_format_i18n( $product_count ); ?></span>
				</button>
				<?php endif; ?>
				<?php if ( $post_count ) : ?>
				<button class="lumea-search-tab" data-filter="post">
					<?php esc_html_e( 'Articles', 'lumea' ); ?>
					<span class="lumea-search-tab-count"><?php echo number_format_i18n( $post_count ); ?></span>
				</button>
				<?php endif; ?>
			</div>

			<!-- Cards grid -->
			<div class="lumea-search-grid" data-lumea-search-grid>
				<?php while ( have_posts() ) : the_post();
					$post_type  = get_post_type();
					$is_product = ( $post_type === 'product' );
					$is_post    = ( $post_type === 'post' );
					$cats       = ( $is_product && taxonomy_exists( 'product_cat' ) )
						? get_the_terms( get_the_ID(), 'product_cat' )
						: get_the_category();
					$cat_name   = ( $cats && ! is_wp_error( $cats ) ) ? esc_html( $cats[0]->name ) : '';
					$wc_product = ( $is_product && function_exists( 'wc_get_product' ) )
						? wc_get_product( get_the_ID() )
						: null;
				?>
				<article
					class="lumea-search-card lumea-search-card--<?php echo esc_attr( $post_type ); ?>"
					data-post-type="<?php echo esc_attr( $post_type ); ?>"
				>
					<!-- Media -->
					<a href="<?php the_permalink(); ?>" class="lumea-search-card-media" tabindex="-1" aria-hidden="true">
						<?php if ( has_post_thumbnail() ) : ?>
							<?php the_post_thumbnail( 'medium_large', array( 'class' => 'lumea-search-card-img', 'loading' => 'lazy' ) ); ?>
						<?php else : ?>
							<div class="lumea-search-card-no-img">
								<svg width="2rem" height="2rem" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
							</div>
						<?php endif; ?>
						<span class="lumea-search-card-type">
							<?php echo $is_product ? esc_html__( 'Product', 'lumea' ) : esc_html__( 'Article', 'lumea' ); ?>
						</span>
					</a>

					<!-- Body -->
					<div class="lumea-search-card-body">
						<?php if ( $cat_name ) : ?>
						<p class="lumea-search-card-cat"><?php echo $cat_name; ?></p>
						<?php endif; ?>

						<h2 class="lumea-search-card-title">
							<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
						</h2>

						<p class="lumea-search-card-excerpt">
							<?php echo wp_trim_words( get_the_excerpt(), 18, '&hellip;' ); ?>
						</p>

						<div class="lumea-search-card-foot">
							<?php if ( $is_product && $wc_product ) : ?>
								<span class="lumea-search-card-price"><?php echo wp_kses_post( $wc_product->get_price_html() ); ?></span>
							<?php else : ?>
								<span class="lumea-search-card-date"><?php echo esc_html( get_the_date( 'M j, Y' ) ); ?></span>
							<?php endif; ?>

							<a href="<?php the_permalink(); ?>" class="lumea-search-card-cta">
								<?php echo $is_product ? esc_html__( 'View', 'lumea' ) : esc_html__( 'Read', 'lumea' ); ?>
								<svg width="0.75rem" height="0.75rem" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" aria-hidden="true"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
							</a>
						</div>
					</div>
				</article>
				<?php endwhile; ?>
			</div>

			<!-- Pagination -->
			<div class="lumea-blog-pagination" data-lumea-search-pagination>
				<?php echo paginate_links( array(
					'prev_text' => '<svg width="1rem" height="1rem" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="15 18 9 12 15 6"/></svg>',
					'next_text' => '<svg width="1rem" height="1rem" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="9 18 15 12 9 6"/></svg>',
					'type'      => 'list',
				) ); ?>
			</div>

			<?php else : ?>

			<!-- Empty state -->
			<div class="lumea-search-empty">
				<div class="lumea-search-empty-icon" aria-hidden="true">
					<svg width="2.25rem" height="2.25rem" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
				</div>
				<h2 class="lumea-search-empty-title">
					<?php $query_term
						? printf( /* translators: %s: search query string */ esc_html__( 'No results for &#8220;%s&#8221;', 'lumea' ), esc_html( $query_term ) )
						: esc_html_e( 'No results found', 'lumea' ); ?>
				</h2>
				<p class="lumea-search-empty-text">
					<?php esc_html_e( 'Try a different keyword, or explore what we have to offer.', 'lumea' ); ?>
				</p>
				<div class="lumea-search-empty-actions">
					<a href="<?php echo esc_url( lumea_get_shop_url() ); ?>" class="lumea-search-empty-btn lumea-search-empty-btn--primary">
						<?php esc_html_e( 'Shop All', 'lumea' ); ?>
					</a>
					<a href="<?php echo esc_url( home_url( '/blog/' ) ); ?>" class="lumea-search-empty-btn">
						<?php esc_html_e( 'Browse Articles', 'lumea' ); ?>
					</a>
				</div>
			</div>

			<?php endif; ?>

		</div>
	</div>

</main>

<?php get_footer(); ?>
