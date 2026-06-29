<?php
/**
 * PSR-4 Autoloader for the Axiom namespace.
 *
 * @package Axiom\Core
 */

declare( strict_types=1 );

namespace Axiom\Core;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class Loader {

	private static bool $registered = false;

	public static function register(): void {
		if ( self::$registered ) {
			return;
		}

		spl_autoload_register( static function ( string $class ): void {
			if ( ! str_starts_with( $class, 'Axiom\\' ) ) {
				return;
			}

			$relative = substr( $class, strlen( 'Axiom\\' ) );
			$file     = AXIOM_SRC . '/' . str_replace( '\\', '/', $relative ) . '.php';

			if ( is_readable( $file ) ) {
				require_once $file;
			}
		} );

		self::$registered = true;
	}
}
