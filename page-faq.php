<?php
/**
 * Template Name: FAQ
 * Frequently Asked Questions — Luméa premium edition.
 *
 * @package Lumea
 */

defined( 'ABSPATH' ) || exit;

$faq_hero_bg      = get_theme_mod( 'lumea_faq_hero_bg', LUMEA_THEME_URI . '/assets/images/bestsellers/cta-bg.jpg' );
$faq_hero_eyebrow = get_theme_mod( 'lumea_faq_hero_eyebrow', __( 'Help Centre', 'lumea' ) );
$faq_hero_title   = get_theme_mod( 'lumea_faq_hero_title', __( 'Frequently Asked Questions', 'lumea' ) );

get_header();

$support_email  = sanitize_email( get_theme_mod( 'lumea_support_email', get_option( 'admin_email' ) ) );
$faq_categories = array(
	'skincare' => array(
		'label' => __( 'Skincare', 'lumea' ),
		'items' => array(
			array(
				'q' => __( 'How do I know which products are right for my skin type?', 'lumea' ),
				'a' => sprintf(
					/* translators: %s: support email address. */
					__( 'Start with our Skin Quiz — a 2-minute questionnaire that analyses your concerns and environment to recommend a personalised ritual. You can also browse by Skin Concern in our Shop. If you are ever unsure, email our skincare specialists at %s.', 'lumea' ),
					$support_email
				),
			),
			array(
				'q' => __( 'Are Luméa products safe for sensitive skin?', 'lumea' ),
				'a' => __( 'Yes. Every formula is dermatologist-tested and free from synthetic fragrance, alcohol denat., parabens, and sulphates — the most common sensitisers. Our sensitive skin range is additionally tested with an independent clinical panel and carries a 0-reaction certification.', 'lumea' ),
			),
			array(
				'q' => __( 'How long before I see results?', 'lumea' ),
				'a' => __( 'Most customers notice improved texture and radiance within 14 days of consistent use. Clinical improvements — reduced fine lines, firmer skin, visibly even tone — are typically measured at 28 days. We recommend using each product for a minimum of one full cycle.', 'lumea' ),
			),
			array(
				'q' => __( 'Can I use Luméa products during pregnancy?', 'lumea' ),
				'a' => __( 'We always recommend consulting your healthcare provider before adding new skincare during pregnancy or breastfeeding. As a general guide, our Vitamin C serums and Hydration Collection are widely considered safe, while actives like retinol alternatives (Bakuchiol) warrant a conversation with your doctor.', 'lumea' ),
			),
			array(
				'q' => __( 'Are your products vegan?', 'lumea' ),
				'a' => __( 'All Luméa products are 100% vegan. We do not use any animal-derived ingredients (including beeswax, lanolin, or carmine) and are certified by The Vegan Society.', 'lumea' ),
			),
		),
	),
	'shipping' => array(
		'label' => __( 'Shipping', 'lumea' ),
		'items' => array(
			array(
				'q' => __( 'How long does delivery take?', 'lumea' ),
				'a' => __( 'Standard shipping: 3–5 business days. Express: 1–2 business days. International orders: 7–14 business days depending on destination. All orders are dispatched from our Sydney warehouse within 1 business day of being placed.', 'lumea' ),
			),
			array(
				'q' => __( 'Do you offer free shipping?', 'lumea' ),
				'a' => __( 'Yes — free standard shipping on all Australian orders over $50. International free shipping thresholds vary by region and are shown at checkout.', 'lumea' ),
			),
			array(
				'q' => __( 'Can I track my order?', 'lumea' ),
				'a' => __( 'Absolutely. You will receive a shipping confirmation email with a tracking link as soon as your order leaves our warehouse. You can also view order status any time in My Account.', 'lumea' ),
			),
			array(
				'q' => __( 'Do you ship internationally?', 'lumea' ),
				'a' => __( 'We ship to 40+ countries. Shipping costs and estimated delivery times are calculated at checkout based on your location. Please note customs duties and import taxes are the customer responsibility.', 'lumea' ),
			),
		),
	),
	'returns'  => array(
		'label' => __( 'Returns', 'lumea' ),
		'items' => array(
			array(
				'q' => __( 'What is your return policy?', 'lumea' ),
				'a' => __( 'We offer a 30-day happiness guarantee. If you are not satisfied with a product for any reason, contact us within 30 days of delivery for a full refund or exchange. Products must be at least 50% full.', 'lumea' ),
			),
			array(
				'q' => __( 'How do I start a return?', 'lumea' ),
				'a' => sprintf(
					/* translators: %s: support email address. */
					__( 'Email %s with your order number and reason for return. Our team will respond within 24 hours with a prepaid return label (Australia only) and next steps.', 'lumea' ),
					$support_email
				),
			),
			array(
				'q' => __( 'When will I receive my refund?', 'lumea' ),
				'a' => __( 'Refunds are processed within 2 business days of receiving the returned item. Funds typically appear in your account within 5–7 business days depending on your bank.', 'lumea' ),
			),
		),
	),
	'account'  => array(
		'label' => __( 'Account & Orders', 'lumea' ),
		'items' => array(
			array(
				'q' => __( 'How do I create an account?', 'lumea' ),
				'a' => __( 'Visit the My Account page and click “Create Account”. You will need your email address and a password. You can also create an account during checkout.', 'lumea' ),
			),
			array(
				'q' => __( 'I forgot my password. How do I reset it?', 'lumea' ),
				'a' => __( 'On the login page, click “Forgot password?” and enter your email address. You will receive a reset link within a few minutes. Check your spam folder if it does not appear.', 'lumea' ),
			),
			array(
				'q' => __( 'Can I modify or cancel my order?', 'lumea' ),
				'a' => sprintf(
					/* translators: %s: support email address. */
					__( 'Orders can be modified or cancelled within 1 hour of placement. After that, our warehouse begins picking and packing and changes can no longer be made. Contact us immediately at %s if you need to make a change.', 'lumea' ),
					$support_email
				),
			),
		),
	),
);
?>

<main class="lumea-faq-page" id="lumeaPage">

	<!-- Hero -->
	<div class="lumea-shop-hero" style="--shop-bg: url('<?php echo esc_url( $faq_hero_bg ); ?>')">
		<div class="lumea-shop-hero-overlay"></div>
		<div class="lumea-shop-hero-inner">
			<p class="lumea-shop-hero-eyebrow lumea-reveal-js lumea-reveal--fade-js lumea-reveal--hero-js"><?php echo esc_html( $faq_hero_eyebrow ); ?></p>
			<h1 class="lumea-shop-hero-title lumea-reveal-js lumea-reveal--fade-js lumea-reveal--hero-js"><?php echo esc_html( $faq_hero_title ); ?></h1>
		</div>
	</div>

	<!-- FAQ body -->
	<div class="lumea-faq-body">
		<div class="lumea-faq-body-inner">

			<!-- Category tabs -->
			<div class="lumea-faq-tabs lumea-reveal-js lumea-reveal--static-js" role="tablist" aria-label="<?php esc_attr_e( 'FAQ Categories', 'lumea' ); ?>">
				<?php
				$first = true;
				foreach ( $faq_categories as $key => $faq_category ) :
					?>
				<button type="button" class="lumea-faq-tab <?php echo esc_attr( $first ? 'is-active' : '' ); ?>"
						role="tab"
						aria-selected="<?php echo esc_attr( $first ? 'true' : 'false' ); ?>"
						tabindex="<?php echo esc_attr( $first ? '0' : '-1' ); ?>"
						aria-controls="lumea-faq-panel-<?php echo esc_attr( $key ); ?>"
						id="lumea-faq-tab-<?php echo esc_attr( $key ); ?>"
						data-faq-tab="<?php echo esc_attr( $key ); ?>">
					<?php echo esc_html( $faq_category['label'] ); ?>
				</button>
					<?php
					$first = false;
				endforeach;
				?>
			</div>

			<!-- Panels -->
			<?php
			$first = true;
			foreach ( $faq_categories as $key => $faq_category ) :
				?>
			<div class="lumea-faq-panel <?php echo esc_attr( $first ? 'is-active' : '' ); ?>"
				id="lumea-faq-panel-<?php echo esc_attr( $key ); ?>"
				role="tabpanel"
				aria-labelledby="lumea-faq-tab-<?php echo esc_attr( $key ); ?>"
				<?php
				if ( ! $first ) :
					?>
						hidden<?php endif; ?>>
				<?php
				foreach ( $faq_category['items'] as $i => $faq ) :
					$item_id = 'faq-' . $key . '-' . $i;
					?>
				<div class="lumea-faq-item" data-faq-item>
					<button type="button" class="lumea-faq-question"
							aria-expanded="false"
							aria-controls="<?php echo esc_attr( $item_id ); ?>"
							id="<?php echo esc_attr( $item_id . '-btn' ); ?>">
						<span><?php echo esc_html( $faq['q'] ); ?></span>
						<svg class="lumea-faq-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="6 9 12 15 18 9"/></svg>
					</button>
					<div class="lumea-faq-answer"
						id="<?php echo esc_attr( $item_id ); ?>"
						role="region"
						aria-labelledby="<?php echo esc_attr( $item_id . '-btn' ); ?>"
						hidden>
						<div class="lumea-faq-answer-inner">
							<p><?php echo esc_html( $faq['a'] ); ?></p>
						</div>
					</div>
				</div>
				<?php endforeach; ?>
			</div>
				<?php
				$first = false;
			endforeach;
			?>

		</div>
	</div>

	<!-- Still need help -->
	<div class="lumea-faq-cta">
		<div class="lumea-faq-cta-inner lumea-reveal-js lumea-reveal--static-js">
			<svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
			<div>
				<h2 class="lumea-faq-cta-title"><?php esc_html_e( 'Still have questions?', 'lumea' ); ?></h2>
				<p class="lumea-faq-cta-text"><?php esc_html_e( 'Our skincare specialists reply within 24 hours.', 'lumea' ); ?></p>
			</div>
			<a href="<?php echo esc_url( lumea_get_page_url( 'contact' ) ); ?>" class="lumea-faq-cta-btn">
				<?php esc_html_e( 'Contact Us', 'lumea' ); ?>
				<svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" aria-hidden="true"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
			</a>
		</div>
	</div>

</main>

<?php get_footer(); ?>
