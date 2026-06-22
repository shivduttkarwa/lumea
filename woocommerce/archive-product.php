<?php
/**
 * Shop / archive-product template — world-class edition.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 8.6.0
 */

defined( 'ABSPATH' ) || exit;

get_header();

$current_cat = get_queried_object();
$is_category = is_product_category();

if ( $is_category && ! empty( $current_cat->slug ) ) {
	$cat_slug     = sanitize_key( $current_cat->slug );
	$cat_defaults = array(
		'bestseller' => LUMEA_THEME_URI . '/assets/images/bestsellers/bestsellers-hover3.jpg',
		'latest'     => LUMEA_THEME_URI . '/assets/images/bestsellers/bestsellers-hover5.jpg',
	);
	$default_bg  = isset( $cat_defaults[ $cat_slug ] )
		? $cat_defaults[ $cat_slug ]
		: LUMEA_THEME_URI . '/assets/images/bestsellers/cta-bg.jpg';
	$shop_hero_bg = get_theme_mod( 'lumea_cat_' . $cat_slug . '_hero_bg', $default_bg );
} else {
	$shop_hero_bg = get_theme_mod( 'lumea_shop_hero_bg', LUMEA_THEME_URI . '/assets/images/bestsellers/cta-bg.jpg' );
}

$shop_cats = get_terms( array(
	'taxonomy'   => 'product_cat',
	'hide_empty' => true,
	'parent'     => 0,
	'exclude'    => array( get_option( 'default_product_cat' ) ),
) );

$active_orderby   = isset( $_GET['orderby'] ) ? sanitize_text_field( wp_unslash( $_GET['orderby'] ) ) : get_option( 'woocommerce_default_catalog_orderby', 'menu_order' );
$active_min_price = isset( $_GET['min_price'] ) ? absint( $_GET['min_price'] ) : '';
$active_max_price = isset( $_GET['max_price'] ) ? absint( $_GET['max_price'] ) : '';

$orderby_options = array(
	'menu_order' => __( 'Featured',        'lumea' ),
	'date'       => __( 'Newest',          'lumea' ),
	'price'      => __( 'Price: Low — High','lumea' ),
	'price-desc' => __( 'Price: High — Low','lumea' ),
	'popularity' => __( 'Best Selling',    'lumea' ),
	'rating'     => __( 'Top Rated',       'lumea' ),
);

$price_ranges = array(
	''        => __( 'All Prices', 'lumea' ),
	'0-25'    => __( 'Under $25',  'lumea' ),
	'25-50'   => __( '$25 — $50',  'lumea' ),
	'50-100'  => __( '$50 — $100', 'lumea' ),
	'100-999' => __( 'Over $100',  'lumea' ),
);

$active_price_key = '';
if ( $active_min_price !== '' || $active_max_price !== '' ) {
	$active_price_key = $active_min_price . '-' . $active_max_price;
}

$base_url = $is_category ? get_term_link( $current_cat ) : get_permalink( wc_get_page_id( 'shop' ) );
?>

<main class="lumea-shop" id="lumeaShop">

	<!-- Full-bleed hero -->
	<div class="lumea-shop-hero" style="--shop-bg: url('<?php echo esc_url( $shop_hero_bg ); ?>')">
		<div class="lumea-shop-hero-overlay"></div>
		<div class="lumea-shop-hero-inner">
			<?php if ( apply_filters( 'woocommerce_show_page_title', true ) ) : ?>
			<p class="lumea-shop-hero-eyebrow lumea-reveal-js lumea-reveal--fade-js lumea-reveal--hero-js"><?php esc_html_e( 'The Collection', 'lumea' ); ?></p>
			<h1 class="lumea-shop-hero-title lumea-reveal-js lumea-reveal--fade-js lumea-reveal--hero-js"><?php woocommerce_page_title(); ?></h1>
			<?php endif; ?>
			<?php $cat_desc = get_the_archive_description(); if ( $cat_desc ) : ?>
			<div class="lumea-shop-hero-desc lumea-reveal-js lumea-reveal--fade-js lumea-reveal--hero-js"><?php echo wp_kses_post( $cat_desc ); ?></div>
			<?php endif; ?>
		</div>
	</div>

	<!-- Sticky filter bar -->
	<div class="lumea-filter-bar" id="lumeaFilterBar">
		<div class="lumea-filter-bar-inner">

			<!-- Category pills -->
			<div class="lumea-filter-cats">
				<a href="<?php echo esc_url( get_permalink( wc_get_page_id( 'shop' ) ) ); ?>"
				   class="lumea-filter-pill<?php echo ! $is_category ? ' is-active' : ''; ?>">
					<?php esc_html_e( 'All', 'lumea' ); ?>
				</a>
				<?php if ( ! is_wp_error( $shop_cats ) ) :
					foreach ( $shop_cats as $cat ) :
						$is_active = $is_category && $current_cat->term_id === $cat->term_id;
				?>
				<a href="<?php echo esc_url( get_term_link( $cat ) ); ?>"
				   class="lumea-filter-pill<?php echo $is_active ? ' is-active' : ''; ?>">
					<?php echo esc_html( $cat->name ); ?>
					<span class="lumea-filter-pill-count"><?php echo esc_html( $cat->count ); ?></span>
				</a>
				<?php endforeach; endif; ?>
			</div>

			<!-- Right side controls -->
			<div class="lumea-filter-controls">

				<!-- Price filter -->
				<div class="lumea-filter-dropdown" data-lumea-dropdown>
					<button class="lumea-filter-btn<?php echo $active_price_key ? ' is-active' : ''; ?>" data-lumea-dropdown-trigger>
						<?php echo $active_price_key ? esc_html( $price_ranges[ $active_price_key ] ?? __( 'Price', 'lumea' ) ) : esc_html__( 'Price', 'lumea' ); ?>
						<svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="lumea-filter-chevron"><polyline points="6 9 12 15 18 9"/></svg>
					</button>
					<div class="lumea-filter-dropdown-panel" data-lumea-dropdown-panel>
						<?php foreach ( $price_ranges as $key => $label ) :
							$parts   = $key ? explode( '-', $key ) : array();
							$pparams = $key ? array( 'min_price' => $parts[0], 'max_price' => $parts[1] ) : array( 'min_price' => '', 'max_price' => '' );
						?>
						<a href="<?php echo lumea_filter_url( $base_url, $pparams ); ?>"
						   class="lumea-filter-option<?php echo ( $active_price_key === $key ) ? ' is-active' : ''; ?>">
							<?php echo esc_html( $label ); ?>
							<?php if ( $active_price_key === $key ) : ?>
							<svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
							<?php endif; ?>
						</a>
						<?php endforeach; ?>
					</div>
				</div>

				<!-- Sort -->
				<div class="lumea-filter-dropdown" data-lumea-dropdown>
					<button class="lumea-filter-btn<?php echo $active_orderby !== 'menu_order' ? ' is-active' : ''; ?>" data-lumea-dropdown-trigger>
						<?php echo esc_html( $orderby_options[ $active_orderby ] ?? __( 'Sort', 'lumea' ) ); ?>
						<svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="lumea-filter-chevron"><polyline points="6 9 12 15 18 9"/></svg>
					</button>
					<div class="lumea-filter-dropdown-panel" data-lumea-dropdown-panel>
						<?php foreach ( $orderby_options as $val => $label ) : ?>
						<a href="<?php echo lumea_filter_url( $base_url, array( 'orderby' => $val ) ); ?>"
						   class="lumea-filter-option<?php echo $active_orderby === $val ? ' is-active' : ''; ?>">
							<?php echo esc_html( $label ); ?>
							<?php if ( $active_orderby === $val ) : ?>
							<svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
							<?php endif; ?>
						</a>
						<?php endforeach; ?>
					</div>
				</div>

				<!-- Result count -->
				<span class="lumea-filter-count"><?php woocommerce_result_count(); ?></span>

			</div>
		</div>

		<!-- Active filters strip -->
		<?php
		$has_active = $active_price_key || $is_category || $active_orderby !== 'menu_order';
		if ( $has_active ) : ?>
		<div class="lumea-active-filters">
			<div class="lumea-filter-bar-inner">
				<span class="lumea-active-filters-label"><?php esc_html_e( 'Active:', 'lumea' ); ?></span>
				<?php if ( $is_category ) : ?>
				<a href="<?php echo esc_url( get_permalink( wc_get_page_id( 'shop' ) ) ); ?>" class="lumea-active-tag">
					<?php echo esc_html( $current_cat->name ); ?>
					<svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
				</a>
				<?php endif; ?>
				<?php if ( $active_price_key ) : ?>
				<a href="<?php echo lumea_filter_url( $base_url, array( 'min_price' => '', 'max_price' => '' ) ); ?>" class="lumea-active-tag">
					<?php echo esc_html( $price_ranges[ $active_price_key ] ); ?>
					<svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
				</a>
				<?php endif; ?>
				<?php if ( $active_orderby !== 'menu_order' ) : ?>
				<a href="<?php echo lumea_filter_url( $base_url, array( 'orderby' => '' ) ); ?>" class="lumea-active-tag">
					<?php echo esc_html( $orderby_options[ $active_orderby ] ); ?>
					<svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
				</a>
				<?php endif; ?>
				<a href="<?php echo esc_url( get_permalink( wc_get_page_id( 'shop' ) ) ); ?>" class="lumea-clear-filters"><?php esc_html_e( 'Clear all', 'lumea' ); ?></a>
			</div>
		</div>
		<?php endif; ?>
	</div>

	<!-- Products -->
	<div class="lumea-shop-body">
		<div class="lumea-container">

			<?php if ( woocommerce_product_loop() ) : ?>
				<?php woocommerce_product_loop_start(); ?>
					<?php while ( have_posts() ) : the_post(); ?>
						<?php wc_get_template_part( 'content', 'product' ); ?>
					<?php endwhile; ?>
				<?php woocommerce_product_loop_end(); ?>
				<div class="lumea-shop-pagination">
					<?php woocommerce_pagination(); ?>
				</div>
			<?php else : ?>
				<div class="lumea-shop-empty">
					<p><?php esc_html_e( 'No products found.', 'lumea' ); ?></p>
					<a href="<?php echo esc_url( get_permalink( wc_get_page_id( 'shop' ) ) ); ?>" class="lumea-shop-empty-link"><?php esc_html_e( 'Browse all products', 'lumea' ); ?></a>
				</div>
			<?php endif; ?>

		</div>
	</div>

</main>

<?php get_footer(); ?>
