<?php
// Async load
function theme_async_styles( $url ) {
	if ( strpos( $url, '#asyncload' ) === false )
		return $url;
	else if ( is_admin() )
		return str_replace( '#asyncload', '', $url );
	else
		return str_replace( '#asyncload', '', $url ) . "' async='async";
}
add_filter( 'clean_url', 'theme_async_styles', 11, 1 );

if ( ! is_admin() ) {
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
		wp_enqueue_style( 'paperplane-theme-font', 'https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@400;700&family=Montserrat:ital,wght@0,400;0,700;1,400;1,700&display=swap#asyncload', array(), null );
		wp_enqueue_style( 'paperplane-theme-commnon', get_template_directory_uri() . '/style.min.css', '', $theme_version, 'all' );
		wp_enqueue_style( 'paperplane-material-icons', 'https://fonts.googleapis.com/icon?family=Material+Icons&display=swap', array(), null );
	}
	add_action( 'wp_enqueue_scripts', 'theme_css', 10, 3 );
}


function papperplane_disable_useless_styles() {
	wp_deregister_style( 'classic-theme-styles' );
	wp_dequeue_style( 'classic-theme-styles' );
}
add_filter( 'wp_enqueue_scripts', 'papperplane_disable_useless_styles', 100 );

add_filter( 'style_loader_tag', 'preload_filter', 10, 2 );
function preload_filter( $html, $handle ) {
	if ( strcmp( $handle, 'paperplane-theme-commnon' ) == 0 ) {
		$fallback = '<noscript>' . $html . '</noscript>';
		$preload = str_replace( "rel='stylesheet'", "rel='preload' as='style' onload='this.rel=\"stylesheet\"'", $html );
		$html = $preload . $fallback;
	}
	if ( strcmp( $handle, 'paperplane-theme-font' ) == 0 ) {
		$fallback = '<noscript>' . $html . '</noscript>';
		$preload = str_replace( "rel='stylesheet'", "rel='preload' as='style' onload='this.rel=\"stylesheet\"'", $html );
		$html = $preload . $fallback;
	}
	return $html;
}