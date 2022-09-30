<?php

/**
 * Plugin Name:     DE for radius checker
 * Description:     Custom Plugin for Digital Envision Assesment Test
 * Version:         1.0.0
 * Author:          Hengky S,T
 * Author URI:      https://kiky1991.github.io
 * License:         GPL
 * Text Domain:     derc
 */

if (!defined('ABSPATH')) {
    exit;
}

// constants.
define('DERC_VERSION', '1.0.0');
define('DERC_PLUGIN_PATH', plugin_dir_path(__FILE__));
define('DERC_PLUGIN_URI', plugins_url(basename(plugin_dir_path(__FILE__)), basename(__FILE__)));

// load autoload && tools.
require_once DERC_PLUGIN_PATH . 'autoload.php';
require_once DERC_PLUGIN_PATH . 'vendor/autoload.php';

// load API
require_once DERC_PLUGIN_PATH . 'classes/api/openstreetmap.org.php';

if (!class_exists('DERC')) {

    class DERC
    {
        public function __construct()
        {
            new DERC_Front();
            new DERC_Admin();
            new DERC_Cli();
            new DERC_Ajax();

            register_activation_hook(__FILE__, array($this, 'on_plugin_activation'));
            add_action('plugins_loaded', array($this, 'on_plugin_loaded'));
        }

        public function on_plugin_activation()
        {
            // not used right now
        }
        
        public function on_plugin_loaded()
        {
            // not used right now
        }
    }

    new DERC();
}