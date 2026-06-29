<?php

declare( strict_types=1 );

namespace Axiom\Customizer\Sections;

use Axiom\Customizer\Abstract_Section;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class Header extends Abstract_Section {

	protected const SETTINGS = [
		'header_logo_width'      => [ 'label' => 'Logo Max Width (px)',      'type' => 'range',    'default' => '160', 'unit' => 'px',  'css_var' => '--axiom-header-logo-width',  'input_attrs' => [ 'min' => 60, 'max' => 400, 'step' => 4 ] ],
		'header_bg'              => [ 'label' => 'Background Color',          'type' => 'color',    'default' => '#FFFFFF', 'css_var' => '--axiom-header-bg' ],
		'header_text_color'      => [ 'label' => 'Text / Link Color',         'type' => 'color',    'default' => '#0A0A0A', 'css_var' => '--axiom-header-color' ],
		'header_padding_y'       => [ 'label' => 'Vertical Padding (rem)',    'type' => 'range',    'default' => '1',    'unit' => 'rem', 'css_var' => '--axiom-header-padding-y',   'input_attrs' => [ 'min' => 0.25, 'max' => 4, 'step' => 0.25 ] ],
		'header_border'          => [ 'label' => 'Bottom Border',             'type' => 'checkbox', 'default' => false,  'transport' => 'refresh' ],
		'header_border_color'    => [ 'label' => 'Border Color',              'type' => 'color',    'default' => '#E5E7EB', 'css_var' => '--axiom-header-border-color', 'active_cb' => 'header_border' ],
		'header_layout'          => [ 'label' => 'Layout',                    'type' => 'radio',    'default' => 'default', 'transport' => 'refresh', 'choices' => [ 'default' => 'Logo Left / Nav Right', 'inverted' => 'Logo Right / Nav Left', 'stacked' => 'Centered Stack' ] ],
		'header_full_width'      => [ 'label' => 'Full Width',                'type' => 'checkbox', 'default' => false,  'transport' => 'refresh' ],
		'header_sticky'          => [ 'label' => 'Sticky Header',             'type' => 'checkbox', 'default' => false,  'transport' => 'refresh' ],
		'header_sticky_autohide' => [ 'label' => 'Auto-hide on scroll down / reveal on scroll up', 'type' => 'checkbox', 'default' => false, 'transport' => 'refresh', 'active_cb' => 'header_sticky' ],
		'header_sticky_bg'       => [ 'label' => 'Sticky Background Color',   'type' => 'color',    'default' => '#FFFFFF', 'css_var' => '--axiom-header-sticky-bg', 'active_cb' => 'header_sticky' ],
		'header_mobile_breakpoint' => [ 'label' => 'Mobile Menu Breakpoint', 'type' => 'select',   'default' => '768', 'transport' => 'refresh', 'choices' => [ '640' => 'Small (640px)', '768' => 'Tablet (768px)', '1024' => 'Desktop (1024px)' ] ],
		'header_nav_spacing'     => [ 'label' => 'Nav Item Spacing (rem)',    'type' => 'range',    'default' => '1.25', 'unit' => 'rem', 'css_var' => '--axiom-nav-spacing', 'input_attrs' => [ 'min' => 0.5, 'max' => 3, 'step' => 0.25 ] ],
	];

	public function section_id(): string {
		return 'axiom_header';
	}

	public function section_args(): array {
		return [
			'title'    => esc_html__( 'Header', 'axiom' ),
			'panel'    => self::PANEL,
			'priority' => 40,
		];
	}
}
