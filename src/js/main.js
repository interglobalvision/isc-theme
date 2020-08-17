/* jshint esversion: 6, browser: true, devel: true, indent: 2, curly: true, eqeqeq: true, futurehostile: true, latedef: true, undef: true, unused: true */
/* global document, WP, URLSearchParams */

// Import dependencies
import $ from 'jquery';
import lazySizes from 'lazysizes';
import Swiper from 'swiper';
import Cookies from 'js-cookie';
import Player from './player';
import Mailchimp from './mailchimp';

// Import style
import '../styl/site.styl';

class Site {
  constructor() {
    this.landscapeThreshold = 1024;
    this.swiperInstance = false;
    this.currentArchivePage = 1;

    this.handleSearchToggle = this.handleSearchToggle.bind(this);
    this.handleSearchSubmit = this.handleSearchSubmit.bind(this);
    this.handleSearchTag = this.handleSearchTag.bind(this);

    $(window).resize(this.onResize.bind(this));

    $(document).ready(this.onReady.bind(this));

  }

  onResize() {
    this.windowWidth = $(window).width();
  }

  onReady() {
    this.audioPlayer = new Player();

    this.$mainContainer = $('#main-container');

    this.windowWidth = $(window).width();

    lazySizes.init();

    this.bindLinks();
    this.bindStreamButtons();
    this.bindFilterToggle();
    this.bindBack();
    this.setupSwiper();
    this.bindSearchEvents();
    this.setFooterHeight();
    this.bindMobileNav();
    this.initWelcomePanel();

    //this.count();
    //this.thetime = 1;
  }

  count() {
    const _this = this;
    setInterval(function() {
      _this.thetime++;
      $('#counter').html(_this.thetime);
    }, 1000);
  }

  setFooterHeight() {
    const headerHeight = $('#header').outerHeight();
    const contentHeight = $('#main-content').outerHeight();
    const windowHeight = $(window).outerHeight();

    $('#footer').css('min-height', (windowHeight - (headerHeight + contentHeight)) + 'px');
  }

  initWelcomePanel() {
    const welcomeCookie = Cookies.get('wc');

    if (!welcomeCookie) {
      $('body').addClass('welcome-open');
    }

    $('.close-welcome').on('click', function() {
      $('body').removeClass('welcome-open');
      Cookies.set('wc', 'true');
    });
  }

  bindMobileNav() {
    $('.toggle-nav').on('click', function() {
      $('body').toggleClass('mobile-nav-open');
    });
  }

  bindOverlayGallery() {
    $('.toggle-gallery').off().on('click', function() {
      $('body').toggleClass('gallery-open');
    });
  }

  bindLinks(selector = 'a') {
    const _this = this;

    $(selector).off().on('click', function(e) {
      const target = e.currentTarget;
      const href = $(this).attr('href');

      $(this).blur();

      if ($(target).hasClass('search-toggle')) {
        _this.handleSearchToggle(e);
        return false;
      } else if ($(target).hasClass('filter-option')) {
        return;
      } else {
        if (!href.startsWith(WP.siteUrl)) {
          return;
        }

        if ($(target).closest('.swiper-slide').length) {
          const $slide = $(target).closest('.swiper-slide');
          if (!$slide.hasClass('swiper-slide-active')) {
            return false;
          }
        }

        if ($(target).closest('.search-result').length) {
          $('body').removeClass('search-open');
        }

        const context = $(target).attr('data-context') !== undefined ? $(target).attr('data-context') : 'content';
        _this.handleRequest(href, context);

        return false;
      }
    });
  }

  bindSearchEvents() {
    this.$searchPanel = $('#search-panel');
    this.$searchForm = $('#search-form');
    this.$searchField = $('#search-field');
    this.$searchResults = $('#search-results');
    this.$searchLoadMore = $('#search-load-more');

    this.$searchForm.on('submit', this.handleSearchSubmit);
    $('#search-toggle-overlay').on('click', this.handleSearchToggle);
    this.$searchField.on('click', this.handleSearchInput);
    $('.search-tag').on('click.searchTag', this.handleSearchTag);
  }

  handleSearchInput() {
    $(this).select();
  }

  handleSearchToggle() {
    if ($('body').hasClass('search-open')) {
      this.$searchField.blur();
      $('body').removeClass('search-open');
      this.$mainContainer.css('top', 'auto');
      $(window).scrollTop(this.windowScrollTop);
    } else {
      this.windowScrollTop = $(window).scrollTop();
      this.$searchPanel.scrollTop(0);
      $('body').addClass('search-open');
      this.$mainContainer.css('top', this.windowScrollTop * -1);
      this.$searchField.focus();
    }
  }

  enableMainContainerScroll() {

  }

  disableMainContainerScroll() {

  }

  handleSearchSubmit(e, searchTag = false) {
    const _this = this;

    this.searchQuery = this.$searchField.val();

    if (!this.searchQuery.length && !searchTag) {
      return false;
    }

    this.searchUrl = new URL(WP.siteUrl);

    this.searchPage = 1;

    const searchSortQuery = $('.search-sort-option.active').attr('data-query');
    const sortParams = new URLSearchParams(searchSortQuery);

    if (searchTag) {
      this.searchQuery = searchTag;
      this.searchUrl = new URL(WP.siteUrl + '/tag/' + this.searchQuery);
    } else {
      this.searchUrl.searchParams.set('s', this.searchQuery);
    }

    sortParams.forEach(function(value, key) {
      _this.searchUrl.searchParams.set(key, value);
    });

    this.$searchLoadMore.addClass('hide');
    this.$searchResults.html('');

    this.currentSearchPage = 1;

    this.getSearchResults();

    return false;
  }

  getSearchResults() {
    const _this = this;
    const initialScrollTop = this.$searchPanel.scrollTop();

    console.log(this.searchUrl.href);

    $.ajax({
      url: this.searchUrl.href,
      success: function(data){
        const $newResults = $(data).find('#search-results');
        const maxPages = $newResults.data('maxpages');
        const results = $newResults.html();

        if (maxPages === 0) {
          _this.$searchResults.html('<div class="grid-item item-s-12 text-align-center"><span>Sorry, this search returned no results</span></div>');
          return;
        }

        _this.$searchResults.append(results);

        _this.$searchPanel.scrollTop(initialScrollTop);

        _this.bindLinks('#search-results a');

        if (_this.currentSearchPage === maxPages) {
          // hide load more button
          _this.$searchLoadMore.addClass('hide');
        } else {
          // iterate load more page url and show load more button
          _this.currentSearchPage++;
          _this.searchUrl.searchParams.set('paged', _this.currentSearchPage);
          _this.$searchLoadMore.attr('href', _this.searchUrl.href).removeClass('hide');
        }
      }
    });
  }

  handleSearchTag(e) {
    this.$searchField.val($(e.currentTarget).attr('data-tagname'));
    this.handleSearchSubmit(null, $(e.currentTarget).attr('data-tag'));
  }

  bindFilterToggle() {
    const _this = this;

    if ($('.filter').length) {
      $('.filter-trigger').off('click.toggleFilter').on('click.toggleFilter', function() {
        const $filter = $(this).closest('.filter');

        if ($filter.hasClass('show')) {
          $filter.removeClass('show');

          _this.unbindClickOutsideFilter();
        } else {
          $filter.siblings('.show').removeClass('show');

          $filter.addClass('show');

          _this.bindClickOutsideFilter();
        }

        return false;
      });

      $('.filter-option').off('click.updateFilter').on('click.updateFilter', function() {
        const filterText = $(this).text();
        const $filter = $(this).closest('.filter');
        const href = $(this).attr('href');

        $(this).siblings('.active').removeClass('active');
        $(this).addClass('active');

        $filter.find('.filter-value').text(filterText);
        $filter.removeClass('show');

        _this.unbindClickOutsideFilter();

        if ($filter.hasClass('collection-filter')) {
          _this.handleRequest(href, 'filter');
        } else {
          _this.handleSearchSubmit(null, false);
        }

        return false;
      });
    }
  }

  bindClickOutsideFilter() {
    $(document).off('click.outsideFilter').on('click.outsideFilter', function(e) {
      const $filter = $('.filter');
      if (!$filter.is(e.target) && $filter.has(e.target).length === 0) {
        $filter.removeClass('show');
      }
    });
  }

  unbindClickOutsideFilter() {
    $(document).off('click.outsideFilter');
  }

  bindUpdateFilter() {
    const _this = this;

    //if ($('.filter').length) {

  }

  pushState(data, url, context, filter) {
    const title = $(data).filter('title').text();
    this.updateMetaData(data, title, url);

    history.pushState({
      context,
      filter
    }, title, url);
  }

  /*
  <meta property="og:title" content="Alice Coltrane &#8211; World Galaxy | In Sheeps Clothing" />
  <meta property="og:site_name" content="In Sheeps Clothing" />
  <meta name="twitter:card" value="summary_large_image">
  <meta property="og:image" content="https://insheepsclothinghifi.com/wordpress/wp-content/uploads/2020/07/World-Galaxy-1000x630.jpg" />  <meta property="og:url" content="https://insheepsclothinghifi.com/wordpress/album/alice-coltrane-world-galaxy/"/>
  <meta property="og:description" content="If you're new to Alice Coltrane, this is an exciting first album to catapult you straight to her planet, whereas other albums might fly you there more slowly. Recorded in two days and featuring a string orchestra of 16, this sonic kaleidoscope features originals by Alice Coltrane, as well as upside down inside out reimaginings of the classic &quot;My Favorite Things&quot; and her late husband John Coltrane's &quot;A Love Supreme.&quot; At its quietest, stillest moments, World Galaxy feels like the classical soundtrack to an old black and white Hollywood film – if the film were to suddenly start morphin..." />
  <meta property="og:type" content="article" />
  */

  updateMetaData(data, title, url) {
    const $meta = $(data).filter('meta');

    document.title = title;

    $.each($meta, function(index, el) {
      const prop = $(el).attr('property');
      const content = $(el).attr('content');
      if (prop) {
        if (prop.startsWith('og:')) {
          $('meta[property="' + prop + '"]').attr('content', content);
        }
      }
    });
  }

  bindBack() {
    const _this = this;
    $(window).on('popstate', function() {
      _this.handleRequest(window.location.href, history.state.context, true);
    });
  }

  handleRequest(href, context = 'content', isPop = false) {
    if (isPop) {
      this.replaceContent(href, context, isPop);
    } else {
      switch (context) {
        case 'filter':
          this.filterResults(href);
          break;
        case 'load-more':
          this.loadMore(href);
          break;
        case 'search-load-more':
          this.getSearchResults();
          break;
        default:
          this.replaceContent(href, context);
          break;
      }
    }
  }

  filterResults(href) {
    const _this = this;
    const $posts = $('#posts');
    const url = new URL(window.location.href);

    const $loadMore = $('#load-more');

    const newUrl = new URL(href);
    newUrl.searchParams.forEach(function(value, key) {
      url.searchParams.set(key, value);
    });

    $('body').addClass('filtering');

    $.ajax({
      url,
      success: function(data){
        const $newPosts = $(data).find('#posts');
        const posts = $newPosts.html();
        const maxPages = parseInt($newPosts.attr('data-maxpages'));

        $posts.html(posts);

        _this.bindLinks();
        _this.bindFilterToggle();
        _this.setupSwiper();

        _this.pushState(data, url, 'filter', url.searchParams.toString());

        _this.currentArchivePage = 1;

        if (maxPages === 1) {
          // hide load more button
          $loadMore.addClass('hide');
        } else {
          // iterate load more page url
          url.searchParams.set('paged', 2);
          $loadMore.attr('href', url.href);
          $loadMore.removeClass('hide');
        }

        $('body').removeClass('filtering');
      }
    });
  }

  loadMore(href, postsSelector = '#posts') {
    const _this = this;
    const url = new URL(href);
    const $posts = $(postsSelector);
    const $loadMore = $('#load-more');
    const maxPages = parseInt($posts.attr('data-maxpages'));
    const nextPage = parseInt(url.searchParams.get('paged'));
    const initialScrollTop = $(window).scrollTop();

    $('body').addClass('loading-more');

    $.ajax({
      url,
      success: function(data){
        const newPosts = $(data).find(postsSelector)[0].innerHTML;

        $posts.append(newPosts);

        $(window).scrollTop(initialScrollTop);

        _this.bindLinks();
        _this.bindFilterToggle();
        _this.setupSwiper();

        _this.currentArchivePage = nextPage;

        if (_this.currentArchivePage === maxPages) {
          // hide load more button
          $loadMore.addClass('hide');
        } else {
          // iterate load more page url
          url.searchParams.set('paged', _this.currentArchivePage + 1);
          $loadMore.attr('href', url.href);
        }

        $('body').removeClass('loading-more');
      }
    });
  }

  replaceContent(href, context, isPop) {
    const _this = this;

    $('body').addClass('loading').removeClass('welcome-open mobile-nav-open gallery-open search-open playlist-open');
    this.destroyOverlaySwiper();

    $.ajax({
      url: href,
      success: function(data){
        const content = $(data).find('#main-content').html();

        $(window).scrollTop(0);

        if (_this.swiperInstance) {
          _this.swiperInstance.destroy();
          _this.swiperInstance = false;
        }

        $('#main-content').html(content);

        _this.bindLinks();
        _this.bindFilterToggle();
        _this.setupSwiper();
        _this.bindStreamButtons();
        _this.replaceOverlayGallery(data);

        if (!isPop) {
          _this.pushState(data, href, context);
        }

        $('body').removeClass('loading');
      }
    });
  }

  replaceOverlayGallery(data) {
    const $overlaySlides = $(data).find('.overlay-gallery-slide');

    if ($overlaySlides.length) {
      $('#overlay-gallery-swiper-wrapper').html($overlaySlides);
      this.setupOverlaySwiper();
    }
  }

  bindStreamButtons() {
    $('.album-stream').on('click', this.audioPlayer.handleSkip);
    $('.streaming-service').on('click', this.audioPlayer.handlePause);
  }

  setupSwiper() {
    this.setupAlbumsSwiper();
    this.setupOverlaySwiper();
    this.setupSelectionSwiper();
  }

  setupAlbumsSwiper() {
    const _this = this;

    if ($('#featured-albums-swiper').length) {
      const args = {
        slidesPerView: 'auto',
        loop: true,
        loopedSlides: 10,
        centeredSlides: true,
        grabCursor: true,
        mousewheel: {
          forceToAxis: true,
        },
        navigation: {
          nextEl: '.next-slide',
          prevEl: '.prev-slide'
        },
        on: {
          init: function(swiper) {
            $('#featured-albums-swiper').on({
              mousemove: function(e) {
                if (event.pageX < _this.windowWidth / 2) {
                  $(this).removeClass('mouse-right')
                    .addClass('mouse-left');
                } else {
                  $(this).removeClass('mouse-left')
                    .addClass('mouse-right');
                }
              },
              mouseleave: function(e) {
                $(this).removeClass('mouse-right mouse-left');
              }
            }).removeClass('hide');
            _this.bindLinks('.swiper-slide a');
          },
          loopFix: function() {
            _this.bindLinks('.swiper-slide a');
          },
        }
      };

      this.albumSwiper = new Swiper ('#featured-albums-swiper', args);
    }
  }

  setupOverlaySwiper() {
    const _this = this;

    this.bindOverlayGallery();

    if ($('.overlay-gallery-slide').length && this.windowWidth >= this.landscapeThreshold) {
      const args = {
        slidesPerView: 'auto',
        loop: true,
        loopedSlides: 10,
        centeredSlides: false,
        mousewheel: {
          forceToAxis: true,
        },
        navigation: {
          nextEl: '.next-slide',
          prevEl: '.prev-slide'
        },
        on: {
          resize: function(swiper) {
            if (_this.windowWidth < _this.landscapeThreshold) {
              swiper.destroy(true);
            }
          }
        }
      };

      this.overlaySwiper = new Swiper ('#overlay-gallery-swiper', args);
    }
  }

  destroyOverlaySwiper() {
    if (this.overlaySwiper) {
      this.overlaySwiper.destroy(true,true);
      $('#overlay-gallery-swiper-wrapper').html('');
      this.overlaySwiper = false;
    }
  }

  setupSelectionSwiper() {
    const _this = this;

    if ($('#post-selection-swiper').length) {
      const args = {
        slidesPerView: 'auto',
        loop: true,
        loopedSlides: 10,
        centeredSlides: false,
        mousewheel: {
          forceToAxis: true,
        },
        navigation: {
          nextEl: '.next-slide',
          prevEl: '.prev-slide'
        },
        on: {
          init: function(swiper) {
            swiper.$el.removeClass('hide');
            _this.bindLinks('.swiper-slide a');
          },
          loopFix: function() {
            _this.bindLinks('.swiper-slide a');
          },
        }
      };

      this.selectionSwiper = new Swiper ('#post-selection-swiper', args);
    }
  }

  fixWidows() {
    // utility class mainly for use on headines to avoid widows [single words on a new line]
    $('.js-fix-widows').each(function(){
      var string = $(this).html();
      string = string.replace(/ ([^ ]*)$/,'&nbsp;$1');
      $(this).html(string);
    });
  }
}

new Site();
new Mailchimp();
