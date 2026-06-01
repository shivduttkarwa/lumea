<?php
/**
 * Email Styles.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/email-styles.php.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates\Emails
 * @version 4.0.0
 */

defined( 'ABSPATH' ) || exit;

$lumea_bg          = '#f9f7f5';
$lumea_body_bg     = '#ffffff';
$lumea_text        = '#1a1a1a';
$lumea_muted       = '#666666';
$lumea_accent      = '#c9a96e';
$lumea_border      = '#ece8e2';
$lumea_header_bg   = '#1a1a1a';
$lumea_btn_bg      = '#1a1a1a';
$lumea_btn_text    = '#ffffff';
?>
#wrapper {
	background-color: <?php echo esc_attr( $lumea_bg ); ?>;
	margin: 0;
	padding: 70px 0 70px 0;
	-webkit-text-size-adjust: none !important;
	width: 100%;
}

#template_container {
	box-shadow: none;
	border-radius: 8px;
	border: 1px solid <?php echo esc_attr( $lumea_border ); ?>;
}

#template_header {
	background-color: <?php echo esc_attr( $lumea_header_bg ); ?>;
	border-radius: 8px 8px 0 0;
	border-bottom: 3px solid <?php echo esc_attr( $lumea_accent ); ?>;
	color: #ffffff;
	font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
	font-size: 26px;
	font-weight: 700;
	letter-spacing: 0.18em;
	line-height: 100%;
	text-align: center;
	text-transform: uppercase;
	padding: 28px 40px;
}

#template_header h1,
#template_header h1 a {
	color: #ffffff;
	font-size: 26px;
	font-weight: 700;
	letter-spacing: 0.18em;
	text-decoration: none;
}

#template_body {
	background-color: <?php echo esc_attr( $lumea_body_bg ); ?>;
}

#body_content {
	background-color: <?php echo esc_attr( $lumea_body_bg ); ?>;
}

#body_content table td {
	padding: 48px 48px 32px;
}

#body_content table td td {
	padding: 12px;
}

#body_content p,
#body_content ul,
#body_content ol {
	margin: 0 0 16px;
	font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
	font-size: 15px;
	line-height: 1.7;
	color: <?php echo esc_attr( $lumea_text ); ?>;
}

#body_content a {
	color: <?php echo esc_attr( $lumea_accent ); ?>;
	text-decoration: underline;
}

h1, h2, h3 {
	font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
	font-weight: 700;
	letter-spacing: 0.05em;
	color: <?php echo esc_attr( $lumea_text ); ?>;
}

h2 {
	font-size: 22px;
	margin: 0 0 20px;
}

/* Order table */
#body_content .td {
	border-bottom: 1px solid <?php echo esc_attr( $lumea_border ); ?>;
	padding: 12px;
	vertical-align: middle;
}

.woocommerce-order-overview,
.order_details {
	border: 1px solid <?php echo esc_attr( $lumea_border ); ?>;
	border-radius: 4px;
	margin-bottom: 24px;
}

/* Button */
.button,
.woocommerce-button {
	background-color: <?php echo esc_attr( $lumea_btn_bg ); ?> !important;
	border-radius: 2px !important;
	color: <?php echo esc_attr( $lumea_btn_text ); ?> !important;
	display: inline-block !important;
	font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif !important;
	font-size: 13px !important;
	font-weight: 600 !important;
	letter-spacing: 0.12em !important;
	padding: 14px 32px !important;
	text-decoration: none !important;
	text-transform: uppercase !important;
}

/* Footer */
#template_footer {
	background-color: <?php echo esc_attr( $lumea_header_bg ); ?>;
	border-radius: 0 0 8px 8px;
	border-top: 3px solid <?php echo esc_attr( $lumea_accent ); ?>;
}

#credit {
	border: 0;
	color: #888888;
	font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
	font-size: 11px;
	line-height: 150%;
	padding: 24px 48px;
	text-align: center;
}

#credit p {
	color: #888888;
	margin: 0;
}
