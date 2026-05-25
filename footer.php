<?php
/**
 * Footer template.
 *
 * @package Lumea
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

</main>

<footer class="lumea-site-footer">
	<div class="lumea-container">
		<p class="lumea-footer-copy">
			<?php
			printf(
				esc_html__( '© %1$s %2$s. All rights reserved.', 'lumea' ),
				esc_html( date_i18n( 'Y' ) ),
				esc_html( get_bloginfo( 'name' ) )
			);
			?>
		</p>
	</div>
</footer>

<?php wp_footer(); ?>
</body>
</html>