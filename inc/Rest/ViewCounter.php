<?php

namespace WPModular\Rest;

class ViewCounter
{
  public function register_routes()
  {
    register_rest_route('wp-modular/v1', '/views/(?P<id>\d+)', [
      [
        'methods' => 'GET',
        'callback' => [$this, 'get_views'],
        'permission_callback' => '__return_true',
      ],
      [
        'methods' => 'POST',
        'callback' => [$this, 'increment_views'],
        'permission_callback' => '__return_true',
      ]
    ]);
  }

  public function get_views($request)
  {
    $post_id = absint($request['id']);
    $views = (int) get_post_meta($post_id, '_views', true);
    return rest_ensure_response(['views' => $views]);
  }

  public function increment_views($request)
  {
    $post_id = absint($request['id']);
    $views = (int) get_post_meta($post_id, '_views', true);
    $views++;
    update_post_meta($post_id, '_views', $views);

    return rest_ensure_response(['views' => $views]);
  }
}
