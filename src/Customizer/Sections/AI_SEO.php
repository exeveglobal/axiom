<?php

declare( strict_types=1 );

namespace Axiom\Customizer\Sections;

use Axiom\Customizer\Abstract_Section;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class AI_SEO extends Abstract_Section {

	protected const SETTINGS = [
		'schema_org_enabled'      => [ 'label' => 'Organization Schema (JSON-LD)',   'type' => 'checkbox', 'default' => true,  'transport' => 'refresh', 'description' => 'Outputs Organization structured data in <head>.' ],
		'schema_org_name'         => [ 'label' => 'Organization Name',               'type' => 'text',     'default' => '',    'transport' => 'refresh', 'active_cb' => 'schema_org_enabled' ],
		'schema_org_logo'         => [ 'label' => 'Organization Logo',               'type' => 'media',    'default' => '',    'transport' => 'refresh', 'active_cb' => 'schema_org_enabled' ],
		'schema_org_url'          => [ 'label' => 'Organization URL',                'type' => 'text',     'default' => '',    'sanitize' => 'url', 'transport' => 'refresh', 'active_cb' => 'schema_org_enabled' ],
		'schema_org_socials'      => [ 'label' => 'Social Profile URLs (one per line)', 'type' => 'textarea', 'default' => '', 'transport' => 'refresh', 'active_cb' => 'schema_org_enabled', 'description' => 'LinkedIn, Twitter/X, Facebook, etc.' ],
		'schema_website'          => [ 'label' => 'WebSite Schema + SearchAction',   'type' => 'checkbox', 'default' => true,  'transport' => 'refresh', 'description' => 'Helps AI assistants understand your site\'s search capability.' ],
		'schema_breadcrumb'       => [ 'label' => 'Breadcrumb Schema (JSON-LD)',     'type' => 'checkbox', 'default' => true,  'transport' => 'refresh' ],
		'schema_article'          => [ 'label' => 'Article Schema on Posts',         'type' => 'checkbox', 'default' => true,  'transport' => 'refresh' ],
		'ai_gptbot_allow'         => [ 'label' => 'Allow GPTBot (OpenAI)',           'type' => 'checkbox', 'default' => true,  'transport' => 'refresh' ],
		'ai_claudebot_allow'      => [ 'label' => 'Allow ClaudeBot (Anthropic)',     'type' => 'checkbox', 'default' => true,  'transport' => 'refresh' ],
		'ai_perplexitybot_allow'  => [ 'label' => 'Allow PerplexityBot',             'type' => 'checkbox', 'default' => true,  'transport' => 'refresh' ],
		'ai_googlebot_ext_allow'  => [ 'label' => 'Allow Google-Extended',           'type' => 'checkbox', 'default' => true,  'transport' => 'refresh' ],
	];

	public function section_id(): string {
		return 'axiom_ai_seo';
	}

	public function section_args(): array {
		return [
			'title'    => esc_html__( 'AI & SEO', 'axiom' ),
			'panel'    => self::PANEL,
			'priority' => 80,
		];
	}
}
