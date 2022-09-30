<?php

/**
 * Autoload inside each apps
 * 
 * @since v1.0.0-alpha
 */
spl_autoload_register(function ($class) {
    $path = str_replace('_', '-', strtolower($class));
    $file = plugin_dir_path(__FILE__) . "classes/class-{$path}.php";

    if (file_exists($file)) {
        require_once $file;
    }
});