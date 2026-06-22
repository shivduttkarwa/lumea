<?php
/**
 * Cart page — Luméa premium edition.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 10.1.0
 */

defined( 'ABSPATH' ) || exit;

$cart       = WC()->cart;
$cart_items = $cart->get_cart();
$item_count = $cart->get_cart_contents_count();
?>

<div class="lumea-cart-page">
	<?php do_action( 'woocommerce_before_cart' ); ?>

	<!-- Breadcrumb -->
	<nav class="lumea-pdp-breadcrumb" aria-label="<?php esc_attr_e( 'Breadcrumb', 'lumea' ); ?>">
		<div class="lumea-pdp-bc-inner">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'lumea' ); ?></a>
			<svg class="lumea-pdp-bc-arrow" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="9 18 15 12 9 6"/></svg>
			<span aria-current="page"><?php esc_html_e( 'Your Bag', 'lumea' ); ?></span>
		</div>
	</nav>

	<div class="lumea-cart-hero">
		<div class="lumea-cart-hero-inner">
			<p class="lumea-cart-eyebrow"><?php esc_html_e( 'Review & Checkout', 'lumea' ); ?></p>
			<h1 class="lumea-cart-title">
				<?php
				echo esc_html( sprintf(
					_n( 'Your Bag (%d item)', 'Your Bag (%d items)', $item_count, 'lumea' ),
					$item_count
				) );
				?>
			</h1>
		</div>
	</div>

	<?php if ( ! $cart->is_empty() ) : ?>

	<div class="lumea-cart-body">
		<div class="lumea-cart-body-inner">

			<!-- Items -->
			<div class="lumea-cart-items-col">

				<form class="lumea-cart-form woocommerce-cart-form" action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post">

					<?php do_action( 'woocommerce_before_cart_table' ); ?>

					<!-- Column headers -->
					<div class="lumea-cart-thead">
						<span class="lumea-cart-th lumea-cart-th--media" aria-hidden="true"></span>
						<span class="lumea-cart-th lumea-cart-th--product"><?php esc_html_e( 'Product', 'lumea' ); ?></span>
						<span class="lumea-cart-th lumea-cart-th--price"><?php esc_html_e( 'Price', 'lumea' ); ?></span>
						<span class="lumea-cart-th lumea-cart-th--qty"><?php esc_html_e( 'Qty', 'lumea' ); ?></span>
						<span class="lumea-cart-th lumea-cart-th--total"><?php esc_html_e( 'Total', 'lumea' ); ?></span>
					</div>

					<?php do_action( 'woocommerce_before_cart_contents' ); ?>

					<?php foreach ( $cart_items as $cart_item_key => $cart_item ) :
						$_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
						$product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );
						$permalink  = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );

						if ( ! $_product || ! $_product->exists() || $cart_item['quantity'] === 0 ) continue;

						$thumbnail  = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image( 'woocommerce_thumbnail' ), $cart_item, $cart_item_key );
						$price      = apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key );
						$subtotal   = apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key );
						$item_class = apply_filters( 'woocommerce_cart_item_class', 'lumea-cart-row', $cart_item, $cart_item_key );

						$cats     = get_the_terms( $product_id, 'product_cat' );
						$cat_name = ( $cats && ! is_wp_error( $cats ) ) ? $cats[0]->name : '';
					?>

					<div class="<?php echo esc_attr( $item_class ); ?>" data-key="<?php echo esc_attr( $cart_item_key ); ?>">

						<!-- Remove -->
						<?php
						$remove_link = apply_filters( 'woocommerce_cart_item_remove_link',
							sprintf(
								'<a href="%s" class="lumea-cart-remove" aria-label="%s" data-product_id="%s" data-cart_item_key="%s" data-product_sku="%s">
									<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
								</a>',
								esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
								esc_html__( 'Remove item', 'lumea' ),
								esc_attr( $product_id ),
								esc_attr( $cart_item_key ),
								esc_attr( $_product->get_sku() )
							),
							$cart_item_key
						);
						echo wp_kses_post( $remove_link );
						?>

						<!-- Image -->
						<div class="lumea-cart-row-img">
							<?php if ( $permalink ) : ?>
							<a href="<?php echo esc_url( $permalink ); ?>">
								<?php echo wp_kses_post( $thumbnail ); ?>
							</a>
							<?php else : ?>
								<?php echo wp_kses_post( $thumbnail ); ?>
							<?php endif; ?>
						</div>

						<!-- Name -->
						<div class="lumea-cart-row-name">
							<?php if ( $cat_name ) : ?>
							<span class="lumea-cart-row-cat"><?php echo esc_html( $cat_name ); ?></span>
							<?php endif; ?>
							<?php if ( $permalink ) : ?>
							<a href="<?php echo esc_url( $permalink ); ?>" class="lumea-cart-row-title"><?php echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key ) ); ?></a>
							<?php else : ?>
							<span class="lumea-cart-row-title"><?php echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key ) ); ?></span>
							<?php endif; ?>
							<?php echo wc_get_formatted_cart_item_data( $cart_item ); ?>
						</div>

						<!-- Unit price -->
						<div class="lumea-cart-row-price" data-label="<?php esc_attr_e( 'Price', 'lumea' ); ?>">
							<?php echo wp_kses_post( $price ); ?>
						</div>

						<!-- Quantity -->
						<div class="lumea-cart-row-qty" data-label="<?php esc_attr_e( 'Qty', 'lumea' ); ?>">
							<div class="lumea-qty-stepper">
								<button type="button" class="lumea-qty-btn lumea-qty-minus" aria-label="<?php esc_attr_e( 'Decrease', 'lumea' ); ?>">
									<svg width="12" height="2" viewBox="0 0 12 2" fill="none" aria-hidden="true"><rect width="12" height="2" rx="1" fill="currentColor"/></svg>
								</button>
								<?php
								echo apply_filters( 'woocommerce_cart_item_quantity',
									sprintf(
										'<input type="number" class="qty lumea-qty-input" name="cart[%s][qty]" value="%s" min="%s" max="%s" step="1" aria-label="%s">',
										esc_attr( $cart_item_key ),
										esc_attr( $cart_item['quantity'] ),
										esc_attr( $_product->get_min_purchase_quantity() ),
										esc_attr( 0 < $_product->get_max_purchase_quantity() ? $_product->get_max_purchase_quantity() : '' ),
										esc_html__( 'Quantity', 'lumea' )
									),
									$cart_item_key,
									$cart_item
								);
								?>
								<button type="button" class="lumea-qty-btn lumea-qty-plus" aria-label="<?php esc_attr_e( 'Increase', 'lumea' ); ?>">
									<svg width="12" height="12" viewBox="0 0 12 12" fill="none" aria-hidden="true"><rect x="5" y="0" width="2" height="12" rx="1" fill="currentColor"/><rect x="0" y="5" width="12" height="2" rx="1" fill="currentColor"/></svg>
								</button>
							</div>
						</div>

						<!-- Line total -->
						<div class="lumea-cart-row-total" data-label="<?php esc_attr_e( 'Total', 'lumea' ); ?>">
							<?php echo wp_kses_post( $subtotal ); ?>
						</div>

					</div>

					<?php endforeach; ?>

					<?php do_action( 'woocommerce_cart_contents' ); ?>

					<!-- Actions row -->
					<div class="lumea-cart-actions">
						<a href="<?php echo esc_url( apply_filters( 'woocommerce_return_to_shop_redirect', wc_get_page_permalink( 'shop' ) ) ); ?>" class="lumea-cart-continue">
							<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="15 18 9 12 15 6"/></svg>
							<?php esc_html_e( 'Continue Shopping', 'lumea' ); ?>
						</a>
						<button type="submit" class="lumea-cart-update button" name="update_cart" value="<?php esc_attr_e( 'Update bag', 'lumea' ); ?>">
							<?php esc_html_e( 'Update Bag', 'lumea' ); ?>
						</button>
					</div>

					<?php do_action( 'woocommerce_after_cart_contents' ); ?>

					<?php wp_nonce_field( 'woocommerce-cart', 'woocommerce-cart-nonce' ); ?>

				</form>

				<?php do_action( 'woocommerce_after_cart_table' ); ?>

			</div><!-- /.lumea-cart-items-col -->

			<!-- Order summary -->
			<div class="lumea-cart-summary-col">
				<div class="lumea-cart-summary">

					<h2 class="lumea-cart-summary-title"><?php esc_html_e( 'Order Summary', 'lumea' ); ?></h2>

					<?php do_action( 'woocommerce_before_cart_totals' ); ?>

					<div class="lumea-cart-summary-totals" data-lumea-cart-summary-totals>
						<?php woocommerce_cart_totals(); ?>
					</div>

					<?php do_action( 'woocommerce_after_cart_totals' ); ?>

					<!-- Trust badges -->
					<div class="lumea-cart-trust">
						<div class="lumea-cart-trust-item">
							<svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
							<span><?php esc_html_e( 'Secure checkout', 'lumea' ); ?></span>
						</div>
						<div class="lumea-cart-trust-item">
							<svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="23 4 23 10 17 10"/><path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10"/></svg>
							<span><?php esc_html_e( '30-day free returns', 'lumea' ); ?></span>
						</div>
						<div class="lumea-cart-trust-item">
							<svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="1" y="3" width="15" height="13"/><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/></svg>
							<span><?php esc_html_e( 'Free shipping over $50', 'lumea' ); ?></span>
						</div>
					</div>

				</div>
			</div><!-- /.lumea-cart-summary-col -->

		</div>
	</div><!-- /.lumea-cart-body -->

	<?php endif; ?>

	<?php do_action( 'woocommerce_after_cart' ); ?>

</div><!-- /.lumea-cart-page -->

