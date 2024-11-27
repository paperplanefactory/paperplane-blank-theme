<?php
if ( ! is_admin() ) {
	function add_style_attributes( $html, $handle ) {
		if ( 'paperplane-theme-font' === $handle ) {
			return str_replace( "media='all'", "media='all' crossorigin", $html );
		}
		return $html;
	}
	add_filter( 'style_loader_tag', 'add_style_attributes', 10, 2 );
	// load common css
	function paperplane_theme_css() {
		// versione del tema
		global $theme_version;
		// stili comuni
		// Per Google Fonts - Adobe Fonts copiare il contenuto del foglio di stile fornito
		// es.https://fonts.googleapis.com/css2?family=Atkinson+Hyperlegible:ital,wght@0,400;0,700;1,400;1,700&family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap
		// ed aggiungerlo al file assets/css/global/_theme-font.scss
		// terminato il debug aggiungere i font in preload in /includes/theme-performance.php nella funzione paperplane_preload_data -> $fonts_preload
		// Meglio specificare un array vuoto invece di stringa vuota
		wp_enqueue_style( 'paperplane-theme-common', get_template_directory_uri() . '/style.min.css', array(), $theme_version, 'all' );
	}
	add_action( 'wp_enqueue_scripts', 'paperplane_theme_css', 10, 3 );
}


function papperplane_disable_useless_styles() {
	wp_deregister_style( 'classic-theme-styles' );
	wp_dequeue_style( 'classic-theme-styles' );
	wp_dequeue_style( 'global-styles' );
	wp_dequeue_style( 'svg-icon-style-inline-css' );
	wp_dequeue_style( 'wp-block-library' );
	wp_dequeue_style( 'safe-svg-svg-icon-style' );
	wp_deregister_style( 'safe-svg-svg-icon-style' );
}
add_filter( 'wp_enqueue_scripts', 'papperplane_disable_useless_styles', 100 );