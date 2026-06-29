<?php
/**
 * Comments template.
 *
 * @package Axiom
 */

declare( strict_types=1 );

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Do not display comments on password-protected posts.
if ( post_password_required() ) {
	return;
}
?>

<section id="comments" class="axiom-comments">

	<?php if ( have_comments() ) : ?>
		<h2 class="axiom-comments__title">
			<?php
			$count = (int) get_comments_number();
			if ( 1 === $count ) {
				printf(
					/* translators: %s: post title */
					esc_html__( 'One comment on &ldquo;%s&rdquo;', 'axiom' ),
					'<span>' . esc_html( get_the_title() ) . '</span>'
				);
			} else {
				printf(
					/* translators: 1: comment count, 2: post title */
					esc_html( _n( '%1$s comment on &ldquo;%2$s&rdquo;', '%1$s comments on &ldquo;%2$s&rdquo;', $count, 'axiom' ) ),
					esc_html( number_format_i18n( $count ) ),
					'<span>' . esc_html( get_the_title() ) . '</span>'
				);
			}
			?>
		</h2>

		<ol class="axiom-comments__list">
			<?php
			wp_list_comments( [
				'style'      => 'ol',
				'short_ping' => true,
				'avatar_size'=> 48,
				'callback'   => null,
			] );
			?>
		</ol>

		<?php the_comments_navigation(); ?>

	<?php endif; ?>

	<?php if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) : ?>
		<p class="axiom-comments__closed"><?php esc_html_e( 'Comments are closed.', 'axiom' ); ?></p>
	<?php endif; ?>

	<?php
	comment_form( [
		'class_form'           => 'axiom-comment-form',
		'class_submit'         => 'axiom-btn axiom-btn--primary',
		'comment_notes_before' => '',
	] );
	?>

</section>
