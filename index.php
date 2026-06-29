<?php
/**
 * Theme entry point — routes to the correct template part.
 *
 * @package Axiom
 */

declare( strict_types=1 );

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

if ( is_singular() ) {
	get_template_part( 'templates/loop/single' );
} elseif ( is_archive() || is_home() || is_search() ) {
	get_template_part( 'templates/loop/archive' );
} else {
	get_template_part( 'templates/loop/404' );
}

get_footer();
