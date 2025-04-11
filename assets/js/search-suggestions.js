document.addEventListener('DOMContentLoaded', function () {
    let searchData = [];
    const searchInput = document.getElementById('search-input');
    const suggestionsContainer = document.getElementById('search-suggestions');
    let jsonLoaded = false;

    // Funzione per ottenere la priorità di un post type
    function getPostTypePriority(postType) {
        const priorities = searchConfig.postTypePriorities || {};
        const priority = parseInt(priorities[postType]) || 999;
        return priority;
    }

    if (!searchInput || !suggestionsContainer) {
        console.error('Elementi di ricerca non trovati');
        return;
    }

    // Funzione per tentare il caricamento del JSON
    async function loadJSON() {
        try {
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
                    console.warn('Fallback alla versione non compressa:', error);
                }
            }

            // Se gzipUrl non è disponibile (server Nginx) o se il tentativo con gzip è fallito
            const response = await fetch(searchConfig.jsonUrl);
            if (!response.ok) {
                throw new Error('Errore nel caricamento del JSON');
            }
            return await response.json();
        } catch (error) {
            console.error('Errore nel caricamento:', error);
            throw error;
        }
    }

    // Carica il JSON al focus dell'input
    searchInput.addEventListener('focus', function () {
        if (!jsonLoaded) {
            loadJSON()
                .then(data => {
                    searchData = Object.values(data);
                    jsonLoaded = true;
                })
                .catch(error => {
                    console.error('Errore caricamento dati:', error);
                });
        }
    });

    searchInput.addEventListener('input', debounce(function (e) {
        const query = e.target.value.toLowerCase();
        const cursorPosition = searchInput.selectionStart;

        if (query.length < 3) {
            suggestionsContainer.classList.remove('visible');
            return;
        }

        const matches = searchData
            .filter(post => {
                const queryWords = query.split(' ').filter(word => word.length > 0);
                // Per ogni parola della query, genera le variazioni
                const queryVariations = queryWords.map(word => getNormalizedWords(word)).flat();

                // Calcola i match e salva i punteggi direttamente nell'oggetto post
                post.matchScore = 0;

                // Match esatto nel titolo (peso maggiore)
                const exactTitleMatch = queryWords.some(word =>
                    removeAccents(post.title.toLowerCase()).includes(word.toLowerCase())
                );
                if (exactTitleMatch) post.matchScore += 100;

                // Match con variazioni nel titolo (peso minore)
                const variantTitleMatch = queryVariations.some(variation =>
                    removeAccents(post.title.toLowerCase()).includes(variation)
                );
                if (variantTitleMatch && !exactTitleMatch) post.matchScore += 50;

                // Match esatto nel contenuto
                const exactContentMatch = post.searchable_content && queryWords.some(word =>
                    removeAccents(post.searchable_content.toLowerCase()).includes(word.toLowerCase())
                );
                if (exactContentMatch) post.matchScore += 30;

                // Match con variazioni nel contenuto
                const variantContentMatch = post.searchable_content && queryVariations.some(variation =>
                    removeAccents(post.searchable_content.toLowerCase()).includes(variation)
                );
                if (variantContentMatch && !exactContentMatch) post.matchScore += 10;

                return variantTitleMatch || variantContentMatch || exactTitleMatch || exactContentMatch;
            })
            .sort((a, b) => {
                // Prima considera la priorità del post type
                const priorityA = getPostTypePriority(a.post_type);
                const priorityB = getPostTypePriority(b.post_type);

                if (priorityA !== priorityB) {
                    return priorityA - priorityB;
                }

                // A parità di priorità, considera il punteggio del match
                if (a.matchScore !== b.matchScore) {
                    return b.matchScore - a.matchScore;
                }

                // Se anche i punteggi sono uguali, ordina per data
                return new Date(b.modified) - new Date(a.modified);
            })
            .slice(0, 30);

        if (matches.length > 0) {
            // Trova il primo match per l'autocompletamento
            const firstMatch = matches[0].title;
            const queryWords = query.split(' ');
            const lastWord = queryWords[queryWords.length - 1];

            // Cerca una parola nel titolo che inizia con l'ultima parola digitata
            const words = firstMatch.toLowerCase().split(' ');
            const matchingWord = words.find(word => word.startsWith(lastWord));

            if (matchingWord && lastWord.length > 0) {
                // Mantieni il case originale dell'input dell'utente
                const completion = matchingWord.slice(lastWord.length);
                const originalValue = searchInput.value;

                // Aggiungi l'autocompletamento mantenendo il testo selezionato
                searchInput.value = originalValue + completion;
                searchInput.setSelectionRange(cursorPosition, searchInput.value.length);
            }

            suggestionsContainer.innerHTML = matches.map(post => `
                <div class="suggestion-item">
                    ${post.featured_image ?
                    `<div class="suggestion-image">
                            <img src="${post.featured_image}" alt="" loading="lazy" decoding="async" />
                        </div>`
                    : ''
                }
                    <div class="suggestion-title">${post.title}</div>
                    <a href="${post.url}" class="absl">
                        <span class="screen-reader-text">${post.title}</span>
                    </a>
                </div>
            `).join('');
            suggestionsContainer.classList.add('visible');
        } else {
            suggestionsContainer.classList.remove('visible');
        }
    }, 300));

    // Gestione dei tasti speciali
    searchInput.addEventListener('keydown', function (e) {
        if (e.key === 'ArrowRight') {
            // Accetta il suggerimento
            e.preventDefault();
            const selection = window.getSelection();
            if (selection.toString().length > 0) {
                searchInput.setSelectionRange(searchInput.value.length, searchInput.value.length);
            }
        } else if (e.key === 'Escape') {
            // Rimuovi il suggerimento
            const cursorPosition = searchInput.selectionStart;
            searchInput.value = searchInput.value.substring(0, cursorPosition);
            suggestionsContainer.classList.remove('visible');
        }
    });

    document.addEventListener('click', function (e) {
        if (suggestionsContainer &&
            !searchInput.contains(e.target) &&
            !suggestionsContainer.contains(e.target)) {
            suggestionsContainer.classList.remove('visible');
        }
    });

    suggestionsContainer.addEventListener('focusout', function (e) {
        // Verifica se il nuovo elemento focalizzato è fuori dal container
        if (!suggestionsContainer.contains(e.relatedTarget)) {
            suggestionsContainer.classList.remove('visible');
        }
    });
});

function debounce(func, wait) {
    let timeout;
    return function (...args) {
        clearTimeout(timeout);
        timeout = setTimeout(() => func.apply(this, args), wait);
    };
}

function getWordVariations(word) {
    // Array che conterrà tutte le variazioni (singolare/plurale)
    const variations = new Set([word.toLowerCase()]);

    // Regole base italiano
    const rules = [
        // da plurale a singolare
        { from: /i$/i, to: 'o' },  // libri -> libro
        { from: /e$/i, to: 'a' },  // case -> casa
        { from: /i$/i, to: 'e' },  // cani -> cane

        // da singolare a plurale
        { from: /o$/i, to: 'i' },  // libro -> libri
        { from: /a$/i, to: 'e' },  // casa -> case
        { from: /e$/i, to: 'i' },  // cane -> cani
    ];

    // Regole speciali per -co/-ca/-go/-ga
    const specialRules = [
        { from: /chi$/i, to: 'co' }, // fuochi -> fuoco
        { from: /che$/i, to: 'ca' }, // barche -> barca
        { from: /ghi$/i, to: 'go' }, // funghi -> fungo
        { from: /ghe$/i, to: 'ga' }, // botteghe -> bottega

        { from: /co$/i, to: 'chi' }, // fuoco -> fuochi
        { from: /ca$/i, to: 'che' }, // barca -> barche
        { from: /go$/i, to: 'ghi' }, // fungo -> funghi
        { from: /ga$/i, to: 'ghe' }  // bottega -> botteghe
    ];

    // Applica tutte le regole e aggiungi le variazioni
    [...rules, ...specialRules].forEach(rule => {
        if (word.match(rule.from)) {
            variations.add(word.replace(rule.from, rule.to).toLowerCase());
        }
    });

    return Array.from(variations);
}

function handleExceptions(word) {
    // Dizionario delle eccezioni più comuni
    const exceptions = {
        'uomo': 'uomini',
        'uomini': 'uomo',
        'dio': 'dei',
        'dei': 'dio',
        'bue': 'buoi',
        'buoi': 'bue'
    };

    // Parole invariabili
    const invariableWords = new Set([
        'città', 'virtù', 'gioventù', 'caffè', 'computer', 'sport'
    ]);

    if (invariableWords.has(word.toLowerCase())) {
        return [word.toLowerCase()];
    }

    if (exceptions[word.toLowerCase()]) {
        return [word.toLowerCase(), exceptions[word.toLowerCase()]];
    }

    return null; // Nessuna eccezione trovata
}

function getNormalizedWords(word) {
    // Rimuovi accenti e caratteri speciali
    const normalized = word.normalize("NFD")
        .replace(/[\u0300-\u036f]/g, "")
        .toLowerCase();

    // Controlla prima le eccezioni
    const exceptions = handleExceptions(normalized);
    if (exceptions) {
        return exceptions;
    }

    // Altrimenti applica le regole standard
    return getWordVariations(normalized);
}

function removeAccents(str) {
    return str.normalize("NFD")
        .replace(/[\u0300-\u036f]/g, "");
}