<?php
$artist = get_post_meta($post->ID, '_igv_album_artist', true);
$title = get_post_meta($post->ID, '_igv_album_title', true);
$styles = get_the_terms($post->ID, 'style');
?>
<article <?php post_class('grid-item item-s-12 item-m-4 grid-row'); ?> id="album-<?php the_ID(); ?>">
  <div class="grid-item no-gutter item-s-6">
    <?php the_post_thumbnail('full'); ?>
  </div>
  <div class="grid-item no-gutter item-s-6 grid-column justify-between">
    <div>
      <h3 class="u-visuallyhidden"><?php the_title(); ?></h3>
      <div><span>Artist</span></div>
      <div><span>Title</span></div>
    </div>
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
  </div>
</article>
