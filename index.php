<?php
get_header();
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
?>

<main id="main-content">

<?php
if(1 == $paged) {
  $args = array(
    'post_type' => array('post'),
    'posts_per_page' => 1,
  );

  $query = new WP_Query($args);

  if ($query->have_posts()) {
?>

  <section id="recent-post">
    <div class="container">
      <div class="grid-row">
      <?php
        while ($query->have_posts()) {
          $query->the_post();
          get_template_part('partials/post-item-first');
        }
      ?>
      </div>
    </div>
  </section>

<?php
  }
  wp_reset_postdata();
}
?>

  <section class="border-square">

    <div class="container">
      <div id="posts" class="grid-row" data-per-page="<?php echo get_query_var('posts_per_page'); ?>">

      <?php
      if (have_posts()) {
        while (have_posts()) {
          the_post();
          get_template_part('partials/post-item');
        }
      }
      ?>

      </div>
    </div>

    <?php get_template_part('partials/pagination'); ?>

  </section>

</main>

<?php
get_footer();
?>
