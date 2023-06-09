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
        showResult("⏳ BeforeInstallPromptEvent supported but not fired yet");
    } else {
        showResult("❌ BeforeInstallPromptEvent NOT supported");
    }
    document.querySelector("#install").addEventListener("click", installApp);
});

let deferredPrompt;

window.addEventListener('beforeinstallprompt', (e) => {
    // Prevents the default mini-infobar or install dialog from appearing on mobile
    e.preventDefault();
    // Save the event because you’ll need to trigger it later.
    deferredPrompt = e;
    // Show your customized install prompt for your PWA
    document.querySelector("#install").style.display = "block";
    showResult("✅ BeforeInstallPromptEvent fired", true);

});

window.addEventListener('appinstalled', (e) => {
    showResult("✅ AppInstalled fired", true);
});

async function installApp() {
    if (deferredPrompt) {
        deferredPrompt.prompt();
        showResult("🆗 Installation Dialog opened");
        // Find out whether the user confirmed the installation or not
        const { outcome } = await deferredPrompt.userChoice;
        // The deferredPrompt can only be used once.
        deferredPrompt = null;
        // Act on the user's choice
        if (outcome === 'accepted') {
            showResult('😀 User accepted the install prompt.', true);
        } else if (outcome === 'dismissed') {
            showResult('😟 User dismissed the install prompt');
        }
        // We hide the install button
        document.querySelector("#install").style.display = "none";

    }
}

function showResult(text, append = false) {
    if (append) {
        //document.querySelector("output").innerHTML += "<br>" + text;
    } else {
        //document.querySelector("output").innerHTML = text;
    }
}