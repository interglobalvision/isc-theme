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
?>

        <article <?php post_class('grid-item item-s-6 item-m-4 item-l-3'); ?> id="album-<?php the_ID(); ?>">

          <a href="<?php the_permalink() ?>">
            <h3 class="u-visuallyhidden"><?php the_title(); ?></h3>
            <div><?php the_post_thumbnail('full'); ?></div>
            <div><span>Artist</span></div>
            <div><span>Title</span></div>
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
    </div>
  </section>

  <?php get_template_part('partials/pagination'); ?>

</main>

<?php
get_footer();
?>
