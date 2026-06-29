<?php

declare( strict_types=1 );

namespace Axiom\Customizer\Sections;

use Axiom\Customizer\Abstract_Section;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class Footer extends Abstract_Section {

	protected const SETTINGS = [
		'footer_bg'           => [ 'label' => 'Background Color',       'type' => 'color',    'default' => '#F9FAFB', 'css_var' => '--axiom-footer-bg' ],
		'footer_text_color'   => [ 'label' => 'Text Color',             'type' => 'color',    'default' => '#4A4A4A', 'css_var' => '--axiom-footer-color' ],
		'footer_padding_y'    => [ 'label' => 'Vertical Padding (rem)', 'type' => 'range',    'default' => '2', 'unit' => 'rem', 'css_var' => '--axiom-footer-padding-y', 'input_attrs' => [ 'min' => 0.5, 'max' => 6, 'step' => 0.25 ] ],
		'footer_border'       => [ 'label' => 'Top Border',             'type' => 'checkbox', 'default' => true,  'transport' => 'refresh' ],
		'footer_border_color' => [ 'label' => 'Border Color',           'type' => 'color',    'default' => '#E5E7EB', 'css_var' => '--axiom-footer-border-color', 'active_cb' => 'footer_border' ],
		'footer_layout'       => [ 'label' => 'Layout',                 'type' => 'radio',    'default' => 'default', 'transport' => 'refresh', 'choices' => [ 'default' => 'Logo Left / Nav Right', 'stacked' => 'Centered Stack', 'columns' => 'Multi Column' ] ],
		'footer_full_width'   => [ 'label' => 'Full Width',             'type' => 'checkbox', 'default' => false, 'transport' => 'refresh' ],
		'footer_show_logo'    => [ 'label' => 'Show Logo / Site Name',  'type' => 'checkbox', 'default' => true,  'transport' => 'refresh' ],
		'footer_show_nav'     => [ 'label' => 'Show Navigation',        'type' => 'checkbox', 'default' => true,  'transport' => 'refresh' ],
		'footer_show_copyright' => [ 'label' => 'Show Copyright',       'type' => 'checkbox', 'default' => true,  'transport' => 'refresh' ],
		'footer_copyright_text' => [ 'label' => 'Copyright Text',       'type' => 'text',     'default' => '© {year} EXEVE. All rights reserved.', 'active_cb' => 'footer_show_copyright' ],
	];

	public function section_id(): string {
		return 'axiom_footer';
	}

	public function section_args(): array {
		return [
			'title'    => esc_html__( 'Footer', 'axiom' ),
			'panel'    => self::PANEL,
			'priority' => 50,
		];
	}
}
