<?php
if ( ! is_admin() ) {
	function add_style_attributes( $html, $handle ) {

		if ( 'paperplane-theme-font' === $handle ) {
			return str_replace( "media='all'", "media='all' crossorigin", $html );
		}
		return $html;
	}
	add_filter( 'style_loader_tag', 'add_style_attributes', 10, 2 );
	//Disable Gutenberg style in Front
	function wps_deregister_styles() {
		wp_dequeue_style( 'wp-block-library' );
	}
	add_action( 'wp_print_styles', 'wps_deregister_styles', 100 );
	// load common css
	function theme_css() {
		// versione del tema
		global $theme_version;
		// stili comuni
		wp_enqueue_style( 'paperplane-theme-font', 'https://fonts.googleapis.com/css2?family=Atkinson+Hyperlegible:ital,wght@0,400;0,700;1,400;1,700&family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap', array(), null );
		// se non si usano Google Font rimuovere la riga sopra
		// se si usano è possibile usare il CSS del link Google come parziale del tema e commentare la riga
		wp_enqueue_style( 'paperplane-theme-commnon', get_template_directory_uri() . '/style.min.css', '', $theme_version, 'all' );
	}
	add_action( 'wp_enqueue_scripts', 'theme_css', 10, 3 );
}


function papperplane_disable_useless_styles() {
	wp_deregister_style( 'classic-theme-styles' );
	wp_dequeue_style( 'classic-theme-styles' );
	wp_dequeue_style( 'global-styles' );
	wp_dequeue_style( 'svg-icon-style-inline-css' );
}
add_filter( 'wp_enqueue_scripts', 'papperplane_disable_useless_styles', 100 );