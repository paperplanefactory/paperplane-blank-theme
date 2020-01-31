<?php
// imposto la versione del tema
global $theme_version;
if( class_exists('acf') ) {
  $theme_version = get_transient( 'theme_force_cache' );
  if ( false === $theme_version ) {
    $theme_version_value = get_field( 'theme_version', 'option' );
    set_transient( 'theme_force_cache', $theme_version_value, 0 );
  }
  function clear_theme_force_cache() {
  	$screen = get_current_screen();
  	if (strpos($screen->id, "theme-general-settings") == true) {
  		delete_transient('theme_force_cache');
  	}
  }
  add_action('acf/save_post', 'clear_theme_force_cache', 20);
}
