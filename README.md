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
- [Come usare mixin con parametri](https://marksheet.io/sass-mixins.html)

## Immagini
Il resize delle immagini e altre impostazioni si trovano in:

includes/theme-images-crop.php

Le funzioni per utilizzare le immagini nel tema si trovano in:

includes/theme-images-grab.php

Altri esempi per gestire le immagini con post thumbnail e ACF:

sample-blocks/images.php
