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
		wp_enqueue_style( 'paperplane-theme-font', 'https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@400;700&family=Montserrat:ital,wght@0,400;0,700;1,400;1,700&display=swap', array(), null );
		wp_enqueue_style( 'paperplane-theme-commnon', get_template_directory_uri() . '/style.min.css', '', $theme_version, 'all' );
		// se non si usano Google Font rimuovere le 2 righe con il meta preconnect a Google dalla funzione paperplane_preload_self_hosted_fonts()
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


function paperplane_preload_self_hosted_fonts() {
	$static_bloginfo_stylesheet_directory = get_bloginfo( 'stylesheet_directory' );
	$preload_fonts_meta = '<link rel="preconnect" href="https://fonts.googleapis.com" crossorigin />' . "\n";
	$preload_fonts_meta .= '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />' . "\n";
	$preload_fonts_meta .= '<link rel="prefetch" href="https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@400;700&family=Montserrat:ital,wght@0,400;0,700;1,400;1,700" as="style" crossorigin />' . "\n";
	$preload_fonts_meta .= '<link rel="preload" href="' . $static_bloginfo_stylesheet_directory . '/assets/fonts/material-icons/MaterialIcons-Regular.ttf" as="font" crossorigin />' . "\n";
	echo $preload_fonts_meta;
}
add_action( 'wp_head', 'paperplane_preload_self_hosted_fonts', 1 );