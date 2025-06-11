<?php

namespace WPModular\Blocks;

defined('ABSPATH') || exit;

class GalleryBlock
{
  public function register()
  {
    add_action('init', [$this, 'register_block']);
  }

  public function register_block()
  {
    $block_path = plugin_dir_path(__FILE__) . 'gallery';
    if (file_exists($block_path . '/block.json')) {
      register_block_type($block_path);
    }
  }
}
