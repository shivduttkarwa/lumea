<?php
/**
 * Template Name: Contact
 * Contact page — Luméa premium edition.
 *
 * @package Lumea
 */

defined( 'ABSPATH' ) || exit;

$sent    = false;
$errors  = array();
$name    = '';
$email   = '';
$subject = '';
$message = '';

if ( isset( $_POST['lumea_contact_nonce'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['lumea_contact_nonce'] ) ), 'lumea_contact' ) ) {
	$name    = sanitize_text_field( wp_unslash( $_POST['contact_name'] ?? '' ) );
	$email   = sanitize_email( wp_unslash( $_POST['contact_email'] ?? '' ) );
	$subject = sanitize_text_field( wp_unslash( $_POST['contact_subject'] ?? '' ) );
	$message = sanitize_textarea_field( wp_unslash( $_POST['contact_message'] ?? '' ) );

	if ( empty( $name ) )    $errors[] = __( 'Please enter your name.', 'lumea' );
	if ( ! is_email( $email ) ) $errors[] = __( 'Please enter a valid email address.', 'lumea' );
	if ( empty( $message ) ) $errors[] = __( 'Please enter a message.', 'lumea' );

	if ( empty( $errors ) ) {
		$to      = get_option( 'admin_email' );
		
		
		$headers = array(
			'Content-Type: text/plain; charset=UTF-8',
			'Reply-To: ' . $email,
		);
		$body    = sprintf(
			"Name: %s\nEmail: %s\nSubject: %s\n\n%s",
			$name, $email, $subject, $message
		);
		wp_mail( $to, '[Luméa Contact] ' . ( $subject ?: 'New message' ), $body, $headers );
		$sent = true;
	}
}

get_header();
?>

<main class="lumea-contact-page" id="lumeaPage">

	<!-- Breadcrumb -->
	<nav class="lumea-pdp-breadcrumb" aria-label="<?php esc_attr_e( 'Breadcrumb', 'lumea' ); ?>">
		<div class="lumea-pdp-bc-inner">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'lumea' ); ?></a>
			<svg class="lumea-pdp-bc-arrow" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="9 18 15 12 9 6"/></svg>
			<span aria-current="page"><?php esc_html_e( 'Contact', 'lumea' ); ?></span>
		</div>
	</nav>

	<!-- Hero -->
	<div class="lumea-contact-hero">
		<div class="lumea-contact-hero-inner">
			<p class="lumea-cart-eyebrow"><?php esc_html_e( 'We\'d Love to Hear From You', 'lumea' ); ?></p>
			<h1 class="lumea-contact-title"><?php esc_html_e( 'Get in Touch', 'lumea' ); ?></h1>
			<p class="lumea-contact-subtitle"><?php esc_html_e( 'Questions about your order, a product recommendation, or just want to say hello — we reply within 24 hours.', 'lumea' ); ?></p>
		</div>
	</div>

	<!-- Body -->
	<div class="lumea-contact-body">
		<div class="lumea-contact-body-inner">

			<!-- Form -->
			<div class="lumea-contact-form-col">
				<div class="lumea-contact-card">

					<?php if ( $sent ) : ?>
					<div class="lumea-contact-success">
						<div class="lumea-contact-success-icon">
							<svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="20 6 9 17 4 12"/></svg>
						</div>
						<h2 class="lumea-contact-success-title"><?php esc_html_e( 'Message sent!', 'lumea' ); ?></h2>
						<p class="lumea-contact-success-text"><?php esc_html_e( 'Thank you for reaching out. We\'ll be in touch within 24 hours.', 'lumea' ); ?></p>
					</div>
					<?php else : ?>

					<?php if ( $errors ) : ?>
					<div class="lumea-contact-errors">
						<?php foreach ( $errors as $error ) : ?>
						<p><?php echo esc_html( $error ); ?></p>
						<?php endforeach; ?>
					</div>
					<?php endif; ?>

					<h2 class="lumea-contact-card-title"><?php esc_html_e( 'Send a Message', 'lumea' ); ?></h2>

					<form class="lumea-contact-form" method="post" action="">
						<?php wp_nonce_field( 'lumea_contact', 'lumea_contact_nonce' ); ?>

						<div class="lumea-contact-row lumea-contact-row--2col">
							<div class="lumea-contact-field">
								<label for="contact_name"><?php esc_html_e( 'Your name', 'lumea' ); ?> <span aria-hidden="true">*</span></label>
								<input type="text" id="contact_name" name="contact_name" class="lumea-contact-input" placeholder="<?php esc_attr_e( 'Jane Doe', 'lumea' ); ?>" value="<?php echo isset( $_POST['contact_name'] ) ? esc_attr( sanitize_text_field( wp_unslash( $_POST['contact_name'] ) ) ) : ''; ?>" required>
							</div>
							<div class="lumea-contact-field">
								<label for="contact_email"><?php esc_html_e( 'Email address', 'lumea' ); ?> <span aria-hidden="true">*</span></label>
								<input type="email" id="contact_email" name="contact_email" class="lumea-contact-input" placeholder="<?php esc_attr_e( 'you@example.com', 'lumea' ); ?>" value="<?php echo isset( $_POST['contact_email'] ) ? esc_attr( sanitize_email( wp_unslash( $_POST['contact_email'] ) ) ) : ''; ?>" required>
							</div>
						</div>

						<div class="lumea-contact-field">
							<label for="contact_subject"><?php esc_html_e( 'Subject', 'lumea' ); ?></label>
							<select id="contact_subject" name="contact_subject" class="lumea-contact-input lumea-contact-select">
								<option value=""><?php esc_html_e( 'Select a topic…', 'lumea' ); ?></option>
								<option value="Order enquiry" <?php selected( $subject, 'Order enquiry' ); ?>><?php esc_html_e( 'Order Enquiry', 'lumea' ); ?></option>
								<option value="Product recommendation" <?php selected( $subject, 'Product recommendation' ); ?>><?php esc_html_e( 'Product Recommendation', 'lumea' ); ?></option>
								<option value="Returns & exchanges" <?php selected( $subject, 'Returns & exchanges' ); ?>><?php esc_html_e( 'Returns & Exchanges', 'lumea' ); ?></option>
								<option value="Partnership" <?php selected( $subject, 'Partnership' ); ?>><?php esc_html_e( 'Partnership Enquiry', 'lumea' ); ?></option>
								<option value="Other" <?php selected( $subject, 'Other' ); ?>><?php esc_html_e( 'Other', 'lumea' ); ?></option>
							</select>
						</div>

						<div class="lumea-contact-field">
							<label for="contact_message"><?php esc_html_e( 'Message', 'lumea' ); ?> <span aria-hidden="true">*</span></label>
							<textarea id="contact_message" name="contact_message" class="lumea-contact-input lumea-contact-textarea" rows="5" placeholder="<?php esc_attr_e( 'Tell us how we can help…', 'lumea' ); ?>" required><?php echo isset( $_POST['contact_message'] ) ? esc_textarea( sanitize_textarea_field( wp_unslash( $_POST['contact_message'] ) ) ) : ''; ?></textarea>
						</div>

						<button type="submit" class="lumea-contact-submit">
							<?php esc_html_e( 'Send Message', 'lumea' ); ?>
							<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
						</button>
					</form>

					<?php endif; ?>
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
							<?php $support_email = sanitize_email( get_theme_mod( 'lumea_support_email', 'hello@lumeaskincare.com' ) ); ?>
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
						<a href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>" class="lumea-contact-quick-link">
							<span><?php esc_html_e( 'Track your order', 'lumea' ); ?></span>
							<svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" aria-hidden="true"><polyline points="9 18 15 12 9 6"/></svg>
						</a>
						<a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>" class="lumea-contact-quick-link">
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
