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
	<section class="lma-hero">
		<div class="lma-hero-inner">
			<p class="lma-overline">Est. 2018 &middot; Paris</p>
			<h1 class="lma-hero-h1">
				<span class="lma-hero-line">Skincare</span>
				<span class="lma-hero-line lma-hero-line--indent">as ritual.</span>
			</h1>
			<p class="lma-hero-desc">Every Luméa formula begins with a single question — what does your skin truly need?</p>
			<a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>" class="lma-hero-cta">
				Discover the Collection
				<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
			</a>
		</div>
		<div class="lma-hero-strip">
			<div class="lma-hero-strip-item">
				<span class="lma-hero-strip-num">48+</span>
				<span class="lma-hero-strip-label">Botanical actives</span>
			</div>
			<div class="lma-hero-strip-item">
				<span class="lma-hero-strip-num">12</span>
				<span class="lma-hero-strip-label">Countries sourced</span>
			</div>
			<div class="lma-hero-strip-item">
				<span class="lma-hero-strip-num">100%</span>
				<span class="lma-hero-strip-label">Clean formulas</span>
			</div>
			<div class="lma-hero-strip-item">
				<span class="lma-hero-strip-num">2018</span>
				<span class="lma-hero-strip-label">Founded in Paris</span>
			</div>
		</div>
		<div class="lma-hero-ring" aria-hidden="true"></div>
	</section>

	<!-- ② TICKER ────────────────────────────────────────────── -->
	<div class="lma-ticker" aria-hidden="true">
		<div class="lma-ticker-track">
			<?php for ( $i = 0; $i < 2; $i++ ) : ?>
			<span>BOTANICAL PURITY</span><span class="lma-ticker-dot">&middot;</span>
			<span>SCIENTIFIC PRECISION</span><span class="lma-ticker-dot">&middot;</span>
			<span>MINDFUL LUXURY</span><span class="lma-ticker-dot">&middot;</span>
			<span>CLEAN BEAUTY</span><span class="lma-ticker-dot">&middot;</span>
			<span>CRUELTY FREE</span><span class="lma-ticker-dot">&middot;</span>
			<span>SINCE 2018</span><span class="lma-ticker-dot">&middot;</span>
			<?php endfor; ?>
		</div>
	</div>

	<!-- ③ MANIFESTO ─────────────────────────────────────────── -->
	<section class="lma-manifesto">
		<div class="lma-manifesto-inner">
			<blockquote class="lma-manifesto-q">
				&ldquo;The most transformative skincare is the kind you actually look forward to. Not a routine&nbsp;&mdash; a ritual.&rdquo;
			</blockquote>
			<cite class="lma-manifesto-cite">&mdash;&nbsp;Sophie Laurent, Founder</cite>
		</div>
	</section>

	<!-- ④ STORY ─────────────────────────────────────────────── -->
	<section class="lma-story">
		<div class="lma-story-media">
			<?php $story_img = get_theme_mod( 'lumea_about_story_image' ); ?>
			<?php if ( $story_img ) : ?>
				<img src="<?php echo esc_url( $story_img ); ?>" alt="Lumea origin story" loading="lazy">
			<?php else : ?>
				<div class="lma-story-fallback"></div>
			<?php endif; ?>
		</div>
		<div class="lma-story-text">
			<p class="lma-overline lma-overline--warm">The Beginning</p>
			<h2 class="lma-story-h2">A skincare line<br>rooted in botanical<br>science</h2>
			<p class="lma-body-copy">Luméa was born in a small Paris apartment, from years of frustration with formulas full of synthetic fillers and empty promises. Our founder, a trained cosmetic chemist, set out to create a line where every single ingredient earns its place.</p>
			<p class="lma-body-copy">We partner directly with farmers and distilleries across twelve countries — from Bulgarian rose valleys to Japanese forest bathing reserves — to source actives that are as potent as they are pure.</p>
			<a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>" class="lma-text-link">
				Explore our formulas
				<svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
			</a>
		</div>
	</section>

	<!-- ⑤ VALUES ────────────────────────────────────────────── -->
	<section class="lma-values">
		<div class="lma-values-inner">
			<div class="lma-values-head">
				<p class="lma-overline lma-overline--faint">What We Stand For</p>
				<h2 class="lma-values-h2">Three principles.<br>Every decision.</h2>
			</div>
			<div class="lma-values-cols">
				<div class="lma-val">
					<span class="lma-val-num">01</span>
					<h3 class="lma-val-title">Botanical Purity</h3>
					<p class="lma-val-body">We exclude over 1,400 controversial ingredients. If it isn't found in nature or proven safe by independent research, it doesn't enter our lab.</p>
				</div>
				<div class="lma-val">
					<span class="lma-val-num">02</span>
					<h3 class="lma-val-title">Scientific Precision</h3>
					<p class="lma-val-body">Botanicals alone aren't enough. Each formula is stress-tested at the cellular level to deliver clinically measurable results — visible within 28 days.</p>
				</div>
				<div class="lma-val">
					<span class="lma-val-num">03</span>
					<h3 class="lma-val-title">Mindful Luxury</h3>
					<p class="lma-val-body">Premium shouldn't cost the planet. We use ocean-bound glass packaging, carbon-neutral shipping, and donate 1% of every sale to reforestation.</p>
				</div>
			</div>
		</div>
	</section>

	<!-- ⑥ INGREDIENTS ───────────────────────────────────────── -->
	<section class="lma-ingredients">
		<div class="lma-ingredients-inner">
			<div class="lma-ing-left">
				<p class="lma-overline lma-overline--warm">Ingredient Philosophy</p>
				<h2 class="lma-ing-h2">We believe in ingredients you can pronounce</h2>
				<p class="lma-body-copy">Our ingredient selection starts in the field, not the lab. We work backwards from the plant — understanding its native habitat, harvest season, and traditional therapeutic uses before evaluating its modern bioactive potential.</p>
				<ul class="lma-clean-list">
					<li>No synthetic fragrance</li>
					<li>No parabens or sulfates</li>
					<li>Cruelty-free, Leaping Bunny certified</li>
					<li>Sustainably sourced, traceable supply chain</li>
				</ul>
			</div>
			<div class="lma-ing-right">
				<div class="lma-ing-item">
					<span class="lma-ing-item-tag">I</span>
					<div>
						<h4 class="lma-ing-item-name">Bulgarian Rose Otto</h4>
						<p class="lma-ing-item-body">Sourced from the Rose Valley at peak bloom. 3.5 tonnes of petals yield one kilogram of oil.</p>
					</div>
				</div>
				<div class="lma-ing-item">
					<span class="lma-ing-item-tag">II</span>
					<div>
						<h4 class="lma-ing-item-name">Bakuchiol</h4>
						<p class="lma-ing-item-body">Nature&rsquo;s retinol alternative. Clinically proven to reduce fine lines without sensitivity.</p>
					</div>
				</div>
				<div class="lma-ing-item">
					<span class="lma-ing-item-tag">III</span>
					<div>
						<h4 class="lma-ing-item-name">Snow Mushroom</h4>
						<p class="lma-ing-item-body">Japanese forest extract. Holds 500&times; its weight in water — superior to hyaluronic acid.</p>
					</div>
				</div>
			</div>
		</div>
	</section>

	<!-- ⑦ PRESS ─────────────────────────────────────────────── -->
	<section class="lma-press">
		<p class="lma-press-eyebrow">As Featured In</p>
		<div class="lma-press-scroll" aria-hidden="true">
			<div class="lma-press-track">
				<?php
				$publications = array( 'Vogue', "Harper's Bazaar", 'Byrdie', 'Into The Gloss', 'Refinery29', 'Elle', 'Allure' );
				for ( $i = 0; $i < 3; $i++ ) :
					foreach ( $publications as $pub ) :
				?>
				<span class="lma-press-name"><?php echo esc_html( $pub ); ?></span><span class="lma-press-dot">&middot;</span>
				<?php
					endforeach;
				endfor;
				?>
			</div>
		</div>
	</section>

	<!-- ⑧ CTA ───────────────────────────────────────────────── -->
	<section class="lma-cta">
		<div class="lma-cta-inner">
			<div>
				<p class="lma-overline lma-overline--faint">Begin Your Ritual</p>
				<h2 class="lma-cta-h2">Ready to meet<br>your skin&rsquo;s new<br>favourites?</h2>
			</div>
			<div class="lma-cta-actions">
				<a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>" class="lma-btn lma-btn--primary">Shop All Products</a>
				<a href="<?php echo esc_url( get_permalink( get_page_by_path( 'contact' ) ) ?: home_url( '/contact/' ) ); ?>" class="lma-btn lma-btn--ghost">Get In Touch</a>
			</div>
		</div>
	</section>

</main>

<?php get_footer(); ?>
