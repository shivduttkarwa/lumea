php_file = r'c:\Users\shivd\Local Sites\lumea\app\public\wp-content\themes\lumea\front-page.php'
content = open(php_file, 'r', encoding='utf-8').read()

# ── New sticky header (insert before <section class="hero") ──────────────────
new_header = '''<!-- Sticky Header -->
<header class="lumea-header" id="lumeaHeader" role="banner">
\t<div class="lumea-header-inner">

\t\t<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="lumea-header-logo">LUMÉA</a>

\t\t<nav class="lumea-header-nav" aria-label="<?php esc_attr_e( 'Primary navigation', 'lumea' ); ?>">
\t\t\t<?php
\t\t\twp_nav_menu( array(
\t\t\t\t'theme_location' => 'primary',
\t\t\t\t'container'      => false,
\t\t\t\t'menu_class'     => 'lumea-nav-list',
\t\t\t\t'fallback_cb'    => function() {
\t\t\t\t\techo '<ul class="lumea-nav-list">';
\t\t\t\t\t$links = array(
\t\t\t\t\t\tarray( esc_html__( 'Shop',        'lumea' ), wc_get_page_id( 'shop' ) ? get_permalink( wc_get_page_id( 'shop' ) ) : '#' ),
\t\t\t\t\t\tarray( esc_html__( 'Bestsellers', 'lumea' ), '#' ),
\t\t\t\t\t\tarray( esc_html__( 'Ritual',      'lumea' ), '#lumeaRitual' ),
\t\t\t\t\t\tarray( esc_html__( 'Journal',     'lumea' ), '#' ),
\t\t\t\t\t\tarray( esc_html__( 'About',       'lumea' ), '#' ),
\t\t\t\t\t);
\t\t\t\t\tforeach ( $links as $l ) {
\t\t\t\t\t\techo '<li><a href="' . esc_url( $l[1] ) . '">' . $l[0] . '</a></li>';
\t\t\t\t\t}
\t\t\t\t\techo '</ul>';
\t\t\t\t},
\t\t\t) );
\t\t\t?>
\t\t</nav>

\t\t<div class="lumea-header-actions">
\t\t\t<?php if ( class_exists( 'WooCommerce' ) ) : ?>
\t\t\t<button class="lumea-cart-trigger" aria-label="<?php esc_attr_e( 'Open cart', 'lumea' ); ?>" data-lumea-cart-trigger>
\t\t\t\t<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 01-8 0"/></svg>
\t\t\t\t<span class="lumea-cart-count<?php echo WC()->cart->get_cart_contents_count() ? ' lumea-cart-count--visible' : ''; ?>"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
\t\t\t</button>
\t\t\t<?php endif; ?>
\t\t\t<button class="lumea-nav-toggle" aria-label="<?php esc_attr_e( 'Open menu', 'lumea' ); ?>" aria-expanded="false" aria-controls="lumeaMobileNav" data-lumea-nav-toggle>
\t\t\t\t<span class="lumea-nav-toggle-bar"></span>
\t\t\t\t<span class="lumea-nav-toggle-bar"></span>
\t\t\t</button>
\t\t</div>

\t</div>
</header>

<!-- Mobile Nav -->
<div class="lumea-mobile-nav" id="lumeaMobileNav" aria-hidden="true" data-lumea-mobile-nav>
\t<div class="lumea-mobile-nav-inner">
\t\t<nav aria-label="<?php esc_attr_e( 'Mobile navigation', 'lumea' ); ?>">
\t\t\t<?php
\t\t\twp_nav_menu( array(
\t\t\t\t'theme_location' => 'primary',
\t\t\t\t'container'      => false,
\t\t\t\t'menu_class'     => 'lumea-mobile-nav-list',
\t\t\t\t'fallback_cb'    => function() {
\t\t\t\t\techo '<ul class="lumea-mobile-nav-list">';
\t\t\t\t\t$links = array(
\t\t\t\t\t\tarray( esc_html__( 'Shop',        'lumea' ), wc_get_page_id( 'shop' ) ? get_permalink( wc_get_page_id( 'shop' ) ) : '#' ),
\t\t\t\t\t\tarray( esc_html__( 'Bestsellers', 'lumea' ), '#' ),
\t\t\t\t\t\tarray( esc_html__( 'Ritual',      'lumea' ), '#lumeaRitual' ),
\t\t\t\t\t\tarray( esc_html__( 'Journal',     'lumea' ), '#' ),
\t\t\t\t\t\tarray( esc_html__( 'About',       'lumea' ), '#' ),
\t\t\t\t\t);
\t\t\t\t\tforeach ( $links as $l ) {
\t\t\t\t\t\techo '<li><a href="' . esc_url( $l[1] ) . '">' . $l[0] . '</a></li>';
\t\t\t\t\t}
\t\t\t\t\techo '</ul>';
\t\t\t\t},
\t\t\t) );
\t\t\t?>
\t\t</nav>
\t</div>
</div>

'''

# ── Remove old topbar from hero ──────────────────────────────────────────────
old_topbar = '''\t<div class="hero-content">
\t\t<div class="topbar">
\t\t\t<div class="brand-pill">
\t\t\t\t<span>LUMÉA</span>
\t\t\t\t<span class="menu-icon" aria-hidden="true">
\t\t\t\t\t<span></span>
\t\t\t\t\t<span></span>
\t\t\t\t</span>
\t\t\t</div>
\t\t\t<?php if ( class_exists( 'WooCommerce' ) ) : ?>
\t\t\t<button class="lumea-cart-trigger" aria-label="<?php esc_attr_e( 'Open cart', 'lumea' ); ?>" data-lumea-cart-trigger>
\t\t\t\t<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 01-8 0"/></svg>
\t\t\t\t<span class="lumea-cart-count<?php echo WC()->cart->get_cart_contents_count() ? ' lumea-cart-count--visible' : ''; ?>"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
\t\t\t</button>
\t\t\t<?php endif; ?>
\t\t</div>'''

new_topbar_empty = '\t<div class="hero-content">'

if old_topbar in content:
    content = content.replace(old_topbar, new_topbar_empty)
    print("Old topbar removed OK")
else:
    print("ERROR: old topbar not found — check indentation")

# Insert new header before <section class="hero"
if '<section class="hero"' in content:
    content = content.replace('<section class="hero"', new_header + '<section class="hero"')
    print("New header inserted OK")
else:
    print("ERROR: hero section not found")

open(php_file, 'w', encoding='utf-8').write(content)
print("Done")
