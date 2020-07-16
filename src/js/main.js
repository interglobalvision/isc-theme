/* jshint esversion: 6, browser: true, devel: true, indent: 2, curly: true, eqeqeq: true, futurehostile: true, latedef: true, undef: true, unused: true */
/* global document, WP */

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

    $(window).resize(this.onResize.bind(this));

    $(document).ready(this.onReady.bind(this));

  }

  onResize() {
  }

  onReady() {
    this.$posts = $('#posts');
    this.$loadMore = $('#load-more');

    lazySizes.init();
    this.bindLinks();
    this.bindFilters();
    this.bindBack();
    this.setupSwiper();

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
      const href = $(this).attr('href');
      const target = e.currentTarget;

      if ($(target).hasClass('filter-option')) {
        return;
      }

      if ($(target).closest('.swiper-slide').length) {
        return false;
      }

      if (!href.startsWith(WP.siteUrl)) {
        window.location = href;
      }

      if (_this.swiperInstance) {
        _this.swiperInstance.destroy();
        _this.swiperInstance = false;
      }

      const context = $(target).attr('data-context') !== undefined ? $(target).attr('data-context') : 'content';
      _this.handleRequest(href, context);

      return false;
    });
  }

  bindFilters() {
    const _this = this;

    if ($('.filter').length) {
      $('.filter-trigger').off().on('click', function() {
        $(this).closest('.filter').addClass('show');
      });

      $('.filter-option').off().on('click', function() {
        const filterText = $(this).text();
        const $filter = $(this).closest('.filter');
        const href = $(this).attr('href');

        $filter.find('.filter-value').text(filterText);
        $filter.removeClass('show');

        _this.handleRequest(href, 'filter');

        return false;
      });
    }
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
        default:
          this.replaceContent(href, context);
          break;
      }
    }
  }

  filterResults(href) {
    const _this = this;
    const url = new URL(window.location.href);
    const newUrl = new URL(href);
    newUrl.searchParams.forEach(function(value, key) {
      url.searchParams.set(key, value);
    });

    $('body').addClass('filtering');

    $.ajax({
      url,
      success: function(data){
        const posts = $(data).find('#posts')[0].innerHTML;
        $('#posts').html(posts);
        _this.bindLinks();
        _this.bindFilters();
        _this.setupSwiper();
        _this.pushState(data, url, 'filter', url.searchParams.toString());
        $('body').removeClass('filtering');
      }
    });
  }

  loadMore(href) {
    const _this = this;
    const url = new URL(href);
    const maxPages = parseInt(this.$posts.attr('data-max-pages'));
    const nextPage = parseInt(url.searchParams.get('paged'));

    $('body').addClass('loading-more');

    $.ajax({
      url,
      success: function(data){
        const posts = $(data).find('#posts')[0].innerHTML;
        
        $('#posts').append(posts);

        _this.bindLinks();
        _this.bindFilters();
        _this.setupSwiper();

        _this.currentArchivePage = nextPage;

        if (_this.currentArchivePage === maxPages) {
          // hide load more button
          _this.$loadMore.addClass('hide');
        } else {
          // iterate load more page url
          url.searchParams.set('paged', _this.currentArchivePage + 1);
          _this.$loadMore.attr('href', url.href);
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

        $('#main-content').html(content);

        _this.bindLinks();
        _this.bindFilters();
        _this.setupSwiper();

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
new Player();
