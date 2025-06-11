<?php

namespace WPModular;

defined('ABSPATH') || exit;

class Init
{
  public function run()
  {
    // Load all modules
    $this->load_blocks();
    $this->load_settings();
    $this->load_rest_api();
  }

  protected function load_blocks()
  {
    foreach (glob(__DIR__ . '/Blocks/*Block.php') as $file) {
      require_once $file;
      $class = __NAMESPACE__ . '\\Blocks\\' . basename($file, '.php');
      if (class_exists($class)) {
        (new $class)->register();
      }
    }
  }


  protected function load_settings()
  {
    if (is_admin()) {
      if (file_exists(__DIR__ . '/Settings/OptionPage.php')) {
        (new Settings\OptionPage)->register();
      }
      if (file_exists(__DIR__ . '/Settings/SeoSettings.php')) {
        (new Settings\SeoSettings)->register();
      }
    }
  }

  protected function load_rest_api()
  {
    add_action('rest_api_init', function () {
      if (file_exists(__DIR__ . '/Rest/ViewCounter.php')) {
        (new Rest\ViewCounter)->register_routes();
      }
      if (file_exists(__DIR__ . '/Rest/LikeDislike.php')) {
        (new Rest\LikeDislike)->register_routes();
      }
    });
  }
}
