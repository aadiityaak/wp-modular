<?php

namespace WPModular\Rest;

class Settings
{
  public function register_routes()
  {
    register_rest_route('wp-modular/v1', '/settings', [
      'methods' => 'POST',
      'callback' => [$this, 'save_settings'],
      'permission_callback' => function () {
        return current_user_can('manage_options');
      },
    ]);
  }

  public function save_settings($request)
  {
    $data = $request->get_json_params();
    update_option('wpmodular_options', [
      'enable_recaptcha' => !empty($data['enable_recaptcha']),
      'disable_comments' => !empty($data['disable_comments']),
    ]);
    return rest_ensure_response(['status' => 'saved']);
  }
}
