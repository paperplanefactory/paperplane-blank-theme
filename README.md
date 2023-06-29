# paperplane-blank-theme - a starter theme

## Primi passaggi
1. rinominare la cartella del tema es. cliente-theme
2. cancellare le cartelle di GitHub
3. creare la nuova repository su GitHub
4. compilare il file style.css modificando il parametro "Text Domain: paperPlane-blankTheme" e i link alla repository su GitHub
5. se alcuni CPT (banner o modal) non sono necessari impostare su "falso" l'opzione "Mostra UI" ne lplugin CPT UI e verificare di toglielo nei campi di ACF (es. CTA) 

## Strumenti CSS
- [Generatore gradiente CSS](https://cssgradient.io/)
- [Generatore Text Shadow CSS](https://css3gen.com/text-shadow/)
- [Generatore Border Radius CSS](https://css3gen.com/border-radius/)
- [Generatore Box Shadow CSS](https://css3gen.com/box-shadow/)
- [Come usare mixin con parametri](https://marksheet.io/sass-mixins.html)

## Immagini
Il resize delle immagini e altre impostazioni si trovano in:

includes/theme-images-crop.php

Le funzioni per utilizzare le immagini nel tema si trovano in:

includes/theme-images-grab.php

Altri esempi per gestire le immagini con post thumbnail e ACF:

sample-blocks/images.php

## Colore navigazione browser
Impostare il colore per i browser in questi tag presenti nel file header.php
<meta name="theme-color" content="#000000">
<meta name="msapplication-navbutton-color" content="#000000">
<meta name="apple-mobile-web-app-status-bar-style" content="#000000">
