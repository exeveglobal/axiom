<?php
/**
 * Axiom Theme — Bootstrap
 *
 * @package Axiom
 */

declare( strict_types=1 );

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'AXIOM_VERSION', '1.1.0' );
define( 'AXIOM_PATH', get_template_directory() );
define( 'AXIOM_URL', get_template_directory_uri() );
define( 'AXIOM_SRC', AXIOM_PATH . '/src' );
define( 'AXIOM_ASSETS_URL', AXIOM_URL . '/assets' );
define( 'AXIOM_ASSETS_PATH', AXIOM_PATH . '/assets' );

require_once AXIOM_SRC . '/Core/Loader.php';
require_once AXIOM_PATH . '/inc/template-functions.php';

\Axiom\Core\Loader::register();

\Axiom\Theme::instance()->boot();
