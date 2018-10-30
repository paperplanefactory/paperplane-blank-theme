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

// add google analytics to footer
add_action( 'wp_head', 'synth_google_analytics');
function synth_google_analytics() {
  if ( function_exists('cn_cookies_accepted') && cn_cookies_accepted() ) {
    // set in "Theme Geneal Option" page
    the_field( 'tracking_codes', 'options' );
  }
 }

// All scripts
add_action( 'wp_enqueue_scripts', 'all_scripts' );
function all_scripts(){
  // versione del tema
	global $theme_version;
  // smart jquery inclusion
  if (!is_admin()) {
  	wp_deregister_script('jquery');
  	wp_register_script('jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js', '', '3.2.1', false);
  	wp_enqueue_script('jquery');
  }
  // Infinite Scroll
  // documentazione: https://infinite-scroll.com/
  wp_register_script( 'custom-infinitescroll', 'https://cdnjs.cloudflare.com/ajax/libs/jquery-infinitescroll/3.0.3/infinite-scroll.pkgd.min.js#deferload', '', '3.0.3', false);
  wp_enqueue_script( 'custom-infinitescroll' );
  // Lazy load
  // documentazione: http://www.andreaverlicchi.eu/lazyload/
  wp_register_script( 'vanilla-lazyload', 'https://cdnjs.cloudflare.com/ajax/libs/vanilla-lazyload/8.6.0/lazyload.min.js', '', '8.6.0', false);
  wp_enqueue_script( 'vanilla-lazyload' );
	// Comportamenti ricorrenti
	wp_register_script( 'theme-general', get_stylesheet_directory_uri() . '/js/theme-general.min.js#deferload', '', $theme_version, true);
	wp_enqueue_script( 'theme-general' );
  // bxslider
  // documentazione: https://bxslider.com/
	wp_register_script( 'bxslider', 'https://cdnjs.cloudflare.com/ajax/libs/bxslider/4.2.12/jquery.bxslider.min.js#deferload', '', '4.2.12', true);
	wp_enqueue_script( 'bxslider' );
	}
