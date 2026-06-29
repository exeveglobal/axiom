<?php
/**
 * Site header — <head> + opening <body> tag + site-header markup.
 *
 * @package Axiom
 */

declare( strict_types=1 );

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class( axiom_body_classes() ); ?>>
<?php wp_body_open(); ?>

<a class="axiom-skip-link screen-reader-text" href="#axiom-content"><?php esc_html_e( 'Skip to content', 'axiom' ); ?></a>

<?php get_template_part( 'templates/header/site-header' ); ?>

<div id="axiom-content" class="axiom-site-content">
