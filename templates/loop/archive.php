<?php
/**
 * Archive / home / search results template.
 *
 * @package Axiom
 */

declare( strict_types=1 );

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<?php get_template_part( 'templates/page-title-bar/page-title-bar' ); ?>

<main id="axiom-main" class="axiom-main" role="main">
	<?php if ( have_posts() ) : ?>
		<div class="axiom-archive">
			<?php while ( have_posts() ) : the_post(); ?>
				<article id="post-<?php the_ID(); ?>" <?php post_class( 'axiom-card' ); ?>>
					<?php if ( has_post_thumbnail() ) : ?>
						<a href="<?php the_permalink(); ?>" class="axiom-card__thumbnail" tabindex="-1" aria-hidden="true">
							<?php the_post_thumbnail( 'medium_large', [ 'loading' => 'lazy', 'alt' => '' ] ); ?>
						</a>
					<?php endif; ?>

					<div class="axiom-card__body">
						<header class="axiom-card__header">
							<h2 class="axiom-card__title">
								<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
							</h2>
							<time class="axiom-card__date" datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>">
								<?php echo esc_html( get_the_date() ); ?>
							</time>
						</header>

						<?php if ( has_excerpt() ) : ?>
							<div class="axiom-card__excerpt"><?php the_excerpt(); ?></div>
						<?php endif; ?>
					</div>
				</article>
			<?php endwhile; ?>
		</div>

		<?php get_template_part( 'templates/global/pagination' ); ?>

	<?php else : ?>
		<p class="axiom-no-results"><?php esc_html_e( 'No results found.', 'axiom' ); ?></p>
		<?php get_search_form(); ?>
	<?php endif; ?>
</main>
