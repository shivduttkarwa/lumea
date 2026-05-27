<?php
/**
 * Template Name: Wishlist
 * Wishlist page template.
 *
 * @package Lumea
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$shop_url = class_exists( 'WooCommerce' ) ? wc_get_page_permalink( 'shop' ) : home_url( '/shop/' );

get_header();
?>

<main class="lumea-wishlist-page" id="lumeaWishlistPage">
	<section class="lumea-wishlist-page-hero" aria-label="<?php esc_attr_e( 'Wishlist overview', 'lumea' ); ?>">
		<div class="lumea-wishlist-page-hero-inner">
			<p class="lumea-wishlist-page-eyebrow"><?php esc_html_e( 'Saved Favourites', 'lumea' ); ?></p>
			<h1 class="lumea-wishlist-page-title"><?php esc_html_e( 'Your Wishlist', 'lumea' ); ?></h1>
			<p class="lumea-wishlist-page-subtitle">
				<?php esc_html_e( 'Products you saved for your next ritual.', 'lumea' ); ?>
				<span class="lumea-wishlist-page-count-pill"><span data-lumea-wishlist-count-text>0</span> <?php esc_html_e( 'item(s)', 'lumea' ); ?></span>
			</p>
			<a href="<?php echo esc_url( $shop_url ); ?>" class="lumea-wishlist-page-continue"><?php esc_html_e( 'Continue Shopping', 'lumea' ); ?></a>
		</div>
	</section>

	<section class="lumea-wishlist-page-content" aria-live="polite">
		<div class="lumea-wishlist-page-list" data-lumea-wishlist-page-items></div>
		<div class="lumea-wishlist-page-empty" data-lumea-wishlist-page-empty hidden>
			<svg width="44" height="44" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20.84 4.61a5.5 5.5 0 00-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 00-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 000-7.78z"/></svg>
			<h2><?php esc_html_e( 'Your wishlist is empty', 'lumea' ); ?></h2>
			<p><?php esc_html_e( 'Tap the heart icon on products you love and they will appear here.', 'lumea' ); ?></p>
			<a href="<?php echo esc_url( $shop_url ); ?>" class="lumea-wishlist-page-continue"><?php esc_html_e( 'Shop Products', 'lumea' ); ?></a>
		</div>
	</section>

	<?php if ( class_exists( 'WooCommerce' ) ) : ?>
	<?php
	$similar_query = new WP_Query(
		array(
			'post_type'      => 'product',
			'post_status'    => 'publish',
			'posts_per_page' => 4,
			'orderby'        => 'rand',
		)
	);
	?>
	<section class="lumea-wishlist-similar" aria-label="<?php esc_attr_e( 'Similar products', 'lumea' ); ?>">
		<div class="lumea-container">
			<div class="lumea-wishlist-similar-head">
				<p class="lumea-latest-eyebrow"><?php esc_html_e( 'Discover More', 'lumea' ); ?></p>
				<h2 class="lumea-latest-title"><?php esc_html_e( 'Similar Items', 'lumea' ); ?></h2>
			</div>

			<?php if ( $similar_query->have_posts() ) : ?>
			<div class="lumea-latest-grid lumea-wishlist-similar-grid">
				<?php while ( $similar_query->have_posts() ) : ?>
					<?php
					$similar_query->the_post();
					$similar_product = wc_get_product( get_the_ID() );
					if ( function_exists( 'lumea_render_product_card' ) ) {
						lumea_render_product_card(
							$similar_product,
							array(
								'badge'          => $similar_product && $similar_product->is_on_sale() ? __( 'Sale', 'lumea' ) : __( 'New', 'lumea' ),
								'button_class'   => 'lumea-lp-btn',
								'button_label'   => __( 'Add to Cart', 'lumea' ),
								'fallback_label' => __( 'Shop Now', 'lumea' ),
							)
						);
					}
					?>
				<?php endwhile; ?>
			</div>
			<?php else : ?>
			<p class="lumea-wishlist-similar-empty"><?php esc_html_e( 'More products are coming soon.', 'lumea' ); ?></p>
			<?php endif; ?>

			<?php wp_reset_postdata(); ?>
		</div>
	</section>
	<?php endif; ?>
</main>

<?php
get_footer();
