<?php
/**
 * Email Header.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/email-header.php.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates\Emails
 * @version 4.0.0
 */

defined( 'ABSPATH' ) || exit;

$lumea_email_bg    = '#f9f7f5';
$lumea_header_bg   = '#1a1a1a';
$lumea_accent      = '#c9a96e';
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?php echo esc_html( get_bloginfo( 'name' ) ); ?></title>
</head>
<body style="margin:0; padding:0; background-color:<?php echo esc_attr( $lumea_email_bg ); ?>; font-family:'Helvetica Neue', Helvetica, Arial, sans-serif; -webkit-text-size-adjust:none;">

<table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:<?php echo esc_attr( $lumea_email_bg ); ?>; margin:0; padding:0;">
<tr>
<td align="center" style="padding:32px 16px 0;">

<table role="presentation" width="600" cellpadding="0" cellspacing="0" border="0" style="max-width:600px; width:100%;">

	<!-- Header -->
	<tr>
		<td align="center" style="background-color:<?php echo esc_attr( $lumea_header_bg ); ?>; padding:28px 40px; border-radius:8px 8px 0 0;">
			<?php if ( has_custom_logo() ) : ?>
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" style="text-decoration:none;">
				<?php the_custom_logo(); ?>
			</a>
			<?php else : ?>
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" style="font-family:'Helvetica Neue',Helvetica,Arial,sans-serif; font-size:26px; font-weight:700; letter-spacing:0.18em; color:#ffffff; text-decoration:none; text-transform:uppercase;">
				<?php echo esc_html( get_bloginfo( 'name' ) ); ?>
			</a>
			<?php endif; ?>
			<p style="margin:8px 0 0; font-size:11px; letter-spacing:0.12em; color:<?php echo esc_attr( $lumea_accent ); ?>; text-transform:uppercase;">
				<?php echo esc_html( get_bloginfo( 'description' ) ); ?>
			</p>
		</td>
	</tr>

	<!-- Divider accent line -->
	<tr>
		<td style="height:3px; background:linear-gradient(90deg, <?php echo esc_attr( $lumea_accent ); ?> 0%, #e8d5b7 100%);"></td>
	</tr>

	<!-- Body content begins -->
	<tr>
		<td style="background-color:#ffffff; padding:40px 40px 0; border-left:1px solid #ece8e2; border-right:1px solid #ece8e2;">
