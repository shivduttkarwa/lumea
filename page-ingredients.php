<?php
/**
 * Template Name: Our Ingredients
 * Ingredient philosophy, key actives and certification page.
 *
 * @package Lumea
 */

defined( 'ABSPATH' ) || exit;
get_header();

$story_image = esc_url( get_theme_mod( 'lumea_ingredients_image', LUMEA_THEME_URI . '/assets/images/her02.jpg' ) );

$never_list = array(
	array( 'label' => __( 'Synthetic fragrance', 'lumea' ),        'icon' => 'M18.364 18.364A9 9 0 0 0 5.636 5.636m12.728 12.728A9 9 0 0 1 5.636 5.636m12.728 12.728L5.636 5.636' ),
	array( 'label' => __( 'Parabens', 'lumea' ),                   'icon' => 'M18.364 18.364A9 9 0 0 0 5.636 5.636m12.728 12.728A9 9 0 0 1 5.636 5.636m12.728 12.728L5.636 5.636' ),
	array( 'label' => __( 'Sulfates (SLS/SLES)', 'lumea' ),        'icon' => 'M18.364 18.364A9 9 0 0 0 5.636 5.636m12.728 12.728A9 9 0 0 1 5.636 5.636m12.728 12.728L5.636 5.636' ),
	array( 'label' => __( 'Mineral oil', 'lumea' ),                'icon' => 'M18.364 18.364A9 9 0 0 0 5.636 5.636m12.728 12.728A9 9 0 0 1 5.636 5.636m12.728 12.728L5.636 5.636' ),
	array( 'label' => __( 'Phthalates', 'lumea' ),                 'icon' => 'M18.364 18.364A9 9 0 0 0 5.636 5.636m12.728 12.728A9 9 0 0 1 5.636 5.636m12.728 12.728L5.636 5.636' ),
	array( 'label' => __( 'Formaldehyde', 'lumea' ),               'icon' => 'M18.364 18.364A9 9 0 0 0 5.636 5.636m12.728 12.728A9 9 0 0 1 5.636 5.636m12.728 12.728L5.636 5.636' ),
	array( 'label' => __( 'Petrolatum', 'lumea' ),                 'icon' => 'M18.364 18.364A9 9 0 0 0 5.636 5.636m12.728 12.728A9 9 0 0 1 5.636 5.636m12.728 12.728L5.636 5.636' ),
	array( 'label' => __( '1,400+ questionable chemicals', 'lumea' ), 'icon' => 'M18.364 18.364A9 9 0 0 0 5.636 5.636m12.728 12.728A9 9 0 0 1 5.636 5.636m12.728 12.728L5.636 5.636' ),
);

$actives = array(
	array(
		'name'    => get_theme_mod( 'lumea_ing1_name', __( 'Bulgarian Rose Otto', 'lumea' ) ),
		'origin'  => get_theme_mod( 'lumea_ing1_origin', __( 'Bulgaria', 'lumea' ) ),
		'benefit' => get_theme_mod( 'lumea_ing1_benefit', __( 'Deeply hydrating, brightening and anti-inflammatory. 3.5 tonnes of petals yield one kilogram of oil — the most precious botanical in our range.', 'lumea' ) ),
		'badge'   => __( 'Hydration', 'lumea' ),
	),
	array(
		'name'    => get_theme_mod( 'lumea_ing2_name', __( 'Bakuchiol', 'lumea' ) ),
		'origin'  => get_theme_mod( 'lumea_ing2_origin', __( 'India', 'lumea' ) ),
		'benefit' => get_theme_mod( 'lumea_ing2_benefit', __( "Nature's retinol alternative. Clinically proven to reduce fine lines and improve skin tone without sensitivity, redness or sun-avoidance requirements.", 'lumea' ) ),
		'badge'   => __( 'Anti-Ageing', 'lumea' ),
	),
	array(
		'name'    => get_theme_mod( 'lumea_ing3_name', __( 'Snow Mushroom', 'lumea' ) ),
		'origin'  => get_theme_mod( 'lumea_ing3_origin', __( 'Japan', 'lumea' ) ),
		'benefit' => get_theme_mod( 'lumea_ing3_benefit', __( 'Holds 500× its weight in water — outperforming hyaluronic acid in clinical hydration studies. Creates a weightless moisture film on the skin surface.', 'lumea' ) ),
		'badge'   => __( 'Deep Moisture', 'lumea' ),
	),
	array(
		'name'    => get_theme_mod( 'lumea_ing4_name', __( 'Sea Buckthorn', 'lumea' ) ),
		'origin'  => get_theme_mod( 'lumea_ing4_origin', __( 'Himalayas', 'lumea' ) ),
		'benefit' => get_theme_mod( 'lumea_ing4_benefit', __( 'Exceptionally rich in omega-7, vitamins C and E. Speeds cellular repair, reduces redness, and gives the skin a warm luminous glow.', 'lumea' ) ),
		'badge'   => __( 'Repair & Glow', 'lumea' ),
	),
	array(
		'name'    => get_theme_mod( 'lumea_ing5_name', __( 'Blue Tansy', 'lumea' ) ),
		'origin'  => get_theme_mod( 'lumea_ing5_origin', __( 'Morocco', 'lumea' ) ),
		'benefit' => get_theme_mod( 'lumea_ing5_benefit', __( 'Named for its vivid azure oil. Potent anti-inflammatory and calming agent — ideal for reactive, sensitised and post-treatment skin.', 'lumea' ) ),
		'badge'   => __( 'Calm & Soothe', 'lumea' ),
	),
	array(
		'name'    => get_theme_mod( 'lumea_ing6_name', __( 'Niacinamide', 'lumea' ) ),
		'origin'  => get_theme_mod( 'lumea_ing6_origin', __( 'Lab-derived, Vegan', 'lumea' ) ),
		'benefit' => get_theme_mod( 'lumea_ing6_benefit', __( 'Vitamin B3 in its most bioavailable form. Minimises pores, strengthens the moisture barrier, evens skin tone and reduces hyperpigmentation.', 'lumea' ) ),
		'badge'   => __( 'Brightening', 'lumea' ),
	),
);
?>

<main class="lumea-ingredients-page" id="lumeaPage">

	<nav class="lumea-pdp-breadcrumb" aria-label="<?php esc_attr_e( 'Breadcrumb', 'lumea' ); ?>">
		<div class="lumea-pdp-bc-inner">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'lumea' ); ?></a>
			<svg class="lumea-pdp-bc-arrow" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="9 18 15 12 9 6"/></svg>
			<span aria-current="page"><?php esc_html_e( 'Our Ingredients', 'lumea' ); ?></span>
		</div>
	</nav>

	<div class="lumea-policy-hero lumea-ing-hero">
		<div class="lumea-policy-hero-inner">
			<p class="lumea-cart-eyebrow"><?php esc_html_e( 'Ingredient Transparency', 'lumea' ); ?></p>
			<h1 class="lumea-policy-hero-title"><?php esc_html_e( 'What Goes Into Your Skin', 'lumea' ); ?></h1>
			<p class="lumea-policy-hero-sub"><?php esc_html_e( 'Every ingredient earns its place in our formulas. We source from farmers we know by name, exclude over 1,400 questionable chemicals, and publish every active with its origin and purpose.', 'lumea' ); ?></p>
		</div>
	</div>

	<div class="lumea-policy-body">

		<section class="lumea-policy-section">
			<div class="lumea-policy-section-inner lumea-ing-intro-grid">
				<div class="lumea-ing-intro-text">
					<p class="lumea-cart-eyebrow"><?php esc_html_e( 'Our Philosophy', 'lumea' ); ?></p>
					<h2><?php esc_html_e( 'We believe in ingredients you can pronounce', 'lumea' ); ?></h2>
					<p><?php esc_html_e( 'Our ingredient selection starts in the field, not the lab. We work backwards from the plant — understanding its native habitat, harvest season, and traditional therapeutic uses before evaluating its bioactive potential.', 'lumea' ); ?></p>
					<p><?php esc_html_e( 'Every formula is stress-tested at the cellular level before it reaches you, with clinically measurable results visible within 28 days of consistent use.', 'lumea' ); ?></p>
					<div class="lumea-ing-stats">
						<div class="lumea-ing-stat">
							<span class="lumea-ing-stat-n"><?php esc_html_e( '48+', 'lumea' ); ?></span>
							<span class="lumea-ing-stat-l"><?php esc_html_e( 'Botanical actives', 'lumea' ); ?></span>
						</div>
						<div class="lumea-ing-stat">
							<span class="lumea-ing-stat-n"><?php esc_html_e( '12', 'lumea' ); ?></span>
							<span class="lumea-ing-stat-l"><?php esc_html_e( 'Countries sourced', 'lumea' ); ?></span>
						</div>
						<div class="lumea-ing-stat">
							<span class="lumea-ing-stat-n"><?php esc_html_e( '1,400+', 'lumea' ); ?></span>
							<span class="lumea-ing-stat-l"><?php esc_html_e( 'Chemicals excluded', 'lumea' ); ?></span>
						</div>
					</div>
				</div>
				<?php if ( $story_image ) : ?>
				<div class="lumea-ing-intro-img">
					<img src="<?php echo esc_url( $story_image ); ?>" alt="<?php esc_attr_e( 'Luméa ingredient sourcing', 'lumea' ); ?>" loading="lazy">
				</div>
				<?php endif; ?>
			</div>
		</section>

		<section class="lumea-policy-section lumea-policy-section--alt">
			<div class="lumea-policy-section-inner">
				<div class="lumea-policy-section-header">
					<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="var(--lumea-accent)" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M18.364 18.364A9 9 0 0 0 5.636 5.636m12.728 12.728A9 9 0 0 1 5.636 5.636m12.728 12.728L5.636 5.636"/></svg>
					<h2><?php esc_html_e( 'What We Never Use', 'lumea' ); ?></h2>
				</div>
				<p class="lumea-ing-never-sub"><?php esc_html_e( 'We benchmark against the EU Cosmetics Regulation (the world\'s strictest) and go further — excluding every ingredient on the Dirty Dozen list and any chemical with inconclusive safety data.', 'lumea' ); ?></p>
				<ul class="lumea-ing-never-list" aria-label="<?php esc_attr_e( 'Ingredients never used', 'lumea' ); ?>">
					<?php foreach ( $never_list as $item ) : ?>
					<li class="lumea-ing-never-item">
						<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="var(--lumea-accent)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="10"/><line x1="4.93" y1="4.93" x2="19.07" y2="19.07"/></svg>
						<?php echo esc_html( $item['label'] ); ?>
					</li>
					<?php endforeach; ?>
				</ul>
			</div>
		</section>

		<section class="lumea-policy-section">
			<div class="lumea-policy-section-inner">
				<div class="lumea-policy-section-header">
					<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="var(--lumea-accent)" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
					<h2><?php esc_html_e( 'Our Key Actives', 'lumea' ); ?></h2>
				</div>
				<p class="lumea-ing-never-sub"><?php esc_html_e( 'These are the hero ingredients you will find across our core range — each selected for clinical efficacy, sustainable sourcing, and compatibility with sensitive skin.', 'lumea' ); ?></p>

				<div class="lumea-actives-grid">
					<?php foreach ( $actives as $active ) : ?>
					<div class="lumea-active-card">
						<div class="lumea-active-card-top">
							<span class="lumea-active-badge"><?php echo esc_html( $active['badge'] ); ?></span>
						</div>
						<h3 class="lumea-active-name"><?php echo esc_html( $active['name'] ); ?></h3>
						<p class="lumea-active-origin">
							<svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="10" r="3"/><path d="M12 2a8 8 0 0 0-8 8c0 5.4 7.05 11.5 7.35 11.76a1 1 0 0 0 1.3 0C12.95 21.5 20 15.4 20 10a8 8 0 0 0-8-8z"/></svg>
							<?php echo esc_html( $active['origin'] ); ?>
						</p>
						<p class="lumea-active-benefit"><?php echo esc_html( $active['benefit'] ); ?></p>
					</div>
					<?php endforeach; ?>
				</div>
			</div>
		</section>

		<section class="lumea-policy-section lumea-policy-section--alt">
			<div class="lumea-policy-section-inner">
				<div class="lumea-policy-section-header">
					<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="var(--lumea-accent)" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
					<h2><?php esc_html_e( 'Certifications', 'lumea' ); ?></h2>
				</div>
				<div class="lumea-certs-grid">
					<div class="lumea-cert-card">
						<svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="var(--lumea-accent)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><polyline points="9 12 11 14 15 10"/></svg>
						<h3><?php esc_html_e( 'Leaping Bunny', 'lumea' ); ?></h3>
						<p><?php esc_html_e( 'Certified cruelty-free across all products and supply chain.', 'lumea' ); ?></p>
					</div>
					<div class="lumea-cert-card">
						<svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="var(--lumea-accent)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="10"/><path d="M8 14s1.5 2 4 2 4-2 4-2"/><line x1="9" y1="9" x2="9.01" y2="9"/><line x1="15" y1="9" x2="15.01" y2="9"/></svg>
						<h3><?php esc_html_e( 'Vegan Certified', 'lumea' ); ?></h3>
						<p><?php esc_html_e( 'No animal-derived ingredients. Certified by The Vegan Society.', 'lumea' ); ?></p>
					</div>
					<div class="lumea-cert-card">
						<svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="var(--lumea-accent)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M2 20h.01"/><path d="M7 20v-4"/><path d="M12 20v-8"/><path d="M17 20V8"/><path d="M22 4v16"/></svg>
						<h3><?php esc_html_e( 'Carbon Neutral', 'lumea' ); ?></h3>
						<p><?php esc_html_e( 'Offset 100% of emissions across production and shipping.', 'lumea' ); ?></p>
					</div>
					<div class="lumea-cert-card">
						<svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="var(--lumea-accent)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
						<h3><?php esc_html_e( '1% for the Planet', 'lumea' ); ?></h3>
						<p><?php esc_html_e( '1% of every sale donated to reforestation and ocean conservation.', 'lumea' ); ?></p>
					</div>
				</div>
			</div>
		</section>

		<div class="lumea-policy-cta">
			<p class="lumea-cart-eyebrow"><?php esc_html_e( 'Formulated with intention', 'lumea' ); ?></p>
			<h2><?php esc_html_e( 'Experience the difference', 'lumea' ); ?></h2>
			<p><?php esc_html_e( 'Every product is built around these actives. Find your ritual today.', 'lumea' ); ?></p>
			<?php
			lumea_btn( array(
				'label' => __( 'Shop the Collection', 'lumea' ),
				'href'  => esc_url( lumea_get_shop_url() ),
				'style' => 'dark',
			) );
			?>
		</div>

	</div>

</main>

<?php get_footer(); ?>
