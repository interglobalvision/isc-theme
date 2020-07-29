<?php

$related_track = get_posts(array(
  'numberposts' => 1,
  'post_type' => 'track',
  'meta_key' => '_igv_track_album',
  'meta_value' => $post->ID,
));
?>
<div id="album-streaming" class="grid-item item-s-12 no-gutter grid-row">
  <div class="grid-item margin-bottom-tiny">
    <span class="font-cond">Stream:</span>
  </div>
  <div class="flex-grow">
  <?php
  if (!empty($related_track)) {
    $track_id = $related_track[0]->ID;
    $title = get_the_title($track_id);
    $thumb_url = get_the_post_thumbnail_url($track_id);
    $soundcloud_url = get_post_meta($track_id, '_igv_track_soundcloud', true);
    if (!empty($soundcloud_url)) {
  ?>
    <div class="u-inline-block margin-bottom-tiny">
      <div class="stream-button player-skip album-stream u-pointer"
        data-title="<?php echo $title; ?>"
        data-thumb="<?php echo !empty($thumb_url) ? $thumb_url : get_the_post_thumbnail_url($post->ID); ?>"
        data-soundcloud="<?php echo $soundcloud_url; ?>"
        data-id="<?php echo $track_id; ?>">
          <img src="<?php bloginfo('stylesheet_directory'); ?>/dist/img/stream-hifi.png" />
        </div>
    </div>
  <?php
    }
  }

  $services = array('tidal', 'apple', 'spotify');

  foreach ($services as $service) {
    $meta_key = '_igv_album_' . $service . '_url';
    $url = get_post_meta($post->ID, $meta_key, true);
    if (!empty($url)) {
  ?>
    <div class="u-inline-block margin-bottom-tiny">
      <a class="stream-button player-skip album-stream u-pointer" href="<?php echo $url; ?>" target="_blank">
        <img src="<?php bloginfo('stylesheet_directory'); ?>/dist/img/stream-<?php echo $service; ?>.png" />
      </a>
    </div>
  <?php
    }
  }
  ?>
  </div>
</div>
