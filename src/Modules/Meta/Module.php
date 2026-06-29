<?php
/**
 * Meta Module — registers the per-page/per-post metabox for page-specific overrides.
 *
 * @package Axiom\Modules\Meta
 */

declare( strict_types=1 );

namespace Axiom\Modules\Meta;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class Module {

	private const NONCE  = 'axiom_meta_nonce';
	private const PREFIX = '_axiom_';

	public function register(): void {
		add_action( 'add_meta_boxes', [ $this, 'add_meta_box' ] );
		add_action( 'save_post',      [ $this, 'save' ], 10, 2 );
	}

	public function add_meta_box(): void {
		$post_types = apply_filters( 'axiom_meta_post_types', [ 'page', 'post' ] );

		add_meta_box(
			'axiom-page-settings',
			esc_html__( 'Axiom Page Settings', 'axiom' ),
			[ $this, 'render' ],
			$post_types,
			'side',
			'default'
		);
	}

	public function render( \WP_Post $post ): void {
		wp_nonce_field( self::NONCE, self::NONCE );

		$fields = $this->fields();
		foreach ( $fields as $key => $field ) {
			$value = get_post_meta( $post->ID, self::PREFIX . $key, true );
			$this->render_field( $key, $field, $value );
		}
	}

	private function render_field( string $key, array $field, mixed $value ): void {
		$id = 'axiom_' . $key;
		echo '<p>';
		echo '<label for="' . esc_attr( $id ) . '"><strong>' . esc_html( $field['label'] ) . '</strong></label><br>';

		match ( $field['type'] ) {
			'checkbox' => printf(
				'<input type="checkbox" id="%s" name="%s" value="1" %s>',
				esc_attr( $id ),
				esc_attr( $id ),
				checked( $value, '1', false )
			),
			'select' => $this->render_select( $id, $field['options'], (string) $value ),
			'image'  => $this->render_image_picker( $id, (string) $value ),
			default  => printf(
				'<input type="text" id="%s" name="%s" value="%s" style="width:100%%">',
				esc_attr( $id ),
				esc_attr( $id ),
				esc_attr( (string) $value )
			),
		};

		if ( ! empty( $field['description'] ) ) {
			echo '<br><small>' . esc_html( $field['description'] ) . '</small>';
		}
		echo '</p>';
	}

	private function render_select( string $id, array $options, string $current ): void {
		echo '<select id="' . esc_attr( $id ) . '" name="' . esc_attr( $id ) . '" style="width:100%">';
		foreach ( $options as $val => $label ) {
			printf( '<option value="%s" %s>%s</option>', esc_attr( $val ), selected( $current, $val, false ), esc_html( $label ) );
		}
		echo '</select>';
	}

	private function render_image_picker( string $id, string $current ): void {
		printf(
			'<input type="hidden" id="%s" name="%s" value="%s">
			<button type="button" class="button" data-target="%s">%s</button>',
			esc_attr( $id ),
			esc_attr( $id ),
			esc_attr( $current ),
			esc_attr( $id ),
			esc_html__( 'Select Image', 'axiom' )
		);
		if ( $current ) {
			echo '<br><img src="' . esc_url( wp_get_attachment_image_url( (int) $current, 'thumbnail' ) ) . '" style="max-width:100%;margin-top:4px;">';
		}
	}

	public function save( int $post_id, \WP_Post $post ): void {
		if (
			! isset( $_POST[ self::NONCE ] )
			|| ! wp_verify_nonce( sanitize_key( $_POST[ self::NONCE ] ), self::NONCE )
			|| defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE
			|| ! current_user_can( 'edit_post', $post_id )
		) {
			return;
		}

		foreach ( $this->fields() as $key => $field ) {
			$input_key = 'axiom_' . $key;
			$raw       = $_POST[ $input_key ] ?? null;
			$value     = $this->sanitize_field( $field, $raw );

			if ( $value === '' || $value === null ) {
				delete_post_meta( $post_id, self::PREFIX . $key );
			} else {
				update_post_meta( $post_id, self::PREFIX . $key, $value );
			}
		}
	}

	private function sanitize_field( array $field, mixed $raw ): mixed {
		return match ( $field['type'] ) {
			'checkbox' => isset( $raw ) ? '1' : '',
			'select'   => array_key_exists( (string) $raw, $field['options'] ) ? (string) $raw : '',
			'image'    => $raw ? absint( $raw ) : '',
			default    => sanitize_text_field( (string) ( $raw ?? '' ) ),
		};
	}

	private function fields(): array {
		return [
			'hide_title_bar'   => [ 'type' => 'checkbox', 'label' => 'Hide Page Title Bar',      'description' => 'Overrides the global setting for this page.' ],
			'subtitle'         => [ 'type' => 'text',     'label' => 'Page Subtitle',             'description' => 'Displayed beneath the page title in the title bar.' ],
			'breadcrumb_label' => [ 'type' => 'text',     'label' => 'Custom Breadcrumb Label',   'description' => 'Replaces the auto-generated breadcrumb text for this page.' ],
			'body_class'       => [ 'type' => 'text',     'label' => 'Extra Body CSS Class',      'description' => 'Adds a custom class to <body> for this page only.' ],
		];
	}
}
