/////////////////////////////////////////////
// THEME UTILITIES
// Funzionalità generali e componenti UI
/////////////////////////////////////////////

/////////////////////////////////////////////
// AOS - Animate On Scroll
/////////////////////////////////////////////

AOS.init({
    duration: 900,
    once: true,
    mirror: false
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
        if (typeof MenuManager !== 'undefined') {
            MenuManager.toggleHamburgerMenu(true);
        }
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

// Usa le stringhe tradotte passate da WordPress tramite wp_localize_script
var nextSlideLabel = (typeof themeStrings !== 'undefined' && themeStrings.nextSlide) ? themeStrings.nextSlide : 'Next slide';
var prevSlideLabel = (typeof themeStrings !== 'undefined' && themeStrings.prevSlide) ? themeStrings.prevSlide : 'Previous slide';

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
        dots: false,
        variableWidth: true,
        nextArrow: '<button type="button" class="slick-next element-icon-after"><span class="screen-reader-text">' + nextSlideLabel + '</span></button>',
        prevArrow: '<button type="button" class="slick-prev element-icon-after"><span class="screen-reader-text">' + prevSlideLabel + '</span></button>',
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
        // Leggi la durata dell'animazione da ThemeConfig (se disponibile) o usa default
        const animDuration = (window.ThemeConfig && window.ThemeConfig.animation && typeof window.ThemeConfig.animation.durationCounter !== 'undefined')
            ? window.ThemeConfig.animation.durationCounter
            : 1500;

        if (animDuration > 0) {
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
                const dataNumber = parseInt(el.getAttribute('data-bar-number'), 10);
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
        const expandingBlock = expander.closest('.expanding-block');
        if (expandingBlock) {
            expandingBlock.classList.add('hovered');
        }
    });

    expander.addEventListener('mouseleave', () => {
        const expandingBlock = expander.closest('.expanding-block');
        if (expandingBlock) {
            expandingBlock.classList.remove('hovered');
        }
    });
});

// Gestione del click sul bottone principale
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
        if (expandButton.classList.contains('exp-open')) {
            // Se il pulsante è CHIUSO (exp-open), APRI il contenuto
            expandButton.classList.remove('exp-open');
            expandButton.classList.add('exp-close');
            expandButton.setAttribute('aria-expanded', 'true');
            expandContent.classList.add('visible');
            expandCloseButton.setAttribute('aria-expanded', 'true');
            expandCloseButton.removeAttribute('tabindex');
            expandCloseButton.removeAttribute('aria-hidden');
        } else {
            // Se il pulsante è APERTO (exp-close), CHIUDI il contenuto
            expandButton.classList.remove('exp-close');
            expandButton.classList.add('exp-open');
            expandButton.setAttribute('aria-expanded', 'false');
            expandContent.classList.remove('visible');
            expandCloseButton.setAttribute('aria-expanded', 'false');
            expandCloseButton.setAttribute('tabindex', '-1');
            expandCloseButton.setAttribute('aria-hidden', 'true');
        }
    });
});

// Gestione del click sul bottone di chiusura
const expandersClose = document.querySelectorAll('.expander-closer');

expandersClose.forEach(expander => {
    expander.addEventListener('click', (event) => {
        event.preventDefault();

        const expandId = expander.dataset.expandId;

        const elementsToToggle = {
            button: document.getElementById(`expand-button-${expandId}`),
            content: document.getElementById(`expand-content-${expandId}`),
            closeButton: document.getElementById(`expand-close-button-${expandId}`)
        };

        // Chiudi sempre il contenuto
        elementsToToggle.content.classList.remove('visible');
        elementsToToggle.button.classList.remove('exp-close');
        elementsToToggle.button.classList.add('exp-open');
        elementsToToggle.button.setAttribute('aria-expanded', 'false');
        elementsToToggle.closeButton.setAttribute('aria-expanded', 'false');
        elementsToToggle.closeButton.setAttribute('tabindex', '-1');
        elementsToToggle.closeButton.setAttribute('aria-hidden', 'true');
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

document.querySelectorAll('.remove-underline-js, .remove-underline-js a').forEach(function (element) {
    element.addEventListener('mouseenter', function () {
        this.parentElement.parentElement.classList.add('no-underline');
    });

    element.addEventListener('mouseleave', function () {
        this.parentElement.parentElement.classList.remove('no-underline');
    });
});



// Funzione per copiare il valore di data-url-copy o data-copy-text negli appunti
document.addEventListener('DOMContentLoaded', function () {
    // Seleziona tutti gli elementi con attributo data-url-copy O data-copy-text
    const copyableElements = document.querySelectorAll('[data-url-copy], [data-copy-text]');

    // Aggiungi un event listener per il click a ciascun elemento
    copyableElements.forEach(element => {
        // Salva il testo originale escludendo la span screen-reader-text
        const screenReaderSpan = element.querySelector('.screen-reader-text');
        let originalText = element.textContent.trim();

        if (screenReaderSpan) {
            originalText = originalText.replace(screenReaderSpan.textContent, '').trim();
        }

        // Flag per evitare click multipli durante il feedback
        element.isCopying = false;
        element.originalText = originalText;

        element.addEventListener('click', function (e) {
            // Se è già in stato di copia, ignora il click
            if (this.isCopying) {
                return;
            }

            // Ottieni il valore dall'attributo data-url-copy o data-copy-text (priorità a data-url-copy per backward compatibility)
            const textToCopy = this.getAttribute('data-url-copy') || this.getAttribute('data-copy-text');

            if (textToCopy) {
                // Copia negli appunti usando l'API Clipboard
                navigator.clipboard.writeText(textToCopy)
                    .then(() => {
                        // Imposta il flag per bloccare altri click
                        this.isCopying = true;

                        // Usa la stringa tradotta da WordPress per il messaggio
                        const copiedText = (typeof themeStrings !== 'undefined' && themeStrings.urlCopied) ? themeStrings.urlCopied : ' - copiato';

                        // Aggiungi " copied!" al testo originale salvato
                        this.textContent = this.originalText + ' ' + copiedText;

                        // Dopo 4 secondi, ripristina il testo originale e sblocca i click
                        setTimeout(() => {
                            // Ripristina il testo originale salvato
                            this.textContent = this.originalText;
                            // Sblocca i click
                            this.isCopying = false;
                        }, 4000);
                    })
                    .catch(err => {
                        console.error('Errore durante la copia: ', err);
                    });
            }
        });

        // Opzionale: aggiungi un titolo per indicare l'azione
        if (!element.getAttribute('title')) {
            // Usa la stringa tradotta da WordPress
            const clickToCopyText = (typeof themeStrings !== 'undefined' && themeStrings.clickToCopy) ? themeStrings.clickToCopy : 'Click to copy';
            element.setAttribute('title', clickToCopyText);
        }
    });
});

/////////////////////////////////////////////
// Window ready / scroll / resize events
/////////////////////////////////////////////
document.addEventListener('scroll', { passive: true });
document.addEventListener('scroll', (event) => {
    numbersCounter();

});

document.addEventListener('DOMContentLoaded', () => {
    numbersCounter();
});



























/////////////////////////////////////////////
// Scroll text module dynamic speed calculation
/////////////////////////////////////////////
/**
 * Gestisce il calcolo dinamico della velocità di animazione
 * per i moduli scroll-text
 */
(function () {
    'use strict';

    const SELETTORE_MODULES = '.horizontal-scrolling-items';
    const SELETTORE_TEXT_ITEM = '.txt-item';
    const DEBOUNCE_DELAY = 250;

    // Costanti per calcolo velocità scroll
    const VELOCITA_PX_SEC = 100;  // pixel al secondo
    const DURATA_MIN = 8;         // secondi minimo
    const DURATA_MAX = 60;        // secondi massimo

    /**
     * Calcola e applica la durata dell'animazione scroll per un singolo modulo
     */
    function calcolaDurataScrollModulo(module) {
        const item = module.querySelector('.horizontal-scrolling-items-item');
        if (!item) return;

        // Aspetta che il contenuto sia renderizzato
        requestAnimationFrame(() => {
            // Misura la larghezza TOTALE del container (tutti gli elementi duplicati)
            const larghezzaTotale = module.scrollWidth;

            // L'animazione va da 0 a -50%, quindi percorre metà della larghezza totale
            const distanzaEffettiva = larghezzaTotale / 2;

            // Calcola la durata: distanza / velocità
            const durata = distanzaEffettiva / VELOCITA_PX_SEC;

            // Limita la durata tra min e max
            const durataFinale = Math.max(DURATA_MIN, Math.min(durata, DURATA_MAX));

            // Debug
            /*
            console.log({
                modulo: module.id || 'module-scroll-text',
                larghezzaTotale: larghezzaTotale,
                distanzaEffettiva: distanzaEffettiva,
                durata_calcolata: durata,
                durataFinale: durataFinale,
                velocita: VELOCITA_PX_SEC
            });
*/
            // Applica la durata all'animazione
            module.style.animationDuration = durataFinale + 's';
        });
    }

    /**
     * Duplica il contenuto per creare loop infinito senza stacchi
     * Aggiunge aria-hidden="true" solo ai cloni
     */
    function duplicaContenuto(module) {
        const item = module.querySelector('.horizontal-scrolling-items-item');
        if (!item) return;

        // Verifica se già duplicato
        if (module.dataset.duplicated === 'true') return;

        // Calcola quante copie servono per riempire almeno 3x il viewport
        const viewportWidth = window.innerWidth;
        const itemWidth = item.offsetWidth;
        const copiesNeeded = Math.max(1, Math.ceil((viewportWidth * 3) / itemWidth));
        /*
                console.log({
                    modulo: module.id || 'module-scroll-text',
                    viewportWidth: viewportWidth,
                    itemWidth: itemWidth,
                    copiesNeeded: copiesNeeded
                });
        */
        // Duplica N volte
        for (let i = 0; i < copiesNeeded; i++) {
            const clone = item.cloneNode(true);

            // Aggiungi aria-hidden="true" a tutti gli elementi con classe txt-item nel clone
            const txtItems = clone.querySelectorAll('.txt-item');
            txtItems.forEach(txtItem => {
                txtItem.setAttribute('aria-hidden', 'true');
            });

            module.appendChild(clone);
        }

        // Marca come duplicato
        module.dataset.duplicated = 'true';
    }

    /**
     * Gestisce un singolo modulo scroll-text
     */
    function inizializzaModulo(module) {
        // Duplica il contenuto per loop infinito
        duplicaContenuto(module);

        // Calcola e applica la durata dell'animazione
        calcolaDurataScrollModulo(module);
    }

    /**
     * Debounce function
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

    /**
     * Inizializza tutti i moduli scroll-text
     */
    function initModuleScrollText() {
        const modules = document.querySelectorAll(SELETTORE_MODULES);

        if (modules.length === 0) return;

        //console.log(`Trovati ${modules.length} moduli scroll-text da inizializzare`);

        // Inizializza ogni modulo
        modules.forEach(module => {
            inizializzaModulo(module);
        });

        // Gestisci il resize per ricalcolare le durate
        const handleResize = debounce(() => {
            //console.log('Resize rilevato: ricalcolo durate animazioni');
            modules.forEach(module => {
                calcolaDurataScrollModulo(module);
            });
        }, DEBOUNCE_DELAY);

        window.addEventListener('resize', handleResize);
    }

    // Avvia quando il DOM è pronto
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initModuleScrollText);
    } else {
        initModuleScrollText();
    }
})();