# Axiom

A performance-first, page-builder-agnostic WordPress theme engineered for speed, semantic clarity, and AI indexability.

Built by [EXEVE](https://exeve.com).

- **Version:** 1.1.0
- **Requires:** WordPress 6.3+, PHP 8.0+
- **License:** GPL-3.0-or-later
- **No build step** — no Node.js, no Composer, no npm. All CSS/JS in `assets/` is hand-authored and edited directly.

## Features

- Hand-authored CSS with a CSS custom-property theming layer (colors, typography, layout, header/footer/PTB — see [`docs/user-guide.md`](docs/user-guide.md#css-custom-properties))
- Full Customizer control panel: Header, Footer, Page Title Bar, Performance, AI & SEO, Advanced
- Per-page metabox: hide page title bar, page subtitle, custom breadcrumb label, extra body class
- Built-in JSON-LD schema (Organization, WebSite, Article, Breadcrumb) and AI-bot `robots.txt` controls
- Performance toggles: emoji scripts, jQuery Migrate, block library CSS, oEmbed, RSD/WLW, shortlink, REST link, lazy-loading, script defer
- Designed to stay out of the way of page builders (Elementor, Bricks, Beaver Builder, Divi) and Gutenberg

## Requirements

| Requirement | Minimum |
|---|---|
| WordPress | 6.3 |
| PHP | 8.0 |

## Installation

1. Copy (or clone) this repository into `<wp-root>/wp-content/themes/axiom/`.
2. In WP Admin, go to **Appearance → Themes** and activate **Axiom**.
3. Go to **Appearance → Customize** to configure theme settings.

Full setup and configuration walkthrough: [`docs/user-guide.md`](docs/user-guide.md).

## Project Structure

```
axiom/
├── assets/          # Pre-compiled CSS & JS (edit directly, no build)
│   ├── css/         # theme.css, editor.css, customizer.css
│   └── js/          # navigation.js, customizer-preview.js, customizer-controls.js, admin-meta.js
├── src/             # PHP source (PSR-4, namespace Axiom\)
│   ├── Theme.php            # Singleton bootstrap — hooks all modules
│   ├── Core/                # Autoloader + fluent hook registration
│   ├── Assets/               # wp_enqueue_scripts manager
│   ├── Customizer/           # All Customizer panels/sections/controls
│   └── Modules/
│       ├── Performance/     # Emoji, jQuery Migrate, defer, lazy-load, etc.
│       ├── Schema/          # JSON-LD structured data
│       └── Meta/            # Per-page metabox
├── templates/       # PHP template partials (header, footer, PTB, loops)
├── inc/             # get_axiom_option() helper + template tags
├── docs/            # User guide
└── .github/workflows/deploy.yml  # FTP deploy to Hostinger on push to main
```

Any class in the `Axiom\` namespace autoloads from `src/` via a custom `spl_autoload_register` in `src/Core/Loader.php` — no Composer required.

## Development

- Edit PHP in `src/` or `templates/` — changes are live, no reload/build step.
- Edit CSS directly in `assets/css/theme.css`.
- Edit JS directly in `assets/js/`.
- Branch strategy: `dev` (active development) → `main` (production). Merging to `main` triggers the FTP deploy workflow to Hostinger.

## Page Builder Compatibility

Axiom ships CSS that lets Elementor, Beaver Builder, Bricks, and Divi full-width sections escape the theme's container automatically — no theme configuration required for layout.

If you see widget/JS issues with a page builder, check **Appearance → Customize → Performance** first: *Defer Non-Critical Scripts* and *Remove jQuery Migrate* are enabled by default and can interfere with a builder's own runtime scripts. Disable them, retest, and re-enable one at a time if you want to confirm which is safe for your plugin mix. Details: [`docs/user-guide.md` § Page Builder Usage](docs/user-guide.md#7-page-builder-usage).

## Documentation

See [`docs/user-guide.md`](docs/user-guide.md) for the full Customizer reference, per-page settings, widget areas, CSS custom properties, and plugin compatibility notes.

## License

GPL-3.0-or-later. See [style.css](style.css) header for theme metadata.
