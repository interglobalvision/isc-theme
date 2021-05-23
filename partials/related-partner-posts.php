<?php
$post_id = get_the_ID();
$partner_tag = get_post_meta($post->ID, '_igv_partner_tag', true);

$args = array(
  'post_type' => 'post',
  'post__not_in' => array($post_id),
  'posts_per_page' => 6,
  'orderby' => 'date',
  'tax_query' => array(
    'relation' => 'OR',
    array(
      'taxonomy' => 'post_tag',
      'field' => 'term_id',
      'terms' => $partner_tag,
    ),
    array(
      'taxonomy' => 'category',
      'field' => 'slug',
      'terms' => 'community',
    ),
  ),
);

$related_query = new WP_Query($args);

if ($related_query->have_posts()) {
?>

<section class="padding-top-basic padding-bottom-basic border-box border-sides-orange border-top-muck border-bottom-muck background-almond">

  <div class="container">
    <div class="grid-row">
      <div class="grid-item margin-bottom-basic">
        <h2 class="font-size-mid font-uppercase">Community</h2>
      </div>
    </div>
  </div>

  <div class="post-category-swiper swiper-container container grid-row hide">
    <div class="swiper-wrapper">
    <?php
      while ($related_query->have_posts()) {
        $related_query->the_post();
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
        <a class="link-underline" href="<?php echo get_term_link('community', 'category'); ?>">View Community Archive</a>
      </div>
    </div>
  </div>

</section>

<?php
}

wp_reset_postdata();
?>
