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

            // Aggiungiamo i parametri per l'autoplay mutato all'URL
            if (src.includes('?')) {
                src += '&autoplay=1&muted=1';
            } else {
                src += '?autoplay=1&muted=1';
            }

            // Aggiorna gli attributi dell'iframe
            var vimeoIframe = document.getElementById(video_toplay);
            vimeoIframe.removeAttribute("data-src");
            vimeoIframe.setAttribute('src', src);
            vimeoIframe.setAttribute('aria-hidden', 'false');

            // Inizializza il player Vimeo
            var player = new Vimeo.Player(iframe);

            // Gestione pausa alla chiusura del modal
            document.addEventListener('click', function (e) {
                if (e.target.matches('.modal-close-js')) {
                    player.pause();
                }
            }, { once: true });
        }

        // Gestione video YouTube
        if (video_source == 'youtube') {
            var youtube_video_id = e.target.getAttribute('data-youtube-video-id');
            var player;

            document.getElementById(video_toplay).setAttribute('aria-hidden', 'false');

            player = new YT.Player(video_toplay, {
                height: '360',
                width: '640',
                modestbranding: 1,
                enablejsapi: 1,
                videoId: youtube_video_id,
                playerVars: {
                    'autoplay': 1,
                    'mute': 1,
                    'controls': 1,
                    'rel': 0,
                    'playsinline': 1
                },
                events: {
                    'onReady': function (event) {
                        event.target.playVideo();
                    },
                    'onStateChange': function (event) {
                        if (event.data === YT.PlayerState.PLAYING) {
                            //event.target.unMute();
                            console.log('Video in riproduzione');
                        }
                    },
                    'onError': function (event) {
                        console.error('Errore YouTube:', event.data);
                    }
                }
            });

            document.addEventListener('click', function (e) {
                if (e.target.matches('.modal-close-js')) {
                    if (player && typeof player.pauseVideo === 'function') {
                        player.pauseVideo();
                    }
                }
            }, { once: true });
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