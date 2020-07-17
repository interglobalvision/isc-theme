/* jshint esversion: 6, browser: true, devel: true, indent: 2, curly: true, eqeqeq: true, futurehostile: true, latedef: true, undef: true, unused: true */
/* global document, WP, SC */
// https://developers.soundcloud.com/docs/api/sdks#javascript

import $ from 'jquery';

class Player {
  constructor() {
    this.mobileThreshold = 601;
    this.playlist = null;
    this.currentTrack = null;
    this.trackIndex = 0;
    this.player = null;
    this.isPlaying = false;

    // Bind functions
    this.onReady = this.onReady.bind(this);
    this.handleTrack = this.handleTrack.bind(this);
    this.handleStream = this.handleStream.bind(this);
    this.handlePlayPause = this.handlePlayPause.bind(this);
    this.handleSkip = this.handleSkip.bind(this);
    this.setCurrentTime = this.setCurrentTime.bind(this);
    this.updateCurrentTime = this.updateCurrentTime.bind(this);
    this.togglePlaylist = this.togglePlaylist.bind(this);

    $(document).ready(this.onReady);
  }

  onReady() {
    this.$trackTitle = $('#player-track-title');
    this.$duration = $('#player-duration');
    this.$currentTime = $('#player-current-time');
    this.$playPause = $('#player-play-pause');
    this.$skip = $('.player-skip');
    this.$playlist = $('#playlist');
    this.$playlistToggle = $('.playlist-toggle');
    this.$playerThumb = $('#player-thumb');

    this.initSC();
  }

  initSC() {
    if (WP.playerClientId && WP.playerPlaylist) {
      this.playlist = JSON.parse(WP.playerPlaylist);
      SC.initialize({
        client_id: WP.playerClientId
      });

      this.bindControls();
      this.getTrack();
    }
  }

  /*
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
  */

  getTrack() {
    SC.resolve(this.playlist[this.trackIndex].soundcloudUrl)
    .then(this.handleTrack)
    .catch(function(e) {
      console.error('Playlist error', e);
    });
  }

  handleTrack(response) {
    this.currentTrack = response;
    this.createPlayer();
  }

  createPlayer() {
    SC.stream('/tracks/' + this.currentTrack.id)
      .then(this.handleStream)
      .catch(function(e) {
        console.error('Stream error', e);
      });
  }

  handleStream(player) {
    this.player = player;
    this.bindPlayerEvents();
    this.enablePlayPause();
    this.setDuration();
    this.setTrackTitle();
    this.setTrackThumb();
    if (this.isPlaying) {
      this.handlePlayPause();
    }
  }

  bindPlayerEvents() {
    this.player.on('finish', this.handleSkip);
  }

  setDuration() {
    const duration = this.millisToMinutesAndSeconds(this.currentTrack.duration);
    this.$duration.text(duration);
  }

  bindControls() {
    const _this = this;
    this.$playPause.on('click', function() {
      _this.isPlaying = !_this.isPlaying;
      _this.handlePlayPause();
    });
    this.$skip.on('click', this.handleSkip);
    this.$playlistToggle.on('click', this.togglePlaylist);
  }

  enablePlayPause() {
    this.$playPause.prop('disabled', false);
  }

  disablePlayPause() {
    this.$playPause.prop('disabled', true);
  }

  handlePlayPause() {
    this.$playPause.children('.player-control-icon').toggleClass('hide');

    if (this.player.isPlaying()) {
      this.pausePlayer();
    } else {
      this.playPlayer();
    }
  }

  playPlayer() {
    this.player.play()
      .then(this.setCurrentTime)
      .catch(function(e){
        console.error('Playback rejected', e);
      });
  }

  pausePlayer() {
    this.player.pause();
    clearInterval(this.timeUpdater);
  }

  handleSkip(e) {
    this.killPlayer();

    if (e === undefined) {
      // track finished
      this.trackIndex = this.trackIndex === this.playlist.length - 1 ? 0 : this.trackIndex + 1;
    } else {
      if ($(e.currentTarget).hasClass('playlist-item')) {
        // playlist click
        this.trackIndex = parseInt($(e.currentTarget).attr('data-track-index'));
      } else {
        if ($(e.currentTarget).attr('data-skip') === 'prev') {
          // skip prev
          this.trackIndex = this.trackIndex === 0 ? this.playlist.length - 1 : this.trackIndex - 1;
        } else {
          // skip next / default
          this.trackIndex = this.trackIndex === this.playlist.length - 1 ? 0 : this.trackIndex + 1;
        }
      }
    }

    this.getTrack();
  }

  killPlayer() {
    if (this.isPlaying) {
      // pause the player
      // without changing isPlaying state
      // this is important to resume playing
      // after new player is created
      this.handlePlayPause();
    }
    this.player.kill();
    this.$trackTitle.html('&hellip;');
    this.$playerThumb.removeClass('show');
    this.$duration.text('0:00');
    this.$currentTime.text('0:00');
  }

  togglePlaylist() {
    this.$playlist.toggleClass('show');
  }

  setTrackThumb() {
    if (this.playlist[this.trackIndex].thumbUrl) {
      // track has thumb
      this.$playerThumb.attr('src', this.playlist[this.trackIndex].thumbUrl);
      this.$playerThumb.addClass('show');
    } else {
      // track doesn't have thumb
      this.$playerThumb.removeAttr('src');
      this.$playerThumb.removeClass('show');
    }
  }

  setTrackTitle() {
    this.$trackTitle.text(this.playlist[this.trackIndex].title);
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
