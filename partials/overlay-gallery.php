<?php
$images = get_post_meta($post->ID, '_igv_album_images', true);
?>
<div id="overlay-gallery" class="grid-row align-items-center">
  <div id="overlay-gallery-swiper" class="swiper-container">
    <div id="overlay-gallery-swiper-wrapper" class="swiper-wrapper align-items-center">
    <?php
      if (!empty($images)) {
        /*
    ?>
      <div class="swiper-slide overlay-gallery-slide">
        <?php the_post_thumbnail('large', array('data-no-lazysizes' => 'true')); ?>
      </div>
    <?php
    */
        foreach ($images as $id => $url) {
    ?>
      <div class="swiper-slide overlay-gallery-slide">
        <?php echo wp_get_attachment_image($id, 'large', false, array('data-no-lazysizes' => 'true')); ?>
      </div>
    <?php
        }
      }
    ?>
    </div>
  </div>
  <div id="close-gallery-holder" class="padding-top-small padding-right-small">
    <div class="toggle-gallery">
      <?php get_template_part('assets/gallery-min.svg'); ?>
    </div>
  </div>
</div>
<?php
?>
