<?php

namespace WPModular\Admin;

defined('ABSPATH') || exit;

class AdminAssets
{
  protected string $page_slug = 'wp-modular-settings';

  public function register(): void
  {
    add_action('admin_enqueue_scripts', [$this, 'enqueue']);
  }

  public function enqueue(): void
  {
    $screen = get_current_screen();

    // Hanya load jika di halaman plugin settings
    if (!$screen || $screen->base !== 'toplevel_page_' . $this->page_slug) {
      return;
    }

    wp_enqueue_script(
      'alpine',
      'https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js',
      [],
      null,
      true
    );

    wp_enqueue_style(
      'tailwind',
      'https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css'
    );

    // Inject nonce ke JS
    wp_add_inline_script('alpine', 'window.wpApiSettings = ' . json_encode([
      'nonce' => wp_create_nonce('wp_rest'),
    ]) . ';', 'before');
  }
}
