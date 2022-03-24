<?php
// registro la gestione dei menu, esempio header e footer
function register_theme_menus() {
  register_nav_menus(
    array(
      'header-menu' => __( 'Header Menu' ),
      'footer-menu' => __( 'Footer Menu' ),
      'overlay-menu-desktop' => __ ( 'Overlay Menu Desktop' ),
      'overlay-menu-mobile' => __ ( 'Overlay Menu Mobile' )
    )
  );
}
add_action( 'init', 'register_theme_menus' );
// registro la gestione dei menu, esempio header e footer
function register_theme_mega_menus() {
  if (function_exists('pll_the_languages')) {
    $acf_options_parameter = pll_current_language('slug');
  }
  else {
    $acf_options_parameter = 'any-lang';
  }
  $mega_menu_counter = 0;
  if ( have_rows( 'mega_menu_repeater', $acf_options_parameter ) ) : while ( have_rows( 'mega_menu_repeater', $acf_options_parameter ) ) : the_row();
  $mega_menu_counter++;
  register_nav_menu( 'mega-menu-' . $mega_menu_counter . '', __( 'Mega Menu ' . $mega_menu_counter . '' ) );
  endwhile; endif;
}
add_action( 'init', 'register_theme_mega_menus' );



// necessita di ACF PRO - aggiunge pannelli per gestire ulteriori impostazioni del tema
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
      'page_title' => 'Gestione footer (' . strtoupper( $lang ) . ')',
      'menu_title' => __('Gestione footer (' . strtoupper( $lang ) . ')', 'text-domain'),
      'menu_slug'  => "gestione-footer-${lang}",
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
  $theme_external_scripts = get_field( 'theme_external_scripts', 'option');
  if ( $theme_external_scripts == 1 ) {
    foreach ( $languages as $lang ) {
      // gestione cookie GDPR
      acf_add_options_sub_page( array (
        'page_title' => 'Gestione script esterni (' . strtoupper( $lang ) . ')',
        'menu_title' => __('Gestione script esterni (' . strtoupper( $lang ) . ')', 'text-domain'),
        'menu_slug'  => "gestione-script-esterni-${lang}",
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



function options_page_clear_cache() {
  if (function_exists('wpfc_clear_all_cache')) {
    wpfc_clear_all_cache(true);
  }
}
add_action('acf/save_post', 'options_page_clear_cache', 20);

// collegamento voci menu - modal
function add_modal_menu_atts( $atts, $item, $args ) {
  $acf_id_modal = get_field('acf_id_modal', $item);
  if( $acf_id_modal ) {
    $cta_url_modal_array[] = $acf_id_modal;
    $atts['data-modal-open-id'] = '.paperplane-modal-js-' . $acf_id_modal;
    $atts['class'] = 'modal-open-js';

  }
  return $atts;
}
add_filter( 'nav_menu_link_attributes', 'add_modal_menu_atts', 10, 3 );

// colori personalizzati preimpostati in WYSIWYG
function paperplane_wysiwyg_preset_colors( $init ) {
  $custom_colours = '
  "000000", "Colore 1",
  "333333", "Colore 2",
  "F2F2F2", "Colore 3"
  ';
  // build colour grid default+custom colors
  $init['textcolor_map'] = '['.$custom_colours.']';
  // change the number of rows in the grid if the number of colors changes
  // 8 swatches per row
  $init['textcolor_rows'] = 1;
  return $init;
}
add_filter('tiny_mce_before_init', 'paperplane_wysiwyg_preset_colors');
