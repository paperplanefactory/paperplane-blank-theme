<?php
global $theme_version, $attivare_pwa;
$theme_version = get_field( 'theme_version', 'option' );
$attivare_pwa = get_field( 'attivare_pwa', 'option' );
global $theme_pagination;
$theme_pagination = get_field( 'theme_pagination', 'option' );
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
// gestione tassonomie
include_once "includes/theme-taxonomies.php";
// gestione tipo di paginazione
include_once "includes/theme-pagination.php";
// gestione CTA
include_once "includes/theme-ctas.php";
// gestione videos
include_once "includes/theme-videos.php";
// gestione transients
include_once "includes/theme-transients.php";
// PWA
include_once "includes/theme-pwa.php";
// Maintenance page
include_once "includes/theme-maintenance.php";
// CF7 Forms
include_once "includes/theme-cf7-forms.php";
// Performance
include_once "includes/theme-performance.php";
// A/B testing
include_once "includes/theme-ab-testing.php";
// attivo le traduzioni
function paperplane_theme_load_theme_textdomain() {
	load_theme_textdomain( 'paperPlane-blankTheme', get_template_directory() . '/languages' );
}
add_action( 'after_setup_theme', 'paperplane_theme_load_theme_textdomain' );