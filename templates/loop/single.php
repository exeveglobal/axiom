<?php
/**
 * Single post/page template.
 *
 * @package Axiom
 */

declare( strict_types=1 );

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

while ( have_posts() ) :
	the_post();
	?>
	<?php get_template_part( 'templates/page-title-bar/page-title-bar' ); ?>

	<main id="axiom-main" class="axiom-main" role="main">
		<article id="post-<?php the_ID(); ?>" <?php post_class( 'axiom-article' ); ?>>
			<div class="axiom-article__content">
				<?php the_content(); ?>
				<?php wp_link_pages(); ?>
			</div>

			<?php if ( has_tag() ) : ?>
				<footer class="axiom-article__footer">
					<div class="axiom-article__tags">
						<?php the_tags( '<span>' . esc_html__( 'Tags:', 'axiom' ) . ' </span>', ', ' ); ?>
					</div>
				</footer>
			<?php endif; ?>
		</article>

		<?php comments_template(); ?>
	</main>
	<?php
endwhile;
