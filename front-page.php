<?php
/**
 * Front page template — standalone (manages its own document).
 * wp_head() and wp_footer() are called directly so all plugins work.
 *
 * @package Lumea
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<section class="hero" id="hero-home">
	<div class="hero-canvas-wrap">
		<canvas id="heroCanvas"></canvas>
	</div>

	<div class="hero-content">
		<div class="topbar">
			<div class="brand-pill">
				<span>LUMÉA</span>
				<span class="menu-icon" aria-hidden="true">
					<span></span>
					<span></span>
				</span>
			</div>
		</div>

		<h3 class="hero-label">Glow</h3>

		<div class="subtitles">
			<span><?php esc_html_e( 'Skincare', 'lumea' ); ?></span>
			<span><?php esc_html_e( 'Cosmetics', 'lumea' ); ?></span>
			<span><?php esc_html_e( 'Beauty', 'lumea' ); ?></span>
		</div>

		<div class="corner-mark" aria-hidden="true"></div>

		<h1 class="hero-title">LUMÉA</h1>

		<div class="cta-wrap">
			<a href="<?php echo esc_url( class_exists( 'WooCommerce' ) ? wc_get_page_permalink( 'shop' ) : '#' ); ?>"
			   class="cta">
				<span><?php esc_html_e( 'Shop Collection', 'lumea' ); ?></span>
				<span class="cta-plus" aria-hidden="true">+</span>
			</a>
		</div>
	</div>
</section>

<!-- Products Section Intro -->
<div class="lumea-products-intro">
	<div class="lumea-container">
		<span class="lumea-eyebrow"><?php esc_html_e( 'Editorial Collection', 'lumea' ); ?></span>
		<h2 class="lumea-products-title"><?php esc_html_e( 'The Edit', 'lumea' ); ?></h2>
		<p class="lumea-products-desc"><?php esc_html_e( 'Curated botanicals and skin-first formulas for luminous, everyday beauty.', 'lumea' ); ?></p>
	</div>
</div>

<!-- Editorial Product Slider -->
<section class="lumea-slider-section" aria-label="<?php esc_attr_e( 'Luméa editorial product drops', 'lumea' ); ?>">
	<div class="lumea-slider-stage is-loading" id="lumeaSlider">
		<div class="lumea-slides" id="lumeaSlides"></div>

		<div class="lumea-hit-area" aria-hidden="true">
			<button type="button" data-direction="prev"></button>
			<button type="button" data-direction="next"></button>
		</div>

		<article class="lumea-content-card" id="lumeaCard">
			<div class="lumea-card-body">
				<span class="lumea-slide-number" id="lumeaNumber">01</span>
				<p class="lumea-card-text" id="lumeaText">
					<?php esc_html_e( 'Botanical skincare rituals designed for luminous skin, soft texture, and everyday radiance.', 'lumea' ); ?>
				</p>
			</div>
			<a href="<?php echo esc_url( class_exists( 'WooCommerce' ) ? wc_get_page_permalink( 'shop' ) : '#' ); ?>"
			   class="lumea-card-button"><?php esc_html_e( 'Shop All', 'lumea' ); ?></a>
		</article>

		<div class="lumea-mobile-arrows" aria-label="<?php esc_attr_e( 'Slider controls', 'lumea' ); ?>">
			<button type="button" class="lumea-mobile-arrow lumea-mobile-arrow--prev" data-direction="prev"
			        aria-label="<?php esc_attr_e( 'Previous slide', 'lumea' ); ?>"></button>
			<button type="button" class="lumea-mobile-arrow lumea-mobile-arrow--next" data-direction="next"
			        aria-label="<?php esc_attr_e( 'Next slide', 'lumea' ); ?>"></button>
		</div>

		<div class="lumea-cursor-arrow" id="lumeaCursorArrow" aria-hidden="true"></div>
	</div>
</section>

<?php wp_footer(); ?>
</body>
</html>
