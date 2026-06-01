<?php
/**
 * Sidebar template.
 *
 * @package Lumea
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! is_active_sidebar( 'lumea-sidebar' ) ) {
	return;
}
?>

<aside class="lumea-sidebar widget-area" role="complementary" aria-label="<?php esc_attr_e( 'Blog Sidebar', 'lumea' ); ?>">
	<?php dynamic_sidebar( 'lumea-sidebar' ); ?>
</aside>
