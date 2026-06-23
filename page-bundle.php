<?php
/**
 * Template Name: Bundles & Gifts
 * Curated product sets, gift wrapping and e-gift cards page.
 *
 * @package Lumea
 */

defined( 'ABSPATH' ) || exit;
get_header();

$bundles = array(
	array(
		'key'     => 'morning',
		'eyebrow' => get_theme_mod( 'lumea_bundle1_eyebrow', __( 'Best Seller', 'lumea' ) ),
		'name'    => get_theme_mod( 'lumea_bundle1_name', __( 'The Morning Ritual', 'lumea' ) ),
		'desc'    => get_theme_mod( 'lumea_bundle1_desc', __( 'A complete AM routine — cleanse, treat and protect. Three products chosen for synergy and results you will feel by day seven.', 'lumea' ) ),
		'value'   => get_theme_mod( 'lumea_bundle1_value', __( '$142', 'lumea' ) ),
		'price'   => get_theme_mod( 'lumea_bundle1_price', __( '$118', 'lumea' ) ),
		'cat'     => get_theme_mod( 'lumea_bundle1_cat', 'bestseller' ),
		'img'     => get_theme_mod( 'lumea_bundle1_img', LUMEA_THEME_URI . '/assets/images/bestsellers/bestsellers-main1.jpg' ),
		'saving'  => get_theme_mod( 'lumea_bundle1_saving', __( 'Save $24', 'lumea' ) ),
	),
	array(
		'key'     => 'night',
		'eyebrow' => get_theme_mod( 'lumea_bundle2_eyebrow', __( 'Fan Favourite', 'lumea' ) ),
		'name'    => get_theme_mod( 'lumea_bundle2_name', __( 'The Night Repair', 'lumea' ) ),
		'desc'    => get_theme_mod( 'lumea_bundle2_desc', __( 'Let your skin recover overnight. Bakuchiol serum, barrier repair oil and a deeply hydrating sleep mask — wake up to visibly plumper skin.', 'lumea' ) ),
		'value'   => get_theme_mod( 'lumea_bundle2_value', __( '$168', 'lumea' ) ),
		'price'   => get_theme_mod( 'lumea_bundle2_price', __( '$138', 'lumea' ) ),
		'cat'     => get_theme_mod( 'lumea_bundle2_cat', 'latest' ),
		'img'     => get_theme_mod( 'lumea_bundle2_img', LUMEA_THEME_URI . '/assets/images/bestsellers/bestsellers-main2.jpg' ),
		'saving'  => get_theme_mod( 'lumea_bundle2_saving', __( 'Save $30', 'lumea' ) ),
	),
	array(
		'key'     => 'gift',
		'eyebrow' => get_theme_mod( 'lumea_bundle3_eyebrow', __( 'Perfect Gift', 'lumea' ) ),
		'name'    => get_theme_mod( 'lumea_bundle3_name', __( 'The Glow Edit', 'lumea' ) ),
		'desc'    => get_theme_mod( 'lumea_bundle3_desc', __( 'Everything they need for luminous, healthy skin — packaged in our signature gift box with a handwritten card on request.', 'lumea' ) ),
		'value'   => get_theme_mod( 'lumea_bundle3_value', __( '$195', 'lumea' ) ),
		'price'   => get_theme_mod( 'lumea_bundle3_price', __( '$158', 'lumea' ) ),
		'cat'     => get_theme_mod( 'lumea_bundle3_cat', '' ),
		'img'     => get_theme_mod( 'lumea_bundle3_img', LUMEA_THEME_URI . '/assets/images/bestsellers/cta-bg.jpg' ),
		'saving'  => get_theme_mod( 'lumea_bundle3_saving', __( 'Save $37', 'lumea' ) ),
	),
);
?>

<main class="lumea-bundle-page" id="lumeaPage">

	<nav class="lumea-pdp-breadcrumb" aria-label="<?php esc_attr_e( 'Breadcrumb', 'lumea' ); ?>">
		<div class="lumea-pdp-bc-inner">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'lumea' ); ?></a>
			<svg class="lumea-pdp-bc-arrow" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="9 18 15 12 9 6"/></svg>
			<span aria-current="page"><?php esc_html_e( 'Bundles & Gifts', 'lumea' ); ?></span>
		</div>
	</nav>

	<div class="lumea-policy-hero">
		<div class="lumea-policy-hero-inner">
			<p class="lumea-cart-eyebrow"><?php esc_html_e( 'Curated with intention', 'lumea' ); ?></p>
			<h1 class="lumea-policy-hero-title"><?php esc_html_e( 'Bundles & Gift Sets', 'lumea' ); ?></h1>
			<p class="lumea-policy-hero-sub"><?php esc_html_e( 'Carefully curated rituals that work together. Each set is designed by our formulation team for maximum synergy — and comes with a saving on the individual prices.', 'lumea' ); ?></p>
		</div>
	</div>

	<div class="lumea-policy-body">

		<section class="lumea-policy-section">
			<div class="lumea-policy-section-inner">
				<div class="lumea-bundle-grid">
					<?php
					foreach ( $bundles as $bundle ) :
						$cat_slug = sanitize_key( $bundle['cat'] );
						$cat_link = '';
						if ( $cat_slug && taxonomy_exists( 'product_cat' ) ) {
							$cat_obj  = get_term_by( 'slug', $cat_slug, 'product_cat' );
							$term_url = $cat_obj ? get_term_link( $cat_obj ) : '';
							$cat_link = ( $term_url && ! is_wp_error( $term_url ) ) ? esc_url( $term_url ) : '';
						}
						if ( ! $cat_link ) {
							$cat_link = esc_url( lumea_get_shop_url() );
						}

						$products = array();
						if ( class_exists( 'WooCommerce' ) && function_exists( 'wc_get_products' ) && $cat_slug ) {
							$products = wc_get_products(
								array(
									'category' => array( $cat_slug ),
									'limit'    => 3,
									'status'   => 'publish',
									'orderby'  => 'menu_order',
									'order'    => 'ASC',
								)
							);
						}
						?>
					<div class="lumea-bundle-card">
						<div class="lumea-bundle-card-img-wrap">
							<img
								src="<?php echo esc_url( $bundle['img'] ); ?>"
								alt="<?php echo esc_attr( $bundle['name'] ); ?>"
								class="lumea-bundle-card-img"
								loading="lazy"
							>
							<?php if ( $bundle['saving'] ) : ?>
							<span class="lumea-bundle-saving"><?php echo esc_html( $bundle['saving'] ); ?></span>
							<?php endif; ?>
						</div>

						<div class="lumea-bundle-card-body">
							<p class="lumea-cart-eyebrow"><?php echo esc_html( $bundle['eyebrow'] ); ?></p>
							<h2 class="lumea-bundle-name"><?php echo esc_html( $bundle['name'] ); ?></h2>
							<p class="lumea-bundle-desc"><?php echo esc_html( $bundle['desc'] ); ?></p>

							<?php if ( ! empty( $products ) ) : ?>
							<ul class="lumea-bundle-products" aria-label="<?php esc_attr_e( 'Products included', 'lumea' ); ?>">
								<?php foreach ( $products as $product ) : ?>
								<li class="lumea-bundle-product-item">
									<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="var(--lumea-accent)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="20 6 9 17 4 12"/></svg>
									<?php echo esc_html( $product->get_name() ); ?>
								</li>
								<?php endforeach; ?>
							</ul>
							<?php else : ?>
							<ul class="lumea-bundle-products" aria-label="<?php esc_attr_e( 'Products included', 'lumea' ); ?>">
								<li class="lumea-bundle-product-item"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="var(--lumea-accent)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="20 6 9 17 4 12"/></svg><?php esc_html_e( '3 curated products', 'lumea' ); ?></li>
								<li class="lumea-bundle-product-item"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="var(--lumea-accent)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="20 6 9 17 4 12"/></svg><?php esc_html_e( 'Signature gift box', 'lumea' ); ?></li>
								<li class="lumea-bundle-product-item"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="var(--lumea-accent)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="20 6 9 17 4 12"/></svg><?php esc_html_e( 'Ritual guide card', 'lumea' ); ?></li>
							</ul>
							<?php endif; ?>

							<div class="lumea-bundle-pricing">
								<?php if ( $bundle['value'] ) : ?>
								<s class="lumea-bundle-was"><?php echo esc_html( $bundle['value'] ); ?></s>
								<?php endif; ?>
								<span class="lumea-bundle-price"><?php echo esc_html( $bundle['price'] ); ?></span>
							</div>

							<a href="<?php echo esc_url( $cat_link ); ?>" class="lumea-btn btn-dark btn-black lumea-bundle-cta">
								<?php esc_html_e( 'Shop This Set', 'lumea' ); ?>
								<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
							</a>
						</div>
					</div>
					<?php endforeach; ?>
				</div>
			</div>
		</section>

		<section class="lumea-policy-section lumea-policy-section--alt">
			<div class="lumea-policy-section-inner">
				<div class="lumea-gifting-grid">

					<div class="lumea-gifting-card">
						<div class="lumea-gifting-icon">
							<svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="var(--lumea-accent)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="20 12 20 22 4 22 4 12"/><rect x="2" y="7" width="20" height="5"/><line x1="12" y1="22" x2="12" y2="7"/><path d="M12 7H7.5a2.5 2.5 0 0 1 0-5C11 2 12 7 12 7z"/><path d="M12 7h4.5a2.5 2.5 0 0 0 0-5C13 2 12 7 12 7z"/></svg>
						</div>
						<h3><?php esc_html_e( 'Complimentary Gift Wrapping', 'lumea' ); ?></h3>
						<p><?php esc_html_e( 'Every bundle ships in our signature kraft-and-ribbon gift box with tissue paper and a personalised message card — at no extra cost. Add your message at checkout.', 'lumea' ); ?></p>
						<ul class="lumea-gifting-list">
							<li><?php esc_html_e( 'Recycled kraft gift box', 'lumea' ); ?></li>
							<li><?php esc_html_e( 'Tissue paper & ribbon', 'lumea' ); ?></li>
							<li><?php esc_html_e( 'Handwritten message card', 'lumea' ); ?></li>
							<li><?php esc_html_e( 'Always free on bundles', 'lumea' ); ?></li>
						</ul>
					</div>

					<div class="lumea-gifting-card">
						<div class="lumea-gifting-icon">
							<svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="var(--lumea-accent)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>
						</div>
						<h3><?php esc_html_e( 'E-Gift Cards', 'lumea' ); ?></h3>
						<p><?php esc_html_e( 'Not sure which set to choose? Give the gift of choice with a Luméa e-gift card — delivered instantly to their inbox in our signature design.', 'lumea' ); ?></p>
						<ul class="lumea-gifting-list">
							<li><?php esc_html_e( 'Available in any amount', 'lumea' ); ?></li>
							<li><?php esc_html_e( 'Sent instantly by email', 'lumea' ); ?></li>
							<li><?php esc_html_e( 'Never expires', 'lumea' ); ?></li>
							<li><?php esc_html_e( 'Redeemable on anything', 'lumea' ); ?></li>
						</ul>
						<?php
						if ( class_exists( 'WooCommerce' ) ) :
							$gift_card_page = get_page_by_path( 'gift-card' );
							?>
						<a href="<?php echo esc_url( $gift_card_page ? get_permalink( $gift_card_page ) : lumea_get_shop_url() ); ?>" class="lumea-btn btn-outline lumea-gifting-btn">
							<?php esc_html_e( 'Buy a Gift Card', 'lumea' ); ?>
						</a>
						<?php endif; ?>
					</div>

				</div>
			</div>
		</section>

		<div class="lumea-policy-cta">
			<p class="lumea-cart-eyebrow"><?php esc_html_e( 'Need help choosing?', 'lumea' ); ?></p>
			<h2><?php esc_html_e( 'We\'ll build the perfect set for you', 'lumea' ); ?></h2>
			<p><?php esc_html_e( 'Tell us who it\'s for and we\'ll recommend the ideal ritual — for any skin type, budget or occasion.', 'lumea' ); ?></p>
			<?php
			lumea_btn(
				array(
					'label' => __( 'Get Personalised Advice', 'lumea' ),
					'href'  => lumea_get_page_url( 'contact' ),
					'style' => 'dark',
				)
			);
			?>
		</div>

	</div>

</main>

<?php get_footer(); ?>
