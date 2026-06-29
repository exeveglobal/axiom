<?php
/**
 * Performance Module — reads Customizer toggles and strips/defers assets accordingly.
 *
 * @package Axiom\Modules\Performance
 */

declare( strict_types=1 );

namespace Axiom\Modules\Performance;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class Module {

	public function register(): void {
		add_action( 'init',       [ $this, 'remove_head_bloat' ] );
		add_action( 'wp_head',    [ $this, 'dns_prefetch' ], 1 );
		add_action( 'wp_head',    [ $this, 'custom_head_code' ], 999 );
		add_action( 'wp_footer',  [ $this, 'custom_footer_code' ], 999 );
		add_filter( 'body_class', [ $this, 'extra_body_class' ] );
		add_filter( 'the_content', [ $this, 'lazy_images' ] );
		add_filter( 'post_thumbnail_html', [ $this, 'lazy_images' ] );
		add_filter( 'wp_get_attachment_image_attributes', [ $this, 'lazy_attachment_attrs' ] );
		add_filter( 'script_loader_tag', [ $this, 'defer_scripts' ], 10, 3 );
		add_action( 'wp_enqueue_scripts', [ $this, 'maybe_dequeue_block_css' ], 100 );
		add_action( 'wp_default_scripts', [ $this, 'maybe_remove_jquery_migrate' ] );
	}

	public function remove_head_bloat(): void {
		if ( $this->is_on( 'perf_disable_emoji' ) ) {
			remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
			remove_action( 'wp_print_styles', 'print_emoji_styles' );
			remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
			remove_action( 'admin_print_styles', 'print_emoji_styles' );
			remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
			remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
			remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
		}

		if ( $this->is_on( 'perf_disable_rsd' ) ) {
			remove_action( 'wp_head', 'rsd_link' );
			remove_action( 'wp_head', 'wlwmanifest_link' );
		}

		if ( $this->is_on( 'perf_disable_shortlink' ) ) {
			remove_action( 'wp_head', 'wp_shortlink_wp_head' );
		}

		if ( $this->is_on( 'perf_disable_rest_link' ) ) {
			remove_action( 'wp_head', 'rest_output_link_wp_head' );
			remove_action( 'template_redirect', 'rest_output_link_header', 11 );
		}

		if ( $this->is_on( 'perf_disable_oembed' ) ) {
			remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );
			remove_action( 'wp_head', 'wp_oembed_add_host_js' );
		}
	}

	public function maybe_remove_jquery_migrate( \WP_Scripts $scripts ): void {
		if ( ! $this->is_on( 'perf_disable_jquery_migrate' ) || is_admin() ) {
			return;
		}
		if ( isset( $scripts->registered['jquery'] ) ) {
			$scripts->registered['jquery']->deps = array_diff(
				$scripts->registered['jquery']->deps,
				[ 'jquery-migrate' ]
			);
		}
	}

	public function maybe_dequeue_block_css(): void {
		if ( $this->is_on( 'perf_disable_block_css' ) ) {
			wp_dequeue_style( 'wp-block-library' );
			wp_dequeue_style( 'wp-block-library-theme' );
			wp_dequeue_style( 'global-styles' );
		}
	}

	public function defer_scripts( string $tag, string $handle, string $src ): string {
		if ( ! $this->is_on( 'perf_defer_js' ) || is_admin() ) {
			return $tag;
		}
		$no_defer = [ 'axiom-customizer-preview', 'axiom-customizer-controls', 'jquery-core' ];
		if ( in_array( $handle, $no_defer, true ) ) {
			return $tag;
		}
		if ( str_contains( $tag, ' defer' ) || str_contains( $tag, ' async' ) ) {
			return $tag;
		}
		return str_replace( '<script ', '<script defer ', $tag );
	}

	public function lazy_images( string $content ): string {
		if ( ! $this->is_on( 'perf_lazy_images' ) ) {
			return $content;
		}
		return preg_replace( '/<img(?![^>]*\bloading=)([^>]*)>/i', '<img loading="lazy"$1>', $content ) ?? $content;
	}

	public function lazy_attachment_attrs( array $attrs ): array {
		if ( $this->is_on( 'perf_lazy_images' ) && ! isset( $attrs['loading'] ) ) {
			$attrs['loading'] = 'lazy';
		}
		return $attrs;
	}

	public function dns_prefetch(): void {
		$domains = get_theme_mod( 'axiom_perf_dns_prefetch', '' );
		if ( empty( $domains ) ) {
			return;
		}
		foreach ( array_filter( array_map( 'trim', explode( "\n", $domains ) ) ) as $domain ) {
			$domain = esc_attr( $domain );
			echo "<link rel=\"dns-prefetch\" href=\"//{$domain}\">\n"; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		}
	}

	public function extra_body_class( array $classes ): array {
		$extra = sanitize_html_class( get_theme_mod( 'axiom_advanced_body_class', '' ) );
		if ( $extra ) {
			$classes[] = $extra;
		}
		return $classes;
	}

	public function custom_head_code(): void {
		$code = get_theme_mod( 'axiom_advanced_head_code', '' );
		if ( $code ) {
			echo $code . "\n"; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- user-controlled trusted field
		}
	}

	public function custom_footer_code(): void {
		$code = get_theme_mod( 'axiom_advanced_footer_code', '' );
		if ( $code ) {
			echo $code . "\n"; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- user-controlled trusted field
		}
	}

	private function is_on( string $key ): bool {
		return (bool) get_theme_mod( 'axiom_' . $key, false );
	}
}
