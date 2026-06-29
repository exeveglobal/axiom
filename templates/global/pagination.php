<?php
/**
 * Pagination template.
 *
 * @package Axiom
 */

declare( strict_types=1 );

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

the_posts_pagination( [
	'mid_size'           => 2,
	'prev_text'          => esc_html__( '&larr; Previous', 'axiom' ),
	'next_text'          => esc_html__( 'Next &rarr;', 'axiom' ),
	'before_page_number' => '<span class="screen-reader-text">' . esc_html__( 'Page ', 'axiom' ) . '</span>',
] );
