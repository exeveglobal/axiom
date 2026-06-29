<?php
/**
 * 404 template.
 *
 * @package Axiom
 */

declare( strict_types=1 );

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<main id="axiom-main" class="axiom-main" role="main">
	<section class="axiom-404">
		<h1 class="axiom-404__title"><?php esc_html_e( '404 — Page Not Found', 'axiom' ); ?></h1>
		<p class="axiom-404__message"><?php esc_html_e( 'The page you are looking for does not exist.', 'axiom' ); ?></p>
		<?php get_search_form(); ?>
	</section>
</main>
