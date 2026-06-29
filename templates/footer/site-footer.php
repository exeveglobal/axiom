<?php
/**
 * Site footer template.
 *
 * @package Axiom
 */

declare( strict_types=1 );

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$layout      = get_theme_mod( 'axiom_footer_layout', 'default' );
$full        = get_theme_mod( 'axiom_footer_full_width', false );
$border      = get_theme_mod( 'axiom_footer_border', true );
$show_logo   = get_theme_mod( 'axiom_footer_show_logo', true );
$show_nav    = get_theme_mod( 'axiom_footer_show_nav', true );
$show_copy   = get_theme_mod( 'axiom_footer_show_copyright', true );
$copy_text   = get_theme_mod( 'axiom_footer_copyright_text', '© {year} EXEVE. All rights reserved.' );
$copy_text   = str_replace( '{year}', (string) gmdate( 'Y' ), $copy_text );

$classes = array_filter( [
	'axiom-footer',
	'layout-' . sanitize_html_class( $layout ),
	$full   ? 'is-full-width' : '',
	$border ? 'has-border'    : '',
] );
?>
<footer id="axiom-footer" class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>" role="contentinfo">
	<div class="axiom-footer__inner">

		<?php if ( $show_logo ) : ?>
			<div class="axiom-footer__branding">
				<?php if ( has_custom_logo() ) : ?>
					<?php the_custom_logo(); ?>
				<?php else : ?>
					<span class="axiom-footer__site-name"><?php bloginfo( 'name' ); ?></span>
				<?php endif; ?>
			</div>
		<?php endif; ?>

		<?php if ( $show_nav && has_nav_menu( 'footer' ) ) : ?>
			<nav class="axiom-footer__nav" aria-label="<?php esc_attr_e( 'Footer navigation', 'axiom' ); ?>">
				<?php wp_nav_menu( [
					'theme_location' => 'footer',
					'container'      => false,
					'fallback_cb'    => false,
					'menu_class'     => 'axiom-footer__nav-list',
				] ); ?>
			</nav>
		<?php endif; ?>

		<?php if ( $show_copy && $copy_text ) : ?>
			<div class="axiom-footer__copyright">
				<p><?php echo wp_kses_post( $copy_text ); ?></p>
			</div>
		<?php endif; ?>

	</div>
</footer>
