<?php
if ( ! defined( 'ABSPATH' ) ) exit;
if ( ! class_exists( 'WooCommerce' ) ) return;
?>
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
