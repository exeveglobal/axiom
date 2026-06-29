<?php

declare( strict_types=1 );

namespace Axiom\Customizer\Sections;

use Axiom\Customizer\Abstract_Section;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class Colors extends Abstract_Section {

	protected const SETTINGS = [
		// ── Brand Primaries ───────────────────────────────────────────────
		'color_brand_orange'  => [ 'label' => 'Brand — Orange',       'type' => 'color', 'default' => '#FE4C1C', 'css_var' => '--axiom-color-brand-orange',  'description' => 'EXEVE primary orange.' ],
		'color_brand_red'     => [ 'label' => 'Brand — Red',          'type' => 'color', 'default' => '#D9302D', 'css_var' => '--axiom-color-brand-red',     'description' => 'EXEVE primary red.' ],
		'color_brand_blue'    => [ 'label' => 'Brand — Blue',         'type' => 'color', 'default' => '#1754F1', 'css_var' => '--axiom-color-brand-blue',    'description' => 'EXEVE primary blue.' ],
		'color_brand_cyan'    => [ 'label' => 'Brand — Cyan',         'type' => 'color', 'default' => '#00C3FF', 'css_var' => '--axiom-color-brand-cyan',    'description' => 'EXEVE primary cyan.' ],

		// ── Brand Tints (light backgrounds) ──────────────────────────────
		'color_tint_orange'   => [ 'label' => 'Tint — Orange Light',  'type' => 'color', 'default' => '#FFEBE6', 'css_var' => '--axiom-color-tint-orange' ],
		'color_tint_red'      => [ 'label' => 'Tint — Red Light',     'type' => 'color', 'default' => '#FFF3E9', 'css_var' => '--axiom-color-tint-red' ],
		'color_tint_blue'     => [ 'label' => 'Tint — Blue Light',    'type' => 'color', 'default' => '#EAF3FF', 'css_var' => '--axiom-color-tint-blue' ],
		'color_tint_cyan'     => [ 'label' => 'Tint — Cyan Light',    'type' => 'color', 'default' => '#E3F7FD', 'css_var' => '--axiom-color-tint-cyan' ],

		// ── Semantic aliases (used by all other components) ───────────────
		'color_primary'       => [ 'label' => 'Primary (active brand color)',  'type' => 'color', 'default' => '#FE4C1C', 'css_var' => '--axiom-color-primary',  'description' => 'Main interactive colour — buttons, links, highlights.' ],
		'color_accent'        => [ 'label' => 'Accent',                        'type' => 'color', 'default' => '#1754F1', 'css_var' => '--axiom-color-accent',   'description' => 'Secondary interactive colour.' ],

		// ── Neutrals ──────────────────────────────────────────────────────
		'color_text'          => [ 'label' => 'Body Text',    'type' => 'color', 'default' => '#1A1A1A', 'css_var' => '--axiom-color-text' ],
		'color_muted'         => [ 'label' => 'Muted Text',   'type' => 'color', 'default' => '#6B7280', 'css_var' => '--axiom-color-muted' ],
		'color_bg'            => [ 'label' => 'Background',   'type' => 'color', 'default' => '#FFFFFF', 'css_var' => '--axiom-color-bg' ],
		'color_bg_alt'        => [ 'label' => 'Alt Background','type' => 'color', 'default' => '#F9FAFB', 'css_var' => '--axiom-color-bg-alt' ],
		'color_border'        => [ 'label' => 'Border',       'type' => 'color', 'default' => '#E5E7EB', 'css_var' => '--axiom-color-border' ],
		'color_link'          => [ 'label' => 'Link',         'type' => 'color', 'default' => '#FE4C1C', 'css_var' => '--axiom-color-link' ],
		'color_link_hover'    => [ 'label' => 'Link Hover',   'type' => 'color', 'default' => '#D9302D', 'css_var' => '--axiom-color-link-hover' ],
	];

	public function section_id(): string {
		return 'axiom_colors';
	}

	public function section_args(): array {
		return [
			'title'    => esc_html__( 'Colors', 'axiom' ),
			'panel'    => self::PANEL,
			'priority' => 10,
		];
	}
}
