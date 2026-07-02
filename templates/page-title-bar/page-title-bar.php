<?php
/**
 * Page Title Bar template.
 *
 * @package Axiom
 */

declare( strict_types=1 );

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$post_id = get_queried_object_id();

if ( ! get_theme_mod( 'axiom_ptb_enabled', true ) ) {
	return;
}

if ( is_front_page() && get_theme_mod( 'axiom_ptb_hide_on_front', true ) ) {
	return;
}

if ( '1' === get_post_meta( $post_id, '_axiom_hide_title_bar', true ) ) {
	return;
}

$title      = is_archive() ? get_the_archive_title() : get_the_title();
$subtitle   = (string) get_post_meta( $post_id, '_axiom_subtitle', true );
$alignment  = get_theme_mod( 'axiom_ptb_alignment', 'left' );
$breadcrumb = get_theme_mod( 'axiom_ptb_breadcrumb', true );

$label = (string) get_post_meta( $post_id, '_axiom_breadcrumb_label', true );
?>
<section
	class="axiom-ptb axiom-ptb--<?php echo esc_attr( $alignment ); ?>"
	aria-label="<?php esc_attr_e( 'Page title', 'axiom' ); ?>"
>
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
