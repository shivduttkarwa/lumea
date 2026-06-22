<?php
/**
 * Template Name: Contact
 * Contact page — Luméa premium edition.
 *
 * @package Lumea
 */

defined( 'ABSPATH' ) || exit;

$contact_hero_bg      = get_theme_mod( 'lumea_contact_hero_bg', LUMEA_THEME_URI . '/assets/images/bestsellers/cta-bg.jpg' );
$contact_hero_eyebrow = get_theme_mod( 'lumea_contact_hero_eyebrow', __( "We'd Love to Hear From You", 'lumea' ) );
$contact_hero_title   = get_theme_mod( 'lumea_contact_hero_title', __( 'Get in Touch', 'lumea' ) );

get_header();
?>

<main class="lumea-contact-page" id="lumeaPage">

	<!-- Hero -->
	<div class="lumea-shop-hero" style="--shop-bg: url('<?php echo esc_url( $contact_hero_bg ); ?>')">
		<div class="lumea-shop-hero-overlay"></div>
		<div class="lumea-shop-hero-inner">
			<p class="lumea-shop-hero-eyebrow lumea-reveal-js lumea-reveal--fade-js lumea-reveal--hero-js"><?php echo esc_html( $contact_hero_eyebrow ); ?></p>
			<h1 class="lumea-shop-hero-title lumea-reveal-js lumea-reveal--fade-js lumea-reveal--hero-js"><?php echo esc_html( $contact_hero_title ); ?></h1>
		</div>
	</div>

	<!-- Body -->
	<div class="lumea-contact-body">
		<div class="lumea-contact-body-inner">

			<!-- Form -->
			<div class="lumea-contact-form-col">
				<div class="lumea-contact-card">
					<?php
					if ( function_exists( 'lumea_core_render_contact_form' ) ) {
						lumea_core_render_contact_form();
					} else {
						?>
						<h2 class="lumea-contact-card-title"><?php esc_html_e( 'Send a Message', 'lumea' ); ?></h2>
						<p class="lumea-contact-success-text"><?php esc_html_e( 'Install and activate the Lumea Core plugin to enable the contact form.', 'lumea' ); ?></p>
						<?php
					}
					?>
				</div>
			</div>

			<!-- Info -->
			<div class="lumea-contact-info-col">

				<div class="lumea-contact-info-card">
					<h3 class="lumea-contact-info-title"><?php esc_html_e( 'Customer Care', 'lumea' ); ?></h3>
					<div class="lumea-contact-info-item">
						<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
						<div>
							<p class="lumea-contact-info-label"><?php esc_html_e( 'Email', 'lumea' ); ?></p>
							<?php $support_email = sanitize_email( get_theme_mod( 'lumea_support_email', get_option( 'admin_email' ) ) ); ?>
							<a href="mailto:<?php echo esc_attr( $support_email ); ?>" class="lumea-contact-info-value"><?php echo esc_html( $support_email ); ?></a>
						</div>
					</div>
					<div class="lumea-contact-info-item">
						<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
						<div>
							<p class="lumea-contact-info-label"><?php esc_html_e( 'Response time', 'lumea' ); ?></p>
							<p class="lumea-contact-info-value"><?php esc_html_e( 'Within 24 hours', 'lumea' ); ?></p>
						</div>
					</div>
					<div class="lumea-contact-info-item">
						<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
						<div>
							<p class="lumea-contact-info-label"><?php esc_html_e( 'Hours', 'lumea' ); ?></p>
							<p class="lumea-contact-info-value"><?php esc_html_e( 'Mon–Fri, 9am–6pm AEST', 'lumea' ); ?></p>
						</div>
					</div>
				</div>

				<div class="lumea-contact-info-card lumea-contact-info-card--dark">
					<h3 class="lumea-contact-info-title" style="color:#fff;"><?php esc_html_e( 'Quick Links', 'lumea' ); ?></h3>
					<div class="lumea-contact-quick-links">
						<a href="<?php echo esc_url( get_permalink( get_page_by_path( 'faq' ) ) ?: home_url( '/faq/' ) ); ?>" class="lumea-contact-quick-link">
							<span><?php esc_html_e( 'Browse FAQs', 'lumea' ); ?></span>
							<svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" aria-hidden="true"><polyline points="9 18 15 12 9 6"/></svg>
						</a>
						<a href="<?php echo esc_url( lumea_get_myaccount_url() ); ?>" class="lumea-contact-quick-link">
							<span><?php esc_html_e( 'Track your order', 'lumea' ); ?></span>
							<svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" aria-hidden="true"><polyline points="9 18 15 12 9 6"/></svg>
						</a>
						<a href="<?php echo esc_url( lumea_get_shop_url() ); ?>" class="lumea-contact-quick-link">
							<span><?php esc_html_e( 'Shop the Collection', 'lumea' ); ?></span>
							<svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" aria-hidden="true"><polyline points="9 18 15 12 9 6"/></svg>
						</a>
					</div>
				</div>

			</div>

		</div>
	</div>

</main>

<?php get_footer(); ?>
