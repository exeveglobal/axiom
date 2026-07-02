# Axiom — WordPress Theme

**Version:** 1.1.0 | **Built by:** EXEVE | **Package:** `axiom`

## Key Facts

- **No build step.** No Node.js, no Composer, no npm. All CSS/JS is hand-authored and lives in `assets/`.
- **PHP 8.0+ required.** Code uses `declare(strict_types=1)`, `str_starts_with`, nullsafe operators.
- **WordPress 6.3+ required.**
- **Branch strategy:** `dev` → active development; `main` → production. GitHub Actions deploys `main` to Hostinger via FTP.

## Project Structure

```
axiom/
├── assets/          # Pre-compiled CSS & JS (edit directly, no build)
│   ├── css/
│   │   ├── theme.css          # Main frontend stylesheet
│   │   ├── editor.css         # Block editor styles
│   │   └── customizer.css     # Customizer controls
│   └── js/
│       ├── navigation.js      # Mobile drawer, sticky header
│       ├── customizer-preview.js
│       ├── customizer-controls.js
│       └── admin-meta.js
├── src/             # PHP source (PSR-4, namespace Axiom\)
│   ├── Theme.php              # Singleton bootstrap — hooks all modules
│   ├── Core/
│   │   ├── Loader.php         # Custom spl_autoload_register (no Composer needed)
│   │   └── Hook_Manager.php   # Fluent hook registration wrapper
│   ├── Assets/Manager.php     # wp_enqueue_scripts
│   ├── Customizer/            # All Customizer panels/sections/controls
│   └── Modules/
│       ├── Performance/       # Emoji, jQuery Migrate, defer, lazy-load, etc.
│       ├── Schema/            # JSON-LD: Organization, WebSite, Article, Breadcrumb
│       └── Meta/              # Per-page metabox (hide PTB, subtitle, body class)
├── templates/       # PHP template partials (header, footer, PTB, loops)
├── inc/
│   └── template-functions.php # get_axiom_option() helper + template tags
├── functions.php    # Theme bootstrap — defines constants, loads Loader + Theme
├── style.css        # Theme header only (no actual CSS here)
├── theme.json       # Block editor color/typography tokens
└── .github/
    └── workflows/deploy.yml   # FTP deploy to Hostinger on push to main
```

## How PHP Autoloading Works

`functions.php` registers `src/Core/Loader.php` which installs a `spl_autoload_register` callback. Any class in the `Axiom\` namespace resolves automatically from `src/`. Example: `Axiom\Customizer\Sections\Header` → `src/Customizer/Sections/Header.php`.

## Dev Workflow

1. Edit PHP in `src/` or `templates/` — no reload needed beyond standard WordPress.
2. Edit CSS in `assets/css/theme.css` directly.
3. Edit JS in `assets/js/` directly.
4. Commit to `dev`, open PR → `main` to trigger the FTP deploy workflow.

## Local WordPress Setup

This theme folder should live at:
```
<wp-root>/wp-content/themes/axiom/
```
Activate via **Appearance → Themes** in WP Admin.

## CSS Custom Properties (override these to restyle)

All visual defaults are on `:root`:
- Colors: `--axiom-color-text/muted/bg/bg-alt/border/link/link-hover`
- Typography: `--axiom-font-body/heading/mono`
- Layout: `--axiom-container-max` (1140px), `--axiom-container-padding` (1.5rem)
- Header: `--axiom-header-bg/color/padding`
- Footer: `--axiom-footer-bg/color`
- PTB: `--axiom-ptb-bg/padding-y`
