<?php
/**
 * Single product template — world-class edition.
 *
 * @package Lumea
 */

defined( 'ABSPATH' ) || exit;

get_header();

while ( have_posts() ) :
	the_post();
	global $product;

	/* ── Product data ──────────────────────────────────── */
	$product_id    = $product->get_id();
	$name          = $product->get_name();
	$price_html    = $product->get_price_html();
	$short_desc    = $product->get_short_description();
	$description   = $product->get_description();
	$rating_count  = $product->get_rating_count();
	$average       = $product->get_average_rating();
	$sku           = $product->get_sku();
	$cats          = get_the_terms( $product_id, 'product_cat' );
	$tags          = get_the_terms( $product_id, 'product_tag' );
	$is_sale       = $product->is_on_sale();
	$is_instock    = $product->is_in_stock();
	$stock_qty     = $product->get_stock_quantity();

	/* ── Gallery images ────────────────────────────────── */
	$main_img_id    = $product->get_image_id();
	$gallery_ids    = $product->get_gallery_image_ids();
	$all_image_ids  = array_merge( array( $main_img_id ), $gallery_ids );
	$all_image_ids  = array_filter( $all_image_ids );

	/* ── Category label ────────────────────────────────── */
	$cat_label = '';
	if ( $cats && ! is_wp_error( $cats ) ) {
		$cat_label = $cats[0]->name;
	}

	/* ── Breadcrumb data ───────────────────────────────── */
	$shop_url   = get_permalink( wc_get_page_id( 'shop' ) );
	$shop_label = get_the_title( wc_get_page_id( 'shop' ) ) ?: __( 'Shop', 'lumea' );
?>

<main class="lumea-pdp" id="lumeaPdp">

	<!-- Breadcrumb -->
	<nav class="lumea-pdp-breadcrumb" aria-label="<?php esc_attr_e( 'Breadcrumb', 'lumea' ); ?>">
		<div class="lumea-pdp-breadcrumb-inner">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'lumea' ); ?></a>
			<span class="lumea-pdp-bc-sep" aria-hidden="true">—</span>
			<a href="<?php echo esc_url( $shop_url ); ?>"><?php echo esc_html( $shop_label ); ?></a>
			<?php if ( $cat_label ) : ?>
			<span class="lumea-pdp-bc-sep" aria-hidden="true">—</span>
			<a href="<?php echo esc_url( get_term_link( $cats[0] ) ); ?>"><?php echo esc_html( $cat_label ); ?></a>
			<?php endif; ?>
			<span class="lumea-pdp-bc-sep" aria-hidden="true">—</span>
			<span aria-current="page"><?php echo esc_html( $name ); ?></span>
		</div>
	</nav>

	<!-- Hero: Gallery + Info -->
	<div class="lumea-pdp-hero">
		<div class="lumea-pdp-hero-inner">

			<!-- Gallery -->
			<div class="lumea-pdp-gallery" id="lumeaGallery">

				<!-- Thumbnails (vertical strip) -->
				<?php if ( count( $all_image_ids ) > 1 ) : ?>
				<div class="lumea-pdp-thumbs" role="tablist" aria-label="<?php esc_attr_e( 'Product images', 'lumea' ); ?>">
					<?php foreach ( $all_image_ids as $i => $img_id ) :
						$thumb_url = wp_get_attachment_image_url( $img_id, 'thumbnail' );
						$full_url  = wp_get_attachment_image_url( $img_id, 'large' );
						$alt       = get_post_meta( $img_id, '_wp_attachment_image_alt', true ) ?: $name;
					?>
					<button class="lumea-pdp-thumb<?php echo $i === 0 ? ' is-active' : ''; ?>"
					        data-img-src="<?php echo esc_url( $full_url ); ?>"
					        data-index="<?php echo esc_attr( $i ); ?>"
					        role="tab"
					        aria-selected="<?php echo $i === 0 ? 'true' : 'false'; ?>"
					        aria-label="<?php echo esc_attr( sprintf( __( 'Image %d', 'lumea' ), $i + 1 ) ); ?>">
						<img src="<?php echo esc_url( $thumb_url ); ?>" alt="<?php echo esc_attr( $alt ); ?>" loading="lazy" />
					</button>
					<?php endforeach; ?>
				</div>
				<?php endif; ?>

				<!-- Main image -->
				<div class="lumea-pdp-main-img-wrap">
					<?php if ( $is_sale ) : ?>
					<span class="lumea-pdp-badge lumea-pdp-badge--sale"><?php esc_html_e( 'Sale', 'lumea' ); ?></span>
					<?php elseif ( $product->is_featured() ) : ?>
					<span class="lumea-pdp-badge lumea-pdp-badge--new"><?php esc_html_e( 'New', 'lumea' ); ?></span>
					<?php endif; ?>

					<div class="lumea-pdp-main-img" id="lumeaMainImg">
						<?php
						$first_img_id = $all_image_ids[0] ?? null;
						if ( $first_img_id ) :
							echo wp_get_attachment_image( $first_img_id, 'large', false, array(
								'class'   => 'lumea-pdp-img',
								'id'      => 'lumeaActiveImg',
								'loading' => 'eager',
							) );
						else :
							echo '<div class="lumea-pdp-img-placeholder">' . wc_placeholder_img( 'large' ) . '</div>';
						endif;
						?>
					</div>

					<!-- Zoom hint -->
					<div class="lumea-pdp-zoom-hint" aria-hidden="true">
						<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/><line x1="11" y1="8" x2="11" y2="14"/><line x1="8" y1="11" x2="14" y2="11"/></svg>
						<span><?php esc_html_e( 'Click to zoom', 'lumea' ); ?></span>
					</div>
				</div>

			</div><!-- /.lumea-pdp-gallery -->

			<!-- Product info -->
			<div class="lumea-pdp-info" id="lumeaPdpInfo">

				<!-- Category + badge -->
				<div class="lumea-pdp-meta-row">
					<?php if ( $cat_label ) : ?>
					<span class="lumea-pdp-category"><?php echo esc_html( $cat_label ); ?></span>
					<?php endif; ?>
					<?php if ( ! $is_instock ) : ?>
					<span class="lumea-pdp-stock lumea-pdp-stock--out"><?php esc_html_e( 'Out of stock', 'lumea' ); ?></span>
					<?php elseif ( $stock_qty !== null && $stock_qty <= 5 ) : ?>
					<span class="lumea-pdp-stock lumea-pdp-stock--low"><?php printf( esc_html__( 'Only %d left', 'lumea' ), $stock_qty ); ?></span>
					<?php else : ?>
					<span class="lumea-pdp-stock lumea-pdp-stock--in"><?php esc_html_e( 'In stock', 'lumea' ); ?></span>
					<?php endif; ?>
				</div>

				<!-- Title -->
				<h1 class="lumea-pdp-title"><?php echo esc_html( $name ); ?></h1>

				<!-- Rating -->
				<?php if ( $rating_count > 0 ) : ?>
				<div class="lumea-pdp-rating">
					<div class="lumea-pdp-stars" aria-label="<?php echo esc_attr( sprintf( __( 'Rated %s out of 5', 'lumea' ), $average ) ); ?>">
						<?php for ( $s = 1; $s <= 5; $s++ ) :
							$pct = max( 0, min( 1, $average - ( $s - 1 ) ) ) * 100;
						?>
						<span class="lumea-pdp-star" aria-hidden="true">
							<svg width="14" height="14" viewBox="0 0 24 24" fill="none">
								<defs>
									<linearGradient id="star-<?php echo esc_attr( $product_id . '-' . $s ); ?>">
										<stop offset="<?php echo esc_attr( $pct ); ?>%" stop-color="#c98578"/>
										<stop offset="<?php echo esc_attr( $pct ); ?>%" stop-color="#e5dbd8"/>
									</linearGradient>
								</defs>
								<polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"
								         fill="url(#star-<?php echo esc_attr( $product_id . '-' . $s ); ?>)"/>
							</svg>
						</span>
						<?php endfor; ?>
					</div>
					<a href="#lumea-reviews" class="lumea-pdp-rating-count"><?php printf( esc_html( _n( '%s review', '%s reviews', $rating_count, 'lumea' ) ), number_format_i18n( $rating_count ) ); ?></a>
				</div>
				<?php endif; ?>

				<!-- Price -->
				<div class="lumea-pdp-price"><?php echo wp_kses_post( $price_html ); ?></div>

				<!-- Short description -->
				<?php if ( $short_desc ) : ?>
				<div class="lumea-pdp-short-desc"><?php echo wp_kses_post( $short_desc ); ?></div>
				<?php endif; ?>

				<!-- Divider -->
				<hr class="lumea-pdp-divider">

				<!-- Add to cart form -->
				<div class="lumea-pdp-atc-wrap">
					<?php if ( $product->is_type( 'variable' ) ) : ?>
						<?php woocommerce_variable_add_to_cart(); ?>
					<?php elseif ( $product->is_type( 'simple' ) ) : ?>
					<form class="lumea-pdp-atc-form" action="<?php echo esc_url( apply_filters( 'woocommerce_add_to_cart_form_action', $product->get_permalink() ) ); ?>" method="post" enctype="multipart/form-data">
						<!-- Quantity -->
						<div class="lumea-pdp-qty-wrap">
							<label class="lumea-pdp-qty-label" for="lumea-qty"><?php esc_html_e( 'Qty', 'lumea' ); ?></label>
							<div class="lumea-pdp-qty">
								<button type="button" class="lumea-qty-btn" data-lumea-qty-minus aria-label="<?php esc_attr_e( 'Decrease quantity', 'lumea' ); ?>">
									<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="5" y1="12" x2="19" y2="12"/></svg>
								</button>
								<input type="number" id="lumea-qty" name="quantity" value="1" min="1"
								       max="<?php echo esc_attr( $product->get_max_purchase_quantity() ); ?>"
								       class="lumea-qty-input"
								       aria-label="<?php esc_attr_e( 'Product quantity', 'lumea' ); ?>">
								<button type="button" class="lumea-qty-btn" data-lumea-qty-plus aria-label="<?php esc_attr_e( 'Increase quantity', 'lumea' ); ?>">
									<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
								</button>
							</div>
						</div>

						<!-- Buttons -->
						<div class="lumea-pdp-btn-row">
							<button type="submit"
							        name="add-to-cart"
							        value="<?php echo esc_attr( $product_id ); ?>"
							        class="lumea-pdp-atc-btn<?php echo ! $is_instock ? ' is-disabled' : ''; ?>"
							        <?php echo ! $is_instock ? 'disabled' : ''; ?>>
								<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 01-8 0"/></svg>
								<?php esc_html_e( 'Add to Bag', 'lumea' ); ?>
							</button>
							<button type="button" class="lumea-pdp-wish-btn" data-product-id="<?php echo esc_attr( $product_id ); ?>" aria-label="<?php esc_attr_e( 'Add to wishlist', 'lumea' ); ?>">
								<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
							</button>
						</div>

						<?php wp_nonce_field( 'lumea-add-to-cart', 'lumea_cart_nonce' ); ?>
					</form>
					<?php else : ?>
						<?php do_action( 'woocommerce_' . $product->get_type() . '_add_to_cart' ); ?>
					<?php endif; ?>
				</div>

				<!-- Trust badges -->
				<div class="lumea-pdp-trust">
					<div class="lumea-pdp-trust-item">
						<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="3" width="15" height="13"/><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/></svg>
						<div>
							<p><?php esc_html_e( 'Free Delivery', 'lumea' ); ?></p>
							<span><?php esc_html_e( 'On orders over $50', 'lumea' ); ?></span>
						</div>
					</div>
					<div class="lumea-pdp-trust-item">
						<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><polyline points="23 4 23 10 17 10"/><path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10"/></svg>
						<div>
							<p><?php esc_html_e( '30-Day Returns', 'lumea' ); ?></p>
							<span><?php esc_html_e( 'Hassle-free guarantee', 'lumea' ); ?></span>
						</div>
					</div>
					<div class="lumea-pdp-trust-item">
						<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
						<div>
							<p><?php esc_html_e( 'Clean Beauty', 'lumea' ); ?></p>
							<span><?php esc_html_e( 'Cruelty-free & vegan', 'lumea' ); ?></span>
						</div>
					</div>
				</div>

				<!-- SKU + Tags -->
				<?php if ( $sku ) : ?>
				<p class="lumea-pdp-sku"><?php esc_html_e( 'SKU:', 'lumea' ); ?> <span><?php echo esc_html( $sku ); ?></span></p>
				<?php endif; ?>

			</div><!-- /.lumea-pdp-info -->

		</div>
	</div><!-- /.lumea-pdp-hero -->

	<!-- Product details accordion -->
	<div class="lumea-pdp-details">
		<div class="lumea-pdp-details-inner">

			<!-- Accordion items -->
			<?php if ( $description ) : ?>
			<div class="lumea-pdp-accordion" data-lumea-accordion>
				<button class="lumea-pdp-accordion-trigger is-open" aria-expanded="true" data-lumea-accordion-trigger>
					<span><?php esc_html_e( 'Description', 'lumea' ); ?></span>
					<svg class="lumea-pdp-accordion-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>
				</button>
				<div class="lumea-pdp-accordion-body is-open" data-lumea-accordion-body>
					<div class="lumea-pdp-accordion-content"><?php echo wp_kses_post( $description ); ?></div>
				</div>
			</div>
			<?php endif; ?>

			<div class="lumea-pdp-accordion" data-lumea-accordion>
				<button class="lumea-pdp-accordion-trigger" aria-expanded="false" data-lumea-accordion-trigger>
					<span><?php esc_html_e( 'Key Ingredients', 'lumea' ); ?></span>
					<svg class="lumea-pdp-accordion-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>
				</button>
				<div class="lumea-pdp-accordion-body" data-lumea-accordion-body>
					<div class="lumea-pdp-accordion-content">
						<?php
						$ingredients = $product->get_attribute( 'ingredients' ) ?: $product->get_attribute( 'pa_ingredients' );
						if ( $ingredients ) :
							echo wp_kses_post( $ingredients );
						else :
							echo '<p>' . esc_html__( 'Formulated with nature-powered actives. Full ingredient list available on packaging.', 'lumea' ) . '</p>';
						endif;
						?>
					</div>
				</div>
			</div>

			<div class="lumea-pdp-accordion" data-lumea-accordion>
				<button class="lumea-pdp-accordion-trigger" aria-expanded="false" data-lumea-accordion-trigger>
					<span><?php esc_html_e( 'How to Use', 'lumea' ); ?></span>
					<svg class="lumea-pdp-accordion-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>
				</button>
				<div class="lumea-pdp-accordion-body" data-lumea-accordion-body>
					<div class="lumea-pdp-accordion-content">
						<?php
						$how_to = $product->get_attribute( 'how_to_use' ) ?: $product->get_attribute( 'pa_how_to_use' );
						if ( $how_to ) :
							echo wp_kses_post( $how_to );
						else :
							echo '<p>' . esc_html__( 'Apply a small amount to cleansed skin morning and evening. Gently pat until absorbed. Follow with moisturiser and SPF in the morning.', 'lumea' ) . '</p>';
						endif;
						?>
					</div>
				</div>
			</div>

			<div class="lumea-pdp-accordion" data-lumea-accordion>
				<button class="lumea-pdp-accordion-trigger" aria-expanded="false" data-lumea-accordion-trigger>
					<span><?php esc_html_e( 'Delivery & Returns', 'lumea' ); ?></span>
					<svg class="lumea-pdp-accordion-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>
				</button>
				<div class="lumea-pdp-accordion-body" data-lumea-accordion-body>
					<div class="lumea-pdp-accordion-content">
						<p><?php esc_html_e( 'Standard delivery 3–5 business days. Free on orders over $50. Express available at checkout.', 'lumea' ); ?></p>
						<p><?php esc_html_e( 'Returns accepted within 30 days of purchase for unused, sealed products. Contact us to initiate a return.', 'lumea' ); ?></p>
					</div>
				</div>
			</div>

		</div>
	</div><!-- /.lumea-pdp-details -->

	<!-- Reviews -->
	<div class="lumea-pdp-reviews-wrap" id="lumea-reviews">
		<div class="lumea-pdp-reviews-inner">
			<?php
			$rating_count = $product->get_rating_count();
			$average      = $product->get_average_rating();
			?>
			<div class="lumea-pdp-reviews-head">
				<div class="lumea-pdp-reviews-summary">
					<span class="lumea-pdp-reviews-avg"><?php echo esc_html( number_format( (float) $average, 1 ) ); ?></span>
					<div>
						<div class="lumea-pdp-stars lumea-pdp-stars--lg">
							<?php for ( $s = 1; $s <= 5; $s++ ) : ?>
							<svg width="18" height="18" viewBox="0 0 24 24" fill="<?php echo $s <= round( $average ) ? '#c98578' : '#e5dbd8'; ?>">
								<polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
							</svg>
							<?php endfor; ?>
						</div>
						<p class="lumea-pdp-reviews-total"><?php printf( esc_html( _n( 'Based on %s review', 'Based on %s reviews', $rating_count, 'lumea' ) ), number_format_i18n( $rating_count ) ); ?></p>
					</div>
				</div>
				<h2 class="lumea-pdp-reviews-title"><?php esc_html_e( 'Customer Reviews', 'lumea' ); ?></h2>
			</div>

			<!-- WooCommerce reviews -->
			<?php
			if ( comments_open() ) :
				comments_template();
			endif;
			?>
		</div>
	</div>

	<!-- Related products -->
	<?php
	$related_ids = wc_get_related_products( $product_id, 8 );
	if ( $related_ids ) :
		$related_args = array(
			'post_type'      => 'product',
			'post__in'       => $related_ids,
			'posts_per_page' => 8,
			'orderby'        => 'rand',
		);
		$related_query = new WP_Query( $related_args );
	?>
	<section class="lumea-pdp-related">
		<div class="lumea-pdp-related-inner">
			<div class="lumea-pdp-related-head">
				<p class="lumea-pdp-related-eyebrow"><?php esc_html_e( 'You May Also Like', 'lumea' ); ?></p>
				<h2 class="lumea-pdp-related-title"><?php esc_html_e( 'Complete Your Ritual', 'lumea' ); ?></h2>
			</div>
			<div class="lumea-pdp-related-grid">
				<?php while ( $related_query->have_posts() ) : $related_query->the_post();
					global $product;
					$rel_id    = $product->get_id();
					$rel_name  = $product->get_name();
					$rel_price = $product->get_price_html();
					$rel_img   = wp_get_attachment_image_url( $product->get_image_id(), 'woocommerce_thumbnail' );
					$rel_cats  = get_the_terms( $rel_id, 'product_cat' );
					$rel_cat   = ( $rel_cats && ! is_wp_error( $rel_cats ) ) ? $rel_cats[0]->name : '';
				?>
				<a href="<?php echo esc_url( get_permalink() ); ?>" class="lumea-pdp-rel-card">
					<div class="lumea-pdp-rel-media">
						<?php if ( $rel_img ) : ?>
						<img src="<?php echo esc_url( $rel_img ); ?>" alt="<?php echo esc_attr( $rel_name ); ?>" loading="lazy" class="lumea-pdp-rel-img" />
						<?php else : ?>
						<div class="lumea-pdp-rel-placeholder"></div>
						<?php endif; ?>
						<?php if ( $product->is_on_sale() ) : ?>
						<span class="lumea-pdp-rel-badge"><?php esc_html_e( 'Sale', 'lumea' ); ?></span>
						<?php endif; ?>
					</div>
					<div class="lumea-pdp-rel-body">
						<?php if ( $rel_cat ) : ?>
						<span class="lumea-pdp-rel-cat"><?php echo esc_html( $rel_cat ); ?></span>
						<?php endif; ?>
						<p class="lumea-pdp-rel-name"><?php echo esc_html( $rel_name ); ?></p>
						<p class="lumea-pdp-rel-price"><?php echo wp_kses_post( $rel_price ); ?></p>
					</div>
					<span class="lumea-pdp-rel-cta"><?php esc_html_e( 'View Product', 'lumea' ); ?> →</span>
				</a>
				<?php endwhile; wp_reset_postdata(); ?>
			</div>
		</div>
	</section>
	<?php endif; ?>

</main>

<!-- Lightbox overlay -->
<div class="lumea-lightbox" id="lumeaLightbox" aria-modal="true" role="dialog" aria-label="<?php esc_attr_e( 'Image zoom', 'lumea' ); ?>" aria-hidden="true">
	<button class="lumea-lightbox-close" id="lumeaLightboxClose" aria-label="<?php esc_attr_e( 'Close', 'lumea' ); ?>">
		<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
	</button>
	<img class="lumea-lightbox-img" id="lumeaLightboxImg" src="" alt="" />
</div>

<?php endwhile; ?>

<script>
(function(){
  /* ── Gallery thumbnails ── */
  var thumbs   = document.querySelectorAll('.lumea-pdp-thumb');
  var mainImg  = document.getElementById('lumeaActiveImg');

  thumbs.forEach(function(btn){
    btn.addEventListener('click', function(){
      thumbs.forEach(function(t){ t.classList.remove('is-active'); t.setAttribute('aria-selected','false'); });
      btn.classList.add('is-active');
      btn.setAttribute('aria-selected','true');
      if(mainImg){
        mainImg.style.opacity = '0';
        mainImg.style.transform = 'scale(0.97)';
        setTimeout(function(){
          mainImg.src = btn.dataset.imgSrc;
          mainImg.style.opacity = '1';
          mainImg.style.transform = 'scale(1)';
        }, 180);
      }
    });
  });

  /* ── Lightbox ── */
  var lightbox  = document.getElementById('lumeaLightbox');
  var lbImg     = document.getElementById('lumeaLightboxImg');
  var lbClose   = document.getElementById('lumeaLightboxClose');
  var imgWrap   = document.querySelector('.lumea-pdp-main-img');

  if(imgWrap && lightbox){
    imgWrap.style.cursor = 'zoom-in';
    imgWrap.addEventListener('click', function(){
      lbImg.src = mainImg ? mainImg.src : '';
      lightbox.classList.add('is-open');
      lightbox.setAttribute('aria-hidden','false');
      document.body.style.overflow = 'hidden';
    });
    lbClose.addEventListener('click', closeLightbox);
    lightbox.addEventListener('click', function(e){ if(e.target === lightbox) closeLightbox(); });
    document.addEventListener('keydown', function(e){ if(e.key==='Escape') closeLightbox(); });
    function closeLightbox(){
      lightbox.classList.remove('is-open');
      lightbox.setAttribute('aria-hidden','true');
      document.body.style.overflow = '';
    }
  }

  /* ── Quantity stepper ── */
  var qtyInput = document.querySelector('.lumea-qty-input');
  var qtyMinus = document.querySelector('[data-lumea-qty-minus]');
  var qtyPlus  = document.querySelector('[data-lumea-qty-plus]');

  if(qtyInput){
    if(qtyMinus) qtyMinus.addEventListener('click', function(){
      var v = parseInt(qtyInput.value,10);
      var min = parseInt(qtyInput.min,10) || 1;
      if(v > min) qtyInput.value = v - 1;
    });
    if(qtyPlus) qtyPlus.addEventListener('click', function(){
      var v = parseInt(qtyInput.value,10);
      var max = parseInt(qtyInput.max,10) || 9999;
      if(v < max) qtyInput.value = v + 1;
    });
  }

  /* ── Accordion ── */
  document.querySelectorAll('[data-lumea-accordion]').forEach(function(acc){
    var trigger = acc.querySelector('[data-lumea-accordion-trigger]');
    var body    = acc.querySelector('[data-lumea-accordion-body]');
    if(!trigger || !body) return;

    trigger.addEventListener('click', function(){
      var isOpen = body.classList.contains('is-open');
      body.classList.toggle('is-open', !isOpen);
      trigger.classList.toggle('is-open', !isOpen);
      trigger.setAttribute('aria-expanded', !isOpen);
      if(!isOpen){
        body.style.maxHeight = body.scrollHeight + 'px';
      } else {
        body.style.maxHeight = '0';
      }
    });

    /* Set initial max-height for pre-opened accordions */
    if(body.classList.contains('is-open')){
      body.style.maxHeight = body.scrollHeight + 'px';
    } else {
      body.style.maxHeight = '0';
    }
  });

  /* ── Sticky info panel on scroll ── */
  var pdpInfo  = document.getElementById('lumeaPdpInfo');
  var pdpHero  = document.querySelector('.lumea-pdp-hero');
  if(pdpInfo && pdpHero && window.innerWidth >= 1024){
    pdpInfo.style.position = 'sticky';
    pdpInfo.style.top = '96px';
    pdpInfo.style.alignSelf = 'start';
  }
})();
</script>

<?php get_footer(); ?>
