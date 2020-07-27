<?php
$tidal_url = get_post_meta($post->ID, '_igv_album_tidal_url', true);
$apple_url = get_post_meta($post->ID, '_igv_album_apple_url', true);
$spotify_url = get_post_meta($post->ID, '_igv_album_spotify_url', true);
$related_track = get_posts(array(
  'numberposts' => 1,
  'post_type' => 'track',
  'meta_key' => '_igv_track_album',
  'meta_value' => $post->ID,
));
?>
<div id="album-streaming" class="grid-item item-s-12 no-gutter grid-row">
  <div class="grid-item item-s-12 item-m-2">
    <span>Stream:</span>
  </div>
<?php
if (!empty($related_track)) {
  $track_id = $related_track[0]->ID;
  $title = get_the_title($track_id);
  $thumb_url = get_the_post_thumbnail_url($track_id);
  $soundcloud_url = get_post_meta($track_id, '_igv_track_soundcloud', true);
  if (!empty($soundcloud_url)) {
?>
  <div class="grid-item">
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
} if (!empty($tidal_url)) {
?>
  <div class="grid-item">
    <a class="stream-button player-skip album-stream u-pointer" href="<?php echo $tidal_url; ?>">
      <img src="<?php bloginfo('stylesheet_directory'); ?>/dist/img/stream-tidal.png" />
    </a>
  </div>
<?php } if (!empty($apple_url)) { ?>
  <div class="grid-item">
    <a class="stream-button player-skip album-stream u-pointer" href="<?php echo $apple_url; ?>">
      <img src="<?php bloginfo('stylesheet_directory'); ?>/dist/img/stream-apple.png" />
    </a>
  </div>
<?php } if (!empty($spotify_url)) { ?>
  <div class="grid-item">
    <a class="stream-button player-skip album-stream u-pointer" href="<?php echo $spotify_url; ?>">
      <img src="<?php bloginfo('stylesheet_directory'); ?>/dist/img/stream-spotify.png" />
    </a>
  </div>
<?php } ?>
</div>
