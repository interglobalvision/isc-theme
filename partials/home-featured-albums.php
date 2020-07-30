<?php
$featured_albums = get_post_meta($post->ID, '_igv_featured_albums', true);
?>

<section class="background-woodgrain">

  <?php get_template_part('assets/woodgrain.svg'); ?>

<?php
if (!empty($featured_albums)) {
?>

  <div id="featured-albums-swiper" class="swiper-container padding-top-mid padding-bottom-mid grid-row align-items-center hide">
    <div class="swiper-wrapper align-items-center">
    <?php
      foreach ($featured_albums as $album_id) {
    ?>
      <article <?php post_class('swiper-slide album-featured-slide text-align-center'); ?> id="post-<?php echo $album_id; ?>">
        <a href="<?php echo get_the_permalink($album_id); ?>">
          <?php echo get_the_post_thumbnail($album_id, 'full', array('data-no-lazysizes' => 'true')); ?>
          <img src="<?php bloginfo('stylesheet_directory'); ?>/dist/img/player-info.png" class="slide-info-icon"/>
        </a>
      </article>
    <?php
      }
    ?>
    </div>
  </div>

<?php
}
?>
</section>
