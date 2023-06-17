/////////////////////////////////////////////
// accessibility
/////////////////////////////////////////////
const isReduced = window.matchMedia('(prefers-reduced-motion: reduce)') === true || window.matchMedia('(prefers-reduced-motion: reduce)').matches === true;
if (isReduced) {
  jQuery('.stoppable-js').trigger('pause');
  var animation_duration = 0;
  var animation_duration_counter = 0;
}
else {
  var animation_duration = 500;
  var animation_duration_counter = 1500;
  jQuery(document).on('click', '.accessible-navi-activate-js:not(.initialized)', function (e) {
    var accessible_navi = localStorage.getItem('accessible_navi');
    var original_label = jQuery('.accessible-navi-activate-js').data('original-label');
    var active_label = jQuery('.accessible-navi-activate-js').data('active-label');
    if (accessible_navi === null || accessible_navi === '' || accessible_navi === 'no') {
      localStorage.setItem('accessible_navi', 'yes');
      jQuery('.accessible-navi-activate-js').html(active_label).attr('title', active_label).attr('aria-label', active_label);
      jQuery('body').addClass('body-accessible-navi');
      jQuery('.stoppable-js').trigger('pause');
    };
    if (accessible_navi === 'yes') {
      localStorage.setItem('accessible_navi', 'no');
      jQuery('.accessible-navi-activate-js').html(original_label).attr('title', original_label).attr('aria-label', original_label);
      jQuery('body').removeClass('body-accessible-navi');
      jQuery('.stoppable-js').trigger('play');
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
      jQuery('.stoppable-js').trigger('play');
    };
    if (accessible_navi == 'yes') {
      jQuery('.accessible-navi-activate-js').html(active_label).attr('title', active_label).attr('aria-label', active_label);
      jQuery('body').addClass('body-accessible-navi');
      jQuery('.stoppable-js').trigger('pause');
    }
  }
  set_accessible_navi();
}

jQuery(document).on('click', '.video-stop-js:not(.initialized)', function (e) {
  jQuery(this).toggleClass('pause');
  var video_stop = jQuery(this).data('video-stop');
  var video = jQuery('#' + video_stop).get(0);
  if (video.paused) {
    jQuery('#' + video_stop).trigger('play');
  }
  else {
    jQuery('#' + video_stop).trigger('pause');
  }
  e.preventDefault();
});


/////////////////////////////////////////////
// AOS
/////////////////////////////////////////////

AOS.init({
  duration: 900,
  once: false,
  mirror: true
});

/////////////////////////////////////////////
// Infinite scroll
/////////////////////////////////////////////

function initInfiniteScroll() {
  if (jQuery(".nav-next a")[0]) {
    jQuery('.grid-infinite').infiniteScroll({
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
      AOS.refreshHard();
    });
    window.setInterval(function () {
      if (jQuery('.infinite-scroll-last').is(":visible")) {
        jQuery('#infscr-loading').fadeOut(animation_duration);
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

/////////////////////////////////////////////
// mega menu
/////////////////////////////////////////////

jQuery(document).on('click', '.mega-menu-js-trigger:not(.initialized)', function (e) {
  jQuery('.header-menu-js > .menu-item-has-children > a').removeClass('clicked');
  jQuery('.sub-menu').removeClass('visible');
  data_megamenu_id = jQuery(this).data('megamenu-open-id');
  jQuery('.mega-menu-js').addClass('hidden');
  if (jQuery(this).hasClass('current-mega-menu')) {
    jQuery('.mega-menu-js-trigger').removeClass('current-mega-menu');
    jQuery(this).removeClass('current-mega-menu');
    jQuery('.mega-menu-js-' + data_megamenu_id + '-target').addClass('hidden');
    jQuery('.submenu-close-js').removeClass('active');
  }
  else {
    jQuery('.mega-menu-js-trigger').removeClass('current-mega-menu');
    jQuery(this).addClass('current-mega-menu');
    jQuery('.mega-menu-js-' + data_megamenu_id + '-target').removeClass('hidden');
    jQuery('.submenu-close-js').addClass('active');
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


/////////////////////////////////////////////
// sub menu desktop
/////////////////////////////////////////////

jQuery(document).on('click', '.header-menu-js > .menu-item-has-children > a:not(.initialized)', function (e) {
  jQuery(this).toggleClass('clicked');
  if (jQuery(this).hasClass('clicked')) {
    jQuery(this).addClass('clicked');
    jQuery(this).parent().find('.sub-menu').addClass('visible');
    jQuery('.submenu-close-js').addClass('active');
  }
  else {
    jQuery(this).removeClass('clicked');
    jQuery(this).parent().find('.sub-menu').removeClass('visible');
    jQuery('.submenu-close-js').removeClass('active');
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

jQuery(document).on('click', '.submenu-close-js:not(.initialized)', function (e) {
  jQuery('.header-menu-js > .menu-item-has-children > a').removeClass('clicked');
  jQuery('.sub-menu').removeClass('visible');
  jQuery('.mega-menu-js').addClass('hidden');
  jQuery('.mega-menu-js-trigger').removeClass('current-mega-menu');
  jQuery(this).removeClass('active');
  e.preventDefault();
});


/////////////////////////////////////////////
// sub menu mobile
/////////////////////////////////////////////

jQuery('.overlay-menu-mobile-js > .menu-item-has-children > a').each(function (i, el) {
  jQuery(this).append('<span>▼</span>');
});
jQuery(document).on('click', '.overlay-menu-mobile-js > .menu-item-has-children > a:not(.initialized)', function (e) {
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

jQuery(document).ready(function () {
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

  jQuery('.slide-next-slider-single-js').click(function (e) {
    //e.preventDefault(); 
    jQuery('.slider-single-js').slick('slickNext');
  });
});

/////////////////////////////////////////////
// Numbers counter
/////////////////////////////////////////////

function numbers_counter() {
  if (jQuery('.count')[0]) {
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
          duration: animation_duration_counter,
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
jQuery(document).ready(function () {
  numbers_counter();
});


/////////////////////////////////////////////
// Modals
/////////////////////////////////////////////

jQuery(document).on('click', '.modal-close-js:not(.initialized)', function (e) {
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
  }
});

jQuery(document).on('click', '.modal-open-js:not(.initialized)', function (e) {
  var modal_open_id = jQuery(this).data('modal-open-id');
  var modal_back_to = jQuery(this).data('modal-back-to');
  setTimeout(function () { jQuery('.modal-focus-' + modal_open_id).focus() }, 50);
  localStorage.setItem('modal_back_to', modal_back_to);
  jQuery('.paperplane-modal-js-' + modal_open_id).removeClass('hidden');
  jQuery('html, body').css({
    overflow: 'hidden',
  });
  e.preventDefault();
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
// hide editor section front end labels
/////////////////////////////////////////////

jQuery(document).on('click', '.click-hide:not(.initialized)', function (e) {
  jQuery(this).next('.hide-me').toggleClass('hidden-label');
  var isVisible = jQuery(this).next('.hide-me').hasClass('hidden-label');
  jQuery(this).text(isVisible ? "+" : "-");
  e.preventDefault();
});


/////////////////////////////////////////////
// expandables
/////////////////////////////////////////////

jQuery(document).on('click', '.expander:not(.initialized)', function (e) {
  var expand_id = jQuery(this).data('expand-id');
  if (jQuery('#expand-button-' + expand_id).hasClass('exp-close')) {
    jQuery('#expand-button-' + expand_id).addClass('exp-open').removeClass('exp-close').attr('aria-expanded', false);
    jQuery('#expand-button-' + expand_id).find('span').addClass('exp-plus').removeClass('exp-minus');
    jQuery('#expand-content-' + expand_id).slideUp(animation_duration).removeClass('visible');
  } else {
    jQuery('#expand-button-' + expand_id).addClass('exp-close').removeClass('exp-open').attr('aria-expanded', true);
    jQuery('#expand-button-' + expand_id).find('span').removeClass('exp-plus').addClass('exp-minus');
    jQuery('#expand-content-' + expand_id).slideDown(animation_duration).addClass('visible');
  }
  e.preventDefault();
});

jQuery(document).on('click', '.expander-closer:not(.initialized)', function (e) {
  var expand_id = jQuery(this).data('expand-id');
  jQuery('#expand-button-' + expand_id).addClass('exp-open').removeClass('exp-close').attr('aria-expanded', false);
  jQuery('#expand-button-' + expand_id).find('span').addClass('exp-plus').removeClass('exp-minus');
  jQuery('#expand-content-' + expand_id).slideUp(animation_duration).removeClass('visible');
  e.preventDefault();
});

/////////////////////////////////////////////
// Play video
/////////////////////////////////////////////

var tag = document.createElement('script');
tag.src = "https://www.youtube.com/iframe_api";
var firstScriptTag = document.getElementsByTagName('script')[0];
firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

jQuery(document).on('click', '.play-video-js:not(.initialized)', function (e) {
  var video_source = jQuery(this).data('video-source');
  var video_toplay = jQuery(this).data('video-toplay');
  jQuery(this).fadeOut(300);
  if (video_source == 'vimeo') {
    var iframe = document.getElementById(video_toplay);
    var src = jQuery('#' + video_toplay).attr("data-src");
    jQuery('#' + video_toplay).removeAttr("data-src").attr('src', src);
    var player = new Vimeo.Player(iframe);
    player.play();
    jQuery(document).on('click', '.modal-close-js:not(.initialized)', function (e) {
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
    jQuery(document).on('click', '.modal-close-js:not(.initialized)', function (e) {
      player.pauseVideo();
    });
  }
  if (video_source == 'upload-video') {
    jQuery('#' + video_toplay).trigger('play');
    jQuery(document).on('click', '.modal-close-js:not(.initialized)', function (e) {
      jQuery('#' + video_toplay).trigger('pause');
    });
  }
  e.preventDefault();
});

/////////////////////////////////////////////
// Stop videos in autoplay to enable screensaver
/////////////////////////////////////////////

setTimeout(function () { jQuery('.stoppable-js').trigger('pause') }, 120000);


/////////////////////////////////////////////
// Window scroll / resize events
/////////////////////////////////////////////

jQuery(window).on('scroll', function (e) {
  scrollDirectionMenu();
  numbers_counter();
});
/*
jQuery(window).resize(function () {
  clear_overlay_scroll();
});
*/

/////////////////////////////////////////////
// Clear overlay scroll when resizing desktop - mobile: attivare se la versione desktop non ha menu overlay
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