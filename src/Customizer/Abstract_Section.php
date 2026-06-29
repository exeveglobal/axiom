<?php
/**
 * Abstract Customizer Section.
 *
 * Each Section subclass declares a SETTINGS array. This base class loops through it
 * to register settings + controls, output CSS variables, and generate preview JS —
 * so adding a new setting is a single array entry, not four separate function calls.
 *
 * Setting definition keys:
 *   label        string   — Control label.
 *   type         string   — color | text | textarea | checkbox | select | radio | range | image | media
 *   default      mixed    — Default value.
 *   css_var      string   — CSS custom property name (e.g. '--axiom-color-primary'). Omit for non-visual settings.
 *   transport    string   — 'postMessage' (default for css_var) | 'refresh'
 *   choices      array    — For select/radio controls.
 *   input_attrs  array    — For range controls (min, max, step).
 *   active_cb    string   — Name of another setting ID whose truthy value shows this control.
 *   sanitize     string   — 'color' | 'text' | 'textarea' | 'checkbox' | 'url' | 'absint' | 'select'
 *   description  string   — Optional control description.
 *
 * @package Axiom\Customizer
 */

declare( strict_types=1 );

namespace Axiom\Customizer;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

abstract class Abstract_Section {

	protected const PANEL    = 'axiom_theme';
	protected const SETTINGS = [];

	abstract public function section_id(): string;
	abstract public function section_args(): array;

	public function register( \WP_Customize_Manager $wp_customize ): void {
		$wp_customize->add_section( $this->section_id(), $this->section_args() );

		foreach ( static::SETTINGS as $id => $config ) {
			$full_id  = 'axiom_' . $id;
			$has_var  = ! empty( $config['css_var'] );
			$transport = $config['transport'] ?? ( $has_var ? 'postMessage' : 'refresh' );

			$wp_customize->add_setting( $full_id, [
				'default'           => $config['default'] ?? '',
				'transport'         => $transport,
				'sanitize_callback' => $this->resolve_sanitizer( $config ),
			] );

			$control_args = [
				'label'       => $config['label'] ?? '',
				'description' => $config['description'] ?? '',
				'section'     => $this->section_id(),
				'settings'    => $full_id,
			];

			if ( isset( $config['active_cb'] ) ) {
				$dep_id = 'axiom_' . $config['active_cb'];
				$control_args['active_callback'] = static fn() => (bool) get_theme_mod( $dep_id );
			}

			$this->add_control( $wp_customize, $full_id, $config, $control_args );
		}
	}

	private function add_control(
		\WP_Customize_Manager $wp_customize,
		string $full_id,
		array $config,
		array $control_args
	): void {
		$type = $config['type'] ?? 'text';

		match ( $type ) {
			'color' => $wp_customize->add_control(
				new \WP_Customize_Color_Control( $wp_customize, $full_id, $control_args )
			),
			'image' => $wp_customize->add_control(
				new \WP_Customize_Image_Control( $wp_customize, $full_id, $control_args )
			),
			'media' => $wp_customize->add_control(
				new \WP_Customize_Media_Control( $wp_customize, $full_id, $control_args )
			),
			'range' => $wp_customize->add_control( $full_id, array_merge( $control_args, [
				'type'        => 'range',
				'input_attrs' => $config['input_attrs'] ?? [ 'min' => 0, 'max' => 100, 'step' => 1 ],
			] ) ),
			'select' => $wp_customize->add_control( $full_id, array_merge( $control_args, [
				'type'    => 'select',
				'choices' => $config['choices'] ?? [],
			] ) ),
			'radio' => $wp_customize->add_control( $full_id, array_merge( $control_args, [
				'type'    => 'radio',
				'choices' => $config['choices'] ?? [],
			] ) ),
			'textarea' => $wp_customize->add_control( $full_id, array_merge( $control_args, [
				'type' => 'textarea',
			] ) ),
			default => $wp_customize->add_control( $full_id, array_merge( $control_args, [
				'type' => $type,
			] ) ),
		};
	}

	public function css_variables(): string {
		$lines = [];
		foreach ( static::SETTINGS as $id => $config ) {
			if ( empty( $config['css_var'] ) ) {
				continue;
			}
			$value  = get_theme_mod( 'axiom_' . $id, $config['default'] ?? '' );
			$unit   = $config['unit'] ?? '';
			$lines[] = "\t{$config['css_var']}: {$value}{$unit};";
		}
		return implode( "\n", $lines );
	}

	public function preview_js(): string {
		$lines = [];
		foreach ( static::SETTINGS as $id => $config ) {
			if ( empty( $config['css_var'] ) ) {
				continue;
			}
			$setting_id = 'axiom_' . $id;
			$css_var    = $config['css_var'];
			$unit       = $config['unit'] ?? '';
			$lines[]    = <<<JS
			wp.customize('{$setting_id}',function(v){v.bind(function(val){document.documentElement.style.setProperty('{$css_var}',val+'{$unit}');});});
			JS;
		}
		return implode( "\n", $lines );
	}

	public function controls_js(): string {
		$lines = [];
		foreach ( static::SETTINGS as $id => $config ) {
			if ( empty( $config['active_cb'] ) ) {
				continue;
			}
			$dep_id    = 'axiom_' . $config['active_cb'];
			$ctrl_id   = 'axiom_' . $id;
			$lines[]   = <<<JS
			wp.customize('{$dep_id}',function(v){v.bind(function(val){wp.customize.control('{$ctrl_id}',function(ctrl){val?ctrl.activate():ctrl.deactivate();});});});
			JS;
		}
		return implode( "\n", $lines );
	}

	private function resolve_sanitizer( array $config ): callable {
		$type = $config['sanitize'] ?? $config['type'] ?? 'text';

		return match ( $type ) {
			'color'    => 'sanitize_hex_color',
			'checkbox' => static fn( $v ) => (bool) $v,
			'url'      => 'esc_url_raw',
			'absint'   => 'absint',
			'textarea' => 'sanitize_textarea_field',
			'select', 'radio' => $this->make_select_sanitizer( $config['choices'] ?? [] ),
			default    => 'sanitize_text_field',
		};
	}

	private function make_select_sanitizer( array $choices ): callable {
		return static function ( string $value ) use ( $choices ): string {
			return array_key_exists( $value, $choices ) ? $value : array_key_first( $choices );
		};
	}
}
