<?php
/**
 * Schema Module — outputs JSON-LD structured data for AI indexability and rich results.
 *
 * @package Axiom\Modules\Schema
 */

declare( strict_types=1 );

namespace Axiom\Modules\Schema;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class Module {

	public function register(): void {
		add_action( 'wp_head', [ $this, 'output' ], 2 );
		add_filter( 'robots_txt', [ $this, 'ai_robots' ], 10, 2 );
	}

	public function output(): void {
		$graphs = array_filter( [
			$this->organization(),
			$this->website(),
			$this->breadcrumb(),
			$this->article(),
		] );

		if ( empty( $graphs ) ) {
			return;
		}

		$schema = [
			'@context' => 'https://schema.org',
			'@graph'   => array_values( $graphs ),
		];

		echo '<script type="application/ld+json">' . wp_json_encode( $schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) . '</script>' . "\n"; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}

	private function organization(): ?array {
		if ( ! get_theme_mod( 'axiom_schema_org_enabled', true ) ) {
			return null;
		}

		$name    = get_theme_mod( 'axiom_schema_org_name', get_bloginfo( 'name' ) );
		$url     = get_theme_mod( 'axiom_schema_org_url', home_url( '/' ) );
		$logo_id = get_theme_mod( 'axiom_schema_org_logo', '' );
		$socials = array_filter( array_map( 'trim', explode( "\n", get_theme_mod( 'axiom_schema_org_socials', '' ) ) ) );

		$graph = [
			'@type' => 'Organization',
			'@id'   => home_url( '/#organization' ),
			'name'  => $name,
			'url'   => $url,
		];

		if ( $logo_id ) {
			$logo_url = wp_get_attachment_image_url( (int) $logo_id, 'full' );
			if ( $logo_url ) {
				$graph['logo'] = [ '@type' => 'ImageObject', 'url' => $logo_url ];
			}
		}

		if ( $socials ) {
			$graph['sameAs'] = array_values( $socials );
		}

		return $graph;
	}

	private function website(): ?array {
		if ( ! get_theme_mod( 'axiom_schema_website', true ) ) {
			return null;
		}

		return [
			'@type'            => 'WebSite',
			'@id'              => home_url( '/#website' ),
			'url'              => home_url( '/' ),
			'name'             => get_bloginfo( 'name' ),
			'description'      => get_bloginfo( 'description' ),
			'publisher'        => [ '@id' => home_url( '/#organization' ) ],
			'potentialAction'  => [
				'@type'       => 'SearchAction',
				'target'      => [
					'@type'       => 'EntryPoint',
					'urlTemplate' => home_url( '/?s={search_term_string}' ),
				],
				'query-input' => 'required name=search_term_string',
			],
		];
	}

	private function breadcrumb(): ?array {
		if ( ! get_theme_mod( 'axiom_schema_breadcrumb', true ) || is_front_page() ) {
			return null;
		}

		$items    = [];
		$position = 1;

		$items[] = [
			'@type'    => 'ListItem',
			'position' => $position++,
			'name'     => get_bloginfo( 'name' ),
			'item'     => home_url( '/' ),
		];

		if ( is_singular() ) {
			if ( is_singular( 'post' ) ) {
				$category = get_the_category();
				if ( $category ) {
					$items[] = [
						'@type'    => 'ListItem',
						'position' => $position++,
						'name'     => esc_html( $category[0]->name ),
						'item'     => get_category_link( $category[0]->term_id ),
					];
				}
			}
			$items[] = [
				'@type'    => 'ListItem',
				'position' => $position,
				'name'     => esc_html( get_the_title() ),
				'item'     => get_permalink(),
			];
		} elseif ( is_archive() ) {
			$items[] = [
				'@type'    => 'ListItem',
				'position' => $position,
				'name'     => esc_html( get_the_archive_title() ),
				'item'     => get_pagenum_link(),
			];
		}

		if ( count( $items ) <= 1 ) {
			return null;
		}

		return [
			'@type'           => 'BreadcrumbList',
			'@id'             => get_pagenum_link() . '#breadcrumb',
			'itemListElement' => $items,
		];
	}

	private function article(): ?array {
		if ( ! get_theme_mod( 'axiom_schema_article', true ) || ! is_singular( 'post' ) ) {
			return null;
		}

		$post      = get_queried_object();
		$image_url = get_the_post_thumbnail_url( $post, 'large' );

		$graph = [
			'@type'            => 'Article',
			'@id'              => get_permalink() . '#article',
			'headline'         => esc_html( get_the_title() ),
			'url'              => get_permalink(),
			'datePublished'    => get_the_date( 'c' ),
			'dateModified'     => get_the_modified_date( 'c' ),
			'author'           => [
				'@type' => 'Person',
				'name'  => esc_html( get_the_author() ),
			],
			'publisher'        => [ '@id' => home_url( '/#organization' ) ],
			'isPartOf'         => [ '@id' => home_url( '/#website' ) ],
		];

		if ( $image_url ) {
			$graph['image'] = [ '@type' => 'ImageObject', 'url' => $image_url ];
		}

		$excerpt = get_the_excerpt();
		if ( $excerpt ) {
			$graph['description'] = esc_html( wp_strip_all_tags( $excerpt ) );
		}

		return $graph;
	}

	public function ai_robots( string $output, bool $public ): string {
		if ( ! $public ) {
			return $output;
		}

		$bots = [
			'axiom_ai_gptbot_allow'        => 'GPTBot',
			'axiom_ai_claudebot_allow'      => 'ClaudeBot',
			'axiom_ai_perplexitybot_allow'  => 'PerplexityBot',
			'axiom_ai_googlebot_ext_allow'  => 'Google-Extended',
		];

		$rules = '';
		foreach ( $bots as $mod => $agent ) {
			if ( ! get_theme_mod( $mod, true ) ) {
				$rules .= "\nUser-agent: {$agent}\nDisallow: /\n";
			}
		}

		return $output . $rules;
	}
}
