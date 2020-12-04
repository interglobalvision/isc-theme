<?php
$args = array(
  'post_type' => array('post'),
  'category_name' => 'playlist',
  'posts_per_page' => 6,
);

$query = new WP_Query($args);

if ($query->have_posts()) {
?>
<section class="padding-top-basic padding-bottom-small border-box border-sides-orange background-almond">
  <div class="container">
    <div class="grid-row">
      <div class="grid-item item-s-12 margin-bottom-basic">
        <h2 class="font-size-mid font-uppercase">Playlists</h2>
      </div>
    </div>
    <div class="grid-row">
<?php
  while ($query->have_posts()) {
    $query->the_post();
    get_template_part('partials/post-item-small');
  }
?>
    </div>
  </div>
</section>
<?php
}
wp_reset_postdata();
