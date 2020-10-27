/* jshint esversion: 6, browser: true, devel: true, indent: 2, curly: true, eqeqeq: true, futurehostile: true, latedef: true, undef: true, unused: true */
/* global $, document, WP, SC */
// https://developers.soundcloud.com/docs/api/sdks#javascript

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
    this.handlePause = this.handlePause.bind(this);
    this.handleSkip = this.handleSkip.bind(this);
    this.setCurrentTime = this.setCurrentTime.bind(this);
    this.updateCurrentTime = this.updateCurrentTime.bind(this);
    this.togglePlaylist = this.togglePlaylist.bind(this);

    $(document).ready(this.onReady);
  }

  onReady() {
    this.$mainContainer = $('#main-container');
    this.$player = $('#player');
    this.$trackTitle = $('.player-track-title');
    this.$duration = $('.player-duration');
    this.$currentTime = $('.player-current-time');
    this.$playPause = $('.player-play-pause');
    this.$skip = $('.player-skip');
    this.$playlist = $('#playlist');
    this.$playlistToggle = $('.playlist-toggle');
    this.$playerThumb = $('.player-thumb');
    this.$playerTrackInfo = $('.player-track-info');

    this.initSC();
  }

  shuffle(array) {
    var currentIndex = array.length, temporaryValue, randomIndex;

    // While there remain elements to shuffle...
    while (0 !== currentIndex) {

      // Pick a remaining element...
      randomIndex = Math.floor(Math.random() * currentIndex);
      currentIndex -= 1;

      // And swap it with the current element.
      temporaryValue = array[currentIndex];
      array[currentIndex] = array[randomIndex];
      array[randomIndex] = temporaryValue;
    }

    return array;
  }

  initSC() {
    if (WP.playerClientId && WP.playerPlaylist && this.$player.length) {
      this.playlist = this.shuffle(JSON.parse(WP.playerPlaylist));

      this.shufflePlaylistElements();

      SC.initialize({
        client_id: WP.playerClientId
      });

      this.bindControls();
      this.getTrack();
    }
  }

  shufflePlaylistElements() {
    var _this = this;
    var playlistItems = document.querySelectorAll('.playlist-item');
    playlistItems.forEach(function(element, index) {
      var playlistIndex = _this.playlist.findIndex(el => el.index === index);
      element.style.order = playlistIndex;
      element.dataset.index = playlistIndex;
    });
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

  handleError(errorMsg, event) {
    console.error(errorMsg, event);
    this.isPlaying = false;
    this.hasError = true;
    this.$player.addClass('player-error');
    this.$trackTitle.text(errorMsg);
  }

  clearError() {
    if (this.hasError) {
      this.hasError = false;
      this.$player.removeClass('player-error');
      this.$trackTitle.html('&hellip;');
    }
  }

  getTrack() {
    const _this = this;
    this.clearError();
    SC.resolve(this.playlist[this.trackIndex].soundcloudUrl)
    .then(this.handleTrack)
    .catch(function(e) {
      _this.handleError('Playlist error', e);
    });
  }

  handleTrack(response) {
    this.currentTrack = response;
    this.createPlayer();
  }

  createPlayer() {
    const _this = this;
    SC.stream('/tracks/' + this.currentTrack.id)
      .then(this.handleStream)
      .catch(function(e) {
        _this.handleError('Stream error', e);
      });
  }

  handleStream(player) {
    this.player = player;
    this.bindPlayerEvents();
    this.enablePlayPause();
    this.setDuration();
    this.setTrackTitle();
    this.setTrackThumb();
    this.updateInfoLink();
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
      $(this).blur();
      _this.isPlaying = !_this.isPlaying;
      _this.handlePlayPause();
    });
    this.$skip.on('click', function(e) {
      $(this).blur();
      _this.handleSkip(e);
    });
    this.$playlistToggle.on('click', function(e) {
      $(this).blur();
      _this.togglePlaylist(e);
    });
    this.$playerTrackInfo.on('click.togglePlaylist', function() {
      $(this).blur();
      if ($('body').hasClass('playlist-open')) {
        $('body').removeClass('playlist-open');
        this.$mainContainer.css('top', 'auto');
        $(window).scrollTop(this.windowScrollTop);
      }
    });
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

  handlePause() {
    if (this.player.isPlaying()) {
      this.$playPause.children('.player-control-icon').toggleClass('hide');
      this.pausePlayer();
    }
  }

  playPlayer() {
    const _this = this;
    this.player.play()
      .then(this.setCurrentTime)
      .catch(function(e){
        _this.handleError('Playback rejected', e);
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
    } else if ($(e.currentTarget).hasClass('album-stream')) {
      this.insertAlbumTrack(e.currentTarget);
    } else if ($(e.currentTarget).hasClass('playlist-item')) {
      // playlist click
      this.trackIndex = parseInt($(e.currentTarget).attr('data-index'));
    } else {
      if ($(e.currentTarget).attr('data-skip') === 'prev') {
        // skip prev
        this.trackIndex = this.trackIndex === 0 ? this.playlist.length - 1 : this.trackIndex - 1;
      } else {
        // skip next / default
        this.trackIndex = this.trackIndex === this.playlist.length - 1 ? 0 : this.trackIndex + 1;
      }
    }

    this.getTrack();
  }

  insertAlbumTrack(target) {
    const trackData = $(target).data();
    const $playlistTrack = $('.playlist-item[data-id="' + trackData.id + '"]');

    if ($playlistTrack.length) {
      // track is in playlist

      this.trackIndex = $playlistTrack.attr('data-index');

    } else {
      // create track in playlist

      const albumTrack = {
        title: trackData.title,
        thumbUrl: trackData.thumb,
        soundcloudUrl: trackData.soundcloud,
        relatedAlbumUrl: trackData.url
      };

      const $currentPlaylistItem = $('.playlist-item').eq(this.trackIndex);
      let $newPlaylistItem = $currentPlaylistItem.clone(true, true);

      this.trackIndex++;

      $newPlaylistItem.find('.playlist-item-title').text(albumTrack.title);
      $newPlaylistItem.find('.playlist-item-thumb').attr('src', albumTrack.thumbUrl);
      $newPlaylistItem.attr('data-id', trackData.id);

      $newPlaylistItem.insertAfter($currentPlaylistItem);

      this.playlist.splice(this.trackIndex, 0, albumTrack);
    }

    this.isPlaying = true;
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
    if ($('body').hasClass('playlist-open')) {
      $('body').removeClass('playlist-open');
      this.$mainContainer.css('top', 'auto');
      $(window).scrollTop(this.windowScrollTop);
    } else {
      this.windowScrollTop = $(window).scrollTop();
      this.$playlist.scrollTop(0);
      $('body').addClass('playlist-open');
      this.$mainContainer.css('top', this.windowScrollTop * -1);
    }
  }

  setTrackThumb() {
    if (this.playlist[this.trackIndex].thumbUrl) {
      // track has thumb
      this.$playerThumb.removeAttr('src')
        .attr('src', this.playlist[this.trackIndex].thumbUrl)
        .addClass('show');
    } else {
      // track doesn't have thumb
      this.$playerThumb.removeAttr('src')
        .removeClass('show');
    }
  }

  setTrackTitle() {
    this.$trackTitle.text(this.playlist[this.trackIndex].title);
  }

  updateInfoLink() {
    if (this.playlist[this.trackIndex].relatedAlbumUrl) {
      this.$playerTrackInfo.attr('href', this.playlist[this.trackIndex].relatedAlbumUrl)
        .removeClass('disabled');
    } else {
      this.$playerTrackInfo.removeAttr('href')
        .addClass('disabled');
    }
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
