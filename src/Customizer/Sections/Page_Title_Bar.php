<?php

declare( strict_types=1 );

namespace Axiom\Customizer\Sections;

use Axiom\Customizer\Abstract_Section;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class Page_Title_Bar extends Abstract_Section {

	protected const SETTINGS = [
		'ptb_enabled' => [
			'label'     => 'Enable Page Title Bar',
			'type'      => 'checkbox',
			'default'   => true,
			'transport' => 'refresh',
		],
		'ptb_hide_on_front' => [
			'label'     => 'Hide on Homepage',
			'type'      => 'checkbox',
			'default'   => true,
			'transport' => 'refresh',
			'active_cb' => 'ptb_enabled',
		],
		'ptb_alignment' => [
			'label'     => 'Alignment',
			'type'      => 'radio',
			'default'   => 'left',
			'transport' => 'refresh',
			'active_cb' => 'ptb_enabled',
			'choices'   => [ 'left' => 'Left', 'center' => 'Center', 'right' => 'Right' ],
		],
		'ptb_breadcrumb' => [
			'label'     => 'Show Breadcrumb',
			'type'      => 'checkbox',
			'default'   => true,
			'transport' => 'refresh',
			'active_cb' => 'ptb_enabled',
		],
	];

	public function section_id(): string {
		return 'axiom_page_title_bar';
	}

	public function section_args(): array {
		return [
			'title'       => esc_html__( 'Page Title Bar', 'axiom' ),
			'description' => esc_html__( 'Background and colours can be overridden via Appearance → Customize → Additional CSS or your page builder.', 'axiom' ),
			'panel'       => self::PANEL,
			'priority'    => 60,
		];
	}
}
