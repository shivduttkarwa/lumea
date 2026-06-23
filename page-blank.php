<?php
/**
 * Template Name: Blank (No Header / Footer)
 * Template Post Type: page
 *
 * A clean canvas page with no header, navigation, or footer.
 * Ideal for campaign landing pages, promotional pages, or custom layouts
 * built entirely with the block editor or a page builder.
 *
 * @package Lumea
 */

defined( 'ABSPATH' ) || exit;
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>

<body <?php body_class( 'lumea-blank-page' ); ?>>
<?php wp_body_open(); ?>
<a class="skip-link screen-reader-text" href="#lumeaBlankMain"><?php esc_html_e( 'Skip to content', 'lumea' ); ?></a>

<main id="lumeaBlankMain" role="main">
	<?php
	while ( have_posts() ) :
		the_post();
		?>
	<article <?php post_class(); ?>>
		<?php the_content(); ?>
	</article>
	<?php endwhile; ?>
</main>

<?php wp_footer(); ?>
</body>
</html>
