<?php
/**
 * Reusable latest-style WooCommerce product card.
 *
 * @package Lumea
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$defaults = array(
	'product_id'      => 0,
	'name'            => '',
	'url'             => '#',
	'price_html'      => '',
	'old_price_html'  => '',
	'is_sale'         => false,
	'badge'           => '',
	'main_image'      => '',
	'hover_image'     => '',
	'category'        => '',
	'product_type'    => 'simple',
	'can_add_to_cart' => false,
	'supports_ajax'   => false,
	'button_label'    => __( 'Add to Cart', 'lumea' ),
	'fallback_label'  => __( 'Shop Now', 'lumea' ),
	'button_class'    => 'lumea-btn btn-black',
	'card_class'      => 'lumea-lp-card',
);
$data = wp_parse_args( is_array( $args ) ? $args : array(), $defaults );

$product_id      = absint( $data['product_id'] );
$product_name    = wp_strip_all_tags( (string) $data['name'] );
$product_name_esc = esc_html( $product_name );
$product_url_raw = (string) $data['url'];
$product_url     = esc_url( $product_url_raw );
$price_html      = (string) $data['price_html'];
$old_price_html  = (string) $data['old_price_html'];
$is_sale         = ! empty( $data['is_sale'] );
$badge           = (string) $data['badge'];
$main_image      = esc_url( (string) $data['main_image'] );
$hover_image     = esc_url( (string) $data['hover_image'] );
$category        = (string) $data['category'];
$product_type    = (string) $data['product_type'];
$can_add_to_cart = ! empty( $data['can_add_to_cart'] );
$supports_ajax   = ! empty( $data['supports_ajax'] );
$button_label    = (string) $data['button_label'];
$fallback_label  = (string) $data['fallback_label'];
$button_class    = sanitize_text_field( (string) $data['button_class'] );
$card_class      = sanitize_text_field( (string) $data['card_class'] );
?>
<article class="<?php echo esc_attr( $card_class ); ?>">
	<div class="lumea-card-media-wrap">
	<a href="<?php echo $product_url; ?>" class="lumea-lp-media">
		<?php if ( $badge ) : ?>
		<span class="lumea-lp-badge<?php echo $is_sale ? ' lumea-lp-badge--sale' : ''; ?>"><?php echo esc_html( $badge ); ?></span>
		<?php endif; ?>
		<?php if ( $main_image ) : ?>
		<img src="<?php echo $main_image; ?>" alt="<?php echo esc_attr( $product_name ); ?>" class="lumea-lp-img lumea-lp-img--main" loading="lazy" />
		<?php endif; ?>
		<?php if ( $hover_image ) : ?>
		<img src="<?php echo $hover_image; ?>" alt="" class="lumea-lp-img lumea-lp-img--hover" loading="lazy" aria-hidden="true" />
		<?php endif; ?>
	</a>
	</div>
	<div class="lumea-lp-body">
		<?php if ( $category ) : ?>
		<p class="lumea-lp-category"><?php echo esc_html( $category ); ?></p>
		<?php endif; ?>
		<div class="lumea-lp-title-row">
			<h3 class="lumea-lp-name"><a href="<?php echo $product_url; ?>"><?php echo $product_name_esc; ?></a></h3>
			<?php if ( $product_id ) : ?>
			<button class="lumea-wish-btn" type="button" aria-label="<?php esc_attr_e( 'Add to wishlist', 'lumea' ); ?>" data-lumea-wish data-product_id="<?php echo esc_attr( $product_id ); ?>">
				<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
			</button>
			<?php endif; ?>
		</div>
		<div class="lumea-lp-pricing">
			<?php if ( $is_sale && $old_price_html ) : ?>
			<s class="lumea-lp-old"><?php echo wp_kses_post( $old_price_html ); ?></s>
			<?php endif; ?>
			<span class="lumea-lp-price<?php echo $is_sale ? ' lumea-lp-price--sale' : ''; ?>"><?php echo wp_kses_post( $price_html ); ?></span>
		</div>
		<?php if ( function_exists( 'lumea_render_product_card_actions' ) ) : ?>
			<?php
			lumea_render_product_card_actions(
				array(
					'product_id'      => $product_id,
					'product_url'     => $product_url_raw,
					'product_name'    => $product_name,
					'product_type'    => $product_type,
					'button_class'    => $button_class,
					'button_label'    => $button_label,
					'fallback_label'  => $fallback_label,
					'can_add_to_cart' => $can_add_to_cart,
					'supports_ajax'   => $supports_ajax,
				)
			);
			?>
		<?php else : ?>
		<div class="lumea-card-actions">
			<a href="<?php echo $product_url; ?>" class="<?php echo esc_attr( $button_class ); ?>"><?php echo esc_html( $fallback_label ); ?></a>
		</div>
		<?php endif; ?>
	</div>
</article>
