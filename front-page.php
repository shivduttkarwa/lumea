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

<?php wp_footer(); ?>
</body>
</html>
