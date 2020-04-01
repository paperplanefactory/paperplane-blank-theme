<?php
// Async load
function theme_async_scripts( $url ) {
  if ( strpos( $url, '#asyncload' ) === false )
  return $url;
  else if ( is_admin() )
  return str_replace( '#asyncload', '', $url );
  else
  return str_replace( '#asyncload', '', $url )."' async='async";
}
add_filter( 'clean_url', 'theme_async_scripts', 11, 1 );

// Defer load
function theme_defer_scripts( $url ) {
  if ( strpos( $url, '#deferload' ) === false )
  return $url;
  else if ( is_admin() )
  return str_replace( '#deferload', '', $url );
  else
  return str_replace( '#deferload', '', $url )."' defer='defer";
}
add_filter( 'clean_url', 'theme_defer_scripts', 11, 1 );

// All scripts
add_action( 'wp_enqueue_scripts', 'all_scripts' );
function all_scripts(){
  // versione del tema
	global $theme_version;
  // smart jquery inclusion
  if (!is_admin()) {
  	wp_deregister_script('jquery');
  	wp_register_script('jquery', get_template_directory_uri() . '/assets/js/libs/jquery-3.4.1.min.js', '', '3.4.1', false);
  	wp_enqueue_script('jquery');
  }
  // Infinite Scroll
  // documentazione: https://infinite-scroll.com/
  wp_register_script( 'custom-infinitescroll', get_template_directory_uri() . '/assets/js/libs/infinite-scroll.min.js#deferload', '', '3.0.6', false);
  wp_enqueue_script( 'custom-infinitescroll' );

  // Lazy load
  // documentazione: http://www.andreaverlicchi.eu/lazyload/
  wp_register_script( 'vanilla-lazyload', get_template_directory_uri() . '/assets/js/libs/lazyload.min.js#deferload', '', '14.0.0', true);
  wp_enqueue_script( 'vanilla-lazyload' );

  // AOS
  // documentazione: https://github.com/michalsnik/aos
  wp_register_script( 'theme-aos', get_template_directory_uri() . '/assets/js/libs/aos.min.js#deferload', '', $theme_version, true);
  wp_enqueue_script( 'theme-aos' );

  // slick
  // documentazione: https://github.com/kenwheeler/slick
  wp_register_script( 'slick', get_template_directory_uri() . '/assets/js/libs/slick.min.js#deferload', '', $theme_version, false);
	wp_enqueue_script( 'slick' );

  // parallasse
  // documentazione: https://github.com/dixonandmoe/rellax
	// wp_register_script( 'js-parallax', get_template_directory_uri() . '/assets/js/libs/rellax.min.js', '', '1.10.0', false);
	// wp_enqueue_script( 'js-parallax' );

  // FontAwesome
  // documentazione: https://fontawesome.com/
	// wp_register_script( 'theme-fontawesome', 'https://kit.fontawesome.com/2ab89a2041.js#deferload', '', $theme_version, true);
	// wp_enqueue_script( 'theme-fontawesome' );

  // Comportamenti ricorrenti
	wp_register_script( 'theme-general', get_template_directory_uri() . '/assets/js/theme-general.min.js#deferload', '', $theme_version, true);
	wp_enqueue_script( 'theme-general' );
}
