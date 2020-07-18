<?php
get_header();

global $wp_query;
$max_pages = $wp_query->max_num_pages;
$current_page = (get_query_var('paged')) ? get_query_var('paged') : 1;
?>
<?php get_search_form(); ?>
<section>
  <div class="container">
    <div id="search-results" data-max-pages="<?php echo $max_pages; ?>" class="grid-row">
      <?php
      if (have_posts()) {
        while (have_posts()) {
          the_post();
          get_template_part('partials/search-item');
        }
      }
      ?>
    </div>
  </div>
</section>
