<?php
$featured_albums = get_post_meta($post->ID, '_igv_featured_albums', true);

if (!empty($featured_albums)) {
?>
<section  class="padding-top-mid padding-bottom-mid background-woodgrain">
  <?php get_template_part('assets/woodgrain.svg'); ?>
  <div class="swiper-container">
    <div class="swiper-wrapper align-items-center">
    <?php
      foreach ($featured_albums as $album_id) {
    ?>
      <article <?php post_class('swiper-slide album-featured-slide'); ?> id="post-<?php echo $album_id; ?>">
        <a href="<?php echo get_the_permalink($album_id); ?>">
          <?php echo get_the_post_thumbnail($album_id, 'full', array('data-no-lazysizes' => 'true')); ?>
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
