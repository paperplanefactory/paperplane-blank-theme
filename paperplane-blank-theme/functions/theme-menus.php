<?php
// registro la gestione dei menu, esempio header e footer
function register_theme_menus() {
  register_nav_menus(
    array(
      'header-menu' => __( 'Header Menu' ),
      'footer-menu' => __( 'Footer Menu' )
    )
  );
}
add_action( 'init', 'register_theme_menus' );

// necessita di ACF PRO - aggiunge un pannello per gestire ulteriori impostazioni del tema
if( function_exists('acf_add_options_page') ) {
  // gestione tema per admin
  $option_page = acf_add_options_page(array(
		'page_title' 	=> 'Theme General Settings',
		'menu_title' 	=> 'Theme Settings',
		'menu_slug' 	=> 'theme-general-settings',
		'capability' 	=> 'update_core',
		'redirect' 	=> false
	));
  $parent = acf_add_options_page(array(
    'page_title' 	=> 'Impostazioni sito',
		'menu_title'	=> 'Impostazioni sito',
		'capability'	=> 'edit_posts',
		//'menu_slug' 	=> 'impostazioni-sito',
		//'redirect'		=> false
	));
  // social
	acf_add_options_sub_page(array(
		'page_title' 	=> 'Gestione social',
		'menu_title' 	=> 'Gestione social',
		'parent_slug' 	=> $parent['menu_slug'],
	));
  // partner / sponsor
	acf_add_options_sub_page(array(
		'page_title' 	=> 'Gestione partner / sponsor',
		'menu_title' 	=> 'Gestione partner / sponsor',
		'parent_slug' 	=> $parent['menu_slug'],
	));
  // verifico che sia attivo Polylang
  if ( function_exists( 'PLL' ) ) {
    $langs_parameters = array(
      'hide_empty' => 0,
      'fields' => 'slug'
    );
    $languages = pll_languages_list($args);
  }
  else {
    $languages = array('any-lang');
  }
  foreach ( $languages as $lang ) {
    // gestione programma
  	acf_add_options_sub_page( array (
      'page_title' => 'Gestione programma (' . strtoupper( $lang ) . ')',
      'menu_title' => __('Gestione programma (' . strtoupper( $lang ) . ')', 'text-domain'),
      'menu_slug'  => "gestione-programma-${lang}",
      'post_id'    => $lang,
      'parent_slug' 	=> $parent['menu_slug'],
  	) );
    // gestione cookie GDPR
  	acf_add_options_sub_page( array (
      'page_title' => 'Gestione cookie GDPR (' . strtoupper( $lang ) . ')',
      'menu_title' => __('Gestione cookie GDPR (' . strtoupper( $lang ) . ')', 'text-domain'),
      'menu_slug'  => "gestione-cookie-gdpr-${lang}",
      'post_id'    => $lang,
      'parent_slug' 	=> $parent['menu_slug'],
  	) );
  }

}
