<?php
/**
 * Site header template — logo left, primary nav right.
 *
 * @package Axiom
 */

declare( strict_types=1 );

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$sticky   = get_theme_mod( 'axiom_header_sticky', false );
$autohide = get_theme_mod( 'axiom_header_sticky_autohide', false );

$classes = array_filter( [
	'axiom-header',
	$sticky   ? 'is-sticky'   : '',
	$autohide ? 'is-autohide' : '',
] );
?>
<header id="axiom-header" class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>" role="banner">
	<div class="axiom-header__inner">

		<div class="axiom-header__branding">
			<?php if ( has_custom_logo() ) : ?>
				<?php the_custom_logo(); ?>
			<?php else : ?>
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="axiom-header__site-name" rel="home">
					<?php bloginfo( 'name' ); ?>
				</a>
			<?php endif; ?>
		</div>

		<?php
		$menu_html = wp_nav_menu( [
			'theme_location' => 'primary',
			'container'      => false,
			'fallback_cb'    => false,
			'echo'           => false,
			'menu_class'     => 'axiom-nav__list',
		] );
		?>

		<?php if ( $menu_html ) : ?>
			<nav class="axiom-nav axiom-nav--desktop" aria-label="<?php esc_attr_e( 'Primary navigation', 'axiom' ); ?>">
				<?php echo $menu_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			</nav>

			<button
				class="axiom-nav-toggle"
				aria-label="<?php esc_attr_e( 'Toggle navigation', 'axiom' ); ?>"
				aria-expanded="false"
				aria-controls="axiom-mobile-nav"
			>
				<span class="axiom-nav-toggle__icon" aria-hidden="true"></span>
			</button>

			<nav
				id="axiom-mobile-nav"
				class="axiom-nav axiom-nav--mobile"
				aria-label="<?php esc_attr_e( 'Mobile navigation', 'axiom' ); ?>"
				aria-hidden="true"
				inert
			>
				<?php echo $menu_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			</nav>
		<?php endif; ?>

	</div>
</header>
