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
  //offset: 40
  //offset: 50
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

    jQuery('.grid-infinite').on('append.infiniteScroll', function(event, response, path, items) {
      paperPlaneLazyLoad.update();
      AOS.refresh();
    });
    window.setInterval(function() {
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
    jQuery('#header-overlay').focus();
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
}

/////////////////////////////////////////////
// menu scroll effect
/////////////////////////////////////////////

var lastScrollTop = 0;

function scrollDirectionMenu() {
  var st = jQuery(this).scrollTop();
  if ((st > lastScrollTop) && (st > 100)) {
    // downscroll code
    jQuery('#header').addClass('hidden');
    jQuery('.mega-menu-js').addClass('hidden');
    jQuery('.mega-menu-js-trigger').removeClass('current-mega-menu');
  } else {
    // upscroll code
    jQuery('#header').removeClass('hidden');
  }
  lastScrollTop = st;
}


jQuery(window).scroll(function(event) {
  scrollDirectionMenu();
});

/////////////////////////////////////////////
// mega menu
/////////////////////////////////////////////

jQuery('.mega-menu-js-trigger').click(function(e) {
  e.preventDefault();
});

/////////////////////////////////////////////
// slick slideshow
/////////////////////////////////////////////

jQuery('.slide-double-js, .slide-single-js').on('init reInit afterChange', function(event, slick, currentSlide, nextSlide) {
  AOS.refresh();
});

jQuery('.slide-double-js').slick({
  lazyLoad: 'progressive',
  dots: true,
  focusOnSelect: true,
  draggable: true,
  infinite: false,
  accessibility: true,
  adaptiveHeight: false,
  slidesToShow: 2,
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
jQuery(document).on('keydown', function(e) {
  if (e.keyCode == 37) {
    jQuery('.slide-single-js').slick('slickPrev');
  }
  if (e.keyCode == 39) {
    jQuery('.slide-single-js').slick('slickNext');
  }
});

jQuery('.slide-single-js').slick({
  lazyLoad: 'progressive',
  dots: true,
  focusOnSelect: true,
  draggable: true,
  infinite: false,
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

if (jQuery('.count')[0]) {}

function activateCounter() {
  jQuery('.count').each(function() {
    jQuery(this).prop('Counter', 0).animate({
      Counter: jQuery(this).attr('data-bar-number')

    }, {
      duration: 2000,
      step: function(now) {
        jQuery(this).text(Math.ceil(now));
        if (jQuery(this).hasClass('percent-justnumber')) {
          jQuery(this).text(jQuery(this).text().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
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
// expandables
/////////////////////////////////////////////

jQuery('.expander').click(function(e) {
  if (jQuery(this).hasClass('exp-close')) {
    jQuery(this).addClass('exp-open').removeClass('exp-close').attr('aria-expanded', false).focus();
    jQuery(this).find('span').addClass('exp-plus').removeClass('exp-minus');
    jQuery(this).parent().next('.expandable-content').slideUp(150);
  } else {
    jQuery(this).addClass('exp-close').removeClass('exp-open').attr('aria-expanded', true);
    jQuery(this).find('span').removeClass('exp-plus').addClass('exp-minus');
    jQuery(this).parent().next('.expandable-content').slideDown(150).focus();
  }
  e.preventDefault();
});

/////////////////////////////////////////////
// sub menu mobile
/////////////////////////////////////////////

jQuery('.overlay-menu-mobile-js > .menu-item-has-children').click(function(e) {
  jQuery(this).find('.sub-menu').slideToggle(150);
  e.preventDefault();
});

/////////////////////////////////////////////
// preload
/////////////////////////////////////////////

function hidePreload() {
  jQuery('.preload-container').addClass('hidden-preload');
}

//window.addEventListener('load', hidePreload);