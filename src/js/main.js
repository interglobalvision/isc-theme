/* jshint esversion: 6, browser: true, devel: true, indent: 2, curly: true, eqeqeq: true, futurehostile: true, latedef: true, undef: true, unused: true */
/* global document, WP */

// Import dependencies
import $ from 'jquery';
import lazySizes from 'lazysizes';

// Import style
import '../styl/site.styl';

class Site {
  constructor() {
    this.mobileThreshold = 601;

    $(window).resize(this.onResize.bind(this));

    $(document).ready(this.onReady.bind(this));

  }

  onResize() {
  }

  onReady() {
    lazySizes.init();
    this.bindLinks();
    this.bindBack();

    //this.count();
    //this.thetime = 1;
  }

  count() {
    const _this = this;
    setInterval(function() {
      _this.thetime++;
      console.log(_this.thetime);
      $('#counter').html(_this.thetime);
    }, 1000);
  }

  bindLinks() {
    const _this = this;

    $('a').off().on('click', function(e) {
      const href = $(this).attr('href');
      const target = e.currentTarget;

      if (!href.startsWith(WP.siteUrl)) {
        window.location = href;
      }

      const context = $(target).attr('data-context') !== undefined ? $(target).attr('data-context') : 'content';
      _this.handleRequest(href, context);

      return false;
    });
  }

  pushState(data, url, context) {
    const title = $(data).filter('title').text();
    document.title = title;
    history.pushState({context}, title, url);
  }

  bindBack() {
    const _this = this;
    $(window).on('popstate', function() {
      _this.handleRequest(window.location.href, history.state.context);
    });
  }

  handleRequest(url, context) {
    switch (context) {
      case 'filter':
        console.log('filter');
        break;
      case 'paginate':
        console.log('paginate');
        break;
      default:
        this.handleAjax(url);
        break;
    }
  }

  handleAjax(url) {
    const _this = this;
    $.ajax({
      url,
      success: function(data){
        const content = $(data).find('#main-content')[0].innerHTML;
        $('#main-content').html(content);
        _this.bindLinks();
        _this.pushState(data, url, 'content');
      }
    });
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
