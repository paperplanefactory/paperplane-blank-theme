/////////////////////////////////////////////
// lazy load
/////////////////////////////////////////////
var lazyLoadInstances = [];
var paperPlaneLazyLoad = new LazyLoad({
  elements_selector: ".lazy",
  class_loading: "lazy-loading",
  class_loaded: "lazy-loaded",
  callback_enter: function(el) {
    // console.log('entered');
    var oneLL = new LazyLoad({
      container: el
    });
    lazyLoadInstances.push(oneLL);
  },
  callback_reveal: (el) => {
    if (el.complete && el.naturalWidth !== 0) {
      el.classList.remove('lazy-loading');
      el.classList.add('lazy-loaded');
    }
  }
});

/////////////////////////////////////////////
// AOS
/////////////////////////////////////////////

AOS.init({
  duration: 900,
  once: false,
  mirror: true,
  offset: 40
  //offset: 50
});

/////////////////////////////////////////////
// Infinite scroll
/////////////////////////////////////////////

function initInfiniteScroll() {
  if ($('.grid-infinite')[0]) {
    $('.grid-infinite').infiniteScroll({
      path: '.nav-next a',
      append: '.grid-item-infinite',
      status: '#infscr-loading',
      prefill: true,
      history: 'push',
      historyTitle: true
    });

    $('.grid-infinite').on('append.infiniteScroll', function(event, response, path, items) {
      paperPlaneLazyLoad.update();
      AOS.refresh();
    });
    window.setInterval(function() {
      if ($('.infinite-scroll-last').is(":visible")) {
        $('#infscr-loading').fadeOut(300);
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
  $('.content-styled iframe').wrap('<div class="video_frame"></div>');
  // Controllo se l'immagine ha la didascalia e se manca la wrappo per allinearla
  if (!$('img.alignnone').closest('.wp-caption').length) {
    $('img.alignnone').wrap('<div class="wp-caption alignnone"></div>');
  }
  if (!$('img.aligncenter').closest('.wp-caption').length) {
    $('img.aligncenter').wrap('<div class="wp-caption aligncenter"></div>');
  }
  if ($('img.alignleft')) {
    $('img.alignleft').wrap('<div class="wp-caption alignleft"></div>');
  }
  if ($('img.alignright')) {
    $('img.alignright').wrap('<div class="wp-caption alignright"></div>');
  }
}
manipulateContent();

/////////////////////////////////////////////
// hamburger
/////////////////////////////////////////////

function hamburgerMenu(e) {
  $('.hambuger-element').toggleClass('open');
  if ($('.hambuger-element').hasClass('open')) {
    $('html').css('overflowY', 'hidden');
    $('html').addClass('occupy-scrollbar');
    $('#header-overlay').focus();
    $(this).attr('aria-expanded', true);
  } else {
    $('html').css('overflowY', 'scroll');
    $('html').removeClass('occupy-scrollbar');
    $('#header').focus();
    $(this).attr('aria-expanded', false);
    $('.scroll-opportunity').scrollTop(0);
  }
  $('#head-overlay').toggleClass('hidden');
  $('.mega-menu-js').addClass('hidden');
  $('.mega-menu-js-trigger').removeClass('current-mega-menu');
}

/////////////////////////////////////////////
// menu scroll effect
/////////////////////////////////////////////

var lastScrollTop = 0;

function scrollDirectionMenu() {
  var st = $(this).scrollTop();
  if ((st > lastScrollTop) && (st > 100)) {
    // downscroll code
    $('#header').addClass('hidden');
    $('.mega-menu-js').addClass('hidden');
    $('.mega-menu-js-trigger').removeClass('current-mega-menu');
  } else {
    // upscroll code
    $('#header').removeClass('hidden');
  }
  lastScrollTop = st;
}


$(window).scroll(function(event) {
  scrollDirectionMenu();
});

/////////////////////////////////////////////
// mega menu
/////////////////////////////////////////////

$('.mega-menu-js-trigger').click(function(e) {
  e.preventDefault();
});

/////////////////////////////////////////////
// go Below The Fold
/////////////////////////////////////////////

function goBelowTheFold() {
  $('html, body').animate({
    scrollTop: $('.below-the-fold').offset().top - 20
  }, 500)
}

// below the fold
$('#intro-scroll-js').click(function() {
  goBelowTheFold();
});

/////////////////////////////////////////////
// slick slideshow
/////////////////////////////////////////////

$('.single-item').on('init reInit afterChange', function(event, slick, currentSlide, nextSlide) {
  //currentSlide is undefined on init -- set it to 0 in this case (currentSlide is 0 based)
  var i = (currentSlide ? currentSlide : 0) + 1;
  $('.paging-info').text(i + '/' + slick.slideCount);
});

$('.single-item').slick({
  dots: true,
  focusOnSelect: true,
  draggable: true,
  infinite: true,
  accessibility: true,
  adaptiveHeight: true,
  nextArrow: '<div class="slick-next"><i class="fas fa-long-arrow-alt-right" aria-label="next"></i></div>',
  prevArrow: '<div class="slick-prev"><i class="fas fa-long-arrow-alt-left" aria-label="previous"></i></div>'
});
$(document).on('keydown', function(e) {
  if (e.keyCode == 37) {
    $('.single-item').slick('slickPrev');
  }
  if (e.keyCode == 39) {
    $('.single-item').slick('slickNext');
  }
});

$('.slider-for').slick({
  slidesToShow: 1,
  slidesToScroll: 1,
  infinite: true,
  arrows: false,
  fade: true,
  asNavFor: '.slider-nav',
  lazyLoad: 'ondemand',
});
$('.slider-nav').slick({
  slidesToShow: 3,
  slidesToScroll: 1,
  infinite: true,
  asNavFor: '.slider-for',
  dots: true,
  centerMode: true,
  arrows: true,
  focusOnSelect: true,
  lazyLoad: 'ondemand',
  nextArrow: '<div class="slick-next"><i class="fas fa-long-arrow-alt-right" aria-label="next"></i></div>',
  prevArrow: '<div class="slick-prev"><i class="fas fa-long-arrow-alt-left" aria-label="previous"></i></div>'
});



$('.slide-double').on('init reInit afterChange', function(event, slick, currentSlide, nextSlide) {
  AOS.refresh();
});

$('.slide-double').slick({
  lazyLoad: 'ondemand',
  dots: false,
  focusOnSelect: true,
  draggable: true,
  infinite: true,
  accessibility: true,
  adaptiveHeight: false,
  slidesToShow: 2,
  slidesToScroll: 1,
  nextArrow: '<div class="slick-next"><div class="slide-button-shaper"><i class="fas fa-arrow-right" aria-label="next"></i></div></div>',
  prevArrow: '<div class="slick-prev"><div class="slide-button-shaper"><i class="fas fa-arrow-left" aria-label="previous"></i></div></div>',
  responsive: [{
    breakpoint: 1024,
    settings: {
      slidesToShow: 1,
      slidesToScroll: 1
    }
  }]
});
$(document).on('keydown', function(e) {
  if (e.keyCode == 37) {
    $('.single-item').slick('slickPrev');
  }
  if (e.keyCode == 39) {
    $('.single-item').slick('slickNext');
  }
});

/////////////////////////////////////////////
// Numbers counter
/////////////////////////////////////////////

if ($('.count')[0]) {}

function activateCounter() {
  $('.count').each(function() {
    $(this).prop('Counter', 0).animate({
      Counter: $(this).attr('data-bar-number')

    }, {
      duration: 2000,
      step: function(now) {
        $(this).text(Math.ceil(now));
        if ($(this).hasClass('percent-justnumber')) {
          $(this).text($(this).text().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
        }

      }
    });
  });
}



if (!!window.IntersectionObserver) {
  let observer = new IntersectionObserver((entries, observer) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        console.log(entry);
        entry.target.src = entry.target.dataset.src;
        activateCounter();
        observer.unobserve(entry.target);
      }
    });
  }, {
    rootMargin: "0px 0px -200px 0px"
  });
  document.querySelectorAll('.count').forEach(count => {
    observer.observe(count)
  });
} else document.querySelector('#warning').style.display = 'block';

/////////////////////////////////////////////
// click hamburger
/////////////////////////////////////////////

$('.ham-activator').click(function(e) {
  hamburgerMenu();
});

/////////////////////////////////////////////
// expandables
/////////////////////////////////////////////

$('.expander').click(function(e) {
  if ($(this).hasClass('exp-close')) {
    $(this).addClass('exp-open').removeClass('exp-close').attr('aria-expanded', false).focus();
    $(this).find('span').addClass('exp-plus').removeClass('exp-minus');
    $(this).parent().next('.expandable-content').slideUp(150);
  } else {
    $(this).addClass('exp-close').removeClass('exp-open').attr('aria-expanded', true);
    $(this).find('span').removeClass('exp-plus').addClass('exp-minus');
    $(this).parent().next('.expandable-content').slideDown(150).focus();
  }
  e.preventDefault();
});

/////////////////////////////////////////////
// sub menu mobile
/////////////////////////////////////////////

$('.overlay-menu-mobile-js > .menu-item-has-children').click(function(e) {
  $(this).find('.sub-menu').slideToggle(150);
  e.preventDefault();
});

/////////////////////////////////////////////
// preload
/////////////////////////////////////////////

function hidePreload() {
  $('.preload-container').addClass('hidden-preload');
  //alert('dfg');
}

//window.addEventListener('load', hidePreload);