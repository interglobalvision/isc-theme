<?php
get_header();

global $wp_query;
$max_pages = $wp_query->max_num_pages;
$current_page = (get_query_var('paged')) ? get_query_var('paged') : 1;
?>

<main id="main-content">
  <section class="padding-top-basic">
    <div class="container">
      <?php get_template_part('partials/collection-filter'); ?>
    </div>
  </section>

  <section class="border-box background-almond padding-top-basic padding-bottom-basic">
    <div class="container">
      <div id="posts" class="grid-row" data-maxpages="<?php echo $max_pages; ?>">
<?php
if (have_posts()) {
  while (have_posts()) {
    the_post();

    $artist = get_post_meta($post->ID, '_igv_album_artist', true);
    $title = get_post_meta($post->ID, '_igv_album_title', true);
    $styles = get_the_terms($post->ID, 'style');

    $style_slugs = array();
    foreach ($styles as $key => $value) {
      array_push($style_slugs, $value->slug);
    }
    $filter = json_encode(array(
      'title' => get_the_title(),
      'styles' => $style_slugs,
      'time' => get_post_time()
    ));
?>

        <article <?php post_class('grid-item item-s-6 item-m-4 item-l-3'); ?> id="album-<?php the_ID(); ?>" data-filter="<?php echo $filter; ?>">
          <a href="<?php the_permalink() ?>">
            <h3 class="u-visuallyhidden"><?php the_title(); ?></h3>
            <div><?php the_post_thumbnail('album-item'); ?></div>
          </a>
        </article>

<?php
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
