<?php
/**
 * Email Footer.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/email-footer.php.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates\Emails
 * @version 2.4.0
 */

defined( 'ABSPATH' ) || exit;

$lumea_footer_bg  = '#1a1a1a';
$lumea_accent     = '#c9a96e';
$lumea_instagram  = get_theme_mod( 'lumea_footer_instagram', '' );
$lumea_tiktok     = get_theme_mod( 'lumea_footer_tiktok', '' );
$lumea_pinterest  = get_theme_mod( 'lumea_footer_pinterest', '' );
$lumea_address    = get_theme_mod( 'lumea_footer_address', '' );
$lumea_email_addr = get_theme_mod( 'lumea_footer_email', get_option( 'admin_email' ) );
?>
		</td>
	</tr>
	<!-- End body content -->

	<!-- Footer divider -->
	<tr>
		<td style="height:3px; background:linear-gradient(90deg, <?php echo esc_attr( $lumea_accent ); ?> 0%, #e8d5b7 100%);"></td>
	</tr>

	<!-- Footer -->
	<tr>
		<td style="background-color:<?php echo esc_attr( $lumea_footer_bg ); ?>; padding:32px 40px; border-radius:0 0 8px 8px; text-align:center;">

			<!-- Brand name -->
			<p style="margin:0 0 16px; font-size:18px; font-weight:700; letter-spacing:0.16em; color:#ffffff; text-transform:uppercase;">
				<?php echo esc_html( get_bloginfo( 'name' ) ); ?>
			</p>

			<!-- Social links -->
			<?php if ( $lumea_instagram || $lumea_tiktok || $lumea_pinterest ) : ?>
			<p style="margin:0 0 20px;">
				<?php if ( $lumea_instagram ) : ?>
				<a href="<?php echo esc_url( $lumea_instagram ); ?>" style="display:inline-block; margin:0 6px; color:<?php echo esc_attr( $lumea_accent ); ?>; text-decoration:none; font-size:12px; letter-spacing:0.1em; text-transform:uppercase;">Instagram</a>
				<?php endif; ?>
				<?php if ( $lumea_tiktok ) : ?>
				<a href="<?php echo esc_url( $lumea_tiktok ); ?>" style="display:inline-block; margin:0 6px; color:<?php echo esc_attr( $lumea_accent ); ?>; text-decoration:none; font-size:12px; letter-spacing:0.1em; text-transform:uppercase;">TikTok</a>
				<?php endif; ?>
				<?php if ( $lumea_pinterest ) : ?>
				<a href="<?php echo esc_url( $lumea_pinterest ); ?>" style="display:inline-block; margin:0 6px; color:<?php echo esc_attr( $lumea_accent ); ?>; text-decoration:none; font-size:12px; letter-spacing:0.1em; text-transform:uppercase;">Pinterest</a>
				<?php endif; ?>
			</p>
			<?php endif; ?>

			<!-- Contact info -->
			<?php if ( $lumea_address ) : ?>
			<p style="margin:0 0 6px; font-size:11px; color:#888888; letter-spacing:0.06em;">
				<?php echo esc_html( $lumea_address ); ?>
			</p>
			<?php endif; ?>
			<?php if ( $lumea_email_addr ) : ?>
			<p style="margin:0 0 20px; font-size:11px;">
				<a href="mailto:<?php echo esc_attr( $lumea_email_addr ); ?>" style="color:<?php echo esc_attr( $lumea_accent ); ?>; text-decoration:none;">
					<?php echo esc_html( $lumea_email_addr ); ?>
				</a>
			</p>
			<?php endif; ?>

			<!-- Legal -->
			<p style="margin:0; font-size:10px; color:#666666; letter-spacing:0.04em;">
				&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?> <?php echo esc_html( get_bloginfo( 'name' ) ); ?>.
				<?php echo wp_kses_post( apply_filters( 'woocommerce_email_footer_text', get_option( 'woocommerce_email_footer_text' ) ) ); ?>
			</p>

		</td>
	</tr>

</table>

</td>
</tr>
</table>

</body>
</html>
