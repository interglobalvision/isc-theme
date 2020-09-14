<?php
$args = array(
  'post_type' => array('product'),
  'posts_per_page' => 4,
);

$query = new WP_Query($args);

if ($query->have_posts()) {
?>
<section class="border-box border-sides-brown background-white padding-top-basic">
  <div class="container">
    <div class="grid-row">
      <div class="grid-item item-s-12 margin-bottom-small">
        <h2>Featured Products</h2>
      </div>
<?php
  while ($query->have_posts()) {
    $query->the_post();
    get_template_part('partials/product-item');
  }
?>
    </div>
  </div>
</section>
<?php
}
wp_reset_postdata();
