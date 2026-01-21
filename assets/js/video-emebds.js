// Gestisce la pausa dei video al chiusura del modal
document.addEventListener('click', function (e) {
    if (e.target.matches('.modal-close-js')) {
        // Pausa tutti i video tag HTML5
        document.querySelectorAll('video.video-element').forEach(video => {
            video.pause();
        });

        // Pausa tutti i YouTube player (usando postMessage API)
        document.querySelectorAll('iframe.video-element[src*="youtube.com/embed"]').forEach(iframe => {
            iframe.contentWindow.postMessage(
                JSON.stringify({ event: 'command', func: 'pauseVideo' }),
                '*'
            );
        });

        // Pausa tutti i Vimeo player (usando postMessage API)
        document.querySelectorAll('iframe.video-element[src*="vimeo.com"]').forEach(iframe => {
            iframe.contentWindow.postMessage({ method: 'pause' }, '*');
        });
    }
});