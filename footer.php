<?php
/**
 * Site footer — closes #axiom-content, renders footer template, closes <body>.
 *
 * @package Axiom
 */

declare( strict_types=1 );

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
</div><!-- #axiom-content -->

<?php get_template_part( 'templates/footer/site-footer' ); ?>

<?php wp_footer(); ?>
</body>
</html>
