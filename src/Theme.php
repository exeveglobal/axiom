<?php
/**
 * Theme bootstrap — the single entry point that wires everything together.
 *
 * @package Axiom
 */

declare( strict_types=1 );

namespace Axiom;

use Axiom\Core\Hook_Manager;
use Axiom\Assets\Manager as Asset_Manager;
use Axiom\Customizer\Manager as Customizer_Manager;
use Axiom\Modules\Performance\Module as Performance_Module;
use Axiom\Modules\Schema\Module as Schema_Module;
use Axiom\Modules\Meta\Module as Meta_Module;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class Theme {

	private static ?self $instance = null;

	private Hook_Manager $hooks;

	private function __construct() {
		$this->hooks = new Hook_Manager();
	}

	public static function instance(): self {
		return self::$instance ??= new self();
	}

	public function boot(): void {
		$assets     = new Asset_Manager();
		$customizer = new Customizer_Manager();

		$this->hooks
			->action( 'after_setup_theme', [ $this, 'setup' ] )
			->action( 'after_setup_theme', [ $this, 'content_width' ], 0 )
			->action( 'wp_enqueue_scripts', [ $assets, 'enqueue_frontend' ] )
			->action( 'admin_enqueue_scripts', [ $assets, 'enqueue_admin' ] )
			->action( 'customize_register', [ $customizer, 'register' ] )
			->action( 'customize_preview_init', [ $customizer, 'enqueue_preview' ] )
			->action( 'customize_controls_enqueue_scripts', [ $customizer, 'enqueue_controls' ] )
			->action( 'wp_head', [ $customizer, 'output_css_variables' ], 5 )
			->register();

		( new Performance_Module() )->register();
		( new Schema_Module() )->register();
		( new Meta_Module() )->register();
	}

	public function setup(): void {
		load_theme_textdomain( 'axiom', AXIOM_PATH . '/languages' );

		add_theme_support( 'title-tag' );
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'align-wide' );
		add_theme_support( 'responsive-embeds' );
		add_theme_support( 'editor-styles' );
		add_theme_support( 'html5', [
			'search-form', 'comment-form', 'comment-list',
			'gallery', 'caption', 'script', 'style', 'navigation-widgets',
		] );
		add_theme_support( 'custom-logo', [
			'height'      => 120,
			'width'       => 400,
			'flex-height' => true,
			'flex-width'  => true,
		] );

		add_editor_style( 'assets/css/editor.css' );

		register_nav_menus( [
			'primary' => esc_html__( 'Primary Navigation', 'axiom' ),
			'footer'  => esc_html__( 'Footer Navigation', 'axiom' ),
		] );
	}

	public function content_width(): void {
		$GLOBALS['content_width'] = (int) get_theme_mod( 'axiom_content_width', 800 );
	}

	public function __clone() {
		_doing_it_wrong( __FUNCTION__, 'Cloning Theme is forbidden.', '1.0.0' ); // phpcs:ignore
	}

	public function __wakeup() {
		_doing_it_wrong( __FUNCTION__, 'Unserializing Theme is forbidden.', '1.0.0' ); // phpcs:ignore
	}
}
