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

<div id="player" class="padding-bottom-tiny padding-top-tiny">
  <div class="container">
    <div class="grid-row justify-between align-items-center">
      <div class="grid-row justify-between align-items-center grid-item item-s-12 item-m-auto flex-grow no-gutter">
        <div class="grid-item">
          <div class="player-thumb-holder">
            <img id="player-thumb"/>
          </div>
        </div>

        <div class="grid-item flex-grow">
          <div id="player-name-holder">
            <span>ISCHiFi—DIGITAL AUDIO PLAYER</span>
          </div>
          <div>
            <span id="player-track-title">&hellip;</span>
          </div>
        </div>

        <div  class="grid-item">
          <span id="player-current-time">0:00</span>/<span id="player-duration">0:00</span>
        </div>
      </div>
      <div class="grid-row justify-between align-items-center grid-item item-s-12 item-m-auto no-gutter">
        <div class="grid-item">
          <button class="player-skip player-control" data-skip="prev">
            <div class="player-control-icon">
              <img src="<?php bloginfo('stylesheet_directory'); ?>/dist/img/player-prev.png" />
            </div>
          </button>
        </div>

        <div class="grid-item">
          <button id="player-play-pause" class="player-control" disabled>
            <div class="player-control-icon">
              <img src="<?php bloginfo('stylesheet_directory'); ?>/dist/img/player-play.png" />
            </div>
            <div class="player-control-icon hide">
              <img src="<?php bloginfo('stylesheet_directory'); ?>/dist/img/player-pause.png" />
            </div>
          </button>
        </div>

        <div class="grid-item">
          <button class="player-skip player-control" data-skip="next">
            <div class="player-control-icon">
              <img src="<?php bloginfo('stylesheet_directory'); ?>/dist/img/player-next.png" />
            </div>
          </button>
        </div>

        <div  class="grid-item">
          <button class="player-control grid-row align-items-center" id="playlist-toggle">
            <span class="font-size-tiny">View Playlist</span>
            <img src="<?php bloginfo('stylesheet_directory'); ?>/dist/img/player-playlist.png" />
          </button>
        </div>
      </div>
    </div>
  </div>
</div>

<?php
}
?>
