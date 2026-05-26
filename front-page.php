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

<!-- Sticky Header -->
<header class="lumea-header" id="lumeaHeader" role="banner">
	<div class="lumea-header-inner">

		<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="lumea-header-logo">LUMÉA</a>

		<nav class="lumea-header-nav" aria-label="<?php esc_attr_e( 'Primary navigation', 'lumea' ); ?>">
			<?php
			wp_nav_menu( array(
				'theme_location' => 'primary',
				'container'      => false,
				'menu_class'     => 'lumea-nav-list',
				'fallback_cb'    => function() {
					$shop_url     = wc_get_page_id( 'shop' ) ? get_permalink( wc_get_page_id( 'shop' ) ) : home_url( '/shop/' );
					$blog_url     = get_option( 'page_for_posts' ) ? get_permalink( get_option( 'page_for_posts' ) ) : home_url( '/blog/' );
					$about_page   = get_page_by_path( 'about' );
					$about_url    = $about_page ? get_permalink( $about_page ) : home_url( '/about/' );
					$contact_page = get_page_by_path( 'contact' );
					$contact_url  = $contact_page ? get_permalink( $contact_page ) : home_url( '/contact/' );
					echo '<ul class="lumea-nav-list">';
					$links = array(
						array( esc_html__( 'Shop',       'lumea' ), $shop_url ),
						array( esc_html__( 'Bestsellers','lumea' ), home_url( '/#lumeaBest' ) ),
						array( esc_html__( 'Blog',       'lumea' ), $blog_url ),
						array( esc_html__( 'About',      'lumea' ), $about_url ),
						array( esc_html__( 'Contact',    'lumea' ), $contact_url ),
					);
					foreach ( $links as $l ) {
						echo '<li><a href="' . esc_url( $l[1] ) . '">' . $l[0] . '</a></li>';
					}
					echo '</ul>';
				},
			) );
			?>
		</nav>

		<div class="lumea-header-actions">
			<?php if ( class_exists( 'WooCommerce' ) ) : ?>
			<button class="lumea-cart-trigger" aria-label="<?php esc_attr_e( 'Open cart', 'lumea' ); ?>" data-lumea-cart-trigger>
				<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 01-8 0"/></svg>
				<span class="lumea-cart-count<?php echo WC()->cart->get_cart_contents_count() ? ' lumea-cart-count--visible' : ''; ?>"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
			</button>
			<?php endif; ?>
			<button class="lumea-nav-toggle" aria-label="<?php esc_attr_e( 'Open menu', 'lumea' ); ?>" aria-expanded="false" aria-controls="lumeaMobileNav" data-lumea-nav-toggle>
				<span class="lumea-nav-toggle-bar"></span>
				<span class="lumea-nav-toggle-bar"></span>
			</button>
		</div>

	</div>
</header>

<!-- Mobile Nav -->
<div class="lumea-mobile-nav" id="lumeaMobileNav" aria-hidden="true" data-lumea-mobile-nav>
	<div class="lumea-mobile-nav-inner">
		<nav aria-label="<?php esc_attr_e( 'Mobile navigation', 'lumea' ); ?>">
			<?php
			wp_nav_menu( array(
				'theme_location' => 'primary',
				'container'      => false,
				'menu_class'     => 'lumea-mobile-nav-list',
				'fallback_cb'    => function() {
					$shop_url     = wc_get_page_id( 'shop' ) ? get_permalink( wc_get_page_id( 'shop' ) ) : home_url( '/shop/' );
					$blog_url     = get_option( 'page_for_posts' ) ? get_permalink( get_option( 'page_for_posts' ) ) : home_url( '/blog/' );
					$about_page   = get_page_by_path( 'about' );
					$about_url    = $about_page ? get_permalink( $about_page ) : home_url( '/about/' );
					$contact_page = get_page_by_path( 'contact' );
					$contact_url  = $contact_page ? get_permalink( $contact_page ) : home_url( '/contact/' );
					echo '<ul class="lumea-mobile-nav-list">';
					$links = array(
						array( esc_html__( 'Shop',       'lumea' ), $shop_url ),
						array( esc_html__( 'Bestsellers','lumea' ), home_url( '/#lumeaBest' ) ),
						array( esc_html__( 'Blog',       'lumea' ), $blog_url ),
						array( esc_html__( 'About',      'lumea' ), $about_url ),
						array( esc_html__( 'Contact',    'lumea' ), $contact_url ),
					);
					foreach ( $links as $l ) {
						echo '<li><a href="' . esc_url( $l[1] ) . '">' . $l[0] . '</a></li>';
					}
					echo '</ul>';
				},
			) );
			?>
		</nav>
	</div>
</div>

<section class="hero" id="hero-home">
	<div class="hero-canvas-wrap">
		<canvas id="heroCanvas"></canvas>
	</div>

	<div class="hero-content">

		<h3 class="hero-label"><?php echo esc_html( get_theme_mod( 'lumea_hero_label', 'Glow' ) ); ?></h3>

		<div class="subtitles">
			<span><?php echo esc_html( get_theme_mod( 'lumea_hero_subtitle_1', 'Skincare' ) ); ?></span>
			<span><?php echo esc_html( get_theme_mod( 'lumea_hero_subtitle_2', 'Cosmetics' ) ); ?></span>
			<span><?php echo esc_html( get_theme_mod( 'lumea_hero_subtitle_3', 'Beauty' ) ); ?></span>
		</div>

		<div class="corner-mark" aria-hidden="true"></div>

		<h1 class="hero-title">LUMÉA</h1>

		<div class="cta-wrap">
			<a href="<?php echo $shop_url; ?>" class="lumea-btn lumea-btn--outline"><?php echo esc_html( get_theme_mod( 'lumea_hero_cta_text', 'Shop Collection' ) ); ?></a>
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

<!-- Section Intro: Bestsellers -->
<div class="lumea-section-intro">
	<div class="lumea-container">
		<span class="lumea-eyebrow"><?php echo esc_html( get_theme_mod( 'lumea_best_eyebrow', 'Customer Favourites' ) ); ?></span>
		<h2 class="lumea-section-title"><?php echo esc_html( get_theme_mod( 'lumea_best_title', 'Shop Bestsellers' ) ); ?></h2>
		<p class="lumea-section-desc"><?php echo esc_html( get_theme_mod( 'lumea_best_desc', 'Our most-loved formulas, trusted by thousands worldwide.' ) ); ?></p>
	</div>
</div>

<!-- Bestsellers Slider -->
<?php
$lumea_best_defaults = array(
	1 => array(
		'name'        => 'Radiance Serum',
		'price'       => '$48.00',
		'badge'       => 'Serum',
		'main_image'  => LUMEA_THEME_URI . '/assets/images/bestsellers/bestsellers-main1.jpg',
		'hover_image' => LUMEA_THEME_URI . '/assets/images/bestsellers/bestsellers-hover1.jpg',
		'url'         => '',
	),
	2 => array(
		'name'        => 'Velvet Face Cream',
		'price'       => '$42.00',
		'badge'       => 'Cream',
		'main_image'  => LUMEA_THEME_URI . '/assets/images/bestsellers/bestsellers-main2.jpg',
		'hover_image' => LUMEA_THEME_URI . '/assets/images/bestsellers/bestsellers-hover2.jpg',
		'url'         => '',
	),
	3 => array(
		'name'        => 'Glow Sunscreen SPF 50',
		'price'       => '$44.00',
		'badge'       => 'SPF 50',
		'main_image'  => LUMEA_THEME_URI . '/assets/images/bestsellers/bestsellers-main3.jpg',
		'hover_image' => LUMEA_THEME_URI . '/assets/images/bestsellers/bestsellers-hover3.jpg',
		'url'         => '',
	),
	4 => array(
		'name'        => 'Luminous Glow Toner',
		'price'       => '$34.00',
		'badge'       => 'Toner',
		'main_image'  => LUMEA_THEME_URI . '/assets/images/bestsellers/bestsellers-main4.jpg',
		'hover_image' => LUMEA_THEME_URI . '/assets/images/bestsellers/bestsellers-hover4.jpg',
		'url'         => '',
	),
	5 => array(
		'name'        => 'Skin Glow Face Oil',
		'price'       => '$52.00',
		'badge'       => 'Face Oil',
		'main_image'  => LUMEA_THEME_URI . '/assets/images/bestsellers/bestsellers-main5.jpg',
		'hover_image' => LUMEA_THEME_URI . '/assets/images/bestsellers/bestsellers-hover5.jpg',
		'url'         => '',
	),
);

/* WooCommerce product query — tag: bestseller, fallback: top sellers */
$lumea_best_products = array();
if ( class_exists( 'WooCommerce' ) ) {
	$_bq = new WP_Query( array(
		'post_type'      => 'product',
		'posts_per_page' => 5,
		'post_status'    => 'publish',
		'tax_query'      => array( array(
			'taxonomy' => 'product_tag',
			'field'    => 'slug',
			'terms'    => 'bestseller',
		) ),
	) );
	if ( ! $_bq->have_posts() ) {
		$_bq = new WP_Query( array(
			'post_type'      => 'product',
			'posts_per_page' => 5,
			'post_status'    => 'publish',
			'meta_key'       => 'total_sales',
			'orderby'        => 'meta_value_num',
			'order'          => 'DESC',
		) );
	}
	while ( $_bq->have_posts() ) {
		$_bq->the_post();
		$_bp      = wc_get_product( get_the_ID() );
		$_bpgal   = $_bp->get_gallery_image_ids();
		$_bpterms = get_the_terms( get_the_ID(), 'product_cat' );
		$lumea_best_products[] = array(
			'id'          => get_the_ID(),
			'name'        => get_the_title(),
			'price'       => $_bp->get_price_html(),
			'badge'       => $_bp->is_on_sale() ? esc_html__( 'Sale', 'lumea' ) : ( ! empty( $_bpterms ) ? $_bpterms[0]->name : '' ),
			'is_sale'     => $_bp->is_on_sale(),
			'main_image'  => get_the_post_thumbnail_url( get_the_ID(), 'woocommerce_single' ),
			'hover_image' => ! empty( $_bpgal ) ? wp_get_attachment_image_url( $_bpgal[0], 'woocommerce_single' ) : '',
			'url'         => get_permalink(),
			'type'        => $_bp->get_type(),
		);
	}
	wp_reset_postdata();
}
?>
<section class="lumea-best-section" aria-label="<?php esc_attr_e( 'Shop Bestsellers', 'lumea' ); ?>">
	<div class="lumea-best-inner">
		<div class="lumea-best-slider-area">

			<div class="swiper lumea-best-swiper">
				<div class="swiper-wrapper">
					<?php
					$lumea_best_source = ( class_exists( 'WooCommerce' ) && ! empty( $lumea_best_products ) ) ? $lumea_best_products : array();
					if ( empty( $lumea_best_source ) ) :
						foreach ( $lumea_best_defaults as $n => $d ) :
							$lumea_best_source[] = array(
								'id'          => 0,
								'name'        => esc_html( get_theme_mod( 'lumea_best' . $n . '_name',        $d['name'] ) ),
								'price'       => esc_html( get_theme_mod( 'lumea_best' . $n . '_price',       $d['price'] ) ),
								'badge'       => esc_html( get_theme_mod( 'lumea_best' . $n . '_badge',       $d['badge'] ) ),
								'is_sale'     => false,
								'main_image'  => esc_url( get_theme_mod( 'lumea_best' . $n . '_main_image',  $d['main_image'] ) ),
								'hover_image' => esc_url( get_theme_mod( 'lumea_best' . $n . '_hover_image', $d['hover_image'] ) ),
								'url'         => lumea_product_url( 'lumea_best' . $n . '_url' ),
								'type'        => 'simple',
							);
						endforeach;
					endif;
					?>
					<?php foreach ( $lumea_best_source as $bp ) :
						$bp_id    = (int) $bp['id'];
						$bp_name  = esc_html( $bp['name'] );
						$bp_url   = esc_url( $bp['url'] );
						$bp_badge = $bp['badge'];
						$bp_main  = esc_url( $bp['main_image'] );
						$bp_hover = esc_url( isset( $bp['hover_image'] ) ? $bp['hover_image'] : '' );
					?>
					<div class="swiper-slide">
						<article class="lumea-best-card">
							<a href="<?php echo $bp_url; ?>" class="lumea-best-media-link">
								<?php if ( $bp_badge ) : ?>
								<span class="lumea-best-badge<?php echo ! empty( $bp['is_sale'] ) ? ' lumea-best-badge--sale' : ''; ?>" aria-hidden="true"><?php echo esc_html( $bp_badge ); ?></span>
								<?php endif; ?>
								<div class="lumea-best-media">
									<img class="lumea-best-img lumea-best-img--main" src="<?php echo $bp_main; ?>" alt="<?php echo $bp_name; ?>" loading="lazy" />
									<?php if ( $bp_hover ) : ?>
									<img class="lumea-best-img lumea-best-img--hover" src="<?php echo $bp_hover; ?>" alt="" loading="lazy" aria-hidden="true" />
									<?php endif; ?>
								</div>
							</a>
							<div class="lumea-best-info">
								<h3 class="lumea-best-name"><a href="<?php echo $bp_url; ?>"><?php echo $bp_name; ?></a></h3>
								<p class="lumea-best-price"><?php echo isset( $bp['price'] ) ? wp_kses_post( $bp['price'] ) : ''; ?></p>
								<?php if ( $bp_id && class_exists( 'WooCommerce' ) ) : ?>
								<a href="<?php echo esc_url( add_query_arg( 'add-to-cart', $bp_id, $bp_url ) ); ?>"
								   class="lumea-best-btn add_to_cart_button ajax_add_to_cart"
								   data-product_id="<?php echo $bp_id; ?>"
								   data-product_type="<?php echo esc_attr( $bp['type'] ); ?>"
								   data-quantity="1"
								   aria-label="<?php echo esc_attr( sprintf( __( 'Add %s to cart', 'lumea' ), $bp_name ) ); ?>"
								   rel="nofollow"><?php esc_html_e( 'Add to Cart', 'lumea' ); ?></a>
								<?php else : ?>
								<a href="<?php echo $bp_url; ?>" class="lumea-best-btn"><?php esc_html_e( 'Shop Now', 'lumea' ); ?></a>
								<?php endif; ?>
							</div>
						</article>
					</div>
					<?php endforeach; ?>
				</div>
			</div>

			<div class="lumea-best-nav" aria-hidden="true">
				<button class="lumea-best-nav-btn lumea-best-prev" type="button" aria-label="<?php esc_attr_e( 'Previous', 'lumea' ); ?>">
					<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M19 12H5M12 5l-7 7 7 7"/></svg>
				</button>
				<button class="lumea-best-nav-btn lumea-best-next" type="button" aria-label="<?php esc_attr_e( 'Next', 'lumea' ); ?>">
					<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
				</button>
			</div>

		</div>
	</div>
</section>




<!-- Full-Screen CTA -->
<?php
$lumea_cta_bg = get_theme_mod( 'lumea_cta_bg_image', LUMEA_THEME_URI . '/assets/images/bestsellers/cta-bg.jpg' );
?>
<section class="lumea-fullcta" aria-label="Shop all products" style="--cta-bg: url('<?php echo esc_url( $lumea_cta_bg ); ?>')">
	<div class="lumea-fullcta-overlay"></div>
	<div class="lumea-fullcta-inner">
		<p class="lumea-fullcta-eyebrow">The Collection</p>
		<h2 class="lumea-fullcta-heading">
			<?php echo esc_html( get_theme_mod( 'lumea_cta_heading_1', 'For' ) ); ?><br>
			<em><?php echo esc_html( get_theme_mod( 'lumea_cta_heading_2', 'every' ) ); ?></em><br>
			<?php echo esc_html( get_theme_mod( 'lumea_cta_heading_3', 'skin.' ) ); ?>
		</h2>
		<p class="lumea-fullcta-sub"><?php echo esc_html( get_theme_mod( 'lumea_cta_sub', 'Every formula crafted for one result — skin that looks and feels undeniably radiant.' ) ); ?></p>
		<a href="<?php echo esc_url( get_permalink( wc_get_page_id( 'shop' ) ) ); ?>" class="lumea-fullcta-btn">
			<span><?php echo esc_html( get_theme_mod( 'lumea_cta_btn', 'Shop All Products' ) ); ?></span>
			<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
		</a>
	</div>
</section>


<!-- Latest Products Section -->
<?php
$lumea_latest = array(
	1 => array(
		'name'      => get_theme_mod( 'lumea_latest1_name',      'Hydra Glow Mist' ),
		'price'     => get_theme_mod( 'lumea_latest1_price',     '$36.00' ),
		'old_price' => get_theme_mod( 'lumea_latest1_old_price', '' ),
		'badge'     => get_theme_mod( 'lumea_latest1_badge',     'New' ),
		'image'     => get_theme_mod( 'lumea_latest1_image',     LUMEA_THEME_URI . '/assets/images/bestsellers/bestsellers-main1.jpg' ),
		'hover'     => get_theme_mod( 'lumea_latest1_hover',     LUMEA_THEME_URI . '/assets/images/bestsellers/bestsellers-hover1.jpg' ),
		'url'       => get_theme_mod( 'lumea_latest1_url',       '#' ),
	),
	2 => array(
		'name'      => get_theme_mod( 'lumea_latest2_name',      'Peptide Eye Cream' ),
		'price'     => get_theme_mod( 'lumea_latest2_price',     '$48.00' ),
		'old_price' => get_theme_mod( 'lumea_latest2_old_price', '$58.00' ),
		'badge'     => get_theme_mod( 'lumea_latest2_badge',     'Sale' ),
		'image'     => get_theme_mod( 'lumea_latest2_image',     LUMEA_THEME_URI . '/assets/images/bestsellers/bestsellers-main2.jpg' ),
		'hover'     => get_theme_mod( 'lumea_latest2_hover',     LUMEA_THEME_URI . '/assets/images/bestsellers/bestsellers-hover2.jpg' ),
		'url'       => get_theme_mod( 'lumea_latest2_url',       '#' ),
	),
	3 => array(
		'name'      => get_theme_mod( 'lumea_latest3_name',      'Barrier Repair Balm' ),
		'price'     => get_theme_mod( 'lumea_latest3_price',     '$54.00' ),
		'old_price' => get_theme_mod( 'lumea_latest3_old_price', '' ),
		'badge'     => get_theme_mod( 'lumea_latest3_badge',     'New' ),
		'image'     => get_theme_mod( 'lumea_latest3_image',     LUMEA_THEME_URI . '/assets/images/bestsellers/bestsellers-main3.jpg' ),
		'hover'     => get_theme_mod( 'lumea_latest3_hover',     LUMEA_THEME_URI . '/assets/images/bestsellers/bestsellers-hover3.jpg' ),
		'url'       => get_theme_mod( 'lumea_latest3_url',       '#' ),
	),
	4 => array(
		'name'      => get_theme_mod( 'lumea_latest4_name',      'AHA Resurfacing Serum' ),
		'price'     => get_theme_mod( 'lumea_latest4_price',     '$62.00' ),
		'old_price' => get_theme_mod( 'lumea_latest4_old_price', '$72.00' ),
		'badge'     => get_theme_mod( 'lumea_latest4_badge',     '-14%' ),
		'image'     => get_theme_mod( 'lumea_latest4_image',     LUMEA_THEME_URI . '/assets/images/bestsellers/bestsellers-main4.jpg' ),
		'hover'     => get_theme_mod( 'lumea_latest4_hover',     LUMEA_THEME_URI . '/assets/images/bestsellers/bestsellers-hover4.jpg' ),
		'url'       => get_theme_mod( 'lumea_latest4_url',       '#' ),
	),
	5 => array(
		'name'      => get_theme_mod( 'lumea_latest5_name',      'Brightening Vitamin C' ),
		'price'     => get_theme_mod( 'lumea_latest5_price',     '$58.00' ),
		'old_price' => get_theme_mod( 'lumea_latest5_old_price', '' ),
		'badge'     => get_theme_mod( 'lumea_latest5_badge',     'New' ),
		'image'     => get_theme_mod( 'lumea_latest5_image',     LUMEA_THEME_URI . '/assets/images/bestsellers/bestsellers-main5.jpg' ),
		'hover'     => get_theme_mod( 'lumea_latest5_hover',     LUMEA_THEME_URI . '/assets/images/bestsellers/bestsellers-hover5.jpg' ),
		'url'       => get_theme_mod( 'lumea_latest5_url',       '#' ),
	),
	6 => array(
		'name'      => get_theme_mod( 'lumea_latest6_name',      'Niacinamide 10% Serum' ),
		'price'     => get_theme_mod( 'lumea_latest6_price',     '$42.00' ),
		'old_price' => get_theme_mod( 'lumea_latest6_old_price', '$50.00' ),
		'badge'     => get_theme_mod( 'lumea_latest6_badge',     'Sale' ),
		'image'     => get_theme_mod( 'lumea_latest6_image',     LUMEA_THEME_URI . '/assets/images/bestsellers/bestsellers-main1.jpg' ),
		'hover'     => get_theme_mod( 'lumea_latest6_hover',     LUMEA_THEME_URI . '/assets/images/bestsellers/bestsellers-hover1.jpg' ),
		'url'       => get_theme_mod( 'lumea_latest6_url',       '#' ),
	),
	7 => array(
		'name'      => get_theme_mod( 'lumea_latest7_name',      'Retinol Night Cream' ),
		'price'     => get_theme_mod( 'lumea_latest7_price',     '$66.00' ),
		'old_price' => get_theme_mod( 'lumea_latest7_old_price', '' ),
		'badge'     => get_theme_mod( 'lumea_latest7_badge',     'New' ),
		'image'     => get_theme_mod( 'lumea_latest7_image',     LUMEA_THEME_URI . '/assets/images/bestsellers/bestsellers-main2.jpg' ),
		'hover'     => get_theme_mod( 'lumea_latest7_hover',     LUMEA_THEME_URI . '/assets/images/bestsellers/bestsellers-hover2.jpg' ),
		'url'       => get_theme_mod( 'lumea_latest7_url',       '#' ),
	),
	8 => array(
		'name'      => get_theme_mod( 'lumea_latest8_name',      'Calming Rose Toner' ),
		'price'     => get_theme_mod( 'lumea_latest8_price',     '$32.00' ),
		'old_price' => get_theme_mod( 'lumea_latest8_old_price', '$38.00' ),
		'badge'     => get_theme_mod( 'lumea_latest8_badge',     '-16%' ),
		'image'     => get_theme_mod( 'lumea_latest8_image',     LUMEA_THEME_URI . '/assets/images/bestsellers/bestsellers-main3.jpg' ),
		'hover'     => get_theme_mod( 'lumea_latest8_hover',     LUMEA_THEME_URI . '/assets/images/bestsellers/bestsellers-hover3.jpg' ),
		'url'       => get_theme_mod( 'lumea_latest8_url',       '#' ),
	),
);
?>
<section class="lumea-latest" aria-label="<?php esc_attr_e( 'Latest products', 'lumea' ); ?>">
	<div class="lumea-container">

		<div class="lumea-latest-head">
			<div>
				<p class="lumea-latest-eyebrow"><?php esc_html_e( 'Just Arrived', 'lumea' ); ?></p>
				<h2 class="lumea-latest-title"><?php echo esc_html( get_theme_mod( 'lumea_latest_title', 'Latest Products' ) ); ?></h2>
			</div>
			<a href="<?php echo esc_url( get_permalink( wc_get_page_id( 'shop' ) ) ); ?>" class="lumea-latest-all">
				View all
				<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
			</a>
		</div>

		<?php
		$lumea_lp_source = array();
		if ( class_exists( 'WooCommerce' ) ) {
			$lumea_lp_query = new WP_Query( array(
				'post_type'      => 'product',
				'posts_per_page' => 8,
				'orderby'        => 'date',
				'order'          => 'DESC',
				'post_status'    => 'publish',
			) );
			while ( $lumea_lp_query->have_posts() ) {
				$lumea_lp_query->the_post();
				$_lp           = wc_get_product( get_the_ID() );
				$_lp_gallery   = $_lp->get_gallery_image_ids();
				$lumea_lp_source[] = array(
					'id'        => get_the_ID(),
					'name'      => get_the_title(),
					'price'     => $_lp->get_price_html(),
					'old_price' => $_lp->is_on_sale() ? wc_price( $_lp->get_regular_price() ) : '',
					'is_sale'   => $_lp->is_on_sale(),
					'badge'     => $_lp->is_on_sale() ? esc_html__( 'Sale', 'lumea' ) : esc_html__( 'New', 'lumea' ),
					'image'     => get_the_post_thumbnail_url( get_the_ID(), 'woocommerce_single' ),
					'hover'     => ! empty( $_lp_gallery ) ? wp_get_attachment_image_url( $_lp_gallery[0], 'woocommerce_single' ) : '',
					'url'       => get_permalink(),
					'type'      => $_lp->get_type(),
				);
			}
			wp_reset_postdata();
		}
		if ( empty( $lumea_lp_source ) ) {
			foreach ( $lumea_latest as $p ) {
				$lumea_lp_source[] = array(
					'id'        => 0,
					'name'      => $p['name'],
					'price'     => $p['price'],
					'old_price' => $p['old_price'],
					'is_sale'   => ! empty( $p['old_price'] ),
					'badge'     => $p['badge'],
					'image'     => $p['image'],
					'hover'     => $p['hover'],
					'url'       => $p['url'],
					'type'      => 'simple',
				);
			}
		}
		?>
		<div class="lumea-latest-grid">
			<?php foreach ( $lumea_lp_source as $lp ) :
				$lp_id       = (int) $lp['id'];
				$lp_name     = esc_html( $lp['name'] );
				$lp_url      = esc_url( $lp['url'] );
				$lp_badge    = $lp['badge'];
				$lp_is_sale  = ! empty( $lp['is_sale'] );
				$lp_old      = $lp['old_price'];
				$lp_img      = esc_url( $lp['image'] );
				$lp_hover    = esc_url( $lp['hover'] );
			?>
			<article class="lumea-lp-card">
				<a href="<?php echo $lp_url; ?>" class="lumea-lp-media">
					<?php if ( $lp_badge ) : ?>
					<span class="lumea-lp-badge<?php echo $lp_is_sale ? ' lumea-lp-badge--sale' : ''; ?>"><?php echo esc_html( $lp_badge ); ?></span>
					<?php endif; ?>
					<img src="<?php echo $lp_img; ?>" alt="<?php echo $lp_name; ?>" class="lumea-lp-img lumea-lp-img--main" loading="lazy" />
					<?php if ( $lp_hover ) : ?>
					<img src="<?php echo $lp_hover; ?>" alt="" class="lumea-lp-img lumea-lp-img--hover" loading="lazy" aria-hidden="true" />
					<?php endif; ?>
				</a>
				<div class="lumea-lp-body">
					<h3 class="lumea-lp-name"><a href="<?php echo $lp_url; ?>"><?php echo $lp_name; ?></a></h3>
					<div class="lumea-lp-pricing">
						<?php if ( $lp_is_sale && $lp_old ) : ?>
						<s class="lumea-lp-old"><?php echo wp_kses_post( $lp_old ); ?></s>
						<?php endif; ?>
						<span class="lumea-lp-price<?php echo $lp_is_sale ? ' lumea-lp-price--sale' : ''; ?>"><?php echo wp_kses_post( $lp['price'] ); ?></span>
					</div>
					<?php if ( $lp_id && class_exists( 'WooCommerce' ) ) : ?>
					<a href="<?php echo esc_url( add_query_arg( 'add-to-cart', $lp_id, $lp_url ) ); ?>"
					   class="lumea-lp-btn add_to_cart_button ajax_add_to_cart"
					   data-product_id="<?php echo $lp_id; ?>"
					   data-product_type="<?php echo esc_attr( $lp['type'] ); ?>"
					   data-quantity="1"
					   aria-label="<?php echo esc_attr( sprintf( __( 'Add %s to cart', 'lumea' ), $lp_name ) ); ?>"
					   rel="nofollow"><?php esc_html_e( 'Add to Cart', 'lumea' ); ?></a>
					<?php else : ?>
					<a href="<?php echo $lp_url; ?>" class="lumea-lp-btn"><?php esc_html_e( 'Shop Now', 'lumea' ); ?></a>
					<?php endif; ?>
				</div>
			</article>
			<?php endforeach; ?>
		</div>

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
				$img2 = esc_url( get_theme_mod( 'lumea_ritual_step' . $n . '_image2', $ritual_img_defaults[ $n ][2] ) );
			?>
			<article class="lumea-ritual-mobile-card">
				<div class="lumea-ritual-xfade-wrap">
					<img src="<?php echo $img1; ?>" alt="<?php echo esc_attr( $step['title'] ); ?>" class="lumea-ritual-xfade lumea-ritual-xfade--a" loading="lazy" />
					<img src="<?php echo $img2; ?>" alt="" class="lumea-ritual-xfade lumea-ritual-xfade--b" loading="lazy" aria-hidden="true" />
				</div>
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


<?php if ( class_exists( 'WooCommerce' ) ) : ?>
<!-- Cart Drawer -->
<div class="lumea-cart-overlay" data-lumea-cart-overlay aria-hidden="true"></div>
<aside class="lumea-cart-drawer" id="lumeaCartDrawer" aria-label="<?php esc_attr_e( 'Shopping cart', 'lumea' ); ?>" aria-hidden="true" data-lumea-cart-drawer>
	<div class="lumea-drawer-head">
		<h2 class="lumea-drawer-title"><?php esc_html_e( 'Your Cart', 'lumea' ); ?></h2>
		<button class="lumea-drawer-close" aria-label="<?php esc_attr_e( 'Close cart', 'lumea' ); ?>" data-lumea-cart-close>
			<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
		</button>
	</div>
	<div class="lumea-drawer-body">
		<?php lumea_mini_cart_items(); ?>
	</div>
	<?php if ( ! WC()->cart->is_empty() ) : ?>
	<div class="lumea-drawer-footer">
		<div class="lumea-drawer-subtotal">
			<span><?php esc_html_e( 'Subtotal', 'lumea' ); ?></span>
			<span><?php echo WC()->cart->get_cart_subtotal(); ?></span>
		</div>
		<a href="<?php echo esc_url( wc_get_cart_url() ); ?>" class="lumea-drawer-cart-btn"><?php esc_html_e( 'View Cart', 'lumea' ); ?></a>
		<a href="<?php echo esc_url( wc_get_checkout_url() ); ?>" class="lumea-drawer-checkout-btn"><?php esc_html_e( 'Checkout', 'lumea' ); ?></a>
	</div>
	<?php endif; ?>
</aside>
<?php endif; ?>

<?php wp_footer(); ?>
</body>
</html>
