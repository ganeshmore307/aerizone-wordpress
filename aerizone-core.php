<?php
/**
 * Plugin Name: Aerizone Core
 * Plugin URI: https://aerizone.in/
 * Description: Brand styles, front-end enhancements, and Elementor support for the Aerizone website.
 * Version: 1.0.1
 * Author: Aerizone
 * Text Domain: aerizone-core
 */

if (!defined('ABSPATH')) {
    exit;
}

define('AERIZONE_CORE_VERSION', '1.0.1');
define('AERIZONE_CORE_URL', plugin_dir_url(__FILE__));

function aerizone_core_enqueue_assets() {
    wp_enqueue_style(
        'aerizone-core',
        AERIZONE_CORE_URL . 'assets/css/aerizone.css',
        array(),
        AERIZONE_CORE_VERSION
    );

    wp_enqueue_script(
        'aerizone-core',
        AERIZONE_CORE_URL . 'assets/js/aerizone.js',
        array(),
        AERIZONE_CORE_VERSION,
        true
    );
}
add_action('wp_enqueue_scripts', 'aerizone_core_enqueue_assets');

function aerizone_core_body_classes($classes) {
    $classes[] = 'aerizone-site';
    return $classes;
}
add_filter('body_class', 'aerizone_core_body_classes');
