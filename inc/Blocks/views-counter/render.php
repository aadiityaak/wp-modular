<?php

use function WPModular\Utils\interactivity_data;

$attrs = [
  'postId' => get_the_ID(),
  'viewUrl' => rest_url('wp-modular/v1/views/' . get_the_ID()),
];

?>
<div
  data-wp-interactive="wp-modular"
  <?php echo interactivity_data($attrs); ?>
  data-wp-init="views/init">
  👁️ <span data-wp-text="state.viewCount">...</span> views
</div>