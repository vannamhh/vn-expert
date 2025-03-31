<?php
/**
 * Plugin Name: VN Expert
 * Plugin URI: https://wpmasterynow.com
 * Description: Custom expert shortcode for Flatsome theme
 * Version: 2.2.0
 * Author: Van Nam
 * Author URI: https://wpmasterynow.com
 * Text Domain: vn-expert
 * Domain Path: /languages
 *
 * @package vn-expert
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Initialize plugin.
 *
 * @return void
 */
function vn_expert_init() {
	require_once plugin_dir_path( __FILE__ ) . 'inc/class-vn-expert-plugin.php';
	new VN_Expert_Plugin();
}
add_action( 'after_setup_theme', 'vn_expert_init' );
