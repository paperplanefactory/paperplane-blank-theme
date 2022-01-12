# paperplane-blank-theme - a starter theme

## Primi passaggi
1. rinominare la cartella del tema es. cliente-theme
2. compilare il file style.css con il nome del tema e il percorso alla repo del tema su GitHub
3. nel file wp-config.php modificare la riga define( 'UPLOADS', 'blankuploads' ); con il nome della cartella uploads corretta

## Strumenti CSS
- [Generatore gradiente CSS](https://cssgradient.io/)
- [Generatore Text Shadow CSS](https://css3gen.com/text-shadow/)
- [Generatore Border Radius CSS](https://css3gen.com/border-radius/)
- [Generatore Box Shadow CSS](https://css3gen.com/box-shadow/)
- [Come usare mixin con parametris](https://marksheet.io/sass-mixins.html)

## PICTURES SET
// trovi esempi per gestire le immagini con post thumbnail e ACF:
// template-parts/images/image-display-post-thumbnail.php
// template-parts/images/image-display-acf.php
// LAZY LOAD NOTES
// nelle immagini caricate con lazyload devono essere presenti i 2 tag:
// data-src="url file" src="url file con ritaglio micro"
// in questo modo verrà caricata prima l'immagine sgranata e poi sarà sostituita da quella vera e propria
// INFINITE SCROLL NOTES
// ora lo script per attivare l'infinite scroll si trova in js/theme-general.js in modo da non avere script nella pagina
// attivare lo script da functions/theme-scriptsloader.php
// togliere i commenti dal file js/theme-general.js
// per far funzionare l'infinite scroll:
// la griglia che contiene gli elementi deve avere la classe "grid-infinite" e ogni elemento da caricare deve avere la classe "grid-item-infinite"
// la pagina deve usare la paginazione -> vedi come esempio sample-blocks/query-post-con-parametro-paginazione-e-infinite-scroll.php
// la gestione dei messaggi di caricamento e dei link di paginazione è gestita dal file template-parts/grid/infinite-message.php
// CONTACT FORM 7
// nel file wp-config.php sono presenti queste 2 righe:
// define('WPCF7_LOAD_JS', false);
// define('WPCF7_LOAD_CSS', false);
// che impediscono il normale caricamento degli stili e degli script del plugin in modo da poterli attivare selettivamente solo dove servono
// nel file functions/theme-stylesloader.php c'è il condizionale per attivare gli stili in determinate pagine
// nel file functions/theme-scriptsloader.php c'è il condizionale per attivare gli script in determinate pagine
// TRADUZIONE STRINGHE
// Per aggiungere una nuove stringa è sufficiente usare questo codice php per ogni stringa che si vuole generare
// <?php _e('Ciao mondo!', 'paperplane-theme'); ?>
// è poi necessario seguire queste istruzioni per compilare le stringhe:
// https://premium.wpmudev.org/blog/how-to-localize-a-wordpress-theme-and-make-it-translation-ready/
// e queste istruzioni per tradurle:
// https://premium.wpmudev.org/blog/how-to-translate-a-wordpress-theme/
// SOCIAL
// i social sono gestiti dal pannello opzioni Impostazioni sito -> Gestione social
// le icone sono gestite con Font Awesome
// FONT AWESOME NOTES
// Font Awesome viene incluso dal file functions/theme-stylesloader.php
// disattivarlo se non necessario
// MATERIAL DESIGN ICONS
// In alternativa a Font Awesome è possibile utilizzare il font di Google per le icone, richiamato sempre dal file functions/theme-stylesloader.php
// informazioni sull'utilizzo:
// https://google.github.io/material-design-icons/#icon-font-for-the-web
// https://material.io/tools/icons/?style=baseline
