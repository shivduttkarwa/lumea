<?php
/**
 * Default page template — wraps all WordPress pages.
 *
 * @package Lumea
 */

defined( 'ABSPATH' ) || exit;
get_header();

$lumea_is_wc_shortcode_page = function_exists( 'is_cart' )
	&& ( is_cart() || is_checkout() || is_account_page() );
?>

<main class="lumea-page" id="lumeaPage">
	<?php
	while ( have_posts() ) :
		the_post();
		?>
		<article id="post-<?php the_ID(); ?>" <?php post_class( 'lumea-page-content' ); ?>>
			<?php if ( ! $lumea_is_wc_shortcode_page ) : ?>
			<header class="lumea-page-header">
				<h1 class="lumea-page-title"><?php the_title(); ?></h1>
			</header>
			<?php endif; ?>
			<div class="lumea-page-entry">
				<?php
				the_content();
				wp_link_pages(
					array(
						'before' => '<nav class="page-links" aria-label="' . esc_attr__( 'Page', 'lumea' ) . '">',
						'after'  => '</nav>',
					)
				);
				?>
			</div>
		</article>
			<?php
			if ( comments_open() || get_comments_number() ) {
					comments_template();
			}
	endwhile;
	?>
</main>
<?php get_footer(); ?>
