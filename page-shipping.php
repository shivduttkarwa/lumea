<?php
/**
 * Template Name: Shipping & Returns
 * Shipping methods, delivery times and returns policy page.
 *
 * @package Lumea
 */

defined( 'ABSPATH' ) || exit;
get_header();

$support_email = sanitize_email( get_theme_mod( 'lumea_support_email', get_option( 'admin_email' ) ) );
$free_threshold = sanitize_text_field( get_theme_mod( 'lumea_free_shipping_threshold', '$75' ) );
?>

<main class="lumea-policy-page" id="lumeaPage">

	<nav class="lumea-pdp-breadcrumb" aria-label="<?php esc_attr_e( 'Breadcrumb', 'lumea' ); ?>">
		<div class="lumea-pdp-bc-inner">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'lumea' ); ?></a>
			<svg class="lumea-pdp-bc-arrow" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="9 18 15 12 9 6"/></svg>
			<span aria-current="page"><?php esc_html_e( 'Shipping & Returns', 'lumea' ); ?></span>
		</div>
	</nav>

	<div class="lumea-policy-hero">
		<div class="lumea-policy-hero-inner">
			<p class="lumea-cart-eyebrow"><?php esc_html_e( 'Transparent & Simple', 'lumea' ); ?></p>
			<h1 class="lumea-policy-hero-title"><?php esc_html_e( 'Shipping & Returns', 'lumea' ); ?></h1>
			<p class="lumea-policy-hero-sub"><?php esc_html_e( 'We ship worldwide with the same care we put into our formulas — sustainable packaging, carbon-neutral delivery, and a returns process that is genuinely hassle-free.', 'lumea' ); ?></p>
		</div>
	</div>

	<div class="lumea-policy-body">

		<section class="lumea-policy-section">
			<div class="lumea-policy-section-inner">
				<div class="lumea-policy-section-header">
					<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="var(--lumea-accent)" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="1" y="3" width="15" height="13"/><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/></svg>
					<h2><?php esc_html_e( 'Shipping Options', 'lumea' ); ?></h2>
				</div>

				<div class="lumea-shipping-methods">

					<div class="lumea-shipping-card lumea-shipping-card--featured">
						<div class="lumea-shipping-card-badge"><?php esc_html_e( 'Most Popular', 'lumea' ); ?></div>
						<div class="lumea-shipping-card-icon">
							<svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20 12V22H4V12"/><path d="M22 7H2v5h20V7z"/><path d="M12 22V7"/><path d="M12 7H7.5a2.5 2.5 0 0 1 0-5C11 2 12 7 12 7z"/><path d="M12 7h4.5a2.5 2.5 0 0 0 0-5C13 2 12 7 12 7z"/></svg>
						</div>
						<h3><?php esc_html_e( 'Free Standard Shipping', 'lumea' ); ?></h3>
						<?php
						/* translators: %s: free shipping threshold amount */
						echo '<p>' . esc_html( sprintf( __( 'On all orders over %s', 'lumea' ), $free_threshold ) ) . '</p>';
						?>
						<p class="lumea-shipping-card-time"><?php esc_html_e( '3–5 business days', 'lumea' ); ?></p>
					</div>

					<div class="lumea-shipping-card">
						<div class="lumea-shipping-card-icon">
							<svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="1" y="3" width="15" height="13"/><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/></svg>
						</div>
						<h3><?php esc_html_e( 'Standard Shipping', 'lumea' ); ?></h3>
						<p><?php esc_html_e( 'Australia wide, tracked delivery', 'lumea' ); ?></p>
						<p class="lumea-shipping-card-time"><?php esc_html_e( '3–5 business days', 'lumea' ); ?></p>
						<p class="lumea-shipping-card-price"><?php esc_html_e( '$8.95', 'lumea' ); ?></p>
					</div>

					<div class="lumea-shipping-card">
						<div class="lumea-shipping-card-icon">
							<svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
						</div>
						<h3><?php esc_html_e( 'Express Shipping', 'lumea' ); ?></h3>
						<p><?php esc_html_e( 'Priority overnight delivery', 'lumea' ); ?></p>
						<p class="lumea-shipping-card-time"><?php esc_html_e( '1–2 business days', 'lumea' ); ?></p>
						<p class="lumea-shipping-card-price"><?php esc_html_e( '$14.95', 'lumea' ); ?></p>
					</div>

					<div class="lumea-shipping-card">
						<div class="lumea-shipping-card-icon">
							<svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg>
						</div>
						<h3><?php esc_html_e( 'International', 'lumea' ); ?></h3>
						<p><?php esc_html_e( 'Worldwide tracked delivery', 'lumea' ); ?></p>
						<p class="lumea-shipping-card-time"><?php esc_html_e( '7–14 business days', 'lumea' ); ?></p>
						<p class="lumea-shipping-card-price"><?php esc_html_e( 'From $19.95', 'lumea' ); ?></p>
					</div>

				</div>

				<div class="lumea-shipping-note">
					<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
					<?php esc_html_e( 'Orders placed before 1pm AEST on business days are dispatched same day. All orders ship in our signature eco packaging made from 100% recycled materials.', 'lumea' ); ?>
				</div>
			</div>
		</section>

		<section class="lumea-policy-section lumea-policy-section--alt">
			<div class="lumea-policy-section-inner">
				<div class="lumea-policy-section-header">
					<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="var(--lumea-accent)" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="1 4 1 10 7 10"/><path d="M3.51 15a9 9 0 1 0 .49-3.07"/></svg>
					<h2><?php esc_html_e( 'Returns & Exchanges', 'lumea' ); ?></h2>
				</div>

				<div class="lumea-returns-grid">
					<div class="lumea-returns-policy">
						<div class="lumea-returns-badge">
							<span><?php esc_html_e( '30', 'lumea' ); ?></span>
							<small><?php esc_html_e( 'Day Returns', 'lumea' ); ?></small>
						</div>
						<p><?php esc_html_e( 'If you are not completely satisfied with your purchase, return it within 30 days for a full refund or exchange. Items must be unused, in their original packaging, and in re-saleable condition.', 'lumea' ); ?></p>
						<p><?php esc_html_e( 'Free return shipping within Australia. International customers are responsible for return shipping costs.', 'lumea' ); ?></p>
					</div>

					<div class="lumea-returns-steps">
						<h3><?php esc_html_e( 'How to return', 'lumea' ); ?></h3>

						<div class="lumea-returns-step">
							<span class="lumea-returns-step-num">01</span>
							<div>
								<strong><?php esc_html_e( 'Contact us', 'lumea' ); ?></strong>
								<?php if ( $support_email ) : ?>
								<p>
									<?php esc_html_e( 'Email', 'lumea' ); ?>
									<a href="mailto:<?php echo esc_attr( $support_email ); ?>"><?php echo esc_html( $support_email ); ?></a>
									<?php esc_html_e( 'with your order number and reason for return.', 'lumea' ); ?>
								</p>
								<?php else : ?>
								<p><?php esc_html_e( 'Contact our team with your order number and reason for return.', 'lumea' ); ?></p>
								<?php endif; ?>
							</div>
						</div>

						<div class="lumea-returns-step">
							<span class="lumea-returns-step-num">02</span>
							<div>
								<strong><?php esc_html_e( 'Receive your label', 'lumea' ); ?></strong>
								<p><?php esc_html_e( 'We will respond within 24 hours with a prepaid return label (Australia only) and packing instructions.', 'lumea' ); ?></p>
							</div>
						</div>

						<div class="lumea-returns-step">
							<span class="lumea-returns-step-num">03</span>
							<div>
								<strong><?php esc_html_e( 'Ship your item', 'lumea' ); ?></strong>
								<p><?php esc_html_e( 'Pack securely in the original box if possible and drop off at any Australia Post location.', 'lumea' ); ?></p>
							</div>
						</div>

						<div class="lumea-returns-step">
							<span class="lumea-returns-step-num">04</span>
							<div>
								<strong><?php esc_html_e( 'Refund processed', 'lumea' ); ?></strong>
								<p><?php esc_html_e( 'Your refund will be processed within 3–5 business days of us receiving your return. You will receive an email confirmation.', 'lumea' ); ?></p>
							</div>
						</div>

					</div>
				</div>
			</div>
		</section>

		<section class="lumea-policy-section">
			<div class="lumea-policy-section-inner">
				<div class="lumea-policy-section-header">
					<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="var(--lumea-accent)" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="10"/><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
					<h2><?php esc_html_e( 'Common Questions', 'lumea' ); ?></h2>
				</div>

				<div class="lumea-policy-faqs">

					<details class="lumea-policy-faq">
						<summary><?php esc_html_e( 'Can I change or cancel my order?', 'lumea' ); ?></summary>
						<p><?php esc_html_e( 'Orders can be modified or cancelled within 1 hour of placement. After that our warehouse begins processing and changes may not be possible. Please contact us immediately if you need to make a change.', 'lumea' ); ?></p>
					</details>

					<details class="lumea-policy-faq">
						<summary><?php esc_html_e( 'What if my item arrives damaged?', 'lumea' ); ?></summary>
						<p><?php esc_html_e( 'We are so sorry if this happens. Please photograph the packaging and product and email us within 48 hours of delivery. We will arrange a replacement or full refund immediately at no cost to you.', 'lumea' ); ?></p>
					</details>

					<details class="lumea-policy-faq">
						<summary><?php esc_html_e( 'Do you offer free samples?', 'lumea' ); ?></summary>
						<p><?php esc_html_e( 'Yes — we include a complimentary sample with every order. You can also request specific samples at checkout in the order notes field.', 'lumea' ); ?></p>
					</details>

					<details class="lumea-policy-faq">
						<summary><?php esc_html_e( 'How do I track my order?', 'lumea' ); ?></summary>
						<p><?php esc_html_e( 'A tracking number is emailed to you as soon as your order is dispatched. You can also view your order status at any time in your account under Order History.', 'lumea' ); ?></p>
					</details>

				</div>
			</div>
		</section>

		<div class="lumea-policy-cta">
			<p class="lumea-cart-eyebrow"><?php esc_html_e( 'Still have questions?', 'lumea' ); ?></p>
			<h2><?php esc_html_e( 'We are here to help', 'lumea' ); ?></h2>
			<p><?php esc_html_e( 'Our customer care team replies within 24 hours, Monday to Friday.', 'lumea' ); ?></p>
			<?php
			lumea_btn( array(
				'label' => __( 'Contact Us', 'lumea' ),
				'href'  => esc_url( get_permalink( get_page_by_path( 'contact' ) ) ?: home_url( '/contact/' ) ),
				'style' => 'dark',
			) );
			?>
		</div>

	</div>

</main>

<?php get_footer(); ?>
