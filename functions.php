<?php
// imposto la versione del tema
global $theme_version;
if( class_exists('acf') ) {
  $theme_version = get_field( 'theme_version', 'option' );
}
// gestione caricamento css
include_once "includes/theme-stylesloader.php";
// gestione caricamento script
include_once "includes/theme-scriptsloader.php";
// gestione immagini
include_once "includes/theme-images.php";
// lazy load
include_once "includes/theme-lazyload.php";
// gestione trim testi
include_once "includes/theme-txts.php";
// gestione core WordPress
include_once "includes/theme-messages.php";
// custom menus
include_once "includes/theme-menus.php";
// embedded ACF version and info
include_once "includes/theme-embedded-acf-version-and-info.php";
// embedded ACF social
include_once "includes/theme-embedded-acf-social.php";
// embedded ACF parnters and sponsors
include_once "includes/theme-embedded-acf-parnters-sponsors.php";
// gestione tassonomie
include_once "includes/theme-taxonomies.php";
// transients killer
include_once "includes/theme-transients-killer.php";
// gestione cookies
//include_once "functions/theme-cookies-handler.php";
// infinite posts
//include_once "functions/theme-infinite-posts.php";

//load_theme_textdomain( 'paperplane-theme', '/languages' );
load_theme_textdomain( 'paperplane-theme', TEMPLATEPATH.'/languages' );
