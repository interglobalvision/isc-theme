<?php
get_header();
?>

<main id="main-content">
  <section>
    <div class="container">

      <?php get_template_part('partials/collection-filter'); ?>

      <div id="posts" class="grid-row" data-per-page="<?php echo get_query_var('posts_per_page'); ?>">
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
            <div><?php the_post_thumbnail('full'); ?></div>
            <?php echo !empty($artist) ? '<div><span>' . $artist . '</span></div>' : ''; ?>
            <?php echo !empty($title) ? '<div><span>' . $title . '</span></div>' : ''; ?>
          </a>
          <?php if ($styles) { ?>
            <div>
            <?php
              foreach($styles as $key => $value) {
                echo '<span>' . $value->name . '</span>';
                echo $key + 1 !== count($styles) ? ', ' : '';
              }
            ?>
            </div>
          <?php } ?>
        </article>

<?php
  }
}
?>

      </div>

      <?php get_template_part('partials/pagination'); ?>

    </div>
  </section>





</main>

<?php
get_footer();
?>
