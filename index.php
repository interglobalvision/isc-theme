<?php
get_header();

global $wp_query;
$max_pages = $wp_query->max_num_pages;
$current_page = (get_query_var('paged')) ? get_query_var('paged') : 1;
$current_query = $wp_query->query_vars;
?>

<main id="main-content">

<?php
if ($current_page === 1) {
  $args = $current_query;
  if (!is_home()) {
    pr($args['post__not_in']);
  }
  $args['posts_per_page'] = 1;
  $args['post__in'] = $args['post__not_in'];
  $args['post__not_in'] = array();

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

  <section class="border-box background-almond padding-bottom-basic padding-top-basic <?php echo (!is_home() || $current_page !== 1) ? 'margin-top-mid mobile-margin-top' : ''; ?>">

    <div class="container">

      <?php if (is_category() || is_tag() || is_tax()) { ?>
        <div class="grid-row margin-bottom-basic">
          <div class="grid-item">
            <h2 class="font-size-mid font-uppercase"><?php echo single_term_title(); ?></h2>
          </div>
        </div>
      <?php } ?>

      <div id="posts" class="grid-row" data-maxpages="<?php echo $max_pages; ?>">

      <?php
      if (have_posts()) {
        while (have_posts()) {
          the_post();
          get_template_part('partials/post-item');
        }
      }
      ?>

      </div>

      <?php
        if ($max_pages > $current_page) {
          $queried_object = get_queried_object();
          $post_type_archive = get_post_type_archive_link('post');

          if (!is_home()) {
            $post_type_archive = get_term_link($queried_object->term_id);
          }

          $load_more_url = add_query_arg( array(
            'paged' => $current_page + 1,
          ), $post_type_archive);
      ?>
      <div class="grid-row justify-end">
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
