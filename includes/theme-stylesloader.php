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
		wp_enqueue_style( 'theme-font', 'https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@400;700&family=Montserrat:ital,wght@0,400;0,700;1,400;1,700&display=swap#asyncload', array(), null );
		wp_enqueue_style( 'theme-commnon', get_template_directory_uri() . '/style.min.css', '', $theme_version, 'all' );
		wp_enqueue_style( 'material-icons', 'https://fonts.googleapis.com/icon?family=Material+Icons&display=swap', array(), null );
	}
	add_action( 'wp_enqueue_scripts', 'theme_css' );
}

function paperplane_images_add_meta_tags() {
	$preload_fonts_meta = '';
	$preload_fonts_meta .= '<link rel="preload" href="' . get_bloginfo( 'stylesheet_directory' ) . '/assets/fonts/paperplane-blank-theme-social-icons.eot" as="font" />' . "\n";
	$preload_fonts_meta .= '<link rel="preload" href="' . get_bloginfo( 'stylesheet_directory' ) . '/assets/fonts/paperplane-blank-theme-social-icons.svg" as="font" />' . "\n";
	$preload_fonts_meta .= '<link rel="preload" href="' . get_bloginfo( 'stylesheet_directory' ) . '/assets/fonts/paperplane-blank-theme-social-icons.ttf" as="font" />' . "\n";
	$preload_fonts_meta .= '<link rel="preload" href="' . get_bloginfo( 'stylesheet_directory' ) . '/assets/fonts/paperplane-blank-theme-social-icons.woff" as="font" />' . "\n";
	$preload_fonts_meta .= '<link rel="preload" href="' . get_bloginfo( 'stylesheet_directory' ) . '/assets/fonts/paperplane-blank-theme-social-icons.woff2" as="font" />' . "\n";
	echo $preload_fonts_meta;
}
//add_action('wp_head', 'paperplane_images_add_meta_tags');