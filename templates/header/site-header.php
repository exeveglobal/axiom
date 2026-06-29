<?php
/**
 * Site header template.
 *
 * @package Axiom
 */

declare( strict_types=1 );

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$layout    = get_theme_mod( 'axiom_header_layout', 'default' );
$full      = get_theme_mod( 'axiom_header_full_width', false );
$sticky    = get_theme_mod( 'axiom_header_sticky', false );
$autohide  = get_theme_mod( 'axiom_header_sticky_autohide', false );
$border    = get_theme_mod( 'axiom_header_border', false );
$breakpoint = (int) get_theme_mod( 'axiom_header_mobile_breakpoint', 768 );

$classes = array_filter( [
	'axiom-header',
	'layout-' . sanitize_html_class( $layout ),
	$full      ? 'is-full-width' : '',
	$sticky    ? 'is-sticky'     : '',
	$autohide  ? 'is-autohide'   : '',
	$border    ? 'has-border'    : '',
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
		$menu = wp_nav_menu( [
			'theme_location' => 'primary',
			'container'      => false,
			'fallback_cb'    => false,
			'echo'           => false,
			'menu_class'     => 'axiom-nav__list',
		] );
		?>

		<?php if ( $menu ) : ?>
			<nav class="axiom-nav axiom-nav--desktop" aria-label="<?php esc_attr_e( 'Primary navigation', 'axiom' ); ?>">
				<?php echo $menu; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped by wp_nav_menu ?>
			</nav>

			<button
				class="axiom-nav-toggle"
				aria-label="<?php esc_attr_e( 'Open menu', 'axiom' ); ?>"
				aria-expanded="false"
				aria-controls="axiom-mobile-nav"
				data-breakpoint="<?php echo esc_attr( $breakpoint ); ?>"
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
				<?php echo $menu; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			</nav>
		<?php endif; ?>

	</div>
</header>
