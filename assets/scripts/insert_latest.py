import re

php_file = r'c:\Users\shivd\Local Sites\lumea\app\public\wp-content\themes\lumea\front-page.php'
content = open(php_file, 'r', encoding='utf-8').read()

new_section = r"""
<!-- Latest Products Section -->
<?php
$lumea_latest = array(
	1 => array(
		'name'      => get_theme_mod( 'lumea_latest1_name',      'Hydra Glow Mist' ),
		'price'     => get_theme_mod( 'lumea_latest1_price',     '$36.00' ),
		'old_price' => get_theme_mod( 'lumea_latest1_old_price', '' ),
		'badge'     => get_theme_mod( 'lumea_latest1_badge',     'New' ),
		'image'     => get_theme_mod( 'lumea_latest1_image',     LUMEA_THEME_URI . '/assets/images/bestsellers/bestsellers-main1.jpg' ),
		'hover'     => get_theme_mod( 'lumea_latest1_hover',     LUMEA_THEME_URI . '/assets/images/bestsellers/bestsellers-hover1.jpg' ),
		'url'       => get_theme_mod( 'lumea_latest1_url',       '#' ),
	),
	2 => array(
		'name'      => get_theme_mod( 'lumea_latest2_name',      'Peptide Eye Cream' ),
		'price'     => get_theme_mod( 'lumea_latest2_price',     '$48.00' ),
		'old_price' => get_theme_mod( 'lumea_latest2_old_price', '$58.00' ),
		'badge'     => get_theme_mod( 'lumea_latest2_badge',     'Sale' ),
		'image'     => get_theme_mod( 'lumea_latest2_image',     LUMEA_THEME_URI . '/assets/images/bestsellers/bestsellers-main2.jpg' ),
		'hover'     => get_theme_mod( 'lumea_latest2_hover',     LUMEA_THEME_URI . '/assets/images/bestsellers/bestsellers-hover2.jpg' ),
		'url'       => get_theme_mod( 'lumea_latest2_url',       '#' ),
	),
	3 => array(
		'name'      => get_theme_mod( 'lumea_latest3_name',      'Barrier Repair Balm' ),
		'price'     => get_theme_mod( 'lumea_latest3_price',     '$54.00' ),
		'old_price' => get_theme_mod( 'lumea_latest3_old_price', '' ),
		'badge'     => get_theme_mod( 'lumea_latest3_badge',     'New' ),
		'image'     => get_theme_mod( 'lumea_latest3_image',     LUMEA_THEME_URI . '/assets/images/bestsellers/bestsellers-main3.jpg' ),
		'hover'     => get_theme_mod( 'lumea_latest3_hover',     LUMEA_THEME_URI . '/assets/images/bestsellers/bestsellers-hover3.jpg' ),
		'url'       => get_theme_mod( 'lumea_latest3_url',       '#' ),
	),
	4 => array(
		'name'      => get_theme_mod( 'lumea_latest4_name',      'AHA Resurfacing Serum' ),
		'price'     => get_theme_mod( 'lumea_latest4_price',     '$62.00' ),
		'old_price' => get_theme_mod( 'lumea_latest4_old_price', '$72.00' ),
		'badge'     => get_theme_mod( 'lumea_latest4_badge',     '-14%' ),
		'image'     => get_theme_mod( 'lumea_latest4_image',     LUMEA_THEME_URI . '/assets/images/bestsellers/bestsellers-main4.jpg' ),
		'hover'     => get_theme_mod( 'lumea_latest4_hover',     LUMEA_THEME_URI . '/assets/images/bestsellers/bestsellers-hover4.jpg' ),
		'url'       => get_theme_mod( 'lumea_latest4_url',       '#' ),
	),
	5 => array(
		'name'      => get_theme_mod( 'lumea_latest5_name',      'Brightening Vitamin C' ),
		'price'     => get_theme_mod( 'lumea_latest5_price',     '$58.00' ),
		'old_price' => get_theme_mod( 'lumea_latest5_old_price', '' ),
		'badge'     => get_theme_mod( 'lumea_latest5_badge',     'New' ),
		'image'     => get_theme_mod( 'lumea_latest5_image',     LUMEA_THEME_URI . '/assets/images/bestsellers/bestsellers-main5.jpg' ),
		'hover'     => get_theme_mod( 'lumea_latest5_hover',     LUMEA_THEME_URI . '/assets/images/bestsellers/bestsellers-hover5.jpg' ),
		'url'       => get_theme_mod( 'lumea_latest5_url',       '#' ),
	),
	6 => array(
		'name'      => get_theme_mod( 'lumea_latest6_name',      'Niacinamide 10% Serum' ),
		'price'     => get_theme_mod( 'lumea_latest6_price',     '$42.00' ),
		'old_price' => get_theme_mod( 'lumea_latest6_old_price', '$50.00' ),
		'badge'     => get_theme_mod( 'lumea_latest6_badge',     'Sale' ),
		'image'     => get_theme_mod( 'lumea_latest6_image',     LUMEA_THEME_URI . '/assets/images/bestsellers/bestsellers-main1.jpg' ),
		'hover'     => get_theme_mod( 'lumea_latest6_hover',     LUMEA_THEME_URI . '/assets/images/bestsellers/bestsellers-hover1.jpg' ),
		'url'       => get_theme_mod( 'lumea_latest6_url',       '#' ),
	),
	7 => array(
		'name'      => get_theme_mod( 'lumea_latest7_name',      'Retinol Night Cream' ),
		'price'     => get_theme_mod( 'lumea_latest7_price',     '$66.00' ),
		'old_price' => get_theme_mod( 'lumea_latest7_old_price', '' ),
		'badge'     => get_theme_mod( 'lumea_latest7_badge',     'New' ),
		'image'     => get_theme_mod( 'lumea_latest7_image',     LUMEA_THEME_URI . '/assets/images/bestsellers/bestsellers-main2.jpg' ),
		'hover'     => get_theme_mod( 'lumea_latest7_hover',     LUMEA_THEME_URI . '/assets/images/bestsellers/bestsellers-hover2.jpg' ),
		'url'       => get_theme_mod( 'lumea_latest7_url',       '#' ),
	),
	8 => array(
		'name'      => get_theme_mod( 'lumea_latest8_name',      'Calming Rose Toner' ),
		'price'     => get_theme_mod( 'lumea_latest8_price',     '$32.00' ),
		'old_price' => get_theme_mod( 'lumea_latest8_old_price', '$38.00' ),
		'badge'     => get_theme_mod( 'lumea_latest8_badge',     '-16%' ),
		'image'     => get_theme_mod( 'lumea_latest8_image',     LUMEA_THEME_URI . '/assets/images/bestsellers/bestsellers-main3.jpg' ),
		'hover'     => get_theme_mod( 'lumea_latest8_hover',     LUMEA_THEME_URI . '/assets/images/bestsellers/bestsellers-hover3.jpg' ),
		'url'       => get_theme_mod( 'lumea_latest8_url',       '#' ),
	),
);
?>
<section class="lumea-latest" aria-label="<?php esc_attr_e( 'Latest products', 'lumea' ); ?>">
	<div class="lumea-container">

		<div class="lumea-latest-head">
			<div>
				<p class="lumea-latest-eyebrow"><?php esc_html_e( 'Just Arrived', 'lumea' ); ?></p>
				<h2 class="lumea-latest-title"><?php echo esc_html( get_theme_mod( 'lumea_latest_title', 'Latest Products' ) ); ?></h2>
			</div>
			<a href="<?php echo esc_url( get_permalink( wc_get_page_id( 'shop' ) ) ); ?>" class="lumea-latest-all">
				View all
				<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
			</a>
		</div>

		<div class="lumea-latest-grid">
			<?php foreach ( $lumea_latest as $p ) :
				$lp_badge     = $p['badge'];
				$lp_old_price = $p['old_price'];
				$lp_is_sale   = ! empty( $lp_old_price );
			?>
			<article class="lumea-lp-card">
				<a href="<?php echo esc_url( $p['url'] ); ?>" class="lumea-lp-media">
					<?php if ( $lp_badge ) : ?>
					<span class="lumea-lp-badge<?php echo $lp_is_sale ? ' lumea-lp-badge--sale' : ''; ?>"><?php echo esc_html( $lp_badge ); ?></span>
					<?php endif; ?>
					<img src="<?php echo esc_url( $p['image'] ); ?>" alt="<?php echo esc_attr( $p['name'] ); ?>" class="lumea-lp-img lumea-lp-img--main" loading="lazy" />
					<img src="<?php echo esc_url( $p['hover'] ); ?>" alt="" class="lumea-lp-img lumea-lp-img--hover" loading="lazy" aria-hidden="true" />
				</a>
				<div class="lumea-lp-body">
					<h3 class="lumea-lp-name"><a href="<?php echo esc_url( $p['url'] ); ?>"><?php echo esc_html( $p['name'] ); ?></a></h3>
					<div class="lumea-lp-pricing">
						<?php if ( $lp_is_sale ) : ?>
						<s class="lumea-lp-old"><?php echo esc_html( $lp_old_price ); ?></s>
						<?php endif; ?>
						<span class="lumea-lp-price<?php echo $lp_is_sale ? ' lumea-lp-price--sale' : ''; ?>"><?php echo esc_html( $p['price'] ); ?></span>
					</div>
					<a href="<?php echo esc_url( $p['url'] ); ?>" class="lumea-lp-btn">Shop Now</a>
				</div>
			</article>
			<?php endforeach; ?>
		</div>

	</div>
</section>

"""

content = content.replace('<!-- The Ritual Section -->', new_section + '<!-- The Ritual Section -->')
open(php_file, 'w', encoding='utf-8').write(content)
print('done')
