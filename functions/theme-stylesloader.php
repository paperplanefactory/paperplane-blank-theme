<?php
if ( !is_admin() ) {
// load common css
function theme_css() {
	// versione del tema
	global $theme_version;
	// stabilisco il device
	global $isMobile;
	global $isTablet;
	global $isDesktop;

	// stili comuni
	wp_enqueue_style( 'theme-commnon', get_template_directory_uri() . '/style.min.css', '', $theme_version, 'all' );
	wp_enqueue_style( 'theme-font', 'https://fonts.googleapis.com/css?family=Playfair+Display:400,400i,700,700i|Roboto:400,400i,700,700i', '', $theme_version, 'all' );
	}
add_action( 'wp_enqueue_scripts', 'theme_css' );
}
