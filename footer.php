<?php
/**
 * Footer template.
 *
 * @package Lumea
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$footer_links = array(
	1 => array( get_theme_mod( 'lumea_footer_link1_label', 'Shop' ),    get_theme_mod( 'lumea_footer_link1_url', '#' ) ),
	2 => array( get_theme_mod( 'lumea_footer_link2_label', 'Journal' ), get_theme_mod( 'lumea_footer_link2_url', '#' ) ),
	3 => array( get_theme_mod( 'lumea_footer_link3_label', 'About' ),   get_theme_mod( 'lumea_footer_link3_url', '#' ) ),
	4 => array( get_theme_mod( 'lumea_footer_link4_label', 'Contact' ), get_theme_mod( 'lumea_footer_link4_url', '#' ) ),
);
$footer_ig  = get_theme_mod( 'lumea_footer_instagram', '' );
$footer_tk  = get_theme_mod( 'lumea_footer_tiktok', '' );
$footer_pin = get_theme_mod( 'lumea_footer_pinterest', '' );
?>

<footer class="lumea-footer" role="contentinfo">
	<div class="lumea-footer-inner">

		<div class="lumea-footer-top">
			<div class="lumea-footer-brand">
				<span class="lumea-footer-logo">LUMÉA</span>
				<p class="lumea-footer-tagline"><?php echo esc_html( get_theme_mod( 'lumea_footer_tagline', 'Botanical skincare for luminous living.' ) ); ?></p>
			</div>

			<nav class="lumea-footer-nav" aria-label="<?php esc_attr_e( 'Footer navigation', 'lumea' ); ?>">
				<?php foreach ( $footer_links as $link ) :
					if ( ! $link[0] ) continue; ?>
				<a href="<?php echo esc_url( $link[1] ); ?>"><?php echo esc_html( $link[0] ); ?></a>
				<?php endforeach; ?>
			</nav>
		</div>

		<div class="lumea-footer-bottom">
			<p class="lumea-footer-copy">
				&copy; <?php echo esc_html( date( 'Y' ) ); ?> <?php echo esc_html( get_theme_mod( 'lumea_footer_copy', 'Luméa. All rights reserved.' ) ); ?>
			</p>

			<?php if ( $footer_ig || $footer_tk || $footer_pin ) : ?>
			<div class="lumea-footer-social">
				<?php if ( $footer_ig ) : ?>
				<a href="<?php echo esc_url( $footer_ig ); ?>" aria-label="<?php esc_attr_e( 'Instagram', 'lumea' ); ?>" target="_blank" rel="noopener noreferrer">
					<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"/><circle cx="12" cy="12" r="4"/><circle cx="17.5" cy="6.5" r="0.6" fill="currentColor" stroke="none"/></svg>
				</a>
				<?php endif; ?>
				<?php if ( $footer_tk ) : ?>
				<a href="<?php echo esc_url( $footer_tk ); ?>" aria-label="<?php esc_attr_e( 'TikTok', 'lumea' ); ?>" target="_blank" rel="noopener noreferrer">
					<svg width="17" height="17" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 0 1-2.88 2.5 2.89 2.89 0 0 1-2.89-2.89 2.89 2.89 0 0 1 2.89-2.89c.28 0 .54.04.79.1V9.01a6.34 6.34 0 0 0-.79-.05 6.34 6.34 0 0 0-6.34 6.34 6.34 6.34 0 0 0 6.34 6.34 6.34 6.34 0 0 0 6.33-6.34V8.69a8.22 8.22 0 0 0 4.84 1.55V6.79a4.85 4.85 0 0 1-1.07-.1z"/></svg>
				</a>
				<?php endif; ?>
				<?php if ( $footer_pin ) : ?>
				<a href="<?php echo esc_url( $footer_pin ); ?>" aria-label="<?php esc_attr_e( 'Pinterest', 'lumea' ); ?>" target="_blank" rel="noopener noreferrer">
					<svg width="17" height="17" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 0C5.373 0 0 5.373 0 12c0 5.084 3.163 9.426 7.627 11.174-.105-.949-.2-2.405.042-3.441.218-.937 1.407-5.965 1.407-5.965s-.359-.719-.359-1.782c0-1.668.967-2.914 2.171-2.914 1.023 0 1.518.769 1.518 1.69 0 1.029-.655 2.568-.994 3.995-.283 1.194.599 2.169 1.777 2.169 2.133 0 3.772-2.249 3.772-5.495 0-2.873-2.064-4.882-5.012-4.882-3.414 0-5.418 2.561-5.418 5.207 0 1.031.397 2.138.893 2.738a.36.36 0 0 1 .083.345l-.333 1.36c-.053.22-.174.267-.402.161-1.499-.698-2.436-2.889-2.436-4.649 0-3.785 2.75-7.262 7.929-7.262 4.163 0 7.398 2.967 7.398 6.931 0 4.136-2.607 7.464-6.227 7.464-1.216 0-2.359-.632-2.75-1.378l-.748 2.853c-.271 1.043-1.002 2.35-1.492 3.146C9.57 23.812 10.763 24 12 24c6.627 0 12-5.373 12-12S18.627 0 12 0z"/></svg>
				</a>
				<?php endif; ?>
			</div>
			<?php endif; ?>
		</div>

	</div>
</footer>

<?php if ( class_exists( 'WooCommerce' ) ) : ?>
<div class="lumea-cart-overlay" data-lumea-cart-overlay aria-hidden="true"></div>
<aside class="lumea-cart-drawer" id="lumeaCartDrawer" aria-label="<?php esc_attr_e( 'Shopping cart', 'lumea' ); ?>" aria-hidden="true" data-lumea-cart-drawer>
	<div class="lumea-drawer-head">
		<h2 class="lumea-drawer-title"><?php esc_html_e( 'Your Cart', 'lumea' ); ?></h2>
		<button class="lumea-drawer-close" aria-label="<?php esc_attr_e( 'Close cart', 'lumea' ); ?>" data-lumea-cart-close>
			<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
		</button>
	</div>
	<div class="lumea-drawer-body">
		<?php lumea_mini_cart_items(); ?>
	</div>
	<?php lumea_drawer_footer(); ?>
</aside>
<?php endif; ?>

<?php wp_footer(); ?>
</body>
</html>
