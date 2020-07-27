<?php
$player_options = get_site_option('_igv_player_options');
$playlist = $player_options['player_playlist'];

if (!empty($playlist)) {
?>

<div id="playlist">
  <ul id="playlist-items" class="container padding-top-tiny">
  <?php
    foreach($playlist as $track_index => $track_id) {
      $related_album = get_post_meta($track_id, '_igv_track_album', true);
      $thumb_url = get_the_post_thumbnail_url($track_id);

      if (!has_post_thumbnail($track_id) && !empty($related_album)) {
        $thumb_url = get_the_post_thumbnail_url($related_album);
      }
  ?>
    <li class="playlist-item player-skip u-pointer grid-row justify-between align-items-center padding-top-micro padding-bottom-micro" data-id="<?php echo $track_id; ?>">
      <div class="grid-item">
        <div class="player-thumb-holder">
          <?php echo $thumb_url ? '<img src="' . $thumb_url . '" class="playlist-item-thumb" alt="' . get_the_title() . ' album cover" data-no-lazysizes="true" />' : ''; ?>
        </div>
      </div>
      <div class="grid-item flex-grow">
        <div>
          <span class="playlist-item-title"><?php echo get_the_title($track_id); ?></span>
        </div>
      </div>
    </li>
  <?php } ?>
  </ul>
</div>

<?php
}
?>
