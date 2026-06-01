Luméa WordPress Theme
======================
Theme Name:  Luméa
Theme URI:   https://themeforest.net/user/shivdutt/portfolio
Author:      Shivdutt Karwa
Author URI:  https://themeforest.net/user/shivdutt
Version:     1.1.1
License:     GNU General Public License v2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html


== DESCRIPTION ==

Luméa is a premium beauty and skincare WooCommerce WordPress theme built for
modern cosmetic, wellness, and personal care brands. It features a canvas-based
animated hero, an editorial product slider, scroll-reveal animations powered by
GSAP, a full WooCommerce storefront with custom product cards, slide-out cart,
wishlist functionality, and an extensive Customizer panel with 56+ settings
across 9 sections — giving shop owners full control without touching code.


== REQUIREMENTS ==

- WordPress 6.5 or higher
- PHP 8.0 or higher
- WooCommerce 8.0 or higher (required for e-commerce features)
- Modern browser (Chrome 90+, Firefox 88+, Safari 14+, Edge 90+)


== INSTALLATION ==

1. Log in to your WordPress admin dashboard.
2. Go to Appearance > Themes > Add New > Upload Theme.
3. Click "Choose File", select the lumea.zip file, and click "Install Now".
4. After installation, click "Activate".
5. Install and activate the WooCommerce plugin when prompted.
6. Go to Appearance > Customize to configure the theme.


== QUICK SETUP ==

After activating the theme, follow these steps to replicate the demo:

1. INSTALL WOOCOMMERCE
   Go to Plugins > Add New, search for "WooCommerce", install and activate it.
   Run the WooCommerce setup wizard to configure your store currency, payments,
   and shipping.

2. CREATE REQUIRED PAGES
   WooCommerce creates its own pages (Shop, Cart, Checkout, My Account).
   Additionally create the following pages and assign the correct template:

   - "About"    → Page Template: About Us
   - "Contact"  → Page Template: Contact
   - "FAQ"      → Page Template: FAQ
   - "Wishlist" → Page Template: Wishlist
   - "Blog"     → Set as Posts Page under Settings > Reading

3. SET THE FRONT PAGE
   Go to Settings > Reading and set:
   - "Your homepage displays" → A static page
   - "Homepage" → Front Page (or whichever page you set as home)
   - "Posts page" → Blog

4. SET UP NAVIGATION
   Go to Appearance > Menus, create a menu, add your pages, and assign it to
   the "Primary Menu" location.

5. CONFIGURE THE CUSTOMIZER
   Go to Appearance > Customize > Luméa Theme to set up:
   - Hero section images and labels (slide 1 image is required)
   - Editorial slider images and product links
   - Curated Glow product tiles
   - Bestsellers section category
   - Blog/Journal hero images
   - Footer headline, CTA, social links, video background
   - About page: hero, stats, manifesto, story sections
   - Shop hero images per category

6. ADD PRODUCTS
   Go to Products > Add New to create your first WooCommerce products.
   Set a product image, price, and category. The Bestsellers section can be
   filtered by assigning a "Bestseller" product category.

7. ADD BLOG POSTS
   Go to Posts > Add New to publish journal articles. Use a featured image for
   each post — it appears in the blog archive grid and related posts section.


== CUSTOMIZER REFERENCE ==

Panel: Luméa Theme
|
├── Hero Section
|   ├── Slide images 1–5 (slide 1 required; 2–5 optional)
|   ├── Per-slide labels (Glow, Hydrate, Nourish, Protect, Renew)
|   ├── Subtitle pills (up to 3)
|   └── CTA button text
|
├── Editorial Slider
|   ├── Eyebrow, title, description
|   ├── 6 slides: image, body text, URL
|   └── Shop All button text
|
├── Curated Glow
|   └── 3 product tiles: image, name, price, description, URL
|
├── Latest Products
|   ├── Section title and description
|   └── Product count and columns
|
├── Bestsellers
|   ├── Eyebrow, title, description
|   └── Category term slug
|
├── Blog / Journal
|   ├── Archive hero: image, title, subtitle
|   └── Single post hero: image, subtitle
|
├── About Page
|   ├── Hero: image, eyebrow, heading, subtitle
|   ├── Statistics: 4 stat blocks (value + label)
|   ├── Ticker text
|   ├── Manifesto quote
|   ├── Story sections A and B (image + text)
|   ├── Values: 4 principle cards
|   ├── Ingredient philosophy
|   └── Press quotes and testimonials
|
├── Footer
|   ├── Headline, CTA text, copyright
|   ├── Social links (Instagram, TikTok, Pinterest)
|   ├── Address and email
|   └── Footer video and poster image
|
└── Shop / Category
    ├── Main shop hero image
    └── Per-category hero: Bestsellers, Latest


== PAGE TEMPLATES ==

The following custom page templates are included:

- About Us   (page-about.php)   — Full about page with hero, stats, story,
                                   values, press quotes, and testimonials.
- Contact    (page-contact.php) — Contact form with nonce-protected submission
                                   and email delivery via wp_mail().
- FAQ        (page-faq.php)     — Accordion FAQ page organised by category.
- Wishlist   (page-wishlist.php)— Customer wishlist stored in browser localStorage
                                   with AJAX cart integration.


== WIDGET AREAS ==

- Sidebar        — General-purpose sidebar for blog posts and pages.
- Footer Column  — Widget area displayed in the footer column area.


== WOOCOMMERCE TEMPLATES OVERRIDDEN ==

The following WooCommerce core templates are customised for Luméa:

  woocommerce/archive-product.php
  woocommerce/content-product.php
  woocommerce/single-product.php
  woocommerce/cart/cart.php
  woocommerce/checkout/form-checkout.php
  woocommerce/checkout/thankyou.php
  woocommerce/loop/loop-start.php
  woocommerce/loop/loop-end.php
  woocommerce/myaccount/dashboard.php
  woocommerce/myaccount/form-login.php
  woocommerce/myaccount/form-lost-password.php
  woocommerce/myaccount/form-reset-password.php
  woocommerce/myaccount/lost-password-confirmation.php
  woocommerce/myaccount/my-account.php


== TRANSLATION ==

Luméa is translation-ready. All user-facing strings are wrapped in WordPress
translation functions using the text domain "lumea".

To translate:
1. Use Poedit or Loco Translate (plugin) to open languages/lumea.pot.
2. Create a translation file (e.g. lumea-fr_FR.po / lumea-fr_FR.mo).
3. Place the .mo file in wp-content/languages/themes/ or in the theme's
   languages/ folder.


== THIRD-PARTY LIBRARIES & CREDITS ==

The following third-party libraries are used in this theme. All are released
under free, open-source licenses compatible with the GPL.

1. GSAP (GreenSock Animation Platform) v3.12.5
   Source:  https://gsap.com
   License: GSAP Standard License — free for all use including commercial
   https://gsap.com/community/standard-license/

2. Bootstrap v5.3.3
   Source:  https://getbootstrap.com
   License: MIT License
   https://github.com/twbs/bootstrap/blob/main/LICENSE

3. Swiper v11
   Source:  https://swiperjs.com
   License: MIT License
   https://github.com/nolimits4web/swiper/blob/master/LICENSE

4. Clash Display (font)
   Source:  https://www.fontshare.com/fonts/clash-display
   License: Fontshare Free License — free for personal and commercial use
   https://www.fontshare.com/licenses/itf-ffl

5. Inter (font)
   Source:  https://fonts.google.com/specimen/Inter
   License: SIL Open Font License 1.1
   https://scripts.sil.org/OFL

All theme images used in the demo are for demonstration purposes only and are
NOT included in the final download. Replace them with your own licensed images
before launching your store.


== CHANGELOG ==

= 1.1.0 =
* Initial ThemeForest release.


== SUPPORT ==

For support, please use the comments section on the ThemeForest item page.
Documentation is available at: https://themeforest.net/user/shivdutt/portfolio
