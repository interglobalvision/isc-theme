<?php
$artist = get_post_meta($post->ID, '_igv_album_artist', true);
$title = get_post_meta($post->ID, '_igv_album_title', true);
$styles = get_the_terms($post->ID, 'style');
?>
<article <?php post_class('album-item-recent grid-item item-s-12 item-m-4 grid-row margin-bottom-small'); ?> id="post-<?php the_ID(); ?>">
  <div class="grid-item no-gutter item-m-12 item-l-7 margin-right-tiny">
    <a href="<?php the_permalink(); ?>">
      <?php the_post_thumbnail('album-item', ['class' => 'recent-album-thumb']); ?>
    </a>
  </div>
  <div class="grid-item no-gutter grid-column justify-between item-m-12 item-l-auto">
    <div>
      <h3 class="u-visuallyhidden"><?php the_title(); ?></h3>
      <div>
        <a href="<?php the_permalink(); ?>" class="font-size-mid font-cond">
          <?php echo !empty($artist) ? $artist : ''; ?>
        </a>
      </div>
      <div>
        <a href="<?php the_permalink(); ?>" class="font-size-small">
          <?php echo !empty($title) ? $title : ''; ?>
        </a>
      </div>
    </div>
  <?php if ($styles) { ?>
    <div>
    <?php
      foreach($styles as $key => $value) {
        echo '<span class="font-uppercase font-size-small"><a href="' . get_post_type_archive_link('album') . '?style=' . $value->slug . '">' . $value->name . '</a></span>';
        echo $key + 1 !== count($styles) ? ', ' : '';
      }
    ?>
    </div>
  <?php } ?>
  </div>
</article>
