<?php
/**
 * My Account Dashboard.
 *
 * Shows the first intro screen on the account dashboard.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/dashboard.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 4.4.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$current_user = wp_get_current_user();
$first_name   = $current_user->first_name ?: $current_user->display_name;
$shop_url     = wc_get_page_permalink( 'shop' );

if ( ! $shop_url ) {
	$shop_url = home_url( '/shop/' );
}

/* Recent orders (last 3) */
$orders = wc_get_orders( array(
	'customer' => get_current_user_id(),
	'limit'    => 3,
	'orderby'  => 'date',
	'order'    => 'DESC',
) );
?>

<div class="lumea-dashboard">

	<!-- Welcome -->
	<div class="lumea-dashboard-welcome">
		<h2 class="lumea-dashboard-hi">
			<?php /* translators: %s customer first name */
			printf( esc_html__( 'Hello, %s', 'lumea' ), esc_html( $first_name ) ); ?>
		</h2>
		<p class="lumea-dashboard-intro">
			<?php esc_html_e( 'From your account dashboard you can view your recent orders, manage your shipping and billing addresses, and edit your account details.', 'lumea' ); ?>
		</p>
	</div>

	<!-- Quick stats -->
	<div class="lumea-dashboard-stats">
		<?php
		$total_orders = wc_get_customer_order_count( get_current_user_id() );
		$total_spent  = wc_price( wc_get_customer_total_spent( get_current_user_id() ) );
		?>
		<div class="lumea-dashboard-stat-card">
			<span class="lumea-dashboard-stat-num"><?php echo esc_html( $total_orders ); ?></span>
			<span class="lumea-dashboard-stat-label"><?php esc_html_e( 'Orders placed', 'lumea' ); ?></span>
		</div>
		<div class="lumea-dashboard-stat-card">
			<span class="lumea-dashboard-stat-num"><?php echo wp_kses_post( $total_spent ); ?></span>
			<span class="lumea-dashboard-stat-label"><?php esc_html_e( 'Total spent', 'lumea' ); ?></span>
		</div>
		<div class="lumea-dashboard-stat-card">
			<span class="lumea-dashboard-stat-num"><?php echo esc_html( $current_user->user_registered ? date_i18n( 'Y', strtotime( $current_user->user_registered ) ) : '—' ); ?></span>
			<span class="lumea-dashboard-stat-label"><?php esc_html_e( 'Member since', 'lumea' ); ?></span>
		</div>
	</div>

	<!-- Recent orders -->
	<?php if ( $orders ) : ?>
	<div class="lumea-dashboard-section">
		<div class="lumea-dashboard-section-header">
			<h3 class="lumea-dashboard-section-title"><?php esc_html_e( 'Recent Orders', 'lumea' ); ?></h3>
			<a href="<?php echo esc_url( wc_get_account_endpoint_url( 'orders' ) ); ?>" class="lumea-dashboard-section-link">
				<?php esc_html_e( 'View all', 'lumea' ); ?>
				<svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" aria-hidden="true"><polyline points="9 18 15 12 9 6"/></svg>
			</a>
		</div>
		<div class="lumea-dashboard-orders">
			<?php foreach ( $orders as $order ) :
				$order_items = $order->get_items();
				$first_item  = reset( $order_items );
				$product     = $first_item ? wc_get_product( $first_item->get_product_id() ) : null;
				$img_id      = $product ? $product->get_image_id() : 0;
				$img_url     = $img_id ? wp_get_attachment_image_url( $img_id, 'thumbnail' ) : '';
			?>
			<div class="lumea-dashboard-order-row">
				<div class="lumea-dashboard-order-img">
					<?php if ( $img_url ) : ?>
					<img src="<?php echo esc_url( $img_url ); ?>" alt="<?php echo esc_attr( $product ? $product->get_name() : '' ); ?>" loading="lazy">
					<?php endif; ?>
				</div>
				<div class="lumea-dashboard-order-info">
					<p class="lumea-dashboard-order-num"><?php printf( esc_html__( 'Order #%s', 'lumea' ), esc_html( $order->get_order_number() ) ); ?></p>
					<p class="lumea-dashboard-order-date"><?php echo esc_html( wc_format_datetime( $order->get_date_created() ) ); ?></p>
				</div>
				<div class="lumea-dashboard-order-status">
					<span class="lumea-dashboard-order-badge lumea-dashboard-order-badge--<?php echo esc_attr( $order->get_status() ); ?>">
						<?php echo esc_html( wc_get_order_status_name( $order->get_status() ) ); ?>
					</span>
				</div>
				<div class="lumea-dashboard-order-total">
					<?php echo wp_kses_post( $order->get_formatted_order_total() ); ?>
				</div>
				<a href="<?php echo esc_url( $order->get_view_order_url() ); ?>" class="lumea-dashboard-order-link" aria-label="<?php printf( esc_attr__( 'View order %s', 'lumea' ), $order->get_order_number() ); ?>">
					<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" aria-hidden="true"><polyline points="9 18 15 12 9 6"/></svg>
				</a>
			</div>
			<?php endforeach; ?>
		</div>
	</div>
	<?php endif; ?>

	<?php if ( ! $orders ) : ?>
	<div class="lumea-dashboard-section lumea-dashboard-empty">
		<h3 class="lumea-dashboard-section-title"><?php esc_html_e( 'No orders yet', 'lumea' ); ?></h3>
		<p class="lumea-dashboard-intro"><?php esc_html_e( 'When you place your first order, it will appear here with delivery updates.', 'lumea' ); ?></p>
		<a href="<?php echo esc_url( $shop_url ); ?>" class="lumea-dashboard-empty-cta"><?php esc_html_e( 'Start Shopping', 'lumea' ); ?></a>
	</div>
	<?php endif; ?>

	<!-- Quick actions -->
	<div class="lumea-dashboard-actions">
		<a href="<?php echo esc_url( wc_get_account_endpoint_url( 'edit-account' ) ); ?>" class="lumea-dashboard-action">
			<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
			<span><?php esc_html_e( 'Edit Profile', 'lumea' ); ?></span>
		</a>
		<a href="<?php echo esc_url( wc_get_account_endpoint_url( 'edit-address' ) ); ?>" class="lumea-dashboard-action">
			<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
			<span><?php esc_html_e( 'Addresses', 'lumea' ); ?></span>
		</a>
		<a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>" class="lumea-dashboard-action">
			<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 01-8 0"/></svg>
			<span><?php esc_html_e( 'Shop Now', 'lumea' ); ?></span>
		</a>
		<a href="<?php echo esc_url( wc_logout_url() ); ?>" class="lumea-dashboard-action lumea-dashboard-action--logout">
			<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
			<span><?php esc_html_e( 'Sign Out', 'lumea' ); ?></span>
		</a>
	</div>

	<?php
	/**
	 * My Account dashboard.
	 *
	 * @since 2.6.0
	 */
	do_action( 'woocommerce_account_dashboard' );

	/**
	 * Deprecated WooCommerce actions for backward compatibility.
	 *
	 * @deprecated 2.6.0
	 */
	do_action( 'woocommerce_before_my_account' );
	do_action( 'woocommerce_after_my_account' );
	?>

</div>
