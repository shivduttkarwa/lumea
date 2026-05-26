php_file = r'c:\Users\shivd\Local Sites\lumea\app\public\wp-content\themes\lumea\front-page.php'
content = open(php_file, 'r', encoding='utf-8').read()

# ── Replace bestsellers slider loop ──────────────────────────────────────────
old_best_loop = """\t\t\t\t<div class="swiper-wrapper">
\t\t\t\t\t<?php foreach ( $lumea_best_defaults as $n => $d ) :
\t\t\t\t\t\t$name        = esc_html( get_theme_mod( 'lumea_best' . $n . '_name',        $d['name'] ) );
\t\t\t\t\t\t$price       = esc_html( get_theme_mod( 'lumea_best' . $n . '_price',       $d['price'] ) );
\t\t\t\t\t\t$badge       = esc_html( get_theme_mod( 'lumea_best' . $n . '_badge',       $d['badge'] ) );
\t\t\t\t\t\t$main_img    = esc_url(  get_theme_mod( 'lumea_best' . $n . '_main_image',  $d['main_image'] ) );
\t\t\t\t\t\t$hover_img   = esc_url(  get_theme_mod( 'lumea_best' . $n . '_hover_image', $d['hover_image'] ) );
\t\t\t\t\t\t$product_url = lumea_product_url( 'lumea_best' . $n . '_url' );
\t\t\t\t\t?>
\t\t\t\t\t<div class="swiper-slide">
\t\t\t\t\t\t<article class="lumea-best-card">
\t\t\t\t\t\t\t<a href="<?php echo $product_url; ?>" class="lumea-best-media-link">
\t\t\t\t\t\t\t\t<?php if ( $badge ) : ?>
\t\t\t\t\t\t\t\t<span class="lumea-best-badge" aria-hidden="true"><?php echo $badge; ?></span>
\t\t\t\t\t\t\t\t<?php endif; ?>
\t\t\t\t\t\t\t\t<div class="lumea-best-media">
\t\t\t\t\t\t\t\t\t<img class="lumea-best-img lumea-best-img--main" src="<?php echo $main_img; ?>" alt="<?php echo $name; ?>" loading="lazy" />
\t\t\t\t\t\t\t\t\t<img class="lumea-best-img lumea-best-img--hover" src="<?php echo $hover_img; ?>" alt="" loading="lazy" aria-hidden="true" />
\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t</a>
\t\t\t\t\t\t\t<div class="lumea-best-info">
\t\t\t\t\t\t\t\t<h3 class="lumea-best-name"><a href="<?php echo $product_url; ?>"><?php echo $name; ?></a></h3>
\t\t\t\t\t\t\t\t<p class="lumea-best-price"><?php echo $price; ?></p>
\t\t\t\t\t\t\t\t<a href="<?php echo $product_url; ?>" class="lumea-best-btn"><?php esc_html_e( 'Shop Now', 'lumea' ); ?></a>
\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t</article>
\t\t\t\t\t</div>
\t\t\t\t\t<?php endforeach; ?>
\t\t\t\t</div>"""

new_best_loop = """\t\t\t\t<div class="swiper-wrapper">
\t\t\t\t\t<?php
\t\t\t\t\t$lumea_best_source = class_exists( 'WooCommerce' ) ? $lumea_best_products : array();
\t\t\t\t\tif ( empty( $lumea_best_source ) ) :
\t\t\t\t\t\tforeach ( $lumea_best_defaults as $n => $d ) :
\t\t\t\t\t\t\t$lumea_best_source[] = array(
\t\t\t\t\t\t\t\t'id'          => 0,
\t\t\t\t\t\t\t\t'name'        => esc_html( get_theme_mod( 'lumea_best' . $n . '_name',        $d['name'] ) ),
\t\t\t\t\t\t\t\t'price'       => esc_html( get_theme_mod( 'lumea_best' . $n . '_price',       $d['price'] ) ),
\t\t\t\t\t\t\t\t'badge'       => esc_html( get_theme_mod( 'lumea_best' . $n . '_badge',       $d['badge'] ) ),
\t\t\t\t\t\t\t\t'is_sale'     => false,
\t\t\t\t\t\t\t\t'main_image'  => esc_url( get_theme_mod( 'lumea_best' . $n . '_main_image',  $d['main_image'] ) ),
\t\t\t\t\t\t\t\t'hover_image' => esc_url( get_theme_mod( 'lumea_best' . $n . '_hover_image', $d['hover_image'] ) ),
\t\t\t\t\t\t\t\t'url'         => lumea_product_url( 'lumea_best' . $n . '_url' ),
\t\t\t\t\t\t\t\t'type'        => 'simple',
\t\t\t\t\t\t\t);
\t\t\t\t\t\tendforeach;
\t\t\t\t\tendif;
\t\t\t\t\t?>
\t\t\t\t\t<?php foreach ( $lumea_best_source as $bp ) :
\t\t\t\t\t\t$bp_id    = (int) $bp['id'];
\t\t\t\t\t\t$bp_name  = esc_html( $bp['name'] );
\t\t\t\t\t\t$bp_url   = esc_url( $bp['url'] );
\t\t\t\t\t\t$bp_badge = $bp['badge'];
\t\t\t\t\t\t$bp_main  = esc_url( $bp['main_image'] );
\t\t\t\t\t\t$bp_hover = esc_url( isset( $bp['hover_image'] ) ? $bp['hover_image'] : '' );
\t\t\t\t\t?>
\t\t\t\t\t<div class="swiper-slide">
\t\t\t\t\t\t<article class="lumea-best-card">
\t\t\t\t\t\t\t<a href="<?php echo $bp_url; ?>" class="lumea-best-media-link">
\t\t\t\t\t\t\t\t<?php if ( $bp_badge ) : ?>
\t\t\t\t\t\t\t\t<span class="lumea-best-badge<?php echo ! empty( $bp['is_sale'] ) ? ' lumea-best-badge--sale' : ''; ?>" aria-hidden="true"><?php echo esc_html( $bp_badge ); ?></span>
\t\t\t\t\t\t\t\t<?php endif; ?>
\t\t\t\t\t\t\t\t<div class="lumea-best-media">
\t\t\t\t\t\t\t\t\t<img class="lumea-best-img lumea-best-img--main" src="<?php echo $bp_main; ?>" alt="<?php echo $bp_name; ?>" loading="lazy" />
\t\t\t\t\t\t\t\t\t<?php if ( $bp_hover ) : ?>
\t\t\t\t\t\t\t\t\t<img class="lumea-best-img lumea-best-img--hover" src="<?php echo $bp_hover; ?>" alt="" loading="lazy" aria-hidden="true" />
\t\t\t\t\t\t\t\t\t<?php endif; ?>
\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t</a>
\t\t\t\t\t\t\t<div class="lumea-best-info">
\t\t\t\t\t\t\t\t<h3 class="lumea-best-name"><a href="<?php echo $bp_url; ?>"><?php echo $bp_name; ?></a></h3>
\t\t\t\t\t\t\t\t<p class="lumea-best-price"><?php echo isset( $bp['price'] ) ? wp_kses_post( $bp['price'] ) : ''; ?></p>
\t\t\t\t\t\t\t\t<?php if ( $bp_id && class_exists( 'WooCommerce' ) ) : ?>
\t\t\t\t\t\t\t\t<a href="<?php echo esc_url( add_query_arg( 'add-to-cart', $bp_id, $bp_url ) ); ?>"
\t\t\t\t\t\t\t\t   class="lumea-best-btn add_to_cart_button ajax_add_to_cart"
\t\t\t\t\t\t\t\t   data-product_id="<?php echo $bp_id; ?>"
\t\t\t\t\t\t\t\t   data-product_type="<?php echo esc_attr( $bp['type'] ); ?>"
\t\t\t\t\t\t\t\t   data-quantity="1"
\t\t\t\t\t\t\t\t   aria-label="<?php echo esc_attr( sprintf( __( 'Add %s to cart', 'lumea' ), $bp_name ) ); ?>"
\t\t\t\t\t\t\t\t   rel="nofollow"><?php esc_html_e( 'Add to Cart', 'lumea' ); ?></a>
\t\t\t\t\t\t\t\t<?php else : ?>
\t\t\t\t\t\t\t\t<a href="<?php echo $bp_url; ?>" class="lumea-best-btn"><?php esc_html_e( 'Shop Now', 'lumea' ); ?></a>
\t\t\t\t\t\t\t\t<?php endif; ?>
\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t</article>
\t\t\t\t\t</div>
\t\t\t\t\t<?php endforeach; ?>
\t\t\t\t</div>"""

if old_best_loop in content:
    content = content.replace(old_best_loop, new_best_loop)
    print("Bestsellers loop replaced OK")
else:
    print("ERROR: bestsellers loop not found")

# ── Replace latest products loop ──────────────────────────────────────────────
old_latest_loop = """\t\t<div class="lumea-latest-grid">
\t\t\t<?php foreach ( $lumea_latest as $p ) :
\t\t\t\t$lp_badge     = $p['badge'];
\t\t\t\t$lp_old_price = $p['old_price'];
\t\t\t\t$lp_is_sale   = ! empty( $lp_old_price );
\t\t\t?>
\t\t\t<article class="lumea-lp-card">
\t\t\t\t<a href="<?php echo esc_url( $p['url'] ); ?>" class="lumea-lp-media">
\t\t\t\t\t<?php if ( $lp_badge ) : ?>
\t\t\t\t\t<span class="lumea-lp-badge<?php echo $lp_is_sale ? ' lumea-lp-badge--sale' : ''; ?>"><?php echo esc_html( $lp_badge ); ?></span>
\t\t\t\t\t<?php endif; ?>
\t\t\t\t\t<img src="<?php echo esc_url( $p['image'] ); ?>" alt="<?php echo esc_attr( $p['name'] ); ?>" class="lumea-lp-img lumea-lp-img--main" loading="lazy" />
\t\t\t\t\t<img src="<?php echo esc_url( $p['hover'] ); ?>" alt="" class="lumea-lp-img lumea-lp-img--hover" loading="lazy" aria-hidden="true" />
\t\t\t\t</a>
\t\t\t\t<div class="lumea-lp-body">
\t\t\t\t\t<h3 class="lumea-lp-name"><a href="<?php echo esc_url( $p['url'] ); ?>"><?php echo esc_html( $p['name'] ); ?></a></h3>
\t\t\t\t\t<div class="lumea-lp-pricing">
\t\t\t\t\t\t<?php if ( $lp_is_sale ) : ?>
\t\t\t\t\t\t<s class="lumea-lp-old"><?php echo esc_html( $lp_old_price ); ?></s>
\t\t\t\t\t\t<?php endif; ?>
\t\t\t\t\t\t<span class="lumea-lp-price<?php echo $lp_is_sale ? ' lumea-lp-price--sale' : ''; ?>"><?php echo esc_html( $p['price'] ); ?></span>
\t\t\t\t\t</div>
\t\t\t\t\t<a href="<?php echo esc_url( $p['url'] ); ?>" class="lumea-lp-btn">Shop Now</a>
\t\t\t\t</div>
\t\t\t</article>
\t\t\t<?php endforeach; ?>
\t\t</div>"""

new_latest_loop = """\t\t<?php
\t\t$lumea_lp_source = array();
\t\tif ( class_exists( 'WooCommerce' ) ) {
\t\t\t$lumea_lp_query = new WP_Query( array(
\t\t\t\t'post_type'      => 'product',
\t\t\t\t'posts_per_page' => 8,
\t\t\t\t'orderby'        => 'date',
\t\t\t\t'order'          => 'DESC',
\t\t\t\t'post_status'    => 'publish',
\t\t\t) );
\t\t\twhile ( $lumea_lp_query->have_posts() ) {
\t\t\t\t$lumea_lp_query->the_post();
\t\t\t\t$_lp           = wc_get_product( get_the_ID() );
\t\t\t\t$_lp_gallery   = $_lp->get_gallery_image_ids();
\t\t\t\t$lumea_lp_source[] = array(
\t\t\t\t\t'id'        => get_the_ID(),
\t\t\t\t\t'name'      => get_the_title(),
\t\t\t\t\t'price'     => $_lp->get_price_html(),
\t\t\t\t\t'old_price' => $_lp->is_on_sale() ? wc_price( $_lp->get_regular_price() ) : '',
\t\t\t\t\t'is_sale'   => $_lp->is_on_sale(),
\t\t\t\t\t'badge'     => $_lp->is_on_sale() ? esc_html__( 'Sale', 'lumea' ) : esc_html__( 'New', 'lumea' ),
\t\t\t\t\t'image'     => get_the_post_thumbnail_url( get_the_ID(), 'woocommerce_single' ),
\t\t\t\t\t'hover'     => ! empty( $_lp_gallery ) ? wp_get_attachment_image_url( $_lp_gallery[0], 'woocommerce_single' ) : '',
\t\t\t\t\t'url'       => get_permalink(),
\t\t\t\t\t'type'      => $_lp->get_type(),
\t\t\t\t);
\t\t\t}
\t\t\twp_reset_postdata();
\t\t}
\t\tif ( empty( $lumea_lp_source ) ) {
\t\t\tforeach ( $lumea_latest as $p ) {
\t\t\t\t$lumea_lp_source[] = array(
\t\t\t\t\t'id'        => 0,
\t\t\t\t\t'name'      => $p['name'],
\t\t\t\t\t'price'     => $p['price'],
\t\t\t\t\t'old_price' => $p['old_price'],
\t\t\t\t\t'is_sale'   => ! empty( $p['old_price'] ),
\t\t\t\t\t'badge'     => $p['badge'],
\t\t\t\t\t'image'     => $p['image'],
\t\t\t\t\t'hover'     => $p['hover'],
\t\t\t\t\t'url'       => $p['url'],
\t\t\t\t\t'type'      => 'simple',
\t\t\t\t);
\t\t\t}
\t\t}
\t\t?>
\t\t<div class="lumea-latest-grid">
\t\t\t<?php foreach ( $lumea_lp_source as $lp ) :
\t\t\t\t$lp_id       = (int) $lp['id'];
\t\t\t\t$lp_name     = esc_html( $lp['name'] );
\t\t\t\t$lp_url      = esc_url( $lp['url'] );
\t\t\t\t$lp_badge    = $lp['badge'];
\t\t\t\t$lp_is_sale  = ! empty( $lp['is_sale'] );
\t\t\t\t$lp_old      = $lp['old_price'];
\t\t\t\t$lp_img      = esc_url( $lp['image'] );
\t\t\t\t$lp_hover    = esc_url( $lp['hover'] );
\t\t\t?>
\t\t\t<article class="lumea-lp-card">
\t\t\t\t<a href="<?php echo $lp_url; ?>" class="lumea-lp-media">
\t\t\t\t\t<?php if ( $lp_badge ) : ?>
\t\t\t\t\t<span class="lumea-lp-badge<?php echo $lp_is_sale ? ' lumea-lp-badge--sale' : ''; ?>"><?php echo esc_html( $lp_badge ); ?></span>
\t\t\t\t\t<?php endif; ?>
\t\t\t\t\t<img src="<?php echo $lp_img; ?>" alt="<?php echo $lp_name; ?>" class="lumea-lp-img lumea-lp-img--main" loading="lazy" />
\t\t\t\t\t<?php if ( $lp_hover ) : ?>
\t\t\t\t\t<img src="<?php echo $lp_hover; ?>" alt="" class="lumea-lp-img lumea-lp-img--hover" loading="lazy" aria-hidden="true" />
\t\t\t\t\t<?php endif; ?>
\t\t\t\t</a>
\t\t\t\t<div class="lumea-lp-body">
\t\t\t\t\t<h3 class="lumea-lp-name"><a href="<?php echo $lp_url; ?>"><?php echo $lp_name; ?></a></h3>
\t\t\t\t\t<div class="lumea-lp-pricing">
\t\t\t\t\t\t<?php if ( $lp_is_sale && $lp_old ) : ?>
\t\t\t\t\t\t<s class="lumea-lp-old"><?php echo wp_kses_post( $lp_old ); ?></s>
\t\t\t\t\t\t<?php endif; ?>
\t\t\t\t\t\t<span class="lumea-lp-price<?php echo $lp_is_sale ? ' lumea-lp-price--sale' : ''; ?>"><?php echo wp_kses_post( $lp['price'] ); ?></span>
\t\t\t\t\t</div>
\t\t\t\t\t<?php if ( $lp_id && class_exists( 'WooCommerce' ) ) : ?>
\t\t\t\t\t<a href="<?php echo esc_url( add_query_arg( 'add-to-cart', $lp_id, $lp_url ) ); ?>"
\t\t\t\t\t   class="lumea-lp-btn add_to_cart_button ajax_add_to_cart"
\t\t\t\t\t   data-product_id="<?php echo $lp_id; ?>"
\t\t\t\t\t   data-product_type="<?php echo esc_attr( $lp['type'] ); ?>"
\t\t\t\t\t   data-quantity="1"
\t\t\t\t\t   aria-label="<?php echo esc_attr( sprintf( __( 'Add %s to cart', 'lumea' ), $lp_name ) ); ?>"
\t\t\t\t\t   rel="nofollow"><?php esc_html_e( 'Add to Cart', 'lumea' ); ?></a>
\t\t\t\t\t<?php else : ?>
\t\t\t\t\t<a href="<?php echo $lp_url; ?>" class="lumea-lp-btn"><?php esc_html_e( 'Shop Now', 'lumea' ); ?></a>
\t\t\t\t\t<?php endif; ?>
\t\t\t\t</div>
\t\t\t</article>
\t\t\t<?php endforeach; ?>
\t\t</div>"""

if old_latest_loop in content:
    content = content.replace(old_latest_loop, new_latest_loop)
    print("Latest products loop replaced OK")
else:
    print("ERROR: latest loop not found")

# ── Add cart drawer before wp_footer ──────────────────────────────────────────
cart_drawer = """
<?php if ( class_exists( 'WooCommerce' ) ) : ?>
<!-- Cart Drawer -->
<div class="lumea-cart-overlay" data-lumea-cart-overlay aria-hidden="true"></div>
<aside class="lumea-cart-drawer" id="lumeaCartDrawer" aria-label="<?php esc_attr_e( 'Shopping cart', 'lumea' ); ?>" aria-hidden="true" data-lumea-cart-drawer>
\t<div class="lumea-drawer-head">
\t\t<h2 class="lumea-drawer-title"><?php esc_html_e( 'Your Cart', 'lumea' ); ?></h2>
\t\t<button class="lumea-drawer-close" aria-label="<?php esc_attr_e( 'Close cart', 'lumea' ); ?>" data-lumea-cart-close>
\t\t\t<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
\t\t</button>
\t</div>
\t<div class="lumea-drawer-body">
\t\t<?php lumea_mini_cart_items(); ?>
\t</div>
\t<?php if ( ! WC()->cart->is_empty() ) : ?>
\t<div class="lumea-drawer-footer">
\t\t<div class="lumea-drawer-subtotal">
\t\t\t<span><?php esc_html_e( 'Subtotal', 'lumea' ); ?></span>
\t\t\t<span><?php echo WC()->cart->get_cart_subtotal(); ?></span>
\t\t</div>
\t\t<a href="<?php echo esc_url( wc_get_cart_url() ); ?>" class="lumea-drawer-cart-btn"><?php esc_html_e( 'View Cart', 'lumea' ); ?></a>
\t\t<a href="<?php echo esc_url( wc_get_checkout_url() ); ?>" class="lumea-drawer-checkout-btn"><?php esc_html_e( 'Checkout', 'lumea' ); ?></a>
\t</div>
\t<?php endif; ?>
</aside>
<?php endif; ?>

"""

if '<?php wp_footer(); ?>' in content:
    content = content.replace('<?php wp_footer(); ?>', cart_drawer + '<?php wp_footer(); ?>')
    print("Cart drawer added OK")
else:
    print("ERROR: wp_footer not found")

open(php_file, 'w', encoding='utf-8').write(content)
print("All done!")
