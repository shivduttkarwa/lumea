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

/* ── Helper: product tile URL ─────────────────────────────── */
function lumea_product_url( $setting_key ) {
	$custom = get_theme_mod( $setting_key, '' );
	if ( $custom ) {
		return esc_url( $custom );
	}
	return esc_url( class_exists( 'WooCommerce' ) ? wc_get_page_permalink( 'shop' ) : '#' );
}

$shop_url = esc_url( class_exists( 'WooCommerce' ) ? wc_get_page_permalink( 'shop' ) : '#' );
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

		<h3 class="hero-label"><?php echo esc_html( get_theme_mod( 'lumea_hero_label', 'Glow' ) ); ?></h3>

		<div class="subtitles">
			<span><?php echo esc_html( get_theme_mod( 'lumea_hero_subtitle_1', 'Skincare' ) ); ?></span>
			<span><?php echo esc_html( get_theme_mod( 'lumea_hero_subtitle_2', 'Cosmetics' ) ); ?></span>
			<span><?php echo esc_html( get_theme_mod( 'lumea_hero_subtitle_3', 'Beauty' ) ); ?></span>
		</div>

		<div class="corner-mark" aria-hidden="true"></div>

		<h1 class="hero-title">LUMÉA</h1>

		<div class="cta-wrap">
			<a href="<?php echo $shop_url; ?>" class="cta">
				<span><?php echo esc_html( get_theme_mod( 'lumea_hero_cta_text', 'Shop Collection' ) ); ?></span>
				<span class="cta-plus" aria-hidden="true">+</span>
			</a>
		</div>
	</div>
</section>

<!-- Section Intro: Editorial Slider -->
<div class="lumea-section-intro">
	<div class="lumea-container">
		<span class="lumea-eyebrow"><?php echo esc_html( get_theme_mod( 'lumea_slider_eyebrow', 'Editorial Collection' ) ); ?></span>
		<h2 class="lumea-section-title"><?php echo esc_html( get_theme_mod( 'lumea_slider_title', 'The Edit' ) ); ?></h2>
		<p class="lumea-section-desc"><?php echo esc_html( get_theme_mod( 'lumea_slider_desc', 'Curated botanicals and skin-first formulas for luminous, everyday beauty.' ) ); ?></p>
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
					<?php echo esc_html( get_theme_mod( 'lumea_slide_1_text', 'Botanical skincare rituals designed for luminous skin, soft texture, and everyday radiance.' ) ); ?>
				</p>
			</div>
			<a href="<?php echo $shop_url; ?>"
			   class="lumea-card-button"><?php echo esc_html( get_theme_mod( 'lumea_slider_cta_text', 'Shop All' ) ); ?></a>
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

<!-- Section Intro: Curated Glow -->
<div class="lumea-section-intro">
	<div class="lumea-container">
		<span class="lumea-eyebrow"><?php echo esc_html( get_theme_mod( 'lumea_curated_eyebrow', 'Bestsellers' ) ); ?></span>
		<h2 class="lumea-section-title"><?php echo esc_html( get_theme_mod( 'lumea_curated_title', 'Curated Glow' ) ); ?></h2>
		<p class="lumea-section-desc"><?php echo esc_html( get_theme_mod( 'lumea_curated_desc', 'Handpicked essentials for a luminous, skin-first daily ritual.' ) ); ?></p>
	</div>
</div>

<!-- Curated Glow Section -->
<section class="lumea-curated">
	<div class="lumea-curated-row">

		<?php
		// Product 1
		$p1_image = get_theme_mod( 'lumea_product1_image', LUMEA_THEME_URI . '/assets/images/hero1.jpg' );
		$p1_name  = get_theme_mod( 'lumea_product1_name',  'Radiance Serum' );
		$p1_price = get_theme_mod( 'lumea_product1_price', '$48.00' );
		$p1_desc  = get_theme_mod( 'lumea_product1_desc',  'A lightweight botanical serum for dewy, luminous, everyday skin.' );
		$p1_url   = lumea_product_url( 'lumea_product1_url' );
		?>
		<a class="lumea-product-tile" href="<?php echo $p1_url; ?>">
			<div class="lumea-product-image-wrap">
				<img
					class="lumea-product-image"
					src="<?php echo esc_url( $p1_image ); ?>"
					alt="<?php echo esc_attr( $p1_name ); ?>"
				/>
			</div>
			<div class="lumea-bottom-overlay"></div>
			<div class="lumea-product-info">
				<div class="lumea-product-meta">
					<h3 class="lumea-product-name"><?php echo esc_html( $p1_name ); ?></h3>
					<p class="lumea-product-price"><?php echo esc_html( $p1_price ); ?></p>
					<p class="lumea-product-desc"><?php echo esc_html( $p1_desc ); ?></p>
				</div>
				<div class="lumea-buy-wrap">
					<span class="lumea-buy-button"><?php esc_html_e( 'Shop Now', 'lumea' ); ?></span>
				</div>
			</div>
		</a>

		<?php
		// Product 2
		$p2_image = get_theme_mod( 'lumea_product2_image', LUMEA_THEME_URI . '/assets/images/her02.jpg' );
		$p2_name  = get_theme_mod( 'lumea_product2_name',  'Velvet Cream' );
		$p2_price = get_theme_mod( 'lumea_product2_price', '$42.00' );
		$p2_desc  = get_theme_mod( 'lumea_product2_desc',  'Rich daily moisture with a soft-touch finish and botanical comfort.' );
		$p2_url   = lumea_product_url( 'lumea_product2_url' );
		?>
		<a class="lumea-product-tile" href="<?php echo $p2_url; ?>">
			<div class="lumea-product-image-wrap">
				<img
					class="lumea-product-image"
					src="<?php echo esc_url( $p2_image ); ?>"
					alt="<?php echo esc_attr( $p2_name ); ?>"
				/>
			</div>
			<div class="lumea-bottom-overlay"></div>
			<div class="lumea-product-info">
				<div class="lumea-product-meta">
					<h3 class="lumea-product-name"><?php echo esc_html( $p2_name ); ?></h3>
					<p class="lumea-product-price"><?php echo esc_html( $p2_price ); ?></p>
					<p class="lumea-product-desc"><?php echo esc_html( $p2_desc ); ?></p>
				</div>
				<div class="lumea-buy-wrap">
					<span class="lumea-buy-button"><?php esc_html_e( 'Shop Now', 'lumea' ); ?></span>
				</div>
			</div>
		</a>

	</div>
</section>

<!-- The Ritual Section -->
<?php
$ritual_steps = array(
	1 => array(
		'id'    => 'lumea-cleanse',
		'title' => get_theme_mod( 'lumea_ritual_step1_title', 'Cleanse' ),
		'text'  => get_theme_mod( 'lumea_ritual_step1_text', 'Begin with pure intention. Our gentle botanical cleansers dissolve impurities without stripping the skin\'s natural balance, leaving a fresh, receptive canvas.' ),
	),
	2 => array(
		'id'    => 'lumea-tone',
		'title' => get_theme_mod( 'lumea_ritual_step2_title', 'Tone & Prep' ),
		'text'  => get_theme_mod( 'lumea_ritual_step2_text', 'Restore skin\'s equilibrium. Botanical tonics and essence waters refine pores, balance pH, and prime skin to absorb every active that follows.' ),
	),
	3 => array(
		'id'    => 'lumea-treat',
		'title' => get_theme_mod( 'lumea_ritual_step3_title', 'Treat & Correct' ),
		'text'  => get_theme_mod( 'lumea_ritual_step3_text', 'Targeted actives where they matter most. Concentrated serums address luminosity, firmness, and even tone at the cellular level.' ),
	),
	4 => array(
		'id'    => 'lumea-restore',
		'title' => get_theme_mod( 'lumea_ritual_step4_title', 'Restore & Protect' ),
		'text'  => get_theme_mod( 'lumea_ritual_step4_text', 'Seal the ritual with nourishment. Rich creams and facial oils lock in actives, rebuild the moisture barrier, and leave skin visibly calm, plump, and glowing.' ),
	),
);
$ritual_img_defaults = array(
	1 => array( 'lumea-cleanse', LUMEA_THEME_URI . '/assets/images/ritual/a1.jpg', LUMEA_THEME_URI . '/assets/images/ritual/a2.jpg' ),
	2 => array( 'lumea-tone',    LUMEA_THEME_URI . '/assets/images/ritual/b1.jpg', LUMEA_THEME_URI . '/assets/images/ritual/b2.jpg' ),
	3 => array( 'lumea-treat',   LUMEA_THEME_URI . '/assets/images/ritual/c1.jpg',    LUMEA_THEME_URI . '/assets/images/ritual/c2.jpg' ),
	4 => array( 'lumea-restore', LUMEA_THEME_URI . '/assets/images/ritual/d1.jpg',   LUMEA_THEME_URI . '/assets/images/ritual/d2.jpg' ),
);
?>
<section class="lumea-ritual" id="lumeaRitual" aria-label="<?php esc_attr_e( 'Luméa skincare ritual', 'lumea' ); ?>">

	<!-- Desktop -->
	<div class="lumea-ritual-desktop">

		<aside class="lumea-ritual-left">
			<h2 class="lumea-ritual-heading">
				<?php echo esc_html( get_theme_mod( 'lumea_ritual_heading_1', 'your daily' ) ); ?>
				<em><?php echo esc_html( get_theme_mod( 'lumea_ritual_heading_2', 'skin ritual' ) ); ?></em>
			</h2>
			<p class="lumea-ritual-intro">
				<?php echo esc_html( get_theme_mod( 'lumea_ritual_intro', 'Four intentional steps, one luminous result. A complete routine designed around the skin you have.' ) ); ?>
			</p>
			<div class="lumea-ritual-accordion">
				<?php foreach ( $ritual_steps as $n => $step ) : ?>
				<div class="lumea-ritual-acc<?php echo $n === 1 ? ' is-active' : ''; ?>" data-target="<?php echo esc_attr( $step['id'] ); ?>">
					<button class="lumea-ritual-acc-head" type="button">
						<span class="lumea-ritual-acc-title"><?php echo esc_html( $step['title'] ); ?></span>
					</button>
					<div class="lumea-ritual-panel">
						<p><?php echo esc_html( $step['text'] ); ?></p>
					</div>
				</div>
				<?php endforeach; ?>
			</div>
		</aside>

		<div class="lumea-ritual-right">
			<div class="lumea-ritual-image-stack">
				<?php foreach ( $ritual_img_defaults as $n => $grp ) :
					$img1 = esc_url( get_theme_mod( 'lumea_ritual_step' . $n . '_image1', $grp[1] ) );
					$img2 = esc_url( get_theme_mod( 'lumea_ritual_step' . $n . '_image2', $grp[2] ) );
				?>
				<div class="lumea-ritual-image-group" id="<?php echo esc_attr( $grp[0] ); ?>">
					<div class="lumea-ritual-image-wrap">
						<img src="<?php echo $img1; ?>" alt="<?php echo esc_attr( $ritual_steps[ $n ]['title'] ); ?> skincare step" loading="lazy" />
					</div>
					<div class="lumea-ritual-image-wrap">
						<img src="<?php echo $img2; ?>" alt="<?php echo esc_attr( $ritual_steps[ $n ]['title'] ); ?> ritual detail" loading="lazy" />
					</div>
				</div>
				<?php endforeach; ?>
			</div>
		</div>

	</div>

	<!-- Mobile -->
	<div class="lumea-ritual-mobile">
		<h2 class="lumea-ritual-heading">
			<?php echo esc_html( get_theme_mod( 'lumea_ritual_heading_1', 'your daily' ) ); ?>
			<em><?php echo esc_html( get_theme_mod( 'lumea_ritual_heading_2', 'skin ritual' ) ); ?></em>
		</h2>
		<p class="lumea-ritual-intro">
			<?php echo esc_html( get_theme_mod( 'lumea_ritual_intro', 'Four intentional steps, one luminous result. A complete routine designed around the skin you have.' ) ); ?>
		</p>
		<div class="lumea-ritual-mobile-list">
			<?php foreach ( $ritual_steps as $n => $step ) :
				$img1 = esc_url( get_theme_mod( 'lumea_ritual_step' . $n . '_image1', $ritual_img_defaults[ $n ][1] ) );
			?>
			<article class="lumea-ritual-mobile-card">
				<img src="<?php echo $img1; ?>" alt="<?php echo esc_attr( $step['title'] ); ?>" loading="lazy" />
				<div>
					<h3 class="lumea-ritual-mobile-title"><?php echo esc_html( $step['title'] ); ?></h3>
					<p class="lumea-ritual-mobile-text"><?php echo esc_html( $step['text'] ); ?></p>
				</div>
			</article>
			<?php endforeach; ?>
		</div>
	</div>

</section>

<!-- Manifest Section -->
<?php
$manifest_bg = get_theme_mod( 'lumea_manifest_image', LUMEA_THEME_URI . '/assets/images/he.jpg' );
$kicker_1    = get_theme_mod( 'lumea_manifest_kicker_1', '.make your skin comfortable' );
$kicker_2    = get_theme_mod( 'lumea_manifest_kicker_2', 'trust your glow and feel calm' );
$kicker_3    = get_theme_mod( 'lumea_manifest_kicker_3', 'in every skincare ritual+' );
$title_1     = get_theme_mod( 'lumea_manifest_title_1', 'modern ritual' );
$title_2     = get_theme_mod( 'lumea_manifest_title_2', 'for timeless' );
$title_3     = get_theme_mod( 'lumea_manifest_title_3', 'radiance' );
$title_aria  = esc_attr( $title_1 . ' ' . $title_2 . ' ' . $title_3 );
?>
<section class="lumea-manifest" id="lumeaManifest">
	<div class="lumea-manifest-bg">
		<img
			src="<?php echo esc_url( $manifest_bg ); ?>"
			alt="<?php esc_attr_e( 'Luméa skincare background', 'lumea' ); ?>"
		/>
	</div>

	<div class="lumea-manifest-content">
		<p class="lumea-kicker">
			<span class="lumea-line" data-split><?php echo esc_html( $kicker_1 ); ?></span>
			<span class="lumea-line" data-split><?php echo esc_html( $kicker_2 ); ?></span>
			<span class="lumea-line" data-split><?php echo esc_html( $kicker_3 ); ?></span>
		</p>

		<h2 class="lumea-title" aria-label="<?php echo $title_aria; ?>">
			<span class="lumea-line" data-split><?php echo esc_html( $title_1 ); ?></span>
			<span class="lumea-line" data-split><?php echo esc_html( $title_2 ); ?></span>
			<span class="lumea-line" data-split><?php echo esc_html( $title_3 ); ?></span>
		</h2>
	</div>
</section>

<?php
/* ── Footer ──────────────────────────────────────────── */
$footer_links = array(
	1 => array( get_theme_mod( 'lumea_footer_link1_label', 'Shop' ),    get_theme_mod( 'lumea_footer_link1_url', '#' ) ),
	2 => array( get_theme_mod( 'lumea_footer_link2_label', 'Journal' ), get_theme_mod( 'lumea_footer_link2_url', '#' ) ),
	3 => array( get_theme_mod( 'lumea_footer_link3_label', 'About' ),   get_theme_mod( 'lumea_footer_link3_url', '#' ) ),
	4 => array( get_theme_mod( 'lumea_footer_link4_label', 'Contact' ), get_theme_mod( 'lumea_footer_link4_url', '#' ) ),
);
$footer_ig  = get_theme_mod( 'lumea_footer_instagram', '' );
$footer_tk  = get_theme_mod( 'lumea_footer_tiktok', '' );
$footer_pin = get_theme_mod( 'lumea_footer_pinterest', '' );
?>
<footer class="lumea-footer" role="contentinfo">
	<div class="lumea-footer-inner">

		<div class="lumea-footer-top">
			<div class="lumea-footer-brand">
				<span class="lumea-footer-logo">LUMÉA</span>
				<p class="lumea-footer-tagline"><?php echo esc_html( get_theme_mod( 'lumea_footer_tagline', 'Botanical skincare for luminous living.' ) ); ?></p>
			</div>

			<nav class="lumea-footer-nav" aria-label="<?php esc_attr_e( 'Footer navigation', 'lumea' ); ?>">
				<?php foreach ( $footer_links as $link ) :
					if ( ! $link[0] ) continue; ?>
				<a href="<?php echo esc_url( $link[1] ); ?>"><?php echo esc_html( $link[0] ); ?></a>
				<?php endforeach; ?>
			</nav>
		</div>

		<div class="lumea-footer-bottom">
			<p class="lumea-footer-copy">
				&copy; <?php echo esc_html( date( 'Y' ) ); ?> <?php echo esc_html( get_theme_mod( 'lumea_footer_copy', 'Luméa. All rights reserved.' ) ); ?>
			</p>

			<?php if ( $footer_ig || $footer_tk || $footer_pin ) : ?>
			<div class="lumea-footer-social">
				<?php if ( $footer_ig ) : ?>
				<a href="<?php echo esc_url( $footer_ig ); ?>" aria-label="<?php esc_attr_e( 'Instagram', 'lumea' ); ?>" target="_blank" rel="noopener noreferrer">
					<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
						<rect x="2" y="2" width="20" height="20" rx="5" ry="5"/>
						<circle cx="12" cy="12" r="4"/>
						<circle cx="17.5" cy="6.5" r="0.6" fill="currentColor" stroke="none"/>
					</svg>
				</a>
				<?php endif; ?>
				<?php if ( $footer_tk ) : ?>
				<a href="<?php echo esc_url( $footer_tk ); ?>" aria-label="<?php esc_attr_e( 'TikTok', 'lumea' ); ?>" target="_blank" rel="noopener noreferrer">
					<svg width="17" height="17" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
						<path d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 0 1-2.88 2.5 2.89 2.89 0 0 1-2.89-2.89 2.89 2.89 0 0 1 2.89-2.89c.28 0 .54.04.79.1V9.01a6.34 6.34 0 0 0-.79-.05 6.34 6.34 0 0 0-6.34 6.34 6.34 6.34 0 0 0 6.34 6.34 6.34 6.34 0 0 0 6.33-6.34V8.69a8.22 8.22 0 0 0 4.84 1.55V6.79a4.85 4.85 0 0 1-1.07-.1z"/>
					</svg>
				</a>
				<?php endif; ?>
				<?php if ( $footer_pin ) : ?>
				<a href="<?php echo esc_url( $footer_pin ); ?>" aria-label="<?php esc_attr_e( 'Pinterest', 'lumea' ); ?>" target="_blank" rel="noopener noreferrer">
					<svg width="17" height="17" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
						<path d="M12 0C5.373 0 0 5.373 0 12c0 5.084 3.163 9.426 7.627 11.174-.105-.949-.2-2.405.042-3.441.218-.937 1.407-5.965 1.407-5.965s-.359-.719-.359-1.782c0-1.668.967-2.914 2.171-2.914 1.023 0 1.518.769 1.518 1.69 0 1.029-.655 2.568-.994 3.995-.283 1.194.599 2.169 1.777 2.169 2.133 0 3.772-2.249 3.772-5.495 0-2.873-2.064-4.882-5.012-4.882-3.414 0-5.418 2.561-5.418 5.207 0 1.031.397 2.138.893 2.738a.36.36 0 0 1 .083.345l-.333 1.36c-.053.22-.174.267-.402.161-1.499-.698-2.436-2.889-2.436-4.649 0-3.785 2.75-7.262 7.929-7.262 4.163 0 7.398 2.967 7.398 6.931 0 4.136-2.607 7.464-6.227 7.464-1.216 0-2.359-.632-2.75-1.378l-.748 2.853c-.271 1.043-1.002 2.35-1.492 3.146C9.57 23.812 10.763 24 12 24c6.627 0 12-5.373 12-12S18.627 0 12 0z"/>
					</svg>
				</a>
				<?php endif; ?>
			</div>
			<?php endif; ?>
		</div>

	</div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
