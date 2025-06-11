<?php

namespace WPModular\Blocks;

abstract class BlockBase
{
  protected $slug; // block slug, e.g., "views-counter"
  protected $namespace = 'wp-modular'; // default block namespace

  public function register()
  {
    add_action('init', [$this, 'register_block']);
  }

  public function register_block()
  {
    if (!$this->slug) {
      return;
    }

    $dir = dirname(__FILE__) . '/' . $this->slug;

    if (file_exists($dir . '/block.json')) {
      register_block_type($dir);
    }
  }

  public function get_name()
  {
    return "{$this->namespace}/{$this->slug}";
  }
}
