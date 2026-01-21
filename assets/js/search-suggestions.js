/**
 * VARIABILI GLOBALI - FUORI DAL DOMContentLoaded
 * Per evitare problemi di scope durante la minificazione
 */
let searchData = [];
let searchConfig = {};
let jsonLoaded = false;
let selectedIndex = -1;

document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('search-input');
    const suggestionsContainer = document.getElementById('search-suggestions');
    const searchStatus = document.getElementById('search-status-js');

    // Recupera le stringhe tradotte
    const strings = {
        closeSearchResults: (typeof themeStrings !== 'undefined' && themeStrings.closeSearchResults) ? themeStrings.closeSearchResults : 'Chiudi risultati ricerca',
        searchResultSingular: (typeof themeStrings !== 'undefined' && themeStrings.searchResultSingular) ? themeStrings.searchResultSingular : 'risultato',
        searchResultPlural: (typeof themeStrings !== 'undefined' && themeStrings.searchResultPlural) ? themeStrings.searchResultPlural : 'risultati',
        noSearchResults: (typeof themeStrings !== 'undefined' && themeStrings.noSearchResults) ? themeStrings.noSearchResults : '0 risultati',
        proceedToView: (typeof themeStrings !== 'undefined' && themeStrings.proceedToView) ? themeStrings.proceedToView : ', prosegui per visualizzare',
        searchSuggestions: (typeof themeStrings !== 'undefined' && themeStrings.searchSuggestions) ? themeStrings.searchSuggestions : 'Suggerimenti di ricerca',
        searchElementsNotFound: (typeof themeStrings !== 'undefined' && themeStrings.searchElementsNotFound) ? themeStrings.searchElementsNotFound : 'Elementi di ricerca non trovati',
        fallbackUncompressed: (typeof themeStrings !== 'undefined' && themeStrings.fallbackUncompressed) ? themeStrings.fallbackUncompressed : 'Fallback alla versione non compressa',
        errorLoadingJSON: (typeof themeStrings !== 'undefined' && themeStrings.errorLoadingJSON) ? themeStrings.errorLoadingJSON : 'Errore nel caricamento del JSON',
        errorLoading: (typeof themeStrings !== 'undefined' && themeStrings.errorLoading) ? themeStrings.errorLoading : 'Errore nel caricamento:',
        errorLoadingData: (typeof themeStrings !== 'undefined' && themeStrings.errorLoadingData) ? themeStrings.errorLoadingData : 'Errore caricamento dati:'
    };

    // Funzione per ottenere la priorità di un post type
    function getPostTypePriority(postType) {
        const priorities = searchConfig.postTypePriorities || {};
        const priority = parseInt(priorities[postType]) || 999;
        return priority;
    }

    if (!searchInput || !suggestionsContainer) {
        console.error(strings.searchElementsNotFound);
        return;
    }

    // Funzione per eseguire la ricerca
    function performSearch() {
        const query = searchInput.value.toLowerCase();

        // Aggiorna la classe per mostrare/nascondere il clear button
        if (query.length >= 3) {
            searchInput.classList.add('has-text');
        } else {
            searchInput.classList.remove('has-text');
        }

        // Query < 3 caratteri
        if (query.length < 3) {
            suggestionsContainer.classList.remove('visible');
            searchInput.setAttribute('aria-expanded', 'false');
            searchInput.removeAttribute('aria-activedescendant');

            // Nascondi il bottone close
            const closeBtn = document.getElementById('search-close-button');
            if (closeBtn) {
                closeBtn.classList.remove('visible');
            }

            if (searchStatus && query.length > 0) {
                searchStatus.textContent = 'Digita almeno 3 caratteri';
            }
            return;
        }

        const matches = searchData
            .filter(post => {
                const queryWords = query.split(' ').filter(word => word.length > 0);
                const queryVariations = queryWords.map(word => getNormalizedWords(word)).flat();

                post.matchScore = 0;

                const exactTitleMatch = queryWords.some(word =>
                    removeAccents(post.title.toLowerCase()).includes(word.toLowerCase())
                );
                if (exactTitleMatch) post.matchScore += 100;

                const variantTitleMatch = queryVariations.some(variation =>
                    removeAccents(post.title.toLowerCase()).includes(variation)
                );
                if (variantTitleMatch && !exactTitleMatch) post.matchScore += 50;

                const exactContentMatch = post.searchable_content && queryWords.some(word =>
                    removeAccents(post.searchable_content.toLowerCase()).includes(word.toLowerCase())
                );
                if (exactContentMatch) post.matchScore += 30;

                const variantContentMatch = post.searchable_content && queryVariations.some(variation =>
                    removeAccents(post.searchable_content.toLowerCase()).includes(variation)
                );
                if (variantContentMatch && !exactContentMatch) post.matchScore += 10;

                return variantTitleMatch || variantContentMatch || exactTitleMatch || exactContentMatch;
            })
            .sort((a, b) => {
                const priorityA = getPostTypePriority(a.post_type);
                const priorityB = getPostTypePriority(b.post_type);

                if (priorityA !== priorityB) {
                    return priorityA - priorityB;
                }

                if (a.matchScore !== b.matchScore) {
                    return b.matchScore - a.matchScore;
                }

                return new Date(b.modified) - new Date(a.modified);
            })
            .slice(0, 30);

        if (matches.length > 0) {
            selectedIndex = -1;

            const resultCount = matches.length;
            const countText = resultCount === 1 ? strings.searchResultSingular : strings.searchResultPlural;
            const counterHTML = '<li class="search-result-counter" aria-hidden="true" aria-selected="false" role="option" tabindex="-1">' + resultCount + ' ' + countText + '</li>';

            const suggestionsHTML = matches.map((post, index) => {
                const itemId = 'search-suggestion-' + index;
                return '<li class="suggestion-item" aria-selected="false" id="' + itemId + '" role="option" tabindex="-1" aria-posinset="' + (index + 1) + '" aria-setsize="' + matches.length + '">' +
                    (post.featured_image ? '<div class="suggestion-image"><img src="' + post.featured_image + '" alt="" loading="lazy" decoding="async" /></div>' : '') +
                    '<div class="suggestion-title" aria-hidden="true">' + post.title + '</div>' +
                    '<a href="' + post.url + '" class="absl"><span class="screen-reader-text">' + post.title + '</span></a>' +
                    '</li>';
            }).join('');

            suggestionsContainer.innerHTML = counterHTML + suggestionsHTML;
            suggestionsContainer.classList.add('visible');

            searchInput.setAttribute('aria-expanded', 'true');

            // Mostra il bottone close
            const closeBtn = document.getElementById('search-close-button');
            if (closeBtn) {
                closeBtn.classList.add('visible');
            }

            if (searchStatus) {
                const statusCountText = resultCount === 1 ? strings.searchResultSingular : strings.searchResultPlural;
                searchStatus.textContent = resultCount + ' ' + statusCountText + strings.proceedToView;
            }
        } else {
            suggestionsContainer.classList.remove('visible');
            searchInput.setAttribute('aria-expanded', 'false');
            searchInput.removeAttribute('aria-activedescendant');
            selectedIndex = -1;

            // Nascondi il bottone close
            const closeBtn = document.getElementById('search-close-button');
            if (closeBtn) {
                closeBtn.classList.remove('visible');
            }

            if (searchStatus) {
                searchStatus.textContent = strings.noSearchResults;
            }
        }
    }

    // Funzione per tentare il caricamento del JSON
    async function loadJSON() {
        try {
            // Aspetta che searchConfig sia caricato (se REST API non è ancora completata)
            while (!searchConfig.jsonUrl || !searchConfig.gzipUrl) {
                // console.log('⏳ In attesa che searchConfig sia caricato...');
                await new Promise(resolve => setTimeout(resolve, 50));
            }

            // console.log('✅ searchConfig è pronto, procedo con il caricamento del JSON');

            // Se gzipUrl è disponibile (server Apache), prova prima la versione compressa
            if (searchConfig.gzipUrl) {
                try {
                    const gzResponse = await fetch(searchConfig.gzipUrl, {
                        headers: {
                            'Accept-Encoding': 'gzip'
                        }
                    });

                    if (gzResponse.ok) {
                        return await gzResponse.json();
                    }
                } catch (error) {
                    console.warn(strings.fallbackUncompressed, error);
                }
            }

            // Se gzipUrl non è disponibile (server Nginx) o se il tentativo con gzip è fallito
            const response = await fetch(searchConfig.jsonUrl);
            if (!response.ok) {
                throw new Error(strings.errorLoadingJSON);
            }
            return await response.json();
        } catch (error) {
            console.error(strings.errorLoading, error);
            throw error;
        }
    }

    // Carica il JSON al focus dell'input
    searchInput.addEventListener('focus', function () {
        if (searchStatus) {
            searchStatus.setAttribute('aria-hidden', 'false');
        }

        if (!jsonLoaded) {
            loadJSON()
                .then(data => {
                    searchData = Object.values(data);
                    jsonLoaded = true;
                    if (searchInput.value.length >= 3) {
                        performSearch();
                    }
                })
                .catch(error => {
                    console.error(strings.errorLoadingData, error);
                });
        }
    });

    // Listener per input
    const debouncedSearch = debounce(performSearch, 300);
    searchInput.addEventListener('input', debouncedSearch);

    // Listener per navigazione con tastiera
    searchInput.addEventListener('keydown', function (e) {
        const visibleItems = Array.from(suggestionsContainer.querySelectorAll('.suggestion-item'));

        if (visibleItems.length === 0) {
            return;
        }

        if (e.key === 'ArrowDown') {
            e.preventDefault();
            selectedIndex = Math.min(selectedIndex + 1, visibleItems.length - 1);
            updateSelectedItem(visibleItems, selectedIndex);
        }

        if (e.key === 'ArrowUp') {
            e.preventDefault();
            selectedIndex = Math.max(selectedIndex - 1, -1);
            updateSelectedItem(visibleItems, selectedIndex);
        }

        if (e.key === 'Enter' && selectedIndex >= 0) {
            e.preventDefault();
            const selectedLink = visibleItems[selectedIndex].querySelector('.absl');
            if (selectedLink) {
                selectedLink.click();
            }
        }

        if (e.key === 'Escape') {
            e.preventDefault();
            suggestionsContainer.classList.remove('visible');
            searchInput.setAttribute('aria-expanded', 'false');
            searchInput.removeAttribute('aria-activedescendant');
            selectedIndex = -1;
            updateSelectedItem(visibleItems, selectedIndex);

            // Nascondi il bottone close
            const closeBtn = document.getElementById('search-close-button');
            if (closeBtn) {
                closeBtn.classList.remove('visible');
            }
        }
    });

    // Listener sul bottone close
    const closeBtn = document.getElementById('search-close-button');
    if (closeBtn) {
        closeBtn.addEventListener('click', function (e) {
            e.preventDefault();
            suggestionsContainer.classList.remove('visible');
            searchInput.setAttribute('aria-expanded', 'false');
            searchInput.removeAttribute('aria-activedescendant');
            selectedIndex = -1;
            closeBtn.classList.remove('visible');

            // Reset: Permetti al focus listener di eseguire la ricerca di nuovo
            jsonLoaded = false;

            // Rimetti focus sul bottone (non sull'input)
            closeBtn.focus();
        });
    }

    /**
     * FETCH DELLA REST API - PARTE SUBITO IN BACKGROUND
     * Senza bloccare l'aggiunta dei listener
     */
    fetchLatestJsonUrl()
        .catch(error => {
            console.error('❌ Errore nel caricamento della REST API:', error);
        });
});

/**
 * FETCH DINAMICO DELLA REST API
 * Recupera l'URL del file JSON più recente
 */
async function fetchLatestJsonUrl() {
    try {
        // console.log('Tentando di caricare REST API...');

        const baseUrl = window.location.origin;
        const restUrl = baseUrl + '/wp-json/custom/v1/latest-json-url/';

        // console.log('URL REST API:', restUrl);

        const response = await fetch(restUrl);
        // console.log('Response status:', response.status);

        if (!response.ok) {
            throw new Error('Errore REST API: ' + response.status + ' ' + response.statusText);
        }

        const data = await response.json();
        // console.log('Dati ricevuti dalla REST API:', data);

        // Verifica che i dati siano validi
        if (!data.jsonUrl || !data.gzipUrl) {
            throw new Error('Dati REST API incompleti: jsonUrl o gzipUrl mancanti');
        }

        // Popola searchConfig - VARIABILE GLOBALE
        searchConfig = {
            jsonUrl: data.jsonUrl,
            gzipUrl: data.gzipUrl,
            postTypePriorities: data.postTypePriorities || {}
        };

        // console.log('searchConfig caricato:', searchConfig);
        return searchConfig;

    } catch (error) {
        console.error('ERRORE nel caricamento della REST API:', error);
        throw error;
    }
}

function debounce(func, wait) {
    let timeout;
    return function () {
        const args = arguments;
        clearTimeout(timeout);
        timeout = setTimeout(() => func.apply(this, args), wait);
    };
}

function getWordVariations(word) {
    const variations = new Set([word.toLowerCase()]);

    const rules = [
        { from: /i$/i, to: 'o' },
        { from: /e$/i, to: 'a' },
        { from: /i$/i, to: 'e' },
        { from: /o$/i, to: 'i' },
        { from: /a$/i, to: 'e' },
        { from: /e$/i, to: 'i' }
    ];

    const specialRules = [
        { from: /chi$/i, to: 'co' },
        { from: /che$/i, to: 'ca' },
        { from: /ghi$/i, to: 'go' },
        { from: /ghe$/i, to: 'ga' },
        { from: /co$/i, to: 'chi' },
        { from: /ca$/i, to: 'che' },
        { from: /go$/i, to: 'ghi' },
        { from: /ga$/i, to: 'ghe' }
    ];

    var allRules = rules.concat(specialRules);
    allRules.forEach(function (rule) {
        if (word.match(rule.from)) {
            variations.add(word.replace(rule.from, rule.to).toLowerCase());
        }
    });

    return Array.from(variations);
}

function handleExceptions(word) {
    const exceptions = {
        'uomo': 'uomini',
        'uomini': 'uomo',
        'dio': 'dei',
        'dei': 'dio',
        'bue': 'buoi',
        'buoi': 'bue'
    };

    const invariableWords = new Set([
        'città', 'virtù', 'gioventù', 'caffè', 'computer', 'sport'
    ]);

    if (invariableWords.has(word.toLowerCase())) {
        return [word.toLowerCase()];
    }

    if (exceptions[word.toLowerCase()]) {
        return [word.toLowerCase(), exceptions[word.toLowerCase()]];
    }

    return null;
}

function getNormalizedWords(word) {
    const normalized = word.normalize("NFD")
        .replace(/[\u0300-\u036f]/g, "")
        .toLowerCase();

    const exceptions = handleExceptions(normalized);
    if (exceptions) {
        return exceptions;
    }

    return getWordVariations(normalized);
}

function removeAccents(str) {
    return str.normalize("NFD")
        .replace(/[\u0300-\u036f]/g, "");
}

function updateSelectedItem(items, index) {
    items.forEach(function (item, i) {
        if (i === index) {
            item.setAttribute('aria-selected', 'true');
            const searchInput = document.getElementById('search-input');
            if (searchInput) {
                searchInput.setAttribute('aria-activedescendant', item.id);
            }
        } else {
            item.setAttribute('aria-selected', 'false');
        }
    });

    if (index === -1) {
        const searchInput = document.getElementById('search-input');
        if (searchInput) {
            searchInput.removeAttribute('aria-activedescendant');
        }
    }
}

// console.log('Script di ricerca caricato - Con fetch REST API dinamico FIX');