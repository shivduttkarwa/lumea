<?php
/**
 * Template Name: About Us
 * About Us page — Luméa.
 *
 * @package Lumea
 */

defined( 'ABSPATH' ) || exit;

get_header();

$a = array(
	
	'hero_bg'          => get_theme_mod( 'lma_about_hero_bg',        LUMEA_THEME_URI . '/assets/images/hero/about-hero.jpg' ),
	'hero_label'       => get_theme_mod( 'lma_about_hero_label',     'About Lum&eacute;a' ),
	'hero_h1_1'        => get_theme_mod( 'lma_about_hero_h1_1',      'Skincare, with intention.' ),
	'hero_h1_2'        => get_theme_mod( 'lma_about_hero_h1_2',      'Clean formulas. Quiet luxury.' ),
	'hero_sub'         => get_theme_mod( 'lma_about_hero_sub',       'We create botanical skincare that feels sensorial, performs clinically, and fits real life.' ),
	'hero_cta'         => get_theme_mod( 'lma_about_hero_cta',       'Shop the Ritual' ),
	'stat1_n'          => get_theme_mod( 'lma_about_stat1_n',        '48+' ),
	'stat1_l'          => get_theme_mod( 'lma_about_stat1_l',        'Botanical actives' ),
	'stat2_n'          => get_theme_mod( 'lma_about_stat2_n',        '12' ),
	'stat2_l'          => get_theme_mod( 'lma_about_stat2_l',        'Countries sourced' ),
	'stat3_n'          => get_theme_mod( 'lma_about_stat3_n',        '100%' ),
	'stat3_l'          => get_theme_mod( 'lma_about_stat3_l',        'Clean formulas' ),
	'stat4_n'          => get_theme_mod( 'lma_about_stat4_n',        '2018' ),
	'stat4_l'          => get_theme_mod( 'lma_about_stat4_l',        'Founded in Paris' ),
	
	'ticker'           => get_theme_mod( 'lma_about_ticker',         "BOTANICAL PURITY\nSCIENTIFIC PRECISION\nMINDFUL LUXURY\nCLEAN BEAUTY\nCRUELTY FREE\nSINCE 2018" ),
	
	'manifesto_q'      => get_theme_mod( 'lma_about_manifesto_q',    'The most transformative skincare is the kind you actually look forward to. Not a routine — a ritual.' ),
	'manifesto_cite'   => get_theme_mod( 'lma_about_manifesto_cite', 'Sophie Laurent, Founder & Cosmetic Chemist' ),
	
	'story_img'        => get_theme_mod( 'lumea_about_story_image',  LUMEA_THEME_URI . '/assets/images/her02.jpg' ),
	'story1_label'     => get_theme_mod( 'lma_about_story1_label',   'The Beginning' ),
	'story1_h2'        => get_theme_mod( 'lma_about_story1_h2',      'A skincare line rooted in botanical science' ),
	'story1_body'      => get_theme_mod( 'lma_about_story1_body',    'Luméa was born in a small Paris apartment, from years of frustration with formulas full of synthetic fillers and empty promises. Our founder, a trained cosmetic chemist, set out to create a line where every single ingredient earns its place.' ),
	'story1_link'      => get_theme_mod( 'lma_about_story1_link',    'Explore formulas' ),
	'story2_label'     => get_theme_mod( 'lma_about_story2_label',   'Our Process' ),
	'story2_h2'        => get_theme_mod( 'lma_about_story2_h2',      'From field to formula' ),
	'story2_body1'     => get_theme_mod( 'lma_about_story2_body1',   'We partner directly with farmers and distilleries across twelve countries — from Bulgarian rose valleys to Japanese forest bathing reserves — to source actives that are as potent as they are pure.' ),
	'story2_body2'     => get_theme_mod( 'lma_about_story2_body2',   'Every formula is stress-tested at the cellular level before it reaches you, with clinically measurable results visible within 28 days.' ),
	
	'values_bg'        => get_theme_mod( 'lma_about_values_bg',      LUMEA_THEME_URI . '/assets/images/2.jpg' ),
	'values_label'     => get_theme_mod( 'lma_about_values_label',   'What We Stand For' ),
	'values_h2'        => get_theme_mod( 'lma_about_values_h2',      'Three principles. Every decision.' ),
	'val1_h3'          => get_theme_mod( 'lma_about_val1_h3',        'Botanical Purity' ),
	'val1_p'           => get_theme_mod( 'lma_about_val1_p',         "We exclude over 1,400 controversial ingredients. If it isn't found in nature or proven safe by independent research, it doesn't enter our lab." ),
	'val2_h3'          => get_theme_mod( 'lma_about_val2_h3',        'Scientific Precision' ),
	'val2_p'           => get_theme_mod( 'lma_about_val2_p',         'Botanicals alone aren\'t enough. Each formula is stress-tested at the cellular level to deliver clinically measurable results — visible within 28 days.' ),
	'val3_h3'          => get_theme_mod( 'lma_about_val3_h3',        'Mindful Luxury' ),
	'val3_p'           => get_theme_mod( 'lma_about_val3_p',         'Premium shouldn\'t cost the planet. We use ocean-bound glass packaging, carbon-neutral shipping, and donate 1% of every sale to reforestation.' ),
	
	'ing_label'        => get_theme_mod( 'lma_about_ing_label',      'Ingredient Philosophy' ),
	'ing_h2'           => get_theme_mod( 'lma_about_ing_h2',         'We believe in ingredients you can pronounce' ),
	'ing_body'         => get_theme_mod( 'lma_about_ing_body',       'Our ingredient selection starts in the field, not the lab. We work backwards from the plant — understanding its native habitat, harvest season, and traditional therapeutic uses before evaluating its bioactive potential.' ),
	'ing_bullets'      => get_theme_mod( 'lma_about_ing_bullets',    "No synthetic fragrance\nNo parabens or sulfates\nCruelty-free, Leaping Bunny certified\nSustainably sourced, traceable supply chain" ),
	'ing1_name'        => get_theme_mod( 'lma_about_ing1_name',      'Bulgarian Rose Otto' ),
	'ing1_desc'        => get_theme_mod( 'lma_about_ing1_desc',      'Sourced from the Rose Valley at peak bloom. 3.5 tonnes of petals yield one kilogram of oil.' ),
	'ing2_name'        => get_theme_mod( 'lma_about_ing2_name',      'Bakuchiol' ),
	'ing2_desc'        => get_theme_mod( 'lma_about_ing2_desc',      "Nature's retinol alternative. Clinically proven to reduce fine lines without sensitivity." ),
	'ing3_name'        => get_theme_mod( 'lma_about_ing3_name',      'Snow Mushroom' ),
	'ing3_desc'        => get_theme_mod( 'lma_about_ing3_desc',      'Japanese forest extract. Holds 500× its weight in water — superior to hyaluronic acid.' ),
	
	'press_pubs'       => get_theme_mod( 'lma_about_press_pubs',     "Vogue\nHarper's Bazaar\nByrdie\nInto The Gloss\nRefinery29\nElle\nAllure" ),
	
	'cta_bg'           => get_theme_mod( 'lma_about_cta_bg',         LUMEA_THEME_URI . '/assets/images/bestsellers/cta-bg.jpg' ),
	'cta_label'        => get_theme_mod( 'lma_about_cta_label',      'Begin Your Ritual' ),
	'cta_h2'           => get_theme_mod( 'lma_about_cta_h2',         "Ready to meet\nyour skin's new favourites?" ),
	'cta_btn1'         => get_theme_mod( 'lma_about_cta_btn1',       'Shop All Products' ),
	'cta_btn2'         => get_theme_mod( 'lma_about_cta_btn2',       'Get In Touch' ),
);

?>

<main class="lma-page" id="lumeaPage">

	<!-- ① HERO ─────────────────────────────────────────────── -->
	<section class="lma-hero" style="--lma-bg:url('<?php echo esc_url( $a['hero_bg'] ); ?>')">
		<div class="lma-hero-body">
			<p class="lma-label lma-label--hero"><?php echo wp_kses_post( $a['hero_label'] ); ?></p>
			<h1 class="lma-hero-h1">
				<span class="lma-hero-line">Pure ritual.</span>
				<span class="lma-hero-line lma-hero-line--soft">Real results.</span>
			</h1>
			<p class="lma-hero-sub"><?php echo esc_html( $a['hero_sub'] ); ?></p>
		</div>
		<button class="lma-scroll-down" aria-label="<?php esc_attr_e( 'Scroll down', 'lumea' ); ?>">
			<span class="lma-scroll-dot"></span>
			<span class="lma-scroll-dot"></span>
			<span class="lma-scroll-dot"></span>
		</button>
	</section>


<!-- ③ MANIFESTO ─────────────────────────────────────────── -->
	<section class="lma-manifesto">
		<div class="lma-manifesto-inner">
			<blockquote class="lma-manifesto-q">
				&ldquo;<?php echo esc_html( $a['manifesto_q'] ); ?>&rdquo;
			</blockquote>
			<cite class="lma-manifesto-cite">&mdash;&nbsp;<?php echo esc_html( $a['manifesto_cite'] ); ?></cite>
		</div>
	</section>

	<!-- ④ STATS ─────────────────────────────────────────────── -->
	<section class="lma-stats">
		<div class="lma-stats-row">
			<div class="lma-stat-cell">
				<span class="lma-stat-tag"><?php echo esc_html( $a['stat1_l'] ); ?></span>
				<span class="lma-stat-n"><?php echo esc_html( $a['stat1_n'] ); ?></span>
			</div>
			<div class="lma-stat-cell">
				<span class="lma-stat-tag"><?php echo esc_html( $a['stat4_l'] ); ?></span>
				<span class="lma-stat-n lma-stat-n--stroke"><?php echo esc_html( $a['stat4_n'] ); ?></span>
			</div>
			<div class="lma-stat-cell">
				<span class="lma-stat-tag"><?php echo esc_html( $a['stat2_l'] ); ?></span>
				<span class="lma-stat-n"><?php echo esc_html( $a['stat2_n'] ); ?></span>
			</div>
			<div class="lma-stat-cell">
				<span class="lma-stat-tag"><?php echo esc_html( $a['stat3_l'] ); ?></span>
				<span class="lma-stat-n lma-stat-n--stroke"><?php echo esc_html( $a['stat3_n'] ); ?></span>
			</div>
		</div>
	</section>

	<!-- ⑤ STORY ─────────────────────────────────────────────── -->
	<section class="lma-story">
		<div class="lma-story-img-col">
			<div class="lma-story-img-pin">
				<img src="<?php echo esc_url( $a['story_img'] ); ?>" alt="<?php esc_attr_e( 'Lumea story', 'lumea' ); ?>" loading="lazy">
			</div>
		</div>
		<div class="lma-story-text-col">
			<div class="lma-story-panel">
				<p class="lma-label lma-label--warm"><?php echo esc_html( $a['story1_label'] ); ?></p>
				<h2 class="lma-story-h2"><?php echo esc_html( $a['story1_h2'] ); ?></h2>
				<p class="lma-body"><?php echo esc_html( $a['story1_body'] ); ?></p>
				<a href="<?php echo esc_url( lumea_get_shop_url() ); ?>" class="lma-link">
					<?php echo esc_html( $a['story1_link'] ); ?>
					<svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
				</a>
			</div>
			<div class="lma-story-panel">
				<p class="lma-label lma-label--warm"><?php echo esc_html( $a['story2_label'] ); ?></p>
				<h2 class="lma-story-h2"><?php echo esc_html( $a['story2_h2'] ); ?></h2>
				<p class="lma-body"><?php echo esc_html( $a['story2_body1'] ); ?></p>
				<p class="lma-body"><?php echo esc_html( $a['story2_body2'] ); ?></p>
			</div>
		</div>
	</section>

	<!-- ⑥ VALUES ────────────────────────────────────────────── -->
	<section class="lma-values" style="--lma-bg:url('<?php echo esc_url( $a['values_bg'] ); ?>')">
		<div class="lma-values-wrap">
			<div class="lma-values-head">
				<p class="lma-label" style="color:rgba(255,255,255,0.32)"><?php echo esc_html( $a['values_label'] ); ?></p>
				<h2 class="lma-values-h2"><?php echo nl2br( esc_html( $a['values_h2'] ) ); ?></h2>
			</div>
			<div class="lma-values-grid">
				<?php foreach ( array(
					array( 'I',   '01', $a['val1_h3'], $a['val1_p'] ),
					array( 'II',  '02', $a['val2_h3'], $a['val2_p'] ),
					array( 'III', '03', $a['val3_h3'], $a['val3_p'] ),
				) as $v ) : ?>
				<div class="lma-val">
					<div class="lma-val-wm"><?php echo esc_html( $v[0] ); ?></div>
					<span class="lma-val-idx"><?php echo esc_html( $v[1] ); ?></span>
					<h3 class="lma-val-h3"><?php echo esc_html( $v[2] ); ?></h3>
					<p class="lma-val-p"><?php echo esc_html( $v[3] ); ?></p>
				</div>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

	<!-- ⑦ INGREDIENTS ───────────────────────────────────────── -->
	<section class="lma-ingredients">
		<div class="lma-ingredients-wrap">
			<div class="lma-ing-left">
				<p class="lma-label lma-label--warm"><?php echo esc_html( $a['ing_label'] ); ?></p>
				<h2 class="lma-ing-h2"><?php echo esc_html( $a['ing_h2'] ); ?></h2>
				<p class="lma-body"><?php echo esc_html( $a['ing_body'] ); ?></p>
				<ul class="lma-check-list">
					<?php foreach ( lma_lines( $a['ing_bullets'] ) as $bullet ) : ?>
					<li><?php echo esc_html( $bullet ); ?></li>
					<?php endforeach; ?>
				</ul>
			</div>
			<div class="lma-ing-right">
				<?php
				$ingredients = array(
					array( 'I',   $a['ing1_name'], $a['ing1_desc'] ),
					array( 'II',  $a['ing2_name'], $a['ing2_desc'] ),
					array( 'III', $a['ing3_name'], $a['ing3_desc'] ),
				);
				foreach ( $ingredients as $ing ) : ?>
				<div class="lma-ing-entry">
					<span class="lma-ing-tag"><?php echo esc_html( $ing[0] ); ?></span>
					<div>
						<h4 class="lma-ing-name"><?php echo esc_html( $ing[1] ); ?></h4>
						<p class="lma-ing-desc"><?php echo esc_html( $ing[2] ); ?></p>
					</div>
				</div>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

	<!-- ⑧ PRESS ─────────────────────────────────────────────── -->
	<section class="lma-press">
		<p class="lma-press-label"><?php esc_html_e( 'As Featured In', 'lumea' ); ?></p>
		<div class="lma-press-scroll" aria-hidden="true">
			<div class="lma-press-track">
				<?php
				$pubs = lma_lines( $a['press_pubs'] );
				for ( $i = 0; $i < 3; $i++ ) :
					foreach ( $pubs as $p ) :
				?>
				<span class="lma-press-n"><?php echo esc_html( $p ); ?></span><span class="lma-press-sep">&middot;</span>
				<?php endforeach; endfor; ?>
			</div>
		</div>
	</section>

	<!-- ⑨ CTA ───────────────────────────────────────────────── -->
	<section class="lma-cta" style="--lma-bg:url('<?php echo esc_url( $a['cta_bg'] ); ?>')">
		<div class="lma-cta-inner">
			<p class="lma-label" style="color:rgba(255,255,255,0.4)"><?php echo esc_html( $a['cta_label'] ); ?></p>
			<h2 class="lma-cta-h2"><?php echo nl2br( esc_html( $a['cta_h2'] ) ); ?></h2>
			<div class="lma-cta-btns">
				<a href="<?php echo esc_url( lumea_get_shop_url() ); ?>" class="lma-btn lma-btn--accent">
					<?php echo esc_html( $a['cta_btn1'] ); ?>
				</a>
				<a href="<?php echo esc_url( get_permalink( get_page_by_path( 'contact' ) ) ?: home_url( '/contact/' ) ); ?>" class="lma-btn lma-btn--ghost">
					<?php echo esc_html( $a['cta_btn2'] ); ?>
				</a>
			</div>
		</div>
	</section>

</main>

<?php get_footer(); ?>
