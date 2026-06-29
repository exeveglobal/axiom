<?php

declare( strict_types=1 );

namespace Axiom\Customizer\Sections;

use Axiom\Customizer\Abstract_Section;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class Page_Title_Bar extends Abstract_Section {

	protected const SETTINGS = [
		'ptb_enabled'        => [ 'label' => 'Enable Page Title Bar',     'type' => 'checkbox', 'default' => true,      'transport' => 'refresh' ],
		'ptb_bg_type'        => [ 'label' => 'Background Type',           'type' => 'radio',    'default' => 'color',   'transport' => 'refresh', 'active_cb' => 'ptb_enabled', 'choices' => [ 'color' => 'Color', 'image' => 'Image', 'gradient' => 'Gradient' ] ],
		'ptb_bg_color'       => [ 'label' => 'Background Color',          'type' => 'color',    'default' => '#F9FAFB', 'css_var' => '--axiom-ptb-bg', 'active_cb' => 'ptb_enabled' ],
		'ptb_bg_image'       => [ 'label' => 'Background Image',          'type' => 'image',    'default' => '',        'transport' => 'refresh', 'active_cb' => 'ptb_enabled' ],
		'ptb_overlay'        => [ 'label' => 'Enable Overlay',            'type' => 'checkbox', 'default' => false,     'transport' => 'refresh', 'active_cb' => 'ptb_enabled' ],
		'ptb_overlay_color'  => [ 'label' => 'Overlay Color',             'type' => 'color',    'default' => '#0A0A0A', 'css_var' => '--axiom-ptb-overlay-color', 'active_cb' => 'ptb_overlay' ],
		'ptb_overlay_opacity'=> [ 'label' => 'Overlay Opacity',           'type' => 'range',    'default' => '0.4',     'unit' => '', 'css_var' => '--axiom-ptb-overlay-opacity', 'active_cb' => 'ptb_overlay', 'input_attrs' => [ 'min' => 0, 'max' => 1, 'step' => 0.05 ] ],
		'ptb_title_color'    => [ 'label' => 'Title Color',               'type' => 'color',    'default' => '#0A0A0A', 'css_var' => '--axiom-ptb-title-color', 'active_cb' => 'ptb_enabled' ],
		'ptb_subtitle_color' => [ 'label' => 'Subtitle Color',            'type' => 'color',    'default' => '#4A4A4A', 'css_var' => '--axiom-ptb-subtitle-color', 'active_cb' => 'ptb_enabled' ],
		'ptb_alignment'      => [ 'label' => 'Alignment',                 'type' => 'radio',    'default' => 'left',    'transport' => 'refresh', 'active_cb' => 'ptb_enabled', 'choices' => [ 'left' => 'Left', 'center' => 'Center', 'right' => 'Right' ] ],
		'ptb_padding_y'      => [ 'label' => 'Vertical Padding (rem)',    'type' => 'range',    'default' => '3', 'unit' => 'rem', 'css_var' => '--axiom-ptb-padding-y', 'active_cb' => 'ptb_enabled', 'input_attrs' => [ 'min' => 1, 'max' => 10, 'step' => 0.5 ] ],
		'ptb_breadcrumb'     => [ 'label' => 'Show Breadcrumb',           'type' => 'checkbox', 'default' => true,      'transport' => 'refresh', 'active_cb' => 'ptb_enabled' ],
		'ptb_breadcrumb_color' => [ 'label' => 'Breadcrumb Color',        'type' => 'color',    'default' => '#6B7280', 'css_var' => '--axiom-ptb-breadcrumb-color', 'active_cb' => 'ptb_breadcrumb' ],
	];

	public function section_id(): string {
		return 'axiom_page_title_bar';
	}

	public function section_args(): array {
		return [
			'title'    => esc_html__( 'Page Title Bar', 'axiom' ),
			'panel'    => self::PANEL,
			'priority' => 60,
		];
	}
}
