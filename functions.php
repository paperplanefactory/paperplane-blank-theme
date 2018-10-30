<?php
// imposto la versione del tema
global $theme_version;
$theme_version = get_field( 'theme_version', 'option' );
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
// slides
include_once "functions/theme-slides.php";
// gestione tassonomie
include_once "functions/theme-taxonomies.php";
// infinite posts
//include_once "functions/theme-infinite-posts.php";


// gestione DetectMobile - stabilisco il device e creo le variabili globali da richiamare nei template e negli altri script del tema
add_action( 'wp_head', 'theme_detect_device');
function theme_detect_device() {
  require_once 'libraries/Mobile-Detect.php';
  global $isMobile;
  global $isTablet;
  global $isDesktop;
  $mobileDetect   = false;
  $isMobile       = false;
  $isTablet       = false;
  $isDesktop      = false;
  $mobileDetect   = new Mobile_Detect;
  $isTablet       = $mobileDetect->isTablet();
  $isMobile       = $mobileDetect->isMobile() && !$isTablet;
  $isDesktop      = !$isMobile && !$isTablet;
}
