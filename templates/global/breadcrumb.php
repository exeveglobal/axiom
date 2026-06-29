<?php
/**
 * Breadcrumb template — outputs semantic nav + feeds the Schema module's BreadcrumbList.
 *
 * @package Axiom
 */

declare( strict_types=1 );

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$post_id       = get_queried_object_id();
$custom_label  = get_post_meta( $post_id, '_axiom_breadcrumb_label', true );
$crumbs        = [];

$crumbs[] = [ 'label' => get_bloginfo( 'name' ), 'url' => home_url( '/' ) ];

if ( is_singular() ) {
	if ( is_singular( 'post' ) ) {
		$cats = get_the_category();
		if ( $cats ) {
			$crumbs[] = [ 'label' => $cats[0]->name, 'url' => get_category_link( $cats[0]->term_id ) ];
		}
	}
	$crumbs[] = [ 'label' => $custom_label ?: get_the_title(), 'url' => '' ];
} elseif ( is_archive() ) {
	$crumbs[] = [ 'label' => $custom_label ?: get_the_archive_title(), 'url' => '' ];
} elseif ( is_search() ) {
	$crumbs[] = [ 'label' => sprintf( esc_html__( 'Search: %s', 'axiom' ), get_search_query() ), 'url' => '' ];
}

if ( count( $crumbs ) <= 1 ) {
	return;
}
?>
<nav class="axiom-breadcrumb" aria-label="<?php esc_attr_e( 'Breadcrumb', 'axiom' ); ?>">
	<ol class="axiom-breadcrumb__list" itemscope itemtype="https://schema.org/BreadcrumbList">
		<?php foreach ( $crumbs as $index => $crumb ) : ?>
			<li class="axiom-breadcrumb__item" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
				<?php if ( $crumb['url'] ) : ?>
					<a href="<?php echo esc_url( $crumb['url'] ); ?>" itemprop="item" class="axiom-breadcrumb__link">
						<span itemprop="name"><?php echo esc_html( $crumb['label'] ); ?></span>
					</a>
				<?php else : ?>
					<span itemprop="name" aria-current="page"><?php echo esc_html( $crumb['label'] ); ?></span>
				<?php endif; ?>
				<meta itemprop="position" content="<?php echo esc_attr( (string) ( $index + 1 ) ); ?>">
			</li>
		<?php endforeach; ?>
	</ol>
</nav>
