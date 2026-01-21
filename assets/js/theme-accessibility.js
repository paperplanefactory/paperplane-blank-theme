/////////////////////////////////////////////
// THEME ACCESSIBILITY - VERSIONE OTTIMIZZATA
// Gestione delle funzionalità di accessibilità
// NOTA: Gli attributi critici (data-theme, data-reduced-motion, data-reduced-transparency)
// sono impostati dal PHP nel HEAD. Questo script aggiunge l'interattività e le system preferences.
/////////////////////////////////////////////

/////////////////////////////////////////////
// Configurazione Accessibilità
// Definisci se il sito deve rispettare le preferenze di accessibilità dell'OS
/////////////////////////////////////////////
const ACCESSIBILITY_CONFIG = {
    autoApplySystemPreferences: {
        reducedMotion: true,      // Se true, applica automaticamente prefers-reduced-motion dell'OS
        darkMode: false,           // Se true, applica automaticamente prefers-color-scheme dell'OS
        highContrast: false,       // Se true, applica automaticamente prefers-contrast dell'OS
        reducedTransparency: false // Se true, applica automaticamente prefers-reduced-transparency dell'OS
    }
};

/////////////////////////////////////////////
// Rileva Preferenze di Sistema Operativo
/////////////////////////////////////////////
function detectReducedTransparencySupport() {
    const isAppleDevice = /Mac|iPad|iPhone|iPod/.test(navigator.userAgent);
    const standardQuery = window.matchMedia('(prefers-reduced-transparency: reduce)');
    const appleQuery = window.matchMedia('(-apple-prefers-reduced-transparency: reduce)');
    const highContrastQuery = window.matchMedia('(prefers-contrast: more)');

    return standardQuery.matches || (isAppleDevice && appleQuery.matches) || highContrastQuery.matches;
}

const systemPreferences = {
    isReduced: window.matchMedia('(prefers-reduced-motion: reduce)').matches,
    prefersDarkMode: window.matchMedia('(prefers-color-scheme: dark)').matches,
    prefersHighContrast: window.matchMedia('(prefers-contrast: more)').matches,
    prefersReducedTransparency: detectReducedTransparencySupport()
};

/////////////////////////////////////////////
// Configurazione globale
/////////////////////////////////////////////
const PREFERENCES_KEY = 'paperplane_user_preferences';
const COOKIE_NAME = 'paperplane_user_preferences';

// Configurazione animazioni
window.ThemeConfig = window.ThemeConfig || {
    animation: {
        duration: 500,
        durationCounter: 1500
    }
};

/////////////////////////////////////////////
// Utility Functions
/////////////////////////////////////////////

function addHours(date, hours) {
    date.setTime(date.getTime() + hours * 60 * 60 * 1000);
    return date;
}

function getPreferencesFromStorage() {
    try {
        return JSON.parse(localStorage.getItem(PREFERENCES_KEY)) || {};
    } catch (e) {
        return {};
    }
}

function savePreferencesToStorage(prefs) {
    try {
        // Salva in localStorage
        localStorage.setItem(PREFERENCES_KEY, JSON.stringify(prefs));

        // Salva come cookie (per il prossimo page load)
        const expiryDate = addHours(new Date(), 365 * 24);
        document.cookie = COOKIE_NAME + "=" +
            encodeURIComponent(JSON.stringify(prefs)) +
            "; expires=" + expiryDate.toUTCString() +
            "; path=/" +
            "; SameSite=Lax" +
            (window.location.protocol === 'https:' ? "; Secure" : "");
    } catch (e) {
        console.error('Errore nel salvataggio delle preferenze:', e);
    }
}

function updateAttributesFromPreferences() {
    const prefs = getPreferencesFromStorage();

    // Aggiorna data-reduced-motion
    if (prefs.reduced_motion === 0) {
        document.documentElement.setAttribute('data-reduced-motion', 'true');

        // Pausa i video
        document.querySelectorAll('.stoppable-js').forEach(el => {
            if (el.pause) el.pause();
        });

        // Aggiorna pulsanti play/pause
        document.querySelectorAll('.animation-play-pause-js').forEach(el => {
            el.classList.remove('pause');
            el.classList.add('play');
            el.setAttribute('aria-pressed', 'false');
        });

        // Aggiorna switch UI
        // Bottone OFF quando movimento ridotto è ATTIVO
        document.querySelectorAll('.paperplane-reduce-motion-js').forEach(el => {
            el.setAttribute('aria-checked', 'false');
            updateSwitchLabel(el);
        });

        // Imposta durate animazioni a 0
        window.ThemeConfig.animation.duration = 0;
        window.ThemeConfig.animation.durationCounter = 0;
    } else {
        document.documentElement.removeAttribute('data-reduced-motion');

        // Riproduci i video
        document.querySelectorAll('.stoppable-js').forEach(el => {
            if (el.play) el.play();
        });

        // Aggiorna pulsanti play/pause
        document.querySelectorAll('.animation-play-pause-js').forEach(el => {
            el.classList.add('pause');
            el.classList.remove('play');
            el.setAttribute('aria-pressed', 'true');
        });

        // Aggiorna switch UI
        // Bottone ON quando movimento ridotto è INATTIVO
        document.querySelectorAll('.paperplane-reduce-motion-js').forEach(el => {
            el.setAttribute('aria-checked', 'true');
            updateSwitchLabel(el);
        });

        // Ripristina durate animazioni
        window.ThemeConfig.animation.duration = 500;
        window.ThemeConfig.animation.durationCounter = 1500;
    }

    // Aggiorna data-theme
    if (prefs.dark_mode === 1) {
        document.documentElement.setAttribute('data-theme', 'dark');
        document.querySelectorAll('.paperplane-darkmode-js').forEach(el => {
            el.setAttribute('aria-checked', 'true');
            updateSwitchLabel(el);
        });
    } else {
        document.documentElement.setAttribute('data-theme', 'light');
        document.querySelectorAll('.paperplane-darkmode-js').forEach(el => {
            el.setAttribute('aria-checked', 'false');
            updateSwitchLabel(el);
        });
    }

    // Aggiorna data-reduced-transparency
    if (prefs.reduced_transparency === 1) {
        document.documentElement.setAttribute('data-reduced-transparency', 'true');
        document.querySelectorAll('.paperplane-reduce-transparency-js').forEach(el => {
            el.setAttribute('aria-checked', 'true');
            updateSwitchLabel(el);
        });
    } else {
        document.documentElement.removeAttribute('data-reduced-transparency');
        document.querySelectorAll('.paperplane-reduce-transparency-js').forEach(el => {
            el.setAttribute('aria-checked', 'false');
            updateSwitchLabel(el);
        });
    }
}

function savePreference(preferenceKey, value) {
    const prefs = getPreferencesFromStorage();
    prefs[preferenceKey] = value;
    savePreferencesToStorage(prefs);
    updateAttributesFromPreferences();
}

function updateSwitchLabel(button) {
    const isChecked = button.getAttribute('aria-checked') === 'true';
    const label = button.querySelector('.paperplane-switch-label');

    if (label) {
        label.textContent = isChecked ? 'On' : 'Off';
    }
}

function syncButtonsWithCurrentDOM() {
    // Leggi lo stato ATTUALE dal DOM (impostato dal PHP)
    let hasReducedMotion = document.documentElement.hasAttribute('data-reduced-motion');
    let isDarkMode = document.documentElement.getAttribute('data-theme') === 'dark';
    let hasReducedTransparency = document.documentElement.hasAttribute('data-reduced-transparency');

    // ============ APPLICA SYSTEM PREFERENCES SE ABILITATO ============

    // Se autoApplySystemPreferences.reducedMotion è TRUE, rispetta la preferenza dell'OS
    if (ACCESSIBILITY_CONFIG.autoApplySystemPreferences.reducedMotion && systemPreferences.isReduced) {
        hasReducedMotion = true;
        document.documentElement.setAttribute('data-reduced-motion', 'true');
    }

    // Se autoApplySystemPreferences.darkMode è TRUE, rispetta la preferenza dell'OS
    if (ACCESSIBILITY_CONFIG.autoApplySystemPreferences.darkMode && systemPreferences.prefersDarkMode) {
        isDarkMode = true;
        document.documentElement.setAttribute('data-theme', 'dark');
    }

    // Se autoApplySystemPreferences.reducedTransparency è TRUE, rispetta la preferenza dell'OS
    if (ACCESSIBILITY_CONFIG.autoApplySystemPreferences.reducedTransparency && systemPreferences.prefersReducedTransparency) {
        hasReducedTransparency = true;
        document.documentElement.setAttribute('data-reduced-transparency', 'true');
    }

    // ============ SINCRONIZZA I BOTTONI CON LO STATO DEL DOM ============

    document.querySelectorAll('.paperplane-reduce-motion-js').forEach(el => {
        el.setAttribute('aria-checked', hasReducedMotion ? 'false' : 'true');
        updateSwitchLabel(el);
    });

    document.querySelectorAll('.paperplane-darkmode-js').forEach(el => {
        el.setAttribute('aria-checked', isDarkMode ? 'true' : 'false');
        updateSwitchLabel(el);
    });

    document.querySelectorAll('.paperplane-reduce-transparency-js').forEach(el => {
        el.setAttribute('aria-checked', hasReducedTransparency ? 'true' : 'false');
        updateSwitchLabel(el);
    });

    // ============ INIZIALIZZA LOCALSTORAGE ============

    // Inizializza localStorage se non esiste (primo caricamento/anonimo)
    if (!localStorage.getItem(PREFERENCES_KEY)) {
        try {
            const prefs = {
                reduced_motion: hasReducedMotion ? 0 : 1,
                dark_mode: isDarkMode ? 1 : 0,
                reduced_transparency: hasReducedTransparency ? 1 : 0
            };
            localStorage.setItem(PREFERENCES_KEY, JSON.stringify(prefs));

            // Salva anche come cookie per il PHP al prossimo caricamento
            const expiryDate = addHours(new Date(), 365 * 24);
            document.cookie = COOKIE_NAME + "=" +
                encodeURIComponent(JSON.stringify(prefs)) +
                "; expires=" + expiryDate.toUTCString() +
                "; path=/" +
                "; SameSite=Lax" +
                (window.location.protocol === 'https:' ? "; Secure" : "");
        } catch (e) {
            console.warn('Impossibile inizializzare localStorage/cookie:', e);
        }
    }
}

// ============ AVVOLGI IL CODICE IN DOMContentLoaded ============
document.addEventListener('DOMContentLoaded', function () {

    // ✅ PRIMO: Sincronizza i bottoni con lo stato attuale del DOM (impostato dal PHP)
    syncButtonsWithCurrentDOM();

    // ✅ NUOVO: Applica tutte le preferenze (incluso pausa video, duration, ecc.)
    updateAttributesFromPreferences();

    // Mantieni le variabili legacy per retrocompatibilità
    var animation_duration = window.ThemeConfig.animation.duration;
    var animation_duration_counter = window.ThemeConfig.animation.durationCounter;

    /////////////////////////////////////////////
    // Click Handler: Reduced Motion Toggle
    /////////////////////////////////////////////
    document.addEventListener('click', function (e) {
        const target = e.target.closest('.paperplane-reduce-motion-js');
        if (target) {
            const prefs = getPreferencesFromStorage();
            const newValue = prefs.reduced_motion === 0 ? 1 : 0;
            savePreference('reduced_motion', newValue);
            e.preventDefault();
        }
    });

    /////////////////////////////////////////////
    // Click Handler: Dark Mode Toggle
    /////////////////////////////////////////////
    document.addEventListener('click', function (e) {
        const target = e.target.closest('.paperplane-darkmode-js');
        if (target) {
            const prefs = getPreferencesFromStorage();
            const newValue = prefs.dark_mode === 1 ? 0 : 1;
            savePreference('dark_mode', newValue);
            e.preventDefault();
        }
    });

    /////////////////////////////////////////////
    // Click Handler: Reduced Transparency Toggle
    /////////////////////////////////////////////
    document.addEventListener('click', function (e) {
        const target = e.target.closest('.paperplane-reduce-transparency-js');
        if (target) {
            const prefs = getPreferencesFromStorage();
            const newValue = prefs.reduced_transparency === 1 ? 0 : 1;
            savePreference('reduced_transparency', newValue);
            e.preventDefault();
        }
    });

    /////////////////////////////////////////////
    // Click Handler: Video Play/Pause
    /////////////////////////////////////////////
    document.addEventListener('click', function (e) {
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
    // Click Handler: Animation Play/Pause
    /////////////////////////////////////////////
    document.addEventListener('click', function (e) {
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
    // Stop Videos in Autoplay to Enable Screensaver
    // (120 seconds = 2 minutes)
    /////////////////////////////////////////////
    setTimeout(function () {
        // Pausa per tutti gli elementi con la classe 'stoppable-js'
        document.querySelectorAll('.stoppable-js').forEach(function (element) {
            if (element.pause) element.pause();
        });

        // Aggiorna tutti gli elementi con la classe 'animation-play-pause-js'
        document.querySelectorAll('.animation-play-pause-js').forEach(function (element) {
            element.classList.remove('pause');
            element.classList.add('play');
            element.setAttribute('aria-pressed', 'false');
        });
    }, 120000);

    /////////////////////////////////////////////
    // Accessibility Panel Hide on Scroll
    /////////////////////////////////////////////
    function acessibilityPanelHide() {
        const scroll = window.scrollY || window.pageYOffset;
        const elements = document.querySelectorAll('.reduce-motion-overlay-js');

        if (scroll > 200) {
            elements.forEach(el => el.classList.add('hidden'));
        } else {
            elements.forEach(el => el.classList.remove('hidden'));
        }
    }

    window.addEventListener('scroll', acessibilityPanelHide);

    /////////////////////////////////////////////
    // Z-index for Focused Links - OTTIMIZZATO PER SAFARI
    /////////////////////////////////////////////
    document.body.addEventListener('keydown', function (event) {
        if (event.keyCode === 9) { // Tab key
            const target = event.target;

            // Se è un anchor, applica la logica
            if (target.tagName === 'A') {
                document.querySelectorAll('.aos-animate').forEach(function (element) {
                    element.classList.remove('aos-animate');
                    element.classList.add('unset-aos-animate');
                });
            }
        }
    });

    document.body.addEventListener('keyup', function (event) {
        if (event.keyCode === 9) { // Tab key - quando esce dall'anchor
            document.querySelectorAll('.unset-aos-animate').forEach(function (element) {
                element.classList.remove('unset-aos-animate');
                element.classList.add('aos-animate');
            });
        }
    });

}); // ============ FINE DOMContentLoaded ============