<?php
/**
 * Exit if accessed directly.
 *
 * @package vn-expert
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Main plugin class for VN Expert.
 *
 * @since 2.0.0
 */
class VN_Expert_Plugin {

	/**
	 * Plugin version
	 *
	 * @var string
	 */
	public $version = '2.2.0';

	/**
	 * Plugin directory path
	 *
	 * @var string
	 */
	private $plugin_path;

	/**
	 * Plugin directory URL
	 *
	 * @var string
	 */
	private $plugin_url;

	/**
	 * Constructor for the VN_Expert_Plugin class.
	 *
	 * @since 2.0.0
	 */
	public function __construct() {
		$this->plugin_path = plugin_dir_path( __DIR__ );
		$this->plugin_url  = plugin_dir_url( __DIR__ );

		$this->define_constants();
		$this->load_dependencies();
		$this->init_hooks();
	}

	/**
	 * Define plugin constants.
	 *
	 * @since 2.0.0
	 * @return void
	 */
	private function define_constants() {
		define( 'VN_EXPERT_PATH', $this->plugin_path );
		define( 'VN_EXPERT_URL', $this->plugin_url );
		define( 'VN_EXPERT_VERSION', '2.0.0' );
	}

	/**
	 * Load plugin dependencies.
	 *
	 * @since 2.0.0
	 * @return void
	 */
	private function load_dependencies() {
		require_once __DIR__ . '/class-vn-expert-shortcode.php';
		require_once VN_EXPERT_PATH . 'inc/builder.php';
	}

	/**
	 * Initialize plugin hooks.
	 *
	 * @since 2.0.0
	 * @return void
	 */
	private function init_hooks() {
		add_action( 'plugins_loaded', array( $this, 'load_textdomain' ) );
	}

	/**
	 * Load plugin text domain for translations.
	 *
	 * @since 2.0.0
	 * @return void
	 */
	public function load_textdomain() {
		load_plugin_textdomain( 'vn-expert', false, dirname( plugin_basename( $this->plugin_path ) ) . '/languages/' );
	}
}
