<?php

declare( strict_types=1 );

namespace Axiom\Customizer\Sections;

use Axiom\Customizer\Abstract_Section;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class Header extends Abstract_Section {

	protected const SETTINGS = [
		'header_sticky' => [
			'label'     => 'Sticky Header',
			'type'      => 'checkbox',
			'default'   => false,
			'transport' => 'refresh',
		],
		'header_sticky_autohide' => [
			'label'     => 'Auto-hide on scroll down / reveal on scroll up',
			'type'      => 'checkbox',
			'default'   => false,
			'transport' => 'refresh',
			'active_cb' => 'header_sticky',
		],
	];

	public function section_id(): string {
		return 'axiom_header';
	}

	public function section_args(): array {
		return [
			'title'       => esc_html__( 'Header', 'axiom' ),
			'description' => esc_html__( 'Logo and colours are set via Appearance → Customize → Site Identity. Layout and typography are controlled by your page builder.', 'axiom' ),
			'panel'       => self::PANEL,
			'priority'    => 40,
		];
	}
}
