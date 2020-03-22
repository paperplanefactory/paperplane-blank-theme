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
    // gestione cookie GDPR
    acf_add_options_sub_page( array (
      'page_title' => 'Opzioni eventuali (' . strtoupper( $lang ) . ')',
      'menu_title' => __('Opzioni eventuali (' . strtoupper( $lang ) . ')', 'text-domain'),
      'menu_slug'  => "opzioni-eventuali-${lang}",
      'post_id'    => $lang,
      'parent_slug'     => $parent['menu_slug'],
    ) );
  }
  $use_mega_menus = get_field( 'use_mega_menus', 'option');
  if ( $use_mega_menus == 1 ) {
    foreach ( $languages as $lang ) {
      // gestione cookie GDPR
      acf_add_options_sub_page( array (
        'page_title' => 'Gestione mega menu (' . strtoupper( $lang ) . ')',
        'menu_title' => __('Gestione mega menu (' . strtoupper( $lang ) . ')', 'text-domain'),
        'menu_slug'  => "gestione-mega-menu-${lang}",
        'post_id'    => $lang,
        'parent_slug'     => $parent['menu_slug'],
      ) );
    }
  }
}

// show flamingo to editors
add_filter( 'flamingo_map_meta_cap', 'for_editors_flamingo_map_meta_cap' );
function for_editors_flamingo_map_meta_cap( $meta_caps ) {
	$meta_caps = array_merge( $meta_caps, array(
		'flamingo_edit_contacts' => 'edit_pages',
		'flamingo_edit_inbound_messages' => 'edit_pages',
	) );

	return $meta_caps;
}


add_action('admin_head', 'my_custom_acf');
function my_custom_acf() {
  echo '<style>
  [data-name*="choose_module"] {
    background-color: #2867c5 !important;
    color: #FFFFFF;
  }
  .acf-label.acf-accordion-title, .acf-label.acf-accordion-title:hover  {
    background-color: #989898 !important;
    color: #000000;
  }


  </style>';
}
