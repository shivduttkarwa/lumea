<?php
/**
 * Template Name: Coming Soon
 * Template Post Type: page
 *
 * Full-screen coming soon page. No header or footer.
 * Assign this template to any page via Page Attributes > Template.
 *
 * @package Lumea
 */

defined( 'ABSPATH' ) || exit;
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>

<body <?php body_class( 'lumea-coming-soon-body' ); ?>>
<?php wp_body_open(); ?>
<a class="skip-link screen-reader-text" href="#lumeaComingSoonMain"><?php esc_html_e( 'Skip to content', 'lumea' ); ?></a>

<main class="lumea-cs" id="lumeaComingSoonMain" role="main">

	<div class="lumea-cs-backdrop">
		<?php
		$cs_bg = get_theme_mod( 'lumea_hero_image', LUMEA_THEME_URI . '/assets/images/hero1.jpg' );
		if ( $cs_bg ) :
		?>
		<img src="<?php echo esc_url( $cs_bg ); ?>" alt="" class="lumea-cs-bg-img" aria-hidden="true" loading="eager">
		<?php endif; ?>
		<div class="lumea-cs-overlay"></div>
	</div>

	<div class="lumea-cs-inner">

		<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="lumea-cs-logo" aria-label="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>">
			<?php
			if ( has_custom_logo() ) {
				the_custom_logo();
			} else {
				echo esc_html( get_bloginfo( 'name' ) );
			}
			?>
		</a>

		<div class="lumea-cs-content">
			<?php
			while ( have_posts() ) :
				the_post();
				$cs_title    = get_the_title();
				$cs_subtitle = get_the_excerpt();
			?>

			<p class="lumea-cs-eyebrow"><?php esc_html_e( 'Something beautiful is coming', 'lumea' ); ?></p>

			<h1 class="lumea-cs-heading">
				<?php echo $cs_title ? esc_html( $cs_title ) : esc_html( get_bloginfo( 'name' ) ); ?>
			</h1>

			<?php if ( $cs_subtitle ) : ?>
			<p class="lumea-cs-sub"><?php echo esc_html( $cs_subtitle ); ?></p>
			<?php endif; ?>

			<!-- Email capture -->
			<?php if ( function_exists( 'wc_get_page_permalink' ) ) : ?>
			<form class="lumea-cs-form" action="<?php echo esc_url( home_url( '/' ) ); ?>" method="get">
				<input
					type="email"
					name="lumea_notify_email"
					class="lumea-cs-email"
					placeholder="<?php esc_attr_e( 'Enter your email', 'lumea' ); ?>"
					required
					aria-label="<?php esc_attr_e( 'Email address for launch notification', 'lumea' ); ?>"
				>
				<button type="submit" class="lumea-cs-btn"><?php esc_html_e( 'Notify Me', 'lumea' ); ?></button>
			</form>
			<?php endif; ?>

			<?php endwhile; ?>
		</div>

		<!-- Social links -->
		<?php
		$cs_instagram = get_theme_mod( 'lumea_footer_instagram', '' );
		$cs_tiktok    = get_theme_mod( 'lumea_footer_tiktok', '' );
		$cs_pinterest = get_theme_mod( 'lumea_footer_pinterest', '' );
		if ( $cs_instagram || $cs_tiktok || $cs_pinterest ) :
		?>
		<div class="lumea-cs-social">
			<?php if ( $cs_instagram ) : ?>
			<a href="<?php echo esc_url( $cs_instagram ); ?>" class="lumea-cs-social-link" target="_blank" rel="noopener noreferrer" aria-label="<?php esc_attr_e( 'Instagram', 'lumea' ); ?>">
				<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/></svg>
			</a>
			<?php endif; ?>
			<?php if ( $cs_tiktok ) : ?>
			<a href="<?php echo esc_url( $cs_tiktok ); ?>" class="lumea-cs-social-link" target="_blank" rel="noopener noreferrer" aria-label="<?php esc_attr_e( 'TikTok', 'lumea' ); ?>">
				<svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 0 1-2.88 2.5 2.89 2.89 0 0 1-2.89-2.89 2.89 2.89 0 0 1 2.89-2.89c.28 0 .54.04.79.1V9.01a6.32 6.32 0 0 0-.79-.05 6.34 6.34 0 0 0-6.34 6.34 6.34 6.34 0 0 0 6.34 6.34 6.34 6.34 0 0 0 6.33-6.34V8.69a8.17 8.17 0 0 0 4.78 1.52V6.74a4.85 4.85 0 0 1-1.01-.05z"/></svg>
			</a>
			<?php endif; ?>
			<?php if ( $cs_pinterest ) : ?>
			<a href="<?php echo esc_url( $cs_pinterest ); ?>" class="lumea-cs-social-link" target="_blank" rel="noopener noreferrer" aria-label="<?php esc_attr_e( 'Pinterest', 'lumea' ); ?>">
				<svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 0C5.373 0 0 5.373 0 12c0 5.084 3.163 9.426 7.627 11.174-.105-.949-.2-2.405.042-3.441.218-.937 1.407-5.965 1.407-5.965s-.359-.719-.359-1.782c0-1.668.967-2.914 2.171-2.914 1.023 0 1.518.769 1.518 1.69 0 1.029-.655 2.568-.994 3.995-.283 1.194.599 2.169 1.777 2.169 2.133 0 3.772-2.249 3.772-5.495 0-2.873-2.064-4.882-5.012-4.882-3.414 0-5.418 2.561-5.418 5.207 0 1.031.397 2.138.893 2.738a.36.36 0 0 1 .083.345l-.333 1.36c-.053.22-.174.267-.402.161-1.499-.698-2.436-2.889-2.436-4.649 0-3.785 2.75-7.262 7.929-7.262 4.163 0 7.398 2.967 7.398 6.931 0 4.136-2.607 7.464-6.227 7.464-1.216 0-2.359-.632-2.75-1.378l-.748 2.853c-.271 1.043-1.002 2.35-1.492 3.146C9.57 23.812 10.763 24 12 24c6.627 0 12-5.373 12-12S18.627 0 12 0z"/></svg>
			</a>
			<?php endif; ?>
		</div>
		<?php endif; ?>

		<p class="lumea-cs-copyright">&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?> <?php echo esc_html( get_bloginfo( 'name' ) ); ?></p>

	</div>

</main>

<?php wp_footer(); ?>
</body>
</html>
