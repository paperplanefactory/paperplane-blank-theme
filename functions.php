<?php
// gestione caching parameter per css e script
include_once "includes/theme-caching-parameter.php";
// gestione caricamento css
include_once "includes/theme-stylesloader.php";
// gestione caricamento script
include_once "includes/theme-scriptsloader.php";
// gestione ritagli immagini
include_once "includes/theme-images-crop.php";
// gestione immagini
include_once "includes/theme-images-grab.php";
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
// include_once "includes/theme-transients-killer.php";

// load_theme_textdomain( 'paperplane-theme', '/languages' );
load_theme_textdomain( 'paperplane-theme', TEMPLATEPATH.'/languages' );
