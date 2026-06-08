<?php
/**
 * 404 page — Luméa premium edition.
 *
 * @package Lumea
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>

<main class="lumea-404-page" id="lumeaPage">

	<div class="lumea-404-inner">
		<div class="lumea-404-visual" aria-hidden="true">
			<svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/><line x1="11" y1="8" x2="11" y2="14"/><line x1="8" y1="11" x2="14" y2="11"/></svg>
		</div>
		<p class="lumea-cart-eyebrow"><?php esc_html_e( '404 — Not Found', 'lumea' ); ?></p>
		<h1 class="lumea-404-title"><?php esc_html_e( 'Page not found', 'lumea' ); ?></h1>
		<p class="lumea-404-text">
			<?php esc_html_e( 'The page you were looking for has moved, or perhaps it never existed. Let’s get you back to something beautiful.', 'lumea' ); ?>
		</p>
		<div class="lumea-404-actions">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="lumea-404-btn lumea-404-btn--primary">
				<?php esc_html_e( 'Back to Home', 'lumea' ); ?>
			</a>
			<a href="<?php echo esc_url( lumea_get_shop_url() ); ?>" class="lumea-404-btn lumea-404-btn--outline">
				<?php esc_html_e( 'Shop the Collection', 'lumea' ); ?>
			</a>
		</div>
	</div>

</main>

<?php get_footer(); ?>
