<?php
// Async load
function theme_async_styles( $url ) {
	if ( strpos( $url, '#asyncload' ) === false )
	return $url;
	else if ( is_admin() )
	return str_replace( '#asyncload', '', $url );
	else
	return str_replace( '#asyncload', '', $url )."' async='async";
}
add_filter( 'clean_url', 'theme_async_styles', 11, 1 );

if ( !is_admin() ) {
	function add_font_awesome_5_cdn_attributes( $html, $handle ) {
		if ( 'theme-font-awesome' === $handle ) {
			return str_replace( "media='all'", "media='all' integrity='sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf' crossorigin='anonymous' async='async'", $html );
		}
		return $html;
	}
	add_filter( 'style_loader_tag', 'add_font_awesome_5_cdn_attributes', 10, 2 );
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
		wp_enqueue_style( 'theme-commnon', get_template_directory_uri() . '/style.min.css', '', $theme_version, 'all' );
		wp_enqueue_style( 'theme-font', 'https://fonts.googleapis.com/css?family=Playfair+Display:400,400i,700,700i|Roboto:400,400i,700,700i#asyncload', '', $theme_version, 'all' );
		wp_enqueue_style( 'theme-font-awesome', 'https://use.fontawesome.com/releases/v5.8.1/css/all.css#asyncload', array(), null );
		// wp_enqueue_style( 'material-icons', 'https://fonts.googleapis.com/icon?family=Material+Icons', '', $theme_version, 'all' );
	}
	add_action( 'wp_enqueue_scripts', 'theme_css' );
}
