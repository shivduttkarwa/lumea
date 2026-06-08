<?php
/**
 * Order received / Thank you page — Luméa premium edition.
 *
 * @package Lumea
 * @version 8.0.0
 */

defined( 'ABSPATH' ) || exit;
?>

<div class="lumea-thankyou-page">

	<!-- Breadcrumb -->
	<nav class="lumea-pdp-breadcrumb" aria-label="<?php esc_attr_e( 'Breadcrumb', 'lumea' ); ?>">
		<div class="lumea-pdp-bc-inner">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'lumea' ); ?></a>
			<svg class="lumea-pdp-bc-arrow" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="9 18 15 12 9 6"/></svg>
			<a href="<?php echo esc_url( wc_get_cart_url() ); ?>"><?php esc_html_e( 'Your Bag', 'lumea' ); ?></a>
			<svg class="lumea-pdp-bc-arrow" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="9 18 15 12 9 6"/></svg>
			<span aria-current="page"><?php esc_html_e( 'Order Confirmed', 'lumea' ); ?></span>
		</div>
	</nav>

	<?php if ( $order ) : ?>

	<?php do_action( 'woocommerce_before_thankyou', $order->get_id() ); ?>

	<!-- Confirmation hero -->
	<div class="lumea-ty-hero">
		<div class="lumea-ty-hero-inner">
			<div class="lumea-ty-icon">
				<svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="20 6 9 17 4 12"/></svg>
			</div>
			<p class="lumea-cart-eyebrow"><?php esc_html_e( 'Thank You', 'lumea' ); ?></p>
			<h1 class="lumea-ty-title"><?php esc_html_e( 'Your order is confirmed', 'lumea' ); ?></h1>
			<p class="lumea-ty-subtitle">
				<?php
				echo wp_kses_post( sprintf(
					/* translators: %s: customer billing email address */
					__( 'We&rsquo;ve sent a confirmation to <strong>%s</strong>. Your ritual is on its way.', 'lumea' ),
					esc_html( $order->get_billing_email() )
				) );
				?>
			</p>

			<!-- Step indicator (Confirmation active) -->
			<div class="lumea-checkout-steps">
				<span class="lumea-checkout-step is-done">
					<span class="lumea-checkout-step-dot">
						<svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="20 6 9 17 4 12"/></svg>
					</span>
					<?php esc_html_e( 'Bag', 'lumea' ); ?>
				</span>
				<span class="lumea-checkout-step-line"></span>
				<span class="lumea-checkout-step is-done">
					<span class="lumea-checkout-step-dot">
						<svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="20 6 9 17 4 12"/></svg>
					</span>
					<?php esc_html_e( 'Details', 'lumea' ); ?>
				</span>
				<span class="lumea-checkout-step-line"></span>
				<span class="lumea-checkout-step is-active">
					<span class="lumea-checkout-step-dot"></span>
					<?php esc_html_e( 'Confirmation', 'lumea' ); ?>
				</span>
			</div>
		</div>
	</div>

	<!-- Main content -->
	<div class="lumea-ty-body">
		<div class="lumea-ty-body-inner">

			<!-- Order details column -->
			<div class="lumea-ty-left">

				<!-- Order meta -->
				<div class="lumea-ty-block">
					<div class="lumea-ty-meta-grid">
						<div class="lumea-ty-meta-item">
							<span class="lumea-ty-meta-label"><?php esc_html_e( 'Order number', 'lumea' ); ?></span>
							<span class="lumea-ty-meta-value">#<?php echo esc_html( $order->get_order_number() ); ?></span>
						</div>
						<div class="lumea-ty-meta-item">
							<span class="lumea-ty-meta-label"><?php esc_html_e( 'Date', 'lumea' ); ?></span>
							<span class="lumea-ty-meta-value"><?php echo esc_html( wc_format_datetime( $order->get_date_created() ) ); ?></span>
						</div>
						<div class="lumea-ty-meta-item">
							<span class="lumea-ty-meta-label"><?php esc_html_e( 'Total', 'lumea' ); ?></span>
							<span class="lumea-ty-meta-value"><?php echo wp_kses_post( $order->get_formatted_order_total() ); ?></span>
						</div>
						<div class="lumea-ty-meta-item">
							<span class="lumea-ty-meta-label"><?php esc_html_e( 'Payment', 'lumea' ); ?></span>
							<span class="lumea-ty-meta-value"><?php echo esc_html( $order->get_payment_method_title() ); ?></span>
						</div>
					</div>
				</div>

				<!-- Order items -->
				<div class="lumea-ty-block">
					<h2 class="lumea-ty-block-title"><?php esc_html_e( 'Your Order', 'lumea' ); ?></h2>
					<div class="lumea-ty-items">
						<?php foreach ( $order->get_items() as $item_id => $item ) :
							$product  = $item->get_product();
							$img_id   = $product ? $product->get_image_id() : 0;
							$img_url  = $img_id ? wp_get_attachment_image_url( $img_id, 'thumbnail' ) : '';
						?>
						<div class="lumea-ty-item">
							<div class="lumea-ty-item-img">
								<?php if ( $img_url ) : ?>
								<img src="<?php echo esc_url( $img_url ); ?>" alt="<?php echo esc_attr( $item->get_name() ); ?>" loading="lazy">
								<?php endif; ?>
								<span class="lumea-checkout-item-qty"><?php echo esc_html( $item->get_quantity() ); ?></span>
							</div>
							<div class="lumea-ty-item-info">
								<p class="lumea-ty-item-name"><?php echo esc_html( $item->get_name() ); ?></p>
								<?php echo wc_display_item_meta( $item, array( 'echo' => false ) ); ?>
							</div>
							<div class="lumea-ty-item-price"><?php echo wp_kses_post( $order->get_formatted_line_subtotal( $item ) ); ?></div>
						</div>
						<?php endforeach; ?>
					</div>

					<!-- Totals -->
					<div class="lumea-ty-totals">
						<?php foreach ( $order->get_order_item_totals() as $key => $total ) : ?>
						<div class="lumea-ty-total-row <?php echo $key === 'order_total' ? 'lumea-ty-total-row--grand' : ''; ?>">
							<span><?php echo esc_html( $total['label'] ); ?></span>
							<span><?php echo wp_kses_post( $total['value'] ); ?></span>
						</div>
						<?php endforeach; ?>
					</div>
				</div>

				<!-- Delivery address -->
				<div class="lumea-ty-block">
					<h2 class="lumea-ty-block-title"><?php esc_html_e( 'Delivery Address', 'lumea' ); ?></h2>
					<address class="lumea-ty-address">
						<?php echo wp_kses_post( $order->get_formatted_shipping_address() ?: $order->get_formatted_billing_address() ); ?>
					</address>
				</div>

				<?php
				
				
				
				remove_action( 'woocommerce_thankyou', 'woocommerce_order_details_table', 10 );

				do_action( 'woocommerce_thankyou_' . $order->get_payment_method(), $order->get_id() );
				do_action( 'woocommerce_thankyou', $order->get_id() );
				?>

			</div><!-- /.lumea-ty-left -->

			<!-- CTA column -->
			<div class="lumea-ty-right">

				<!-- What's next -->
				<div class="lumea-ty-next-card">
					<h3 class="lumea-ty-next-title"><?php esc_html_e( 'What happens next?', 'lumea' ); ?></h3>
					<ol class="lumea-ty-steps-list">
						<li>
							<span class="lumea-ty-step-num">01</span>
							<div>
								<strong><?php esc_html_e( 'Order Processing', 'lumea' ); ?></strong>
								<p><?php esc_html_e( 'Our team carefully prepares and quality-checks your order.', 'lumea' ); ?></p>
							</div>
						</li>
						<li>
							<span class="lumea-ty-step-num">02</span>
							<div>
								<strong><?php esc_html_e( 'Dispatched', 'lumea' ); ?></strong>
								<p><?php esc_html_e( 'You\'ll receive a shipping confirmation with tracking details.', 'lumea' ); ?></p>
							</div>
						</li>
						<li>
							<span class="lumea-ty-step-num">03</span>
							<div>
								<strong><?php esc_html_e( 'Delivered', 'lumea' ); ?></strong>
								<p><?php esc_html_e( 'Your ritual arrives, elegantly packaged, ready to transform your routine.', 'lumea' ); ?></p>
							</div>
						</li>
					</ol>
				</div>

				<!-- Account creation prompt for guests -->
				<?php if ( ! is_user_logged_in() && $order->get_customer_id() === 0 ) : ?>
				<div class="lumea-ty-account-card">
					<p class="lumea-ty-account-text"><?php esc_html_e( 'Create an account to track your order, save your skin profile, and earn rewards.', 'lumea' ); ?></p>
					<a href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>" class="lumea-ty-account-btn"><?php esc_html_e( 'Create Account', 'lumea' ); ?></a>
				</div>
				<?php endif; ?>

				<!-- Continue shopping -->
				<a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>" class="lumea-ty-shop-btn">
					<?php esc_html_e( 'Continue Shopping', 'lumea' ); ?>
					<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
				</a>

			</div><!-- /.lumea-ty-right -->

		</div>
	</div><!-- /.lumea-ty-body -->

	<?php else : ?>

	<!-- Fallback (no order object) -->
	<div class="lumea-ty-fallback">
		<div class="lumea-ty-hero-inner" style="text-align:center;padding:80px 24px;">
			<p class="lumea-cart-eyebrow"><?php esc_html_e( 'Thank You', 'lumea' ); ?></p>
			<h1 class="lumea-ty-title"><?php esc_html_e( 'Your order is confirmed', 'lumea' ); ?></h1>
			<p class="lumea-ty-subtitle"><?php esc_html_e( 'A confirmation email is on its way.', 'lumea' ); ?></p>
			<a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>" class="lumea-ty-shop-btn" style="margin-top:32px;"><?php esc_html_e( 'Continue Shopping', 'lumea' ); ?></a>
		</div>
	</div>

	<?php endif; ?>

</div><!-- /.lumea-thankyou-page -->
