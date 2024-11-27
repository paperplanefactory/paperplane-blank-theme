/////////////////////////////////////////////
// accessibility default
/////////////////////////////////////////////
const isReduced = window.matchMedia('(prefers-reduced-motion: reduce)') === true || window.matchMedia('(prefers-reduced-motion: reduce)').matches === true;

if (isReduced) {
  // Per gli elementi con classe 'stoppable-js'
  document.querySelectorAll('.stoppable-js').forEach(el => {
    el.pause(); // Assumendo che siano elementi video/audio
  });

  // Per gli elementi con classe 'animation-play-pause-js'
  document.querySelectorAll('.animation-play-pause-js').forEach(el => {
    el.classList.remove('pause');
    el.classList.add('play');
    el.setAttribute('aria-pressed', 'false');
  });

  var animation_duration = 0;
  var animation_duration_counter = 0;

  // Nascondi il pulsante reduce-motion
  document.querySelectorAll('.reduce-motion-button-js').forEach(el => {
    el.classList.add('hidden');
  });
} else {
  var animation_duration, animation_duration_counter;
}

/////////////////////////////////////////////
// accessibility user
/////////////////////////////////////////////

const themeVersion = document.querySelector('meta[name=theme-version]').getAttribute('data-theme-version');

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

if (localStorage.getItem('paperplane_user_preferences_' + themeVersion) != null) {
  const now = new Date();
  const paperplane_user_preferences_array = JSON.parse(
    localStorage.getItem('paperplane_user_preferences_' + themeVersion),
  );
  Object.keys(paperplane_user_preferences_array).forEach(function (key) {
    if (key == 'expiry' && now.getTime() > paperplane_user_preferences_array[key]) {
      localStorage.removeItem('paperplane_user_preferences_' + themeVersion);
    }
  });
}

if (localStorage.getItem('paperplane_user_preferences_' + themeVersion) === null) {
  const expry_date = addHours(new Date(), (1 * 24) * 365);
  //const expry_date = addHours(new Date(), 1 / 60);
  const initial_a11y_values = { expiry: expry_date.getTime(), reduced_motion: 1, reduced_transparency: 0, dark_mode: 0 };
  saveArrayToLocalStorage('paperplane_user_preferences_' + themeVersion, initial_a11y_values);
}

document.addEventListener('click', function (e) {
  // Verifica se l'elemento cliccato o uno dei suoi genitori ha la classe specificata
  const target = e.target.closest('.paperplane-reduce-motion-js');
  if (target) {
    const paperplane_user_preferences_array = JSON.parse(
      localStorage.getItem('paperplane_user_preferences_' + themeVersion)
    );

    Object.keys(paperplane_user_preferences_array).forEach(function (key) {
      if (key == 'reduced_motion') {
        // Inverti il valore tra 0 e 1
        paperplane_user_preferences_array[key] = paperplane_user_preferences_array[key] === 0 ? 1 : 0;
      }
    });

    saveArrayToLocalStorage('paperplane_user_preferences_' + themeVersion, paperplane_user_preferences_array);
    userSetAccessibility();
    e.preventDefault();
  }
});

document.addEventListener('click', function (e) {
  // Verifica se l'elemento cliccato o uno dei suoi genitori ha la classe specificata
  const target = e.target.closest('.paperplane-reduce-transparency-js');
  if (target) {
    const paperplane_user_preferences_array = JSON.parse(
      localStorage.getItem('paperplane_user_preferences_' + themeVersion)
    );

    Object.keys(paperplane_user_preferences_array).forEach(function (key) {
      if (key == 'reduced_transparency') {
        // Inverti il valore tra 1 e 0
        paperplane_user_preferences_array[key] = paperplane_user_preferences_array[key] === 1 ? 0 : 1;
      }
    });

    saveArrayToLocalStorage('paperplane_user_preferences_' + themeVersion, paperplane_user_preferences_array);
    userSetAccessibility();
    e.preventDefault();
  }
});

document.addEventListener('click', function (e) {
  const target = e.target.closest('.paperplane-darkmode-js');
  if (target) {
    const expry_date_cookie = addHours(new Date(), (1 * 24) * 365);
    const paperplane_user_preferences_array = JSON.parse(
      localStorage.getItem('paperplane_user_preferences_' + themeVersion)
    );

    Object.keys(paperplane_user_preferences_array).forEach(function (key) {
      if (key == 'dark_mode') {
        if (paperplane_user_preferences_array[key] == 1) {
          // Passa alla modalità chiara
          paperplane_user_preferences_array[key] = 0;
          document.cookie = "dark_mode=0; SameSite=None; Secure; expires=" + expry_date_cookie + "";
          document.body.setAttribute('data-theme-color', '');
        } else if (paperplane_user_preferences_array[key] == 0) {
          // Passa alla modalità scura
          paperplane_user_preferences_array[key] = 1;
          document.cookie = "dark_mode=1; SameSite=None; Secure; expires=" + expry_date_cookie + "";
          document.body.setAttribute('data-theme-color', 'dark');
        }
      }
    });

    saveArrayToLocalStorage('paperplane_user_preferences_' + themeVersion, paperplane_user_preferences_array);
    userSetAccessibility();
    e.preventDefault();
  }
});

function userSetAccessibility() {
  const paperplane_user_preferences_options_array = JSON.parse(
    localStorage.getItem('paperplane_user_preferences_' + themeVersion)
  );

  Object.keys(paperplane_user_preferences_options_array).forEach(function (key) {
    // Gestione reduced motion
    if ((key == 'reduced_motion' && paperplane_user_preferences_options_array[key] == 0) || isReduced) {
      document.body.classList.add('body-reduced-motion');

      // Gestione elementi stoppable
      document.querySelectorAll('.stoppable-js').forEach(el => {
        // Assumendo che siano elementi video/audio
        if (el.pause) el.pause();
      });

      // Gestione pulsanti play/pause
      document.querySelectorAll('.animation-play-pause-js').forEach(el => {
        el.classList.remove('pause');
        el.classList.add('play');
        el.setAttribute('aria-pressed', 'false');
      });

      document.querySelectorAll('.paperplane-reduce-motion-js').forEach(el => {
        el.setAttribute('aria-checked', 'false');
      });

      animation_duration = 0;
      animation_duration_counter = 0;
    }
    else if (key == 'reduced_motion' && paperplane_user_preferences_options_array[key] == 1) {
      document.body.classList.remove('body-reduced-motion');

      document.querySelectorAll('.stoppable-js').forEach(el => {
        // Assumendo che siano elementi video/audio
        if (el.play) el.play();
      });

      document.querySelectorAll('.animation-play-pause-js').forEach(el => {
        el.classList.add('pause');
        el.classList.remove('play');
        el.setAttribute('aria-pressed', 'true');
      });

      document.querySelectorAll('.paperplane-reduce-motion-js').forEach(el => {
        el.setAttribute('aria-checked', 'true');
      });

      animation_duration = 500;
      animation_duration_counter = 1500;
    }

    // Gestione reduced transparency
    if (key == 'reduced_transparency' && paperplane_user_preferences_options_array[key] == 1) {
      document.body.classList.add('body-reduced-transparency');
      document.querySelectorAll('.paperplane-reduce-transparency-js').forEach(el => {
        el.setAttribute('aria-checked', 'true');
      });
    }
    else if (key == 'reduced_transparency' && paperplane_user_preferences_options_array[key] == 0) {
      document.body.classList.remove('body-reduced-transparency');
      document.querySelectorAll('.paperplane-reduce-transparency-js').forEach(el => {
        el.setAttribute('aria-checked', 'false');
      });
    }

    // Gestione dark mode
    if (key == 'dark_mode' && paperplane_user_preferences_options_array[key] == 1) {
      // document.documentElement.setAttribute('data-theme-color', 'dark');
      document.querySelectorAll('.paperplane-darkmode-js').forEach(el => {
        el.setAttribute('aria-checked', 'true');
      });
    }
    else if (key == 'dark_mode' && paperplane_user_preferences_options_array[key] == 0) {
      // document.documentElement.setAttribute('data-theme-color', '');
      document.querySelectorAll('.paperplane-darkmode-js').forEach(el => {
        el.setAttribute('aria-checked', 'false');
      });
    }
  });
}

userSetAccessibility();

function acessibilityPanelHide() {
  const scroll = window.scrollY || window.pageYOffset;
  const elements = document.querySelectorAll('.reduce-motion-overlay-js');

  if (scroll > 200) {
    elements.forEach(el => el.classList.add('hidden'));
  } else {
    elements.forEach(el => el.classList.remove('hidden'));
  }
}

/////////////////////////////////////////////
// Video bg play/pause
/////////////////////////////////////////////

document.addEventListener('click', function (e) {
  // Verifica se il target dell'evento è un elemento con la classe richiesta e non è ancora inizializzato
  const target = e.target.closest('.animation-play-pause-js');

  if (target) {
    const videoStop = target.getAttribute('data-video-stop');
    const video = document.getElementById(videoStop);

    if (video) {
      if (video.paused) {
        video.play();
        target.classList.add('pause');
        target.classList.remove('play');
        target.setAttribute('aria-pressed', 'true');
      } else {
        video.pause();
        target.classList.remove('pause');
        target.classList.add('play');
        target.setAttribute('aria-pressed', 'false');
      }
    }

    e.preventDefault();
  }
});

/////////////////////////////////////////////
// Animation play/pause
/////////////////////////////////////////////

document.addEventListener('click', function (e) {
  // Verifica se il target dell'evento è un elemento con la classe richiesta e non è ancora inizializzato
  const target = e.target.closest('.animation-stop-js:not(.initialized)');

  if (target) {
    const videoStop = target.getAttribute('data-video-stop');
    const videoElement = document.getElementById(videoStop);

    if (videoElement) {
      if (target.classList.contains('pause')) {
        videoElement.classList.remove('animate');
        target.classList.add('play');
        target.classList.remove('pause');
        target.setAttribute('aria-pressed', 'true');
      } else {
        videoElement.classList.add('animate');
        target.classList.remove('play');
        target.classList.add('pause');
        target.setAttribute('aria-pressed', 'false');
      }
    }

    e.preventDefault();
  }
});

/////////////////////////////////////////////
// Stop videos in autoplay to enable screensaver
/////////////////////////////////////////////

setTimeout(function () {
  // Pausa per tutti gli elementi con la classe 'stoppable-js'
  document.querySelectorAll('.stoppable-js').forEach(function (element) {
    element.pause();
  });

  // Aggiorna tutti gli elementi con la classe 'animation-play-pause-js'
  document.querySelectorAll('.animation-play-pause-js').forEach(function (element) {
    element.classList.remove('pause');
    element.classList.add('play');
    element.setAttribute('aria-pressed', 'false');
  });
}, 120000);


/////////////////////////////////////////////
// z-index for focused links
/////////////////////////////////////////////

document.body.addEventListener('keydown', function (event) {
  if (event.keyCode === 9) { // Tab key
    document.querySelectorAll('a').forEach(function (anchor) {
      anchor.addEventListener('focusin', function () {
        document.querySelectorAll('.aos-animate').forEach(function (element) {
          element.classList.remove('aos-animate');
          element.classList.add('unset-aos-animate');
        });
      });

      anchor.addEventListener('focusout', function () {
        document.querySelectorAll('.unset-aos-animate').forEach(function (element) {
          element.classList.remove('unset-aos-animate');
          element.classList.add('aos-animate');
        });
      });
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
  // Controlla se esiste un link 'nav-next a'
  if (document.querySelector(".nav-next a")) {

    // Inizializza Infinite Scroll
    const infScroll = new InfiniteScroll('.grid-infinite', {
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

    // Listener per l'evento di aggiunta di nuovi elementi
    infScroll.on('append', function (event, response, path, items) {
      AOS.refreshHard(); // Chiama AOS per aggiornare le animazioni
    });

    // Controlla periodicamente la visibilità dell'ultimo elemento
    window.setInterval(function () {
      const lastItem = document.querySelector('.infinite-scroll-last');
      const loadingStatus = document.querySelector('#infscr-loading');

      if (lastItem && lastItem.offsetParent !== null && loadingStatus) {
        loadingStatus.style.display = 'none';
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
  document.querySelectorAll('.content-styled iframe').forEach(function (iframe) {
    var wrapper = document.createElement('div');
    wrapper.className = 'video-frame';
    iframe.parentNode.insertBefore(wrapper, iframe);
    wrapper.appendChild(iframe);
  });

  // Wrappo immagini senza didascalia in modo appropriato
  document.querySelectorAll('img.alignnone').forEach(function (img) {
    if (!img.closest('.wp-caption')) {
      var wrapper = document.createElement('div');
      wrapper.className = 'wp-caption alignnone';
      img.parentNode.insertBefore(wrapper, img);
      wrapper.appendChild(img);
    }
  });

  document.querySelectorAll('img.aligncenter').forEach(function (img) {
    if (!img.closest('.wp-caption')) {
      var wrapper = document.createElement('div');
      wrapper.className = 'wp-caption aligncenter';
      img.parentNode.insertBefore(wrapper, img);
      wrapper.appendChild(img);
    }
  });

  document.querySelectorAll('img.alignleft').forEach(function (img) {
    var wrapper = document.createElement('div');
    wrapper.className = 'wp-caption alignleft';
    img.parentNode.insertBefore(wrapper, img);
    wrapper.appendChild(img);
  });

  document.querySelectorAll('img.alignright').forEach(function (img) {
    var wrapper = document.createElement('div');
    wrapper.className = 'wp-caption alignright';
    img.parentNode.insertBefore(wrapper, img);
    wrapper.appendChild(img);
  });
}

manipulateContent();

/////////////////////////////////////////////
// menu scroll effect
/////////////////////////////////////////////

var lastScrollTop = 0;

function scrollDirectionMenu() {
  var st = window.scrollY;
  /*
  if ((st > lastScrollTop) && (st > 100) && !document.querySelector('.hambuger-element').classList.contains('open')) {
    // downscroll code
    document.getElementById('header').classList.add('hidden');
    document.querySelectorAll('.mega-menu-js').forEach(function(menu) {
      menu.classList.add('hidden');
    });
    document.querySelectorAll('.mega-menu-js-trigger').forEach(function(trigger) {
      trigger.classList.remove('clicked');
    });
    document.querySelectorAll('.header-menu-js > .menu-item-has-children > a').forEach(function(link) {
      link.classList.remove('clicked');
    });
    document.querySelectorAll('.sub-menu').forEach(function(subMenu) {
      subMenu.classList.remove('visible');
    });
  } else {
    // upscroll code
    document.getElementById('header').classList.remove('hidden');
  }
  */

  if (st > 200) {
    document.getElementById('header').classList.add('scrolled');
  } else {
    document.getElementById('header').classList.remove('scrolled');
  }

  lastScrollTop = st;
}


/////////////////////////////////////////////
// hamburger
/////////////////////////////////////////////

function hamburgerMenu(e) {
  // Seleziona gli elementi principali
  const hamActivator = document.querySelector('#hamburger-button');
  const headOverlay = document.getElementById('head-overlay');
  const scrollOpportunityOverlay = document.querySelector('.scroll-opportunity-overlay-js');
  const header = document.getElementById('header'); // Seleziona l'header

  // Controlla se il menu è aperto
  const isOpen = hamActivator.classList.contains('open');

  // Imposta lo stile di overflow per impedire o consentire lo scroll della pagina
  document.documentElement.style.overflow = document.body.style.overflow = isOpen ? 'visible' : 'hidden';

  // Aggiunge o rimuove la classe 'open' per mostrare/nascondere il menu
  hamActivator.classList.toggle('open', !isOpen);

  // Aggiorna l'attributo ARIA per migliorare l'accessibilità
  hamActivator.setAttribute('aria-expanded', !isOpen);

  // Mostra o nasconde l'overlay
  headOverlay.classList.toggle('hidden', isOpen);

  // Gestisce la classe scrolled sull'header in base alla visibilità dell'overlay
  if (!headOverlay.classList.contains('hidden')) {
    header.classList.add('scrolled');
  } else {
    header.classList.remove('scrolled');
  }

  // Se il menu viene aperto, reimposta la posizione di scorrimento dell'overlay
  if (!isOpen && scrollOpportunityOverlay) {
    scrollOpportunityOverlay.scrollTop = 0;
  }

  // Chiude eventuali sottomenu aperti
  closeSubMenus();
}

// Funzione per chiudere il menu hamburger
function closeHamburgerMenu() {
  // Ripristina lo scroll
  document.documentElement.style.overflow = 'visible';
  document.body.style.overflow = 'visible';

  // Rimuovi classe open e aggiorna aria-expanded
  const hamburger = document.querySelector('.ham-activator-js');
  const header = document.getElementById('header'); // Seleziona l'header
  hamburger.classList.remove('open');
  hamburger.setAttribute('aria-expanded', 'false');
  header.classList.remove('scrolled');
  // Nascondi overlay
  document.getElementById('head-overlay').classList.add('hidden');
}

document.querySelector('#head-overlay a:last-of-type').addEventListener('keydown', function (event) {
  if (event.key === 'Tab') {
    closeSubMenus();
  }
});

document.getElementById('hamburger-button').addEventListener('click', hamburgerMenu);

document.querySelector('.overlay-navi-reset-js').addEventListener('focusin', function (e) {
  document.querySelector('#hamburger-button').focus();
  e.preventDefault();
});

let isPKeyPressed = false;
let isEscKeyPressed = false;

document.querySelector('#head-overlay').addEventListener('keydown', function (event) {
  if (event.key === 'p') {
    isPKeyPressed = true;
  }
  if (event.key === 'Escape') {
    isEscKeyPressed = true;
  }

  // Controlla se entrambi i tasti sono premuti contemporaneamente
  if (isPKeyPressed && isEscKeyPressed) {
    document.querySelector('.ham-activator-js').focus();
    closeHamburgerMenu();
  }
});

document.querySelector('#head-overlay').addEventListener('keyup', function (event) {
  // Resetta lo stato dei tasti quando vengono rilasciati
  if (event.key === 'p') {
    isPKeyPressed = false;
  }
  if (event.key === 'Escape') {
    isEscKeyPressed = false;
  }
});

/////////////////////////////////////////////
// mega menu
/////////////////////////////////////////////

// Ascolta click su elementi del documento
document.addEventListener('click', function (e) {
  // Verifica se l'elemento cliccato è un trigger del mega menu
  if (!e.target.matches('.mega-menu-js-trigger')) return;

  // Seleziona tutti gli altri trigger del mega menu
  const otherTriggers = document.querySelectorAll('.mega-menu-js-trigger:not(.clicked)');

  // Reset stato degli altri menu
  otherTriggers.forEach(trigger => {
    trigger.classList.remove('clicked');
    trigger.setAttribute('aria-expanded', 'false');
    const megaMenu = trigger.closest('.mega-menu-js');
    if (megaMenu) {
      megaMenu.classList.add('hidden');
      megaMenu.setAttribute('aria-hidden', 'true');
    }
  });

  // Ottiene ID del mega menu da gestire
  const megamenuId = e.target.dataset.megamenuOpenId;

  // Se il menu è già aperto, lo chiude
  if (e.target.classList.contains('clicked')) {
    e.target.classList.remove('clicked');
    e.target.setAttribute('aria-expanded', 'false');
    document.querySelector(`.mega-menu-js-${megamenuId}-target`).classList.add('hidden');
    document.querySelector('.submenu-close-js').classList.remove('active');
  }
  // Altrimenti apre il menu
  else {
    e.target.classList.add('clicked');
    e.target.setAttribute('aria-expanded', 'true');
    document.querySelector(`.mega-menu-js-${megamenuId}-target`).classList.remove('hidden');
    document.querySelector('.submenu-close-js').classList.add('active');
  }

  // Chiude menu hamburger
  closeHamburgerMenu();
});

/////////////////////////////////////////////
// sub menu desktop
/////////////////////////////////////////////

// Seleziona tutti i pulsanti dei sottomenu
document.querySelectorAll('.header-menu-js > .menu-item-has-children > .sub-menu-btn').forEach(function (btn) {
  btn.addEventListener('click', function () {
    // Alterna la classe 'clicked'
    btn.classList.toggle('clicked');

    if (btn.classList.contains('clicked')) {
      // Se cliccato, aggiungi la classe 'clicked' e imposta aria-expanded su true
      btn.setAttribute('aria-expanded', 'true');
      btn.parentElement.querySelector('.sub-menu').classList.add('visible');
      document.querySelectorAll('.submenu-close-js').forEach(function (closeBtn) {
        closeBtn.classList.add('active');
      });
    } else {
      // Se non cliccato, rimuovi la classe 'clicked' e imposta aria-expanded su false
      btn.setAttribute('aria-expanded', 'false');
      btn.parentElement.querySelector('.sub-menu').classList.remove('visible');
      document.querySelectorAll('.submenu-close-js').forEach(function (closeBtn) {
        closeBtn.classList.remove('active');
      });
    }

    // Chiama la funzione closeHamburgerMenu, se definita
    if (typeof closeHamburgerMenu === 'function') {
      closeHamburgerMenu();
    }
  });
});



/////////////////////////////////////////////
// sub menu overlay
/////////////////////////////////////////////

document.querySelectorAll('.overlay-menu-mobile-js > .menu-item-has-children').forEach(function (el) {
  if (el.classList.contains('mobile-open-default')) {
    const subMenuBtn = el.querySelector('.sub-menu-btn');
    if (subMenuBtn) {
      subMenuBtn.classList.add('clicked');
      const subMenu = subMenuBtn.nextElementSibling;
      if (subMenu && subMenu.classList.contains('sub-menu')) {
        subMenu.classList.add('visible');
      }
    }
  }
});


document.addEventListener('click', e => {
  const button = e.target.closest('.overlay-menu-mobile-js > .menu-item-has-children > .sub-menu-btn');
  if (!button) return;

  const subMenu = button.parentElement.querySelector('.sub-menu');
  const isOpen = button.classList.contains('clicked');

  button.classList.toggle('clicked');
  button.setAttribute('aria-expanded', !isOpen);
  subMenu.classList.toggle('visible');
});

/////////////////////////////////////////////
// close_sub menus
/////////////////////////////////////////////


function closeSubMenus() {
  // Nascondi tutti i mega menu
  document.querySelectorAll('.mega-menu-js').forEach(menu => menu.classList.add('hidden'));

  // Rimuovi classe 'clicked' dai trigger dei mega menu
  document.querySelectorAll('.mega-menu-js-trigger').forEach(trigger => trigger.classList.remove('clicked'));

  // Reset pulsanti submenu nell'header
  document.querySelectorAll('.header-menu-js > .menu-item-has-children > .sub-menu-btn').forEach(btn => {
    btn.classList.remove('clicked');
    btn.setAttribute('aria-expanded', 'false');
  });

  // Nascondi tutti i submenu
  document.querySelectorAll('.header-menu-js > .menu-item-has-children > .sub-menu').forEach(menu => menu.classList.remove('visible'));

  // Disattiva pulsanti di chiusura
  document.querySelectorAll('.submenu-close-js').forEach(close => close.classList.remove('active'));
}

document.querySelectorAll('.header-menu .mega-menu-js-trigger, .header-menu .sub-menu-btn, .header-menu .simple-link').forEach(element => {
  element.addEventListener('focusin', closeSubMenus);
});

// Gestisci click sul pulsante di chiusura submenu
document.addEventListener('click', e => {
  if (e.target.matches('.submenu-close-js')) {
    closeSubMenus();
  }
});

// Aggiungi listener keydown per il tasto ESC su tutti i mega menu
document.querySelectorAll('.mega-menu').forEach(menu => {
  menu.addEventListener('keydown', e => {
    if (e.key === 'Escape') {
      closeSubMenus();
    }
  });
});

/////////////////////////////////////////////
// Modals
/////////////////////////////////////////////

document.addEventListener('click', function (e) {
  const target = e.target.closest('.modal-open-js');
  if (target) {
    const modal_id = target.dataset.modalId;
    const modal_back_to = target.dataset.modalBackTo;
    localStorage.setItem('modal_back_to', modal_back_to);

    const modal = document.getElementById(`paperplane-modal-js-${modal_id}`);
    modal.classList.remove('hidden');
    modal.setAttribute('aria-hidden', 'false');

    const focusable = modal.querySelectorAll('button, a, input:not([type=hidden]), select, textarea, [tabindex]:not([tabindex="-1"])');
    if (focusable.length > 0) {
      setTimeout(function () {
        focusable[1] ? focusable[1].focus() : focusable[0].focus();
      }, 50);
    }

    document.documentElement.style.overflow = 'hidden';

    if (typeof gtag === 'function') {
      const modal_title = target.dataset.modalTitle;
      gtag('event', 'modal_open', {
        'modal_title': modal_title
      });
    }
    closeHamburgerMenu();
    e.preventDefault();
  }
});

document.addEventListener('click', function (e) {
  const target = e.target.closest('.modal-close-js');
  if (target) {
    const modal_id = target.dataset.modalId;
    const modal_back_to = localStorage.getItem('modal_back_to');

    const modal = document.getElementById(`paperplane-modal-js-${modal_id}`);
    modal.classList.add('hidden');
    modal.setAttribute('aria-hidden', 'true');

    document.documentElement.style.overflow = 'visible';

    setTimeout(function () {
      document.querySelector(`.${modal_back_to}`).focus();
    }, 50);

    e.preventDefault();
  }
});

document.querySelectorAll('.paperplane-modal').forEach(function (modal) {
  // Ottieni l'ID del modal dal data-modal-id
  const idModal = modal.dataset.modalId;

  // Ottieni tutti gli elementi focusabili all'interno del modal
  const elementiMarcabili = modal.querySelectorAll('button:not([hidden]), a, input:not([type=hidden]), select, textarea, [tabindex]:not([tabindex="-1"])');

  // Aggiungi un event listener per i tasti premuti sul modal
  modal.addEventListener('keydown', gestisciTastiModal);

  // Se ci sono elementi focusabili, aggiungi gli event listener sul primo e sull'ultimo
  if (elementiMarcabili.length > 0) {
    elementiMarcabili[0].addEventListener('keydown', gestisciPrimoElementoMarcabile);
    elementiMarcabili[elementiMarcabili.length - 1].addEventListener('keydown', gestisciUltimoElementoMarcabile);
  }

  // Gestisci gli eventi tastiera sul modal
  function gestisciTastiModal(event) {
    // Se il tasto premuto è Escape
    if (event.key === 'Escape') {
      // Ottieni l'elemento a cui tornare dopo aver chiuso il modal
      const elementoDaFocussare = localStorage.getItem('modal_back_to');
      // Seleziona il modal usando l'ID
      const elementoModal = document.getElementById(`paperplane-modal-js-${idModal}`);

      // Aggiungi la classe 'hidden' e imposta aria-hidden a true per nascondere il modal
      elementoModal.classList.add('hidden');
      elementoModal.setAttribute('aria-hidden', 'true');

      // Rimuovi lo stile overflow:hidden dall'HTML
      document.documentElement.style.overflow = 'visible';

      // Dopo 50ms, sposta il focus sull'elemento con la classe 'modal_back_to'
      setTimeout(() => {
        document.querySelector(`.${elementoDaFocussare}`).focus();
      }, 50);
    }
  }

  // Gestisci gli eventi tastiera sul primo elemento focusabile del modal
  function gestisciPrimoElementoMarcabile(event) {
    // Se viene premuto Shift+Tab, sposta il focus sull'ultimo elemento marcabile
    if (event.shiftKey && event.key === 'Tab') {
      elementiMarcabili[elementiMarcabili.length - 1].focus();
      event.preventDefault();
    }
  }

  // Gestisci gli eventi tastiera sull'ultimo elemento focusabile del modal
  function gestisciUltimoElementoMarcabile(event) {
    // Se viene premuto Tab (senza Shift), sposta il focus sul primo elemento marcabile
    if (!event.shiftKey && event.key === 'Tab') {
      elementiMarcabili[0].focus();
      event.preventDefault();
    }
  }
});


// Controlla se esiste un hash nell'URL corrente
if (window.location.hash) {
  // Memorizza il valore dell'hash
  var hash = window.location.hash;
  // Definisce il pattern da cercare nell'hash
  var pattern = /modal-focus-/;
  // Verifica se il pattern esiste nell'hash
  var exists = pattern.test(hash);

  if (exists) {
    // Estrae l'ID del modal rimuovendo i primi 13 caratteri ("modal-focus-")
    var modal_open_id = hash.substring(13, hash.length);

    // Trova l'elemento modal e rimuove la classe 'hidden'
    document.querySelector('.paperplane-modal-js-' + modal_open_id).classList.remove('hidden');

    // Imposta il focus sull'elemento modal dopo 50ms
    setTimeout(function () {
      document.querySelector('.modal-focus-' + modal_open_id).focus();
    }, 50);

    // Disabilita lo scroll sulla pagina
    document.documentElement.style.overflow = 'hidden'; // Blocca scroll su <html>
    document.body.style.overflow = 'hidden';           // Blocca scroll su <body>
  }
}


/////////////////////////////////////////////
// Slick slideshow
/////////////////////////////////////////////

const slider = document.querySelector('.slider-single-js');
const nextButton = document.querySelector('.slide-next-slider-single-js');
const prevButton = document.querySelector('.slide-prev-slider-single-js');

if (slider) {
  // Aggiunge l'evento `init` e `reInit` per aggiornare AOS
  slider.addEventListener('init', function () {
    AOS.refresh();
  });
  slider.addEventListener('reInit', function () {
    AOS.refresh();
  });
  /*
      // Imposta inizialmente il pulsante "prev" come disabilitato
      slider.addEventListener('init', function () {
        prevButton.setAttribute('disabled', 'disabled');
      });
  
      // Evento `afterChange` per abilitare/disabilitare i pulsanti in base allo slide corrente
      slider.addEventListener('afterChange', function (event, slick, currentSlide) {
        const totalSlides = slick.slideCount;
        const currentSlideIndex = currentSlide + 1;
  
        // Disabilita il pulsante "next" se siamo sull'ultimo slide
        if (currentSlideIndex === totalSlides) {
          nextButton.setAttribute('disabled', 'disabled');
        } else {
          nextButton.removeAttribute('disabled');
        }
  
        // Disabilita il pulsante "prev" se siamo sul primo slide
        if (currentSlideIndex === 1) {
          prevButton.setAttribute('disabled', 'disabled');
        } else {
          prevButton.removeAttribute('disabled');
        }
      });
  */
  // Inizializza lo slider Slick con le opzioni
  $(slider).slick({
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
  /*
      // Aggiunge eventi click ai pulsanti per cambiare slide
      nextButton.addEventListener('click', function () {
        $(slider).slick('slickNext');
      });
      prevButton.addEventListener('click', function () {
        $(slider).slick('slickPrev');
      });
      */
}


/////////////////////////////////////////////
// Numbers counter
/////////////////////////////////////////////



function numbersCounter() {
  const counts = document.querySelectorAll('.count');
  if (counts.length > 0) {
    if (animation_duration_counter > 0) {
      const winHeight = window.innerHeight / 1.2;
      const scrollTop = window.scrollY;
      counts.forEach((el) => {
        const dataNumber = parseInt(el.getAttribute('data-bar-number'), 10);
        const elementOffset = el.getBoundingClientRect().top + scrollTop;
        const distance = elementOffset - scrollTop;
        // Avvia il conteggio solo se l'elemento è visibile e textContent è minore di dataNumber
        if (distance < winHeight && parseInt(el.textContent, 10) < dataNumber) {
          let counter = parseInt(el.textContent, 10) || 0; // Inizia dal valore corrente di textContent
          const step = () => {
            if (counter < dataNumber) {
              counter++;
              el.textContent = Math.ceil(counter);
              if (counter < dataNumber - 2) {
                el.classList.add('blurred-counter');
              } else {
                el.classList.remove('blurred-counter');
              }
              requestAnimationFrame(step);
            } else {
              el.classList.remove('blurred-counter');
            }
          };
          step();
        }
      });
    }
    else {
      counts.forEach((el) => {
        const dataNumber = parseInt(el.getAttribute('data-bar-number'), animation_duration_counter);
        el.textContent = dataNumber;
      });
    }
  }
}

/////////////////////////////////////////////
// hide editor section front end labels
/////////////////////////////////////////////

// Aggiunge un evento click a tutto il documento
document.addEventListener('click', function (e) {
  // `e.target` rappresenta l'elemento su cui si è fatto clic
  const target = e.target;

  // Verifica se l'elemento cliccato ha la classe `click-hide`
  if (target.matches('.click-hide')) {
    // Seleziona l'elemento successivo a `target` che dovrebbe avere la classe `hide-me`
    const nextElement = target.nextElementSibling;

    // Controlla che `nextElement` esista e abbia la classe `hide-me`
    if (nextElement && nextElement.classList.contains('hide-me')) {
      // Alterna (aggiunge o rimuove) la classe `hidden-label` su `nextElement`
      nextElement.classList.toggle('hidden-label');

      // Verifica se `nextElement` ha ora la classe `hidden-label`
      const isVisible = nextElement.classList.contains('hidden-label');

      // Cambia il testo di `target` a "+" se `nextElement` è nascosto, altrimenti "-"
      target.textContent = isVisible ? "+" : "-";
    }

    // Previene il comportamento predefinito del clic (ad esempio, evitare che un link si attivi)
    e.preventDefault();
  }
});

/////////////////////////////////////////////
// expandables
/////////////////////////////////////////////

// Seleziona tutti gli elementi con la classe "expander"
const expanders = document.querySelectorAll('.expander');

// Aggiungi un event listener a ciascuno degli elementi
expanders.forEach(expander => {
  expander.addEventListener('click', (event) => {
    event.preventDefault();

    // Ottieni l'ID dell'elemento da espandere
    const expandId = expander.dataset.expandId;

    // Seleziona gli elementi coinvolti nell'espansione
    const expandButton = document.getElementById(`expand-button-${expandId}`);
    const expandContent = document.getElementById(`expand-content-${expandId}`);
    const expandCloseButton = document.getElementById(`expand-close-button-${expandId}`);

    // Verifica lo stato attuale e applica le modifiche necessarie
    if (expandButton.classList.contains('exp-close')) {
      // Se il pulsante è chiuso, apri il contenuto
      expandButton.classList.remove('exp-close');
      expandButton.classList.add('exp-open');
      expandButton.setAttribute('aria-expanded', 'false');
      //expandContent.style.display = 'block';
      expandContent.classList.remove('visible');
      expandCloseButton.setAttribute('aria-expanded', 'false');
      expandCloseButton.tabIndex = -1;
      expandCloseButton.setAttribute('aria-hidden', 'true');
    } else {
      // Se il pulsante è aperto, chiudi il contenuto
      expandButton.classList.remove('exp-open');
      expandButton.classList.add('exp-close');
      expandButton.setAttribute('aria-expanded', 'true');
      //expandContent.style.display = 'none';
      expandContent.classList.add('visible');
      expandCloseButton.setAttribute('aria-expanded', 'true');
      expandCloseButton.removeAttribute('tabindex');
      expandCloseButton.removeAttribute('aria-hidden');
    }
  });
});

const expandersClose = document.querySelectorAll('.expander-closer');

expandersClose.forEach(expander => {
  expander.addEventListener('click', (event) => {
    const expandId = expander.dataset.expandId;

    const elementsToToggle = {
      button: document.getElementById(`expand-button-${expandId}`),
      content: document.getElementById(`expand-content-${expandId}`),
      closeButton: document.getElementById(`expand-close-button-${expandId}`)
    };
    elementsToToggle.content.classList.remove('visible');
    elementsToToggle.button.classList.toggle('exp-open');
    elementsToToggle.button.classList.toggle('exp-close');
    elementsToToggle.button.setAttribute('aria-expanded', 'false');
    elementsToToggle.closeButton.setAttribute('aria-expanded', 'false');
  });
});

/////////////////////////////////////////////
// Play video
/////////////////////////////////////////////

// Trova il primo tag script nel documento
var firstScriptTag = document.getElementsByTagName('script')[0];

// Flag per il caricamento dei video
var load_youtube = false;
var load_vimeo = false;

// Seleziona tutti gli elementi con classe 'play-video-js'
document.querySelectorAll('.play-video-js').forEach(function (element) {
  // Ottiene il valore dell'attributo data-video-source
  var video_source = element.getAttribute('data-video-source');
  // alternativa: var video_source = element.dataset.videoSource;

  // Imposta i flag in base al tipo di video
  if (video_source == 'vimeo') {
    load_vimeo = true;
  }
  if (video_source == 'youtube') {
    load_youtube = true;
  }
});

function add_video_platforms_apis() {
  // Aggiungi preconnect per Vimeo
  if (load_vimeo) {
    // Crea il tag preconnect per Vimeo
    var preconnectVimeo = document.createElement('link');
    preconnectVimeo.rel = 'preconnect';
    preconnectVimeo.href = 'https://player.vimeo.com';
    preconnectVimeo.crossOrigin = 'anonymous';
    document.head.appendChild(preconnectVimeo);

    // Carica lo script Vimeo
    var tag = document.createElement('script');
    tag.src = "https://player.vimeo.com/api/player.js";
    tag.async = true;
    firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
  }

  // Aggiungi preconnect per YouTube
  if (load_youtube) {
    // Crea il tag preconnect per YouTube
    var preconnectYouTube = document.createElement('link');
    preconnectYouTube.rel = 'preconnect';
    preconnectYouTube.href = 'https://www.youtube.com';
    preconnectYouTube.crossOrigin = 'anonymous';
    document.head.appendChild(preconnectYouTube);

    // Carica lo script YouTube
    var tag = document.createElement('script');
    tag.src = "https://www.youtube.com/iframe_api";
    tag.async = true;
    firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
  }
}
add_video_platforms_apis();


// Aggiungi event listener per i click sui video
document.addEventListener('click', function (e) {
  // Verifica se l'elemento cliccato ha la classe 'play-video-js'
  if (e.target.classList.contains('play-video-js')) {
    // Ottieni i dati del video
    var video_source = e.target.getAttribute('data-video-source');
    var video_toplay = e.target.getAttribute('data-video-toplay');

    // Nascondi l'elemento cliccato con fade out
    fadeOut(e.target, 300);

    // Gestione video Vimeo
    if (video_source == 'vimeo') {
      var iframe = document.getElementById(video_toplay);
      var src = document.getElementById(video_toplay).getAttribute("data-src");

      // Aggiorna gli attributi dell'iframe
      var vimeoIframe = document.getElementById(video_toplay);
      vimeoIframe.removeAttribute("data-src");
      vimeoIframe.setAttribute('src', src);
      vimeoIframe.setAttribute('aria-hidden', 'false');

      // Inizializza e avvia il player Vimeo
      var player = new Vimeo.Player(iframe);
      player.play();

      // Gestione pausa alla chiusura del modal
      document.addEventListener('click', function (e) {
        if (e.target.matches('.modal-close-js')) {
          player.pause();
        }
      });
    }

    // Gestione video YouTube
    if (video_source == 'youtube') {
      var youtube_video_id = e.target.getAttribute('data-youtube-video-id');
      var player;

      document.getElementById(video_toplay).setAttribute('aria-hidden', 'false');

      // Inizializza il player YouTube
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

      // Funzione callback per l'avvio del video
      function onPlayerReady(event) {
        event.target.playVideo();
      }

      // Gestione pausa alla chiusura del modal
      document.addEventListener('click', function (e) {
        if (e.target.matches('.modal-close-js')) {
          player.pauseVideo();
        }
      });
    }

    // Gestione video caricati
    if (video_source == 'upload-video') {
      var videoElement = document.getElementById(video_toplay);
      videoElement.play();
      videoElement.setAttribute('aria-hidden', 'false');

      // Gestione pausa alla chiusura del modal
      document.addEventListener('click', function (e) {
        if (e.target.matches('.modal-close-js:not(.initialized)')) {
          videoElement.pause();
        }
      });
    }

    e.preventDefault();
  }
});

// Funzione di utilità per il fadeOut
function fadeOut(element, duration) {
  element.style.opacity = 1;

  var start = performance.now();

  requestAnimationFrame(function animate(currentTime) {
    var elapsed = currentTime - start;

    var opacity = 1 - elapsed / duration;

    if (opacity <= 0) {
      element.style.opacity = 0;
      element.style.display = 'none';
      return;
    }

    element.style.opacity = opacity;
    requestAnimationFrame(animate);
  });
}

/////////////////////////////////////////////
// GA modal open event trigger
/////////////////////////////////////////////

// Aggiungi event listener per l'apertura dei modal
document.addEventListener('click', function (e) {
  // Verifica se l'elemento cliccato è un modal-open non inizializzato
  if (e.target.matches('.modal-open-js')) {
    // Verifica se la funzione gtag di Google Analytics esiste
    if (typeof gtag === 'function') {
      // Ottieni i dati per l'evento GA dai data attributes
      var ga_modal_event_name = e.target.getAttribute('data-ga-modal-event-name');
      var ga_modal_event_cta_text = e.target.getAttribute('data-ga-modal-event-cta-text');
      var ga_modal_event_modal_title = e.target.getAttribute('data-ga-modal-title');

      // Invia l'evento a Google Analytics
      gtag('event', ga_modal_event_name, {
        'page_title': ga_custom_event_cta_page_title,
        'modal_title': ga_modal_event_modal_title,
        'cta_text': ga_modal_event_cta_text
      });
    } else {
      // Log se Google Analytics non è installato
      console.log('Sorry, Google Analytics is not installed.');
    }
  }
});


/////////////////////////////////////////////
// GA custom event trigger
/////////////////////////////////////////////

// Aggiungi event listener per eventi GA personalizzati
document.addEventListener('click', function (e) {
  // Verifica se l'elemento cliccato ha la classe per il trigger dell'evento GA
  if (e.target.matches('.ga-custom-event-trigger-js')) {
    // Verifica se la funzione gtag di Google Analytics esiste
    if (typeof gtag === 'function') {
      // Ottieni i dati per l'evento GA dai data attributes
      var ga_custom_event_name = e.target.getAttribute('data-ga-custom-event-name');
      var ga_custom_event_cta_text = e.target.getAttribute('data-ga-custom-event-cta-text');
      var ga_custom_event_cta_url = e.target.getAttribute('data-ga-custom-event-cta-url');
      var ga_custom_event_cta_page_title = e.target.getAttribute('data-ga-custom-event-cta-page-title');

      // Invia l'evento personalizzato a Google Analytics
      gtag('event', ga_custom_event_name, {
        'page_title': ga_custom_event_cta_page_title,
        'page_location': ga_custom_event_cta_url,
        'cta_text': ga_custom_event_cta_text
      });
    } else {
      // Log se Google Analytics non è installato
      console.log('Sorry, Google Analytics is not installed.');
    }
  }
});

/////////////////////////////////////////////
// GA custom event trigger A/B test
/////////////////////////////////////////////

// Aggiungi event listener per eventi GA A/B testing
document.addEventListener('click', function (e) {
  // Verifica se l'elemento cliccato è un trigger A/B non inizializzato
  if (e.target.matches('.ga-ab-event-trigger-js:not(.initialized)')) {
    // Verifica se la funzione gtag di Google Analytics esiste
    if (typeof gtag === 'function') {
      // Ottieni i dati per l'evento GA dai data attributes
      var ga_custom_event_name = e.target.getAttribute('data-ga-ab-event-name');
      var ga_custom_event_cta_text = e.target.getAttribute('data-ga-ab-cta-text');
      var ga_custom_event_cta_url = e.target.getAttribute('data-ga-ab-cta-url');

      // Invia l'evento A/B a Google Analytics
      gtag('event', ga_custom_event_name, {
        'cta_text': ga_custom_event_cta_text,
        'cta_url': ga_custom_event_cta_url
      });
    } else {
      // Log se Google Analytics non è installato
      console.log('Sorry, Google Analytics is not installed.');
    }
  }
});

/////////////////////////////////////////////
// Clear overlay scroll when resizing desktop - mobile: attivare se la versione desktop non ha menu overlay
/////////////////////////////////////////////

function clearOverlayScroll() {
  // Ottieni la larghezza della finestra
  var clearOverlayScroll_window_width = window.innerWidth;
  // oppure: var clearOverlayScroll_window_width = document.documentElement.clientWidth;

  // Verifica se l'overlay è visibile (non ha classe 'hidden')
  if (!document.getElementById('head-overlay').classList.contains('hidden')) {
    // Imposta lo scroll in base alla larghezza della finestra
    if (clearOverlayScroll_window_width > 1023) {
      // Per schermi larghi, permetti lo scroll
      document.documentElement.style.overflow = 'visible';
      document.body.style.overflow = 'visible';
    } else {
      // Per schermi stretti, blocca lo scroll
      document.documentElement.style.overflow = 'hidden';
      document.body.style.overflow = 'hidden';
    }
  }
}


// Ascolta l'evento DOMContentLoaded per eseguire il codice quando il DOM è completamente caricato
window.addEventListener('DOMContentLoaded', () => {
  // Verifica se l'app è in modalità standalone (PWA) o browser normale
  const displayMode = window.matchMedia('(display-mode: standalone)').matches ? 'standalone' : 'browser tab';

  // Se l'app è in modalità standalone (PWA)
  if (displayMode === 'standalone') {
    // Funzione che gestisce l'evento di scaricamento della pagina
    function handleUnload() {
      // Aggiunge la classe per la navigazione PWA al body
      document.body.classList.add('pwa-navigation');
    }
    // Assegna la funzione all'evento onbeforeunload della finestra
    window.onbeforeunload = handleUnload;
  }
});

/*
// link esterno
// Crea una regex per il controllo del dominio corrente
const hostRegex = new RegExp(location.host);

// Seleziona tutti i link nella pagina
document.querySelectorAll('a').forEach(link => {
 // Ottiene l'attributo href del link
 const href = link.getAttribute('href');
 
 // Verifica le condizioni per cui NON aprire in nuova tab:
 // - contiene hashtag
 // - stesso dominio
 // - href non definito o vuoto
 if (href?.indexOf("#") >= 0 || 
     hostRegex.test(href) || 
     !href || 
     href === '') {
   return;
 }
 
 // Imposta target _blank per i link esterni
 link.setAttribute('target', '_blank');
});
*/



document.querySelectorAll('.remove-underline-js, .cta-holder a').forEach(function (element) {
  element.addEventListener('mouseenter', function () {
    this.parentElement.parentElement.classList.add('no-underline');
  });

  element.addEventListener('mouseleave', function () {
    this.parentElement.parentElement.classList.remove('no-underline');
  });
});

/////////////////////////////////////////////
// Window ready / scroll / resize events
/////////////////////////////////////////////
document.addEventListener('scroll', { passive: true });
document.addEventListener('scroll', (event) => {
  scrollDirectionMenu();
  numbersCounter();
  acessibilityPanelHide();
});

document.addEventListener('DOMContentLoaded', () => {
  numbersCounter();
});


window.addEventListener('resize', function () {
  // Aggiungi un debounce per migliorare le performance
  if (this.resizeTimeout) {
    clearTimeout(this.resizeTimeout);
  }

  this.resizeTimeout = setTimeout(function () {
    clearOverlayScroll();
  }, 200);
});