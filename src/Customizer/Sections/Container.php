<?php

declare( strict_types=1 );

namespace Axiom\Customizer\Sections;

use Axiom\Customizer\Abstract_Section;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class Container extends Abstract_Section {

	protected const SETTINGS = [
		'content_width'       => [ 'label' => 'Content Width (px)',        'type' => 'range', 'default' => '800',  'unit' => 'px', 'css_var' => '--axiom-content-width',    'input_attrs' => [ 'min' => 600, 'max' => 1400, 'step' => 10 ] ],
		'wide_width'          => [ 'label' => 'Wide Width (px)',            'type' => 'range', 'default' => '1200', 'unit' => 'px', 'css_var' => '--axiom-wide-width',       'input_attrs' => [ 'min' => 800, 'max' => 1920, 'step' => 10 ] ],
		'container_padding_x' => [ 'label' => 'Side Padding Desktop (rem)', 'type' => 'range', 'default' => '1.5',  'unit' => 'rem','css_var' => '--axiom-container-padding', 'input_attrs' => [ 'min' => 0, 'max' => 5, 'step' => 0.25 ] ],
		'container_padding_mobile' => [ 'label' => 'Side Padding Mobile (rem)', 'type' => 'range', 'default' => '1', 'unit' => 'rem', 'css_var' => '--axiom-container-padding-mobile', 'input_attrs' => [ 'min' => 0, 'max' => 3, 'step' => 0.25 ] ],
	];

	public function section_id(): string {
		return 'axiom_container';
	}

	public function section_args(): array {
		return [
			'title'    => esc_html__( 'Container', 'axiom' ),
			'panel'    => self::PANEL,
			'priority' => 30,
		];
	}
}
