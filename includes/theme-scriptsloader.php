<?php
// Async load
function theme_async_scripts( $url ) {
	if ( strpos( $url, '#asyncload' ) === false )
		return $url;
	else if ( is_admin() )
		return str_replace( '#asyncload', '', $url );
	else
		return str_replace( '#asyncload', '', $url ) . "' async='async";
}
add_filter( 'clean_url', 'theme_async_scripts', 11, 1 );

// Defer load
function theme_defer_scripts( $url ) {
	if ( strpos( $url, '#deferload' ) === false )
		return $url;
	else if ( is_admin() )
		return str_replace( '#deferload', '', $url );
	else
		return str_replace( '#deferload', '', $url ) . "' defer='defer";
}
add_filter( 'clean_url', 'theme_defer_scripts', 11, 1 );

// All scripts

function paperplane_load_scripts() {
	// versione del tema
	global $theme_version, $theme_pagination;
	//$content_fields = paperplane_content_transients( $post->ID );
	// smart jquery inclusion
	if ( ! is_admin() ) {
		wp_deregister_script( 'jquery' );
		wp_register_script( 'jquery', get_template_directory_uri() . '/assets/js/libs/jquery-3.6.0.min.js', array(), '3.6.0', false );
		wp_enqueue_script( 'jquery' );
	}

	if ( $theme_pagination === 'theme-infinite-scroll' ) {
		// Infinite Scroll
		// documentazione: https://infinite-scroll.com/
		wp_register_script( 'theme-infinitescroll', get_template_directory_uri() . '/assets/js/libs/infinite-scroll.min.js#deferload', array( 'jquery' ), '4.0.1', true );
		wp_enqueue_script( 'theme-infinitescroll' );
	}
	// Vimeo API
	wp_register_script( 'vimeo-api', 'https://player.vimeo.com/api/player.js#deferload', array( 'jquery' ), '4.0.1', true );
	wp_enqueue_script( 'vimeo-api' );
	//wp_register_script('youtube-api', 'https://www.youtube.com/iframe_api#deferload', array('jquery'), '4.0.1', true);
	//wp_enqueue_script('youtube-api');

	// AOS
	// documentazione: https://github.com/michalsnik/aos
	wp_register_script( 'theme-aos', get_template_directory_uri() . '/assets/js/libs/aos.min.js#deferload', array( 'jquery' ), $theme_version, true );
	wp_enqueue_script( 'theme-aos' );

	// slick
	// documentazione: https://github.com/kenwheeler/slick
	wp_register_script( 'slick', get_template_directory_uri() . '/assets/js/libs/slick.min.js#deferload', array( 'jquery' ), $theme_version, true );
	wp_enqueue_script( 'slick' );

	// parallasse
	// documentazione: https://github.com/dixonandmoe/rellax
	// wp_register_script( 'js-parallax', get_template_directory_uri() . '/assets/js/libs/rellax.min.js', '', '1.10.0', false);
	// wp_enqueue_script( 'js-parallax' );

	// Comportamenti ricorrenti
	wp_register_script( 'theme-general', get_template_directory_uri() . '/assets/js/theme-general.min.js#deferload', array( 'jquery' ), $theme_version, true );
	wp_enqueue_script( 'theme-general' );
}

add_action( 'wp_enqueue_scripts', 'paperplane_load_scripts' );