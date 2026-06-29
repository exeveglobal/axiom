<?php
/**
 * Page Title Bar template.
 * Checks per-page meta overrides first, then falls back to global Customizer settings.
 *
 * @package Axiom
 */

declare( strict_types=1 );

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$post_id = get_queried_object_id();

$global_enabled = get_theme_mod( 'axiom_ptb_enabled', true );
$page_hidden    = '1' === get_post_meta( $post_id, '_axiom_hide_title_bar', true );

if ( ! $global_enabled || $page_hidden ) {
	return;
}

$title      = is_archive() ? get_the_archive_title() : get_the_title();
$subtitle   = get_post_meta( $post_id, '_axiom_subtitle', true );
$alignment  = get_theme_mod( 'axiom_ptb_alignment', 'left' );
$breadcrumb = get_theme_mod( 'axiom_ptb_breadcrumb', true );
$bg_type    = get_theme_mod( 'axiom_ptb_bg_type', 'color' );

// Per-page bg image overrides global
$page_bg_image_id = get_post_meta( $post_id, '_axiom_ptb_bg_image', true );
$bg_image_url     = $page_bg_image_id
	? wp_get_attachment_image_url( (int) $page_bg_image_id, 'full' )
	: '';

$inline_style = '';
if ( 'image' === $bg_type && $bg_image_url ) {
	$inline_style = ' style="background-image:url(' . esc_url( $bg_image_url ) . ')"';
}

$overlay = get_theme_mod( 'axiom_ptb_overlay', false );
?>
<section
	class="axiom-ptb axiom-ptb--<?php echo esc_attr( $alignment ); ?> axiom-ptb--<?php echo esc_attr( $bg_type ); ?>"
	aria-label="<?php esc_attr_e( 'Page title', 'axiom' ); ?>"
	<?php echo $inline_style; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
>
	<?php if ( $overlay ) : ?>
		<div class="axiom-ptb__overlay" aria-hidden="true"></div>
	<?php endif; ?>

	<div class="axiom-ptb__inner">
		<?php if ( $breadcrumb ) : ?>
			<?php get_template_part( 'templates/global/breadcrumb' ); ?>
		<?php endif; ?>

		<h1 class="axiom-ptb__title"><?php echo esc_html( $title ); ?></h1>

		<?php if ( $subtitle ) : ?>
			<p class="axiom-ptb__subtitle"><?php echo esc_html( $subtitle ); ?></p>
		<?php endif; ?>
	</div>
</section>
