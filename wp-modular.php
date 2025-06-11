<?php

/**
 * Plugin Name:       WP Modular
 * Plugin URI:        https://websweetstudio.com/wp-modular
 * Description:       Modular plugin for WordPress with blocks, site settings, and Interactivity API features.
 * Version:           1.0.0
 * Author:            AK @ WebSweetStudio
 * Author URI:        https://websweetstudio.com
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       wp-modular
 * Domain Path:       /languages
 */

defined('ABSPATH') || exit;

// Autoload classes (manual/simple PSR-4 style)
spl_autoload_register(function ($class) {
  if (strpos($class, 'WPModular\\') !== 0) {
    return;
  }

  $class_path = str_replace('\\', '/', substr($class, strlen('WPModular\\')));
  $file = plugin_dir_path(__FILE__) . 'inc/' . $class_path . '.php';

  if (file_exists($file)) {
    require $file;
  }
});

// Plugin bootstrap
add_action('plugins_loaded', function () {
  // You can initialize your core classes here
  (new \WPModular\Init)->run();
});
