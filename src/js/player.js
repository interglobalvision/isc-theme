/* jshint esversion: 6, browser: true, devel: true, indent: 2, curly: true, eqeqeq: true, futurehostile: true, latedef: true, undef: true, unused: true */
/* global document, WP, SC */
// https://developers.soundcloud.com/docs/api/sdks#javascript

import $ from 'jquery';

class Player {
  constructor() {
    this.mobileThreshold = 601;
    this.currentTrack = 0;
    this.player = null;

    // Bind functions
    this.onReady = this.onReady.bind(this);
    this.handlePlaylist = this.handlePlaylist.bind(this);
    this.handleStream = this.handleStream.bind(this);
    this.handlePlayPause = this.handlePlayPause.bind(this);
    this.handleSkip = this.handleSkip.bind(this);
    this.setCurrentTime = this.setCurrentTime.bind(this);
    this.updateCurrentTime = this.updateCurrentTime.bind(this);

    $(document).ready(this.onReady);
  }

  onReady() {
    this.$trackTitle = $('#player-track-title');
    this.$duration = $('#player-duration');
    this.$currentTime = $('#player-current-time');
    this.$playPause = $('#player-play-pause');
    this.$skip = $('#player-skip');

    this.initSC();
  }

  initSC() {
    if (WP.playerClientId && WP.playerPlaylistUrl) {
      SC.initialize({
        client_id: WP.playerClientId
      });

      this.bindControls();
      this.getPlaylist();
    } else {
      $('#player').remove();
    }
  }

  getPlaylist() {
    SC.resolve(WP.playerPlaylistUrl)
      .then(this.handlePlaylist)
      .catch(function(e) {
        console.error('Playlist error', e);
      });
  }

  handlePlaylist(response) {
    this.tracks = response.tracks;
    this.createPlayer();
  }

  createPlayer() {
    SC.stream('/tracks/' + this.tracks[this.currentTrack].id)
      .then(this.handleStream)
      .catch(function(e) {
        console.error('Stream error', e);
      });
  }

  handleStream(player) {
    this.player = player;
    this.enablePlayPause();
    this.setDuration();
    this.setTrackTitle();
    if (this.skipped) {
      this.handlePlayPause();
    }
  }

  setDuration() {
    const duration = this.millisToMinutesAndSeconds(this.tracks[this.currentTrack].duration);
    this.$duration.text(duration);
  }

  bindControls() {
    this.$playPause.on('click', this.handlePlayPause);
    this.$skip.on('click', this.handleSkip);
  }

  enablePlayPause() {
    this.$playPause.prop('disabled', false);
  }

  disablePlayPause() {
    this.$playPause.prop('disabled', true);
  }

  handlePlayPause() {
    if (this.player.isPlaying()) {
      this.player.pause();
      clearInterval(this.timeUpdater);
    } else {
      this.player.play()
        .then(this.setCurrentTime)
        .catch(function(e){
          console.error('Playback rejected', e);
        });
    }
    this.skipped = false;
  }

  handleSkip() {
    this.skipped = true;
    this.killPlayer();
    this.currentTrack += 1;
    this.createPlayer();
  }

  killPlayer() {
    this.player.pause();
    this.player.kill();
    this.$trackTitle.text('&hellip;');
    this.$duration.text('0:00');
    this.$currentTime.text('0:00');
  }

  setTrackTitle() {
    this.$trackTitle.text(this.tracks[this.currentTrack].title);
  }

  setCurrentTime() {
    this.timeUpdater = setInterval(this.updateCurrentTime, 500);
  }

  updateCurrentTime() {
    const currentTime = this.millisToMinutesAndSeconds(this.player.currentTime());
    this.$currentTime.text(currentTime);
  }

  millisToMinutesAndSeconds(millis) {
    var minutes = Math.floor(millis / 60000);
    var seconds = ((millis % 60000) / 1000).toFixed(0);
    return (seconds === 60 ? (minutes+1) + ":00" : minutes + ":" + (seconds < 10 ? "0" : "") + seconds);
  }
}

export default Player;
