<?php
get_header();
global $wp_query;
$max_pages = $wp_query->max_num_pages;
$current_page = (get_query_var('paged')) ? get_query_var('paged') : 1;
$promo_message = gws_get_option('_gws_shop_promo_message');
?>
<main id="main-content">
<div class="mobile-padding-top">
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
  <section class="padding-top-mid">
    <div class="container">
      <div class="grid-row">
        <div class="grid-item item-s-12 item-m-6">
          <h2>Featured Bundle</h2>
          <div class="margin-top-basic margin-bottom-basic text-align-center">
            <span class="font-size-extra font-cond"><?php echo !empty($promo_message) ? $promo_message : ''; ?></span>
          </div>
        </div>
        <?php get_template_part('partials/product-item-featured'); ?>
      </div>
    </div>
  </section>
<?php
    }
  }
  wp_reset_postdata();
}
?>
  <section class="<?php echo !$has_featured || $current_page !== 1 ? 'padding-top-mid' : 'padding-top-basic'; ?>  padding-bottom-basic">
    <div class="container">
      <div id="posts" class="grid-row" data-maxpages="<?php echo $max_pages; ?>">
        <?php
        if (have_posts()) {
          while (have_posts()) {
            the_post();
            if ($current_page === 1 && $wp_query->current_post === 0) {
        ?>
          <div class="grid-item item-s-12 margin-bottom-small">
            <h2>Featured Selections</h2>
          </div>
        <?php
            }
            if ($current_page === 1 && $wp_query->current_post === 4) {
        ?>
          <div class="grid-item item-s-12 padding-top-basic margin-bottom-small">
            <h2>Past Selections</h2>
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
      <?php
        $post_type_archive = get_post_type_archive_link('product');
        $load_more_url = add_query_arg( array(
          'paged' => $current_page + 1,
        ), $post_type_archive);
      ?>
      <div class="grid-row justify-end">
        <div class="grid-item">
          <a id="load-more" class="load-more-button <?php echo $max_pages > $current_page ? '' : 'hide'; ?>" data-context="load-more" data-maxpages="<?php echo $max_pages; ?>" href="<?php echo $load_more_url; ?>">Load More</a>
        </div>
      </div>
    </div>
  </section>
</div>
</main>
<?php
get_footer();
?>
