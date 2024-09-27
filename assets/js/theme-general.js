/////////////////////////////////////////////
// accessibility default
/////////////////////////////////////////////
const isReduced = window.matchMedia('(prefers-reduced-motion: reduce)') === true || window.matchMedia('(prefers-reduced-motion: reduce)').matches === true;
if (isReduced) {
  //jQuery('.stoppable-js').trigger('pause');
  //jQuery('.animation-play-pause-js').removeClass('pause').addClass('play').attr('aria-pressed', false);
  //var animation_duration = 0;
  //var animation_duration_counter = 0;
  jQuery('.reduce-motion-button-js').addClass('hidden');
}
else {
  var animation_duration, animation_duration_counter;
}

/////////////////////////////////////////////
// accessibility user
/////////////////////////////////////////////

var theme_version = jQuery('meta[name=theme-version]').attr('data-theme-version');
function saveArrayToLocalStorage(arrayName, array) {
  localStorage.setItem(arrayName, JSON.stringify(array));
}
function addHours(date, hours) {
  date.setTime(date.getTime() + hours * 60 * 60 * 1000);
  return date;
}
// Example usage
//const myArray = { reduced_motion: 0, reduced_transparency: 0 };
//saveArrayToLocalStorage('paperplane_user_preferences_', myArray);

if (localStorage.getItem('paperplane_user_preferences_' + theme_version) != null) {
  const now = new Date();
  const paperplane_user_preferences_array = JSON.parse(
    localStorage.getItem('paperplane_user_preferences_' + theme_version),
  );
  Object.keys(paperplane_user_preferences_array).forEach(function (key) {
    if (key == 'expiry' && now.getTime() > paperplane_user_preferences_array[key]) {
      localStorage.removeItem('paperplane_user_preferences_' + theme_version);
    }
  });
}

if (localStorage.getItem('paperplane_user_preferences_' + theme_version) === null) {
  const expry_date = addHours(new Date(), (1 * 24) * 365);
  //const expry_date = addHours(new Date(), 1 / 60);
  const initial_a11y_values = { expiry: expry_date.getTime(), reduced_motion: 1, reduced_transparency: 0, dark_mode: 0 };
  saveArrayToLocalStorage('paperplane_user_preferences_' + theme_version, initial_a11y_values);
}

jQuery(document).on('click', '.paperplane-reduce-motion-js:not(.initialized)', function (e) {
  const paperplane_user_preferences_array = JSON.parse(
    localStorage.getItem('paperplane_user_preferences_' + theme_version),
  );
  Object.keys(paperplane_user_preferences_array).forEach(function (key) {

    if (key == 'reduced_motion' && paperplane_user_preferences_array[key] == 0) {
      paperplane_user_preferences_array[key] = 1;
    }
    else if (key == 'reduced_motion' && paperplane_user_preferences_array[key] == 1) {
      paperplane_user_preferences_array[key] = 0;
    }
  });
  saveArrayToLocalStorage('paperplane_user_preferences_' + theme_version, paperplane_user_preferences_array);
  user_set_accessibility();
  e.preventDefault();
});

jQuery(document).on('click', '.paperplane-reduce-transparency-js:not(.initialized)', function (e) {
  const paperplane_user_preferences_array = JSON.parse(
    localStorage.getItem('paperplane_user_preferences_' + theme_version),
  );
  Object.keys(paperplane_user_preferences_array).forEach(function (key) {
    if (key == 'reduced_transparency' && paperplane_user_preferences_array[key] == 1) {
      paperplane_user_preferences_array[key] = 0;
    }
    else if (key == 'reduced_transparency' && paperplane_user_preferences_array[key] == 0) {
      paperplane_user_preferences_array[key] = 1;
    }
  });
  saveArrayToLocalStorage('paperplane_user_preferences_' + theme_version, paperplane_user_preferences_array);
  user_set_accessibility();
  e.preventDefault();
});

jQuery(document).on('click', '.paperplane-darkmode-js:not(.initialized)', function (e) {
  const expry_date_cookie = addHours(new Date(), (1 * 24) * 365);
  const paperplane_user_preferences_array = JSON.parse(
    localStorage.getItem('paperplane_user_preferences_' + theme_version),
  );
  Object.keys(paperplane_user_preferences_array).forEach(function (key) {
    if (key == 'dark_mode' && paperplane_user_preferences_array[key] == 1) {
      paperplane_user_preferences_array[key] = 0;
      document.cookie = "dark_mode=0; SameSite=None; Secure; expires=" + expry_date_cookie + "";
      jQuery('body').attr('data-theme-color', '');
    }
    else if (key == 'dark_mode' && paperplane_user_preferences_array[key] == 0) {
      paperplane_user_preferences_array[key] = 1;
      document.cookie = "dark_mode=1; SameSite=None; Secure; expires=" + expry_date_cookie + "";
      jQuery('body').attr('data-theme-color', 'dark');
    }
  });
  saveArrayToLocalStorage('paperplane_user_preferences_' + theme_version, paperplane_user_preferences_array);
  user_set_accessibility();
  e.preventDefault();
});

function user_set_accessibility() {
  const paperplane_user_preferences_options_array = JSON.parse(
    localStorage.getItem('paperplane_user_preferences_' + theme_version),
  );
  Object.keys(paperplane_user_preferences_options_array).forEach(function (key) {
    if ((key == 'reduced_motion' && paperplane_user_preferences_options_array[key] == 0) || isReduced) {
      jQuery('body').addClass('body-reduced-motion');
      jQuery('.stoppable-js').trigger('pause');
      jQuery('.animation-play-pause-js').removeClass('pause').addClass('play').attr('aria-pressed', false);
      jQuery('.paperplane-reduce-motion-js').attr('aria-checked', 'false');
      animation_duration = 0;
      animation_duration_counter = 0;
    }
    else if (key == 'reduced_motion' && paperplane_user_preferences_options_array[key] == 1) {
      jQuery('body').removeClass('body-reduced-motion');
      jQuery('.stoppable-js').trigger('play');
      jQuery('.animation-play-pause-js').addClass('pause').removeClass('play').attr('aria-pressed', true);
      jQuery('.paperplane-reduce-motion-js').attr('aria-checked', 'true');
      animation_duration = 500;
      animation_duration_counter = 1500;
    }
    if (key == 'reduced_transparency' && paperplane_user_preferences_options_array[key] == 1) {
      jQuery('body').addClass('body-reduced-transparency');
      jQuery('.paperplane-reduce-transparency-js').attr('aria-checked', 'true');
    }
    else if (key == 'reduced_transparency' && paperplane_user_preferences_options_array[key] == 0) {
      jQuery('body').removeClass('body-reduced-transparency');
      jQuery('.paperplane-reduce-transparency-js').attr('aria-checked', 'false');
    }
    if (key == 'dark_mode' && paperplane_user_preferences_options_array[key] == 1) {
      //jQuery('html').attr('data-theme-color', 'dark');
      jQuery('.paperplane-darkmode-js').attr('aria-checked', 'true');
    }
    else if (key == 'dark_mode' && paperplane_user_preferences_options_array[key] == 0) {
      //jQuery('html').attr('data-theme-color', '');
      jQuery('.paperplane-darkmode-js').attr('aria-checked', 'false');
    }
  });

}

user_set_accessibility();

function acessibility_panel_hide() {
  var scroll = jQuery(window).scrollTop();
  if (scroll > 200) {
    jQuery('.reduce-motion-overlay-js').addClass('hidden');
  }
  else {
    jQuery('.reduce-motion-overlay-js').removeClass('hidden');
  }
}


/////////////////////////////////////////////
// Video bg play/pause
/////////////////////////////////////////////

jQuery(document).on('click', '.animation-play-pause-js:not(.initialized)', function (e) {
  var video_stop = jQuery(this).data('video-stop');
  var video = jQuery('#' + video_stop).get(0);
  if (video.paused) {
    jQuery('#' + video_stop).trigger('play');
    jQuery(this).addClass('pause').removeClass('play').attr('aria-pressed', true);
  }
  else {
    jQuery('#' + video_stop).trigger('pause');
    jQuery(this).removeClass('pause').addClass('play').attr('aria-pressed', false);
  }
  e.preventDefault();
});

/////////////////////////////////////////////
// Animation play/pause
/////////////////////////////////////////////

jQuery(document).on('click', '.animation-stop-js:not(.initialized)', function (e) {
  var video_stop = jQuery(this).data('video-stop');
  if (jQuery(this).hasClass('pause')) {
    jQuery('#' + video_stop).removeClass('animate');
    jQuery(this).addClass('play').removeClass('pause').attr('aria-pressed', true);
  }
  else {
    jQuery('#' + video_stop).addClass('animate');
    jQuery(this).removeClass('play').addClass('pause').attr('aria-pressed', false);
  }
  e.preventDefault();
});

/////////////////////////////////////////////
// Stop videos in autoplay to enable screensaver
/////////////////////////////////////////////

setTimeout(function () {
  jQuery('.stoppable-js').trigger('pause');
  jQuery('.animation-play-pause-js').removeClass('pause').addClass('play').attr('aria-pressed', false);
}, 120000);

/////////////////////////////////////////////
// z-index for focused links
/////////////////////////////////////////////

jQuery('body').on('keydown', function (event) {
  if (event.keyCode == 9) {
    jQuery('a').on('focusin', function () {
      jQuery('.aos-animate').removeClass('aos-animate').addClass('unset-aos-animate');
    });
    jQuery('a').on('focusout', function () {
      jQuery('.unset-aos-animate').removeClass('aos-animate').addClass('aos-animate');
    });
  }
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
// menu scroll effect
/////////////////////////////////////////////

var lastScrollTop = 0;

function scrollDirectionMenu() {
  var st = jQuery(this).scrollTop();
  /*
  if ((st > lastScrollTop) && (st > 100) && !jQuery('.hambuger-element').hasClass('open')) {
    // downscroll code
    jQuery('#header').addClass('hidden');
    jQuery('.mega-menu-js').addClass('hidden');
    jQuery('.mega-menu-js-trigger').removeClass('clicked');
    jQuery('.header-menu-js > .menu-item-has-children > a').removeClass('clicked');
    jQuery('.sub-menu').removeClass('visible');
  } else {
    // upscroll code
    jQuery('#header').removeClass('hidden');
  }
  */
  if (st > 200) {
    jQuery('#header').addClass('scrolled');
  }
  else {
    jQuery('#header').removeClass('scrolled');
  }
  lastScrollTop = st;
}

/////////////////////////////////////////////
// hamburger
/////////////////////////////////////////////

function hamburgerMenu(e) {
  if (jQuery('.ham-activator-js').hasClass('open')) {
    jQuery('html, body').css({
      overflow: 'visible',
    });
    jQuery('.ham-activator-js').removeClass('open').attr('aria-expanded', false);
    jQuery('#head-overlay').addClass('hidden');
    scrollDirectionMenu();
  } else {
    jQuery('html, body').css({
      overflow: 'hidden',
    });
    jQuery('.ham-activator-js').addClass('open').attr('aria-expanded', true);
    jQuery('#head-overlay').removeClass('hidden');
    jQuery('.scroll-opportunity-overlay-js').scrollTop(0);
    jQuery('#header').addClass('scrolled');
  }
  close_sub_menus();
}

jQuery('#head-overlay a:last').on('keydown', function (event) {
  if (event.keyCode == 9) {
    close_sub_menus();
  }
});
jQuery(document).on('click', '.ham-activator-js:not(.initialized)', function (e) {
  hamburgerMenu();
});

jQuery('.overlay-navi-reset-js').on('focusin', function (e) {
  jQuery('.ham-activator-js').focus();
  e.preventDefault();
});

jQuery('#head-overlay').on('keydown', function (event) {
  if (event.keyCode == 27) {
    jQuery('.ham-activator-js').focus();
    closeHamburgerMenu();
  }
});

/////////////////////////////////////////////
// mega menu
/////////////////////////////////////////////

jQuery(document).on('click', '.mega-menu-js-trigger:not(.initialized)', function (e) {
  jQuery('.mega-menu-js-trigger').not(this).removeClass('clicked').attr('aria-expanded', false);
  jQuery('.mega-menu-js-trigger').not(this).parent().find('.mega-menu-js').addClass('hidden').attr('aria-hidden', true);
  data_megamenu_id = jQuery(this).data('megamenu-open-id');
  if (jQuery(this).hasClass('clicked')) {
    jQuery(this).removeClass('clicked').attr('aria-expanded', false);
    jQuery('.mega-menu-js-' + data_megamenu_id + '-target').addClass('hidden');
    jQuery('.submenu-close-js').removeClass('active');
    scrollDirectionMenu();
  }
  else {
    jQuery(this).addClass('clicked').attr('aria-expanded', true);
    jQuery('.mega-menu-js-' + data_megamenu_id + '-target').removeClass('hidden');
    jQuery('#header').addClass('scrolled');
    jQuery('.submenu-close-js').addClass('active');

  }
  closeHamburgerMenu();
});

/////////////////////////////////////////////
// sub menu desktop
/////////////////////////////////////////////

jQuery('.header-menu-js > .menu-item-has-children > .sub-menu-btn:not(.initialized)').click(function () {
  jQuery(this).toggleClass('clicked');
  if (jQuery(this).hasClass('clicked')) {
    jQuery(this).addClass('clicked').attr('aria-expanded', true);
    jQuery(this).parent().find('.sub-menu').addClass('visible');
    jQuery('.submenu-close-js').addClass('active');
    jQuery('#header').addClass('scrolled');
  }
  else {
    jQuery(this).removeClass('clicked').attr('aria-expanded', false);
    jQuery(this).parent().find('.sub-menu').removeClass('visible');
    jQuery('.submenu-close-js').removeClass('active');
    scrollDirectionMenu();
  }
  closeHamburgerMenu();
});


/////////////////////////////////////////////
// sub menu overlay
/////////////////////////////////////////////

jQuery('.overlay-menu-mobile-js > .menu-item-has-children').each(function (i, el) {
  if (jQuery(this).hasClass('mobile-open-default')) {
    jQuery(this).find('.sub-menu-btn').addClass('clicked');
  }
});

jQuery(document).on('click', '.overlay-menu-mobile-js > .menu-item-has-children > .sub-menu-btn:not(.initialized)', function (e) {
  if (jQuery(this).hasClass('clicked')) {
    jQuery(this).removeClass('clicked').attr('aria-expanded', false);
    jQuery(this).parent().find('.sub-menu').slideUp(animation_duration);
  } else {
    jQuery(this).addClass('clicked').attr('aria-expanded', true);
    jQuery(this).parent().find('.sub-menu').slideDown(animation_duration);
  }
});

/////////////////////////////////////////////
// close_sub menus
/////////////////////////////////////////////

function closeHamburgerMenu() {
  jQuery('html, body').css({
    overflow: 'visible',
  });
  jQuery('.ham-activator-js').removeClass('open').attr('aria-expanded', false);
  jQuery('#head-overlay').addClass('hidden');
}

function close_sub_menus() {
  jQuery('.mega-menu-js').addClass('hidden');
  jQuery('.mega-menu-js-trigger').removeClass('clicked');
  jQuery('.submenu-close-js').removeClass('active');
  jQuery('.header-menu-js > .menu-item-has-children > .sub-menu-btn').removeClass('clicked').attr('aria-expanded', false);
  jQuery('.sub-menu').removeClass('visible');
  jQuery('.submenu-close-js').removeClass('active');
}

jQuery('.header-menu .mega-menu-js-trigger, .header-menu .sub-menu-btn, .header-menu .simple-link').on('focusin', function () {
  close_sub_menus();
});

jQuery(document).on('click', '.submenu-close-js:not(.initialized)', function (e) {
  close_sub_menus();
});

jQuery('.mega-menu').each(function (i, el) {
  jQuery(this).on('keydown', function (event) {
    if (event.keyCode == 27) {
      close_sub_menus();
    }
  });
});

/////////////////////////////////////////////
// Modals
/////////////////////////////////////////////

jQuery(document).on('click', '.modal-open-js:not(.initialized)', function (e) {
  var modal_id = jQuery(this).data('modal-id');
  var modal_back_to = jQuery(this).data('modal-back-to');
  localStorage.setItem('modal_back_to', modal_back_to);
  jQuery('#paperplane-modal-js-' + modal_id).removeClass('hidden').attr('aria-hidden', false);
  var focusable = jQuery('#paperplane-modal-js-' + modal_id).find('button, a, input:not([type=hidden]), select, textarea, [tabindex]:not([tabindex="-1"])');
  if (typeof focusable[1] === 'undefined') {
    setTimeout(function () { jQuery(focusable[0]).focus() }, 50);
  }
  else {
    setTimeout(function () { jQuery(focusable[1]).focus() }, 50);
  }
  jQuery('html, body').css({
    overflow: 'hidden',
  });
  if (typeof gtag === 'function') {
    var modal_title = jQuery(this).data('modal-title');
    gtag('event', 'modal_open', {
      'modal_title': modal_title
    });
  }
  e.preventDefault();
});

jQuery(document).on('click', '.modal-close-js:not(.initialized)', function (e) {
  var modal_id = jQuery(this).data('modal-id');
  var modal_back_to = localStorage.getItem('modal_back_to');
  jQuery('#paperplane-modal-js-' + modal_id).addClass('hidden').attr('aria-hidden', true);
  jQuery('html, body').css({
    overflow: 'visible',
  });
  setTimeout(function () { jQuery('.' + modal_back_to).focus() }, 50);
  e.preventDefault();
});

jQuery('.paperplane-modal').each(function (i, el) {
  var modal_id = jQuery(this).data('modal-id');
  focusable = jQuery(this).find('button:not([hidden]), a, input:not([type=hidden]), select, textarea, [tabindex]:not([tabindex="-1"])');
  jQuery(this).on('keydown', function (event) {
    focusable = jQuery(this).find('button:not([hidden]), a, input:not([type=hidden]), select, textarea, [tabindex]:not([tabindex="-1"])');
    focusable_first = 1;
    if (event.keyCode == 27) {
      var modal_back_to = localStorage.getItem('modal_back_to');
      jQuery('#paperplane-modal-js-' + modal_id).addClass('hidden').attr('aria-hidden', true);
      jQuery('html, body').css({
        overflow: 'visible',
      });
      setTimeout(function () { jQuery('.' + modal_back_to).focus() }, 50);
    }
  });
  jQuery(focusable[0]).on('keydown', function (event) {
    if (event.shiftKey && (event.keyCode == 9)) {
      jQuery(focusable[focusable.length - 1]).focus();
      event.preventDefault();
    }
  });
  jQuery(focusable[focusable.length - 1]).on('keydown', function (event) {
    if (!event.shiftKey && (event.keyCode == 9)) {
      jQuery(focusable[0]).focus();
      event.preventDefault();
    }
  });
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
// Slick slideshow
/////////////////////////////////////////////

jQuery(window).on('load', function () {
  jQuery('.slider-single-js').on('init reInit', function (event, slick, currentSlide, nextSlide) {
    AOS.refresh();
  });
  /*
  Riferimenti per bottoni di navigazione separati rispetto a quelli nativi
    jQuery('.slider-single-js').on('init', function (event, slick) {
      jQuery('.slide-prev-slider-single-js').attr('disabled', 'disabled');
    });
    jQuery('.slider-single-js').on('afterChange', function (event, slick, currentSlide, nextSlide) {
      var total_slides = slick.slideCount;
      var current_slide = currentSlide + 1;
      if (total_slides == current_slide) {
        jQuery('.slide-next-slider-single-js').attr('disabled', 'disabled');
      }
      else {
        jQuery('.slide-next-slider-single-js').removeAttr('disabled');
      }
      if (current_slide == 1) {
        jQuery('.slide-prev-slider-single-js').attr('disabled', 'disabled');
      }
      else {
        jQuery('.slide-prev-slider-single-js').removeAttr('disabled');
      }
    });
    */

  jQuery('.slider-single-js').slick({
    focusOnSelect: false,
    draggable: true,
    infinite: false,
    accessibility: true,
    adaptiveHeight: false,
    slidesToShow: 1,
    slidesToScroll: 1,
    arrows: true,
    dots: true,
    nextArrow: '<button class="slick-next">→</button>',
    prevArrow: '<button class="slick-prev">←</button>',
    responsive: [{
      breakpoint: 1024,
      settings: {
        slidesToShow: 1,
        slidesToScroll: 1
      }
    }]
  });
  // non disabilitare dots - se non necessari aggiungere allo slider la classe hidden-dots
  /*
  Riferimenti per bottoni di navigazione separati rispetto a quelli nativi
  jQuery('.slide-next-slider-single-js').click(function (e) {
    //e.preventDefault(); 
    jQuery('.slider-single-js').slick('slickNext');
  });
  jQuery('.slide-prev-slider-single-js').click(function (e) {
    //e.preventDefault(); 
    jQuery('.slider-single-js').slick('slickPrev');
  });
  */
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
    jQuery('#expand-content-' + expand_id).slideUp(animation_duration).removeClass('visible');
    jQuery('#expand-close-button-' + expand_id).attr('aria-expanded', false);
  } else {
    jQuery('#expand-button-' + expand_id).addClass('exp-close').removeClass('exp-open').attr('aria-expanded', true);
    jQuery('#expand-content-' + expand_id).slideDown(animation_duration).addClass('visible');
    jQuery('#expand-close-button-' + expand_id).attr('aria-expanded', true);
  }
  e.preventDefault();
});

jQuery(document).on('click', '.expander-closer:not(.initialized)', function (e) {
  var expand_id = jQuery(this).data('expand-id');
  jQuery('#expand-button-' + expand_id).addClass('exp-open').removeClass('exp-close').attr('aria-expanded', false);
  jQuery('#expand-content-' + expand_id).slideUp(animation_duration).removeClass('visible');
  jQuery('#expand-close-button-' + expand_id).attr('aria-expanded', false);
  e.preventDefault();
});

/////////////////////////////////////////////
// Play video
/////////////////////////////////////////////

var firstScriptTag = document.getElementsByTagName('script')[0];
var load_youtube = false;
var load_vimeo = false;
jQuery('.play-video-js').each(function (i, el) {
  var video_source = jQuery(this).data('video-source');
  if (video_source == 'vimeo') {
    load_vimeo = true;
  }
  if (video_source == 'youtube') {
    load_youtube = true;
  }
});

function add_video_platforms_apis() {
  if (load_vimeo) {
    var tag = document.createElement('script');
    tag.src = "https://player.vimeo.com/api/player.js";
    tag.async = true;
    firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
  }
  if (load_youtube) {
    var tag = document.createElement('script');
    tag.src = "https://www.youtube.com/iframe_api";
    tag.async = true;
    firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
  }
}
add_video_platforms_apis();


jQuery(document).on('click', '.play-video-js:not(.initialized)', function (e) {
  var video_source = jQuery(this).data('video-source');
  var video_toplay = jQuery(this).data('video-toplay');
  jQuery(this).fadeOut(300);
  if (video_source == 'vimeo') {
    var iframe = document.getElementById(video_toplay);
    var src = jQuery('#' + video_toplay).attr("data-src");
    jQuery('#' + video_toplay).removeAttr("data-src").attr('src', src).attr('aria-hidden', false);
    var player = new Vimeo.Player(iframe);
    player.play();
    jQuery(document).on('click', '.modal-close-js:not(.initialized)', function (e) {
      player.pause();
    });
  }
  if (video_source == 'youtube') {
    var youtube_video_id = jQuery(this).data('youtube-video-id');
    var player;
    jQuery('#' + video_toplay).attr('aria-hidden', false);
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
    jQuery('#' + video_toplay).trigger('play').attr('aria-hidden', false);
    jQuery(document).on('click', '.modal-close-js:not(.initialized)', function (e) {
      jQuery('#' + video_toplay).trigger('pause');
    });
  }
  e.preventDefault();
});


/////////////////////////////////////////////
// Window scroll / resize events
/////////////////////////////////////////////
document.addEventListener('scroll', { passive: true });
document.addEventListener('scroll', (event) => {
  scrollDirectionMenu();
  numbers_counter();
  acessibility_panel_hide();
});

/////////////////////////////////////////////
// GA modal open event trigger
/////////////////////////////////////////////

jQuery(document).on('click', '.modal-open-js:not(.initialized)', function (e) {
  if (typeof gtag === 'function') {
    var ga_modal_event_name = jQuery(this).data('ga-modal-event-name');
    var ga_modal_event_cta_text = jQuery(this).data('ga-modal-event-cta-text');
    var ga_modal_event_modal_title = jQuery(this).data('ga-modal-title');
    gtag('event', ga_modal_event_name, {
      'page_title': ga_custom_event_cta_page_title,
      'modal_title': ga_modal_event_modal_title,
      'cta_text': ga_modal_event_cta_text
    });

  }
  else {
    console.log('Sorry, Google Analytics is not installed.');
  }
});


/////////////////////////////////////////////
// GA custom event trigger
/////////////////////////////////////////////

jQuery(document).on('click', '.ga-custom-event-trigger-js:not(.initialized)', function (e) {
  if (typeof gtag === 'function') {
    var ga_custom_event_name = jQuery(this).data('ga-custom-event-name');
    var ga_custom_event_cta_text = jQuery(this).data('ga-custom-event-cta-text');
    var ga_custom_event_cta_url = jQuery(this).data('ga-custom-event-cta-url');
    var ga_custom_event_cta_page_title = jQuery(this).data('ga-custom-event-cta-page-title');
    gtag('event', ga_custom_event_name, {
      'page_title': ga_custom_event_cta_page_title,
      'page_location': ga_custom_event_cta_url,
      'cta_text': ga_custom_event_cta_text
    });
  }
  else {
    console.log('Sorry, Google Analytics is not installed.');
  }
});

/////////////////////////////////////////////
// GA custom event trigger A/B test
/////////////////////////////////////////////

jQuery(document).on('click', '.ga-ab-event-trigger-js:not(.initialized)', function (e) {
  if (typeof gtag === 'function') {
    var ga_custom_event_name = jQuery(this).data('ga-ab-event-name');
    var ga_custom_event_cta_text = jQuery(this).data('ga-ab-cta-text');
    var ga_custom_event_cta_url = jQuery(this).data('ga-ab-cta-url');
    gtag('event', ga_custom_event_name, {
      'cta_text': ga_custom_event_cta_text,
      'cta_url': ga_custom_event_cta_url
    });
  }
  else {
    console.log('Sorry, Google Analytics is not installed.');
  }
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


window.addEventListener('DOMContentLoaded', () => {
  let displayMode = 'browser tab';
  if (window.matchMedia('(display-mode: standalone)').matches) {
    displayMode = 'standalone';
  }
  if (displayMode == 'standalone') {
    function UnLoadWindow() {
      jQuery('body').addClass('pwa-navigation');
    }
    window.onbeforeunload = UnLoadWindow;
  }
});

/*
// link esterno
var comp = new RegExp(location.host);
jQuery('a').each(function () {
  if (jQuery(this).indexOf("#") >= 0 || comp.test(jQuery(this).attr('href')) || typeof jQuery(this).attr('href') === 'undefined' || jQuery(this).attr('href') === null || jQuery(this).attr('href') === '') {
  }
  else {
    jQuery(this).attr('target', '_blank');
  }
});
*/