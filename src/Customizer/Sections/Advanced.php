<?php

declare( strict_types=1 );

namespace Axiom\Customizer\Sections;

use Axiom\Customizer\Abstract_Section;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class Advanced extends Abstract_Section {

	protected const SETTINGS = [
		'advanced_body_class'   => [ 'label' => 'Global Body CSS Class',  'type' => 'text',     'default' => '', 'transport' => 'refresh' ],
		'advanced_head_code'    => [ 'label' => 'Custom <head> Code',     'type' => 'textarea', 'default' => '', 'transport' => 'refresh', 'sanitize' => 'textarea', 'description' => 'Injected verbatim before </head>. Use for analytics, tag managers, etc.' ],
		'advanced_footer_code'  => [ 'label' => 'Custom Footer Code',     'type' => 'textarea', 'default' => '', 'transport' => 'refresh', 'sanitize' => 'textarea', 'description' => 'Injected verbatim before </body>.' ],
		'advanced_custom_css'   => [ 'label' => 'Custom CSS',             'type' => 'textarea', 'default' => '', 'transport' => 'postMessage', 'sanitize' => 'textarea' ],
	];

	public function section_id(): string {
		return 'axiom_advanced';
	}

	public function section_args(): array {
		return [
			'title'    => esc_html__( 'Advanced', 'axiom' ),
			'panel'    => self::PANEL,
			'priority' => 90,
		];
	}

	public function preview_js(): string {
		return <<<JS
		wp.customize('axiom_advanced_custom_css', function(v) {
			v.bind(function(val) {
				let el = document.getElementById('axiom-custom-css');
				if (!el) { el = document.createElement('style'); el.id = 'axiom-custom-css'; document.head.appendChild(el); }
				el.textContent = val;
			});
		});
		JS;
	}
}
