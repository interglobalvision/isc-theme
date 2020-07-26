/* jshint esversion: 6, browser: true, devel: true, indent: 2, curly: true, eqeqeq: true, futurehostile: true, latedef: true, undef: true, unused: true */
/* global document, WP, URLSearchParams */

// Import dependencies
import $ from 'jquery';
import lazySizes from 'lazysizes';
import Swiper from 'swiper';
import Player from './player';

// Import style
import '../styl/site.styl';

class Site {
  constructor() {
    this.mobileThreshold = 601;
    this.swiperInstance = false;
    this.currentArchivePage = 1;

    this.handleSearchToggle = this.handleSearchToggle.bind(this);
    this.handleSearchSubmit = this.handleSearchSubmit.bind(this);

    $(window).resize(this.onResize.bind(this));

    $(document).ready(this.onReady.bind(this));

  }

  onResize() {
  }

  onReady() {
    lazySizes.init();
    this.bindLinks();
    this.bindFilterToggle();
    this.bindBack();
    this.setupSwiper();
    this.bindSearchEvents();

    this.audioPlayer = new Player();

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

  bindLinks(selector = 'a') {
    const _this = this;

    $(selector).off().on('click', function(e) {
      const target = e.currentTarget;
      const href = $(this).attr('href');

      if ($(target).hasClass('search-toggle')) {
        _this.handleSearchToggle(e);
        return false;
      } else if ($(target).hasClass('filter-option')) {
        return;
      } else if ($(target).closest('.swiper-slide').length) {
        return false;
      } else {
        if (!href.startsWith(WP.siteUrl)) {
          return;
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

    this.$searchForm.on('submit', this.handleSearchSubmit);
    $('#search-toggle-overlay').on('click', this.handleSearchToggle);
  }

  handleSearchToggle() {
    $('body').toggleClass('search-open');
  }

  handleSearchSubmit() {
    const _this = this;
    this.searchUrl = new URL(WP.siteUrl);
    this.searchQuery = this.$searchField.val();
    this.searchPage = 1;

    const searchSortQuery = $('.search-sort-option.active').attr('data-query');
    const sortParams = new URLSearchParams(searchSortQuery);

    this.searchUrl.searchParams.set('s', this.searchQuery);

    sortParams.forEach(function(value, key) {
      _this.searchUrl.searchParams.set(key, value);
    });

    this.currentSearchPage = 1;

    this.getSearchResults();

    return false;
  }

  getSearchResults() {
    const _this = this;
    $.ajax({
      url: this.searchUrl.href,
      success: function(data){
        const $loadMore = $('#search-load-more');
        const $resultsWrapper = $('#search-results');
        const $newResultsWrapper = $(data).find('#search-results');
        const maxPages = $newResultsWrapper.data('maxpages');
        const newResults = $newResultsWrapper.html();

        $resultsWrapper.append(newResults);
        _this.bindLinks('#search-results a');

        if (_this.currentSearchPage === maxPages) {
          // hide load more button
          $loadMore.addClass('hide');
        } else {
          // iterate load more page url and show load more button
          _this.currentSearchPage++;
          _this.searchUrl.searchParams.set('paged', _this.currentSearchPage);
          $loadMore.attr('href', _this.searchUrl.href).removeClass('hide');
        }

        //$('body').removeClass('loading-more');
      }
    });
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
          console.log('filter');
          //_this.updateSearchSort(href, 'filter');
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
    document.title = title;
    history.pushState({
      context,
      filter
    }, title, url);
  }

  bindBack() {
    const _this = this;
    $(window).on('popstate', function() {
      console.log('back', window.location.href);
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
    const newUrl = new URL(href);
    newUrl.searchParams.forEach(function(value, key) {
      url.searchParams.set(key, value);
    });

    $('body').addClass('filtering');

    $.ajax({
      url,
      success: function(data){
        const newPosts = $(data).find('#posts')[0].innerHTML;
        $posts.html(newPosts);
        _this.bindLinks();
        _this.bindFilterToggle();
        _this.setupSwiper();
        _this.pushState(data, url, 'filter', url.searchParams.toString());
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

    $('body').addClass('loading-more');

    $.ajax({
      url,
      success: function(data){
        const newPosts = $(data).find(postsSelector)[0].innerHTML;

        $posts.append(newPosts);

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

    $('body').addClass('loading');
    $.ajax({
      url: href,
      success: function(data){
        const content = $(data).find('#main-content')[0].innerHTML;

        $(window).scrollTop(0);

        if (_this.swiperInstance) {
          _this.swiperInstance.destroy();
          _this.swiperInstance = false;
        }

        $('#main-content').html(content);

        _this.bindLinks();
        _this.bindFilterToggle();
        _this.setupSwiper();

        //bind album stream button
        $('.album-stream').on('click', _this.audioPlayer.handleSkip);

        if (!isPop) {
          _this.pushState(data, href, context);
        }

        $('body').removeClass('loading');
      }
    });
  }

  setupSwiper() {
    if ($('.swiper-container').length) {
      const _this = this;
      const swiperArgs = {
        slidesPerView: 'auto',
        loop: true,
        loopedSlides: 3,
        spaceBetween: $(window).width() * 0.2,
        centeredSlides: true,
        slideToClickedSlide: true,
        preventClicks: true,
        preventClicksPropagation: true,
        on: {
          init: function() {
            _this.bindLinks('.swiper-slide a');
          },
          loopFix: function() {
            _this.bindLinks('.swiper-slide a');
          },
        }
      };
      this.swiperInstance = new Swiper ('.swiper-container', swiperArgs);
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
