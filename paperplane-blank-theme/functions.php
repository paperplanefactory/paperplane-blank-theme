<?php
// imposto la versione del tema
global $theme_version;
if( class_exists('acf') ) {
  $theme_version = get_field( 'theme_version', 'option' );
}
// gestione caricamento css
include_once "functions/theme-stylesloader.php";
// gestione caricamento script
include_once "functions/theme-scriptsloader.php";
// gestione immagini
include_once "functions/theme-images.php";
// lazy load
include_once "functions/theme-lazyload.php";
// gestione trim testi
include_once "functions/theme-txts.php";
// gestione core WordPress
include_once "functions/theme-messages.php";
// custom menus
include_once "functions/theme-menus.php";
// embedded ACF
//include_once "functions/theme-embedded-acf.php";
// gestione tassonomie
include_once "functions/theme-taxonomies.php";
// gestione cookies
include_once "functions/theme-cookies-handler.php";
// infinite posts
//include_once "functions/theme-infinite-posts.php";

//load_theme_textdomain( 'paperplane-theme', '/languages' );
load_theme_textdomain( 'paperplane-theme', TEMPLATEPATH.'/languages' );
