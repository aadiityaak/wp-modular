<?php
$images = $attributes['images'] ?? [];

if (empty($images)) {
  return '';
}

ob_start();
?>
<div class="wp-modular-gallery">
  <?php foreach ($images as $img) : ?>
    <img src="<?php echo esc_url($img['url']); ?>" style="width:150px; margin:5px;" />
  <?php endforeach; ?>
</div>
<?php
return ob_get_clean();
