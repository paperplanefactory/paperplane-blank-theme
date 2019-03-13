<?php
if ( !is_admin() ) {
// load common css
function theme_css() {
	// versione del tema
	global $theme_version;

	// stili comuni
	wp_enqueue_style( 'theme-commnon', get_template_directory_uri() . '/style.min.css', '', $theme_version, 'all' );
	wp_enqueue_style( 'theme-font', 'https://fonts.googleapis.com/css?family=Playfair+Display:400,400i,700,700i|Roboto:400,400i,700,700i', '', $theme_version, 'all' );
	wp_enqueue_style( 'theme-font-awesome', 'https://use.fontawesome.com/releases/v5.7.2/css/solid.css', '', '5.7.2', 'all' );
	wp_enqueue_style( 'theme-font-awesome-ore', 'https://use.fontawesome.com/releases/v5.7.2/css/fontawesome.css', '', '5.7.2', 'all' );
	// wp_enqueue_style( 'material-icons', 'https://fonts.googleapis.com/icon?family=Material+Icons', '', $theme_version, 'all' );
	}
add_action( 'wp_enqueue_scripts', 'theme_css' );
}
