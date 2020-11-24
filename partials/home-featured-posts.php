<?php
global $featured_posts;

$args = array(
  'post_type' => array('post'),
  'posts_per_page' => 2,
);

$query = new WP_Query($args);

if ($query->have_posts()) {
?>
<section class="padding-top-basic padding-bottom-small border-box background-almond">
  <div class="container">
    <div class="grid-row">
      <div class="grid-item item-s-12 margin-bottom-basic">
        <h2 class="font-size-mid font-uppercase">Recent Editorial</h2>
      </div>
    </div>
    <div class="grid-row">
<?php
  while ($query->have_posts()) {
    $query->the_post();

    array_push($featured_posts, $post->ID);

    get_template_part('partials/post-item');
  }
?>
    </div>
  </div>
</section>
<?php
}
wp_reset_postdata();
