<?php
/**
 * Template Name: About Us
 * About Us page — Luméa.
 *
 * @package Lumea
 */

defined( 'ABSPATH' ) || exit;
get_header();
?>

<main class="lma-page" id="lumeaPage">

	<!-- ① HERO ─────────────────────────────────────────────── -->
	<section class="lma-hero" style="--lma-bg:url('<?php echo esc_url( LUMEA_THEME_URI ); ?>/assets/images/hero.jpg')">
		<div class="lma-hero-body">
			<p class="lma-label">Est. 2018 &middot; Paris</p>
			<h1 class="lma-hero-h1">
				<span class="lma-hero-line">Skincare</span>
				<span class="lma-hero-line lma-hero-line--stroke">as ritual.</span>
			</h1>
			<p class="lma-hero-sub">Every Luméa formula begins with a single question &mdash; what does your skin truly need?</p>
			<a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>" class="lma-hero-cta">
				Discover the Collection
				<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
			</a>
		</div>
		<div class="lma-hero-foot">
			<div class="lma-hero-foot-cell">
				<span class="lma-hero-foot-n">48+</span>
				<span class="lma-hero-foot-l">Botanical actives</span>
			</div>
			<div class="lma-hero-foot-cell">
				<span class="lma-hero-foot-n">12</span>
				<span class="lma-hero-foot-l">Countries sourced</span>
			</div>
			<div class="lma-hero-foot-cell">
				<span class="lma-hero-foot-n">100%</span>
				<span class="lma-hero-foot-l">Clean formulas</span>
			</div>
			<div class="lma-hero-foot-cell">
				<span class="lma-hero-foot-n">2018</span>
				<span class="lma-hero-foot-l">Founded in Paris</span>
			</div>
		</div>
		<div class="lma-hero-deco" aria-hidden="true"></div>
	</section>

	<!-- ② TICKER ────────────────────────────────────────────── -->
	<div class="lma-ticker" aria-hidden="true">
		<div class="lma-ticker-track">
			<?php for ( $i = 0; $i < 2; $i++ ) : ?>
			<span>BOTANICAL PURITY</span><span class="lma-ticker-sep">&middot;</span>
			<span>SCIENTIFIC PRECISION</span><span class="lma-ticker-sep">&middot;</span>
			<span>MINDFUL LUXURY</span><span class="lma-ticker-sep">&middot;</span>
			<span>CLEAN BEAUTY</span><span class="lma-ticker-sep">&middot;</span>
			<span>CRUELTY FREE</span><span class="lma-ticker-sep">&middot;</span>
			<span>SINCE 2018</span><span class="lma-ticker-sep">&middot;</span>
			<?php endfor; ?>
		</div>
	</div>

	<!-- ③ MANIFESTO ─────────────────────────────────────────── -->
	<section class="lma-manifesto">
		<div class="lma-manifesto-inner">
			<blockquote class="lma-manifesto-q">
				&ldquo;The most transformative skincare is the kind you actually look forward to. Not a routine&nbsp;&mdash; a ritual.&rdquo;
			</blockquote>
			<cite class="lma-manifesto-cite">&mdash;&nbsp;Sophie Laurent, Founder &amp; Cosmetic Chemist</cite>
		</div>
	</section>

	<!-- ④ STATS ─────────────────────────────────────────────── -->
	<section class="lma-stats">
		<div class="lma-stats-row">
			<div class="lma-stat-cell">
				<span class="lma-stat-tag">Founded</span>
				<span class="lma-stat-n">2018</span>
			</div>
			<div class="lma-stat-cell">
				<span class="lma-stat-tag">Botanical actives</span>
				<span class="lma-stat-n lma-stat-n--stroke">48+</span>
			</div>
			<div class="lma-stat-cell">
				<span class="lma-stat-tag">Countries sourced</span>
				<span class="lma-stat-n">12</span>
			</div>
			<div class="lma-stat-cell">
				<span class="lma-stat-tag">Clean formulas</span>
				<span class="lma-stat-n lma-stat-n--stroke">100%</span>
			</div>
		</div>
	</section>

	<!-- ⑤ STORY (STICKY SPLIT) ──────────────────────────────── -->
	<section class="lma-story">
		<div class="lma-story-img-col">
			<div class="lma-story-img-pin">
				<?php $si = get_theme_mod( 'lumea_about_story_image' ) ?: LUMEA_THEME_URI . '/assets/images/her02.jpg'; ?>
				<img src="<?php echo esc_url( $si ); ?>" alt="Lumea story" loading="lazy">
			</div>
		</div>
		<div class="lma-story-text-col">
			<div class="lma-story-panel">
				<p class="lma-label lma-label--warm">The Beginning</p>
				<h2 class="lma-story-h2">A skincare line rooted in botanical science</h2>
				<p class="lma-body">Luméa was born in a small Paris apartment, from years of frustration with formulas full of synthetic fillers and empty promises. Our founder, a trained cosmetic chemist, set out to create a line where every single ingredient earns its place.</p>
				<a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>" class="lma-link">
					Explore formulas
					<svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
				</a>
			</div>
			<div class="lma-story-panel">
				<p class="lma-label lma-label--warm">Our Process</p>
				<h2 class="lma-story-h2">From field to formula</h2>
				<p class="lma-body">We partner directly with farmers and distilleries across twelve countries &mdash; from Bulgarian rose valleys to Japanese forest bathing reserves &mdash; to source actives that are as potent as they are pure.</p>
				<p class="lma-body">Every formula is stress-tested at the cellular level before it reaches you, with clinically measurable results visible within 28&nbsp;days.</p>
			</div>
		</div>
	</section>

	<!-- ⑥ VALUES ────────────────────────────────────────────── -->
	<section class="lma-values" style="--lma-bg:url('<?php echo esc_url( LUMEA_THEME_URI ); ?>/assets/images/2.jpg')">
		<div class="lma-values-wrap">
			<div class="lma-values-head">
				<p class="lma-label" style="color:rgba(255,255,255,0.32)">What We Stand For</p>
				<h2 class="lma-values-h2">Three principles.<br>Every decision.</h2>
			</div>
			<div class="lma-values-grid">
				<div class="lma-val">
					<div class="lma-val-wm">I</div>
					<span class="lma-val-idx">01</span>
					<h3 class="lma-val-h3">Botanical Purity</h3>
					<p class="lma-val-p">We exclude over 1,400 controversial ingredients. If it isn't found in nature or proven safe by independent research, it doesn't enter our lab.</p>
				</div>
				<div class="lma-val">
					<div class="lma-val-wm">II</div>
					<span class="lma-val-idx">02</span>
					<h3 class="lma-val-h3">Scientific Precision</h3>
					<p class="lma-val-p">Botanicals alone aren't enough. Each formula is stress-tested at the cellular level to deliver clinically measurable results — visible within 28 days.</p>
				</div>
				<div class="lma-val">
					<div class="lma-val-wm">III</div>
					<span class="lma-val-idx">03</span>
					<h3 class="lma-val-h3">Mindful Luxury</h3>
					<p class="lma-val-p">Premium shouldn't cost the planet. We use ocean-bound glass packaging, carbon-neutral shipping, and donate 1% of every sale to reforestation.</p>
				</div>
			</div>
		</div>
	</section>

	<!-- ⑦ INGREDIENTS ───────────────────────────────────────── -->
	<section class="lma-ingredients">
		<div class="lma-ingredients-wrap">
			<div class="lma-ing-left">
				<p class="lma-label lma-label--warm">Ingredient Philosophy</p>
				<h2 class="lma-ing-h2">We believe in ingredients you can pronounce</h2>
				<p class="lma-body">Our ingredient selection starts in the field, not the lab. We work backwards from the plant — understanding its native habitat, harvest season, and traditional therapeutic uses before evaluating its bioactive potential.</p>
				<ul class="lma-check-list">
					<li>No synthetic fragrance</li>
					<li>No parabens or sulfates</li>
					<li>Cruelty-free, Leaping Bunny certified</li>
					<li>Sustainably sourced, traceable supply chain</li>
				</ul>
			</div>
			<div class="lma-ing-right">
				<div class="lma-ing-entry">
					<span class="lma-ing-tag">I</span>
					<div>
						<h4 class="lma-ing-name">Bulgarian Rose Otto</h4>
						<p class="lma-ing-desc">Sourced from the Rose Valley at peak bloom. 3.5 tonnes of petals yield one kilogram of oil.</p>
					</div>
				</div>
				<div class="lma-ing-entry">
					<span class="lma-ing-tag">II</span>
					<div>
						<h4 class="lma-ing-name">Bakuchiol</h4>
						<p class="lma-ing-desc">Nature&rsquo;s retinol alternative. Clinically proven to reduce fine lines without sensitivity.</p>
					</div>
				</div>
				<div class="lma-ing-entry">
					<span class="lma-ing-tag">III</span>
					<div>
						<h4 class="lma-ing-name">Snow Mushroom</h4>
						<p class="lma-ing-desc">Japanese forest extract. Holds 500&times; its weight in water — superior to hyaluronic acid.</p>
					</div>
				</div>
			</div>
		</div>
	</section>

	<!-- ⑧ PRESS ─────────────────────────────────────────────── -->
	<section class="lma-press">
		<p class="lma-press-label">As Featured In</p>
		<div class="lma-press-scroll" aria-hidden="true">
			<div class="lma-press-track">
				<?php
				$pubs = array( 'Vogue', "Harper's Bazaar", 'Byrdie', 'Into The Gloss', 'Refinery29', 'Elle', 'Allure' );
				for ( $i = 0; $i < 3; $i++ ) :
					foreach ( $pubs as $p ) :
				?>
				<span class="lma-press-n"><?php echo esc_html( $p ); ?></span><span class="lma-press-sep">&middot;</span>
				<?php endforeach; endfor; ?>
			</div>
		</div>
	</section>

	<!-- ⑨ CTA ───────────────────────────────────────────────── -->
	<section class="lma-cta" style="--lma-bg:url('<?php echo esc_url( LUMEA_THEME_URI ); ?>/assets/images/bestsellers/cta-bg.jpg')">
		<div class="lma-cta-inner">
			<p class="lma-label" style="color:rgba(255,255,255,0.4)">Begin Your Ritual</p>
			<h2 class="lma-cta-h2">Ready to meet<br>your skin&rsquo;s new favourites?</h2>
			<div class="lma-cta-btns">
				<a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>" class="lma-btn lma-btn--accent">Shop All Products</a>
				<a href="<?php echo esc_url( get_permalink( get_page_by_path( 'contact' ) ) ?: home_url( '/contact/' ) ); ?>" class="lma-btn lma-btn--ghost">Get In Touch</a>
			</div>
		</div>
	</section>

</main>

<?php get_footer(); ?>
