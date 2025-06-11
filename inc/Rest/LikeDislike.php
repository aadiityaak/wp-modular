<?php

namespace WPModular\Rest;

class LikeDislike
{
  public function register_routes()
  {
    register_rest_route('wp-modular/v1', '/reaction/(?P<id>\d+)', [
      [
        'methods' => 'GET',
        'callback' => [$this, 'get_reaction'],
        'permission_callback' => '__return_true',
      ],
      [
        'methods' => 'POST',
        'callback' => [$this, 'add_reaction'],
        'permission_callback' => '__return_true',
      ],
    ]);
  }

  public function get_reaction($request)
  {
    $post_id = absint($request['id']);

    return rest_ensure_response([
      'like' => (int) get_post_meta($post_id, '_like_count', true),
      'dislike' => (int) get_post_meta($post_id, '_dislike_count', true),
    ]);
  }

  public function add_reaction($request)
  {
    $post_id = absint($request['id']);
    $type = sanitize_text_field($request->get_param('type')); // 'like' or 'dislike'

    if (!in_array($type, ['like', 'dislike'])) {
      return new \WP_Error('invalid_type', 'Type must be like or dislike', ['status' => 400]);
    }

    $meta_key = $type === 'like' ? '_like_count' : '_dislike_count';
    $count = (int) get_post_meta($post_id, $meta_key, true);
    $count++;
    update_post_meta($post_id, $meta_key, $count);

    return rest_ensure_response([
      'status' => 'success',
      'like' => (int) get_post_meta($post_id, '_like_count', true),
      'dislike' => (int) get_post_meta($post_id, '_dislike_count', true),
    ]);
  }
}
