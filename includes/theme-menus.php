<?php
// registro la gestione dei menu, esempio header e footer
function register_theme_menus() {
	register_nav_menus(
		array(
			'header-menu' => __( 'Header Menu' ),
			'footer-menu' => __( 'Footer Menu' ),
			'overlay-menu-desktop' => __( 'Overlay Menu Desktop' ),
			'overlay-menu-mobile' => __( 'Overlay Menu Mobile' ),
			'accessible-menu' => __( 'Menu per accessibilita' )
		)
	);
}
add_action( 'init', 'register_theme_menus' );
// registro la gestione dei menu, esempio header e footer
function register_theme_mega_menus() {
	$args_mega_menus = array(
		'post_type' => 'cpt_mega_menu',
		'posts_per_page' => -1
	);
	$my_filter_mega_menus = get_posts( $args_mega_menus );
	if ( ! empty( $my_filter_mega_menus ) ) {
		foreach ( $my_filter_mega_menus as $post ) {
			$menu_name = get_the_title( $post->ID );
			register_nav_menu( 'mega-menu-' . $post->ID . '', __( 'Mega Menu ' . $menu_name . '' ) );
		}
		wp_reset_postdata();
	}
}
add_action( 'init', 'register_theme_mega_menus' );



// necessita di ACF PRO - aggiunge pannelli per gestire ulteriori impostazioni del tema
if ( function_exists( 'acf_add_options_page' ) ) {
	// gestione tema per admin
	$option_page = acf_add_options_page(
		array(
			'page_title' => 'Theme General Settings',
			'menu_title' => 'Theme Settings',
			'menu_slug' => 'theme-general-settings',
			'capability' => 'update_core',
			'redirect' => false
		)
	);
	$parent = acf_add_options_page(
		array(
			'page_title' => 'Impostazioni sito',
			'menu_title' => 'Impostazioni sito',
			'capability' => 'edit_posts',
			//'menu_slug' 	=> 'impostazioni-sito',
			//'redirect'		=> false
		)
	);
	// social
	acf_add_options_sub_page(
		array(
			'page_title' => 'Gestione social',
			'menu_title' => 'Gestione social',
			'parent_slug' => $parent['menu_slug'],
		)
	);
	// verifico che sia attivo Polylang
	if ( function_exists( 'PLL' ) ) {
		$langs_parameters = array(
			'hide_empty' => 0,
			'fields' => 'slug'
		);
		$languages = pll_languages_list();
	} else {
		$languages = array( 'any-lang' );
	}
	foreach ( $languages as $lang ) {
		// gestione footer
		acf_add_options_sub_page(
			array(
				'page_title' => 'Gestione footer (' . strtoupper( $lang ) . ')',
				'menu_title' => __( 'Gestione footer (' . strtoupper( $lang ) . ')', 'text-domain' ),
				'menu_slug' => "gestione-footer-{$lang}",
				'post_id' => $lang,
				'parent_slug' => $parent['menu_slug'],
			)
		);
		// gestione archivi
		acf_add_options_sub_page(
			array(
				'page_title' => 'Gestione archivi (' . strtoupper( $lang ) . ')',
				'menu_title' => __( 'Gestione archivi (' . strtoupper( $lang ) . ')', 'text-domain' ),
				'menu_slug' => "gestione-archivi-{$lang}",
				'post_id' => $lang,
				'parent_slug' => $parent['menu_slug'],
			)
		);
	}
}

// show flamingo to editors
add_filter( 'flamingo_map_meta_cap', 'for_editors_flamingo_map_meta_cap' );
function for_editors_flamingo_map_meta_cap( $meta_caps ) {
	$meta_caps = array_merge(
		$meta_caps,
		array(
			'flamingo_edit_contacts' => 'edit_pages',
			'flamingo_edit_inbound_messages' => 'edit_pages',
		)
	);

	return $meta_caps;
}


add_action( 'admin_head', 'my_custom_acf' );
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
	if ( function_exists( 'wpfc_clear_all_cache' ) ) {
		wpfc_clear_all_cache( true );
	}
}
add_action( 'acf/save_post', 'options_page_clear_cache', 20 );

// collegamento voci menu - modal
function paperplane_add_modal_menu_atts( $atts, $item, $args ) {
	$acf_id_modal = get_field( 'acf_id_modal', $item );
	if ( $acf_id_modal ) {
		global $cta_url_modal_array;
		$cta_url_modal_array[] = $acf_id_modal;
		$start_point = paperplane_random_code();
		$atts['data-modal-open-id'] = $acf_id_modal;
		$atts['data-modal-back-to'] = $start_point;
		$atts['class'] = 'modal-open-js ' . $start_point;
		$atts['href'] = '#modal-focus-' . $acf_id_modal;
		$atts['aria-haspopup'] = 'true';
		$atts['aria-label'] = __( 'Questo link apre una finestra sovrapposta alla pagina', 'paperPlane-blankTheme' );
	}
	return $atts;
}
//add_filter( 'nav_menu_link_attributes', 'paperplane_add_modal_menu_atts', 10, 3 );

// collegamento voci menu - mega menu

function paperplane_add_mega_menu_atts( $atts, $item, $args ) {
	if ( $args->theme_location == 'header-menu' ) {
		$mega_menu_activator = get_field( 'mega_menu_activator', $item );
		if ( ! in_array( 'menu-item-has-children', $item->classes ) && $item->menu_item_parent == 0 ) {
			$atts['class'] = 'simple-link';
		}
		if ( $item->menu_item_parent && $item->menu_item_parent > 0 ) {
			$atts['class'] = 'child-link';
		}
	}
	return $atts;
}
add_filter( 'nav_menu_link_attributes', 'paperplane_add_mega_menu_atts', 10, 3 );

function paperplane_menu_items_as_buttons( $item_output, $item ) {
	$mega_menu_activator = get_field( 'mega_menu_activator', $item );
	$acf_id_modal = get_field( 'acf_id_modal', $item );
	if ( $mega_menu_activator ) {
		$item_output = '<button type="button" aria-expanded="false" haspopup="true" aria-controls="mega-menu-control-' . $mega_menu_activator[0] . '" id="mega-menu-controller-' . $mega_menu_activator[0] . '" class="nav-simple-button element-icon-after mega-menu-js-trigger mega-menu-js-' . $mega_menu_activator[0] . '-trigger" aria-controls="mega-menu-js-' . $mega_menu_activator[0] . '-target" data-megamenu-open-id="' . $mega_menu_activator[0] . '">' . $item->title . '</button>';
		ob_start();
		include( locate_template( 'template-parts/grid/mega-menu-single.php' ) );
		$item_output .= ob_get_clean();
	} elseif ( in_array( 'menu-item-has-children', $item->classes ) ) {
		$item_output = '<button type="button" aria-expanded="false" class="nav-simple-button element-icon-after sub-menu-btn">' . $item->title . '</button>';
	} elseif ( $acf_id_modal ) {
		global $cta_url_modal_array;
		$cta_url_modal_array[] = $acf_id_modal;
		$start_point = paperplane_random_code();
		$item_output = '<button type="button" aria-haspopup="true" aria-label="' . $item->title . ': ' . __( 'Apre una finestra sovrapposta alla pagina', 'paperPlane-blankTheme' ) . '" class="default-button modal-open-js ' . $start_point . '" data-modal-id="' . $acf_id_modal . '" data-modal-back-to="' . $start_point . '">' . $item->title . '</button>';
	}
	return $item_output;
}
add_filter( 'walker_nav_menu_start_el', 'paperplane_menu_items_as_buttons', 10, 3 );




// colori personalizzati preimpostati in WYSIWYG
function paperplane_wysiwyg_preset_colors( $init ) {
	$custom_colours = '
  "000000", "Colore 1",
  "333333", "Colore 2",
  "F2F2F2", "Colore 3"
  ';
	// build colour grid default+custom colors
	$init['textcolor_map'] = '[' . $custom_colours . ']';
	// change the number of rows in the grid if the number of colors changes
	// 8 swatches per row
	$init['textcolor_rows'] = 1;
	return $init;
}
add_filter( 'tiny_mce_before_init', 'paperplane_wysiwyg_preset_colors' );

function paperplane_random_code() {
	$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$string = '';

	for ( $i = 0; $i < 5; $i++ ) {
		$string .= $characters[ mt_rand( 0, strlen( $characters ) - 1 ) ];
	}

	return $string;
}