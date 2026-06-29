<?php
/**
 * Asset Manager — enqueues frontend CSS/JS with no unnecessary dependencies.
 *
 * @package Axiom\Assets
 */

declare( strict_types=1 );

namespace Axiom\Assets;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class Manager {

	public function enqueue_frontend(): void {
		wp_enqueue_style(
			'axiom-theme',
			AXIOM_ASSETS_URL . '/css/theme.css',
			[],
			AXIOM_VERSION
		);

		wp_enqueue_script(
			'axiom-navigation',
			AXIOM_ASSETS_URL . '/js/navigation.js',
			[],
			AXIOM_VERSION,
			[ 'strategy' => 'defer', 'in_footer' => true ]
		);

		if ( get_theme_mod( 'axiom_advanced_custom_css', '' ) ) {
			wp_add_inline_style( 'axiom-theme', wp_strip_all_tags( get_theme_mod( 'axiom_advanced_custom_css', '' ) ) );
		}

		if ( is_singular() && comments_open() ) {
			wp_enqueue_script( 'comment-reply' );
		}
	}

	public function enqueue_admin(): void {
		$screen = get_current_screen();
		if ( ! $screen || ! in_array( $screen->base, [ 'post', 'page' ], true ) ) {
			return;
		}

		wp_enqueue_media();

		wp_enqueue_script(
			'axiom-admin-meta',
			AXIOM_ASSETS_URL . '/js/admin-meta.js',
			[ 'wp-dom-ready' ],
			AXIOM_VERSION,
			[ 'strategy' => 'defer', 'in_footer' => true ]
		);
	}
}
