<?php
/**
 * Footer template — editorial with video brand mask.
 *
 * @package Lumea
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$shop_url        = function_exists( 'wc_get_page_id' ) ? get_permalink( wc_get_page_id( 'shop' ) ) : home_url( '/shop/' );
$blog_url        = get_option( 'page_for_posts' ) ? get_permalink( get_option( 'page_for_posts' ) ) : home_url( '/blog/' );
$about_url       = ( $ap = get_page_by_path( 'about' ) )   ? get_permalink( $ap ) : home_url( '/about/' );
$contact_url     = ( $cp = get_page_by_path( 'contact' ) ) ? get_permalink( $cp ) : home_url( '/contact/' );
$bestseller_term = get_term_by( 'name', 'Bestseller', 'product_cat' );
$bestseller_url  = $bestseller_term ? get_term_link( $bestseller_term ) : $shop_url;

$footer_headline         = get_theme_mod( 'lumea_footer_headline',        'Discover your skin&rsquo;s new ritual. Start today.' );
$footer_cta_text         = get_theme_mod( 'lumea_footer_cta_text',        'Shop Collection' );
$footer_copy             = get_theme_mod( 'lumea_footer_copy',            'Luméa · Botanical Skincare' );
$footer_connect_heading  = get_theme_mod( 'lumea_footer_connect_heading', 'Connect' );
$footer_address          = get_theme_mod( 'lumea_footer_address',         '' );
$footer_email            = get_theme_mod( 'lumea_footer_email',           '' );
$footer_ig               = get_theme_mod( 'lumea_footer_instagram',       '' );
$footer_tk               = get_theme_mod( 'lumea_footer_tiktok',          '' );
$footer_pin              = get_theme_mod( 'lumea_footer_pinterest',       '' );
$footer_video            = get_theme_mod( 'lumea_footer_video',           LUMEA_THEME_URI . '/assets/images/hero/footer-vd.mp4' );
$footer_video_poster     = get_theme_mod( 'lumea_footer_video_poster',    LUMEA_THEME_URI . '/assets/images/hero/latest-hero.jpg' );

$nav_links = array(
	array( __( 'Home',        'lumea' ), home_url( '/' ) ),
	array( __( 'Shop',        'lumea' ), $shop_url ),
	array( __( 'Bestsellers', 'lumea' ), $bestseller_url ),
	array( __( 'Blog',        'lumea' ), $blog_url ),
	array( __( 'About',       'lumea' ), $about_url ),
	array( __( 'Contact',     'lumea' ), $contact_url ),
);
?>

<footer class="lumea-footer" role="contentinfo">

	<!-- ── Main content row ────────────────────────────────── -->
	<div class="lumea-footer-main">
		<div class="lumea-footer-inner">

			<!-- Col 1: CTA -->
			<div class="lumea-footer-col lumea-footer-col--cta">
				<p class="lumea-footer-headline"><?php echo wp_kses_post( $footer_headline ); ?></p>
				<a href="<?php echo esc_url( $shop_url ); ?>" class="lumea-footer-cta-btn">
					<span><?php echo esc_html( $footer_cta_text ); ?></span>
					<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="7" y1="17" x2="17" y2="7"/><polyline points="7 7 17 7 17 17"/></svg>
				</a>
				<p class="lumea-footer-copy">&copy; <?php echo esc_html( date( 'Y' ) ); ?> <?php echo esc_html( $footer_copy ); ?></p>
			</div>

			<!-- Col 2: Nav -->
			<nav class="lumea-footer-col lumea-footer-col--nav" aria-label="<?php esc_attr_e( 'Footer navigation', 'lumea' ); ?>">
				<?php foreach ( $nav_links as $l ) : ?>
				<a href="<?php echo esc_url( $l[1] ); ?>"><?php echo esc_html( $l[0] ); ?></a>
				<?php endforeach; ?>
			</nav>

			<!-- Col 3: Connect -->
			<div class="lumea-footer-col lumea-footer-col--connect">
				<h3 class="lumea-footer-connect-h"><?php echo esc_html( $footer_connect_heading ); ?></h3>

				<!-- Social icons always visible directly below Connect heading -->
				<div class="lumea-footer-social">
					<a href="<?php echo $footer_ig  ? esc_url( $footer_ig )  : '#'; ?>" aria-label="<?php esc_attr_e( 'Instagram', 'lumea' ); ?>" <?php echo $footer_ig  ? 'target="_blank" rel="noopener noreferrer"' : 'tabindex="-1"'; ?>>
						<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="2" y="2" width="20" height="20" rx="5"/><circle cx="12" cy="12" r="4"/><circle cx="17.5" cy="6.5" r="0.6" fill="currentColor" stroke="none"/></svg>
					</a>
					<a href="<?php echo $footer_tk  ? esc_url( $footer_tk )  : '#'; ?>" aria-label="<?php esc_attr_e( 'TikTok', 'lumea' ); ?>" <?php echo $footer_tk  ? 'target="_blank" rel="noopener noreferrer"' : 'tabindex="-1"'; ?>>
						<svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 0 1-2.88 2.5 2.89 2.89 0 0 1-2.89-2.89 2.89 2.89 0 0 1 2.89-2.89c.28 0 .54.04.79.1V9.01a6.34 6.34 0 0 0-.79-.05 6.34 6.34 0 0 0-6.34 6.34 6.34 6.34 0 0 0 6.34 6.34 6.34 6.34 0 0 0 6.33-6.34V8.69a8.22 8.22 0 0 0 4.84 1.55V6.79a4.85 4.85 0 0 1-1.07-.1z"/></svg>
					</a>
					<a href="<?php echo $footer_pin ? esc_url( $footer_pin ) : '#'; ?>" aria-label="<?php esc_attr_e( 'Pinterest', 'lumea' ); ?>" <?php echo $footer_pin ? 'target="_blank" rel="noopener noreferrer"' : 'tabindex="-1"'; ?>>
						<svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 0C5.373 0 0 5.373 0 12c0 5.084 3.163 9.426 7.627 11.174-.105-.949-.2-2.405.042-3.441.218-.937 1.407-5.965 1.407-5.965s-.359-.719-.359-1.782c0-1.668.967-2.914 2.171-2.914 1.023 0 1.518.769 1.518 1.69 0 1.029-.655 2.568-.994 3.995-.283 1.194.599 2.169 1.777 2.169 2.133 0 3.772-2.249 3.772-5.495 0-2.873-2.064-4.882-5.012-4.882-3.414 0-5.418 2.561-5.418 5.207 0 1.031.397 2.138.893 2.738a.36.36 0 0 1 .083.345l-.333 1.36c-.053.22-.174.267-.402.161-1.499-.698-2.436-2.889-2.436-4.649 0-3.785 2.75-7.262 7.929-7.262 4.163 0 7.398 2.967 7.398 6.931 0 4.136-2.607 7.464-6.227 7.464-1.216 0-2.359-.632-2.75-1.378l-.748 2.853c-.271 1.043-1.002 2.35-1.492 3.146C9.57 23.812 10.763 24 12 24c6.627 0 12-5.373 12-12S18.627 0 12 0z"/></svg>
					</a>
				</div>

				<?php if ( $footer_address ) : ?>
				<p class="lumea-footer-address"><?php echo nl2br( esc_html( $footer_address ) ); ?></p>
				<?php endif; ?>
				<?php if ( $footer_email ) : ?>
				<a href="mailto:<?php echo esc_attr( $footer_email ); ?>" class="lumea-footer-email"><?php echo esc_html( $footer_email ); ?></a>
				<?php endif; ?>
			</div>

		</div>
	</div>

	<!-- ── Brand mask (video through letters) ──────────────── -->
	<div class="lumea-footer-brand" aria-hidden="true">
		<div class="lumea-footer-brand-text">LUMÉA</div>
		<?php if ( $footer_video ) : ?>
		<video
			class="lumea-footer-brand-video"
			autoplay muted loop playsinline
			poster="<?php echo esc_url( $footer_video_poster ); ?>"
			preload="none"
		>
			<source src="<?php echo esc_url( $footer_video ); ?>" type="video/mp4">
		</video>
		<?php else : ?>
		<div class="lumea-footer-brand-imgfallback" style="background-image:url('<?php echo esc_url( $footer_video_poster ); ?>')"></div>
		<?php endif; ?>
	</div>

</footer>

<?php get_template_part( 'template-parts/components/cart-drawer' ); ?>

<?php wp_footer(); ?>
</body>
</html>
