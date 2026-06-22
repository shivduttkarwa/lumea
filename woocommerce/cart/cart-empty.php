<?php
/**
 * Empty cart page — Luméa.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart-empty.php.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 7.0.1
 */

defined( 'ABSPATH' ) || exit;

$lumea_shop_url     = wc_get_page_permalink( 'shop' );
$lumea_best_term    = get_term_by( 'name', 'Bestseller', 'product_cat' );
$lumea_best_url     = $lumea_best_term ? get_term_link( $lumea_best_term ) : $lumea_shop_url;
$lumea_empty_img    = get_theme_mod( 'lumea_hero_image', LUMEA_THEME_URI . '/assets/images/hero-slide-1.jpg' );
?>

<div class="lumea-cart-page">

	<?php wc_print_notices(); ?>

	<!-- Breadcrumb -->
	<nav class="lumea-pdp-breadcrumb" aria-label="<?php esc_attr_e( 'Breadcrumb', 'lumea' ); ?>">
		<div class="lumea-pdp-bc-inner">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'lumea' ); ?></a>
			<svg class="lumea-pdp-bc-arrow" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="9 18 15 12 9 6"/></svg>
			<span aria-current="page"><?php esc_html_e( 'Your Bag', 'lumea' ); ?></span>
		</div>
	</nav>

	<!-- Hero -->
	<div class="lumea-cart-hero">
		<div class="lumea-cart-hero-inner">
			<p class="lumea-cart-eyebrow"><?php esc_html_e( 'Review & Checkout', 'lumea' ); ?></p>
			<h1 class="lumea-cart-title"><?php esc_html_e( 'Your Bag (0 items)', 'lumea' ); ?></h1>
		</div>
	</div>

	<!-- Empty state -->
	<div class="lumea-cart-empty">

		<!-- Stage: copy left, image right -->
		<div class="lumea-cart-empty-stage">

			<div class="lumea-cart-empty-copy">
				<div class="lumea-cart-empty-icon" aria-hidden="true">
					<svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.1" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 01-8 0"/></svg>
				</div>
				<p class="lumea-cart-empty-eyebrow"><?php esc_html_e( 'Your Bag', 'lumea' ); ?></p>
				<h2 class="lumea-cart-empty-title"><?php esc_html_e( 'Nothing here yet', 'lumea' ); ?></h2>
				<p class="lumea-cart-empty-text"><?php esc_html_e( 'Your bag is empty. Browse our botanical skincare collection and find your ritual.', 'lumea' ); ?></p>
				<div class="lumea-cart-empty-actions">
					<a href="<?php echo esc_url( $lumea_shop_url ); ?>" class="lumea-cart-empty-btn-primary"><?php esc_html_e( 'Shop the Collection', 'lumea' ); ?></a>
					<a href="<?php echo esc_url( $lumea_best_url ); ?>" class="lumea-cart-empty-btn-ghost"><?php esc_html_e( 'Browse Bestsellers', 'lumea' ); ?></a>
				</div>
			</div>

			<div class="lumea-cart-empty-visual" aria-hidden="true">
				<img src="<?php echo esc_url( $lumea_empty_img ); ?>" alt="" class="lumea-cart-empty-img" loading="lazy">
				<div class="lumea-cart-empty-visual-badge">
					<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
					<?php esc_html_e( 'Free returns on all orders', 'lumea' ); ?>
				</div>
			</div>

		</div><!-- /.lumea-cart-empty-stage -->

		<!-- Recommended products -->
		<?php
		$lumea_rec = wc_get_products( array(
			'status'  => 'publish',
			'limit'   => 4,
			'orderby' => 'popularity',
			'order'   => 'DESC',
		) );
		if ( $lumea_rec ) :
		?>
		<div class="lumea-cart-empty-rec">
			<div class="lumea-cart-empty-rec-inner">
				<p class="lumea-cart-empty-rec-eyebrow"><?php esc_html_e( 'Start Here', 'lumea' ); ?></p>
				<h3 class="lumea-cart-empty-rec-title"><?php esc_html_e( 'Our Most-Loved', 'lumea' ); ?></h3>
				<div class="lumea-cart-empty-rec-grid">
					<?php foreach ( $lumea_rec as $lumea_rec_product ) :
						$rec_data = lumea_get_product_card_data( $lumea_rec_product );
						if ( empty( $rec_data ) ) continue;
						get_template_part( 'template-parts/components/product-card', null, $rec_data );
					endforeach; ?>
				</div>
			</div>
		</div>
		<?php endif; ?>

	</div><!-- /.lumea-cart-empty -->

	<?php do_action( 'woocommerce_after_cart' ); ?>

</div><!-- /.lumea-cart-page -->
