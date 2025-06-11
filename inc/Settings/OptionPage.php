<?php

namespace WPModular\Settings;

defined('ABSPATH') || exit;

class OptionPage
{
  protected string $option_name = 'wp_modular_options';

  public function register(): void
  {
    add_action('admin_menu', [$this, 'add_menu_page']);
    add_action('rest_api_init', [$this, 'register_rest']);
  }

  public function add_menu_page(): void
  {
    add_menu_page(
      'WP Modular Settings',
      'WP Modular',
      'manage_options',
      'wp-modular-settings',
      [$this, 'render_page'],
      'dashicons-admin-generic'
    );
  }

  public function render_page(): void
  {
    $options = get_option($this->option_name, []);
?>
    <div class="wrap" x-data="settingsForm()" class="p-6">
      <h1 class="text-2xl font-bold mb-4">WP Modular Settings</h1>
      <form @submit.prevent="save" class="space-y-4">
        <div>
          <label class="inline-flex items-center space-x-2">
            <input type="checkbox" x-model="form.enable_recaptcha" class="form-checkbox text-blue-600">
            <span>Enable reCAPTCHA</span>
          </label>
        </div>

        <div>
          <label class="inline-flex items-center space-x-2">
            <input type="checkbox" x-model="form.disable_comments" class="form-checkbox text-blue-600">
            <span>Disable Comments</span>
          </label>
        </div>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
          Save Settings
        </button>
        <span x-text="message" class="ml-4 text-green-600"></span>
      </form>
    </div>

    <script>
      function settingsForm() {
        return {
          form: {
            enable_recaptcha: <?= json_encode(!empty($options['enable_recaptcha'])) ?>,
            disable_comments: <?= json_encode(!empty($options['disable_comments'])) ?>
          },
          message: '',
          save() {
            fetch("<?= esc_url(rest_url('wp-modular/v1/settings')) ?>", {
                method: 'POST',
                headers: {
                  'Content-Type': 'application/json',
                  'X-WP-Nonce': wpApiSettings.nonce
                },
                body: JSON.stringify(this.form)
              })
              .then(res => res.json())
              .then(data => this.message = "Saved!")
              .catch(err => this.message = "Error saving.");
          }
        };
      }
    </script>
<?php
  }

  public function register_rest(): void
  {
    register_rest_route('wp-modular/v1', '/settings', [
      'methods' => 'POST',
      'permission_callback' => function () {
        return current_user_can('manage_options');
      },
      'callback' => function ($request) {
        $data = $request->get_json_params();
        $sanitized = [
          'enable_recaptcha' => !empty($data['enable_recaptcha']),
          'disable_comments' => !empty($data['disable_comments']),
        ];
        update_option($this->option_name, $sanitized);
        return rest_ensure_response(['success' => true]);
      }
    ]);
  }
}
