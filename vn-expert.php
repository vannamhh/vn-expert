<?php
/**
 * Plugin Name: VN Expert
 * Plugin URI: https://wpmasterynow.com
 * Description: Custom expert shortcode for Flatsome theme
 * Version: 2.1.0
 * Author: Van Nam
 * Author URI: https://wpmasterynow.com
 * Text Domain: vn-expert
 * Domain Path: /languages
 */

// Exit if accessed directly
if (!defined('ABSPATH')) exit;

class VN_Expert_Plugin {
    
    public function __construct() {
        $this->define_constants();
        $this->load_dependencies();
        $this->init_hooks();
    }

    private function define_constants() {
        define('VN_EXPERT_PATH', plugin_dir_path(__FILE__));
        define('VN_EXPERT_URL', plugin_dir_url(__FILE__));
        define('VN_EXPERT_VERSION', '2.0.0');
    }

    private function load_dependencies() {
        require_once VN_EXPERT_PATH . 'inc/shortcode.php';
        require_once VN_EXPERT_PATH . 'inc/builder.php';
    }

    private function init_hooks() {
        add_action('init', array($this, 'load_textdomain'));
    }

    public function load_textdomain() {
        load_plugin_textdomain('vn-expert', false, dirname(plugin_basename(__FILE__)) . '/languages');
    }
}

// Initialize plugin
function vn_expert_init() {
    new VN_Expert_Plugin();
}
add_action('after_setup_theme', 'vn_expert_init');