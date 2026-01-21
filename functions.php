<?php
global $theme_version, $attivare_pwa;
$theme_version = get_field( 'theme_version', 'option' );
$attivare_pwa = get_field( 'attivare_pwa', 'option' );
global $theme_pagination;
$theme_pagination = get_field( 'theme_pagination', 'option' );
// Gestione caricamento CSS
require_once get_template_directory() . '/includes/theme-stylesloader.php';
// Gestione caricamento script
require_once get_template_directory() . '/includes/theme-scriptsloader.php';
// Disabilitazione funzionalità WordPress
require_once get_template_directory() . '/includes/theme-wordpress-disableds.php';
// Gestione transients
require_once get_template_directory() . '/includes/theme-transients.php';
// Gestione ritagli immagini
require_once get_template_directory() . '/includes/theme-images-crop.php';
// Gestione immagini
require_once get_template_directory() . '/includes/theme-images-grab.php';
// Gestione trim testi
require_once get_template_directory() . '/includes/theme-txts.php';
// Gestione core WordPress
require_once get_template_directory() . '/includes/theme-messages.php';
// Custom menus
require_once get_template_directory() . '/includes/theme-menus.php';
// Gestione tassonomie
require_once get_template_directory() . '/includes/theme-taxonomies.php';
// Gestione tipo di paginazione
require_once get_template_directory() . '/includes/theme-pagination.php';
// Gestione CTA
require_once get_template_directory() . '/includes/theme-component-ctas.php';
// Gestione expanding text
require_once get_template_directory() . '/includes/theme-component-expanding-text.php';
// Gestione videos
require_once get_template_directory() . '/includes/theme-component-videos.php';
// Configurazione aperture pagina (deve essere caricato prima di theme-performance)
require_once get_template_directory() . '/includes/theme-page-opening-config.php';
// Performance e preload
require_once get_template_directory() . '/includes/theme-performance.php';
// PWA
require_once get_template_directory() . '/includes/theme-pwa.php';
// Maintenance page
require_once get_template_directory() . '/includes/theme-maintenance.php';
// CF7 Forms
require_once get_template_directory() . '/includes/theme-cf7-forms.php';
// Paste cleaner
require_once get_template_directory() . '/includes/theme-paste-cleaner.php';
// Improved search
require_once get_template_directory() . '/includes/theme-search.php';
// attivo le traduzioni
function paperplane_theme_load_theme_textdomain() {
	load_theme_textdomain( 'paperPlane-blankTheme', get_template_directory() . '/languages' );
}
add_action( 'after_setup_theme', 'paperplane_theme_load_theme_textdomain' );
