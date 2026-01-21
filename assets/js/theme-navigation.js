/////////////////////////////////////////////
// THEME NAVIGATION
// Sistema unificato per la gestione dei menu
/////////////////////////////////////////////

/////////////////////////////////////////////
// GESTIONE DESKTOP/MOBILE - SELETTORI E ATTIVAZIONE
/////////////////////////////////////////////
//
// SELETTORI E ATTIVAZIONE:
//
// DESKTOP:
//   - Mega-menu trigger: .mega-menu-js-trigger
//     Classe attiva: 'clicked' (sul bottone)
//     Effetto: nasconde/mostra mega-menu con classe 'hidden'
//
//   - Sub-menu trigger: .header-menu-js > .menu-item-has-children > .sub-menu-btn
//     Classe attiva: 'clicked' (sul bottone)
//     Effetto: nasconde/mostra .sub-menu con classe 'visible'
//
//   - Pulsante chiusura: .submenu-close-js
//     Classe attiva: 'active' (quando menu aperto)
//
// MOBILE:
//   - Sub-menu trigger: .overlay-menu-mobile-js > .menu-item-has-children > .sub-menu-btn
//     Classe attiva: 'clicked' (sul bottone)
//     Effetto: nasconde/mostra .sub-menu con classe 'visible'
//     Comportamento: multi-open (nessuna interferenza tra i menu)
//
//   - Nota: i mega-menu non esistono su mobile
//
// CLASSI DI STATO:
//   'clicked'  → bottone/trigger aperto (+ aria-expanded="true")
//   'visible'  → contenitore menu visibile
//   'hidden'   → mega-menu nascosto (default)
//   'active'   → pulsante di chiusura attivo
//
// FLUSSO DI ESEMPIO (Desktop):
//   1. Click bottone "Categorie" (.header-menu-js > .menu-item-has-children > .sub-menu-btn)
//   2. Aggiungi 'clicked' → aria-expanded="true"
//   3. Aggiungi 'visible' al .sub-menu associato
//   4. Aggiungi 'active' al pulsante .submenu-close-js
//   5. User naviga (TAB/ESC) → closeAllMenus()
//   6. Rimuovi 'clicked', 'visible', 'active'
//
// FLUSSO DI ESEMPIO (Mobile - Multi-Open):
//   1. User apre hamburger → overlay .overlay-menu-mobile-js appare
//   2. Click bottone "Prodotti" → apri submenu 1 (clicked + visible)
//   3. Click bottone "Categorie" → apri submenu 2 (clicked + visible)
//   4. ENTRAMBI rimangono aperti (multi-open behavior)
//   5. Apertura hamburger NON chiude i submenu mobile aperti
//   6. User chiude → closeAllSubMenus() rimuove 'clicked' e 'visible'

/////////////////////////////////////////////
// Sistema Menu - Gestione Unificata
/////////////////////////////////////////////

// Funzioni di utilità
const MenuUtils = {
    // Imposta attributi di accessibilità e alterna classe
    setElementState: function (element, isOpen, stateClass = 'open') {
        if (!element) return;

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
        let navigationElementsHeight = 0;
        const navigationCounters = document.querySelectorAll('.navigation-height-counter');

        navigationCounters.forEach(element => {
            const rect = element.getBoundingClientRect();
            if (rect.bottom > 0) {
                const visibleHeight = rect.top < 0 ? rect.bottom : rect.height;
                navigationElementsHeight += visibleHeight;
            }
        });

        // Variabile dinamica (ricalcolata sempre)
        document.documentElement.style.setProperty('--header-height-real-time', `${navigationElementsHeight}px`);

        // Variabile statica (generata una sola volta)
        if (!window.navigationElementsHeightStatic) {
            window.navigationElementsHeightStatic = navigationElementsHeight;
            document.documentElement.style.setProperty('--header-height-static', `${navigationElementsHeight}px`);
        }

        // Applica top ai mega menu
        const megaMenus = document.querySelectorAll('.mega-menu-js');
        megaMenus.forEach(menu => {
            menu.style.top = navigationElementsHeight + 'px';
        });
    }
};


// Gestore Menu Principale
const MenuManager = {
    // Selettori costanti
    SELECTORS: {
        MEGA_TRIGGER: '.mega-menu-js-trigger',
        MEGA_MENU: '.mega-menu-js',
        SUBMENU_DESKTOP: '.sub-menu-btn[data-menu-type="desktop"]',
        SUBMENU_MOBILE: '.sub-menu-btn[data-menu-type="mobile"]',
        SUBMENU: '.sub-menu',
        CLOSE_BTN: '.submenu-close-js',
        MENU_TRIGGER_ALL: '[data-menu-type="desktop"].mega-menu-js-trigger, [data-menu-type="desktop"].sub-menu-btn, [data-menu-type="mobile"].sub-menu-btn, .simple-link'
    },

    // Memorizza i tasti premuti per scorciatoie da tastiera
    pressedKeys: new Set(),
    // Memorizza l'ultima posizione di scorrimento
    lastScrollTop: 0,

    // =========================================================================
    // 🔧 OTTIMIZZAZIONE #3: Cache dello stato granulare per context
    // =========================================================================
    // Discrimina tra desktop, mobile e hamburger per evitare interferenze
    menuStateCache: {
        hasOpenMegaMenu: false,
        hasOpenDesktopSubMenu: false,    // ✅ NUOVO: traccia solo submenu desktop
        hasOpenMobileSubMenu: false,     // ✅ NUOVO: traccia solo submenu mobile
        isHamburgerOpen: false           // ✅ NUOVO: traccia stato hamburger
    },

    // Inizializza tutte le funzionalità del menu
    init: function () {
        this.setupHamburgerMenu();
        this.setupMegaMenu();
        this.setupSubMenus(this.SELECTORS.SUBMENU_DESKTOP, false);  // Desktop
        this.setupSubMenus(this.SELECTORS.SUBMENU_MOBILE, true);    // Mobile
        this.setupKeyboardHandlers();
        this.setupMenuClosers();
        this.setupExpandButton();

        window.addEventListener('scroll', () => this.scrollDirectionMenu());
        window.addEventListener('resize', () => MenuUtils.updateNavigationHeights());

        MenuUtils.updateNavigationHeights();
        this.updateMenuStateCache();
    },

    // =========================================================================
    // 🔧 OTTIMIZZAZIONE #3: updateMenuStateCache() aggiornato
    // =========================================================================
    // Aggiorna la cache con discriminazione tra context
    updateMenuStateCache: function () {
        this.menuStateCache.hasOpenMegaMenu = !!document.querySelector(this.SELECTORS.MEGA_MENU + ':not(.hidden)');
        this.menuStateCache.hasOpenDesktopSubMenu = !!document.querySelector(this.SELECTORS.SUBMENU_DESKTOP + '.clicked');
        this.menuStateCache.hasOpenMobileSubMenu = !!document.querySelector(this.SELECTORS.SUBMENU_MOBILE + '.clicked');
        this.menuStateCache.isHamburgerOpen = !!document.querySelector('#hamburger-button.open');
    },

    // Ritorna vero se c'è un menu aperto (qualsiasi context)
    hasOpenMenus: function () {
        return this.menuStateCache.hasOpenMegaMenu ||
            this.menuStateCache.hasOpenDesktopSubMenu ||
            this.menuStateCache.hasOpenMobileSubMenu;
    },

    // =========================================================================
    // 🔧 OTTIMIZZAZIONE #4: closeOthers() con parametro forceClose
    // =========================================================================
    // Permette di controllare quando chiudere altri elementi
    closeOthers: function (selector, currentElement, targetSelector = null, forceClose = true) {
        // Se forceClose è false, non eseguire la chiusura
        if (!forceClose) return;

        document.querySelectorAll(selector).forEach(element => {
            if (element !== currentElement && element.classList.contains('clicked')) {
                MenuUtils.setElementState(element, false, 'clicked');

                // Gestisce l'elemento target associato (menu, submenu, ecc.)
                if (targetSelector) {
                    const target = element.parentElement.querySelector(targetSelector) ||
                        document.querySelector(`.mega-menu-js-${element.dataset.megamenuOpenId}-target`);
                    if (target) {
                        target.classList.remove('visible');
                        target.classList.add('hidden');
                    }
                }
            }
        });
    },

    // =========================================================================
    // 🔧 OTTIMIZZAZIONE #2: toggleHamburgerMenu() modificato
    // =========================================================================
    // NON chiude i submenu mobile quando si apre/chiude l'hamburger
    toggleHamburgerMenu: function (forceClose = false) {
        const hamActivator = document.querySelector('#hamburger-button');
        const headOverlay = document.getElementById('head-overlay');
        const scrollOpportunityOverlay = document.querySelector('.scroll-opportunity-overlay-js');

        let isOpen = hamActivator.classList.contains('open');
        if (forceClose) isOpen = true;

        MenuUtils.setElementState(hamActivator, !isOpen, 'open');
        headOverlay.classList.toggle('hidden', isOpen);

        // Toggle classe fixed su header e no-scroll su body
        const header = document.getElementById('header');
        const body = document.querySelector('body');

        if (!isOpen) {
            // Hamburger si apre
            if (header) header.classList.add('fixed');
            if (body) body.classList.add('no-scroll');
        } else {
            // Hamburger si chiude
            if (header) header.classList.remove('fixed');
            if (body) body.classList.remove('no-scroll');
        }

        // Resetta la posizione di scorrimento
        if (!isOpen && scrollOpportunityOverlay) {
            scrollOpportunityOverlay.scrollTop = 0;
        }

        // ✅ OTTIMIZZAZIONE: Chiude SOLO i menu desktop, NON i submenu mobile
        if (!isOpen) {
            this.closeAllDesktopMenus();
        } else {
            this.updateHeaderBackground();
        }

        this.updateMenuStateCache();
        return !isOpen;
    },

    // Alias più chiaro per chiudere l'hamburger
    closeHamburgerMenu: function () {
        return this.toggleHamburgerMenu(true);
    },

    // Chiude tutti i menu (megamenu, sub-menu desktop E mobile, etc.)
    closeAllMenus: function () {
        // Chiude mega-menu
        document.querySelectorAll(this.SELECTORS.MEGA_MENU).forEach(menu => {
            menu.classList.add('hidden');
        });
        document.querySelectorAll(this.SELECTORS.MEGA_TRIGGER).forEach(trigger => {
            MenuUtils.setElementState(trigger, false, 'clicked');
        });

        // Chiude sub-menu desktop
        document.querySelectorAll(this.SELECTORS.SUBMENU_DESKTOP).forEach(btn => {
            MenuUtils.setElementState(btn, false, 'clicked');
        });

        // Chiude sub-menu mobile
        document.querySelectorAll(this.SELECTORS.SUBMENU_MOBILE).forEach(btn => {
            MenuUtils.setElementState(btn, false, 'clicked');
        });

        document.querySelectorAll(this.SELECTORS.SUBMENU).forEach(menu => {
            menu.classList.remove('visible');
        });

        // Disattiva pulsanti di chiusura
        document.querySelectorAll(this.SELECTORS.CLOSE_BTN).forEach(close => {
            close.classList.remove('active');
        });

        this.updateMenuStateCache();
        this.updateHeaderBackground();
    },

    // Alias per compatibilità con codice esistente
    closeAllSubMenus: function () {
        this.closeAllMenus();
    },

    // =========================================================================
    // ✅ NUOVA FUNZIONE: Chiude SOLO i menu desktop (mega + sub-menu standard)
    // =========================================================================
    // Utile per chiudere i menu desktop senza toccare i submenu mobile
    closeAllDesktopMenus: function () {
        this.closeAllMegaMenus();
        this.closeAllStandardSubMenus();
    },

    // Chiude tutti i mega menu
    closeAllMegaMenus: function () {
        document.querySelectorAll(this.SELECTORS.MEGA_MENU).forEach(menu => {
            menu.classList.add('hidden');
        });

        document.querySelectorAll(this.SELECTORS.MEGA_TRIGGER).forEach(trigger => {
            MenuUtils.setElementState(trigger, false, 'clicked');
        });

        this.updateMenuStateCache();
    },

    // Chiude tutti i sub-menu standard (SOLO desktop, non mobile)
    closeAllStandardSubMenus: function () {
        document.querySelectorAll(this.SELECTORS.SUBMENU_DESKTOP).forEach(btn => {
            MenuUtils.setElementState(btn, false, 'clicked');
        });

        // Chiudi SOLO i submenu desktop, NON i submenu mobile
        document.querySelectorAll('.sub-menu[data-menu-type="desktop"]').forEach(menu => {
            menu.classList.remove('visible');
        });

        this.updateMenuStateCache();
    },

    // Configura gli eventi del menu hamburger
    setupHamburgerMenu: function () {
        const hamburgerButton = document.getElementById('hamburger-button');
        if (hamburgerButton) {
            hamburgerButton.addEventListener('click', () => this.toggleHamburgerMenu());
        }

        const overlayNaviReset = document.querySelector('.overlay-navi-reset-js');
        if (overlayNaviReset) {
            overlayNaviReset.addEventListener('focusin', (e) => {
                const hamburgerButton = document.querySelector('#hamburger-button');
                if (hamburgerButton) hamburgerButton.focus();
                e.preventDefault();
            });
        }
    },

    // Configura il mega menu
    setupMegaMenu: function () {
        document.addEventListener('click', (e) => {
            const trigger = e.target.closest(this.SELECTORS.MEGA_TRIGGER);
            if (!trigger) return;

            const megamenuId = trigger.dataset.megamenuOpenId;
            const megaMenu = document.querySelector(`.mega-menu-js-${megamenuId}-target`);
            const isOpen = trigger.classList.contains('clicked');

            // Chiude sub-menu e altri mega menu
            if (!isOpen) {
                this.closeAllStandardSubMenus();
            }
            this.closeOthers(this.SELECTORS.MEGA_TRIGGER, trigger, null);

            // Alterna questo menu
            MenuUtils.setElementState(trigger, !isOpen, 'clicked');
            if (megaMenu) {
                megaMenu.classList.toggle('hidden', isOpen);
            }

            // Gestisce pulsante di chiusura
            const closeButton = document.querySelector(this.SELECTORS.CLOSE_BTN);
            if (closeButton) {
                closeButton.classList.toggle('active', !isOpen);
            }

            this.updateHeaderBackground();
            this.closeHamburgerMenu();
            MenuUtils.updateNavigationHeights();
            this.updateMenuStateCache();
        });
    },

    // =========================================================================
    // 🔧 OTTIMIZZAZIONE #1: setupSubMenus() con multi-open mobile
    // =========================================================================
    // Per desktop: accordion behavior (chiude gli altri)
    // Per mobile: multi-open behavior (lascia aperti gli altri)
    setupSubMenus: function (selector, isMobile = false) {
        document.addEventListener('click', (e) => {
            const btn = e.target.closest(selector);
            if (!btn) return;

            const isOpen = btn.classList.contains('clicked');
            const subMenu = btn.parentElement.querySelector(this.SELECTORS.SUBMENU);

            // Chiude mega menu e altri sub-menu
            if (!isOpen && !isMobile) {
                this.closeAllMegaMenus();
            }

            // ✅ OTTIMIZZAZIONE: Chiude gli altri SOLO se desktop (isMobile = false)
            // Per mobile, non chiude gli altri (permette multi-open)
            this.closeOthers(selector, btn, this.SELECTORS.SUBMENU, !isMobile);

            // Alterna questo sub-menu
            MenuUtils.setElementState(btn, !isOpen, 'clicked');
            if (subMenu) {
                subMenu.classList.toggle('visible', !isOpen);
            }

            // Gestisce pulsante di chiusura (solo desktop)
            if (!isMobile) {
                document.querySelectorAll(this.SELECTORS.CLOSE_BTN).forEach(closeBtn => {
                    closeBtn.classList.toggle('active', !isOpen);
                });
                this.closeHamburgerMenu();
            }

            this.updateHeaderBackground();
            this.updateMenuStateCache();
        });
    },

    // Verifica se il focus è dentro un menu aperto
    isFocusInsideOpenMenu: function (element) {
        // Se nessun menu è aperto, il focus non può essere dentro
        if (!this.hasOpenMenus()) {
            return false;
        }

        // Cerca il primo padre che sia un mega-menu o sub-menu
        let current = element;
        while (current) {
            if (current.matches(this.SELECTORS.MEGA_MENU + '.visible, ' + this.SELECTORS.MEGA_MENU + ':not(.hidden)') ||
                current.matches(this.SELECTORS.SUBMENU + '.visible')) {
                return true;
            }
            current = current.parentElement;
        }

        return false;
    },

    // Verifica se l'elemento è un trigger/bottone del menu principale
    isMenuTrigger: function (element) {
        return !!element.closest(this.SELECTORS.MENU_TRIGGER_ALL);
    },

    // Configura i gestori da tastiera per la navigazione del menu
    setupKeyboardHandlers: function () {
        document.addEventListener('keydown', (e) => {
            this.pressedKeys.add(e.key);

            // Combinazione P + ESC per chiudere il menu hamburger
            if (this.pressedKeys.has('p') && this.pressedKeys.has('Escape')) {
                const hamburgerButton = document.querySelector('.ham-activator-js');
                if (hamburgerButton) hamburgerButton.focus();
                this.closeHamburgerMenu();
            }

            // ESC per chiudere i megamenu
            if (e.key === 'Escape') {
                const openModals = document.querySelectorAll('.paperplane-modal:not(.hidden)');
                if (openModals.length === 0) {
                    this.closeAllSubMenus();
                }
            }
        });

        document.addEventListener('keyup', (e) => {
            this.pressedKeys.delete(e.key);
        });

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
        document.addEventListener('click', (e) => {
            if (e.target.matches(this.SELECTORS.CLOSE_BTN)) {
                this.closeAllSubMenus();
            }
        });

        // Listener globale su focusin per gestire chiusura menu
        document.addEventListener('focusin', (e) => {
            // Se nessun menu è aperto, non fare nulla
            if (!this.hasOpenMenus()) {
                return;
            }

            const focusedElement = e.target;

            // Se il focus entra su un trigger del menu principale → Chiudi menu (solo desktop)
            if (this.isMenuTrigger(focusedElement)) {
                // Controlla se è un bottone MOBILE usando data-menu-type
                const isMobileButton = focusedElement.getAttribute('data-menu-type') === 'mobile';

                // Chiudi i menu SOLO se NON è un bottone mobile
                if (!isMobileButton) {
                    this.closeAllSubMenus();
                }
                // Se è mobile, non fare nulla (mantieni multi-open)
                return;
            }

            // Se il focus è dentro un menu aperto → Mantieni aperto (non fare nulla)
            if (this.isFocusInsideOpenMenu(focusedElement)) {
                return;
            }

            // Se il focus è fuori dai menu → Chiudi SOLO menu desktop (mantieni mobile)
            this.closeAllDesktopMenus();
        }, true);
    },

    // Configura il bottone expand dell'avviso header
    setupExpandButton: function () {
        // Usa event delegation per gestire il bottone ovunque venga caricato
        document.addEventListener('click', (e) => {
            if (e.target.closest('#expand-button-header-notice')) {
                const container = document.querySelector('.avviso-container');

                if (container) {
                    container.addEventListener('transitionend', () => {
                        MenuUtils.updateNavigationHeights();
                    });
                }
            }
        });
    },

    // Gestisce l'effetto di scorrimento del menu
    scrollDirectionMenu: function () {
        var st = window.scrollY;
        this.updateHeaderBackground(st);
        this.lastScrollTop = st;
        MenuUtils.updateNavigationHeights();
    },

    // Aggiorna lo sfondo dell'header
    updateHeaderBackground: function (scrollTop) {
        const header = document.getElementById('header');
        if (!header) return;

        const st = scrollTop !== undefined ? scrollTop : window.scrollY;

        const hasOpenMenus = document.querySelector('.mega-menu-js-trigger.clicked') ||
            document.querySelector('.header-menu-js > .menu-item-has-children > .sub-menu-btn.clicked') ||
            document.querySelector('#hamburger-button.open');

        if (st > 200 || hasOpenMenus) {
            header.classList.add('backgrounded');
        } else {
            header.classList.remove('backgrounded');
        }
    }
};

// Inizializzazione del Gestore Menu
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
// HEADER NOTICE
// Sistema di Gestione Avvisi Dinamici
/////////////////////////////////////////////

/**
 * ============================================================================
 * HEADER NOTICE - Sistema di Gestione Avvisi Dinamici
 * ============================================================================
 * 
 * Gestisce la conversione dinamica dell'avviso header in expanding block 
 * se il testo occupa più di una riga.
 * 
 * Modalità supportate:
 * - static-text: Testo statico con espansione automatica se > 1 riga
 * - scroll-text: Testo che scorre orizzontalmente
 * 
 * Feature:
 * - Responsive e adattabile al resize
 * - Compatibile con prefers-reduced-motion
 * - Gestione cookie per dismissione permanente
 * - Classe .initialized aggiunta al completamento
 * 
 * ============================================================================
 */

(function () {
    'use strict';

    // =========================================================================
    // COSTANTI CONFIGURABILI
    // =========================================================================

    const SELETTORE_CONTAINER = '.avviso-container';
    const SELETTORE_CONTENT = '.avviso-content';
    const DEBOUNCE_DELAY = 250;

    // Costanti per calcolo velocità animazione scroll
    const VELOCITA_PX_SEC = 100;  // pixel al secondo
    const DURATA_MIN = 8;         // secondi minimo
    const DURATA_MAX = 60;        // secondi massimo

    // =========================================================================
    // FUNZIONE: Calcola durata animazione scroll
    // =========================================================================

    /**
     * Calcola e applica la durata dell'animazione scroll in base alla 
     * lunghezza del testo
     * 
     * @param {HTMLElement} container - Elemento contenitore
     */
    function calcolaDurataScroll(container) {
        const content = container.querySelector(SELETTORE_CONTENT);
        if (!content) return;

        requestAnimationFrame(() => {
            const larghezzaTesto = content.scrollWidth;
            const durata = larghezzaTesto / VELOCITA_PX_SEC;
            const durataFinale = Math.max(DURATA_MIN, Math.min(durata, DURATA_MAX));

            content.style.animationDuration = durataFinale + 's';
        });
    }

    // =========================================================================
    // FUNZIONE: Calcola numero di righe
    // =========================================================================

    /**
     * Calcola il numero di righe occupate da un elemento basandosi 
     * su altezza e line-height
     * 
     * @param {HTMLElement} elemento - Elemento da misurare
     * @returns {number} Numero di righe
     */
    function calcolaNumeroRighe(elemento) {
        const styles = window.getComputedStyle(elemento);
        let lineHeight = parseFloat(styles.lineHeight);

        // Se line-height è 'normal', calcola da fontSize
        if (isNaN(lineHeight) || styles.lineHeight === 'normal') {
            const fontSize = parseFloat(styles.fontSize);
            lineHeight = fontSize * 1.2;
        }

        const altezza = elemento.offsetHeight;

        if (lineHeight === 0 || altezza === 0) {
            return 1;
        }

        return Math.round(altezza / lineHeight);
    }

    // =========================================================================
    // FUNZIONE: Inizializza event listener per expanding block
    // =========================================================================

    /**
     * Inizializza gli event listener (hover e click) per un button 
     * di expanding block
     * 
     * @param {HTMLElement} button - Elemento button
     */
    function inizializzaExpandingBlock(button) {
        // Hover events
        button.addEventListener('mouseenter', () => {
            const expandingBlock = button.closest('.expanding-block');
            if (expandingBlock) {
                expandingBlock.classList.add('hovered');
            }
        });

        button.addEventListener('mouseleave', () => {
            const expandingBlock = button.closest('.expanding-block');
            if (expandingBlock) {
                expandingBlock.classList.remove('hovered');
            }
        });

        // Click event - Toggle apertura/chiusura
        button.addEventListener('click', (event) => {
            event.preventDefault();

            const expandId = button.dataset.expandId;
            const expandButton = document.getElementById(`expand-button-${expandId}`);
            const expandContent = document.getElementById(`expand-content-${expandId}`);

            if (expandButton.classList.contains('exp-open')) {
                // APRI
                expandButton.classList.remove('exp-open');
                expandButton.classList.add('exp-close');
                expandButton.setAttribute('aria-expanded', 'true');
                expandContent.classList.add('visible');
            } else {
                // CHIUDI
                expandButton.classList.remove('exp-close');
                expandButton.classList.add('exp-open');
                expandButton.setAttribute('aria-expanded', 'false');
                expandContent.classList.remove('visible');
            }
        });
    }

    // =========================================================================
    // FUNZIONE: Converti in expanding block
    // =========================================================================

    /**
     * Converte il contenuto semplice in una struttura expanding block
     * (button + content collassabile)
     * 
     * @param {HTMLElement} container - Contenitore principale
     * @param {HTMLElement} content - Elemento con il contenuto
     * @param {string} testoSummary - Testo per il button
     */
    function convertiInExpandingBlock(container, content, testoSummary) {
        const contenutoOriginale = content.innerHTML;

        // Crea la struttura expanding block
        const expandingBlock = document.createElement('div');
        expandingBlock.className = 'expanding-block';

        // === Crea il button expander ===
        const button = document.createElement('button');
        button.type = 'button';
        button.id = 'expand-button-header-notice';
        button.className = 'expander exp-open';
        button.setAttribute('aria-expanded', 'false');
        button.setAttribute('data-expand-id', 'header-notice');
        button.setAttribute('aria-controls', 'expand-content-header-notice');

        const span = document.createElement('span');
        span.textContent = testoSummary;
        button.appendChild(span);

        // === Crea il contenuto espandibile ===
        const expandableContent = document.createElement('div');
        expandableContent.role = 'region';
        expandableContent.id = 'expand-content-header-notice';
        expandableContent.setAttribute('aria-labelledby', 'expand-button-header-notice');
        expandableContent.className = 'expandable-content';

        const inner = document.createElement('div');
        inner.className = 'inner';

        const contentStyled = document.createElement('div');
        contentStyled.className = 'content-styled last-child-no-margin';

        const anchor = document.createElement('a');
        anchor.name = 'expandable-content-header-notice';
        anchor.className = 'section-anchor';

        contentStyled.appendChild(anchor);
        contentStyled.innerHTML += contenutoOriginale;

        inner.appendChild(contentStyled);
        expandableContent.appendChild(inner);

        // Assembla expanding block
        expandingBlock.appendChild(button);
        expandingBlock.appendChild(expandableContent);

        // Salva il bottone close se esiste
        const closeButton = container.querySelector('.close-header-notice');

        // Sostituisci il contenuto
        container.innerHTML = '';
        container.appendChild(expandingBlock);

        // Riaggiunge il bottone close
        if (closeButton) {
            container.appendChild(closeButton);
        }

        container.dataset.converted = 'true';

        // Inizializza event listener
        inizializzaExpandingBlock(button);
    }

    // =========================================================================
    // FUNZIONE: Ripristina contenuto normale
    // =========================================================================

    /**
     * Ripristina il contenuto originale (non espanso)
     * 
     * @param {HTMLElement} container - Contenitore
     * @param {string} contenutoOriginale - HTML originale
     */
    function ripristinaContenutoNormale(container, contenutoOriginale) {
        container.innerHTML = contenutoOriginale;
        container.dataset.converted = 'false';
    }

    // =========================================================================
    // FUNZIONE: Valuta stato avviso
    // =========================================================================

    /**
     * Valuta se il contenuto occupa più righe e lo converte 
     * in expanding block se necessario
     * 
     * @param {HTMLElement} container - Contenitore
     * @param {string} contenutoOriginale - HTML originale
     */
    function valutaAvviso(container, contenutoOriginale) {
        const testoSummary = container.dataset.summaryText || 'Leggi messaggio';
        const eraConvertito = container.dataset.converted === 'true';

        // Ripristina prima di misurare
        if (eraConvertito) {
            ripristinaContenutoNormale(container, contenutoOriginale);
        }

        // Forza reflow
        container.offsetHeight;

        const content = container.querySelector(SELETTORE_CONTENT);
        if (!content) return;

        const numeroRighe = calcolaNumeroRighe(content);

        // Se più di 1 riga, converti
        if (numeroRighe > 1) {
            convertiInExpandingBlock(container, content, testoSummary);
        }
    }

    // =========================================================================
    // FUNZIONE: Gestisci click bottone close
    // =========================================================================

    /**
     * Gestisce il click sul bottone close per nascondere permanentemente 
     * l'avviso tramite cookie
     */
    function gestisciClose() {
        const closeButton = document.querySelector('.close-header-notice-js');
        if (!closeButton) return;

        closeButton.addEventListener('click', function () {
            const container = this.closest('.avviso-container');
            if (!container) return;

            const noticeId = container.getAttribute('data-notice-id');
            if (!noticeId) return;

            const cookieName = 'header_notice_dismissed_' + noticeId;

            // Salva cookie per 365 giorni
            const expires = new Date();
            expires.setTime(expires.getTime() + (365 * 24 * 60 * 60 * 1000));
            document.cookie = cookieName + '=1; expires=' + expires.toUTCString() + '; path=/; SameSite=Lax';

            // Nascondi l'intero pre-header
            const preHeader = document.getElementById('pre-header');
            if (preHeader) {
                preHeader.style.display = 'none';
            }
        });
    }

    // =========================================================================
    // UTILITY: Debounce function (locale per IIFE)
    // =========================================================================

    /**
     * Debounce function per limitare la frequenza di esecuzione
     * 
     * @param {Function} func - Funzione da eseguire
     * @param {number} wait - Millisecondi di delay
     * @returns {Function} Funzione debounced
     */
    function debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    }

    // =========================================================================
    // FUNZIONE: Segna come inizializzato
    // =========================================================================

    /**
     * Aggiunge la classe .initialized al #pre-header quando tutte 
     * le operazioni sono completate
     */
    function markAsInitialized() {
        const preHeader = document.getElementById('pre-header');
        if (preHeader) {
            requestAnimationFrame(() => {
                preHeader.classList.add('initialized');
            });
        }
    }

    // =========================================================================
    // FUNZIONE: Inizializzazione principale
    // =========================================================================

    /**
     * Inizializza la gestione dell'avviso in base alla modalità configurata
     * - static-text: Testo statico con espansione
     * - scroll-text: Testo che scorre
     */
    function init() {
        const container = document.querySelector(SELETTORE_CONTAINER);
        if (!container) return;

        // Controlla se reduced motion è attivo
        const reducedMotion = document.documentElement.getAttribute('data-reduced-motion') === 'true';

        // Ottieni la modalità di visualizzazione
        let viewMode = container.getAttribute('data-view-mode') || 'static-text';

        // Se reduced motion è attivo, forza static-text
        if (reducedMotion && viewMode === 'scroll-text') {
            viewMode = 'static-text';

            container.classList.remove('avviso-scroll');

            const content = container.querySelector(SELETTORE_CONTENT);
            if (content) {
                content.style.animationDuration = '';
                content.style.animation = 'none';
            }
        }

        // =====================================================================
        // MODALITÀ SCROLL-TEXT
        // =====================================================================
        if (viewMode === 'scroll-text') {
            calcolaDurataScroll(container);

            const handleResizeScroll = debounce(() => {
                calcolaDurataScroll(container);
            }, DEBOUNCE_DELAY);

            window.addEventListener('resize', handleResizeScroll);

            gestisciClose();

            // Segna come inizializzato
            markAsInitialized();
            return;
        }

        // =====================================================================
        // MODALITÀ STATIC-TEXT
        // =====================================================================
        const content = container.querySelector(SELETTORE_CONTENT);
        if (!content) return;

        const contenutoOriginale = container.innerHTML;

        requestAnimationFrame(() => {
            valutaAvviso(container, contenutoOriginale);

            requestAnimationFrame(() => {
                container.classList.add('visible');

                // Segna come inizializzato DOPO la visibilità
                markAsInitialized();
            });
        });

        // Gestisci il resize
        const handleResize = debounce(() => {
            valutaAvviso(container, contenutoOriginale);
        }, DEBOUNCE_DELAY);

        window.addEventListener('resize', handleResize);

        gestisciClose();
    }

    // =========================================================================
    // AVVIO DELLO SCRIPT
    // =========================================================================

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();