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
	
	'hero_bg'          => get_theme_mod( 'lumea_about_hero_bg',        LUMEA_THEME_URI . '/assets/images/hero/about-hero.jpg' ),
	'hero_label'       => get_theme_mod( 'lumea_about_hero_label',     'About Lum&eacute;a' ),
	'hero_h1_1'        => get_theme_mod( 'lumea_about_hero_h1_1',      'Skincare, with intention.' ),
	'hero_h1_2'        => get_theme_mod( 'lumea_about_hero_h1_2',      'Clean formulas. Quiet luxury.' ),
	'hero_sub'         => get_theme_mod( 'lumea_about_hero_sub',       'We create botanical skincare that feels sensorial, performs clinically, and fits real life.' ),
	'hero_cta'         => get_theme_mod( 'lumea_about_hero_cta',       'Shop the Ritual' ),
	'stat1_n'          => get_theme_mod( 'lumea_about_stat1_n',        '48+' ),
	'stat1_l'          => get_theme_mod( 'lumea_about_stat1_l',        'Botanical actives' ),
	'stat2_n'          => get_theme_mod( 'lumea_about_stat2_n',        '12' ),
	'stat2_l'          => get_theme_mod( 'lumea_about_stat2_l',        'Countries sourced' ),
	'stat3_n'          => get_theme_mod( 'lumea_about_stat3_n',        '100%' ),
	'stat3_l'          => get_theme_mod( 'lumea_about_stat3_l',        'Clean formulas' ),
	'stat4_n'          => get_theme_mod( 'lumea_about_stat4_n',        '2018' ),
	'stat4_l'          => get_theme_mod( 'lumea_about_stat4_l',        'Founded in Paris' ),
	
	'ticker'           => get_theme_mod( 'lumea_about_ticker',         "BOTANICAL PURITY\nSCIENTIFIC PRECISION\nMINDFUL LUXURY\nCLEAN BEAUTY\nCRUELTY FREE\nSINCE 2018" ),
	
	'manifesto_q'      => get_theme_mod( 'lumea_about_manifesto_q',    'The most transformative skincare is the kind you actually look forward to. Not a routine — a ritual.' ),
	'manifesto_cite'   => get_theme_mod( 'lumea_about_manifesto_cite', 'Sophie Laurent, Founder & Cosmetic Chemist' ),
	
	'story_img'        => get_theme_mod( 'lumea_about_story_image',  LUMEA_THEME_URI . '/assets/images/model-portrait.jpg' ),
	'story1_label'     => get_theme_mod( 'lumea_about_story1_label',   'The Beginning' ),
	'story1_h2'        => get_theme_mod( 'lumea_about_story1_h2',      'A skincare line rooted in botanical science' ),
	'story1_body'      => get_theme_mod( 'lumea_about_story1_body',    'Luméa was born in a small Paris apartment, from years of frustration with formulas full of synthetic fillers and empty promises. Our founder, a trained cosmetic chemist, set out to create a line where every single ingredient earns its place.' ),
	'story1_link'      => get_theme_mod( 'lumea_about_story1_link',    'Explore formulas' ),
	'story2_label'     => get_theme_mod( 'lumea_about_story2_label',   'Our Process' ),
	'story2_h2'        => get_theme_mod( 'lumea_about_story2_h2',      'From field to formula' ),
	'story2_body1'     => get_theme_mod( 'lumea_about_story2_body1',   'We partner directly with farmers and distilleries across twelve countries — from Bulgarian rose valleys to Japanese forest bathing reserves — to source actives that are as potent as they are pure.' ),
	'story2_body2'     => get_theme_mod( 'lumea_about_story2_body2',   'Every formula is stress-tested at the cellular level before it reaches you, with clinically measurable results visible within 28 days.' ),
	
	'values_bg'        => get_theme_mod( 'lumea_about_values_bg',      LUMEA_THEME_URI . '/assets/images/editorial-slide-2.jpg' ),
	'values_label'     => get_theme_mod( 'lumea_about_values_label',   'What We Stand For' ),
	'values_h2'        => get_theme_mod( 'lumea_about_values_h2',      'Three principles. Every decision.' ),
	'val1_h3'          => get_theme_mod( 'lumea_about_val1_h3',        'Botanical Purity' ),
	'val1_p'           => get_theme_mod( 'lumea_about_val1_p',         "We exclude over 1,400 controversial ingredients. If it isn't found in nature or proven safe by independent research, it doesn't enter our lab." ),
	'val2_h3'          => get_theme_mod( 'lumea_about_val2_h3',        'Scientific Precision' ),
	'val2_p'           => get_theme_mod( 'lumea_about_val2_p',         'Botanicals alone aren\'t enough. Each formula is stress-tested at the cellular level to deliver clinically measurable results — visible within 28 days.' ),
	'val3_h3'          => get_theme_mod( 'lumea_about_val3_h3',        'Mindful Luxury' ),
	'val3_p'           => get_theme_mod( 'lumea_about_val3_p',         'Premium shouldn\'t cost the planet. We use ocean-bound glass packaging, carbon-neutral shipping, and donate 1% of every sale to reforestation.' ),
	
	'ing_label'        => get_theme_mod( 'lumea_about_ing_label',      'Ingredient Philosophy' ),
	'ing_h2'           => get_theme_mod( 'lumea_about_ing_h2',         'We believe in ingredients you can pronounce' ),
	'ing_body'         => get_theme_mod( 'lumea_about_ing_body',       'Our ingredient selection starts in the field, not the lab. We work backwards from the plant — understanding its native habitat, harvest season, and traditional therapeutic uses before evaluating its bioactive potential.' ),
	'ing_bullets'      => get_theme_mod( 'lumea_about_ing_bullets',    "No synthetic fragrance\nNo parabens or sulfates\nCruelty-free, Leaping Bunny certified\nSustainably sourced, traceable supply chain" ),
	'ing1_name'        => get_theme_mod( 'lumea_about_ing1_name',      'Bulgarian Rose Otto' ),
	'ing1_desc'        => get_theme_mod( 'lumea_about_ing1_desc',      'Sourced from the Rose Valley at peak bloom. 3.5 tonnes of petals yield one kilogram of oil.' ),
	'ing2_name'        => get_theme_mod( 'lumea_about_ing2_name',      'Bakuchiol' ),
	'ing2_desc'        => get_theme_mod( 'lumea_about_ing2_desc',      "Nature's retinol alternative. Clinically proven to reduce fine lines without sensitivity." ),
	'ing3_name'        => get_theme_mod( 'lumea_about_ing3_name',      'Snow Mushroom' ),
	'ing3_desc'        => get_theme_mod( 'lumea_about_ing3_desc',      'Japanese forest extract. Holds 500× its weight in water — superior to hyaluronic acid.' ),
	
	'press_pubs'       => get_theme_mod( 'lumea_about_press_pubs',     "Vogue\nHarper's Bazaar\nByrdie\nInto The Gloss\nRefinery29\nElle\nAllure" ),
	
	'cta_bg'           => get_theme_mod( 'lumea_about_cta_bg',         LUMEA_THEME_URI . '/assets/images/bestsellers/cta-bg.jpg' ),
	'cta_label'        => get_theme_mod( 'lumea_about_cta_label',      'Begin Your Ritual' ),
	'cta_h2'           => get_theme_mod( 'lumea_about_cta_h2',         "Ready to meet\nyour skin's new favourites?" ),
	'cta_btn1'         => get_theme_mod( 'lumea_about_cta_btn1',       'Shop All Products' ),
	'cta_btn2'         => get_theme_mod( 'lumea_about_cta_btn2',       'Get In Touch' ),
);

?>

<main class="lumea-about-page" id="lumeaPage">

	<!-- ① HERO ─────────────────────────────────────────────── -->
	<section class="lumea-about-hero" style="--lumea-about-bg:url('<?php echo esc_url( $a['hero_bg'] ); ?>')">
		<div class="lumea-about-hero-body">
			<p class="lumea-about-label lumea-about-label--hero lumea-reveal-js lumea-reveal--fade-js lumea-reveal--hero-js"><?php echo wp_kses_post( $a['hero_label'] ); ?></p>
			<h1 class="lumea-about-hero-h1 lumea-reveal-js lumea-reveal--fade-js lumea-reveal--hero-js">
				<span class="lumea-about-hero-line">Pure ritual.</span>
				<span class="lumea-about-hero-line lumea-about-hero-line--soft">Real results.</span>
			</h1>
			<p class="lumea-about-hero-sub lumea-reveal-js lumea-reveal--fade-js lumea-reveal--hero-js"><?php echo esc_html( $a['hero_sub'] ); ?></p>
		</div>
		<button class="lumea-scroll-down" aria-label="<?php esc_attr_e( 'Scroll down', 'lumea' ); ?>">
			<span class="lumea-scroll-dot"></span>
			<span class="lumea-scroll-dot"></span>
			<span class="lumea-scroll-dot"></span>
		</button>
	</section>


<!-- ③ MANIFESTO ─────────────────────────────────────────── -->
	<section class="lumea-about-manifesto">
		<div class="lumea-about-manifesto-inner">
			<blockquote class="lumea-about-manifesto-q">
				&ldquo;<?php echo esc_html( $a['manifesto_q'] ); ?>&rdquo;
			</blockquote>
			<cite class="lumea-about-manifesto-cite lumea-reveal-js lumea-reveal--static-js">&mdash;&nbsp;<?php echo esc_html( $a['manifesto_cite'] ); ?></cite>
		</div>
	</section>

	<!-- ④ STATS ─────────────────────────────────────────────── -->
	<section class="lumea-about-stats">
		<div class="lumea-about-stats-row">
			<div class="lumea-about-stat-cell lumea-reveal-js lumea-reveal--static-js">
				<span class="lumea-about-stat-tag"><?php echo esc_html( $a['stat1_l'] ); ?></span>
				<span class="lumea-about-stat-n"><?php echo esc_html( $a['stat1_n'] ); ?></span>
			</div>
			<div class="lumea-about-stat-cell lumea-reveal-js lumea-reveal--static-js">
				<span class="lumea-about-stat-tag"><?php echo esc_html( $a['stat4_l'] ); ?></span>
				<span class="lumea-about-stat-n lumea-about-stat-n--stroke"><?php echo esc_html( $a['stat4_n'] ); ?></span>
			</div>
			<div class="lumea-about-stat-cell lumea-reveal-js lumea-reveal--static-js">
				<span class="lumea-about-stat-tag"><?php echo esc_html( $a['stat2_l'] ); ?></span>
				<span class="lumea-about-stat-n"><?php echo esc_html( $a['stat2_n'] ); ?></span>
			</div>
			<div class="lumea-about-stat-cell lumea-reveal-js lumea-reveal--static-js">
				<span class="lumea-about-stat-tag"><?php echo esc_html( $a['stat3_l'] ); ?></span>
				<span class="lumea-about-stat-n lumea-about-stat-n--stroke"><?php echo esc_html( $a['stat3_n'] ); ?></span>
			</div>
		</div>
	</section>

	<!-- ⑤ STORY ─────────────────────────────────────────────── -->
	<section class="lumea-about-story">
		<div class="lumea-about-story-img-col lumea-reveal-js lumea-reveal--static-js">
			<div class="lumea-about-story-img-pin">
				<img src="<?php echo esc_url( $a['story_img'] ); ?>" alt="<?php esc_attr_e( 'Lumea story', 'lumea' ); ?>" loading="lazy">
			</div>
		</div>
		<div class="lumea-about-story-text-col">
			<div class="lumea-about-story-panel lumea-reveal-js lumea-reveal--static-js">
				<p class="lumea-about-label lumea-about-label--warm"><?php echo esc_html( $a['story1_label'] ); ?></p>
				<h2 class="lumea-about-story-h2"><?php echo esc_html( $a['story1_h2'] ); ?></h2>
				<p class="lumea-about-body"><?php echo esc_html( $a['story1_body'] ); ?></p>
				<a href="<?php echo esc_url( lumea_get_shop_url() ); ?>" class="lumea-about-link">
					<?php echo esc_html( $a['story1_link'] ); ?>
					<svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
				</a>
			</div>
			<div class="lumea-about-story-panel lumea-reveal-js lumea-reveal--static-js">
				<p class="lumea-about-label lumea-about-label--warm"><?php echo esc_html( $a['story2_label'] ); ?></p>
				<h2 class="lumea-about-story-h2"><?php echo esc_html( $a['story2_h2'] ); ?></h2>
				<p class="lumea-about-body"><?php echo esc_html( $a['story2_body1'] ); ?></p>
				<p class="lumea-about-body"><?php echo esc_html( $a['story2_body2'] ); ?></p>
			</div>
		</div>
	</section>

	<!-- ⑥ VALUES ────────────────────────────────────────────── -->
	<section class="lumea-about-values" style="--lumea-about-bg:url('<?php echo esc_url( $a['values_bg'] ); ?>')">
		<div class="lumea-about-values-wrap">
			<div class="lumea-about-values-head lumea-section-intro-js">
				<p class="lumea-about-label lumea-eyebrow" style="color:rgba(255,255,255,0.32)"><?php echo esc_html( $a['values_label'] ); ?></p>
				<h2 class="lumea-about-values-h2 lumea-section-title"><?php echo nl2br( esc_html( $a['values_h2'] ) ); ?></h2>
			</div>
			<div class="lumea-about-values-grid">
				<?php foreach ( array(
					array( 'I',   '01', $a['val1_h3'], $a['val1_p'] ),
					array( 'II',  '02', $a['val2_h3'], $a['val2_p'] ),
					array( 'III', '03', $a['val3_h3'], $a['val3_p'] ),
				) as $v ) : ?>
				<div class="lumea-about-val lumea-reveal-js lumea-reveal--static-js">
					<div class="lumea-about-val-wm"><?php echo esc_html( $v[0] ); ?></div>
					<span class="lumea-about-val-idx"><?php echo esc_html( $v[1] ); ?></span>
					<h3 class="lumea-about-val-h3"><?php echo esc_html( $v[2] ); ?></h3>
					<p class="lumea-about-val-p"><?php echo esc_html( $v[3] ); ?></p>
				</div>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

	<!-- ⑦ INGREDIENTS ───────────────────────────────────────── -->
	<section class="lumea-about-ingredients">
		<div class="lumea-about-ingredients-wrap">
			<div class="lumea-about-ing-left lumea-section-intro-js">
				<p class="lumea-about-label lumea-about-label--warm lumea-eyebrow"><?php echo esc_html( $a['ing_label'] ); ?></p>
				<h2 class="lumea-about-ing-h2 lumea-section-title"><?php echo esc_html( $a['ing_h2'] ); ?></h2>
				<p class="lumea-about-body lumea-section-desc"><?php echo esc_html( $a['ing_body'] ); ?></p>
				<ul class="lumea-about-check-list lumea-reveal-js lumea-reveal--static-js">
					<?php foreach ( lumea_lines( $a['ing_bullets'] ) as $bullet ) : ?>
					<li><?php echo esc_html( $bullet ); ?></li>
					<?php endforeach; ?>
				</ul>
			</div>
			<div class="lumea-about-ing-right">
				<?php
				$ingredients = array(
					array( 'I',   $a['ing1_name'], $a['ing1_desc'] ),
					array( 'II',  $a['ing2_name'], $a['ing2_desc'] ),
					array( 'III', $a['ing3_name'], $a['ing3_desc'] ),
				);
				foreach ( $ingredients as $ing ) : ?>
				<div class="lumea-about-ing-entry lumea-reveal-js lumea-reveal--static-js">
					<span class="lumea-about-ing-tag"><?php echo esc_html( $ing[0] ); ?></span>
					<div>
						<h4 class="lumea-about-ing-name"><?php echo esc_html( $ing[1] ); ?></h4>
						<p class="lumea-about-ing-desc"><?php echo esc_html( $ing[2] ); ?></p>
					</div>
				</div>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

	<!-- ⑧ PRESS ─────────────────────────────────────────────── -->
	<section class="lumea-about-press">
		<p class="lumea-about-press-label lumea-reveal-js lumea-reveal--static-js"><?php esc_html_e( 'As Featured In', 'lumea' ); ?></p>
		<div class="lumea-about-press-scroll" aria-hidden="true">
			<div class="lumea-about-press-track">
				<?php
				$pubs = lumea_lines( $a['press_pubs'] );
				for ( $i = 0; $i < 3; $i++ ) :
					foreach ( $pubs as $p ) :
				?>
				<span class="lumea-about-press-n"><?php echo esc_html( $p ); ?></span><span class="lumea-about-press-sep">&middot;</span>
				<?php endforeach; endfor; ?>
			</div>
		</div>
	</section>

	<!-- ⑨ CTA ───────────────────────────────────────────────── -->
	<section class="lumea-about-cta" style="--lumea-about-bg:url('<?php echo esc_url( $a['cta_bg'] ); ?>')">
		<div class="lumea-about-cta-inner lumea-section-intro-js">
			<p class="lumea-about-label lumea-eyebrow" style="color:rgba(255,255,255,0.4)"><?php echo esc_html( $a['cta_label'] ); ?></p>
			<h2 class="lumea-about-cta-h2 lumea-section-title"><?php echo nl2br( esc_html( $a['cta_h2'] ) ); ?></h2>
			<div class="lumea-about-cta-btns lumea-reveal-js lumea-reveal--static-js">
				<a href="<?php echo esc_url( lumea_get_shop_url() ); ?>" class="lumea-about-btn lumea-about-btn--accent">
					<?php echo esc_html( $a['cta_btn1'] ); ?>
				</a>
				<a href="<?php echo esc_url( get_permalink( get_page_by_path( 'contact' ) ) ?: home_url( '/contact/' ) ); ?>" class="lumea-about-btn lumea-about-btn--ghost">
					<?php echo esc_html( $a['cta_btn2'] ); ?>
				</a>
			</div>
		</div>
	</section>

</main>

<?php get_footer(); ?>
