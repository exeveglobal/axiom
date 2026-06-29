<?php

declare( strict_types=1 );

namespace Axiom\Customizer\Sections;

use Axiom\Customizer\Abstract_Section;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class Footer extends Abstract_Section {

	protected const SETTINGS = [
		'footer_copyright_text' => [
			'label'       => 'Copyright Text',
			'description' => 'Use {year} for the current year.',
			'type'        => 'text',
			'default'     => '© {year}. All rights reserved.',
			'transport'   => 'refresh',
		],
	];

	public function section_id(): string {
		return 'axiom_footer';
	}

	public function section_args(): array {
		return [
			'title'       => esc_html__( 'Footer', 'axiom' ),
			'description' => esc_html__( 'Widget content is managed via Appearance → Widgets. Layout and colours are controlled by your page builder.', 'axiom' ),
			'panel'       => self::PANEL,
			'priority'    => 50,
		];
	}
}
