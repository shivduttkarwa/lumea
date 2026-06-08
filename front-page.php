<?php
/**
 * Front page template.
 * Uses shared header/footer templates for consistent global UI.
 *
 * @package Lumea
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


$shop_url = esc_url( lumea_get_shop_url() );
?>
<?php get_header(); ?>

<main id="lumeaPage">

<section class="hero d-flex align-items-stretch" id="hero-home">
	<div class="hero-canvas-wrap">
		<canvas id="heroCanvas"></canvas>
	</div>

	<div class="hero-content container-fluid px-3 px-sm-4 px-lg-5">
		<div class="row h-100">
			<div class="col-12 position-relative">

		<h3 class="hero-label" id="heroLabel" data-lumea-hero-label><?php echo esc_html( get_theme_mod( 'lumea_hero_label', 'Glow' ) ); ?></h3>

		<div class="subtitles">
			<span><?php echo esc_html( get_theme_mod( 'lumea_hero_subtitle_1', 'Skincare' ) ); ?></span>
			<span><?php echo esc_html( get_theme_mod( 'lumea_hero_subtitle_2', 'Cosmetics' ) ); ?></span>
			<span><?php echo esc_html( get_theme_mod( 'lumea_hero_subtitle_3', 'Beauty' ) ); ?></span>
		</div>

		<h1 class="hero-title">LUMÉA</h1>

		<div class="cta-wrap">
			<?php lumea_btn( array(
				'label' => get_theme_mod( 'lumea_hero_cta_text', 'Shop Collection' ),
				'href'  => $shop_url,
				'style' => 'outline',
			) ); ?>
		</div>
			</div>
		</div>
	</div>
</section>

<!-- Section Intro: Editorial Slider -->
<div class="lumea-section-intro lumea-section-intro-js">
	<div class="lumea-container-wide container-fluid">
		<div class="row">
			<div class="col-12 col-xl-10">
				<span class="lumea-eyebrow"><?php echo esc_html( get_theme_mod( 'lumea_slider_eyebrow', 'Editorial Collection' ) ); ?></span>
				<h2 class="lumea-section-title"><?php echo esc_html( get_theme_mod( 'lumea_slider_title', 'The Edit' ) ); ?></h2>
				<p class="lumea-section-desc"><?php echo esc_html( get_theme_mod( 'lumea_slider_desc', 'Curated botanicals and skin-first formulas for luminous, everyday beauty.' ) ); ?></p>
			</div>
		</div>
	</div>
</div>

<!-- Editorial Product Slider -->
<section class="lumea-slider-section container-fluid px-0" aria-label="<?php esc_attr_e( 'Luméa editorial product drops', 'lumea' ); ?>">
	<div class="lumea-slider-stage is-loading" id="lumeaSlider">
		<div class="lumea-slides" id="lumeaSlides"></div>

		<div class="lumea-hit-area" aria-hidden="true">
			<button type="button" data-direction="prev"></button>
			<button type="button" data-direction="next"></button>
		</div>

		<article class="lumea-content-card" id="lumeaCard">
			<div class="lumea-card-body">
				<span class="lumea-slide-number lumea-reveal-js lumea-reveal--static-js" id="lumeaNumber">01</span>
				<p class="lumea-card-text lumea-reveal-js lumea-reveal--static-js" id="lumeaText">
					<?php echo esc_html( get_theme_mod( 'lumea_slide_1_text', 'Botanical skincare rituals designed for luminous skin, soft texture, and everyday radiance.' ) ); ?>
				</p>
			</div>
			<a href="<?php echo esc_url( $shop_url ); ?>"
			   id="lumeaCardButton"
			   class="lumea-card-button lumea-reveal-js lumea-reveal--static-js"><?php esc_html_e( 'Shop Now', 'lumea' ); ?></a>
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
<div class="lumea-section-intro lumea-section-intro-js">
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
		
		$p1_image = get_theme_mod( 'lumea_product1_image', LUMEA_THEME_URI . '/assets/images/hero1.jpg' );
		$p1_name  = get_theme_mod( 'lumea_product1_name',  'Radiance Serum' );
		$p1_price = get_theme_mod( 'lumea_product1_price', '$48.00' );
		$p1_desc  = get_theme_mod( 'lumea_product1_desc',  'A lightweight botanical serum for dewy, luminous, everyday skin.' );
		$p1_url   = lumea_product_url( 'lumea_product1_url' );
		?>
		<a class="lumea-product-tile" href="<?php echo esc_url( $p1_url ); ?>">
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
					<span class="lumea-btn btn-white"><?php esc_html_e( 'Shop Now', 'lumea' ); ?></span>
				</div>
			</div>
		</a>

		<?php
		
		$p2_image = get_theme_mod( 'lumea_product2_image', LUMEA_THEME_URI . '/assets/images/her02.jpg' );
		$p2_name  = get_theme_mod( 'lumea_product2_name',  'Velvet Cream' );
		$p2_price = get_theme_mod( 'lumea_product2_price', '$42.00' );
		$p2_desc  = get_theme_mod( 'lumea_product2_desc',  'Rich daily moisture with a soft-touch finish and botanical comfort.' );
		$p2_url   = lumea_product_url( 'lumea_product2_url' );
		?>
		<a class="lumea-product-tile" href="<?php echo esc_url( $p2_url ); ?>">
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
					<span class="lumea-btn btn-white"><?php esc_html_e( 'Shop Now', 'lumea' ); ?></span>
				</div>
			</div>
		</a>

	</div>
</section>

<!-- Section Intro: Bestsellers -->
<div class="lumea-section-intro lumea-section-intro-js">
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


$lumea_best_products = array();
if ( class_exists( 'WooCommerce' ) ) {
	$_bq = new WP_Query( array(
		'post_type'      => 'product',
		'posts_per_page' => 5,
		'post_status'    => 'publish',
		'meta_query'     => array( array(
			'key'   => '_lumea_is_bestseller',
			'value' => 'yes',
		) ),
	) );

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
			'can_add_to_cart' => $_bp->is_purchasable() && $_bp->is_in_stock(),
			'supports_ajax'   => $_bp->supports( 'ajax_add_to_cart' ) && $_bp->is_purchasable() && $_bp->is_in_stock(),
		);
	}
	wp_reset_postdata();
}
?>
<section class="lumea-best-section" aria-label="<?php esc_attr_e( 'Shop Bestsellers', 'lumea' ); ?>">
	<div class="lumea-best-inner container-fluid px-3 px-sm-4 px-lg-5">
		<div class="lumea-best-slider-area row gx-0">
			<div class="col-12">

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
						$bp_name_raw = wp_strip_all_tags( (string) $bp['name'] );
						$bp_name  = esc_html( $bp_name_raw );
						$bp_url   = esc_url( $bp['url'] );
						$bp_badge = $bp['badge'];
						$bp_main  = esc_url( $bp['main_image'] );
						$bp_hover = esc_url( isset( $bp['hover_image'] ) ? $bp['hover_image'] : '' );
					?>
					<div class="swiper-slide">
						<article class="lumea-best-card lumea-reveal-js lumea-reveal--static-js">
							<div class="lumea-card-media-wrap">
							<a href="<?php echo esc_url( $bp_url ); ?>" class="lumea-best-media-link">
								<?php if ( $bp_badge ) : ?>
								<span class="lumea-best-badge<?php echo ! empty( $bp['is_sale'] ) ? ' lumea-best-badge--sale' : ''; ?>" aria-hidden="true"><?php echo esc_html( $bp_badge ); ?></span>
								<?php endif; ?>
								<div class="lumea-best-media">
									<img class="lumea-best-img lumea-best-img--main" src="<?php echo esc_url( $bp_main ); ?>" alt="<?php echo esc_attr( $bp_name ); ?>" loading="lazy" />
									<?php if ( $bp_hover ) : ?>
									<img class="lumea-best-img lumea-best-img--hover" src="<?php echo esc_url( $bp_hover ); ?>" alt="" loading="lazy" aria-hidden="true" />
									<?php endif; ?>
								</div>
							</a>
							</div>
							<div class="lumea-best-info">
								<div class="lumea-best-title-row">
									<h3 class="lumea-best-name"><a href="<?php echo esc_url( $bp_url ); ?>"><?php echo esc_html( $bp_name ); ?></a></h3>
									<button class="lumea-wish-btn" type="button" aria-label="<?php esc_attr_e( 'Add to wishlist', 'lumea' ); ?>" data-lumea-wish data-product_id="<?php echo esc_attr( $bp_id ); ?>">
										<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
									</button>
								</div>
								<p class="lumea-best-price"><?php echo isset( $bp['price'] ) ? wp_kses_post( $bp['price'] ) : ''; ?></p>
								<?php if ( $bp_id && class_exists( 'WooCommerce' ) && function_exists( 'lumea_render_product_card_actions' ) ) : ?>
									<?php
									lumea_render_product_card_actions(
										array(
											'product_id'      => $bp_id,
											'product_url'     => $bp_url,
											'product_name'    => $bp_name_raw,
											'product_type'    => isset( $bp['type'] ) ? $bp['type'] : 'simple',
											'button_class'    => 'lumea-btn btn-black',
											'button_label'    => __( 'Add to Cart', 'lumea' ),
											'fallback_label'  => __( 'Shop Now', 'lumea' ),
											'can_add_to_cart' => isset( $bp['can_add_to_cart'] ) ? (bool) $bp['can_add_to_cart'] : true,
											'supports_ajax'   => isset( $bp['supports_ajax'] ) ? (bool) $bp['supports_ajax'] : true,
										)
									);
									?>
								<?php else : ?>
								<div class="lumea-card-actions">
									<a href="<?php echo esc_url( $bp_url ); ?>" class="lumea-btn btn-black"><?php esc_html_e( 'Shop Now', 'lumea' ); ?></a>
								</div>
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
	</div>
</section>




<!-- Full-Screen CTA -->
<?php
$lumea_cta_bg = get_theme_mod( 'lumea_cta_bg_image', LUMEA_THEME_URI . '/assets/images/bestsellers/cta-bg.jpg' );
?>
<section class="lumea-fullcta" aria-label="<?php esc_attr_e( 'Shop all products', 'lumea' ); ?>" style="--cta-bg: url('<?php echo esc_url( $lumea_cta_bg ); ?>')">
	<div class="lumea-fullcta-overlay"></div>
	<div class="lumea-fullcta-inner">
		<h2 class="lumea-fullcta-heading lumea-reveal-js lumea-reveal--static-js">
			<?php echo esc_html( get_theme_mod( 'lumea_cta_heading_1', 'For' ) ); ?> <em><?php echo esc_html( get_theme_mod( 'lumea_cta_heading_2', 'every' ) ); ?></em> <?php echo esc_html( get_theme_mod( 'lumea_cta_heading_3', 'skin.' ) ); ?>
		</h2>
		<a href="<?php echo esc_url( $shop_url ); ?>" class="lumea-fullcta-btn lumea-reveal-js lumea-reveal--static-js">
			<span><?php echo esc_html( get_theme_mod( 'lumea_cta_btn', 'Shop All Products' ) ); ?></span>
			<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
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

		<div class="lumea-latest-head lumea-section-intro-js">
			<div>
				<p class="lumea-latest-eyebrow lumea-eyebrow"><?php esc_html_e( 'Just Arrived', 'lumea' ); ?></p>
				<h2 class="lumea-latest-title lumea-section-title"><?php echo esc_html( get_theme_mod( 'lumea_latest_title', 'Latest Products' ) ); ?></h2>
			</div>
			<a href="<?php echo esc_url( $shop_url ); ?>" class="lumea-latest-all">
				<?php esc_html_e( 'View all', 'lumea' ); ?>
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
				'meta_query'     => array( array(
					'key'   => '_lumea_is_latest',
					'value' => 'yes',
				) ),
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
					'can_add_to_cart' => $_lp->is_purchasable() && $_lp->is_in_stock(),
					'supports_ajax'   => $_lp->supports( 'ajax_add_to_cart' ) && $_lp->is_purchasable() && $_lp->is_in_stock(),
					'category'  => ( ( $_lp_cats = get_the_terms( get_the_ID(), 'product_cat' ) ) && ! is_wp_error( $_lp_cats ) ) ? $_lp_cats[0]->name : '',
				);
			}
			wp_reset_postdata();
		}

		if ( empty( $lumea_lp_source ) ) {
			foreach ( $lumea_latest as $latest_item ) {
				$lumea_lp_source[] = array(
					'product_id'      => 0,
					'name'            => isset( $latest_item['name'] ) ? $latest_item['name'] : '',
					'url'             => isset( $latest_item['url'] ) ? $latest_item['url'] : '#',
					'price_html'      => isset( $latest_item['price'] ) ? $latest_item['price'] : '',
					'old_price_html'  => isset( $latest_item['old_price'] ) ? $latest_item['old_price'] : '',
					'is_sale'         => isset( $latest_item['old_price'] ) && '' !== $latest_item['old_price'],
					'badge'           => isset( $latest_item['badge'] ) ? $latest_item['badge'] : '',
					'main_image'      => isset( $latest_item['image'] ) ? $latest_item['image'] : '',
					'hover_image'     => isset( $latest_item['hover'] ) ? $latest_item['hover'] : '',
					'category'        => '',
					'product_type'    => 'simple',
					'can_add_to_cart' => false,
					'supports_ajax'   => false,
				);
			}
		}
		?>
		<div class="lumea-latest-grid">
			<?php foreach ( $lumea_lp_source as $lp ) : ?>
				<?php
				if ( function_exists( 'lumea_render_product_card' ) ) {
					lumea_render_product_card(
						$lp,
						array(
							'button_class'   => 'lumea-btn btn-black',
							'button_label'   => __( 'Add to Cart', 'lumea' ),
							'fallback_label' => __( 'Shop Now', 'lumea' ),
						)
					);
				}
				?>
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
			<div class="lumea-section-intro-js">
				<h2 class="lumea-ritual-heading lumea-section-title">
					<?php echo esc_html( get_theme_mod( 'lumea_ritual_heading_1', 'your daily' ) ); ?>
					<em><?php echo esc_html( get_theme_mod( 'lumea_ritual_heading_2', 'skin ritual' ) ); ?></em>
				</h2>
				<p class="lumea-ritual-intro lumea-section-desc">
					<?php echo esc_html( get_theme_mod( 'lumea_ritual_intro', 'Four intentional steps, one luminous result. A complete routine designed around the skin you have.' ) ); ?>
				</p>
			</div>
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
						<img src="<?php echo esc_url( $img1 ); ?>" alt="<?php echo esc_attr( $ritual_steps[ $n ]['title'] ); ?> skincare step" loading="lazy" />
					</div>
					<div class="lumea-ritual-image-wrap">
						<img src="<?php echo esc_url( $img2 ); ?>" alt="<?php echo esc_attr( $ritual_steps[ $n ]['title'] ); ?> ritual detail" loading="lazy" />
					</div>
				</div>
				<?php endforeach; ?>
			</div>
		</div>

	</div>

	<!-- Mobile -->
	<div class="lumea-ritual-mobile">
		<div class="lumea-section-intro-js">
			<h2 class="lumea-ritual-heading lumea-section-title">
				<?php echo esc_html( get_theme_mod( 'lumea_ritual_heading_1', 'your daily' ) ); ?>
				<em><?php echo esc_html( get_theme_mod( 'lumea_ritual_heading_2', 'skin ritual' ) ); ?></em>
			</h2>
			<p class="lumea-ritual-intro lumea-section-desc">
				<?php echo esc_html( get_theme_mod( 'lumea_ritual_intro', 'Four intentional steps, one luminous result. A complete routine designed around the skin you have.' ) ); ?>
			</p>
		</div>
		<div class="lumea-ritual-mobile-list">
			<?php foreach ( $ritual_steps as $n => $step ) :
				$img1 = esc_url( get_theme_mod( 'lumea_ritual_step' . $n . '_image1', $ritual_img_defaults[ $n ][1] ) );
				$img2 = esc_url( get_theme_mod( 'lumea_ritual_step' . $n . '_image2', $ritual_img_defaults[ $n ][2] ) );
			?>
			<article class="lumea-ritual-mobile-card">
				<div class="lumea-ritual-xfade-wrap">
					<img src="<?php echo esc_url( $img1 ); ?>" alt="<?php echo esc_attr( $step['title'] ); ?>" class="lumea-ritual-xfade lumea-ritual-xfade--a" loading="lazy" />
					<img src="<?php echo esc_url( $img2 ); ?>" alt="" class="lumea-ritual-xfade lumea-ritual-xfade--b" loading="lazy" aria-hidden="true" />
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

</main><!-- /#lumeaPage -->

<?php get_footer(); ?>
