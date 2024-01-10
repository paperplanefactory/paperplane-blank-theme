// Don't register the service worker
// until the page has fully loaded
window.addEventListener('load', () => {
    // Is service worker available?
    if ('serviceWorker' in navigator) {
        navigator.serviceWorker.register('/sw.js').then(() => {
            //console.log('Service worker registered!');
        }).catch((error) => {
            //console.warn('Error registering service worker:');
            //console.warn(error);
        });
    }
});

window.addEventListener("DOMContentLoaded", async event => {
    if ('BeforeInstallPromptEvent' in window) {
        //console.log('⏳ BeforeInstallPromptEvent supported but not fired yet');
    } else {
        //console.log('❌ BeforeInstallPromptEvent NOT supported');
    }
});

let deferredPrompt;

window.addEventListener('beforeinstallprompt', (e) => {
    // Prevents the default mini-infobar or install dialog from appearing on mobile
    e.preventDefault();
    // Save the event because you’ll need to trigger it later.
    deferredPrompt = e;
    // Show your customized install prompt for your PWA
    //console.log('✅ BeforeInstallPromptEvent fired');

});

window.addEventListener('appinstalled', (e) => {
    //console.log('✅ AppInstalled fired');
    gtag('event', 'installazione_PWA', {
        'event_name': 'pwa_installata'
    });
});


async function installApp() {
    if (deferredPrompt) {
        deferredPrompt.prompt();
        //console.log('🆗 Installation Dialog opened');
        // Find out whether the user confirmed the installation or not
        const { outcome } = await deferredPrompt.userChoice;
        // The deferredPrompt can only be used once.
        deferredPrompt = null;
        // Act on the user's choice
        if (outcome === 'accepted') {
            //console.log('😀 User accepted the install prompt.');
        } else if (outcome === 'dismissed') {
            //console.log('😟 User dismissed the install prompt');
        }
        // We hide the install button

    }
}