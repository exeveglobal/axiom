<?php
/**
 * Customizer Manager — registers the Axiom panel and all active sections.
 *
 * Sections intentionally excluded (colours, typography, container widths) are
 * left to page builders and the theme's CSS custom properties so they don't
 * conflict with builder settings.
 *
 * @package Axiom\Customizer
 */

declare( strict_types=1 );

namespace Axiom\Customizer;

use Axiom\Customizer\Sections\Header;
use Axiom\Customizer\Sections\Footer;
use Axiom\Customizer\Sections\Page_Title_Bar;
use Axiom\Customizer\Sections\Performance;
use Axiom\Customizer\Sections\AI_SEO;
use Axiom\Customizer\Sections\Advanced;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class Manager {

	/** @var Abstract_Section[] */
	private array $sections;

	public function __construct() {
		$this->sections = [
			new Header(),
			new Footer(),
			new Page_Title_Bar(),
			new Performance(),
			new AI_SEO(),
			new Advanced(),
		];
	}

	public function register( \WP_Customize_Manager $wp_customize ): void {
		$wp_customize->add_panel( 'axiom_theme', [
			'title'       => esc_html__( 'Axiom Theme', 'axiom' ),
			'description' => esc_html__( 'Performance, SEO, and structural settings. Visual styling is handled by your page builder or Custom CSS.', 'axiom' ),
			'priority'    => 10,
		] );

		foreach ( $this->sections as $section ) {
			$section->register( $wp_customize );
		}
	}

	public function output_css_variables(): void {
		$lines = [];
		foreach ( $this->sections as $section ) {
			$vars = $section->css_variables();
			if ( $vars ) {
				$lines[] = $vars;
			}
		}

		if ( empty( $lines ) ) {
			return;
		}

		echo "<style id=\"axiom-vars\">\n:root {\n" . implode( "\n", $lines ) . "\n}\n</style>\n"; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}

	public function enqueue_preview(): void {
		wp_enqueue_script(
			'axiom-customizer-preview',
			AXIOM_ASSETS_URL . '/js/customizer-preview.js',
			[ 'customize-preview' ],
			AXIOM_VERSION,
			true
		);

		$preview_js = [];
		foreach ( $this->sections as $section ) {
			$js = $section->preview_js();
			if ( $js ) {
				$preview_js[] = $js;
			}
		}

		if ( $preview_js ) {
			wp_add_inline_script(
				'axiom-customizer-preview',
				implode( "\n", $preview_js )
			);
		}
	}

	public function enqueue_controls(): void {
		wp_enqueue_style(
			'axiom-customizer-controls',
			AXIOM_ASSETS_URL . '/css/customizer.css',
			[],
			AXIOM_VERSION
		);

		wp_enqueue_script(
			'axiom-customizer-controls',
			AXIOM_ASSETS_URL . '/js/customizer-controls.js',
			[ 'customize-controls' ],
			AXIOM_VERSION,
			true
		);

		$controls_js = [];
		foreach ( $this->sections as $section ) {
			$js = $section->controls_js();
			if ( $js ) {
				$controls_js[] = $js;
			}
		}

		if ( $controls_js ) {
			wp_add_inline_script(
				'axiom-customizer-controls',
				implode( "\n", $controls_js )
			);
		}
	}
}
