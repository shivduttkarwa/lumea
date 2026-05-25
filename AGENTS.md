# AGENTS.md — Luméa Theme Development Rules

## Project Identity

Project Name: Luméa  
Theme Slug: lumea  
Text Domain: lumea  
Theme Type: Classic/Hybrid WordPress Theme  
Goal: Premium Beauty & Skincare WooCommerce WordPress Theme  
Marketplace Target: ThemeForest / Envato-quality commercial theme

Luméa must be built as a clean, scalable, maintainable, marketplace-ready WordPress + WooCommerce theme.

Do not build it like a random custom website. Build it like a reusable product.

---

## 1. Core Principles

Every AI agent or developer working on this theme must follow these principles:

- Keep the structure clean.
- Keep files small and focused.
- Do not put everything inside functions.php.
- Use WordPress coding standards.
- Use WooCommerce hooks before overriding templates.
- Keep the theme translation-ready.
- Keep the theme responsive.
- Keep the theme accessible.
- Keep CSS and JS lightweight.
- Avoid plugin-level functionality inside the theme.
- Build for long-term maintenance and marketplace quality.

---

## 2. Technology Stack

Use:

- WordPress
- WooCommerce
- PHP
- WordPress Template Hierarchy
- WooCommerce Hooks
- WooCommerce Template Overrides only when needed
- theme.json
- Gutenberg/Core Block Styling
- Block Patterns
- CSS
- Vanilla JavaScript

Do not use inside this theme:

- React
- Vue
- Next.js
- Laravel
- Strapi
- Contentful
- Heavy frontend frameworks

---

## 3. Theme Folder Structure

Follow this structure as the project grows:

- style.css
- functions.php
- header.php
- footer.php
- index.php
- front-page.php
- theme.json
- screenshot.png
- AGENTS.md

Folders:

- assets/css/
- assets/js/
- assets/images/
- assets/fonts/
- inc/
- template-parts/header/
- template-parts/footer/
- template-parts/components/
- template-parts/sections/
- template-parts/content/
- woocommerce/
- patterns/
- languages/
- docs/

Do not create random folders unless there is a clear reason.

---

## 4. File Responsibility Rules

### functions.php

functions.php must stay clean.

It should only contain:

- Security guard
- Theme constants
- Required include files

Do not add random theme logic inside functions.php.

### inc/setup.php

Use for:

- Theme supports
- Menus
- Image sizes
- WooCommerce support
- Translation setup
- Editor support

### inc/enqueue.php

Use for:

- Loading CSS
- Loading JavaScript
- Loading editor styles
- Loading WooCommerce CSS/JS if needed

### inc/helpers.php

Use for reusable helper functions.

### inc/template-functions.php

Use for reusable template output functions.

### inc/woocommerce.php

Use for WooCommerce hooks, filters, product card changes, cart link logic, and shop customizations.

### template-parts/

Use for reusable markup parts.

Examples:

- Header parts
- Footer parts
- Buttons
- Product cards
- Hero sections
- Featured product sections
- FAQ sections

### woocommerce/

Use only for WooCommerce template overrides.

Important: use WooCommerce hooks first. Override templates only when hooks are not enough.

---

## 5. Naming Rules

PHP functions must use the prefix:

lumea_

Good examples:

- lumea_theme_setup()
- lumea_enqueue_assets()
- lumea_register_menus()
- lumea_woocommerce_cart_link()

Bad examples:

- theme_setup()
- enqueue_assets()
- my_function()

CSS classes must use the prefix:

lumea-

Good examples:

- .lumea-site-header
- .lumea-product-card
- .lumea-section-hero
- .lumea-button
- .lumea-cart-drawer

Bad examples:

- .header
- .card
- .btn
- .section

---

## 6. Security Rules

Always escape output.

Use:

- esc_html()
- esc_attr()
- esc_url()
- wp_kses_post()
- esc_html__()
- esc_attr__()

Always sanitize input.

Use:

- sanitize_text_field()
- sanitize_email()
- sanitize_key()
- absint()
- intval()
- wp_unslash()

Never trust:

- $_POST
- $_GET
- $_REQUEST
- Customizer input
- Theme options
- Product meta
- User input

No raw output of user/admin data.

---

## 7. Translation Rules

Text domain must always be:

lumea

All visible text must be translatable.

Use:

- esc_html_e()
- esc_html__()
- esc_attr_e()
- esc_attr__()
- __()

Do not hardcode visible text without translation functions.

---

## 8. Accessibility Rules

The theme must be accessible.

Rules:

- Use semantic HTML.
- Use correct heading order.
- Use buttons for actions.
- Use links for navigation.
- Keep visible focus styles.
- Add aria-label where needed.
- Mobile menu must be keyboard accessible.
- Cart drawer must be keyboard accessible.
- Accordions must use button elements.
- Images must support alt text.
- Do not remove focus outlines unless replacing with a better visible style.

---

## 9. Performance Rules

The theme must stay lightweight.

Rules:

- Do not load unnecessary libraries.
- Do not use jQuery unless WordPress/WooCommerce requires it.
- Prefer vanilla JavaScript.
- Load scripts in the footer.
- Use conditional loading where possible.
- Avoid heavy animations on mobile.
- Optimize images.
- Avoid layout shift.
- Keep CSS and JS modular.
- Do not load product scripts on every page if they are only needed on product pages.

---

## 10. CSS Rules

Main CSS file:

assets/css/main.css

WooCommerce CSS file if needed:

assets/css/woocommerce.css

Editor CSS file if needed:

assets/css/editor.css

Rules:

- Use CSS variables for design tokens.
- Use the lumea- prefix.
- Avoid generic global classes.
- Avoid !important unless absolutely necessary.
- Avoid over-specific selectors.
- Keep responsive CSS clean.
- Do not break plugin or WooCommerce styles.

---

## 11. JavaScript Rules

Main JS file:

assets/js/main.js

Additional JS files may be used only when needed:

- assets/js/navigation.js
- assets/js/cart-drawer.js
- assets/js/product.js
- assets/js/accordion.js

Rules:

- Use vanilla JavaScript.
- Use progressive enhancement.
- Site should not fully break if JS fails.
- Keep functions small and readable.
- Do not add heavy libraries without approval.
- Do not add long inline scripts inside PHP templates.

---

## 12. theme.json Rules

Use theme.json for modern WordPress compatibility.

Use it for:

- Colors
- Typography
- Font sizes
- Spacing
- Layout widths
- Editor consistency
- Button styles where possible

CSS custom properties may also be used, but they should align with theme.json.

Do not scatter design tokens randomly across files.

---

## 13. Gutenberg / Block Editor Rules

The theme must support Gutenberg properly.

Style common core blocks:

- Paragraph
- Heading
- Button
- Image
- Gallery
- Quote
- List
- Columns
- Cover
- Group
- Media & Text
- Separator
- Spacer

Frontend and editor should feel visually consistent.

---

## 14. Block Pattern Rules

Use block patterns for reusable layouts.

Good pattern ideas:

- Beauty hero section
- Skincare product feature section
- Ingredient benefits section
- Routine steps section
- Testimonials section
- FAQ section
- About brand section
- Newsletter section

Patterns should go inside:

patterns/

or be registered from:

inc/block-patterns.php

Do not create complex plugin-level blocks inside the theme.

---

## 15. WooCommerce Rules

WooCommerce is central to Luméa.

The theme must support:

- Shop page
- Product archive
- Single product page
- Cart page
- Checkout page
- My account page
- Product categories
- Variable products
- Sale products
- Related products
- Upsells
- Cross-sells

Use WooCommerce hooks first.

Only use woocommerce/ template overrides when hooks are not enough.

WooCommerce custom logic should go inside:

inc/woocommerce.php

Product cards should be reusable and should preferably go inside:

template-parts/components/product-card.php

Do not break checkout, cart, or account pages.

---

## 16. Beauty / Skincare Feature Rules

Luméa should feel purpose-built for beauty and skincare brands.

Important sections:

- Hero section
- Featured products
- Bestseller products
- Skin concern cards
- Ingredient highlight section
- Routine builder section
- Before/after section
- Testimonials/reviews
- Product benefits
- Brand story
- FAQ accordion
- Newsletter signup
- Blog/article cards
- Shop category cards

Important product page elements:

- Product benefits
- Ingredients
- How to use
- Skin type suitability
- Routine step
- Reviews
- Related products
- Sticky add to cart later if needed

Do not make it look like a generic ecommerce theme.

---

## 17. Plugin Territory Rules

Do not put plugin-level functionality inside the theme.

Avoid adding these directly into the theme:

- Custom post types
- Complex shortcodes
- SEO tools
- Analytics tracking
- Security features
- Payment logic
- CRM integrations
- Email marketing systems
- Booking systems

The theme should handle design, layout, templates, and presentation.

If plugin functionality is needed, create or recommend a companion plugin.

---

## 18. Elementor Compatibility Rules

Elementor compatibility is optional.

Rules:

- Do not make the theme dependent on Elementor.
- Core theme must work without Elementor.
- Avoid CSS conflicts with Elementor.
- Provide full-width page template later if needed.
- Do not require Elementor Pro features.

Build the core theme first. Elementor compatibility can come later.

---

## 19. Demo Import Rules

Prepare the theme for demo import later.

Demo should include:

- Homepage
- Shop page
- Product page
- Product categories
- About page
- Contact page
- FAQ page
- Blog page
- Sample blog posts
- Sample WooCommerce products
- Navigation menus
- Footer menus
- Product images

Possible product categories:

- Cleansers
- Serums
- Moisturisers
- Sunscreens
- Toners
- Masks
- Body Care
- Hair Care
- Wellness

Do not use copyrighted images, logos, or brand names without permission.

---

## 20. Documentation Rules

Documentation should go inside:

docs/

Documentation should explain:

- Theme installation
- Required plugins
- WooCommerce setup
- Homepage setup
- Menu setup
- Logo setup
- Colors and typography
- Product image sizes
- Shop page setup
- Demo import
- Customization
- Troubleshooting
- Changelog
- Support policy

---

## 21. Header Rules

Header should be scalable.

Use:

- header.php
- template-parts/header/

Possible header parts:

- template-parts/header/site-branding.php
- template-parts/header/navigation.php
- template-parts/header/actions.php

Header should support:

- Logo
- Primary menu
- Mobile menu
- Search later if needed
- Account link
- Cart link
- WooCommerce cart count

Do not hardcode menu links.

---

## 22. Footer Rules

Footer should be scalable.

Use:

- footer.php
- template-parts/footer/

Footer should support:

- Logo or brand text
- Footer menu
- Newsletter area
- Social links
- Copyright
- Payment icons later if needed

Do not hardcode everything permanently.

---

## 23. Responsive Rules

The theme must work on:

- Large desktop
- Laptop
- Tablet
- Mobile
- Small mobile

Important areas:

- Header
- Mobile menu
- Product cards
- Product gallery
- Add to cart
- Cart page
- Checkout page
- Forms
- Footer

Mobile ecommerce experience is very important.

---

## 24. AI Agent Rules

AI agents must follow these rules:

1. Check the existing structure before creating files.
2. Do not create duplicate files.
3. Do not move core files without instruction.
4. Do not add dependencies without explaining why.
5. Do not put all logic inside functions.php.
6. Do not use generic class names.
7. Do not create plugin-territory functionality.
8. Use WooCommerce hooks before overrides.
9. Escape all output.
10. Sanitize all input.
11. Use the lumea text domain.
12. Use the lumea_ PHP prefix.
13. Use the lumea- CSS prefix.
14. Keep CSS and JS lightweight.
15. Do not add React, Vue, or Next.js.
16. Do not break WooCommerce pages.
17. Do not hardcode local URLs.
18. Do not add copyrighted assets.
19. Do not ignore accessibility.
20. Do not ignore mobile responsiveness.

Before making major changes, explain:

- Which file will be changed
- Why it belongs there
- Whether it affects WordPress, WooCommerce, CSS, JS, or templates

---

## 25. Development Workflow

Recommended order:

1. Base theme structure
2. WordPress theme supports
3. WooCommerce support
4. Global CSS tokens
5. theme.json
6. Header
7. Footer
8. Homepage
9. Reusable components
10. Product card
11. Shop/archive layout
12. Single product layout
13. Cart and checkout styling
14. Gutenberg styles
15. Block patterns
16. Demo content support
17. Documentation
18. Testing
19. Marketplace packaging

Do not jump into advanced animations before the core theme is stable.

---

## 26. Quality Checklist

Before marking any feature complete, check:

- Is the file in the correct place?
- Is the code readable?
- Is output escaped?
- Is input sanitized?
- Is text translatable?
- Is it responsive?
- Is it accessible?
- Does it avoid plugin territory?
- Does it avoid unnecessary dependencies?
- Does it work with WooCommerce?
- Does it use the lumea- CSS prefix?
- Does it use the lumea_ PHP prefix?
- Is it maintainable later?

---

## Final Principle

Luméa should be built like a premium product.

It must be:

- Beautiful
- Technically clean
- Easy to customize
- Easy to document
- Easy to update
- Safe for buyers
- Compatible with WordPress
- Compatible with WooCommerce
- Ready for marketplace expectations