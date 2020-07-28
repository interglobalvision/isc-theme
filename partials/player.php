<?php
$player_options = get_site_option('_igv_player_options');
$playlist = $player_options['player_playlist'];

if (!empty($playlist)) {

get_template_part('partials/playlist');
?>

<div id="player" class="padding-bottom-tiny padding-top-tiny">
  <div class="container">
    <div class="grid-row justify-between align-items-center">
      <div class="grid-row justify-between align-items-center grid-item item-s-12 item-m-auto flex-grow no-gutter">
        <div class="grid-item">
          <div class="player-thumb-holder">
            <img id="player-thumb"/>
          </div>
        </div>

        <div class="grid-item flex-grow font-size-small">
          <div id="player-name-holder">
            <span>ISCHiFi</span><span> — DIGITAL AUDIO PLAYER</span>
          </div>
          <div>
            <span id="player-track-title" class="font-mono">&hellip;</span>
          </div>
        </div>

        <div class="grid-item font-size-small font-mono">
          <span id="player-current-time">0:00</span><span> / </span><span id="player-duration">0:00</span>
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
