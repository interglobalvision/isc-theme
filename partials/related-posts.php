<?php
$post_id = get_the_ID();
$post_cats = wp_get_post_categories($post_id);

$args = array(
  'post_type' => 'post',
  'category__in' => $post_cats,
  'post__not_in' => array($post_id),
  'posts_per_page' => 6,
  'orderby' => 'date',
);

$query = new WP_Query($args);

if ($query->have_posts()) {
?>

<section class="padding-top-basic padding-bottom-basic border-box background-almond">

  <div class="container">
    <div class="grid-row">
      <div class="grid-item margin-bottom-basic">
        <h2 class="font-size-mid font-uppercase">Related Articles</h2>
      </div>
    </div>
  </div>

  <div class="post-category-swiper swiper-container container grid-row hide">
    <div class="swiper-wrapper">
    <?php
      while ($query->have_posts()) {
        $query->the_post();
    ?>
      <div class="post-category-slide swiper-slide">
        <?php get_template_part('partials/post-item'); ?>
      </div>
    <?php
      }
    ?>
    </div>
    <div class="swiper-scrollbar"></div>
  </div>

  <div class="container">
    <div class="grid-row justify-end margin-top-basic">
      <div class="grid-item">
        <a class="link-underline" href="<?php echo home_url('features'); ?>">View Features Archive</a>
      </div>
    </div>
  </div>

</section>

<?php
}

wp_reset_postdata();
?>
