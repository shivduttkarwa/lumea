<?php
/**
 * Single product — Luméa world-class edition.
 *
 * @package Lumea
 * @version 1.6.4
 */

defined( 'ABSPATH' ) || exit;

get_header();

while ( have_posts() ) :
	the_post();
	global $product;

	$product_id   = $product->get_id();
	$name         = $product->get_name();
	$price_html   = $product->get_price_html();
	$short_desc   = $product->get_short_description();
	$description  = $product->get_description();
	$rating_count = $product->get_rating_count();
	$average      = $product->get_average_rating();
	$sku          = $product->get_sku();
	$is_sale      = $product->is_on_sale();
	$is_instock   = $product->is_in_stock();
	$stock_qty    = $product->get_stock_quantity();
	$max_qty      = $product->get_max_purchase_quantity();
	$max_qty      = ( $max_qty === -1 ) ? 999 : $max_qty;

	
	$main_img_id   = $product->get_image_id();
	$gallery_ids   = $product->get_gallery_image_ids();
	$all_image_ids = array_values( array_filter( array_merge( array( $main_img_id ), $gallery_ids ) ) );

	
	$cats      = get_the_terms( $product_id, 'product_cat' );
	$cat_obj   = ( $cats && ! is_wp_error( $cats ) ) ? $cats[0] : null;
	$cat_label = $cat_obj ? $cat_obj->name : '';
	$cat_link  = $cat_obj ? get_term_link( $cat_obj ) : '';

	
	$shop_page_id  = function_exists( 'wc_get_page_id' ) ? wc_get_page_id( 'shop' ) : 0;
	$shop_url      = ( $shop_page_id > 0 ) ? get_permalink( $shop_page_id ) : home_url( '/' );
	$shop_title    = ( $shop_page_id > 0 ) ? get_the_title( $shop_page_id ) : __( 'Shop', 'lumea' );
	if ( ! $shop_title ) $shop_title = __( 'Shop', 'lumea' );

	
	$cart_action = apply_filters( 'woocommerce_add_to_cart_form_action', $product->get_permalink() );

	
	$schema_images = array();
	foreach ( $all_image_ids as $img_id ) {
		$img_url = wp_get_attachment_image_url( $img_id, 'full' );
		if ( $img_url ) {
			$schema_images[] = esc_url( $img_url );
		}
	}

	$schema = array(
		'@context'    => 'https://schema.org/',
		'@type'       => 'Product',
		'name'        => $name,
		'image'       => $schema_images,
		'description' => wp_strip_all_tags( $short_desc ? $short_desc : $description ),
		'sku'         => $sku,
		'brand'       => array(
			'@type' => 'Brand',
			'name'  => esc_html( get_bloginfo( 'name' ) ),
		),
		'offers'      => array(
			'@type'           => 'Offer',
			'url'             => get_permalink( $product_id ),
			'priceCurrency'   => get_woocommerce_currency(),
			'price'           => $product->get_price(),
			'availability'    => $is_instock
				? 'https://schema.org/InStock'
				: 'https://schema.org/OutOfStock',
			'itemCondition'   => 'https://schema.org/NewCondition',
		),
	);

	if ( $rating_count > 0 ) {
		$schema['aggregateRating'] = array(
			'@type'       => 'AggregateRating',
			'ratingValue' => $average,
			'reviewCount' => $rating_count,
		);
	}
	?>
	<script type="application/ld+json"><?php echo wp_json_encode( $schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ); ?></script>
	<?php
?>

<main class="lumea-pdp">

	<!-- ── Breadcrumb ───────────────────────────────────── -->
	<nav class="lumea-pdp-breadcrumb" aria-label="<?php esc_attr_e( 'Breadcrumb', 'lumea' ); ?>">
		<div class="lumea-pdp-bc-inner">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'lumea' ); ?></a>
			<svg class="lumea-pdp-bc-arrow" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="9 18 15 12 9 6"/></svg>
			<a href="<?php echo esc_url( $shop_url ); ?>"><?php echo esc_html( $shop_title ); ?></a>
			<?php if ( $cat_label && ! is_wp_error( $cat_link ) ) : ?>
			<svg class="lumea-pdp-bc-arrow" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="9 18 15 12 9 6"/></svg>
			<a href="<?php echo esc_url( $cat_link ); ?>"><?php echo esc_html( $cat_label ); ?></a>
			<?php endif; ?>
			<svg class="lumea-pdp-bc-arrow" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="9 18 15 12 9 6"/></svg>
			<span aria-current="page"><?php echo esc_html( $name ); ?></span>
		</div>
	</nav>

	<!-- ── Hero: gallery + info ─────────────────────────── -->
	<section class="lumea-pdp-hero">
		<div class="lumea-pdp-hero-inner">

			<!-- Gallery -->
			<div class="lumea-pdp-gallery">

				<?php if ( count( $all_image_ids ) > 1 ) : ?>
				<div class="lumea-pdp-thumbs">
					<?php foreach ( $all_image_ids as $i => $img_id ) :
						$t_url = wp_get_attachment_image_url( $img_id, 'thumbnail' );
						$l_url = wp_get_attachment_image_url( $img_id, 'large' );
						$alt   = get_post_meta( $img_id, '_wp_attachment_image_alt', true );
						$alt   = $alt ? $alt : $name;
					?>
					<button class="lumea-pdp-thumb<?php echo $i === 0 ? ' is-active' : ''; ?>"
					        data-full="<?php echo esc_url( $l_url ); ?>"
					        aria-label="<?php /* translators: %d: image number */ echo esc_attr( sprintf( __( 'View image %d', 'lumea' ), $i + 1 ) ); ?>">
						<img src="<?php echo esc_url( $t_url ); ?>" alt="<?php echo esc_attr( $alt ); ?>" loading="lazy">
					</button>
					<?php endforeach; ?>
				</div>
				<?php endif; ?>

				<div class="lumea-pdp-img-wrap">
					<?php if ( $is_sale ) : ?>
					<span class="lumea-pdp-badge lumea-pdp-badge--sale"><?php esc_html_e( 'Sale', 'lumea' ); ?></span>
					<?php elseif ( $product->is_featured() ) : ?>
					<span class="lumea-pdp-badge lumea-pdp-badge--new"><?php esc_html_e( 'New', 'lumea' ); ?></span>
					<?php endif; ?>

					<?php if ( ! empty( $all_image_ids ) ) :
						echo wp_get_attachment_image( $all_image_ids[0], 'large', false, array(
							'id'      => 'lumeaPdpMainImg',
							'class'   => 'lumea-pdp-img',
							'loading' => 'eager',
						) );
					else :
						echo wc_placeholder_img( 'large' );
					endif; ?>

					<button class="lumea-pdp-zoom-btn" id="lumeaZoomBtn" aria-label="<?php esc_attr_e( 'Zoom image', 'lumea' ); ?>">
						<svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/><line x1="11" y1="8" x2="11" y2="14"/><line x1="8" y1="11" x2="14" y2="11"/></svg>
						<?php esc_html_e( 'Zoom', 'lumea' ); ?>
					</button>
				</div>

			</div><!-- /.lumea-pdp-gallery -->

			<!-- Info panel -->
			<div class="lumea-pdp-info" id="lumeaPdpInfo">

				<div class="lumea-pdp-meta-top">
					<?php if ( $cat_label ) : ?>
					<span class="lumea-pdp-cat-label"><?php echo esc_html( $cat_label ); ?></span>
					<?php endif; ?>
					<?php if ( ! $is_instock ) : ?>
					<span class="lumea-pdp-stock lumea-pdp-stock--out"><?php esc_html_e( 'Out of stock', 'lumea' ); ?></span>
					<?php elseif ( $stock_qty !== null && $stock_qty > 0 && $stock_qty <= 5 ) : ?>
					<span class="lumea-pdp-stock lumea-pdp-stock--low"><?php /* translators: %d: remaining stock quantity */ echo esc_html( sprintf( __( 'Only %d left', 'lumea' ), $stock_qty ) ); ?></span>
					<?php else : ?>
					<span class="lumea-pdp-stock lumea-pdp-stock--in"><?php esc_html_e( 'In stock', 'lumea' ); ?></span>
					<?php endif; ?>
				</div>

				<h1 class="lumea-pdp-title"><?php echo esc_html( $name ); ?></h1>

				<?php if ( $rating_count > 0 ) : ?>
				<div class="lumea-pdp-rating">
					<div class="lumea-pdp-stars" aria-label="<?php /* translators: %.1f: product rating (e.g. 4.5) */ echo esc_attr( sprintf( __( 'Rated %.1f out of 5', 'lumea' ), $average ) ); ?>">
						<?php for ( $s = 1; $s <= 5; $s++ ) :
							$fill_pct = max( 0, min( 100, ( (float)$average - ($s-1) ) * 100 ) );
							$gid = 'sg-' . $product_id . '-' . $s;
						?>
						<svg width="14" height="14" viewBox="0 0 24 24" aria-hidden="true">
							<defs><linearGradient id="<?php echo esc_attr($gid); ?>" x1="0" x2="1" y1="0" y2="0">
								<stop offset="<?php echo esc_attr($fill_pct); ?>%" stop-color="#c98578"/>
								<stop offset="<?php echo esc_attr($fill_pct); ?>%" stop-color="#e5dbd8"/>
							</linearGradient></defs>
							<polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2" fill="url(#<?php echo esc_attr($gid); ?>)"/>
						</svg>
						<?php endfor; ?>
					</div>
					<a href="#lumea-reviews" class="lumea-pdp-rating-link"><?php /* translators: %s: formatted number of reviews */
				echo esc_html( sprintf( _n( '%s review', '%s reviews', $rating_count, 'lumea' ), number_format_i18n( $rating_count ) ) ); ?></a>
				</div>
				<?php endif; ?>

				<div class="lumea-pdp-price-wrap"><?php echo wp_kses_post( $price_html ); ?></div>

				<?php if ( $short_desc ) : ?>
				<div class="lumea-pdp-excerpt"><?php echo wp_kses_post( $short_desc ); ?></div>
				<?php endif; ?>

				<div class="lumea-pdp-divider"></div>

				<!-- ── WooCommerce add-to-cart (native form = fully working) ── -->
				<div class="lumea-pdp-atc">
					<?php
					
					do_action( 'woocommerce_before_add_to_cart_form' );

					if ( $product->is_type( 'simple' ) ) :
					?>
					<form class="cart lumea-atc-form" action="<?php echo esc_url( $cart_action ); ?>" method="post" enctype="multipart/form-data">

						<div class="lumea-qty-row">
							<label class="lumea-qty-label" for="lumea_qty"><?php esc_html_e( 'Qty', 'lumea' ); ?></label>
							<div class="lumea-qty-stepper">
								<button type="button" class="lumea-qty-btn lumea-qty-minus" aria-label="<?php esc_attr_e( 'Decrease', 'lumea' ); ?>">
									<svg width="14" height="2" viewBox="0 0 14 2" fill="none" aria-hidden="true"><rect width="14" height="2" rx="1" fill="currentColor"/></svg>
								</button>
								<input type="number"
								       id="lumea_qty"
								       name="quantity"
								       value="1"
								       min="1"
								       max="<?php echo esc_attr( $max_qty ); ?>"
								       step="1"
								       class="qty lumea-qty-input"
								       aria-label="<?php esc_attr_e( 'Product quantity', 'lumea' ); ?>">
								<button type="button" class="lumea-qty-btn lumea-qty-plus" aria-label="<?php esc_attr_e( 'Increase', 'lumea' ); ?>">
									<svg width="14" height="14" viewBox="0 0 14 14" fill="none" aria-hidden="true"><rect x="6" y="0" width="2" height="14" rx="1" fill="currentColor"/><rect x="0" y="6" width="14" height="2" rx="1" fill="currentColor"/></svg>
								</button>
							</div>
						</div>

						<div class="lumea-atc-btn-row">
							<?php if ( $is_instock ) : ?>
							<button type="submit"
							        name="add-to-cart"
							        value="<?php echo esc_attr( $product_id ); ?>"
							        class="single_add_to_cart_button button alt lumea-pdp-atc-btn">
								<svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 01-8 0"/></svg>
								<?php esc_html_e( 'Add to Bag', 'lumea' ); ?>
							</button>
							<?php else : ?>
							<button type="button" class="lumea-pdp-atc-btn lumea-pdp-atc-btn--disabled" disabled>
								<?php esc_html_e( 'Out of Stock', 'lumea' ); ?>
							</button>
							<?php endif; ?>

							<button type="button" class="lumea-pdp-wish-btn" aria-label="<?php esc_attr_e( 'Save to wishlist', 'lumea' ); ?>">
								<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
							</button>
						</div>

					</form>

					<?php elseif ( $product->is_type( 'variable' ) ) : ?>
						<?php woocommerce_variable_add_to_cart(); ?>
					<?php else : ?>
						<?php do_action( 'woocommerce_' . $product->get_type() . '_add_to_cart' ); ?>
					<?php endif; ?>

					<?php do_action( 'woocommerce_after_add_to_cart_form' ); ?>
				</div>

				<!-- Trust strips -->
				<div class="lumea-pdp-trust">
					<div class="lumea-pdp-trust-item">
						<svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="1" y="3" width="15" height="13"/><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/></svg>
						<div>
							<strong><?php esc_html_e( 'Free Delivery', 'lumea' ); ?></strong>
							<span><?php esc_html_e( 'Orders over $50', 'lumea' ); ?></span>
						</div>
					</div>
					<div class="lumea-pdp-trust-item">
						<svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="23 4 23 10 17 10"/><path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10"/></svg>
						<div>
							<strong><?php esc_html_e( '30-Day Returns', 'lumea' ); ?></strong>
							<span><?php esc_html_e( 'Hassle-free guarantee', 'lumea' ); ?></span>
						</div>
					</div>
					<div class="lumea-pdp-trust-item">
						<svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
						<div>
							<strong><?php esc_html_e( 'Clean Beauty', 'lumea' ); ?></strong>
							<span><?php esc_html_e( 'Cruelty-free & vegan', 'lumea' ); ?></span>
						</div>
					</div>
				</div>

				<?php if ( $sku ) : ?>
				<p class="lumea-pdp-sku"><?php esc_html_e( 'SKU:', 'lumea' ); ?> <span><?php echo esc_html( $sku ); ?></span></p>
				<?php endif; ?>

			</div><!-- /.lumea-pdp-info -->

		</div>
	</section>

	<!-- ── Details accordion ────────────────────────────── -->
	<div class="lumea-pdp-details">
		<div class="lumea-pdp-details-inner">

			<?php if ( $description ) : ?>
			<div class="lumea-pdp-acc" data-acc>
				<button class="lumea-pdp-acc-trigger is-open" aria-expanded="true" data-acc-trigger>
					<span><?php esc_html_e( 'Description', 'lumea' ); ?></span>
					<svg class="lumea-pdp-acc-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="6 9 12 15 18 9"/></svg>
				</button>
				<div class="lumea-pdp-acc-body is-open" data-acc-body>
					<div class="lumea-pdp-acc-content"><?php echo wp_kses_post( $description ); ?></div>
				</div>
			</div>
			<?php endif; ?>

			<div class="lumea-pdp-acc" data-acc>
				<button class="lumea-pdp-acc-trigger" aria-expanded="false" data-acc-trigger>
					<span><?php esc_html_e( 'Key Ingredients', 'lumea' ); ?></span>
					<svg class="lumea-pdp-acc-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="6 9 12 15 18 9"/></svg>
				</button>
				<div class="lumea-pdp-acc-body" data-acc-body>
					<div class="lumea-pdp-acc-content">
						<?php
						$ing = $product->get_attribute( 'ingredients' );
						if ( ! $ing ) $ing = $product->get_attribute( 'pa_ingredients' );
						echo $ing
							? wp_kses_post( $ing )
							: '<p>' . esc_html__( 'Formulated with nature-powered actives. Full ingredient list available on packaging.', 'lumea' ) . '</p>';
						?>
					</div>
				</div>
			</div>

			<div class="lumea-pdp-acc" data-acc>
				<button class="lumea-pdp-acc-trigger" aria-expanded="false" data-acc-trigger>
					<span><?php esc_html_e( 'How to Use', 'lumea' ); ?></span>
					<svg class="lumea-pdp-acc-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="6 9 12 15 18 9"/></svg>
				</button>
				<div class="lumea-pdp-acc-body" data-acc-body>
					<div class="lumea-pdp-acc-content">
						<?php
						$how = $product->get_attribute( 'how_to_use' );
						if ( ! $how ) $how = $product->get_attribute( 'pa_how_to_use' );
						echo $how
							? wp_kses_post( $how )
							: '<p>' . esc_html__( 'Apply a small amount to cleansed skin morning and evening. Gently pat until absorbed. Follow with SPF in the morning.', 'lumea' ) . '</p>';
						?>
					</div>
				</div>
			</div>

			<div class="lumea-pdp-acc" data-acc>
				<button class="lumea-pdp-acc-trigger" aria-expanded="false" data-acc-trigger>
					<span><?php esc_html_e( 'Delivery & Returns', 'lumea' ); ?></span>
					<svg class="lumea-pdp-acc-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="6 9 12 15 18 9"/></svg>
				</button>
				<div class="lumea-pdp-acc-body" data-acc-body>
					<div class="lumea-pdp-acc-content">
						<p><?php esc_html_e( 'Standard delivery 3–5 business days. Free on orders over $50. Express shipping available at checkout.', 'lumea' ); ?></p>
						<p><?php esc_html_e( 'Returns accepted within 30 days for unused, sealed products. Contact us to begin your return.', 'lumea' ); ?></p>
					</div>
				</div>
			</div>

		</div>
	</div>

	<!-- ── Reviews ──────────────────────────────────────── -->
	<?php if ( comments_open() || get_comments_number() ) : ?>
	<div class="lumea-pdp-reviews" id="lumea-reviews">
		<div class="lumea-pdp-reviews-inner">
			<div class="lumea-pdp-reviews-head">
				<div class="lumea-pdp-rev-score">
					<span class="lumea-pdp-rev-avg"><?php echo esc_html( number_format( (float)$average, 1 ) ); ?></span>
					<div class="lumea-pdp-rev-meta">
						<div class="lumea-pdp-stars">
							<?php for ( $s = 1; $s <= 5; $s++ ) : ?>
							<svg width="16" height="16" viewBox="0 0 24 24" fill="<?php echo esc_attr( $s <= round( $average ) ? '#c98578' : '#e5dbd8' ); ?>" aria-hidden="true"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
							<?php endfor; ?>
						</div>
						<p><?php /* translators: %s: formatted number of reviews */
					echo esc_html( sprintf( _n( 'Based on %s review', 'Based on %s reviews', $rating_count, 'lumea' ), number_format_i18n( $rating_count ) ) ); ?></p>
					</div>
				</div>
				<h2 class="lumea-pdp-reviews-title"><?php esc_html_e( 'Customer Reviews', 'lumea' ); ?></h2>
			</div>
			<?php comments_template(); ?>
		</div>
	</div>
	<?php endif; ?>

	<!-- ── Related products ─────────────────────────────── -->
	<?php
	$related_ids = wc_get_related_products( $product_id, 4 );
	if ( ! empty( $related_ids ) ) :
		$rel_query = new WP_Query( array(
			'post_type'      => 'product',
			'post__in'       => $related_ids,
			'posts_per_page' => 4,
			'orderby'        => 'post__in',
		) );
	?>
	<section class="lumea-pdp-related">
		<div class="lumea-pdp-rel-inner">
			<div class="lumea-pdp-rel-head">
				<p class="lumea-pdp-rel-eyebrow"><?php esc_html_e( 'You May Also Like', 'lumea' ); ?></p>
				<h2 class="lumea-pdp-rel-title"><?php esc_html_e( 'Complete Your Ritual', 'lumea' ); ?></h2>
			</div>
			<div class="lumea-pdp-rel-grid">
				<?php while ( $rel_query->have_posts() ) : $rel_query->the_post();
					global $product;
					$r_cats = get_the_terms( $product->get_id(), 'product_cat' );
					$r_cat  = ( $r_cats && ! is_wp_error( $r_cats ) ) ? $r_cats[0]->name : '';
				?>
				<a href="<?php echo esc_url( get_permalink() ); ?>" class="lumea-pdp-rel-card">
					<div class="lumea-pdp-rel-media">
						<?php if ( $product->get_image_id() ) :
							echo wp_get_attachment_image( $product->get_image_id(), 'woocommerce_thumbnail', false, array( 'class' => 'lumea-pdp-rel-img', 'loading' => 'lazy' ) );
						else :
							echo wc_placeholder_img( 'woocommerce_thumbnail' );
						endif; ?>
						<?php if ( $product->is_on_sale() ) : ?>
						<span class="lumea-pdp-rel-badge"><?php esc_html_e( 'Sale', 'lumea' ); ?></span>
						<?php endif; ?>
					</div>
					<div class="lumea-pdp-rel-info">
						<?php if ( $r_cat ) : ?><span class="lumea-pdp-rel-cat"><?php echo esc_html( $r_cat ); ?></span><?php endif; ?>
						<p class="lumea-pdp-rel-name"><?php echo esc_html( $product->get_name() ); ?></p>
						<p class="lumea-pdp-rel-price"><?php echo wp_kses_post( $product->get_price_html() ); ?></p>
					</div>
					<span class="lumea-pdp-rel-cta"><?php esc_html_e( 'Shop Now', 'lumea' ); ?> →</span>
				</a>
				<?php endwhile; wp_reset_postdata(); ?>
			</div>
		</div>
	</section>
	<?php endif; ?>

</main>

<!-- Lightbox -->
<div class="lumea-lightbox" id="lumeaLightbox" role="dialog" aria-modal="true" aria-label="<?php esc_attr_e( 'Image zoom', 'lumea' ); ?>" aria-hidden="true">
	<button class="lumea-lightbox-close" id="lumeaLightboxClose" aria-label="<?php esc_attr_e( 'Close', 'lumea' ); ?>">
		<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
	</button>
	<img class="lumea-lightbox-img" id="lumeaLightboxImg" src="" alt="">
</div>

<?php endwhile; ?>

<?php get_footer(); ?>
