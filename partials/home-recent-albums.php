<?php
$args = array(
  'post_type' => array('album'),
  'posts_per_page' => 3,
);

$query = new WP_Query($args);

if ($query->have_posts()) {
?>
<section class="padding-top-basic padding-bottom-small border-box border-sides-brown background-white">
  <div class="container">
    <div class="grid-row">
<?php
  while ($query->have_posts()) {
    $query->the_post();
    get_template_part('partials/album-item-recent');
  }
?>
    </div>
  </div>
</section>
<?php
}
wp_reset_postdata();
