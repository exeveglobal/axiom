# Axiom Theme — User Guide

**Version 1.1.0 · Built by EXEVE**

Axiom is a performance-first WordPress theme built for use with page builders (Elementor, Bricks, Beaver Builder) or the Gutenberg block editor. It stays out of the way visually and provides a clean structural foundation plus a focused set of controls for performance, SEO, and layout.

---

## Table of Contents

1. [Requirements](#1-requirements)
2. [Installation](#2-installation)
3. [Quick Start](#3-quick-start)
4. [Customizer Settings](#4-customizer-settings)
   - [Header](#41-header)
   - [Footer](#42-footer)
   - [Page Title Bar](#43-page-title-bar)
   - [Performance](#44-performance)
   - [AI & SEO](#45-ai--seo)
   - [Advanced](#46-advanced)
5. [Per-Page Settings](#5-per-page-settings)
6. [Widget Areas](#6-widget-areas)
7. [Page Builder Usage](#7-page-builder-usage)
8. [Navigation Menus](#8-navigation-menus)
9. [Custom CSS](#9-custom-css)
10. [Plugin Compatibility Notes](#10-plugin-compatibility-notes)

---

## 1. Requirements

| Requirement | Minimum |
|-------------|---------|
| WordPress   | 6.3     |
| PHP         | 8.0     |
| Browser (admin) | Any modern browser |

No build step, no Node.js, no Composer required.

---

## 2. Installation

1. In your WordPress admin go to **Appearance → Themes → Add New → Upload Theme**.
2. Upload the `axiom.zip` file and click **Install Now**.
3. Click **Activate**.
4. Go to **Appearance → Customize** to configure theme settings.

---

## 3. Quick Start

After activation, do these four things:

1. **Set your logo** — Appearance → Customize → Site Identity → Logo.
2. **Assign a menu** — Appearance → Menus → create a menu and assign it to the *Primary Navigation* location.
3. **Add footer widgets** — Appearance → Widgets → add widgets to *Footer Column 1–4*.
4. **Review Performance settings** — Appearance → Customize → Axiom Theme → Performance. Safe defaults are already enabled; see [section 4.4](#44-performance) for details.

---

## 4. Customizer Settings

All theme options live under **Appearance → Customize → Axiom Theme**.

### 4.1 Header

| Setting | Default | Description |
|---------|---------|-------------|
| Sticky Header | Off | Pins the header to the top of the viewport when scrolling. |
| Auto-hide on scroll down | Off | Hides the sticky header when scrolling down; reveals it when scrolling up. Only visible when Sticky Header is on. |

**Logo and site title** are managed via the native **Site Identity** section in the Customizer, not under the Axiom panel.

---

### 4.2 Footer

| Setting | Default | Description |
|---------|---------|-------------|
| Copyright Text | `© {year}. All rights reserved.` | Displayed in the footer bar. Use `{year}` — it is replaced with the current four-digit year automatically. |

Footer widget content is managed separately via **Appearance → Widgets** (see [section 6](#6-widget-areas)).

---

### 4.3 Page Title Bar

The Page Title Bar (PTB) is the section that appears at the top of each page showing the page title and breadcrumb.

| Setting | Default | Description |
|---------|---------|-------------|
| Enable Page Title Bar | On | Shows or hides the title bar globally across the site. |
| Hide on Homepage | Off | Suppresses the title bar only on the front page, while keeping it active on all other pages. |
| Alignment | Left | Sets the text alignment of the title and breadcrumb. Options: Left, Center, Right. |
| Show Breadcrumb | On | Displays the breadcrumb trail above the page title. |

**Per-page override:** Individual pages can hide the title bar via the *Axiom Page Settings* metabox in the post editor (see [section 5](#5-per-page-settings)).

---

### 4.4 Performance

All options default to the recommended setting. Only change them if you have a specific reason.

| Setting | Default | Notes |
|---------|---------|-------|
| Remove Emoji Scripts | On | Removes `wp-emoji-release.min.js` from every page. Disable only if you need emoji in comments or post content. |
| Remove jQuery Migrate | On | Safe for all modern plugins. Disable if you see JS errors after enabling. |
| Remove Block Library CSS | Off | Enable if you are using a page builder exclusively and no Gutenberg blocks on the frontend. |
| Remove oEmbed Script | Off | Enable if you do not embed YouTube/Twitter/etc. in your content. |
| Remove RSD / WLW Links from Head | On | Removes legacy XML-RPC discovery tags — safe to leave on. |
| Remove Shortlink from Head | On | Removes the `<link rel="shortlink">` tag — safe to leave on. |
| Remove REST API Link from Head | On | Removes `<link rel="https://api.w.org/">` from the head — safe to leave on. |
| Native Lazy Load Images | On | Adds `loading="lazy"` to all images. Disable only if you have a dedicated lazy-load plugin. |
| Defer Non-Critical Scripts | On | Adds `defer` to non-critical `<script>` tags to improve Time to Interactive. jQuery and Axiom scripts are excluded. |
| DNS Prefetch Domains | Empty | Enter one domain per line (e.g. `fonts.googleapis.com`). Adds `<link rel="dns-prefetch">` for faster third-party connections. |

**Conflict warning:** If you use a caching or optimisation plugin (WP Rocket, LiteSpeed Cache, NitroPack, W3 Total Cache), it likely has its own emoji/jQuery/CSS controls. Enable those in *either* the plugin *or* Axiom — not both, to avoid double-processing.

---

### 4.5 AI & SEO

Axiom outputs structured data (JSON-LD) and controls AI bot access via `robots.txt`.

#### Organization Schema

| Setting | Default | Description |
|---------|---------|-------------|
| Organization Schema (JSON-LD) | On | Outputs `Organization` structured data in `<head>` on every page. |
| Organization Name | *(empty)* | Defaults to your WordPress site title if left empty. |
| Organization Logo | *(empty)* | Select via Media Library. Recommended size: at least 112 × 112 px. |
| Organization URL | *(empty)* | Defaults to your site's home URL if left empty. |
| Social Profile URLs | *(empty)* | One URL per line — LinkedIn, Twitter/X, Facebook, etc. Added as `sameAs` in the schema. |

#### Other Schema

| Setting | Default | Description |
|---------|---------|-------------|
| WebSite Schema + SearchAction | On | Tells AI assistants your site URL and search endpoint. |
| Breadcrumb Schema (JSON-LD) | On | Outputs `BreadcrumbList` schema on inner pages (skipped on the homepage). |
| Article Schema on Posts | On | Outputs `Article` schema on single blog posts including headline, dates, author, and thumbnail. |

#### AI Bot Access

Controls which AI crawlers can index your site via `robots.txt`. All are allowed by default.

| Setting | Bot |
|---------|-----|
| Allow GPTBot | OpenAI (ChatGPT) |
| Allow ClaudeBot | Anthropic (Claude) |
| Allow PerplexityBot | Perplexity AI |
| Allow Google-Extended | Google Gemini/AI Overview |

Unchecking a bot adds `Disallow: /` for that user-agent to your `robots.txt`.

**Note:** If you use Yoast SEO, Rank Math, or All in One SEO, their schema output will run alongside Axiom's. There is no conflict — search engines accept multiple JSON-LD blocks. If you prefer to manage all schema from your SEO plugin, disable the individual schema toggles here.

---

### 4.6 Advanced

| Setting | Default | Description |
|---------|---------|-------------|
| Global Body CSS Class | *(empty)* | Adds a CSS class to `<body>` on every page of the site. Useful for targeting the theme in your page builder's global CSS. |
| Custom `<head>` Code | *(empty)* | Raw HTML injected before `</head>`. Use for analytics snippets, tag managers (GTM), verification meta tags, etc. Output is not escaped — use trusted code only. |
| Custom Footer Code | *(empty)* | Raw HTML injected before `</body>`. Use for chat widgets, conversion scripts, etc. |
| Custom CSS | *(empty)* | CSS injected after the theme stylesheet. Changes preview live in the Customizer. |

---

## 5. Per-Page Settings

Every page and post has an **Axiom Page Settings** metabox in the right sidebar of the post editor.

| Field | Description |
|-------|-------------|
| Hide Page Title Bar | Hides the PTB for this specific page, overriding the global Customizer setting. |
| Page Subtitle | Short text displayed beneath the page title in the PTB. |
| Custom Breadcrumb Label | Replaces the auto-generated page title in the breadcrumb with a custom label. |
| Extra Body CSS Class | Adds a custom class to `<body>` for this page only. Useful for per-page builder overrides. |

---

## 6. Widget Areas

Axiom registers four footer widget columns:

| Widget Area | Location |
|-------------|----------|
| Footer Column 1 | Leftmost column |
| Footer Column 2 | Second column |
| Footer Column 3 | Third column |
| Footer Column 4 | Rightmost column |

Manage widgets at **Appearance → Widgets**. The footer widget grid is only rendered when at least one column has active widgets. On screens below 1024 px the grid collapses to 2 columns; below 768 px it becomes a single column.

---

## 7. Page Builder Usage

Axiom is designed to be invisible to page builders.

**Elementor:** Full-width Elementor sections escape the theme container automatically. Set a section's Width to *Full Width* and it will stretch edge to edge. No extra configuration needed.

**Bricks / Beaver Builder / Divi:** The theme's `<main>` area has `max-width: none; padding: 0` when a page builder canvas is detected, so builders can control all spacing.

**Disabling the PTB for builder pages:** Use the *Hide Page Title Bar* checkbox in the Axiom Page Settings metabox on each builder page, or disable the PTB globally in the Customizer if you are building a full-site design.

---

## 8. Navigation Menus

Axiom registers one menu location:

| Location | Description |
|----------|-------------|
| Primary Navigation | Displayed in the header — desktop: horizontal right-aligned; mobile: slide-in drawer from left. |

To assign a menu: **Appearance → Menus → select or create a menu → set Location to Primary Navigation → Save**.

The mobile drawer opens with the hamburger button (visible on screens ≤ 767 px). It can be closed with the × button inside the drawer, the backdrop overlay, or the Escape key.

---

## 9. Custom CSS

Three ways to add CSS, in order of scope:

1. **Customizer → Axiom Theme → Advanced → Custom CSS** — site-wide, previews live.
2. **Axiom Page Settings metabox → Extra Body CSS Class** — add a class to a specific page, then target it in your page builder's global CSS or Custom CSS above.
3. **Appearance → Customize → Additional CSS** — WordPress native; works the same as option 1 but with no live preview of Axiom variables.

### CSS Custom Properties

All visual defaults are set as CSS custom properties on `:root` and can be overridden:

```css
/* Colours */
--axiom-color-text
--axiom-color-muted
--axiom-color-bg
--axiom-color-bg-alt
--axiom-color-border
--axiom-color-link
--axiom-color-link-hover

/* Typography */
--axiom-font-body
--axiom-font-heading
--axiom-font-mono

/* Container */
--axiom-container-max      /* default 1140px */
--axiom-container-padding  /* default 1.5rem */

/* Header */
--axiom-header-bg
--axiom-header-color
--axiom-header-padding

/* Footer */
--axiom-footer-bg
--axiom-footer-color

/* Page Title Bar */
--axiom-ptb-bg
--axiom-ptb-padding-y
```

Example — change the header background and link colour globally:
```css
:root {
    --axiom-header-bg:    #0f172a;
    --axiom-header-color: #f8fafc;
    --axiom-color-link:   #38bdf8;
}
```

---

## 10. Plugin Compatibility Notes

| Plugin | Notes |
|--------|-------|
| **Yoast SEO / Rank Math** | Schema output runs alongside Axiom's. Disable Axiom's schema toggles in AI & SEO if you want the SEO plugin to be the sole source. |
| **WooCommerce** | Axiom has no WooCommerce templates — WooCommerce uses its own. The theme container and header/footer render normally on shop pages. |
| **WP Rocket / LiteSpeed Cache / NitroPack** | These plugins duplicate several of Axiom's Performance options (emoji, jQuery, defer). Enable each optimisation in one place only. |
| **Action Scheduler** (via WooCommerce, etc.) | Axiom registers all its hooks on or after `init` to avoid any conflict with Action Scheduler's data store initialisation. |
| **Elementor** | Fully compatible. Full-width sections work without extra configuration. |
| **Contact Form 7 / Gravity Forms** | No conflicts. Form styles inherit the theme's neutral input defaults. |
