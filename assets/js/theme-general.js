/////////////////////////////////////////////
// accessibility
/////////////////////////////////////////////
jQuery('.accessible-navi-activate-js').on('click', function (e) {
  var accessible_navi = localStorage.getItem('accessible_navi');
  var original_label = jQuery('.accessible-navi-activate-js').data('original-label');
  var active_label = jQuery('.accessible-navi-activate-js').data('active-label');
  console.log(accessible_navi);
  if (accessible_navi === null || accessible_navi === '' || accessible_navi === 'no') {
    localStorage.setItem('accessible_navi', 'yes');
    jQuery('.accessible-navi-activate-js').html(active_label).attr('title', active_label).attr('aria-label', active_label);
    jQuery('body').addClass('body-accessible-navi');
    jQuery('video').trigger('pause');
  };
  if (accessible_navi === 'yes') {
    localStorage.setItem('accessible_navi', 'no');
    jQuery('.accessible-navi-activate-js').html(original_label).attr('title', original_label).attr('aria-label', original_label);
    jQuery('body').removeClass('body-accessible-navi');
  }
  e.preventDefault();
});

function set_accessible_navi() {
  var accessible_navi = localStorage.getItem('accessible_navi');
  var original_label = jQuery('.accessible-navi-activate-js').data('original-label');
  var active_label = jQuery('.accessible-navi-activate-js').data('active-label');
  if (accessible_navi === null || accessible_navi === '' || accessible_navi === 'no') {
    jQuery('.accessible-navi-activate-js').html(original_label).attr('title', original_label).attr('aria-label', original_label);
    jQuery('body').removeClass('body-accessible-navi');
  };
  if (accessible_navi == 'yes') {
    jQuery('.accessible-navi-activate-js').html(active_label).attr('title', active_label).attr('aria-label', active_label);
    jQuery('body').addClass('body-accessible-navi');
    jQuery('video').hide();
  }
}
set_accessible_navi();

/////////////////////////////////////////////
// AOS
/////////////////////////////////////////////
//var aos_win_height = (jQuery(window).height() / 2.5);
AOS.init({
  duration: 900,
  once: false,
  mirror: true,
  //offset: aos_win_height
});

/////////////////////////////////////////////
// Infinite scroll
/////////////////////////////////////////////

function initInfiniteScroll() {
  if (jQuery(".nav-next a")[0]) {
    jQuery('.grid-infinite').infiniteScroll({
      // options
      path: '.nav-next a',
      append: '.grid-item-infinite',
      status: '#infscr-loading',
      prefill: true,
      loadOnScroll: false,
      history: false,
      button: '.view-more-button-js',
      scrollThreshold: false,
      checkLastPage: true
    });

    jQuery('.grid-infinite').on('append.infiniteScroll', function (event, response, path, items) {
      paperPlaneLazyLoad.update();
      AOS.refreshHard();
    });
    window.setInterval(function () {
      if (jQuery('.infinite-scroll-last').is(":visible")) {
        jQuery('#infscr-loading').fadeOut(300);
      }
    }, 3000);
  }
}
initInfiniteScroll();

/////////////////////////////////////////////
// impaginazione forzata immagini e video in the_content()
/////////////////////////////////////////////

function manipulateContent(e) {
  // Wrappo i video player in una div per dimensionarli responsive
  jQuery('.content-styled iframe').wrap('<div class="video-frame"></div>');
  // Controllo se l'immagine ha la didascalia e se manca la wrappo per allinearla
  if (!jQuery('img.alignnone').closest('.wp-caption').length) {
    jQuery('img.alignnone').wrap('<div class="wp-caption alignnone"></div>');
  }
  if (!jQuery('img.aligncenter').closest('.wp-caption').length) {
    jQuery('img.aligncenter').wrap('<div class="wp-caption aligncenter"></div>');
  }
  if (jQuery('img.alignleft')) {
    jQuery('img.alignleft').wrap('<div class="wp-caption alignleft"></div>');
  }
  if (jQuery('img.alignright')) {
    jQuery('img.alignright').wrap('<div class="wp-caption alignright"></div>');
  }
}
manipulateContent();

/////////////////////////////////////////////
// hamburger
/////////////////////////////////////////////

function hamburgerMenu(e) {
  jQuery('.hambuger-element').toggleClass('open');
  if (jQuery('.hambuger-element').hasClass('open')) {
    jQuery('html, body').css({
      overflow: 'hidden',
    });
    jQuery(this).attr('aria-expanded', true);
  } else {
    jQuery('html, body').css({
      overflow: 'visible',
    });
    jQuery('#header').focus();
    jQuery(this).attr('aria-expanded', false);
    jQuery('.scroll-opportunity').scrollTop(0);
  }
  jQuery('#head-overlay').toggleClass('hidden');
  jQuery('.mega-menu-js').addClass('hidden');
  jQuery('.mega-menu-js-trigger').removeClass('current-mega-menu');
  setTimeout(function () { jQuery('#menu-overlay-menu-mobile > li:first a').focus() }, 50);
}

jQuery('#head-overlay a:last').on('keydown', function (event) {
  if (event.keyCode == 9) {
    jQuery('.accessible-navi').click();
    hamburgerMenu();
  }
});


/////////////////////////////////////////////
// menu scroll effect
/////////////////////////////////////////////

var lastScrollTop = 0;

function scrollDirectionMenu() {
  var st = jQuery(this).scrollTop();
  if ((st > lastScrollTop) && (st > 100) && !jQuery('.hambuger-element').hasClass('open')) {
    // downscroll code
    jQuery('#header').addClass('hidden');
    jQuery('.mega-menu-js').addClass('hidden');
    jQuery('.mega-menu-js-trigger').removeClass('current-mega-menu');
    jQuery('.header-menu-js > .menu-item-has-children > a').removeClass('clicked');
    jQuery('.sub-menu').removeClass('visible');
  } else {
    // upscroll code
    jQuery('#header').removeClass('hidden');
  }
  lastScrollTop = st;
}

jQuery(window).on('scroll', function (event) {
  scrollDirectionMenu();
});

/////////////////////////////////////////////
// mega menu
/////////////////////////////////////////////

jQuery('.mega-menu-js-trigger').on('click', function (e) {
  jQuery('.header-menu-js > .menu-item-has-children > a').removeClass('clicked');
  jQuery('.sub-menu').removeClass('visible');
  data_megamenu_id = jQuery(this).data('megamenu-open-id');
  jQuery('.mega-menu-js').addClass('hidden');
  if (jQuery(this).hasClass('current-mega-menu')) {
    jQuery('.mega-menu-js-trigger').removeClass('current-mega-menu');
    jQuery(this).removeClass('current-mega-menu');
    jQuery('.mega-menu-js-' + data_megamenu_id + '-target').addClass('hidden');
  }
  else {
    jQuery('.mega-menu-js-trigger').removeClass('current-mega-menu');
    jQuery(this).addClass('current-mega-menu');
    jQuery('.mega-menu-js-' + data_megamenu_id + '-target').removeClass('hidden');
  }
  e.preventDefault();
});

jQuery('.mega-menu-js-trigger').on('keydown', function (event) {
  jQuery('.header-menu-js > .menu-item-has-children > a').removeClass('clicked');
  jQuery('.sub-menu').removeClass('visible');
  data_megamenu_id = jQuery(this).data('megamenu-open-id');
  if (event.keyCode == 9) {
    jQuery('.mega-menu-js-trigger').removeClass('current-mega-menu');
    jQuery(this).addClass('current-mega-menu');
    jQuery('.mega-menu-js').addClass('hidden');
    jQuery('.mega-menu-js-' + data_megamenu_id + '-target').removeClass('hidden');
    setTimeout(function () { jQuery('.mega-menu-page-list-' + data_megamenu_id + ' > li:first a').focus() }, 50);
    event.preventDefault();
  }
});

jQuery('.mega-menu-clicker-js').click(function () {
  jQuery('.mega-menu-js').addClass('hidden');
  jQuery('.mega-menu-js-trigger').removeClass('current-mega-menu');
});

/////////////////////////////////////////////
// sub menu desktop
/////////////////////////////////////////////

jQuery('.header-menu-js > .menu-item-has-children > a').on('click', function (e) {
  jQuery(this).toggleClass('clicked');
  if (jQuery(this).hasClass('clicked')) {
    jQuery(this).addClass('clicked');
    jQuery(this).parent().find('.sub-menu').addClass('visible');
  }
  else {
    jQuery(this).removeClass('clicked');
    jQuery(this).parent().find('.sub-menu').removeClass('visible');
  }
  jQuery('.header-menu-js > .menu-item-has-children > a').not(this).removeClass('clicked');
  jQuery('.header-menu-js > .menu-item-has-children > a').not(this).parent().find('.sub-menu').removeClass('visible');
  jQuery('.mega-menu-js').addClass('hidden');
  jQuery('.mega-menu-js-trigger').removeClass('current-mega-menu');

  e.preventDefault();
});

jQuery('.header-menu-js > .menu-item-has-children > a').on('keydown', function (event) {
  jQuery('.header-menu-js > .menu-item-has-children > a').removeClass('clicked');
  jQuery('.sub-menu').removeClass('visible');
  if (event.keyCode == 9) {
    jQuery(this).addClass('clicked');
    jQuery(this).parent().find('.sub-menu').addClass('visible');
    jQuery(this).parent().find('.sub-menu > li:first a').focus();
    setTimeout(function () { jQuery(this).addClass('kaka') }, 50);
    event.preventDefault();
  }
});

/////////////////////////////////////////////
// sub menu mobile
/////////////////////////////////////////////

jQuery('.overlay-menu-mobile-js > .menu-item-has-children > a').each(function (i, el) {
  jQuery(this).append('<span>▼</span>');
});
jQuery('.overlay-menu-mobile-js > .menu-item-has-children > a').on('click', function (e) {
  //alert('sdfsdf');
  if (jQuery(this).find('span').text() == "▼") {
    jQuery(this).find('span').text("▲");
  } else {
    jQuery(this).find('span').text("▼");
  }
  jQuery(this).parent().find('.sub-menu').slideToggle(150);
  e.preventDefault();
});

/////////////////////////////////////////////
// slick slideshow
/////////////////////////////////////////////


jQuery('.slider-single-js').on('init reInit', function (event, slick, currentSlide, nextSlide) {
  AOS.refresh();
});

jQuery(document).on('keydown', function (e) {
  if (e.keyCode == 37) {
    jQuery('.slider-single-js').slick('slickPrev');
  }
  if (e.keyCode == 39) {
    jQuery('.slider-single-js').slick('slickNext');
  }
});

jQuery('.slider-single-js').slick({
  lazyLoad: 'progressive',
  dots: true,
  focusOnSelect: true,
  draggable: true,
  infinite: true,
  accessibility: true,
  adaptiveHeight: false,
  slidesToShow: 1,
  slidesToScroll: 1,
  arrows: true,
  nextArrow: '<div class="slick-next">→</div>',
  prevArrow: '<div class="slick-prev">←</div>',
  responsive: [{
    breakpoint: 1024,
    settings: {
      slidesToShow: 1,
      slidesToScroll: 1
    }
  }]
});

/////////////////////////////////////////////
// Numbers counter
/////////////////////////////////////////////


function numbers_counter() {
  if (jQuery('.count')[0]) {
    if (jQuery('body').hasClass('body-accessible-navi')) {
      jQuery('.count').each(function (i, el) {
        data_number = jQuery(this).data('bar-number');
        jQuery(this).html(data_number);
      });
    }
    else {
      var win_height = (jQuery(window).height() / 1.2);
      var scrollTop = jQuery(window).scrollTop();
      jQuery('.count').each(function (i, el) {
        data_number = jQuery(this).data('bar-number');
        elementOffset = jQuery(this).offset().top,
          distance = (elementOffset - scrollTop);
        if (distance < win_height) {
          jQuery(this).prop('Counter', 0).animate({
            Counter: jQuery(this).attr('data-bar-number')
          }, {
            duration: 2000,
            easing: 'swing',
            step: function (now) {
              jQuery(this).text(Math.ceil(now));
              if (now < (jQuery(this).attr('data-bar-number') - 2)) {
                jQuery(this).addClass('blurred-counter');
              } else {
                jQuery(this).removeClass('blurred-counter');
              }
            }

          });
        }

      });
    }
  }
}
jQuery(document).ready(function () {
  numbers_counter();
});


/////////////////////////////////////////////
// Modals
/////////////////////////////////////////////

jQuery('.modal-close-js').click(function (e) {
  var modal_close_id = jQuery(this).data('modal-close-id');
  var modal_back_to = localStorage.getItem('modal_back_to');
  jQuery(modal_close_id).addClass('hidden');
  jQuery('html, body').css({
    overflow: 'visible',
  });
  setTimeout(function () { jQuery('.' + modal_back_to).focus() }, 50);
  e.preventDefault();
});


jQuery('.paperplane-modal-js').keyup(function (event) {
  if (event.which == 27) {
    var modal_close_id = jQuery(this).data('modal-close-id');
    var modal_back_to = localStorage.getItem('modal_back_to');
    setTimeout(function () { jQuery('.' + modal_back_to).focus() }, 50);
    jQuery(modal_close_id).addClass('hidden');
    jQuery('html, body').css({
      overflow: 'visible',
    });
    //e.preventDefault();
  }
});

jQuery('.modal-open-js').on('click', function (e) {
  var modal_open_id = jQuery(this).data('modal-open-id');
  var modal_back_to = jQuery(this).data('modal-back-to');
  setTimeout(function () { jQuery('.modal-focus-' + modal_open_id).focus() }, 50);
  localStorage.setItem('modal_back_to', modal_back_to);
  jQuery('.paperplane-modal-js-' + modal_open_id).removeClass('hidden');
  jQuery('html, body').css({
    overflow: 'hidden',
  });
  //e.preventDefault();
});

if (window.location.hash) {
  var hash = window.location.hash;
  var pattern = /modal-focus-/;
  var exists = pattern.test(hash);
  if (exists) {
    var modal_open_id = hash.substring(13, hash.length);
    jQuery('.paperplane-modal-js-' + modal_open_id).removeClass('hidden');
    setTimeout(function () { jQuery('.modal-focus-' + modal_open_id).focus() }, 50);
    jQuery('html, body').css({
      overflow: 'hidden',
    });
  }
}

/////////////////////////////////////////////
// Clear ovarlay scroll when resizing desktop - mobile if desktop has no overlay menu
/////////////////////////////////////////////

function clear_overlay_scroll() {
  var clear_overlay_scroll_window_width = jQuery(window).width();
  if (!jQuery('#head-overlay').hasClass('hidden')) {
    if (clear_overlay_scroll_window_width > 1023) {
      jQuery('html, body').css({
        overflow: 'visible',
      });
    } else {
      jQuery('html, body').css({
        overflow: 'hidden',
      });
    }
  }
}

/////////////////////////////////////////////
// Window scroll / resize events
/////////////////////////////////////////////
//let scrollRef = 0;

jQuery(window).on('scroll', function (e) {
  numbers_counter();
});

//jQuery(window).resize(function() {
//});

/////////////////////////////////////////////
// hide editor section front end labels
/////////////////////////////////////////////
jQuery('.click-hide').on('click', function (e) {
  jQuery(this).next('.hide-me').toggleClass('hidden-label');
  var isVisible = jQuery(this).next('.hide-me').hasClass('hidden-label');
  jQuery(this).text(isVisible ? "+" : "-");
  e.preventDefault();
});


/////////////////////////////////////////////
// expandables
/////////////////////////////////////////////
jQuery('.expander').on('click', function (e) {
  if (jQuery(this).hasClass('exp-close')) {
    jQuery(this).addClass('exp-open').removeClass('exp-close').attr('aria-expanded', false);
    jQuery(this).find('span').addClass('exp-plus').removeClass('exp-minus');
    jQuery(this).parent().next('.expandable-content').slideUp(150).removeClass('visible');
  } else {
    jQuery(this).addClass('exp-close').removeClass('exp-open').attr('aria-expanded', true);
    jQuery(this).find('span').removeClass('exp-plus').addClass('exp-minus');
    jQuery(this).parent().next('.expandable-content').slideDown(150).addClass('visible');
  }
  e.preventDefault();
});


/////////////////////////////////////////////
// Play video
/////////////////////////////////////////////

var tag = document.createElement('script');
tag.src = "https://www.youtube.com/iframe_api";
var firstScriptTag = document.getElementsByTagName('script')[0];
firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

jQuery('.play-video-js').on('click', function (e) {
  var video_source = jQuery(this).data('video-source');
  var video_toplay = jQuery(this).data('video-toplay');
  jQuery(this).fadeOut(300);
  if (video_source == 'vimeo') {
    var iframe = document.getElementById(video_toplay);
    var src = jQuery('#' + video_toplay).attr("data-src");
    jQuery('#' + video_toplay).removeAttr("data-src").attr('src', src);
    var player = new Vimeo.Player(iframe);
    player.play();
    jQuery('.modal-close-js').click(function (e) {
      player.pause();
    });
  }
  if (video_source == 'youtube') {

    var youtube_video_id = jQuery(this).data('youtube-video-id');
    var player;
    player = new YT.Player(video_toplay, {
      height: '360',
      width: '640',
      modestbranding: 1,
      enablejsapi: 1,
      videoId: youtube_video_id,
      events: {
        'onReady': onPlayerReady
      }
    });
    function onPlayerReady(event) {
      event.target.playVideo();
    }
    jQuery('.modal-close-js').click(function (e) {
      //player.pauseVideo();
    });
  }
  if (video_source == 'upload-video') {
    jQuery('#' + video_toplay).trigger('play');
  }
  e.preventDefault();
});