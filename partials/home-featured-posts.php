<section class="padding-top-basic padding-bottom-small border-box background-almond">
  <div class="container">
    <div class="grid-row">
      <div class="grid-item item-s-12 margin-bottom-basic">
        <h2 class="font-size-mid font-uppercase">Featured</h2>
      </div>
    </div>
  </div>

<?php
$featured_posts = array();

$args = array(
  'post_type' => 'post',
  'is_category' => 'feature',
  'posts_per_page' => 1
);

$query = new WP_Query($args);

if ($query->have_posts()) {
?>
  <div class="container">
    <div class="grid-row">
<?php
  while ($query->have_posts()) {
    $query->the_post();

    array_push($featured_posts, $post->ID);

    get_template_part('partials/post-item-first');
  }
?>
    </div>
  </div>
<?php
  }
  wp_reset_postdata();

  global $featured_posts;

  get_template_part('partials/home-featured-carousel');
?>

</section>
