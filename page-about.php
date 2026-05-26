<?php
/**
 * Template Name: About Us
 * About Us page — Luméa premium edition.
 *
 * @package Lumea
 */

defined( 'ABSPATH' ) || exit;
get_header();
?>

<main class="lumea-about-page" id="lumeaPage">

	<!-- Hero -->
	<section class="lumea-about-hero">
		<div class="lumea-about-hero-inner">
			<p class="lumea-about-eyebrow">Our Story</p>
			<h1 class="lumea-about-hero-title">Born from the conviction<br>that skincare is ritual.</h1>
			<p class="lumea-about-hero-sub">Every Luméa formula begins with a single question — what does your skin truly need?</p>
			<a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>" class="lumea-about-hero-cta">
				Discover the Collection
				<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
			</a>
		</div>
		<div class="lumea-about-hero-scroll" aria-hidden="true">
			<svg width="1" height="60" viewBox="0 0 1 60"><line x1="0.5" y1="0" x2="0.5" y2="60" stroke="rgba(255,255,255,0.3)" stroke-width="1"/></svg>
		</div>
	</section>

	<!-- Manifesto -->
	<section class="lumea-about-manifesto">
		<div class="lumea-about-manifesto-inner">
			<blockquote class="lumea-about-quote">
				&ldquo;We believe the most transformative skincare is the kind you actually look forward to. Not a routine — a ritual.&rdquo;
			</blockquote>
			<div class="lumea-about-stats">
				<div class="lumea-about-stat">
					<span class="lumea-about-stat-num">2018</span>
					<span class="lumea-about-stat-label">Founded</span>
				</div>
				<div class="lumea-about-stat">
					<span class="lumea-about-stat-num">48+</span>
					<span class="lumea-about-stat-label">Botanical actives</span>
				</div>
				<div class="lumea-about-stat">
					<span class="lumea-about-stat-num">12</span>
					<span class="lumea-about-stat-label">Countries sourced</span>
				</div>
				<div class="lumea-about-stat">
					<span class="lumea-about-stat-num">100%</span>
					<span class="lumea-about-stat-label">Clean formulas</span>
				</div>
			</div>
		</div>
	</section>

	<!-- Origin Story -->
	<section class="lumea-about-story">
		<div class="lumea-about-story-inner">
			<div class="lumea-about-story-img">
				<div class="lumea-about-story-img-placeholder">
					<?php
					$story_img = get_theme_mod( 'lumea_about_story_image' );
					if ( $story_img ) : ?>
					<img src="<?php echo esc_url( $story_img ); ?>" alt="Lumea origin story" loading="lazy">
					<?php else : ?>
					<div class="lumea-about-img-fallback"></div>
					<?php endif; ?>
				</div>
			</div>
			<div class="lumea-about-story-text">
				<p class="lumea-about-section-eyebrow">The Beginning</p>
				<h2 class="lumea-about-section-title">A skincare line rooted in botanical science</h2>
				<p class="lumea-about-section-body">Luméa was born in a small Paris apartment, from years of frustration with formulas full of synthetic fillers and empty promises. Our founder, a trained cosmetic chemist, set out to create a line where every single ingredient earns its place.</p>
				<p class="lumea-about-section-body">We partner directly with farmers and distilleries across twelve countries — from Bulgarian rose valleys to Japanese forest bathing reserves — to source actives that are as potent as they are pure.</p>
				<a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>" class="lumea-about-story-link">
					Explore our formulas
					<svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
				</a>
			</div>
		</div>
	</section>

	<!-- Core Values -->
	<section class="lumea-about-values">
		<div class="lumea-about-values-inner">
			<div class="lumea-about-values-header">
				<p class="lumea-about-section-eyebrow" style="color:rgba(255,255,255,0.5);">What We Stand For</p>
				<h2 class="lumea-about-values-title">Three principles.<br>Every decision.</h2>
			</div>
			<div class="lumea-about-values-grid">
				<div class="lumea-about-value-card">
					<span class="lumea-about-value-num">01</span>
					<h3 class="lumea-about-value-title">Botanical Purity</h3>
					<p class="lumea-about-value-body">We exclude over 1,400 controversial ingredients. If it isn't found in nature or proven safe by independent research, it doesn't enter our lab.</p>
				</div>
				<div class="lumea-about-value-card">
					<span class="lumea-about-value-num">02</span>
					<h3 class="lumea-about-value-title">Scientific Precision</h3>
					<p class="lumea-about-value-body">Botanicals alone aren't enough. Each formula is stress-tested at the cellular level to deliver clinically measurable results — visible within 28 days.</p>
				</div>
				<div class="lumea-about-value-card">
					<span class="lumea-about-value-num">03</span>
					<h3 class="lumea-about-value-title">Mindful Luxury</h3>
					<p class="lumea-about-value-body">Premium shouldn't cost the planet. We use ocean-bound glass packaging, carbon-neutral shipping, and donate 1% of every sale to reforestation.</p>
				</div>
			</div>
		</div>
	</section>

	<!-- Ingredient Philosophy -->
	<section class="lumea-about-ingredients">
		<div class="lumea-about-ingredients-inner">
			<div class="lumea-about-ingredients-text">
				<p class="lumea-about-section-eyebrow">Ingredient Philosophy</p>
				<h2 class="lumea-about-section-title">We believe in ingredients you can pronounce</h2>
				<p class="lumea-about-section-body">Our ingredient selection starts in the field, not the lab. We work backwards from the plant — understanding its native habitat, harvest season, and traditional therapeutic uses before evaluating its modern bioactive potential.</p>
				<div class="lumea-about-ingredient-list">
					<div class="lumea-about-ingredient-item">
						<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="20 6 9 17 4 12"/></svg>
						<span>No synthetic fragrance</span>
					</div>
					<div class="lumea-about-ingredient-item">
						<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="20 6 9 17 4 12"/></svg>
						<span>No parabens or sulfates</span>
					</div>
					<div class="lumea-about-ingredient-item">
						<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="20 6 9 17 4 12"/></svg>
						<span>Cruelty-free, Leaping Bunny certified</span>
					</div>
					<div class="lumea-about-ingredient-item">
						<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="20 6 9 17 4 12"/></svg>
						<span>Sustainably sourced, traceable supply chain</span>
					</div>
				</div>
			</div>
			<div class="lumea-about-ingredients-visual">
				<div class="lumea-about-ingredient-feature">
					<div class="lumea-about-ingredient-circle">
						<svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 22s-8-4.5-8-11.8A8 8 0 0 1 12 2a8 8 0 0 1 8 8.2c0 7.3-8 11.8-8 11.8z"/><circle cx="12" cy="10" r="3"/></svg>
					</div>
					<h4>Bulgarian Rose Otto</h4>
					<p>Sourced from the Rose Valley at peak bloom. 3.5 tonnes of petals yield one kilogram of oil.</p>
				</div>
				<div class="lumea-about-ingredient-feature">
					<div class="lumea-about-ingredient-circle">
						<svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M2 12h20M12 2v20M4.93 4.93l14.14 14.14M19.07 4.93 4.93 19.07"/></svg>
					</div>
					<h4>Bakuchiol</h4>
					<p>Nature's retinol alternative. Clinically proven to reduce fine lines without sensitivity.</p>
				</div>
				<div class="lumea-about-ingredient-feature">
					<div class="lumea-about-ingredient-circle">
						<svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="10"/><path d="M12 8v4l3 3"/></svg>
					</div>
					<h4>Snow Mushroom</h4>
					<p>Japanese forest extract. Holds 500x its weight in water — superior to hyaluronic acid.</p>
				</div>
			</div>
		</div>
	</section>

	<!-- Press / Recognition -->
	<section class="lumea-about-press">
		<div class="lumea-about-press-inner">
			<p class="lumea-about-section-eyebrow" style="text-align:center;">As Featured In</p>
			<div class="lumea-about-press-logos">
				<span class="lumea-about-press-name">Vogue</span>
				<span class="lumea-about-press-divider" aria-hidden="true">·</span>
				<span class="lumea-about-press-name">Harper's Bazaar</span>
				<span class="lumea-about-press-divider" aria-hidden="true">·</span>
				<span class="lumea-about-press-name">Byrdie</span>
				<span class="lumea-about-press-divider" aria-hidden="true">·</span>
				<span class="lumea-about-press-name">Into The Gloss</span>
				<span class="lumea-about-press-divider" aria-hidden="true">·</span>
				<span class="lumea-about-press-name">Refinery29</span>
			</div>
		</div>
	</section>

	<!-- CTA -->
	<section class="lumea-about-cta">
		<div class="lumea-about-cta-inner">
			<p class="lumea-about-eyebrow" style="color:rgba(255,255,255,0.6);">Begin Your Ritual</p>
			<h2 class="lumea-about-cta-title">Ready to meet your skin's new favourites?</h2>
			<div class="lumea-about-cta-actions">
				<a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>" class="lumea-about-cta-btn lumea-about-cta-btn--primary">
					Shop All Products
				</a>
				<a href="<?php echo esc_url( get_permalink( get_page_by_path( 'contact' ) ) ?: home_url( '/contact/' ) ); ?>" class="lumea-about-cta-btn lumea-about-cta-btn--outline">
					Get In Touch
				</a>
			</div>
		</div>
	</section>

</main>

<?php get_footer(); ?>
