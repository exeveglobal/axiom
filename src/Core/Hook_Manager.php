<?php
/**
 * Centralised hook registration.
 * Modules call Hook_Manager::add() instead of scattering add_action/add_filter calls.
 *
 * @package Axiom\Core
 */

declare( strict_types=1 );

namespace Axiom\Core;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class Hook_Manager {

	/** @var array<array{type:string, hook:string, callback:callable, priority:int, args:int}> */
	private array $hooks = [];

	public function action( string $hook, callable $callback, int $priority = 10, int $args = 1 ): self {
		$this->hooks[] = [ 'type' => 'action', 'hook' => $hook, 'callback' => $callback, 'priority' => $priority, 'args' => $args ];
		return $this;
	}

	public function filter( string $hook, callable $callback, int $priority = 10, int $args = 1 ): self {
		$this->hooks[] = [ 'type' => 'filter', 'hook' => $hook, 'callback' => $callback, 'priority' => $priority, 'args' => $args ];
		return $this;
	}

	public function register(): void {
		foreach ( $this->hooks as $h ) {
			match ( $h['type'] ) {
				'action' => add_action( $h['hook'], $h['callback'], $h['priority'], $h['args'] ),
				'filter' => add_filter( $h['hook'], $h['callback'], $h['priority'], $h['args'] ),
			};
		}
	}
}
