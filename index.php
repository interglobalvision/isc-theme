<?php
get_header();

global $wp_query;
//var_dump($wp_query->paged); die;
$max_pages = $wp_query->max_num_pages;
$current_page = (get_query_var('paged')) ? get_query_var('paged') : 1;
?>

<main id="main-content">

<?php
if (is_home() && $current_page === 1) {
  $args = array(
    'post_type' => array('post'),
    'posts_per_page' => 1,
  );

  $query = new WP_Query($args);

  if ($query->have_posts()) {
?>

  <section id="recent-post" class="padding-top-mid mobile-margin-top">
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

  <section class="border-box background-almond padding-bottom-basic <?php echo (!is_home() && $current_page !== 1) ? 'padding-top-mid mobile-margin-top' : 'padding-top-basic'; ?>">

    <div class="container">
      <div id="posts" class="grid-row" data-maxpages="<?php echo $max_pages; ?>">

      <?php
      if (have_posts()) {
        while (have_posts()) {
          the_post();
          get_template_part('partials/post-item');
        }
      } else {
      ?>
        <div class="grid-item"><span>There's nothing here!</span></div>
      <?php
      }
      ?>

      </div>

      <?php
        if ($max_pages > $current_page) {
          $post_type_archive = get_post_type_archive_link('post');
          $load_more_url = add_query_arg( array(
            'paged' => $current_page + 1,
          ), $post_type_archive);
      ?>
      <div class="grid-row justify-center">
        <div class="grid-item">
          <a id="load-more" class="load-more-button" data-context="load-more" data-maxpages="<?php echo $max_pages; ?>" href="<?php echo $load_more_url; ?>">Load More</a>
        </div>
      </div>
      <?php } ?>
    </div>

  </section>

</main>

<?php
get_footer();
?>
