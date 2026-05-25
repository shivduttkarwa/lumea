<?php
/**
 * Front page template.
 *
 * @package Lumea
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<!-- ═══════════════════════════════════════════
     HERO
     ═══════════════════════════════════════════ -->
<section class="lumea-hero" aria-label="<?php esc_attr_e( 'Welcome to Lumea', 'lumea' ); ?>">
	<div class="lumea-hero-bg" aria-hidden="true"></div>
	<img class="lumea-hero-bg-img"
	     src="https://images.unsplash.com/photo-1522337360788-8b13dee7a37e?auto=format&fit=crop&w=1800&q=75"
	     alt=""
	     aria-hidden="true"
	     loading="eager"
	     fetchpriority="high">
	<div class="lumea-hero-ornament" aria-hidden="true"></div>

	<div class="lumea-container lumea-hero-content">
		<p class="lumea-eyebrow lumea-hero-eyebrow lumea-reveal">
			<?php esc_html_e( 'Premium Beauty & Skincare', 'lumea' ); ?>
		</p>

		<h1 class="lumea-hero-title lumea-reveal lumea-reveal--delay-1">
			<?php esc_html_e( 'Skin that', 'lumea' ); ?><br>
			<em><?php esc_html_e( 'speaks', 'lumea' ); ?></em><br>
			<?php esc_html_e( 'for itself.', 'lumea' ); ?>
		</h1>

		<div class="lumea-hero-footer lumea-reveal lumea-reveal--delay-2">
			<p class="lumea-hero-desc">
				<?php esc_html_e( 'Formulated with clinical precision. Crafted for every skin story. Discover rituals that transform your complexion from within.', 'lumea' ); ?>
			</p>
			<div class="lumea-hero-ctas">
				<a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>"
				   class="lumea-btn lumea-btn--primary">
					<?php esc_html_e( 'Shop Collection', 'lumea' ); ?>
					<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
				</a>
				<a href="<?php echo esc_url( get_permalink( get_page_by_path( 'about' ) ) ); ?>"
				   class="lumea-btn lumea-btn--outline">
					<?php esc_html_e( 'Our Story', 'lumea' ); ?>
				</a>
			</div>
		</div>
	</div>

	<div class="lumea-hero-scroll" aria-hidden="true">
		<span class="lumea-hero-scroll-line"></span>
		<span><?php esc_html_e( 'Scroll', 'lumea' ); ?></span>
	</div>
</section>

<!-- ═══════════════════════════════════════════
     MARQUEE STRIP
     ═══════════════════════════════════════════ -->
<div class="lumea-marquee-strip" aria-hidden="true">
	<div class="lumea-marquee-track">
		<?php
		$lumea_marquee_items = array(
			__( 'Clean Formulas', 'lumea' ),
			__( 'Dermatologist Tested', 'lumea' ),
			__( 'Cruelty Free', 'lumea' ),
			__( 'Sustainable Packaging', 'lumea' ),
			__( 'Clinically Proven', 'lumea' ),
			__( 'Vegan Ingredients', 'lumea' ),
			__( 'No Parabens', 'lumea' ),
			__( 'Fragrance Free Options', 'lumea' ),
		);
		// Duplicate for seamless loop.
		$lumea_marquee_all = array_merge( $lumea_marquee_items, $lumea_marquee_items );
		foreach ( $lumea_marquee_all as $lumea_item ) :
			?>
			<span class="lumea-marquee-item">
				<span class="lumea-marquee-dot"></span>
				<?php echo esc_html( $lumea_item ); ?>
			</span>
		<?php endforeach; ?>
	</div>
</div>

<!-- ═══════════════════════════════════════════
     FEATURED PRODUCTS
     ═══════════════════════════════════════════ -->
<section class="lumea-section lumea-section--dark" aria-labelledby="lumea-featured-heading">
	<div class="lumea-container">
		<header class="lumea-section-header">
			<div>
				<span class="lumea-eyebrow lumea-section-kicker lumea-reveal">
					<?php esc_html_e( 'New Arrivals', 'lumea' ); ?>
				</span>
				<h2 id="lumea-featured-heading"
				    class="lumea-display lumea-display--md lumea-reveal lumea-reveal--delay-1"
				    style="color:var(--lumea-text-light)">
					<?php esc_html_e( 'Curated for your skin', 'lumea' ); ?>
				</h2>
			</div>
			<a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>"
			   class="lumea-btn lumea-btn--outline lumea-reveal lumea-reveal--delay-2">
				<?php esc_html_e( 'View All', 'lumea' ); ?>
			</a>
		</header>

		<div class="lumea-products-grid">
			<?php
			if ( class_exists( 'WooCommerce' ) ) {
				$lumea_featured = wc_get_products( array(
					'limit'    => 3,
					'orderby'  => 'date',
					'order'    => 'DESC',
					'status'   => 'publish',
				) );

				if ( ! empty( $lumea_featured ) ) :
					foreach ( $lumea_featured as $lumea_product ) :
						$lumea_img_id  = $lumea_product->get_image_id();
						$lumea_img_url = $lumea_img_id ? wp_get_attachment_image_url( $lumea_img_id, 'woocommerce_single' ) : '';
						$lumea_cats    = wc_get_product_category_list( $lumea_product->get_id(), ', ' );
						?>
						<article class="lumea-product-card lumea-reveal lumea-reveal--delay-<?php echo esc_attr( $lumea_product === reset( $lumea_featured ) ? '1' : ( $lumea_product === $lumea_featured[1] ? '2' : '3' ) ); ?>">
							<a href="<?php echo esc_url( $lumea_product->get_permalink() ); ?>"
							   class="lumea-product-img-wrap"
							   tabindex="-1"
							   aria-hidden="true">
								<?php if ( $lumea_img_url ) : ?>
									<img src="<?php echo esc_url( $lumea_img_url ); ?>"
									     alt="<?php echo esc_attr( $lumea_product->get_name() ); ?>"
									     loading="lazy">
								<?php else : ?>
									<div style="width:100%;height:100%;background:var(--lumea-dark-3);display:flex;align-items:center;justify-content:center;">
										<svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="rgba(250,248,245,0.15)" stroke-width="1" aria-hidden="true"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><path d="m21 15-5-5L5 21"/></svg>
									</div>
								<?php endif; ?>
								<?php if ( $lumea_product->is_on_sale() ) : ?>
									<span class="lumea-product-badge"><?php esc_html_e( 'Sale', 'lumea' ); ?></span>
								<?php endif; ?>
								<span class="lumea-product-quick-add" aria-hidden="true">
									<?php esc_html_e( '+ Quick Add', 'lumea' ); ?>
								</span>
							</a>
							<div class="lumea-product-category">
								<?php echo wp_kses_post( $lumea_cats ); ?>
							</div>
							<h3 class="lumea-product-name">
								<a href="<?php echo esc_url( $lumea_product->get_permalink() ); ?>">
									<?php echo esc_html( $lumea_product->get_name() ); ?>
								</a>
							</h3>
							<div class="lumea-product-price">
								<?php echo wp_kses_post( $lumea_product->get_price_html() ); ?>
							</div>
						</article>
					<?php endforeach;
				else : ?>
					<?php lumea_fp_placeholder_products( 3, 'dark' ); ?>
				<?php endif;
			} else {
				lumea_fp_placeholder_products( 3, 'dark' );
			}
			?>
		</div>
	</div>
</section>

<!-- ═══════════════════════════════════════════
     SKIN CONCERN CARDS
     ═══════════════════════════════════════════ -->
<section class="lumea-section lumea-section--cream" aria-labelledby="lumea-concerns-heading">
	<div class="lumea-container">
		<header class="lumea-section-header lumea-section-header--center">
			<div>
				<span class="lumea-eyebrow lumea-section-kicker lumea-reveal">
					<?php esc_html_e( 'Shop by Concern', 'lumea' ); ?>
				</span>
				<h2 id="lumea-concerns-heading"
				    class="lumea-display lumea-display--md lumea-reveal lumea-reveal--delay-1">
					<?php esc_html_e( 'Find your formula', 'lumea' ); ?>
				</h2>
			</div>
		</header>

		<div class="lumea-concerns-grid">
			<?php
			$lumea_concerns = array(
				array(
					'name'  => __( 'Hydration', 'lumea' ),
					'count' => 14,
					'color' => '#2a3d5e',
					'letter' => 'H',
				),
				array(
					'name'  => __( 'Brightening', 'lumea' ),
					'count' => 9,
					'color' => '#5e4a2a',
					'letter' => 'B',
				),
				array(
					'name'  => __( 'Anti-Aging', 'lumea' ),
					'count' => 11,
					'color' => '#3d2a5e',
					'letter' => 'A',
				),
				array(
					'name'  => __( 'Sensitive', 'lumea' ),
					'count' => 8,
					'color' => '#2a5e4a',
					'letter' => 'S',
				),
				array(
					'name'  => __( 'Acne Care', 'lumea' ),
					'count' => 7,
					'color' => '#5e2a2a',
					'letter' => 'C',
				),
			);

			foreach ( $lumea_concerns as $lumea_i => $lumea_concern ) :
				$lumea_cat_link = get_term_link( sanitize_title( $lumea_concern['name'] ), 'product_cat' );
				$lumea_cat_link = is_wp_error( $lumea_cat_link )
					? esc_url( wc_get_page_permalink( 'shop' ) )
					: esc_url( $lumea_cat_link );
				?>
				<a href="<?php echo esc_url( $lumea_cat_link ); ?>"
				   class="lumea-concern-card lumea-reveal lumea-reveal--delay-<?php echo esc_attr( $lumea_i + 1 ); ?>"
				   aria-label="<?php echo esc_attr( sprintf( __( 'Shop %s — %d products', 'lumea' ), $lumea_concern['name'], $lumea_concern['count'] ) ); ?>">
					<div class="lumea-concern-bg"
					     style="background:<?php echo esc_attr( $lumea_concern['color'] ); ?>;"
					     aria-hidden="true"></div>
					<div class="lumea-concern-gradient" aria-hidden="true"></div>
					<div class="lumea-concern-body">
						<div class="lumea-concern-icon" aria-hidden="true">
							<svg viewBox="0 0 36 36" fill="none" stroke="rgba(250,248,245,0.7)" stroke-width="1.2">
								<circle cx="18" cy="18" r="14"/>
								<circle cx="18" cy="18" r="6"/>
							</svg>
						</div>
						<div class="lumea-concern-name"><?php echo esc_html( $lumea_concern['name'] ); ?></div>
						<div class="lumea-concern-count">
							<?php echo esc_html( sprintf( _n( '%d product', '%d products', $lumea_concern['count'], 'lumea' ), $lumea_concern['count'] ) ); ?>
						</div>
					</div>
				</a>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<!-- ═══════════════════════════════════════════
     INGREDIENT SPOTLIGHT
     ═══════════════════════════════════════════ -->
<section class="lumea-ingredient" aria-labelledby="lumea-ingredient-heading">
	<div class="lumea-ingredient-visual" aria-hidden="true">
		<div class="lumea-ingredient-visual-inner">
			<div class="lumea-ingredient-circle">
				<span class="lumea-ingredient-letter">R</span>
			</div>
		</div>
	</div>
	<div class="lumea-ingredient-content">
		<div>
			<span class="lumea-eyebrow lumea-reveal">
				<?php esc_html_e( 'Hero Ingredient', 'lumea' ); ?>
			</span>
		</div>
		<h2 id="lumea-ingredient-heading"
		    class="lumea-display lumea-display--md lumea-reveal lumea-reveal--delay-1">
			<?php esc_html_e( 'The power of Retinol', 'lumea' ); ?>
		</h2>
		<p class="lumea-ingredient-desc lumea-reveal lumea-reveal--delay-2">
			<?php esc_html_e( 'A gold-standard active clinically proven to accelerate cell turnover, smooth fine lines, and restore a youthful luminosity — now in a gentle, microencapsulated form your skin will love.', 'lumea' ); ?>
		</p>
		<ul class="lumea-ingredient-facts lumea-reveal lumea-reveal--delay-3" role="list">
			<?php
			$lumea_facts = array(
				__( 'Reduces fine lines by up to 44% in 8 weeks', 'lumea' ),
				__( 'Microencapsulated for slow-release, zero irritation', 'lumea' ),
				__( 'Pairs perfectly with our Barrier Repair Moisturiser', 'lumea' ),
			);
			foreach ( $lumea_facts as $lumea_fact ) :
				?>
				<li class="lumea-ingredient-fact">
					<span class="lumea-ingredient-fact-dot" aria-hidden="true"></span>
					<?php echo esc_html( $lumea_fact ); ?>
				</li>
			<?php endforeach; ?>
		</ul>
		<div class="lumea-reveal lumea-reveal--delay-4">
			<a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>"
			   class="lumea-btn lumea-btn--primary-dark">
				<?php esc_html_e( 'Shop Retinol Range', 'lumea' ); ?>
			</a>
		</div>
	</div>
</section>

<!-- ═══════════════════════════════════════════
     BESTSELLERS
     ═══════════════════════════════════════════ -->
<section class="lumea-section lumea-section--cream-2" aria-labelledby="lumea-bestsellers-heading">
	<div class="lumea-container">
		<header class="lumea-section-header">
			<div>
				<span class="lumea-eyebrow lumea-section-kicker lumea-reveal">
					<?php esc_html_e( 'Best Sellers', 'lumea' ); ?>
				</span>
				<h2 id="lumea-bestsellers-heading"
				    class="lumea-display lumea-display--md lumea-reveal lumea-reveal--delay-1">
					<?php esc_html_e( 'Loved by thousands', 'lumea' ); ?>
				</h2>
			</div>
		</header>
	</div>

	<?php
	if ( class_exists( 'WooCommerce' ) ) {
		$lumea_bestsellers = wc_get_products( array(
			'limit'    => 2,
			'orderby'  => 'popularity',
			'order'    => 'DESC',
			'status'   => 'publish',
		) );
	} else {
		$lumea_bestsellers = array();
	}

	if ( ! empty( $lumea_bestsellers ) ) :
		foreach ( $lumea_bestsellers as $lumea_i => $lumea_product ) :
			$lumea_img_id  = $lumea_product->get_image_id();
			$lumea_img_url = $lumea_img_id ? wp_get_attachment_image_url( $lumea_img_id, 'woocommerce_single' ) : '';
			?>
			<article class="lumea-bestseller-item">
				<div class="lumea-bestseller-visual">
					<?php if ( $lumea_img_url ) : ?>
						<img src="<?php echo esc_url( $lumea_img_url ); ?>"
						     alt="<?php echo esc_attr( $lumea_product->get_name() ); ?>"
						     loading="lazy">
					<?php endif; ?>
				</div>
				<div class="lumea-bestseller-content">
					<div class="lumea-bestseller-num lumea-reveal">
						<?php echo esc_html( sprintf( '%02d', $lumea_i + 1 ) ); ?> —
						<?php esc_html_e( 'Best Seller', 'lumea' ); ?>
					</div>
					<h3 class="lumea-bestseller-name lumea-reveal lumea-reveal--delay-1">
						<?php echo esc_html( $lumea_product->get_name() ); ?>
					</h3>
					<p class="lumea-bestseller-tagline lumea-reveal lumea-reveal--delay-2">
						<?php echo wp_kses_post( wp_trim_words( $lumea_product->get_short_description(), 22, '&hellip;' ) ); ?>
					</p>
					<div class="lumea-bestseller-meta lumea-reveal lumea-reveal--delay-3">
						<div class="lumea-bestseller-price">
							<?php echo wp_kses_post( $lumea_product->get_price_html() ); ?>
						</div>
						<div class="lumea-star-rating" aria-label="<?php esc_attr_e( '5 stars', 'lumea' ); ?>">
							<?php for ( $s = 0; $s < 5; $s++ ) : ?>
								<svg width="13" height="13" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
							<?php endfor; ?>
							<span>(<?php echo esc_html( number_format_i18n( rand( 120, 490 ) ) ); ?>)</span>
						</div>
					</div>
					<div class="lumea-reveal lumea-reveal--delay-4">
						<a href="<?php echo esc_url( $lumea_product->get_permalink() ); ?>"
						   class="lumea-btn lumea-btn--primary-dark">
							<?php esc_html_e( 'Shop Now', 'lumea' ); ?>
						</a>
					</div>
				</div>
			</article>
		<?php endforeach;
	else :
		lumea_fp_placeholder_bestsellers();
	endif;
	?>
</section>

<!-- ═══════════════════════════════════════════
     BRAND STORY
     ═══════════════════════════════════════════ -->
<section class="lumea-story" aria-labelledby="lumea-story-heading">
	<div class="lumea-container">
		<div class="lumea-story-inner">
			<div aria-hidden="true">
				<span class="lumea-story-label">
					<?php esc_html_e( 'Our Philosophy', 'lumea' ); ?>
				</span>
			</div>
			<div>
				<h2 id="lumea-story-heading" class="lumea-story-text lumea-reveal">
					<?php esc_html_e( '"We believe radiant skin isn\'t a destination — it\'s a daily', 'lumea' ); ?>
					<em><?php esc_html_e( 'ritual', 'lumea' ); ?></em>
					<?php esc_html_e( 'built on science, simplicity, and self-care."', 'lumea' ); ?>
				</h2>
				<p class="lumea-story-caption lumea-reveal lumea-reveal--delay-1">
					<?php esc_html_e( 'Founded by a team of cosmetic scientists and skincare enthusiasts, Luméa was born from a shared frustration with complexity. We stripped away the noise and distilled decades of dermatological research into products that actually work — for every skin type, every age, every story.', 'lumea' ); ?>
				</p>
				<a href="<?php echo esc_url( get_permalink( get_page_by_path( 'about' ) ) ); ?>"
				   class="lumea-story-link lumea-reveal lumea-reveal--delay-2">
					<?php esc_html_e( 'Read our story', 'lumea' ); ?>
					<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
				</a>
			</div>
		</div>
	</div>
</section>

<!-- ═══════════════════════════════════════════
     RITUAL STEPS
     ═══════════════════════════════════════════ -->
<section class="lumea-ritual" aria-labelledby="lumea-ritual-heading">
	<div class="lumea-container">
		<header class="lumea-section-header lumea-section-header--center">
			<div>
				<span class="lumea-eyebrow lumea-section-kicker lumea-reveal"
				      style="color:var(--lumea-muted-light)">
					<?php esc_html_e( 'Your Daily Ritual', 'lumea' ); ?>
				</span>
				<h2 id="lumea-ritual-heading"
				    class="lumea-display lumea-display--md lumea-reveal lumea-reveal--delay-1"
				    style="color:var(--lumea-text-light)">
					<?php esc_html_e( 'Four steps to glow', 'lumea' ); ?>
				</h2>
			</div>
		</header>

		<div class="lumea-ritual-steps">
			<?php
			$lumea_steps = array(
				array(
					'title' => __( 'Cleanse', 'lumea' ),
					'desc'  => __( 'Start fresh. Remove impurities with our gentle, pH-balanced formulas that preserve your skin barrier.', 'lumea' ),
				),
				array(
					'title' => __( 'Treat', 'lumea' ),
					'desc'  => __( 'Target your concern. Apply your serum while skin is damp for maximum active penetration.', 'lumea' ),
				),
				array(
					'title' => __( 'Hydrate', 'lumea' ),
					'desc'  => __( 'Seal in actives and reinforce the barrier with our lightweight yet deeply nourishing moisturisers.', 'lumea' ),
				),
				array(
					'title' => __( 'Protect', 'lumea' ),
					'desc'  => __( 'Every morning, SPF is non-negotiable. Our invisible formulas make daily protection effortless.', 'lumea' ),
				),
			);
			foreach ( $lumea_steps as $lumea_i => $lumea_step ) :
				?>
				<div class="lumea-ritual-step lumea-reveal lumea-reveal--delay-<?php echo esc_attr( $lumea_i + 1 ); ?>">
					<div class="lumea-ritual-num" aria-hidden="true">
						<?php echo esc_html( sprintf( '%02d', $lumea_i + 1 ) ); ?>
					</div>
					<h3 class="lumea-ritual-step-title">
						<?php echo esc_html( $lumea_step['title'] ); ?>
					</h3>
					<p class="lumea-ritual-step-desc">
						<?php echo esc_html( $lumea_step['desc'] ); ?>
					</p>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<!-- ═══════════════════════════════════════════
     TESTIMONIALS
     ═══════════════════════════════════════════ -->
<section class="lumea-section lumea-section--cream" aria-labelledby="lumea-testimonials-heading">
	<div class="lumea-container">
		<header class="lumea-section-header lumea-section-header--center">
			<div>
				<span class="lumea-eyebrow lumea-section-kicker lumea-reveal">
					<?php esc_html_e( 'Real Results', 'lumea' ); ?>
				</span>
				<h2 id="lumea-testimonials-heading"
				    class="lumea-display lumea-display--md lumea-reveal lumea-reveal--delay-1">
					<?php esc_html_e( 'What they\'re saying', 'lumea' ); ?>
				</h2>
			</div>
		</header>

		<div class="lumea-testimonials-grid">
			<?php
			$lumea_testimonials = array(
				array(
					'quote'  => __( '"I\'ve tried everything for my dry, sensitive skin. Nothing compares to the Barrier Repair Moisturiser. Three weeks in and my skin has completely transformed."', 'lumea' ),
					'name'   => 'Sarah M.',
					'handle' => __( 'Verified Buyer', 'lumea' ),
					'initial'=> 'S',
				),
				array(
					'quote'  => __( '"The Vitamin C serum is genuinely the best I\'ve used. Bright, even, glowing — and no irritation whatsoever. It\'s earned a permanent spot in my morning routine."', 'lumea' ),
					'name'   => 'Priya K.',
					'handle' => __( 'Verified Buyer', 'lumea' ),
					'initial'=> 'P',
				),
				array(
					'quote'  => __( '"Finally, skincare that delivers on its promises. The Retinol Night Cream has visibly softened my fine lines in just six weeks. I\'m completely converted."', 'lumea' ),
					'name'   => 'Amelia T.',
					'handle' => __( 'Verified Buyer', 'lumea' ),
					'initial'=> 'A',
				),
			);

			foreach ( $lumea_testimonials as $lumea_i => $lumea_t ) :
				?>
				<article class="lumea-testimonial-card lumea-reveal lumea-reveal--delay-<?php echo esc_attr( $lumea_i + 1 ); ?>">
					<div class="lumea-testimonial-stars" aria-label="<?php esc_attr_e( '5 out of 5 stars', 'lumea' ); ?>">
						<?php for ( $s = 0; $s < 5; $s++ ) : ?>
							<svg width="13" height="13" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
						<?php endfor; ?>
					</div>
					<blockquote class="lumea-testimonial-quote">
						<?php echo esc_html( $lumea_t['quote'] ); ?>
					</blockquote>
					<footer class="lumea-testimonial-author">
						<div class="lumea-testimonial-avatar" aria-hidden="true">
							<?php echo esc_html( $lumea_t['initial'] ); ?>
						</div>
						<div>
							<div class="lumea-testimonial-name"><?php echo esc_html( $lumea_t['name'] ); ?></div>
							<div class="lumea-testimonial-handle"><?php echo esc_html( $lumea_t['handle'] ); ?></div>
						</div>
					</footer>
				</article>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<!-- ═══════════════════════════════════════════
     NEWSLETTER CTA
     ═══════════════════════════════════════════ -->
<section class="lumea-newsletter" aria-labelledby="lumea-newsletter-heading">
	<div class="lumea-container">
		<div class="lumea-newsletter-inner">
			<span class="lumea-eyebrow lumea-reveal" style="color:var(--lumea-muted-light)">
				<?php esc_html_e( 'Join the Community', 'lumea' ); ?>
			</span>
			<h2 id="lumea-newsletter-heading"
			    class="lumea-newsletter-title lumea-reveal lumea-reveal--delay-1">
				<?php esc_html_e( 'Your ritual starts here', 'lumea' ); ?>
			</h2>
			<p class="lumea-newsletter-sub lumea-reveal lumea-reveal--delay-2">
				<?php esc_html_e( 'Subscribe for expert skincare tips, early access to new launches, and 15% off your first order.', 'lumea' ); ?>
			</p>
			<form class="lumea-newsletter-form lumea-reveal lumea-reveal--delay-3"
			      method="post"
			      novalidate
			      aria-label="<?php esc_attr_e( 'Newsletter signup', 'lumea' ); ?>">
				<label for="lumea-newsletter-email" class="screen-reader-text">
					<?php esc_html_e( 'Email address', 'lumea' ); ?>
				</label>
				<input id="lumea-newsletter-email"
				       class="lumea-newsletter-input"
				       type="email"
				       name="email"
				       placeholder="<?php esc_attr_e( 'Your email address', 'lumea' ); ?>"
				       required
				       autocomplete="email">
				<button type="submit" class="lumea-newsletter-submit">
					<?php esc_html_e( 'Subscribe', 'lumea' ); ?>
				</button>
			</form>
			<p class="lumea-newsletter-note lumea-reveal lumea-reveal--delay-4">
				<?php esc_html_e( 'No spam. Unsubscribe any time.', 'lumea' ); ?>
			</p>
		</div>
	</div>
</section>

<?php get_footer(); ?>

<?php
/**
 * Placeholder product cards for when WooCommerce has no products.
 *
 * @param int    $lumea_count  Number of cards.
 * @param string $lumea_theme  'dark' or 'light'.
 */
function lumea_fp_placeholder_products( $lumea_count = 3, $lumea_theme = 'dark' ) {
	$lumea_placeholders = array(
		array( 'name' => __( 'Brightening Vitamin C Serum', 'lumea' ), 'cat' => __( 'Serums', 'lumea' ), 'price' => '$68' ),
		array( 'name' => __( 'Barrier Repair Moisturiser', 'lumea' ), 'cat' => __( 'Moisturisers', 'lumea' ), 'price' => '$54' ),
		array( 'name' => __( 'Retinol Night Cream', 'lumea' ), 'cat' => __( 'Treatments', 'lumea' ), 'price' => '$76' ),
	);
	$lumea_light_mod = ( 'light' === $lumea_theme ) ? ' lumea-product-card--light' : '';
	for ( $lumea_i = 0; $lumea_i < $lumea_count; $lumea_i++ ) :
		$lumea_p = $lumea_placeholders[ $lumea_i % count( $lumea_placeholders ) ];
		?>
		<article class="lumea-product-card<?php echo esc_attr( $lumea_light_mod ); ?> lumea-reveal lumea-reveal--delay-<?php echo esc_attr( $lumea_i + 1 ); ?>">
			<div class="lumea-product-img-wrap">
				<div style="width:100%;height:100%;background:var(--lumea-dark-3);display:flex;align-items:center;justify-content:center;">
					<svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="rgba(250,248,245,0.12)" stroke-width="1" aria-hidden="true"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2z"/><path d="M12 6v6l4 2"/></svg>
				</div>
			</div>
			<div class="lumea-product-category"><?php echo esc_html( $lumea_p['cat'] ); ?></div>
			<h3 class="lumea-product-name"><?php echo esc_html( $lumea_p['name'] ); ?></h3>
			<div class="lumea-product-price"><?php echo esc_html( $lumea_p['price'] ); ?></div>
		</article>
	<?php endfor;
}

/**
 * Placeholder bestseller items for when WooCommerce has no products.
 */
function lumea_fp_placeholder_bestsellers() {
	$lumea_items = array(
		array(
			'name'    => __( 'Brightening Vitamin C Serum', 'lumea' ),
			'tagline' => __( 'A potent 20% L-ascorbic acid formula stabilised with ferulic acid and vitamin E. Visibly brightens and protects against environmental damage within weeks.', 'lumea' ),
			'price'   => '$68',
		),
		array(
			'name'    => __( 'Retinol Renewal Night Cream', 'lumea' ),
			'tagline' => __( 'Microencapsulated retinol delivers overnight transformation without the irritation. Wake up to smoother, firmer, more luminous skin every morning.', 'lumea' ),
			'price'   => '$76',
		),
	);
	foreach ( $lumea_items as $lumea_i => $lumea_item ) :
		?>
		<article class="lumea-bestseller-item">
			<div class="lumea-bestseller-visual" style="background:var(--lumea-dark-2);">
				<div style="position:absolute;inset:0;display:flex;align-items:center;justify-content:center;">
					<svg width="80" height="80" viewBox="0 0 24 24" fill="none" stroke="rgba(250,248,245,0.08)" stroke-width="0.8" aria-hidden="true"><circle cx="12" cy="12" r="10"/><circle cx="12" cy="12" r="5"/></svg>
				</div>
			</div>
			<div class="lumea-bestseller-content">
				<div class="lumea-bestseller-num lumea-reveal">
					<?php echo esc_html( sprintf( '%02d', $lumea_i + 1 ) ); ?> —
					<?php esc_html_e( 'Best Seller', 'lumea' ); ?>
				</div>
				<h3 class="lumea-bestseller-name lumea-reveal lumea-reveal--delay-1">
					<?php echo esc_html( $lumea_item['name'] ); ?>
				</h3>
				<p class="lumea-bestseller-tagline lumea-reveal lumea-reveal--delay-2">
					<?php echo esc_html( $lumea_item['tagline'] ); ?>
				</p>
				<div class="lumea-bestseller-meta lumea-reveal lumea-reveal--delay-3">
					<div class="lumea-bestseller-price"><?php echo esc_html( $lumea_item['price'] ); ?></div>
					<div class="lumea-star-rating" aria-label="<?php esc_attr_e( '5 stars', 'lumea' ); ?>">
						<?php for ( $s = 0; $s < 5; $s++ ) : ?>
							<svg width="13" height="13" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
						<?php endfor; ?>
					</div>
				</div>
				<div class="lumea-reveal lumea-reveal--delay-4">
					<a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>"
					   class="lumea-btn lumea-btn--primary-dark">
						<?php esc_html_e( 'Shop Now', 'lumea' ); ?>
					</a>
				</div>
			</div>
		</article>
	<?php endforeach;
}
