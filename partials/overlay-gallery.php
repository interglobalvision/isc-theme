<?php
$images = get_post_meta($post->ID, '_igv_album_images', true);
if (!empty($images)) {
?>
<div id="overlay-gallery">
  <div class="swiper-container">
    <div class="swiper-wrapper align-items-center">
    <?php
      foreach ($images as $id => $url) {
    ?>
      <div class="swiper-slide">
        <?php echo wp_get_attachment_image($id, 'full'); ?>
      </div>
    <?php
      }
    ?>
    </div>
  </div>
  <div id="close-gallery-holder" class="padding-top-small padding-right-small">
    <div class="toggle-gallery">Close</div>
  </div>
</div>
<?php
}
?>
