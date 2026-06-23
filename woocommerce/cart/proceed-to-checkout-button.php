<?php
/**
 * Proceed to checkout button.
 *
 * @package Lumea
 * @version 7.0.1
 */

defined( 'ABSPATH' ) || exit;
?>

<a href="<?php echo esc_url( wc_get_checkout_url() ); ?>" class="checkout-button wc-forward lumea-btn btn-black">
	<?php esc_html_e( 'Proceed to checkout', 'woocommerce' ); ?>
</a>
