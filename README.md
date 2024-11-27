# paperplane-blank-theme
A starter theme by PaperPlane Factory. Tema utilizzato come base di partenza per progetti WordPress.

## Requisiti
Plugin richiesti:
 - Advanced Custom Fields Pro

## Per iniziare
1. cancella le cartelle di GitHub in modo da scollegare la cartella dalla repo
2. rinomina la cartella del tema es. nomecliente-theme
3. aggiorna il file style.css modificando il parametro Text Domain: "paperPlane-blankTheme"
4. aggiorna il file style.css modificando i link alla repository su GitHub:
- Theme URI: https://github.com/paperplanefactory/nomecliente-theme
- GitHub Theme URI: https://github.com/paperplanefactory/nomecliente-theme
5. crea la nuova repository su GitHub
6. attiva il nuovo tema in back end

## Debug
Utilizzare Query Monitor per il debug. Per evitare rallentamenti in back end è possibile disattivare le analisi di Query Monitor solo per il back end dalla pagina opzioni Theme Settings > Abilitare Query Monitor in back end?

## Gestione CTP predefiniti
1. se alcuni CPT (es. banner o modal) non sono necessari:
- cancella gli eventuali contenuti presenti
- imposta su "falso" l'opzione "Mostra UI" nel plugin CPT UI e rimuovili nei campi di ACF interessati (es. CTA) 

2. se è attiva l'opzione del plugin Under Construction, salvando la pagina "Theme Settings" vengono generate in automatico la pagina under construction e la pagina di manutenzione basate su logo e colori del sito. Perchè funzioni è importante che il logo "site-logo-header.svg" venga sostituito ma non rinominato

## ACF e transients
- $content_fields = paperplane_content_transients( $post->ID ); viene utilizzato per richiamare i campi relativi al contenuto visualizzato. Viene generata in header.php e impostata come variabile globale
- $options_fields = paperplane_options_transients(); viene utilizzato per le opzioni del tema che non richiedono traduzione. Viene generata in header.php e impostata come variabile globale
- $options_fields_multilang = paperplane_options_transients_multilanguage( $acf_options_parameter ); viene utilizzato per le opzioni del tema predisposte per la traduzione. Viene generata in header.php e impostata come variabile globale

È possibile disattivare l'utilizzo delle transient per ACF in back end dalla pagina opzioni Theme Settings > Utilizzare le transient per i campi personalizzati? 

## Aperture di pagina
Per mantenenre correttamente la funzionalità di preload delle immagini above the fold, in caso siano necessarie aperture di pagine aggiuntive, dove possibile mantenere questi nomi per i custom field delle immagini e del poster del video:
- page_opening_image_desktop
- page_opening_image_mobile
- page_opening_video_poster

## Favicon
Partendo da un file di almeno 512x512 pixel, caricarlo su https://www.favicon-generator.org/, scaricare il file zip, estrapolare i contenuti e sostituirli a quelli presenti nella cartella assets/images/favicons

## Ottimizzazione performance
### CSS
Terminato il debug rimuovere gli eventuali CSS parziali non utilizzati in assets/css/style.scss

### Immagini in upload
Terminato il debug usare includes/theme-images-crop.php per verificare che:
- i ritagli aggiunti siano della corretta misura e non sia sgranati o sovradimensionati
- in che non siano presenti add_image_size non utilizzate: ogni immagine aggiuntiva occupa spazio su disco e, se non utilizzata, diventa un costo inutile

Se necessario è possibile utilizzare il plugin Regenerate Thumbnails per ridimentionare in bulk tutte le immagini caricate ed eliminare i ritagli non più utilizzati.

### Immagini del tema
Terminato il debug per ottimizzare le immagini utilizzte dal tema (logo header, file svg...) scaricare ed installare ImageOptim (https://imageoptim.com/mac) e trascinare nella finestra la cartella assets/images. ImageOptim ottimizzerà in automatico i file elencati.

### Font
Per Google Fonts - Adobe Fonts copiare il contenuto del foglio di stile fornito es.<br />
https://fonts.googleapis.com/css2?family=Atkinson+Hyperlegible:ital,wght@0,400;0,700;1,400;1,700&family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap<br />
e sostituire il contenuto del file assets/css/global/_theme-font.scss<br />
Terminato il debug aprire il file<br />
/includes/theme-performance.php<br />
ed aggiungere i font in preload in  nella funzione<br />
paperplane_preload_data -> $fonts_preload<br />
che è un array dei font da precaricare con le loro configurazioni.<br />
Se si utilizza Adobe Fonts non è possibile recuperare le URL dei font. Il passaggio successivo sarà quindi limitato al primo elemento dell'array.<br />
Per stabilire quali font precaricare:
- visualizzare una pagina del sito in Chrome
- aprire il pannello dev
- ricaricare la pagina
- aprire la tab Network o Rete
- filtrare per tipo di file font
- per ogni font copiare la URL "Request URL:" e aggiungerla all'array
- 'type' può essere 'preconnect' per la connessione al server dei font da usare come primo elemento dell'array
- 'font/woff2' per i file dei font specifici - utilizzare l'estensione corretta del font

## Strumenti CSS
- [Generatore gradiente CSS](https://cssgradient.io/)
- [Generatore Text Shadow CSS](https://css3gen.com/text-shadow/)
- [Generatore Border Radius CSS](https://css3gen.com/border-radius/)
- [Generatore Box Shadow CSS](https://css3gen.com/box-shadow/)
- [Come usare mixin con parametri](https://marksheet.io/sass-mixins.html)
