<?php
/**
 * Template Name: FAQ
 * Frequently Asked Questions — Luméa premium edition.
 *
 * @package Lumea
 */

defined( 'ABSPATH' ) || exit;
get_header();

$support_email  = sanitize_email( get_theme_mod( 'lumea_support_email', get_option( 'admin_email' ) ) );
$faq_categories = array(
	'skincare'  => array(
		'label' => 'Skincare',
		'items' => array(
			array(
				'q' => 'How do I know which products are right for my skin type?',
				'a' => 'Start with our Skin Quiz — a 2-minute questionnaire that analyses your concerns and environment to recommend a personalised ritual. You can also browse by Skin Concern in our Shop. If you\'re ever unsure, email our skincare specialists at ' . $support_email . '.',
			),
			array(
				'q' => 'Are Luméa products safe for sensitive skin?',
				'a' => 'Yes. Every formula is dermatologist-tested and free from synthetic fragrance, alcohol denat., parabens, and sulphates — the most common sensitisers. Our sensitive skin range is additionally tested with an independent clinical panel and carries a 0-reaction certification.',
			),
			array(
				'q' => 'How long before I see results?',
				'a' => 'Most customers notice improved texture and radiance within 14 days of consistent use. Clinical improvements — reduced fine lines, firmer skin, visibly even tone — are typically measured at 28 days. We recommend using each product for a minimum of one full cycle.',
			),
			array(
				'q' => 'Can I use Luméa products during pregnancy?',
				'a' => 'We always recommend consulting your healthcare provider before adding new skincare during pregnancy or breastfeeding. As a general guide, our Vitamin C serums and Hydration Collection are widely considered safe, while actives like retinol alternatives (Bakuchiol) warrant a conversation with your doctor.',
			),
			array(
				'q' => 'Are your products vegan?',
				'a' => 'All Luméa products are 100% vegan. We do not use any animal-derived ingredients (including beeswax, lanolin, or carmine) and are certified by The Vegan Society.',
			),
		),
	),
	'shipping'  => array(
		'label' => 'Shipping',
		'items' => array(
			array(
				'q' => 'How long does delivery take?',
				'a' => 'Standard shipping: 3–5 business days. Express: 1–2 business days. International orders: 7–14 business days depending on destination. All orders are dispatched from our Sydney warehouse within 1 business day of being placed.',
			),
			array(
				'q' => 'Do you offer free shipping?',
				'a' => 'Yes — free standard shipping on all Australian orders over $50. International free shipping thresholds vary by region and are shown at checkout.',
			),
			array(
				'q' => 'Can I track my order?',
				'a' => 'Absolutely. You\'ll receive a shipping confirmation email with a tracking link as soon as your order leaves our warehouse. You can also view order status any time in My Account.',
			),
			array(
				'q' => 'Do you ship internationally?',
				'a' => 'We ship to 40+ countries. Shipping costs and estimated delivery times are calculated at checkout based on your location. Please note customs duties and import taxes are the customer\'s responsibility.',
			),
		),
	),
	'returns'   => array(
		'label' => 'Returns',
		'items' => array(
			array(
				'q' => 'What is your return policy?',
				'a' => 'We offer a 30-day happiness guarantee. If you\'re not satisfied with a product for any reason, contact us within 30 days of delivery for a full refund or exchange. Products must be at least 50% full.',
			),
			array(
				'q' => 'How do I start a return?',
				'a' => 'Email ' . $support_email . ' with your order number and reason for return. Our team will respond within 24 hours with a prepaid return label (Australia only) and next steps.',
			),
			array(
				'q' => 'When will I receive my refund?',
				'a' => 'Refunds are processed within 2 business days of receiving the returned item. Funds typically appear in your account within 5–7 business days depending on your bank.',
			),
		),
	),
	'account'   => array(
		'label' => 'Account & Orders',
		'items' => array(
			array(
				'q' => 'How do I create an account?',
				'a' => 'Visit the My Account page and click "Create Account". You\'ll need your email address and a password. You can also create an account during checkout.',
			),
			array(
				'q' => 'I forgot my password. How do I reset it?',
				'a' => 'On the login page, click "Forgot password?" and enter your email address. You\'ll receive a reset link within a few minutes. Check your spam folder if it doesn\'t appear.',
			),
			array(
				'q' => 'Can I modify or cancel my order?',
				'a' => 'Orders can be modified or cancelled within 1 hour of placement. After that, our warehouse begins picking and packing and changes can no longer be made. Contact us immediately at ' . $support_email . ' if you need to make a change.',
			),
		),
	),
);
?>

<main class="lumea-faq-page" id="lumeaPage">

	<!-- Breadcrumb -->
	<nav class="lumea-pdp-breadcrumb" aria-label="<?php esc_attr_e( 'Breadcrumb', 'lumea' ); ?>">
		<div class="lumea-pdp-bc-inner">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'lumea' ); ?></a>
			<svg class="lumea-pdp-bc-arrow" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="9 18 15 12 9 6"/></svg>
			<span aria-current="page"><?php esc_html_e( 'FAQ', 'lumea' ); ?></span>
		</div>
	</nav>

	<!-- Hero -->
	<div class="lumea-faq-hero">
		<div class="lumea-faq-hero-inner">
			<p class="lumea-cart-eyebrow"><?php esc_html_e( 'Help Centre', 'lumea' ); ?></p>
			<h1 class="lumea-faq-title"><?php esc_html_e( 'Frequently Asked Questions', 'lumea' ); ?></h1>
			<p class="lumea-faq-subtitle"><?php esc_html_e( 'Everything you need to know about our products, shipping, and returns.', 'lumea' ); ?></p>
		</div>
	</div>

	<!-- FAQ body -->
	<div class="lumea-faq-body">
		<div class="lumea-faq-body-inner">

			<!-- Category tabs -->
			<div class="lumea-faq-tabs" role="tablist" aria-label="<?php esc_attr_e( 'FAQ Categories', 'lumea' ); ?>">
				<?php $first = true; foreach ( $faq_categories as $key => $cat ) : ?>
				<button class="lumea-faq-tab <?php echo $first ? 'is-active' : ''; ?>"
						role="tab"
						aria-selected="<?php echo $first ? 'true' : 'false'; ?>"
						aria-controls="lumea-faq-panel-<?php echo esc_attr( $key ); ?>"
						id="lumea-faq-tab-<?php echo esc_attr( $key ); ?>"
						data-faq-tab="<?php echo esc_attr( $key ); ?>">
					<?php echo esc_html( $cat['label'] ); ?>
				</button>
				<?php $first = false; endforeach; ?>
			</div>

			<!-- Panels -->
			<?php $first = true; foreach ( $faq_categories as $key => $cat ) : ?>
			<div class="lumea-faq-panel <?php echo $first ? 'is-active' : ''; ?>"
				 id="lumea-faq-panel-<?php echo esc_attr( $key ); ?>"
				 role="tabpanel"
				 aria-labelledby="lumea-faq-tab-<?php echo esc_attr( $key ); ?>">
				<?php foreach ( $cat['items'] as $i => $faq ) :
					$item_id = 'faq-' . $key . '-' . $i;
				?>
				<div class="lumea-faq-item" data-faq-item>
					<button class="lumea-faq-question"
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
			<?php $first = false; endforeach; ?>

		</div>
	</div>

	<!-- Still need help -->
	<div class="lumea-faq-cta">
		<div class="lumea-faq-cta-inner">
			<svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
			<div>
				<h2 class="lumea-faq-cta-title"><?php esc_html_e( 'Still have questions?', 'lumea' ); ?></h2>
				<p class="lumea-faq-cta-text"><?php esc_html_e( 'Our skincare specialists reply within 24 hours.', 'lumea' ); ?></p>
			</div>
			<a href="<?php echo esc_url( get_permalink( get_page_by_path( 'contact' ) ) ?: home_url( '/contact/' ) ); ?>" class="lumea-faq-cta-btn">
				<?php esc_html_e( 'Contact Us', 'lumea' ); ?>
				<svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" aria-hidden="true"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
			</a>
		</div>
	</div>

</main>

<script>
(function () {
  'use strict';

  /* ── FAQ Tabs ───────────────────────────────────────────── */
  var tabs   = document.querySelectorAll('[data-faq-tab]');
  var panels = document.querySelectorAll('.lumea-faq-panel');

  tabs.forEach(function (tab) {
    tab.addEventListener('click', function () {
      var key = tab.getAttribute('data-faq-tab');

      tabs.forEach(function (t) {
        t.classList.remove('is-active');
        t.setAttribute('aria-selected', 'false');
      });
      panels.forEach(function (p) { p.classList.remove('is-active'); });

      tab.classList.add('is-active');
      tab.setAttribute('aria-selected', 'true');
      var panel = document.getElementById('lumea-faq-panel-' + key);
      if (panel) panel.classList.add('is-active');
    });
  });

  /* ── FAQ Accordion ──────────────────────────────────────── */
  document.querySelectorAll('[data-faq-item]').forEach(function (item) {
    var btn    = item.querySelector('.lumea-faq-question');
    var answer = item.querySelector('.lumea-faq-answer');
    if (!btn || !answer) return;

    btn.addEventListener('click', function () {
      var isOpen = !answer.hasAttribute('hidden');

      /* Close siblings */
      item.closest('.lumea-faq-panel').querySelectorAll('[data-faq-item]').forEach(function (sibling) {
        var sibAnswer = sibling.querySelector('.lumea-faq-answer');
        var sibBtn    = sibling.querySelector('.lumea-faq-question');
        if (sibAnswer && sibBtn) {
          sibAnswer.setAttribute('hidden', '');
          sibBtn.setAttribute('aria-expanded', 'false');
          sibling.classList.remove('is-open');
        }
      });

      if (!isOpen) {
        answer.removeAttribute('hidden');
        btn.setAttribute('aria-expanded', 'true');
        item.classList.add('is-open');
      }
    });
  });
})();
</script>

<?php get_footer(); ?>
