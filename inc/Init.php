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
    if (is_admin()) {
      // Register Gutenberg blocks (editor)
      if (file_exists(__DIR__ . '/Blocks/GalleryBlock.php')) {
        (new Blocks\GalleryBlock)->register();
      }
      if (file_exists(__DIR__ . '/Blocks/RelatedPostBlock.php')) {
        (new Blocks\RelatedPostBlock)->register();
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
