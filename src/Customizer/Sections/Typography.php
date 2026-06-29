<?php

declare( strict_types=1 );

namespace Axiom\Customizer\Sections;

use Axiom\Customizer\Abstract_Section;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class Typography extends Abstract_Section {

	protected const SETTINGS = [
		'font_body'         => [ 'label' => 'Body Font Family',         'type' => 'text',  'default' => 'system-ui, -apple-system, sans-serif', 'css_var' => '--axiom-font-body',        'transport' => 'refresh' ],
		'font_heading'      => [ 'label' => 'Heading Font Family',      'type' => 'text',  'default' => 'inherit',                               'css_var' => '--axiom-font-heading',     'transport' => 'refresh' ],
		'font_size_base'    => [ 'label' => 'Base Font Size (px)',      'type' => 'range', 'default' => '16', 'unit' => 'px',                    'css_var' => '--axiom-font-size-base',   'input_attrs' => [ 'min' => 12, 'max' => 24, 'step' => 1 ] ],
		'line_height_base'  => [ 'label' => 'Body Line Height',         'type' => 'range', 'default' => '1.6', 'unit' => '',                     'css_var' => '--axiom-line-height-base', 'input_attrs' => [ 'min' => 1.2, 'max' => 2.2, 'step' => 0.1 ] ],
		'font_size_h1'      => [ 'label' => 'H1 Size (rem)',            'type' => 'range', 'default' => '2.5', 'unit' => 'rem',                  'css_var' => '--axiom-font-size-h1',     'input_attrs' => [ 'min' => 1.5, 'max' => 5, 'step' => 0.1 ] ],
		'font_size_h2'      => [ 'label' => 'H2 Size (rem)',            'type' => 'range', 'default' => '2',   'unit' => 'rem',                  'css_var' => '--axiom-font-size-h2',     'input_attrs' => [ 'min' => 1.2, 'max' => 4, 'step' => 0.1 ] ],
		'font_size_h3'      => [ 'label' => 'H3 Size (rem)',            'type' => 'range', 'default' => '1.5', 'unit' => 'rem',                  'css_var' => '--axiom-font-size-h3',     'input_attrs' => [ 'min' => 1, 'max' => 3, 'step' => 0.1 ] ],
		'font_size_h4'      => [ 'label' => 'H4 Size (rem)',            'type' => 'range', 'default' => '1.25','unit' => 'rem',                  'css_var' => '--axiom-font-size-h4',     'input_attrs' => [ 'min' => 1, 'max' => 2.5, 'step' => 0.1 ] ],
		'font_size_h5'      => [ 'label' => 'H5 Size (rem)',            'type' => 'range', 'default' => '1.1', 'unit' => 'rem',                  'css_var' => '--axiom-font-size-h5',     'input_attrs' => [ 'min' => 0.9, 'max' => 2, 'step' => 0.1 ] ],
		'font_size_h6'      => [ 'label' => 'H6 Size (rem)',            'type' => 'range', 'default' => '1',   'unit' => 'rem',                  'css_var' => '--axiom-font-size-h6',     'input_attrs' => [ 'min' => 0.8, 'max' => 1.5, 'step' => 0.1 ] ],
		'font_weight_heading' => [ 'label' => 'Heading Font Weight',   'type' => 'select','default' => '600', 'css_var' => '--axiom-font-weight-heading', 'choices' => [ '300' => 'Light', '400' => 'Normal', '500' => 'Medium', '600' => 'Semi-bold', '700' => 'Bold', '800' => 'Extra-bold' ] ],
		'letter_spacing_heading' => [ 'label' => 'Heading Letter Spacing', 'type' => 'text', 'default' => '-0.02em', 'css_var' => '--axiom-letter-spacing-heading' ],
		'font_nav'          => [ 'label' => 'Navigation Font Family',   'type' => 'text',  'default' => 'inherit',  'css_var' => '--axiom-font-nav',      'transport' => 'refresh' ],
		'font_size_nav'     => [ 'label' => 'Navigation Font Size (rem)','type' => 'range','default' => '0.9375', 'unit' => 'rem', 'css_var' => '--axiom-font-size-nav', 'input_attrs' => [ 'min' => 0.75, 'max' => 1.25, 'step' => 0.0625 ] ],
		'font_weight_nav'   => [ 'label' => 'Navigation Font Weight',   'type' => 'select','default' => '500', 'css_var' => '--axiom-font-weight-nav', 'choices' => [ '300' => 'Light', '400' => 'Normal', '500' => 'Medium', '600' => 'Semi-bold', '700' => 'Bold' ] ],
	];

	public function section_id(): string {
		return 'axiom_typography';
	}

	public function section_args(): array {
		return [
			'title'    => esc_html__( 'Typography', 'axiom' ),
			'panel'    => self::PANEL,
			'priority' => 20,
		];
	}
}
