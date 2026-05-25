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
	1 => array( 'lumea-cleanse', LUMEA_THEME_URI . '/assets/images/1.jpg',    LUMEA_THEME_URI . '/assets/images/2.jpg' ),
	2 => array( 'lumea-tone',    LUMEA_THEME_URI . '/assets/images/hero.jpg', LUMEA_THEME_URI . '/assets/images/4.jpg' ),
	3 => array( 'lumea-treat',   LUMEA_THEME_URI . '/assets/images/6.jpg',    LUMEA_THEME_URI . '/assets/images/her02.jpg' ),
	4 => array( 'lumea-restore', LUMEA_THEME_URI . '/assets/images/he.jpg',   LUMEA_THEME_URI . '/assets/images/hero1.jpg' ),
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

<?php wp_footer(); ?>
</body>
</html>
