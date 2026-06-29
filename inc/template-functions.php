<?php
/**
 * Template helper functions used in template files.
 *
 * @package Axiom
 */

declare( strict_types=1 );

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Returns extra body classes from the per-page meta setting.
 */
function axiom_body_classes(): array {
	$classes = [];

	if ( is_singular() ) {
		$extra = get_post_meta( get_queried_object_id(), '_axiom_body_class', true );
		if ( $extra ) {
			$classes[] = sanitize_html_class( $extra );
		}
	}

	return $classes;
}
