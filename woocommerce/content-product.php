<?php
/**
 * Product card — shop loop.
 *
 * @package Lumea
 */

defined( 'ABSPATH' ) || exit;

global $product;

if ( ! $product || ! $product->is_visible() ) return;

$product_id    = $product->get_id();
$product_url   = get_permalink( $product_id );
$product_name  = get_the_title();
$gallery_ids   = $product->get_gallery_image_ids();
$main_img      = get_the_post_thumbnail_url( $product_id, 'woocommerce_single' );
$hover_img     = ! empty( $gallery_ids ) ? wp_get_attachment_image_url( $gallery_ids[0], 'woocommerce_single' ) : '';
$is_on_sale    = $product->is_on_sale();
$is_new        = ( time() - get_post_time( 'U', false, $product_id ) ) < ( 30 * DAY_IN_SECONDS );
$cats          = get_the_terms( $product_id, 'product_cat' );
$cat_name      = ( ! is_wp_error( $cats ) && ! empty( $cats ) ) ? $cats[0]->name : '';
$can_add_to_cart = $product->is_purchasable() && $product->is_in_stock();
$supports_ajax   = $can_add_to_cart && $product->supports( 'ajax_add_to_cart' );
?>
<li class="lumea-shop-card <?php echo esc_attr( implode( ' ', wc_get_product_class( '', $product ) ) ); ?>">

	<!-- Image -->
	<a href="<?php echo esc_url( $product_url ); ?>" class="lumea-shop-media">

		<?php if ( $is_on_sale ) : ?>
		<span class="lumea-shop-badge lumea-shop-badge--sale"><?php esc_html_e( 'Sale', 'lumea' ); ?></span>
		<?php elseif ( $is_new ) : ?>
		<span class="lumea-shop-badge"><?php esc_html_e( 'New', 'lumea' ); ?></span>
		<?php elseif ( $cat_name ) : ?>
		<span class="lumea-shop-badge"><?php echo esc_html( $cat_name ); ?></span>
		<?php endif; ?>

		<?php if ( $main_img ) : ?>
		<img src="<?php echo esc_url( $main_img ); ?>"
		     alt="<?php echo esc_attr( $product_name ); ?>"
		     class="lumea-shop-img lumea-shop-img--main"
		     loading="lazy" />
		<?php else : ?>
		<div class="lumea-shop-img-placeholder"></div>
		<?php endif; ?>

		<?php if ( $hover_img ) : ?>
		<img src="<?php echo esc_url( $hover_img ); ?>"
		     alt=""
		     class="lumea-shop-img lumea-shop-img--hover"
		     loading="lazy"
		     aria-hidden="true" />
		<?php endif; ?>

	</a>

	<!-- Wishlist toggle -->
	<button class="lumea-wishlist-toggle" data-wishlist-toggle="<?php echo esc_attr( $product_id ); ?>" aria-label="<?php esc_attr_e( 'Save to favourites', 'lumea' ); ?>">
		<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20.84 4.61a5.5 5.5 0 00-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 00-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 000-7.78z"/></svg>
	</button>

	<!-- Info -->
	<div class="lumea-shop-info">

		<?php if ( $cat_name ) : ?>
		<p class="lumea-shop-cat"><?php echo esc_html( $cat_name ); ?></p>
		<?php endif; ?>

		<h2 class="lumea-shop-name">
			<a href="<?php echo esc_url( $product_url ); ?>"><?php echo esc_html( $product_name ); ?></a>
		</h2>

		<div class="lumea-shop-pricing">
			<?php if ( $is_on_sale ) : ?>
			<s class="lumea-shop-old"><?php echo wc_price( $product->get_regular_price() ); ?></s>
			<?php endif; ?>
			<span class="lumea-shop-price<?php echo $is_on_sale ? ' lumea-shop-price--sale' : ''; ?>">
				<?php echo wp_kses_post( $product->get_price_html() ); ?>
			</span>
		</div>

		<?php if ( function_exists( 'lumea_render_product_card_actions' ) ) : ?>
			<?php
			lumea_render_product_card_actions(
				array(
					'product_id'      => $product_id,
					'product_url'     => $product_url,
					'product_name'    => $product_name,
					'product_type'    => $product->get_type(),
					'button_class'    => 'lumea-shop-btn',
					'button_label'    => $can_add_to_cart ? $product->add_to_cart_text() : __( 'View product', 'lumea' ),
					'fallback_label'  => __( 'View product', 'lumea' ),
					'can_add_to_cart' => $can_add_to_cart,
					'supports_ajax'   => $supports_ajax,
				)
			);
			?>
		<?php else : ?>
			<?php
			woocommerce_template_loop_add_to_cart( array(
				'class' => implode( ' ', array_filter( array(
					'lumea-shop-btn',
					'button',
					$can_add_to_cart ? 'add_to_cart_button' : '',
					$supports_ajax ? 'ajax_add_to_cart' : '',
				) ) ),
			) );
			?>
		<?php endif; ?>

	</div>

</li>
