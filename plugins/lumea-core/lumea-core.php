<?php
/**
 * Plugin Name: Lumea Core
 * Description: Companion functionality for the Lumea theme.
 * Version: 1.0.3
 * Author: Shivdutt Karwa
 * License: GPL-2.0-or-later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: lumea-core
 * Domain Path: /languages
 *
 * @package LumeaCore
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


function lumea_core_load_textdomain() {
	load_plugin_textdomain( 'lumea-core', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
}
add_action( 'plugins_loaded', 'lumea_core_load_textdomain' );


function lumea_core_is_woocommerce_ready() {
	return class_exists( 'WooCommerce' ) && function_exists( 'WC' ) && WC()->cart;
}


function lumea_core_update_cart_qty() {
	check_ajax_referer( 'lumea_wishlist', 'nonce' );

	if ( ! lumea_core_is_woocommerce_ready() ) {
		wp_send_json_error( 'missing_cart' );
	}

	$product_id = isset( $_POST['product_id'] ) ? absint( wp_unslash( $_POST['product_id'] ) ) : 0;
	$quantity   = isset( $_POST['quantity'] ) ? intval( wp_unslash( $_POST['quantity'] ) ) : 0;

	if ( ! $product_id ) {
		wp_send_json_error( 'missing_product_id' );
	}

	$product = function_exists( 'wc_get_product' ) ? wc_get_product( $product_id ) : null;
	if ( ! $product ) {
		wp_send_json_error( 'invalid_product' );
	}

	$min_qty = max( 1, (int) $product->get_min_purchase_quantity() );
	$max_qty = (int) $product->get_max_purchase_quantity();
	$new_qty = max( 0, $quantity );

	if ( $new_qty > 0 && $new_qty < $min_qty ) {
		$new_qty = $min_qty;
	}
	if ( $max_qty > 0 && $new_qty > $max_qty ) {
		$new_qty = $max_qty;
	}

	$cart_item_key = null;
	foreach ( WC()->cart->get_cart() as $key => $item ) {
		if ( (int) $item['product_id'] === $product_id ) {
			$cart_item_key = $key;
			break;
		}
	}

	if ( $cart_item_key && $new_qty <= 0 ) {
		WC()->cart->remove_cart_item( $cart_item_key );
	} elseif ( $cart_item_key ) {
		WC()->cart->set_quantity( $cart_item_key, $new_qty, true );
	} elseif ( $new_qty > 0 ) {
		if ( ! $product->is_purchasable() || ! $product->is_in_stock() ) {
			wp_send_json_error( 'not_purchasable' );
		}

		$cart_item_key = WC()->cart->add_to_cart( $product_id, $new_qty );
		if ( ! $cart_item_key ) {
			wp_send_json_error( 'add_to_cart_failed' );
		}
	} else {
		wp_send_json_success(
			array(
				'count'     => WC()->cart->get_cart_contents_count(),
				'quantity'  => 0,
				'removed'   => true,
				'fragments' => apply_filters( 'woocommerce_add_to_cart_fragments', array() ),
			)
		);
	}

	WC()->cart->calculate_totals();

	wp_send_json_success(
		array(
			'count'     => WC()->cart->get_cart_contents_count(),
			'quantity'  => $new_qty,
			'removed'   => $new_qty <= 0,
			'fragments' => apply_filters( 'woocommerce_add_to_cart_fragments', array() ),
		)
	);
}
add_action( 'wp_ajax_lumea_update_cart_qty', 'lumea_core_update_cart_qty' );
add_action( 'wp_ajax_nopriv_lumea_update_cart_qty', 'lumea_core_update_cart_qty' );


function lumea_core_update_cart_line_qty() {
	$cart_nonce = isset( $_POST['cart_nonce'] ) ? sanitize_text_field( wp_unslash( $_POST['cart_nonce'] ) ) : '';
	if ( ! $cart_nonce || ! wp_verify_nonce( $cart_nonce, 'woocommerce-cart' ) ) {
		wp_send_json_error( 'invalid_nonce' );
	}

	if ( ! lumea_core_is_woocommerce_ready() ) {
		wp_send_json_error( 'missing_cart' );
	}

	$cart_item_key = isset( $_POST['cart_item_key'] ) ? sanitize_text_field( wp_unslash( $_POST['cart_item_key'] ) ) : '';
	$quantity      = isset( $_POST['quantity'] ) ? intval( wp_unslash( $_POST['quantity'] ) ) : 0;

	if ( '' === $cart_item_key ) {
		wp_send_json_error( 'missing_cart_item_key' );
	}

	$cart_contents = WC()->cart->get_cart();
	if ( ! isset( $cart_contents[ $cart_item_key ] ) ) {
		wp_send_json_error( 'not_in_cart' );
	}

	$cart_item = $cart_contents[ $cart_item_key ];
	$product   = isset( $cart_item['data'] ) ? $cart_item['data'] : null;

	if ( ! $product ) {
		wp_send_json_error( 'invalid_product' );
	}

	$min_qty = max( 0, (int) $product->get_min_purchase_quantity() );
	$max_qty = (int) $product->get_max_purchase_quantity();
	$new_qty = max( 0, $quantity );

	if ( $new_qty > 0 && $new_qty < $min_qty ) {
		$new_qty = $min_qty;
	}
	if ( $max_qty > 0 && $new_qty > $max_qty ) {
		$new_qty = $max_qty;
	}

	if ( $new_qty <= 0 ) {
		WC()->cart->remove_cart_item( $cart_item_key );
	} else {
		WC()->cart->set_quantity( $cart_item_key, $new_qty, true );
	}

	WC()->cart->calculate_totals();

	$updated_cart = WC()->cart->get_cart();
	$item_exists  = isset( $updated_cart[ $cart_item_key ] );

	$row_subtotal_html = '';
	$normalized_qty    = 0;

	if ( $item_exists ) {
		$updated_item      = $updated_cart[ $cart_item_key ];
		$normalized_qty    = (int) $updated_item['quantity'];
		$row_subtotal_html = apply_filters(
			'woocommerce_cart_item_subtotal',
			WC()->cart->get_product_subtotal( $updated_item['data'], $updated_item['quantity'] ),
			$updated_item,
			$cart_item_key
		);
	}

	ob_start();
	if ( function_exists( 'woocommerce_cart_totals' ) ) {
		woocommerce_cart_totals();
	}
	$cart_totals_html = ob_get_clean();

	$item_count = WC()->cart->get_cart_contents_count();
	$hero_title = sprintf(
		/* translators: %d: number of items in the cart */
		_n( 'Your Bag (%d item)', 'Your Bag (%d items)', $item_count, 'lumea-core' ),
		$item_count
	);

	wp_send_json_success(
		array(
			'cart_item_key'     => $cart_item_key,
			'removed'           => ! $item_exists,
			'quantity'          => $normalized_qty,
			'row_subtotal_html' => $row_subtotal_html,
			'cart_totals_html'  => $cart_totals_html,
			'item_count'        => $item_count,
			'hero_title'        => $hero_title,
			'cart_empty'        => WC()->cart->is_empty(),
			'fragments'         => apply_filters( 'woocommerce_add_to_cart_fragments', array() ),
		)
	);
}
add_action( 'wp_ajax_lumea_update_cart_line_qty', 'lumea_core_update_cart_line_qty' );
add_action( 'wp_ajax_nopriv_lumea_update_cart_line_qty', 'lumea_core_update_cart_line_qty' );


function lumea_core_get_wishlist_items() {
	check_ajax_referer( 'lumea_wishlist', 'nonce' );

	if ( ! class_exists( 'WooCommerce' ) || ! function_exists( 'wc_get_product' ) ) {
		wp_send_json_error( 'missing_woocommerce' );
	}

	$ids = array();
	if ( isset( $_POST['ids'] ) ) {
		$raw_ids = map_deep( wp_unslash( $_POST['ids'] ), 'sanitize_text_field' );
		$ids     = is_array( $raw_ids ) ? $raw_ids : explode( ',', (string) $raw_ids );
	}

	$ids   = array_filter( array_map( 'absint', $ids ) );
	$items = array();

	foreach ( $ids as $id ) {
		$product = wc_get_product( $id );
		if ( ! $product || ! $product->is_visible() ) {
			continue;
		}

		$price_text      = html_entity_decode(
			wp_strip_all_tags( $product->get_price_html() ),
			ENT_QUOTES,
			get_bloginfo( 'charset' )
		);
		$can_add_to_cart = $product->is_purchasable() && $product->is_in_stock();
		$cart_text       = $can_add_to_cart ? $product->add_to_cart_text() : __( 'View product', 'lumea-core' );
		$cart_aria       = $can_add_to_cart
			/* translators: %s: product name */
			? sprintf( __( 'Add %s to cart', 'lumea-core' ), $product->get_name() )
			/* translators: %s: product name */
			: sprintf( __( 'View %s', 'lumea-core' ), $product->get_name() );
		$image_url = wp_get_attachment_image_url( $product->get_image_id(), 'woocommerce_thumbnail' );

		$items[] = array(
			'id'              => $id,
			'name'            => $product->get_name(),
			'url'             => get_permalink( $id ),
			'price'           => $price_text,
			'image'           => $image_url ? $image_url : '',
			'type'            => $product->get_type(),
			'can_add_to_cart' => $can_add_to_cart,
			'supports_ajax'   => $can_add_to_cart && $product->supports( 'ajax_add_to_cart' ),
			'cart_url'        => $can_add_to_cart ? $product->add_to_cart_url() : get_permalink( $id ),
			'cart_text'       => $cart_text,
			'cart_aria'       => $cart_aria,
		);
	}

	wp_send_json_success( $items );
}
add_action( 'wp_ajax_lumea_wishlist_items', 'lumea_core_get_wishlist_items' );
add_action( 'wp_ajax_nopriv_lumea_wishlist_items', 'lumea_core_get_wishlist_items' );


function lumea_core_product_data_tab( $tabs ) {
	$tabs['lumea'] = array(
		'label'  => __( 'Lumea', 'lumea-core' ),
		'target' => 'lumea_product_data',
		'class'  => array(),
	);

	return $tabs;
}
add_filter( 'woocommerce_product_data_tabs', 'lumea_core_product_data_tab' );


function lumea_core_product_data_panel() {
	if ( ! current_user_can( 'edit_post', get_the_ID() ) ) {
		return;
	}

	echo '<div id="lumea_product_data" class="panel woocommerce_options_panel">';
	wp_nonce_field( 'lumea_core_save_product_meta', 'lumea_core_product_nonce' );

	if ( function_exists( 'woocommerce_wp_checkbox' ) ) {
		woocommerce_wp_checkbox(
			array(
				'id'          => '_lumea_is_bestseller',
				'label'       => __( 'Show in Bestsellers', 'lumea-core' ),
				'description' => __( 'Display on the homepage Bestsellers section.', 'lumea-core' ),
			)
		);
		woocommerce_wp_checkbox(
			array(
				'id'          => '_lumea_is_latest',
				'label'       => __( 'Show in Latest Products', 'lumea-core' ),
				'description' => __( 'Display on the homepage Latest Products section.', 'lumea-core' ),
			)
		);
	}

	echo '</div>';
}
add_action( 'woocommerce_product_data_panels', 'lumea_core_product_data_panel' );


function lumea_core_save_product_meta( $post_id ) {
	$product_nonce = isset( $_POST['lumea_core_product_nonce'] ) ? sanitize_text_field( wp_unslash( $_POST['lumea_core_product_nonce'] ) ) : '';
	if ( ! wp_verify_nonce( $product_nonce, 'lumea_core_save_product_meta' ) ) {
		return;
	}

	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	update_post_meta( $post_id, '_lumea_is_bestseller', isset( $_POST['_lumea_is_bestseller'] ) ? 'yes' : 'no' );
	update_post_meta( $post_id, '_lumea_is_latest', isset( $_POST['_lumea_is_latest'] ) ? 'yes' : 'no' );
}
add_action( 'woocommerce_process_product_meta', 'lumea_core_save_product_meta' );


function lumea_core_render_contact_form() {
	$sent           = false;
	$errors         = array();
	$name           = '';
	$email          = '';
	$subject        = '';
	$message        = '';
	$request_method = isset( $_SERVER['REQUEST_METHOD'] ) ? sanitize_key( wp_unslash( $_SERVER['REQUEST_METHOD'] ) ) : '';

	if ( 'post' === $request_method && isset( $_POST['lumea_contact_action'] ) ) {
		$contact_nonce = isset( $_POST['lumea_contact_nonce'] ) ? sanitize_text_field( wp_unslash( $_POST['lumea_contact_nonce'] ) ) : '';

		if ( ! wp_verify_nonce( $contact_nonce, 'lumea_contact' ) ) {
			$errors[] = __( 'Security check failed. Please refresh the page and try again.', 'lumea-core' );
		} else {
			$name    = isset( $_POST['contact_name'] ) ? sanitize_text_field( wp_unslash( $_POST['contact_name'] ) ) : '';
			$email   = isset( $_POST['contact_email'] ) ? sanitize_email( wp_unslash( $_POST['contact_email'] ) ) : '';
			$subject = isset( $_POST['contact_subject'] ) ? sanitize_text_field( wp_unslash( $_POST['contact_subject'] ) ) : '';
			$message = isset( $_POST['contact_message'] ) ? sanitize_textarea_field( wp_unslash( $_POST['contact_message'] ) ) : '';

			if ( empty( $name ) ) {
				$errors[] = __( 'Please enter your name.', 'lumea-core' );
			}
			if ( ! is_email( $email ) ) {
				$errors[] = __( 'Please enter a valid email address.', 'lumea-core' );
			}
			if ( empty( $message ) ) {
				$errors[] = __( 'Please enter a message.', 'lumea-core' );
			}

			if ( empty( $errors ) ) {
				$to      = sanitize_email( get_theme_mod( 'lumea_support_email', get_option( 'admin_email' ) ) );
				$headers = array(
					'Content-Type: text/plain; charset=UTF-8',
					sprintf( 'Reply-To: %s', $email ),
				);
				$body    = sprintf(
					/* translators: 1: sender name, 2: sender email, 3: selected subject, 4: message. */
					__( "Name: %1\$s\nEmail: %2\$s\nSubject: %3\$s\n\n%4\$s", 'lumea-core' ),
					$name,
					$email,
					$subject,
					$message
				);

				$mail_subject = sprintf(
					/* translators: %s: contact form subject. */
					__( '[Lumea Contact] %s', 'lumea-core' ),
					$subject ? $subject : __( 'New message', 'lumea-core' )
				);
				$sent = wp_mail( $to, $mail_subject, $body, $headers );
				if ( ! $sent ) {
					$errors[] = __( 'Your message could not be sent. Please try again.', 'lumea-core' );
				}
			}
		}
	}

	if ( $sent ) :
		?>
		<div class="lumea-contact-success">
			<div class="lumea-contact-success-icon">
				<svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="20 6 9 17 4 12"/></svg>
			</div>
			<h2 class="lumea-contact-success-title"><?php esc_html_e( 'Message sent!', 'lumea-core' ); ?></h2>
			<p class="lumea-contact-success-text"><?php esc_html_e( 'Thank you for reaching out. We will be in touch within 24 hours.', 'lumea-core' ); ?></p>
		</div>
		<?php
		return;
	endif;

	if ( $errors ) :
		?>
		<div class="lumea-contact-errors">
			<?php foreach ( $errors as $error ) : ?>
			<p><?php echo esc_html( $error ); ?></p>
			<?php endforeach; ?>
		</div>
		<?php
	endif;
	?>
	<h2 class="lumea-contact-card-title"><?php esc_html_e( 'Send a Message', 'lumea-core' ); ?></h2>

	<form class="lumea-contact-form" method="post" action="">
		<input type="hidden" name="lumea_contact_action" value="send">
		<?php wp_nonce_field( 'lumea_contact', 'lumea_contact_nonce' ); ?>

		<div class="lumea-contact-row lumea-contact-row--2col">
			<div class="lumea-contact-field">
				<label for="contact_name"><?php esc_html_e( 'Your name', 'lumea-core' ); ?> <span aria-hidden="true">*</span></label>
				<input type="text" id="contact_name" name="contact_name" class="lumea-contact-input" placeholder="<?php esc_attr_e( 'Jane Doe', 'lumea-core' ); ?>" value="<?php echo esc_attr( $name ); ?>" required>
			</div>
			<div class="lumea-contact-field">
				<label for="contact_email"><?php esc_html_e( 'Email address', 'lumea-core' ); ?> <span aria-hidden="true">*</span></label>
				<input type="email" id="contact_email" name="contact_email" class="lumea-contact-input" placeholder="<?php esc_attr_e( 'you@example.com', 'lumea-core' ); ?>" value="<?php echo esc_attr( $email ); ?>" required>
			</div>
		</div>

		<div class="lumea-contact-field">
			<label for="contact_subject"><?php esc_html_e( 'Subject', 'lumea-core' ); ?></label>
			<select id="contact_subject" name="contact_subject" class="lumea-contact-input lumea-contact-select">
				<option value=""><?php esc_html_e( 'Select a topic...', 'lumea-core' ); ?></option>
				<option value="Order enquiry" <?php selected( $subject, 'Order enquiry' ); ?>><?php esc_html_e( 'Order Enquiry', 'lumea-core' ); ?></option>
				<option value="Product recommendation" <?php selected( $subject, 'Product recommendation' ); ?>><?php esc_html_e( 'Product Recommendation', 'lumea-core' ); ?></option>
				<option value="Returns & exchanges" <?php selected( $subject, 'Returns & exchanges' ); ?>><?php esc_html_e( 'Returns & Exchanges', 'lumea-core' ); ?></option>
				<option value="Partnership" <?php selected( $subject, 'Partnership' ); ?>><?php esc_html_e( 'Partnership Enquiry', 'lumea-core' ); ?></option>
				<option value="Other" <?php selected( $subject, 'Other' ); ?>><?php esc_html_e( 'Other', 'lumea-core' ); ?></option>
			</select>
		</div>

		<div class="lumea-contact-field">
			<label for="contact_message"><?php esc_html_e( 'Message', 'lumea-core' ); ?> <span aria-hidden="true">*</span></label>
			<textarea id="contact_message" name="contact_message" class="lumea-contact-input lumea-contact-textarea" rows="5" placeholder="<?php esc_attr_e( 'Tell us how we can help...', 'lumea-core' ); ?>" required><?php echo esc_textarea( $message ); ?></textarea>
		</div>

		<button type="submit" class="lumea-btn btn-black">
			<?php esc_html_e( 'Send Message', 'lumea-core' ); ?>
			<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
		</button>
	</form>
	<?php
}


function lumea_core_contact_form_shortcode() {
	ob_start();
	lumea_core_render_contact_form();
	return ob_get_clean();
}
add_shortcode( 'lumea_contact_form', 'lumea_core_contact_form_shortcode' );


/**
 * Render post-sharing actions in the theme's presentation slot.
 */
function lumea_core_render_post_share_actions() {
	if ( ! is_singular( 'post' ) ) {
		return;
	}

	$post_url     = get_permalink();
	$post_title   = get_the_title();
	$x_url        = add_query_arg(
		array(
			'url'  => $post_url,
			'text' => $post_title,
		),
		'https://twitter.com/intent/tweet'
	);
	$facebook_url = add_query_arg( 'u', $post_url, 'https://www.facebook.com/sharer/sharer.php' );
	?>
	<div class="lumea-post-share">
		<span class="lumea-post-share-label"><?php esc_html_e( 'Share', 'lumea-core' ); ?></span>
		<a href="<?php echo esc_url( $x_url ); ?>" target="_blank" rel="noopener noreferrer" class="lumea-post-share-btn" aria-label="<?php esc_attr_e( 'Share on X', 'lumea-core' ); ?>">
			<svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-4.714-6.231-5.401 6.231H2.744l7.73-8.835L1.254 2.25H8.08l4.258 5.63zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
		</a>
		<a href="<?php echo esc_url( $facebook_url ); ?>" target="_blank" rel="noopener noreferrer" class="lumea-post-share-btn" aria-label="<?php esc_attr_e( 'Share on Facebook', 'lumea-core' ); ?>">
			<svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z"/></svg>
		</a>
	</div>
	<?php
}
add_action( 'lumea_post_share_actions', 'lumea_core_render_post_share_actions' );


/**
 * Process the coming-soon notification form.
 */
function lumea_core_handle_notify_request() {
	$nonce = isset( $_POST['lumea_notify_nonce'] ) ? sanitize_text_field( wp_unslash( $_POST['lumea_notify_nonce'] ) ) : '';

	if ( ! wp_verify_nonce( $nonce, 'lumea_notify' ) ) {
		wp_die(
			esc_html__( 'Security check failed. Please return and try again.', 'lumea-core' ),
			esc_html__( 'Request denied', 'lumea-core' ),
			array( 'response' => 403 )
		);
	}

	$email  = isset( $_POST['lumea_notify_email'] ) ? sanitize_email( wp_unslash( $_POST['lumea_notify_email'] ) ) : '';
	$status = 'invalid';

	if ( is_email( $email ) ) {
		$recipient = sanitize_email( get_option( 'admin_email' ) );
		$subject   = __( 'New launch notification request', 'lumea-core' );
		$body      = sprintf(
			/* translators: %s: subscriber email address. */
			__( 'Please notify this visitor when the site launches: %s', 'lumea-core' ),
			$email
		);
		$headers = array(
			'Content-Type: text/plain; charset=UTF-8',
			sprintf( 'Reply-To: %s', $email ),
		);

		$status = wp_mail( $recipient, $subject, $body, $headers ) ? 'success' : 'error';
	}

	$redirect = wp_get_referer();
	if ( ! $redirect ) {
		$redirect = home_url( '/' );
	}

	$redirect = remove_query_arg( 'lumea_notify', $redirect );
	wp_safe_redirect( add_query_arg( 'lumea_notify', $status, $redirect ) );
	exit;
}
add_action( 'admin_post_lumea_notify', 'lumea_core_handle_notify_request' );
add_action( 'admin_post_nopriv_lumea_notify', 'lumea_core_handle_notify_request' );
