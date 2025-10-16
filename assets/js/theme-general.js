/////////////////////////////////////////////
// Document language
/////////////////////////////////////////////
const lang_get = document.documentElement.lang || 'default';
const lang = lang_get.split('-')[0].toLowerCase();

/////////////////////////////////////////////
// Configurazione accessibilità
/////////////////////////////////////////////
const ACCESSIBILITY_CONFIG = {
  // Impostazioni per applicare automaticamente le preferenze di sistema
  autoApplySystemPreferences: {
    reducedMotion: false,      // Se true, applica automaticamente prefers-reduced-motion
    darkMode: false,           // Se true, applica automaticamente prefers-color-scheme
    highContrast: false,        // Se true, applica automaticamente prefers-contrast
    reducedTransparency: false  // Se true, applica automaticamente prefers-reduced-transparency
  }
};

/////////////////////////////////////////////
// Rileva preferenze di sistema
/////////////////////////////////////////////
// Funzione per rilevare la capacità di supportare trasparenza ridotta basata su OS
function detectReducedTransparencySupport() {
  // Controlla se siamo su un sistema Apple (macOS/iOS)
  const isAppleDevice = /Mac|iPad|iPhone|iPod/.test(navigator.userAgent);

  // Debug media queries
  const appleQuery = window.matchMedia('(-apple-prefers-reduced-transparency: reduce)');
  const standardQuery = window.matchMedia('(prefers-reduced-transparency: reduce)');

  // Se è un dispositivo Apple, possiamo provare a rilevare l'impostazione
  if (isAppleDevice) {
    const result = appleQuery.matches || standardQuery.matches;
    return result;
  }

  // Per altri sistemi, possiamo usare solo il contrasto elevato come alternativa
  return false;
}

const systemPreferences = {
  isReduced: window.matchMedia('(prefers-reduced-motion: reduce)').matches,
  prefersDarkMode: window.matchMedia('(prefers-color-scheme: dark)').matches,
  prefersHighContrast: window.matchMedia('(prefers-contrast: more)').matches,
  prefersReducedTransparency: detectReducedTransparencySupport()
};

// Definisce la chiave costante per le preferenze
const PREFERENCES_KEY = 'paperplane_user_preferences';

/////////////////////////////////////////////
// accessibility default
/////////////////////////////////////////////
// Applica reduced motion in base alla configurazione
const isReduced = ACCESSIBILITY_CONFIG.autoApplySystemPreferences.reducedMotion
  ? systemPreferences.isReduced
  : false;

if (isReduced) {
  // Applica l'attributo data-reduced-motion
  document.documentElement.setAttribute('data-reduced-motion', 'true');

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

  // NON nascondere il pulsante reduce-motion anche se le preferenze di sistema sono attive
  // Aggiorniamo solo il suo stato
  document.querySelectorAll('.paperplane-reduce-motion-js').forEach(el => {
    el.setAttribute('aria-checked', 'false');
  });
} else {
  var animation_duration, animation_duration_counter;
}

// Applica dark mode in base alla configurazione
if (ACCESSIBILITY_CONFIG.autoApplySystemPreferences.darkMode && systemPreferences.prefersDarkMode) {
  document.documentElement.setAttribute('data-theme', 'dark');
}

// Applica high contrast o reduced transparency in base alla configurazione
if ((ACCESSIBILITY_CONFIG.autoApplySystemPreferences.highContrast && systemPreferences.prefersHighContrast) ||
  (ACCESSIBILITY_CONFIG.autoApplySystemPreferences.reducedTransparency && systemPreferences.prefersReducedTransparency)) {
  document.documentElement.setAttribute('data-reduced-transparency', 'true');
}

/////////////////////////////////////////////
// accessibility user
/////////////////////////////////////////////

function saveArrayToLocalStorage(arrayName, array) {
  localStorage.setItem(arrayName, JSON.stringify(array));
}

// Funzione centralizzata per salvare le preferenze sia in localStorage che come cookie
function saveUserPreferences(preferences) {
  // Salva in localStorage
  saveArrayToLocalStorage(PREFERENCES_KEY, preferences);

  // Salva come cookie (trasformando l'oggetto in JSON)
  const expry_date_cookie = addHours(new Date(), (1 * 24) * 365);

  document.cookie = PREFERENCES_KEY + "=" +
    JSON.stringify(preferences) +
    "; expires=" + expry_date_cookie + "; path=/";
}

function addHours(date, hours) {
  date.setTime(date.getTime() + hours * 60 * 60 * 1000);
  return date;
}

if (localStorage.getItem(PREFERENCES_KEY) != null) {
  const now = new Date();
  const paperplane_user_preferences_array = JSON.parse(
    localStorage.getItem(PREFERENCES_KEY)
  );
  Object.keys(paperplane_user_preferences_array).forEach(function (key) {
    if (key == 'expiry' && now.getTime() > paperplane_user_preferences_array[key]) {
      localStorage.removeItem(PREFERENCES_KEY);
    }
  });
}

if (localStorage.getItem(PREFERENCES_KEY) === null) {
  const expry_date = addHours(new Date(), (1 * 24) * 365);

  // Imposta valori iniziali basati sulle preferenze del sistema
  // Per reduced_transparency, impostiamo 1 se il sistema ha preferenze alto contrasto o trasparenza ridotta
  const initialReducedMotion = ACCESSIBILITY_CONFIG.autoApplySystemPreferences.reducedMotion && systemPreferences.isReduced ? 0 : 1;
  const initialReducedTransparency = systemPreferences.prefersHighContrast || systemPreferences.prefersReducedTransparency ? 1 : 0;
  const initialDarkMode = ACCESSIBILITY_CONFIG.autoApplySystemPreferences.darkMode && systemPreferences.prefersDarkMode ? 1 : 0;

  const initial_a11y_values = {
    expiry: expry_date.getTime(),
    reduced_motion: initialReducedMotion,
    reduced_transparency: initialReducedTransparency,
    dark_mode: initialDarkMode
  };

  // Salva sia in localStorage che come cookie
  saveUserPreferences(initial_a11y_values);
}

document.addEventListener('click', function (e) {
  // Verifica se l'elemento cliccato o uno dei suoi genitori ha la classe specificata
  const target = e.target.closest('.paperplane-reduce-motion-js');
  if (target) {
    const paperplane_user_preferences_array = JSON.parse(
      localStorage.getItem(PREFERENCES_KEY)
    );

    Object.keys(paperplane_user_preferences_array).forEach(function (key) {
      if (key == 'reduced_motion') {
        // Inverti il valore tra 0 e 1
        paperplane_user_preferences_array[key] = paperplane_user_preferences_array[key] === 0 ? 1 : 0;
      }
    });

    // Usa la nuova funzione per salvare sia in localStorage che come cookie
    saveUserPreferences(paperplane_user_preferences_array);
    userSetAccessibility();
    e.preventDefault();
  }
});

document.addEventListener('click', function (e) {
  // Verifica se l'elemento cliccato o uno dei suoi genitori ha la classe specificata
  const target = e.target.closest('.paperplane-reduce-transparency-js');
  if (target) {
    const paperplane_user_preferences_array = JSON.parse(
      localStorage.getItem(PREFERENCES_KEY)
    );

    Object.keys(paperplane_user_preferences_array).forEach(function (key) {
      if (key == 'reduced_transparency') {
        // Inverti il valore tra 1 e 0
        paperplane_user_preferences_array[key] = paperplane_user_preferences_array[key] === 1 ? 0 : 1;
      }
    });

    // Usa la nuova funzione per salvare sia in localStorage che come cookie
    saveUserPreferences(paperplane_user_preferences_array);
    userSetAccessibility();
    e.preventDefault();
  }
});

document.addEventListener('click', function (e) {
  const target = e.target.closest('.paperplane-darkmode-js');
  if (target) {
    const paperplane_user_preferences_array = JSON.parse(
      localStorage.getItem(PREFERENCES_KEY)
    );

    Object.keys(paperplane_user_preferences_array).forEach(function (key) {
      if (key == 'dark_mode') {
        if (paperplane_user_preferences_array[key] == 1) {
          // Passa alla modalità chiara
          paperplane_user_preferences_array[key] = 0;
          document.documentElement.setAttribute('data-theme', 'light');
        } else if (paperplane_user_preferences_array[key] == 0) {
          // Passa alla modalità scura
          paperplane_user_preferences_array[key] = 1;
          document.documentElement.setAttribute('data-theme', 'dark');
        }
      }
    });

    // Usa la nuova funzione per salvare sia in localStorage che come cookie
    saveUserPreferences(paperplane_user_preferences_array);
    userSetAccessibility();
    e.preventDefault();
  }
});

function userSetAccessibility() {
  const paperplane_user_preferences_options_array = JSON.parse(
    localStorage.getItem(PREFERENCES_KEY)
  );

  // Flag per tenere traccia se le preferenze sono state modificate manualmente
  const hasUserPreferences = (localStorage.getItem(PREFERENCES_KEY) !== null);

  Object.keys(paperplane_user_preferences_options_array).forEach(function (key) {
    // Gestione reduced motion
    if (key == 'reduced_motion') {
      const useReducedMotion = paperplane_user_preferences_options_array[key] == 0 ||
        (!hasUserPreferences && ACCESSIBILITY_CONFIG.autoApplySystemPreferences.reducedMotion &&
          systemPreferences.isReduced);

      if (useReducedMotion) {
        document.documentElement.setAttribute('data-reduced-motion', 'true');

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
      } else {
        document.documentElement.removeAttribute('data-reduced-motion');

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
    }

    // Gestione reduced transparency
    if (key == 'reduced_transparency') {
      // IMPORTANTE: Qui ignoriamo hasUserPreferences e applichiamo le preferenze di sistema direttamente
      // se l'utente ha impostato reduced_transparency su 1 nelle preferenze O
      // se una delle preferenze di sistema è attiva
      const useReducedTransparency = paperplane_user_preferences_options_array[key] == 1 ||
        systemPreferences.prefersHighContrast ||
        systemPreferences.prefersReducedTransparency;

      if (useReducedTransparency) {
        document.documentElement.setAttribute('data-reduced-transparency', 'true');
        document.querySelectorAll('.paperplane-reduce-transparency-js').forEach(el => {
          el.setAttribute('aria-checked', 'true');
        });
      } else {
        document.documentElement.removeAttribute('data-reduced-transparency');
        document.querySelectorAll('.paperplane-reduce-transparency-js').forEach(el => {
          el.setAttribute('aria-checked', 'false');
        });
      }
    }

    // Gestione dark mode
    if (key == 'dark_mode') {
      const useDarkMode = paperplane_user_preferences_options_array[key] == 1 ||
        (!hasUserPreferences && ACCESSIBILITY_CONFIG.autoApplySystemPreferences.darkMode &&
          systemPreferences.prefersDarkMode);

      if (useDarkMode) {
        // Imposta attributo data-theme per la dark mode
        document.documentElement.setAttribute('data-theme', 'dark');
        document.querySelectorAll('.paperplane-darkmode-js').forEach(el => {
          el.setAttribute('aria-checked', 'true');
        });
      } else {
        // Imposta attributo data-theme per la light mode
        document.documentElement.setAttribute('data-theme', 'light');
        document.querySelectorAll('.paperplane-darkmode-js').forEach(el => {
          el.setAttribute('aria-checked', 'false');
        });
      }
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

// Aggiungi listener per lo scroll per nascondere/mostrare il pannello di accessibilità
window.addEventListener('scroll', acessibilityPanelHide);

/////////////////////////////////////////////
// Video bg play/pause
/////////////////////////////////////////////

document.addEventListener('click', function (e) {
  // Verifica se il target dell'evento è un elemento con la classe richiesta
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
// Sistema Menu - Gestione Unificata
/////////////////////////////////////////////

// Funzioni di utilità
const MenuUtils = {
  // Imposta attributi di accessibilità e alterna classe
  setElementState: function (element, isOpen, stateClass = 'open') {
    if (isOpen) {
      element.classList.add(stateClass);
      element.setAttribute('aria-expanded', 'true');
    } else {
      element.classList.remove(stateClass);
      element.setAttribute('aria-expanded', 'false');
    }
    return isOpen;
  },

  // Calcola e applica le altezze degli elementi di navigazione
  updateNavigationHeights: function () {
    // Calcola l'altezza totale degli elementi di navigazione
    let navigationElementsHeight = 0;
    const preHeader = document.getElementById('pre-header');
    const header = document.getElementById('header');

    // Calcola l'altezza visibile del pre-header
    if (preHeader) {
      const preHeaderRect = preHeader.getBoundingClientRect();
      if (preHeaderRect.bottom > 0) { // Almeno una parte è visibile
        // Se parte del pre-header è fuori dal viewport (sopra), calcola solo la parte visibile
        const visibleHeight = preHeaderRect.top < 0
          ? preHeaderRect.bottom // Altezza dalla parte superiore del viewport fino al fondo del pre-header
          : preHeaderRect.height; // Altezza completa se completamente visibile

        navigationElementsHeight += visibleHeight;
      }
    }

    if (header) navigationElementsHeight += header.offsetHeight;

    // Applica la posizione top ai mega menu
    const megaMenus = document.querySelectorAll('.mega-menu-js');
    megaMenus.forEach(menu => {
      menu.style.top = navigationElementsHeight + 'px';
    });

    // Applica SOLO l'altezza all'overlay
    const headOverlay = document.getElementById('head-overlay');
    if (headOverlay) {
      headOverlay.style.height = `calc(100dvh - ${navigationElementsHeight}px)`;
    }
  }
};


// Gestore Menu Principale
const MenuManager = {
  // Memorizza i tasti premuti per scorciatoie da tastiera
  pressedKeys: new Set(),
  // Memorizza l'ultima posizione di scorrimento
  lastScrollTop: 0,

  // Inizializza tutte le funzionalità del menu
  init: function () {
    this.setupHamburgerMenu();
    this.setupMegaMenu();
    this.setupSubMenus();
    this.setupKeyboardHandlers();
    this.setupMenuClosers();

    // Aggiunge ascoltatore di eventi per effetto menu durante lo scorrimento
    window.addEventListener('scroll', () => this.scrollDirectionMenu());

    // Aggiunge ascoltatore di eventi per il ridimensionamento
    window.addEventListener('resize', () => MenuUtils.updateNavigationHeights());

    // Calcola le altezze iniziali
    MenuUtils.updateNavigationHeights();
  },

  // Gestisce l'attivazione del menu hamburger
  toggleHamburgerMenu: function (forceClose = false) {
    const hamActivator = document.querySelector('#hamburger-button');
    const headOverlay = document.getElementById('head-overlay');
    const scrollOpportunityOverlay = document.querySelector('.scroll-opportunity-overlay-js');
    const header = document.getElementById('header');
    const pageContent = document.getElementById('page-content');

    // Determina lo stato
    let isOpen = hamActivator.classList.contains('open');
    if (forceClose) isOpen = true; // Logica per chiusura forzata

    // Aggiorna lo stato dell'UI
    MenuUtils.setElementState(hamActivator, !isOpen, 'open');
    headOverlay.classList.toggle('hidden', isOpen);

    // Gestisce il posizionamento dell'header/contenuto
    if (!isOpen) {
      header.classList.add('fixed');
      if (pageContent) {
        const headerHeight = header.offsetHeight;
        pageContent.style.marginTop = headerHeight + 'px';
      }
    } else {
      header.classList.remove('fixed');
      if (pageContent) {
        pageContent.style.marginTop = '0';
      }
    }

    // Resetta la posizione di scorrimento
    if (!isOpen && scrollOpportunityOverlay) {
      scrollOpportunityOverlay.scrollTop = 0;
    }

    // Chiude i sottomenu se si apre l'hamburger
    if (!isOpen) {
      this.closeAllSubMenus();
    } else {
      // Quando si chiude il menu hamburger, aggiorna lo sfondo dell'intestazione
      this.updateHeaderBackground();
    }

    return !isOpen; // Restituisce il nuovo stato
  },

  // Chiude tutti i mega menu e i sottomenu
  closeAllSubMenus: function () {
    // Nasconde tutti i mega menu
    document.querySelectorAll('.mega-menu-js').forEach(menu =>
      menu.classList.add('hidden'));

    // Resetta gli attivatori del mega menu
    document.querySelectorAll('.mega-menu-js-trigger').forEach(trigger => {
      trigger.classList.remove('clicked');
      trigger.setAttribute('aria-expanded', 'false');
    });

    // Resetta i sottomenu desktop
    document.querySelectorAll('.header-menu-js > .menu-item-has-children > .sub-menu-btn').forEach(btn => {
      btn.classList.remove('clicked');
      btn.setAttribute('aria-expanded', 'false');
    });

    // Nasconde tutti i sottomenu
    document.querySelectorAll('.sub-menu').forEach(menu =>
      menu.classList.remove('visible'));

    // Resetta i pulsanti di chiusura
    document.querySelectorAll('.submenu-close-js').forEach(close =>
      close.classList.remove('active'));

    // Verifica se è necessario mantenere lo sfondo dell'intestazione in base alla posizione di scorrimento
    this.updateHeaderBackground();
  },

  // Configura gli eventi del menu hamburger
  setupHamburgerMenu: function () {
    const hamburgerButton = document.getElementById('hamburger-button');
    if (hamburgerButton) {
      hamburgerButton.addEventListener('click', () => this.toggleHamburgerMenu());
    }

    // Gestisce il reset dell'overlay
    const overlayNaviReset = document.querySelector('.overlay-navi-reset-js');
    if (overlayNaviReset) {
      overlayNaviReset.addEventListener('focusin', (e) => {
        const hamburgerButton = document.querySelector('#hamburger-button');
        if (hamburgerButton) hamburgerButton.focus();
        e.preventDefault();
      });
    }
  },

  // Configura il mega menu con eventi delegati
  setupMegaMenu: function () {
    document.addEventListener('click', (e) => {
      const trigger = e.target.closest('.mega-menu-js-trigger');
      if (!trigger) return;

      // Ottiene l'ID del menu
      const megamenuId = trigger.dataset.megamenuOpenId;
      const megaMenu = document.querySelector(`.mega-menu-js-${megamenuId}-target`);
      const header = document.getElementById('header');
      const isOpen = trigger.classList.contains('clicked');

      // Resetta prima gli altri mega menu
      document.querySelectorAll('.mega-menu-js-trigger').forEach(otherTrigger => {
        if (otherTrigger !== trigger && otherTrigger.classList.contains('clicked')) {
          otherTrigger.classList.remove('clicked');
          otherTrigger.setAttribute('aria-expanded', 'false');

          const otherId = otherTrigger.dataset.megamenuOpenId;
          const otherMenu = document.querySelector(`.mega-menu-js-${otherId}-target`);
          if (otherMenu) otherMenu.classList.add('hidden');
        }
      });

      // Alterna questo menu
      trigger.classList.toggle('clicked', !isOpen);
      trigger.setAttribute('aria-expanded', !isOpen);

      if (megaMenu) {
        megaMenu.classList.toggle('hidden', isOpen);
      }

      // Alterna il pulsante di chiusura
      const closeButton = document.querySelector('.submenu-close-js');
      if (closeButton) closeButton.classList.toggle('active', !isOpen);

      // Aggiorna lo stato dello sfondo dell'header
      this.updateHeaderBackground();

      // Chiude il menu hamburger
      this.toggleHamburgerMenu(true);

      // Aggiorna le altezze di navigazione
      MenuUtils.updateNavigationHeights();
    });
  },

  // Configura i sottomenu con eventi delegati
  setupSubMenus: function () {
    // Sottomenu desktop
    document.addEventListener('click', (e) => {
      const btn = e.target.closest('.header-menu-js > .menu-item-has-children > .sub-menu-btn');
      if (!btn) return;

      const isOpen = btn.classList.contains('clicked');
      const subMenu = btn.parentElement.querySelector('.sub-menu');

      // Alterna lo stato del pulsante
      btn.classList.toggle('clicked', !isOpen);
      btn.setAttribute('aria-expanded', !isOpen);

      // Alterna la visibilità del sottomenu
      if (subMenu) {
        subMenu.classList.toggle('visible', !isOpen);
      }

      // Alterna il pulsante di chiusura
      document.querySelectorAll('.submenu-close-js').forEach(closeBtn => {
        closeBtn.classList.toggle('active', !isOpen);
      });

      // Aggiorna lo stato dello sfondo dell'header
      this.updateHeaderBackground();

      // Chiude l'hamburger
      this.toggleHamburgerMenu(true);
    });

    // Sottomenu mobile overlay
    document.addEventListener('click', (e) => {
      const button = e.target.closest('.overlay-menu-mobile-js > .menu-item-has-children > .sub-menu-btn');
      if (!button) return;

      const subMenu = button.parentElement.querySelector('.sub-menu');
      const isOpen = button.classList.contains('clicked');

      button.classList.toggle('clicked', !isOpen);
      button.setAttribute('aria-expanded', !isOpen);

      if (subMenu) {
        subMenu.classList.toggle('visible', !isOpen);
      }

      // Aggiorna lo stato dello sfondo dell'header
      this.updateHeaderBackground();
    });
  },

  // Configura i gestori da tastiera per la navigazione del menu
  setupKeyboardHandlers: function () {
    // Traccia i tasti premuti per le scorciatoie da tastiera
    document.addEventListener('keydown', (e) => {
      this.pressedKeys.add(e.key);

      // Combinazione P + ESC per chiudere il menu hamburger
      if (this.pressedKeys.has('p') && this.pressedKeys.has('Escape')) {
        const hamburgerButton = document.querySelector('.ham-activator-js');
        if (hamburgerButton) hamburgerButton.focus();
        this.toggleHamburgerMenu(true);
      }

      // ESC per chiudere i megamenu
      if (e.key === 'Escape') {
        // Chiude i menu solo se non ci sono modali aperte
        const openModals = document.querySelectorAll('.paperplane-modal:not(.hidden)');
        if (openModals.length === 0) {
          this.closeAllSubMenus();
        }
      }
    });

    // Cancella i tasti su keyup
    document.addEventListener('keyup', (e) => {
      this.pressedKeys.delete(e.key);
    });

    // Gestisce la navigazione con tab
    const lastOverlayLink = document.querySelector('#head-overlay a:last-of-type');
    if (lastOverlayLink) {
      lastOverlayLink.addEventListener('keydown', (event) => {
        if (event.key === 'Tab' && !event.shiftKey) {
          this.closeAllSubMenus();
        }
      });
    }
  },

  // Configura i dispositivi di chiusura del menu
  setupMenuClosers: function () {
    // Gestisce il pulsante di chiusura sottomenu
    document.addEventListener('click', (e) => {
      if (e.target.matches('.submenu-close-js')) {
        this.closeAllSubMenus();
      }
    });

    // Chiude i menu quando si mette a fuoco certi elementi
    document.querySelectorAll('.header-menu .mega-menu-js-trigger, .header-menu .sub-menu-btn, .header-menu .simple-link').forEach(element => {
      element.addEventListener('focusin', () => this.closeAllSubMenus());
    });
  },

  // Gestisce l'effetto di scorrimento del menu
  scrollDirectionMenu: function () {
    var st = window.scrollY;
    this.updateHeaderBackground(st);
    this.lastScrollTop = st;

    // Aggiorna le altezze di navigazione durante lo scorrimento
    MenuUtils.updateNavigationHeights();
  },

  // Aggiorna lo sfondo dell'header in base alla posizione di scorrimento o allo stato del menu
  updateHeaderBackground: function (scrollTop) {
    const header = document.getElementById('header');
    if (!header) return;

    // Se scrollTop non è fornito, usa la posizione di scorrimento corrente
    const st = scrollTop !== undefined ? scrollTop : window.scrollY;

    // Verifica la presenza di menu aperti che dovrebbero forzare lo sfondo
    const hasOpenMenus = document.querySelector('.mega-menu-js-trigger.clicked') ||
      document.querySelector('.header-menu-js > .menu-item-has-children > .sub-menu-btn.clicked') ||
      document.querySelector('#hamburger-button.open');

    // Aggiunge sfondo se lo scorrimento supera la soglia O se un menu è aperto
    if (st > 200 || hasOpenMenus) {
      header.classList.add('backgrounded');
    } else {
      header.classList.remove('backgrounded');
    }
  }
};

// Inizializzazione del Gestore Menu (al posto della funzione hamburgerMenu originale)
document.addEventListener('DOMContentLoaded', () => {
  MenuManager.init();
});

// Funzione globale per compatibilità con codice esistente
function scrollDirectionMenu() {
  if (MenuManager) {
    MenuManager.scrollDirectionMenu();
  }
}

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
    //modal.setAttribute('aria-hidden', 'false');

    const focusable = modal.querySelectorAll('button, a, input:not([type=hidden]), select, textarea, [tabindex]:not([tabindex="-1"])');
    if (focusable.length > 0) {
      setTimeout(function () {
        focusable[1] ? focusable[1].focus() : focusable[0].focus();
      }, 50);
    }

    document.documentElement.style.overflow = 'hidden';
    MenuManager.toggleHamburgerMenu(true);
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
    //modal.setAttribute('aria-hidden', 'true');

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

  // Se ci sono elementi focusabili, aggiungi gli// Aggiungi un event listener per i tasti premuti sul modal
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

const slider = document.querySelector('.slider-images-js');
const nextButton = document.querySelector('.slide-next-slider-single-js');
const prevButton = document.querySelector('.slide-prev-slider-single-js');
if (lang === 'it') {
  nextSlideLabel = 'Slide successiva';
  prevSlideLabel = 'Slide precedente';
}
else {
  nextSlideLabel = 'Next slide';
  prevSlideLabel = 'Previous slide';
}

if (slider) {
  // Aggiunge l'evento `init` e `reInit` per aggiornare AOS
  slider.addEventListener('init', function () {
    AOS.refresh();
  });
  slider.addEventListener('reInit', function () {
    AOS.refresh();
  });

  // Inizializza lo slider Slick con le opzioni
  $('.slider-images-js').slick({
    focusOnSelect: false,
    draggable: true,
    infinite: true,
    accessibility: true,
    adaptiveHeight: false,
    slidesToShow: 1,
    slidesToScroll: 1,
    arrows: true,
    dots: true,
    variableWidth: true,
    nextArrow: '<button class="slick-next element-icon-after"><span class="screen-reader-text" aria-hiden="true">' + nextSlideLabel + '</span></button>',
    prevArrow: '<button class="slick-prev element-icon-after"><span class="screen-reader-text" aria-hiden="true">' + prevSlideLabel + '</span></button>',
    responsive: [{
      breakpoint: 1024,
      settings: {
        slidesToShow: 1,
        slidesToScroll: 1
      }
    }]
  });
}



function adjustCaptionWidths() {
  // Seleziona tutte le slide attive
  const activeSlides = document.querySelectorAll('.slick-slide.slick-active');

  activeSlides.forEach(slideContainer => {
    // Trova l'immagine all'interno della slide
    const img = slideContainer.querySelector('.slide img');

    // Trova la didascalia correlata
    const caption = slideContainer.querySelector('.slide-caption');

    if (img && caption) {
      // Ottieni la larghezza reale dell'immagine renderizzata
      const imgWidth = img.offsetWidth;

      // Imposta la larghezza della didascalia
      caption.style.width = `${imgWidth}px`;

      // Rimuovi la classe hidden dalla didascalia
      caption.classList.remove('hidden');
    }
  });
}

// Aggancia a Slick Slider events
document.addEventListener('DOMContentLoaded', function () {
  // Assumi che lo slider sia già inizializzato con un ID o classe
  const slider = document.querySelector('.slider-images-js'); // Aggiorna con il selettore corretto

  if (slider && typeof $(slider).slick === 'function') {
    // Usa l'evento init di Slick
    $(slider).on('init reInit afterChange', function () {
      // Attendi un po' per assicurarti che il rendering sia completo
      setTimeout(adjustCaptionWidths, 50);
    });

    // Se lo slider è già stato inizializzato, aggiusta subito
    if (document.querySelectorAll('.slick-initialized').length > 0) {
      setTimeout(adjustCaptionWidths, 50);
    }
  }

  // Fallback nel caso Slick non sia ancora inizializzato
  setTimeout(adjustCaptionWidths, 500);
});

// Gestisci il ridimensionamento della finestra
window.addEventListener('resize', function () {
  // Aggiungi un ritardo per lasciare che Slick si stabilizzi
  setTimeout(adjustCaptionWidths, 100);
});

// Aggiungi anche un listener per il caricamento delle immagini
window.addEventListener('load', function () {
  setTimeout(adjustCaptionWidths, 100);
});


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

// Aggiungi event listener per mouseenter e mouseleave a ciascun expander
expanders.forEach(expander => {
  expander.addEventListener('mouseenter', () => {
    // Trova il parent "expanding-block" del bottone
    const expandingBlock = expander.closest('.expanding-block');
    // Aggiungi la classe "hovered" all'expanding-block
    if (expandingBlock) {
      expandingBlock.classList.add('hovered');
    }
  });

  expander.addEventListener('mouseleave', () => {
    // Trova il parent "expanding-block" del bottone
    const expandingBlock = expander.closest('.expanding-block');
    // Rimuovi la classe "hovered" dall'expanding-block
    if (expandingBlock) {
      expandingBlock.classList.remove('hovered');
    }
  });
});

// Mantieni il resto del codice originale per le funzionalità di espansione...
// Seleziona tutti gli elementi con la classe "expander"
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
      expandContent.classList.remove('visible');
      expandCloseButton.setAttribute('aria-expanded', 'false');
      expandCloseButton.tabIndex = -1;
      expandCloseButton.setAttribute('aria-hidden', 'true');
    } else {
      // Se il pulsante è aperto, chiudi il contenuto
      expandButton.classList.remove('exp-open');
      expandButton.classList.add('exp-close');
      expandButton.setAttribute('aria-expanded', 'true');
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
// Clear overlay scroll when resizing desktop - mobile: attivare se la versione desktop non ha menu overlay
/////////////////////////////////////////////

function clearOverlayScroll() {
  // Ottieni la larghezza della finestra
  var clearOverlayScroll_window_width = window.innerWidth;

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

/////////////////////////////////////////////
// Tracking System
/////////////////////////////////////////////

window.TrackingSystem = (function () {
  // Configurazione dei tracking ID per piattaforma e lingua
  const TRACKING_CONFIG = {
    linkedin: {
      it: { contact: 20851897, download: 20851898, form_submit: 20851899 },
      en: { contact: 20851900, download: 20851901, form_submit: 20851902 },
      default: { contact: 20851897, download: 20851898, form_submit: 20851899 }
    },
    facebook: {
      it: { contact: 'FB123', download: 'FB124', form_submit: 'FB125' },
      en: { contact: 'FB126', download: 'FB127', form_submit: 'FB128' },
      default: { contact: 'FB123', download: 'FB124', form_submit: 'FB125' }
    },
    analytics: {
      all: {
        contact: 'contact_event',
        download: 'download_event',
        form_submit: 'form_submit_event'
      }
    }
  };

  // Funzione per ottenere la lingua corrente
  function getCurrentLanguage() {
    const lang = document.documentElement.lang || 'default';
    return lang.split('-')[0].toLowerCase();
  }

  // Handler per le diverse piattaforme
  const trackingHandlers = {
    linkedin: function (eventName, metadata) {
      const lang = getCurrentLanguage();
      const config = TRACKING_CONFIG.linkedin[lang] || TRACKING_CONFIG.linkedin.default;
      const conversionId = config[eventName];

      if (window.lintrk && conversionId) {
        window.lintrk('track', { conversion_id: conversionId });
        console.log('LinkedIn track:', { eventName, conversionId, metadata });
      }
    },

    facebook: function (eventName, metadata) {
      const lang = getCurrentLanguage();
      const config = TRACKING_CONFIG.facebook[lang] || TRACKING_CONFIG.facebook.default;
      const eventId = config[eventName];

      if (window.fbq && eventId) {
        // Lista degli eventi standard di Facebook
        const standardEvents = [
          'AddPaymentInfo', 'AddToCart', 'AddToWishlist', 'CompleteRegistration',
          'Contact', 'CustomizeProduct', 'Donate', 'FindLocation', 'InitiateCheckout',
          'Lead', 'PageView', 'Purchase', 'Schedule', 'Search', 'StartTrial',
          'SubmitApplication', 'Subscribe', 'ViewContent'
        ];

        // Usa track per eventi standard e trackCustom per eventi personalizzati
        if (standardEvents.includes(eventId)) {
          window.fbq('track', eventId, metadata);
        } else {
          window.fbq('trackCustom', eventId, metadata);
        }

        console.log('Facebook track:', { eventName, eventId, metadata });
      }
    },

    analytics: function (eventName, metadata) {
      const config = TRACKING_CONFIG.analytics.all;
      const gaEventName = config[eventName];

      if (window.gtag && gaEventName) {
        window.gtag('event', gaEventName, {
          event_category: metadata.category,
          event_label: metadata.label
        });
        console.log('Analytics track:', { eventName, gaEventName, metadata });
      }
    }
  };

  // Funzione principale di tracking
  function handleTracking(element, event) {
    const eventName = element.dataset.trackEvent;
    const platformsString = element.dataset.trackPlatforms;
    const platforms = platformsString ? platformsString.split(',') : [];
    let metadata = {};

    try {
      metadata = JSON.parse(element.dataset.trackMeta || '{}');
    } catch (e) {
      console.error('Invalid metadata JSON:', e);
    }

    platforms.forEach(function (platform) {
      if (trackingHandlers[platform]) {
        trackingHandlers[platform](eventName, metadata);
      }
    });

    if (element.tagName.toLowerCase() === 'a' && element.href) {
      event.preventDefault();
      setTimeout(function () {
        window.location.href = element.href;
      }, 100);
    }
  }

  // Inizializzazione del sistema
  function init() {
    // Gestione click su elementi con data-track
    document.addEventListener('click', function (event) {
      const trackElement = event.target.closest('[data-track]');
      if (trackElement) {
        handleTracking(trackElement, event);
      }
    });

    // Gestione submit dei form con data-track
    document.addEventListener('submit', function (event) {
      const trackElement = event.target.closest('[data-track]');
      if (trackElement) {
        handleTracking(trackElement, event);
      }
    });
  }

  // Debug helper
  function checkTrackingSetup() {
    const trackElements = document.querySelectorAll('[data-track]');
    const stats = Array.from(trackElements).map(function (el) {
      const platformsString = el.dataset.trackPlatforms;
      return {
        element: el.tagName.toLowerCase(),
        event: el.dataset.trackEvent,
        platforms: platformsString ? platformsString.split(',') : [],
        metadata: JSON.parse(el.dataset.trackMeta || '{}')
      };
    });

    console.log({
      documentLang: document.documentElement.lang,
      detectedLang: getCurrentLanguage(),
      trackingElements: stats,
      platformsAvailable: {
        linkedin: typeof window.lintrk === 'function',
        facebook: typeof window.fbq === 'function',
        analytics: typeof window.gtag === 'function'
      }
    });
  }

  // API pubblica
  return {
    init: init,
    track: handleTracking,
    debug: checkTrackingSetup
  };
})();

// Inizializzazione automatica quando il documento è pronto
if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', window.TrackingSystem.init);
} else {
  window.TrackingSystem.init();
}


// Funzione per copiare il valore di data-url-copy negli appunti
document.addEventListener('DOMContentLoaded', function () {
  // Seleziona tutti gli elementi con attributo data-url-copy
  const copyableElements = document.querySelectorAll('[data-url-copy]');

  // Aggiungi un event listener per il click a ciascun elemento
  copyableElements.forEach(element => {
    element.addEventListener('click', function (e) {
      // Ottieni il valore dell'attributo data-url-copy
      const urlToCopy = this.getAttribute('data-url-copy');

      if (urlToCopy) {
        // Copia negli appunti usando l'API Clipboard
        navigator.clipboard.writeText(urlToCopy)
          .then(() => {
            // Feedback di successo all'utente
            const originalText = this.textContent;
            this.textContent = 'URL copiato!';

            // Ripristina il testo originale dopo un breve ritardo
            setTimeout(() => {
              this.textContent = originalText;
            }, 2000);
          })
          .catch(err => {
            console.error('Errore durante la copia: ', err);
          });
      }
    });

    // Aggiungi stile cursore pointer per indicare che è cliccabile
    element.style.cursor = 'pointer';

    // Opzionale: aggiungi un titolo per indicare l'azione
    if (!element.getAttribute('title')) {
      element.setAttribute('title', 'Clicca per copiare l\'URL');
    }
  });
});
