<?php
$featured_albums = get_post_meta($post->ID, '_igv_featured_albums', true);

if (!empty($featured_albums)) {
?>
<section>
  <div class="swiper-container">
    <div class="swiper-wrapper align-items-center">
    <?php
      foreach ($featured_albums as $album_id) {
    ?>
      <article <?php post_class('swiper-slide album-featured-slide'); ?> id="album-featured-<?php echo $album_id; ?>">
        <a href="<?php echo get_the_permalink($album_id); ?>">
          <?php echo get_the_post_thumbnail($album_id); ?>
        </a>
      </article>
    <?php
      }
    ?>
    </div>
  </div>
</section>
<?php
}
wp_reset_postdata();
