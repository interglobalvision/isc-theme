<?php
$selection = get_post_meta($post->ID, '_igv_post_selection', true);
$selection_name = get_post_meta($post->ID, '_igv_post_selection_name', true);

if (!empty($selection)) {
?>

<section class="border-box background-woodgrain padding-top-basic padding-bottom-basic ">

  <?php get_template_part('assets/woodgrain.svg'); ?>

<?php if (!empty($selection_name)) { ?>
  <div class="container">
    <div class="grid-row">
      <div class="grid-item margin-bottom-basic">
        <span class="font-size-small font-color-grey"><?php echo $selection_name; ?></span>
      </div>
    </div>
  </div>
<?php } ?>

  <div id="post-selection-swiper" class="swiper-container container grid-row align-items-center hide">
    <div class="swiper-wrapper grid-item align-items-center">
    <?php
      foreach ($selection as $album_id) {
    ?>
      <article <?php post_class('swiper-slide post-selection-slide text-align-center'); ?> id="post-<?php echo $album_id; ?>">
        <a href="<?php echo get_the_permalink($album_id); ?>">
          <?php echo get_the_post_thumbnail($album_id, 'full', array('data-no-lazysizes' => 'true')); ?>
          <div class="slide-info-icon"><?php get_template_part('assets/info.svg'); ?></div>
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
?>
