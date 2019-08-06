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

// add typekit to header
//add_action( 'wp_head', 'synth_typekit');
function synth_typekit() { ?>
  <script>
    (function(d) {
      var config = {
        kitId: 'oie3fdh',
        scriptTimeout: 3000,
        async: true
      },
      h=d.documentElement,t=setTimeout(function(){h.className=h.className.replace(/\bwf-loading\b/g,"")+" wf-inactive";},config.scriptTimeout),tk=d.createElement("script"),f=false,s=d.getElementsByTagName("script")[0],a;h.className+=" wf-loading";tk.src='https://use.typekit.net/'+config.kitId+'.js';tk.async=true;tk.onload=tk.onreadystatechange=function(){a=this.readyState;if(f||a&&a!="complete"&&a!="loaded")return;f=true;clearTimeout(t);try{Typekit.load(config)}catch(e){}};s.parentNode.insertBefore(tk,s)
    })(document);
  </script>
<?php }

// All scripts
add_action( 'wp_enqueue_scripts', 'all_scripts' );
function all_scripts(){
  // versione del tema
	global $theme_version;
  // smart jquery inclusion
  if (!is_admin()) {
  	wp_deregister_script('jquery');
  	wp_register_script('jquery', get_stylesheet_directory_uri() . '/assets/js/libs/jquery-3.4.1.min.js', '', '3.4.1', false);
  	wp_enqueue_script('jquery');
  }
  // Infinite Scroll
  // documentazione: https://infinite-scroll.com/
  // wp_register_script( 'custom-infinitescroll', 'https://cdnjs.cloudflare.com/ajax/libs/jquery-infinitescroll/3.0.5/infinite-scroll.pkgd.min.js#deferload', '', '3.0.5', false);
  // wp_enqueue_script( 'custom-infinitescroll' );
  // Lazy load
  // documentazione: http://www.andreaverlicchi.eu/lazyload/
  wp_register_script( 'vanilla-lazyload', get_stylesheet_directory_uri() . '/assets/js/libs/lazyload.min.js#deferload', '', '12.0.0', false);
  wp_enqueue_script( 'vanilla-lazyload' );
	// Comportamenti ricorrenti
	wp_register_script( 'theme-general', get_stylesheet_directory_uri() . '/assets/js/theme-general.min.js#deferload', '', $theme_version, true);
	wp_enqueue_script( 'theme-general' );
  // Cookies library
  // documentazione: https://github.com/js-cookie/js-cookie
	wp_register_script( 'js-cookie', get_stylesheet_directory_uri() . '/assets/js/libs/js.cookie.min.js', '', '2.2.0', false);
	wp_enqueue_script( 'js-cookie' );
  // bxslider
  // documentazione: https://bxslider.com/
	wp_register_script( 'bxslider', get_stylesheet_directory_uri() . '/assets/js/libs/jquery.bxslider.min.js#asyncload', '', '4.2.1d', true);
	wp_enqueue_script( 'bxslider' );
  wp_register_script( 'bxslider-activate', get_stylesheet_directory_uri() . '/assets/js/theme-slides.min.js#asyncload', '', $theme_version, true);
	wp_enqueue_script( 'bxslider-activate' );
  // FontAwesome
  // documentazione: https://fontawesome.com/
	// wp_register_script( 'theme-fontawesome', 'https://kit.fontawesome.com/2ab89a2041.js#deferload', '', $theme_version, true);
	// wp_enqueue_script( 'theme-fontawesome' );
  // gestione script CF7
  if ( is_page( array( 47, 562 ) ) ) {
    if ( function_exists( 'wpcf7_enqueue_scripts' ) ) {
        wpcf7_enqueue_scripts();
    }
  }
}
