php_file = r'c:\Users\shivd\Local Sites\lumea\app\public\wp-content\themes\lumea\front-page.php'
content = open(php_file, 'r', encoding='utf-8').read()

# 1. Add cart icon to topbar
old_topbar = '''			<div class="brand-pill">
				<span>LUMÉA</span>
				<span class="menu-icon" aria-hidden="true">
					<span></span>
					<span></span>
				</span>
			</div>
		</div>'''

new_topbar = '''			<div class="brand-pill">
				<span>LUMÉA</span>
				<span class="menu-icon" aria-hidden="true">
					<span></span>
					<span></span>
				</span>
			</div>
			<?php if ( class_exists( 'WooCommerce' ) ) : ?>
			<button class="lumea-cart-trigger" aria-label="<?php esc_attr_e( 'Open cart', 'lumea' ); ?>" data-lumea-cart-trigger>
				<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 01-8 0"/></svg>
				<span class="lumea-cart-count<?php echo WC()->cart->get_cart_contents_count() ? ' lumea-cart-count--visible' : ''; ?>"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
			</button>
			<?php endif; ?>
		</div>'''

content = content.replace(old_topbar, new_topbar)

# 2. Replace bestsellers static array with WooCommerce query
old_best_start = "/* ── Bestsellers ──────────────────────────────────────── */"
new_best = """/* ── Bestsellers ──────────────────────────────────────── */
<?php
$lumea_best_products = array();
if ( class_exists( 'WooCommerce' ) ) {
	$lumea_best_query = new WP_Query( array(
		'post_type'      => 'product',
		'posts_per_page' => 5,
		'tax_query'      => array(
			array(
				'taxonomy' => 'product_tag',
				'field'    => 'slug',
				'terms'    => 'bestseller',
			),
		),
		'post_status'    => 'publish',
	) );
	if ( ! $lumea_best_query->have_posts() ) {
		$lumea_best_query = new WP_Query( array(
			'post_type'      => 'product',
			'posts_per_page' => 5,
			'meta_key'       => 'total_sales',
			'orderby'        => 'meta_value_num',
			'order'          => 'DESC',
			'post_status'    => 'publish',
		) );
	}
	while ( $lumea_best_query->have_posts() ) {
		$lumea_best_query->the_post();
		$_product      = wc_get_product( get_the_ID() );
		$_imgs         = $_product->get_gallery_image_ids();
		$lumea_best_products[] = array(
			'id'          => get_the_ID(),
			'name'        => get_the_title(),
			'price'       => $_product->get_price_html(),
			'badge'       => $_product->is_on_sale() ? esc_html__( 'Sale', 'lumea' ) : get_the_terms( get_the_ID(), 'product_cat' )[0]->name ?? '',
			'is_sale'     => $_product->is_on_sale(),
			'main_image'  => get_the_post_thumbnail_url( get_the_ID(), 'woocommerce_single' ),
			'hover_image' => ! empty( $_imgs ) ? wp_get_attachment_image_url( $_imgs[0], 'woocommerce_single' ) : '',
			'url'         => get_permalink(),
			'type'        => $_product->get_type(),
		);
	}
	wp_reset_postdata();
}
?>"""

content = content.replace(old_best_start, new_best)

# 3. Replace bestsellers product loop
old_best_loop = """	<?php foreach ( $lumea_best_products as $product ) :
				$badge       = get_theme_mod( 'lumea_best' . $product['n'] . '_badge', $product['badge'] );
				$product_url = esc_url( get_theme_mod( 'lumea_best' . $product['n'] . '_url', $product['url'] ) );"""

# Let me check exact text
print("Checking for bestsellers loop pattern...")
import re
m = re.search(r'foreach \( \$lumea_best_products.*?endforeach', content, re.DOTALL)
if m:
    print("Found loop at:", m.start(), "-", m.end())
    print(content[m.start():m.start()+300])

open(php_file, 'w', encoding='utf-8').write(content)
print('Step 1 done - cart icon and WC query added')
