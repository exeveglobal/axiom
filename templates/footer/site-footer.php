<?php
/**
 * Site footer template — 4 widget columns + copyright bar.
 *
 * @package Axiom
 */

declare( strict_types=1 );

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$copyright = get_theme_mod( 'axiom_footer_copyright_text', '© {year}. All rights reserved.' );
$copyright = str_replace( '{year}', (string) gmdate( 'Y' ), $copyright );

$has_widgets = is_active_sidebar( 'footer-1' )
	|| is_active_sidebar( 'footer-2' )
	|| is_active_sidebar( 'footer-3' )
	|| is_active_sidebar( 'footer-4' );
?>
<footer id="axiom-footer" class="axiom-footer" role="contentinfo">

	<?php if ( $has_widgets ) : ?>
		<div class="axiom-footer__widgets">
			<?php for ( $i = 1; $i <= 4; $i++ ) : ?>
				<?php if ( is_active_sidebar( 'footer-' . $i ) ) : ?>
					<div class="axiom-footer__col">
						<?php dynamic_sidebar( 'footer-' . $i ); ?>
					</div>
				<?php endif; ?>
			<?php endfor; ?>
		</div>
	<?php endif; ?>

	<div class="axiom-footer__bottom">
		<?php if ( $copyright ) : ?>
			<p><?php echo wp_kses_post( $copyright ); ?></p>
		<?php endif; ?>
	</div>

</footer>
