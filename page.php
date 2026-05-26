<?php
/**
 * Default page template — wraps all WordPress pages.
 *
 * @package Lumea
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>

<main class="lumea-page" id="lumeaPage">
	<?php while ( have_posts() ) : the_post(); ?>
		<?php the_content(); ?>
	<?php endwhile; ?>
</main>

<?php get_footer(); ?>
