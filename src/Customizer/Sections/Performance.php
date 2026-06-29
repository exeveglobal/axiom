<?php

declare( strict_types=1 );

namespace Axiom\Customizer\Sections;

use Axiom\Customizer\Abstract_Section;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class Performance extends Abstract_Section {

	protected const SETTINGS = [
		'perf_disable_emoji'        => [ 'label' => 'Remove Emoji Scripts',              'type' => 'checkbox', 'default' => true,  'transport' => 'refresh', 'description' => 'Removes wp-emoji-release.min.js from every page load.' ],
		'perf_disable_jquery_migrate' => [ 'label' => 'Remove jQuery Migrate',           'type' => 'checkbox', 'default' => true,  'transport' => 'refresh', 'description' => 'Safe to enable if you are not using legacy plugins.' ],
		'perf_disable_block_css'    => [ 'label' => 'Remove Block Library CSS',          'type' => 'checkbox', 'default' => false, 'transport' => 'refresh', 'description' => 'Disable if you are not using Gutenberg blocks on the frontend.' ],
		'perf_disable_oembed'       => [ 'label' => 'Remove oEmbed Script',              'type' => 'checkbox', 'default' => false, 'transport' => 'refresh' ],
		'perf_disable_rsd'          => [ 'label' => 'Remove RSD / WLW Links from Head',  'type' => 'checkbox', 'default' => true,  'transport' => 'refresh' ],
		'perf_disable_shortlink'    => [ 'label' => 'Remove Shortlink from Head',        'type' => 'checkbox', 'default' => true,  'transport' => 'refresh' ],
		'perf_disable_rest_link'    => [ 'label' => 'Remove REST API Link from Head',    'type' => 'checkbox', 'default' => true,  'transport' => 'refresh' ],
		'perf_lazy_images'          => [ 'label' => 'Native Lazy Load Images',           'type' => 'checkbox', 'default' => true,  'transport' => 'refresh', 'description' => 'Adds loading="lazy" to all images.' ],
		'perf_defer_js'             => [ 'label' => 'Defer Non-Critical Scripts',        'type' => 'checkbox', 'default' => true,  'transport' => 'refresh' ],
		'perf_preload'              => [ 'label' => 'Preload',                           'type' => 'select',   'default' => 'fonts', 'transport' => 'refresh', 'choices' => [ 'none' => 'Nothing', 'fonts' => 'Fonts Only', 'fonts_hero' => 'Fonts + Hero Image' ] ],
		'perf_dns_prefetch'         => [ 'label' => 'DNS Prefetch Domains (one per line)', 'type' => 'textarea', 'default' => '', 'transport' => 'refresh', 'description' => 'e.g. fonts.googleapis.com' ],
	];

	public function section_id(): string {
		return 'axiom_performance';
	}

	public function section_args(): array {
		return [
			'title'    => esc_html__( 'Performance', 'axiom' ),
			'panel'    => self::PANEL,
			'priority' => 70,
		];
	}
}
