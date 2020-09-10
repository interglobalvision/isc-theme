<?php
get_header();
global $wp_query;
$max_pages = $wp_query->max_num_pages;
$current_page = (get_query_var('paged')) ? get_query_var('paged') : 1;
$default_promo = gws_get_option('_gws_default_promo');
?>
<main id="main-content">
<?php
if ($current_page === 1) {
  $has_featured = false;

  $args = array(
    'post_type' => array('product'),
    'posts_per_page' => 1,
    'meta_key'   => '_igv_product_featured',
    'meta_value' => 'on'
  );

  $query = new WP_Query($args);

  if ($query->have_posts()) {
    $has_featured = true;
    while ($query->have_posts()) {
      $query->the_post();
?>
  <section class="padding-top-mid mobile-margin-top">
    <div class="container">
      <div class="grid-row">
        <div class="grid-item item-s-12 item-l-6">
          <h2>Featured Bundle</h2>
          <div class="margin-top-small">
            <span><?php echo !empty($default_promo) ? $default_promo : ''; ?></span>
          </div>
        </div>
        <?php get_template_part('partials/product-item-recent'); ?>
      </div>
    </div>
  </section>
<?php
    }
  }
  wp_reset_postdata();
}
?>
  <section class="<?php echo !$has_featured || $current_page !== 1 ? 'mobile-margin-top padding-top-mid' : ''; ?>">
    <div class="container">
      <div class="grid-row">
        <?php
        if (have_posts()) {
          while (have_posts()) {
            the_post();
            if ($current_page === 1 && $wp_query->current_post === 0) {
        ?>
          <div class="grid-item item-s-12 margin-bottom-small">
            <h2>Featured Items</h2>
          </div>
        <?php
            }
            if ($current_page === 1 && $wp_query->current_post === 4) {
        ?>
          <div class="grid-item item-s-12 margin-bottom-small">
            <h2>All items chronologically ordered</h2>
          </div>
        <?php
            }
            if ($current_page === 1 && $wp_query->current_post < 4) {
              get_template_part('partials/product-item-recent');
            } else {
              get_template_part('partials/product-item');
            }
          }
        }
        ?>
      </div>
    </div>
  </section>
</main>
<?php
get_footer();
?>
