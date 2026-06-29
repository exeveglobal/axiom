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

/**
 * Returns the page title, accounting for archive context.
 */
function axiom_page_title(): string {
	if ( is_archive() ) {
		return get_the_archive_title();
	}
	if ( is_search() ) {
		return sprintf(
			/* translators: %s: search query */
			esc_html__( 'Search: %s', 'axiom' ),
			get_search_query()
		);
	}
	return (string) get_the_title();
}
