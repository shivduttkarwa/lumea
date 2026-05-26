import os

css_path = r"c:\Users\shivd\Local Sites\lumea\app\public\wp-content\themes\lumea\assets\css\main.css"

pdp_css = """

/* ════════════════════════════════════════════════════════
   PRODUCT DETAIL PAGE (PDP)
   ════════════════════════════════════════════════════════ */

.lumea-pdp {
  background: var(--lumea-bg);
}

/* ── Breadcrumb ─────────────────────────────────────────── */
.lumea-pdp-breadcrumb {
  background: #ffffff;
  border-bottom: 1px solid var(--lumea-border);
}

.lumea-pdp-breadcrumb-inner {
  width: min(100% - 48px, var(--lumea-container));
  margin-inline: auto;
  padding: 14px 0;
  display: flex;
  align-items: center;
  gap: 10px;
  flex-wrap: wrap;
  font-family: Inter, sans-serif;
  font-size: 12px;
  color: var(--lumea-muted);
}

.lumea-pdp-breadcrumb-inner a {
  color: var(--lumea-muted);
  text-decoration: none;
  transition: color 0.18s ease;
}

.lumea-pdp-breadcrumb-inner a:hover {
  color: var(--lumea-text);
}

.lumea-pdp-breadcrumb-inner span[aria-current] {
  color: var(--lumea-text);
  font-weight: 600;
}

.lumea-pdp-bc-sep {
  opacity: 0.35;
  font-size: 10px;
}

/* ── Hero: 2-col split ──────────────────────────────────── */
.lumea-pdp-hero {
  padding: 56px 0 80px;
  background: #ffffff;
}

.lumea-pdp-hero-inner {
  width: min(100% - 48px, var(--lumea-container));
  margin-inline: auto;
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 64px;
  align-items: start;
}

/* ── Gallery ────────────────────────────────────────────── */
.lumea-pdp-gallery {
  display: flex;
  gap: 16px;
  align-items: flex-start;
}

.lumea-pdp-thumbs {
  display: flex;
  flex-direction: column;
  gap: 10px;
  flex-shrink: 0;
}

.lumea-pdp-thumb {
  width: 72px;
  height: 88px;
  border: 2px solid transparent;
  border-radius: 12px;
  overflow: hidden;
  padding: 0;
  background: var(--lumea-bg);
  cursor: pointer;
  transition: border-color 0.18s ease, transform 0.18s ease;
  flex-shrink: 0;
}

.lumea-pdp-thumb:hover {
  border-color: var(--lumea-muted);
  transform: scale(1.03);
}

.lumea-pdp-thumb.is-active {
  border-color: var(--lumea-text);
}

.lumea-pdp-thumb img {
  width: 100%;
  height: 100%;
  object-fit: contain;
  display: block;
}

.lumea-pdp-main-img-wrap {
  position: relative;
  flex: 1;
  min-width: 0;
  border-radius: 24px;
  overflow: hidden;
  background: var(--lumea-bg);
  aspect-ratio: 3 / 4;
}

.lumea-pdp-main-img {
  width: 100%;
  height: 100%;
}

.lumea-pdp-img {
  width: 100%;
  height: 100%;
  object-fit: contain;
  display: block;
  transition: opacity 0.22s ease, transform 0.22s ease;
}

.lumea-pdp-img-placeholder {
  width: 100%;
  height: 100%;
  display: flex;
  align-items: center;
  justify-content: center;
}

.lumea-pdp-badge {
  position: absolute;
  top: 20px;
  left: 20px;
  z-index: 2;
  display: inline-block;
  padding: 4px 12px;
  border-radius: 100px;
  font-family: Inter, sans-serif;
  font-size: 10px;
  font-weight: 700;
  letter-spacing: 0.1em;
  text-transform: uppercase;
}

.lumea-pdp-badge--sale {
  background: var(--lumea-accent);
  color: #ffffff;
}

.lumea-pdp-badge--new {
  background: var(--lumea-text);
  color: #ffffff;
}

.lumea-pdp-zoom-hint {
  position: absolute;
  bottom: 18px;
  right: 18px;
  display: flex;
  align-items: center;
  gap: 6px;
  background: rgba(255, 250, 247, 0.85);
  backdrop-filter: blur(6px);
  -webkit-backdrop-filter: blur(6px);
  padding: 6px 12px;
  border-radius: 100px;
  font-family: Inter, sans-serif;
  font-size: 11px;
  color: var(--lumea-muted);
  pointer-events: none;
  opacity: 0;
  transition: opacity 0.2s ease;
}

.lumea-pdp-main-img-wrap:hover .lumea-pdp-zoom-hint {
  opacity: 1;
}

/* ── Product info panel ─────────────────────────────────── */
.lumea-pdp-info {
  display: flex;
  flex-direction: column;
  gap: 0;
}

.lumea-pdp-meta-row {
  display: flex;
  align-items: center;
  gap: 12px;
  margin-bottom: 14px;
}

.lumea-pdp-category {
  font-family: Inter, sans-serif;
  font-size: 11px;
  font-weight: 700;
  letter-spacing: 0.14em;
  text-transform: uppercase;
  color: var(--lumea-accent-dark);
}

.lumea-pdp-stock {
  font-family: Inter, sans-serif;
  font-size: 11px;
  font-weight: 600;
  padding: 3px 10px;
  border-radius: 100px;
}

.lumea-pdp-stock--in {
  background: rgba(34, 197, 94, 0.1);
  color: #15803d;
}

.lumea-pdp-stock--low {
  background: rgba(245, 158, 11, 0.12);
  color: #b45309;
}

.lumea-pdp-stock--out {
  background: rgba(239, 68, 68, 0.1);
  color: #b91c1c;
}

.lumea-pdp-title {
  margin: 0 0 16px;
  font-family: "ClashDisplay-Variable", "Clash Display", Inter, sans-serif;
  font-size: clamp(32px, 4vw, 52px);
  font-weight: 400;
  letter-spacing: -0.03em;
  line-height: 1.05;
  color: var(--lumea-text);
}

.lumea-pdp-rating {
  display: flex;
  align-items: center;
  gap: 10px;
  margin-bottom: 20px;
}

.lumea-pdp-stars {
  display: flex;
  align-items: center;
  gap: 2px;
}

.lumea-pdp-stars--lg {
  gap: 3px;
}

.lumea-pdp-star {
  display: inline-flex;
}

.lumea-pdp-rating-count {
  font-family: Inter, sans-serif;
  font-size: 13px;
  color: var(--lumea-muted);
  text-decoration: underline;
  text-underline-offset: 3px;
  transition: color 0.18s ease;
}

.lumea-pdp-rating-count:hover {
  color: var(--lumea-text);
}

.lumea-pdp-price {
  margin-bottom: 20px;
  font-family: "ClashDisplay-Variable", "Clash Display", Inter, sans-serif;
  font-size: 28px;
  font-weight: 500;
  letter-spacing: -0.02em;
  color: var(--lumea-text);
}

.lumea-pdp-price ins {
  text-decoration: none;
}

.lumea-pdp-price del {
  font-size: 18px;
  color: var(--lumea-muted);
  font-weight: 400;
  margin-right: 8px;
}

.lumea-pdp-short-desc {
  margin-bottom: 24px;
  font-family: Inter, sans-serif;
  font-size: 15px;
  line-height: 1.75;
  color: var(--lumea-muted);
}

.lumea-pdp-short-desc p {
  margin: 0 0 10px;
}

.lumea-pdp-short-desc p:last-child {
  margin-bottom: 0;
}

.lumea-pdp-divider {
  border: none;
  border-top: 1px solid var(--lumea-border);
  margin: 4px 0 28px;
}

/* ── Add to cart ────────────────────────────────────────── */
.lumea-pdp-atc-wrap {
  margin-bottom: 28px;
}

.lumea-pdp-atc-form {
  display: flex;
  flex-direction: column;
  gap: 16px;
}

.lumea-pdp-qty-wrap {
  display: flex;
  align-items: center;
  gap: 16px;
}

.lumea-pdp-qty-label {
  font-family: Inter, sans-serif;
  font-size: 12px;
  font-weight: 700;
  letter-spacing: 0.1em;
  text-transform: uppercase;
  color: var(--lumea-text);
  flex-shrink: 0;
}

.lumea-pdp-qty {
  display: inline-flex;
  align-items: center;
  border: 1px solid var(--lumea-border);
  border-radius: 100px;
  overflow: hidden;
  background: #ffffff;
}

.lumea-qty-btn {
  width: 42px;
  height: 42px;
  display: flex;
  align-items: center;
  justify-content: center;
  background: transparent;
  border: none;
  cursor: pointer;
  color: var(--lumea-text);
  transition: background 0.15s ease;
  flex-shrink: 0;
}

.lumea-qty-btn:hover {
  background: rgba(36, 24, 22, 0.05);
}

.lumea-qty-input {
  width: 52px;
  text-align: center;
  border: none;
  border-left: 1px solid var(--lumea-border);
  border-right: 1px solid var(--lumea-border);
  background: transparent;
  font-family: Inter, sans-serif;
  font-size: 15px;
  font-weight: 600;
  color: var(--lumea-text);
  outline: none;
  padding: 0;
  height: 42px;
  -moz-appearance: textfield;
}

.lumea-qty-input::-webkit-inner-spin-button,
.lumea-qty-input::-webkit-outer-spin-button {
  -webkit-appearance: none;
  margin: 0;
}

.lumea-pdp-btn-row {
  display: flex;
  gap: 10px;
}

.lumea-pdp-atc-btn {
  flex: 1;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 10px;
  padding: 16px 28px;
  background: var(--lumea-text);
  color: #ffffff;
  border: none;
  border-radius: 100px;
  font-family: Inter, sans-serif;
  font-size: 14px;
  font-weight: 700;
  letter-spacing: 0.04em;
  cursor: pointer;
  transition: background 0.2s ease, transform 0.15s ease;
}

.lumea-pdp-atc-btn:hover {
  background: var(--lumea-accent-dark);
  transform: translateY(-1px);
}

.lumea-pdp-atc-btn:active {
  transform: translateY(0);
}

.lumea-pdp-atc-btn.is-disabled {
  background: var(--lumea-muted);
  cursor: not-allowed;
  opacity: 0.6;
}

.lumea-pdp-wish-btn {
  width: 54px;
  height: 54px;
  flex-shrink: 0;
  display: flex;
  align-items: center;
  justify-content: center;
  border: 1px solid var(--lumea-border);
  border-radius: 100px;
  background: transparent;
  color: var(--lumea-text);
  cursor: pointer;
  transition: background 0.2s ease, border-color 0.2s ease, color 0.2s ease;
}

.lumea-pdp-wish-btn:hover {
  border-color: var(--lumea-accent);
  color: var(--lumea-accent);
  background: rgba(201, 133, 120, 0.06);
}

.lumea-pdp-wish-btn.is-active {
  background: var(--lumea-accent);
  border-color: var(--lumea-accent);
  color: #ffffff;
}

/* ── Trust badges ───────────────────────────────────────── */
.lumea-pdp-trust {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 16px;
  padding: 24px 0;
  border-top: 1px solid var(--lumea-border);
  border-bottom: 1px solid var(--lumea-border);
  margin-bottom: 20px;
}

.lumea-pdp-trust-item {
  display: flex;
  align-items: flex-start;
  gap: 10px;
  color: var(--lumea-muted);
}

.lumea-pdp-trust-item svg {
  flex-shrink: 0;
  margin-top: 2px;
  color: var(--lumea-accent-dark);
}

.lumea-pdp-trust-item p {
  margin: 0 0 2px;
  font-family: Inter, sans-serif;
  font-size: 12px;
  font-weight: 700;
  color: var(--lumea-text);
  letter-spacing: 0.01em;
}

.lumea-pdp-trust-item span {
  font-family: Inter, sans-serif;
  font-size: 11px;
  color: var(--lumea-muted);
  line-height: 1.4;
}

.lumea-pdp-sku {
  margin: 0;
  font-family: Inter, sans-serif;
  font-size: 12px;
  color: var(--lumea-muted);
}

.lumea-pdp-sku span {
  color: var(--lumea-text);
}

/* ── Accordion ──────────────────────────────────────────── */
.lumea-pdp-details {
  background: var(--lumea-bg);
  padding: 0 0 80px;
}

.lumea-pdp-details-inner {
  width: min(100% - 48px, 800px);
  margin-inline: auto;
}

.lumea-pdp-accordion {
  border-bottom: 1px solid var(--lumea-border);
}

.lumea-pdp-accordion:first-child {
  border-top: 1px solid var(--lumea-border);
}

.lumea-pdp-accordion-trigger {
  width: 100%;
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 22px 0;
  background: transparent;
  border: none;
  cursor: pointer;
  text-align: left;
  font-family: "ClashDisplay-Variable", "Clash Display", Inter, sans-serif;
  font-size: 17px;
  font-weight: 400;
  letter-spacing: -0.01em;
  color: var(--lumea-text);
  transition: color 0.18s ease;
}

.lumea-pdp-accordion-trigger:hover {
  color: var(--lumea-accent-dark);
}

.lumea-pdp-accordion-icon {
  flex-shrink: 0;
  transition: transform 0.25s ease;
  color: var(--lumea-muted);
}

.lumea-pdp-accordion-trigger.is-open .lumea-pdp-accordion-icon {
  transform: rotate(180deg);
}

.lumea-pdp-accordion-body {
  overflow: hidden;
  max-height: 0;
  transition: max-height 0.35s cubic-bezier(0.4, 0, 0.2, 1);
}

.lumea-pdp-accordion-content {
  padding: 0 0 24px;
  font-family: Inter, sans-serif;
  font-size: 15px;
  line-height: 1.8;
  color: var(--lumea-muted);
}

.lumea-pdp-accordion-content p {
  margin: 0 0 12px;
}

.lumea-pdp-accordion-content p:last-child {
  margin-bottom: 0;
}

.lumea-pdp-accordion-content ul,
.lumea-pdp-accordion-content ol {
  padding-left: 20px;
  margin: 0 0 12px;
}

.lumea-pdp-accordion-content li {
  margin-bottom: 6px;
}

/* ── Reviews ────────────────────────────────────────────── */
.lumea-pdp-reviews-wrap {
  background: #ffffff;
  padding: 80px 0;
  border-top: 1px solid var(--lumea-border);
}

.lumea-pdp-reviews-inner {
  width: min(100% - 48px, 800px);
  margin-inline: auto;
}

.lumea-pdp-reviews-head {
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 32px;
  margin-bottom: 48px;
  flex-wrap: wrap;
}

.lumea-pdp-reviews-summary {
  display: flex;
  align-items: center;
  gap: 16px;
}

.lumea-pdp-reviews-avg {
  font-family: "ClashDisplay-Variable", "Clash Display", Inter, sans-serif;
  font-size: 56px;
  font-weight: 400;
  letter-spacing: -0.04em;
  line-height: 1;
  color: var(--lumea-text);
}

.lumea-pdp-reviews-total {
  margin: 6px 0 0;
  font-family: Inter, sans-serif;
  font-size: 13px;
  color: var(--lumea-muted);
}

.lumea-pdp-reviews-title {
  margin: 0;
  font-family: "ClashDisplay-Variable", "Clash Display", Inter, sans-serif;
  font-size: clamp(28px, 3.5vw, 42px);
  font-weight: 400;
  letter-spacing: -0.03em;
  color: var(--lumea-text);
  text-align: right;
}

.lumea-pdp-reviews-inner #reviews {
  font-family: Inter, sans-serif;
}

.lumea-pdp-reviews-inner .comment-text {
  border: 1px solid var(--lumea-border);
  border-radius: 16px;
  padding: 24px;
  background: var(--lumea-bg);
  margin-bottom: 20px;
}

.lumea-pdp-reviews-inner .woocommerce-review__author {
  font-weight: 700;
  color: var(--lumea-text);
}

.lumea-pdp-reviews-inner .woocommerce-review__date {
  font-size: 12px;
  color: var(--lumea-muted);
}

.lumea-pdp-reviews-inner #respond {
  margin-top: 48px;
  padding-top: 48px;
  border-top: 1px solid var(--lumea-border);
}

.lumea-pdp-reviews-inner #respond h3 {
  font-family: "ClashDisplay-Variable", "Clash Display", Inter, sans-serif;
  font-size: 24px;
  font-weight: 400;
  letter-spacing: -0.02em;
  margin: 0 0 24px;
}

.lumea-pdp-reviews-inner textarea,
.lumea-pdp-reviews-inner input[type="text"],
.lumea-pdp-reviews-inner input[type="email"] {
  width: 100%;
  border: 1px solid var(--lumea-border);
  border-radius: 12px;
  padding: 12px 16px;
  font-family: Inter, sans-serif;
  font-size: 14px;
  background: #ffffff;
  color: var(--lumea-text);
  outline: none;
  transition: border-color 0.18s ease;
}

.lumea-pdp-reviews-inner textarea:focus,
.lumea-pdp-reviews-inner input[type="text"]:focus,
.lumea-pdp-reviews-inner input[type="email"]:focus {
  border-color: var(--lumea-accent);
}

.lumea-pdp-reviews-inner #submit {
  margin-top: 16px;
  padding: 14px 32px;
  background: var(--lumea-text);
  color: #ffffff;
  border: none;
  border-radius: 100px;
  font-family: Inter, sans-serif;
  font-size: 13px;
  font-weight: 700;
  letter-spacing: 0.04em;
  cursor: pointer;
  transition: background 0.2s ease;
}

.lumea-pdp-reviews-inner #submit:hover {
  background: var(--lumea-accent-dark);
}

/* ── Related products ───────────────────────────────────── */
.lumea-pdp-related {
  background: var(--lumea-bg);
  padding: 80px 0 96px;
  border-top: 1px solid var(--lumea-border);
}

.lumea-pdp-related-inner {
  width: min(100% - 48px, var(--lumea-container));
  margin-inline: auto;
}

.lumea-pdp-related-head {
  margin-bottom: 48px;
}

.lumea-pdp-related-eyebrow {
  margin: 0 0 10px;
  font-family: Inter, sans-serif;
  font-size: 11px;
  font-weight: 700;
  letter-spacing: 0.18em;
  text-transform: uppercase;
  color: var(--lumea-accent-dark);
}

.lumea-pdp-related-title {
  margin: 0;
  font-family: "ClashDisplay-Variable", "Clash Display", Inter, sans-serif;
  font-size: clamp(32px, 4vw, 52px);
  font-weight: 400;
  letter-spacing: -0.03em;
  line-height: 1.05;
  color: var(--lumea-text);
}

.lumea-pdp-related-grid {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 32px 20px;
}

.lumea-pdp-rel-card {
  display: flex;
  flex-direction: column;
  gap: 0;
  text-decoration: none;
  color: inherit;
}

.lumea-pdp-rel-media {
  position: relative;
  aspect-ratio: 3 / 4;
  border-radius: 18px;
  overflow: hidden;
  background: #ffffff;
  margin-bottom: 16px;
}

.lumea-pdp-rel-img {
  width: 100%;
  height: 100%;
  object-fit: contain;
  display: block;
  transition: transform 0.45s cubic-bezier(0.25, 0.46, 0.45, 0.94);
}

.lumea-pdp-rel-card:hover .lumea-pdp-rel-img {
  transform: scale(1.04);
}

.lumea-pdp-rel-badge {
  position: absolute;
  top: 12px;
  left: 12px;
  padding: 3px 10px;
  border-radius: 100px;
  background: var(--lumea-accent);
  color: #ffffff;
  font-family: Inter, sans-serif;
  font-size: 10px;
  font-weight: 700;
  letter-spacing: 0.08em;
  text-transform: uppercase;
}

.lumea-pdp-rel-body {
  flex: 1;
}

.lumea-pdp-rel-cat {
  display: block;
  font-family: Inter, sans-serif;
  font-size: 10px;
  font-weight: 700;
  letter-spacing: 0.1em;
  text-transform: uppercase;
  color: var(--lumea-muted);
  margin-bottom: 5px;
}

.lumea-pdp-rel-name {
  margin: 0 0 6px;
  font-family: Inter, sans-serif;
  font-size: 14px;
  font-weight: 600;
  color: var(--lumea-text);
  line-height: 1.35;
}

.lumea-pdp-rel-price {
  margin: 0 0 10px;
  font-family: Inter, sans-serif;
  font-size: 14px;
  font-weight: 600;
  color: var(--lumea-text);
}

.lumea-pdp-rel-cta {
  font-family: Inter, sans-serif;
  font-size: 12px;
  font-weight: 700;
  color: var(--lumea-accent-dark);
  opacity: 0;
  transform: translateY(4px);
  transition: opacity 0.2s ease, transform 0.2s ease;
  display: block;
}

.lumea-pdp-rel-card:hover .lumea-pdp-rel-cta {
  opacity: 1;
  transform: translateY(0);
}

/* ── Lightbox ───────────────────────────────────────────── */
.lumea-lightbox {
  position: fixed;
  inset: 0;
  z-index: 9999;
  background: rgba(10, 8, 6, 0.92);
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 32px;
  opacity: 0;
  pointer-events: none;
  transition: opacity 0.25s ease;
}

.lumea-lightbox.is-open {
  opacity: 1;
  pointer-events: auto;
}

.lumea-lightbox-img {
  max-width: 100%;
  max-height: 90vh;
  object-fit: contain;
  border-radius: 12px;
  transform: scale(0.95);
  transition: transform 0.25s ease;
}

.lumea-lightbox.is-open .lumea-lightbox-img {
  transform: scale(1);
}

.lumea-lightbox-close {
  position: absolute;
  top: 24px;
  right: 24px;
  width: 44px;
  height: 44px;
  display: flex;
  align-items: center;
  justify-content: center;
  background: rgba(255, 255, 255, 0.12);
  border: 1px solid rgba(255, 255, 255, 0.2);
  border-radius: 50%;
  color: #ffffff;
  cursor: pointer;
  transition: background 0.18s ease;
}

.lumea-lightbox-close:hover {
  background: rgba(255, 255, 255, 0.22);
}

/* ── PDP Responsive ─────────────────────────────────────── */
@media (max-width: 1024px) {
  .lumea-pdp-hero-inner {
    grid-template-columns: 1fr;
    gap: 40px;
  }

  .lumea-pdp-gallery {
    max-width: 600px;
    margin-inline: auto;
    flex-direction: column;
  }

  .lumea-pdp-thumbs {
    flex-direction: row;
    order: 2;
    overflow-x: auto;
    scrollbar-width: none;
  }

  .lumea-pdp-thumbs::-webkit-scrollbar {
    display: none;
  }

  .lumea-pdp-thumb {
    width: 64px;
    height: 78px;
  }

  .lumea-pdp-main-img-wrap {
    order: 1;
  }

  .lumea-pdp-related-grid {
    grid-template-columns: repeat(3, 1fr);
  }
}

@media (max-width: 768px) {
  .lumea-pdp-hero {
    padding: 32px 0 56px;
  }

  .lumea-pdp-hero-inner {
    width: min(100% - 32px, var(--lumea-container));
  }

  .lumea-pdp-trust {
    grid-template-columns: 1fr;
    gap: 14px;
  }

  .lumea-pdp-related-grid {
    grid-template-columns: repeat(2, 1fr);
    gap: 20px 12px;
  }

  .lumea-pdp-reviews-head {
    flex-direction: column;
    align-items: flex-start;
  }

  .lumea-pdp-reviews-title {
    text-align: left;
  }
}

@media (max-width: 480px) {
  .lumea-pdp-btn-row {
    flex-direction: column;
  }

  .lumea-pdp-wish-btn {
    width: 100%;
    height: 52px;
    border-radius: 100px;
  }
}
"""

with open(css_path, 'a', encoding='utf-8') as f:
    f.write(pdp_css)

print("PDP CSS appended successfully.")
