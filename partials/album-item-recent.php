<?php
$artist = get_post_meta($post->ID, '_igv_album_artist', true);
$title = get_post_meta($post->ID, '_igv_album_title', true);
$styles = get_the_terms($post->ID, 'style');
?>
<article <?php post_class('grid-item item-s-12 item-m-4 grid-row flex-nowrap'); ?> id="post-<?php the_ID(); ?>">
  <div class="grid-item no-gutter">
    <a href="<?php the_permalink(); ?>">
      <?php the_post_thumbnail('album-item', ['class' => 'recent-album-thumb']); ?>
    </a>
  </div>
  <div class="grid-item no-gutter grid-column justify-between">
    <div>
      <h3 class="u-visuallyhidden"><?php the_title(); ?></h3>
      <div class="font-size-mid font-cond"><a href="<?php the_permalink(); ?>"><?php echo !empty($artist) ? $artist : ''; ?></a></div>
      <div><a href="<?php the_permalink(); ?>"><?php echo !empty($title) ? $title : ''; ?></a></div>
    </div>
  <?php if ($styles) { ?>
    <div class="font-uppercase">
    <?php
      foreach($styles as $key => $value) {
        echo '<span><a href="' . get_post_type_archive_link('album') . '?style=' . $value->slug . '">' . $value->name . '</a></span>';
        echo $key + 1 !== count($styles) ? ', ' : '';
      }
    ?>
    </div>
  <?php } ?>
  </div>
</article>
