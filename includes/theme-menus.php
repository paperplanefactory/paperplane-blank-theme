<?php
// registro la gestione dei menu, esempio header e footer
function register_theme_menus() {
	register_nav_menus(
		array(
			'header-menu' => esc_html__( 'Header Menu' ),
			'overlay-menu-desktop' => esc_html__( 'Overlay Menu Desktop' ),
			'overlay-menu-mobile' => esc_html__( 'Overlay Menu Mobile' ),
			'footer-menu' => esc_html__( 'Footer Menu' )
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
			register_nav_menu( 'mega-menu-' . $post->ID . '', esc_html__( 'Mega Menu ' . $menu_name . '' ) );
		}
		wp_reset_postdata();
	}
}
add_action( 'init', 'register_theme_mega_menus' );


function setup_theme_acf_options() {
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
			if ( $lang == 'any-lang' ) {
				$lang_menu_label = '';
			} else {
				$lang_menu_label = ' (' . strtoupper( $lang ) . ')';
			}
			// gestione header
			acf_add_options_sub_page(
				array(
					'page_title' => 'Gestione header (' . strtoupper( $lang ) . ')',
					'menu_title' => esc_html__( 'Gestione header' . $lang_menu_label, 'paperPlane-blankTheme' ),
					'menu_slug' => "gestione-header-{$lang}",
					'post_id' => $lang,
					'parent_slug' => $parent['menu_slug'],
				)
			);
			// gestione footer
			acf_add_options_sub_page(
				array(
					'page_title' => 'Gestione footer (' . strtoupper( $lang ) . ')',
					'menu_title' => esc_html__( 'Gestione footer' . $lang_menu_label, 'paperPlane-blankTheme' ),
					'menu_slug' => "gestione-footer-{$lang}",
					'post_id' => $lang,
					'parent_slug' => $parent['menu_slug'],
				)
			);
			// gestione archivi
			acf_add_options_sub_page(
				array(
					'page_title' => 'Gestione archivi (' . strtoupper( $lang ) . ')',
					'menu_title' => esc_html__( 'Gestione archivi ' . $lang_menu_label, 'paperPlane-blankTheme' ),
					'menu_slug' => "gestione-archivi-{$lang}",
					'post_id' => $lang,
					'parent_slug' => $parent['menu_slug'],
				)
			);
		}
		// social
		acf_add_options_sub_page(
			array(
				'page_title' => 'Gestione social',
				'menu_title' => 'Gestione social',
				'parent_slug' => $parent['menu_slug'],
			)
		);
	}
}

// Esegui la funzione durante l'hook init
add_action( 'init', 'setup_theme_acf_options' );

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
		$atts['aria-label'] = esc_html__( 'Questo link apre una finestra sovrapposta alla pagina', 'paperPlane-blankTheme' );
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

class Paperplane_Accessible_Walker extends Walker_Nav_Menu {

	private $current_parent_id = null;

	// Cattura l'ID del parent prima di generare il submenu
	function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
		// Salva l'ID del parent se ha children
		if ( in_array( 'menu-item-has-children', $item->classes ) ) {
			$this->current_parent_id = $item->ID;
		}

		// Chiama il parent per generare il normale output
		parent::start_el( $output, $item, $depth, $args, $id );
	}

	// Modifica l'apertura del submenu
	function start_lvl( &$output, $depth = 0, $args = null ) {
		$indent = str_repeat( "\t", $depth );

		// Determina il contesto in base al menu
		$context = 'desktop'; // default
		if ( isset( $args->theme_location ) && $args->theme_location === 'overlay-menu-mobile' ) {
			$context = 'mobile';
		}

		if ( $this->current_parent_id ) {
			$submenu_id = 'sub-menu-' . $this->current_parent_id;
			$button_id = 'menu-button-' . $this->current_parent_id;
			$output .= "\n{$indent}<ul class=\"sub-menu\" role=\"navigation\" id=\"{$submenu_id}\" aria-labelledby=\"{$button_id}\" data-menu-type=\"{$context}\">\n";
		} else {
			$output .= "\n{$indent}<ul class=\"sub-menu\" data-menu-type=\"{$context}\">\n";
		}
	}
}

function paperplane_menu_items_as_buttons( $item_output, $item, $depth, $args ) {
	$mega_menu_activator = get_field( 'mega_menu_activator', $item );
	$acf_id_modal = get_field( 'acf_id_modal', $item );

	// Determina il contesto in base al menu
	$context = 'desktop'; // default
	if ( isset( $args->theme_location ) && $args->theme_location === 'overlay-menu-mobile' ) {
		$context = 'mobile';
	}

	if ( $mega_menu_activator ) {
		$item_output = '<button type="button" aria-expanded="false" aria-haspopup="true" aria-controls="mega-menu-control-' . $mega_menu_activator[0] . '" id="mega-menu-controller-' . $mega_menu_activator[0] . '" class="nav-simple-button element-icon-after mega-menu-js-trigger mega-menu-js-' . $mega_menu_activator[0] . '-trigger" aria-controls="mega-menu-js-' . $mega_menu_activator[0] . '-target" data-megamenu-open-id="' . $mega_menu_activator[0] . '" data-menu-type="' . $context . '">' . $item->title . '</button>';
		ob_start();
		include( locate_template( 'template-parts/grid/mega-menu-single.php' ) );
		$item_output .= ob_get_clean();

	} elseif ( in_array( 'menu-item-has-children', $item->classes ) ) {
		$unique_id = 'menu-button-' . $item->ID;
		$submenu_id = 'sub-menu-' . $item->ID;

		$item_output = '<button type="button" aria-expanded="false" id="' . $unique_id . '" aria-controls="' . $submenu_id . '" class="nav-simple-button element-icon-after sub-menu-btn" data-menu-type="' . $context . '">' . $item->title . '</button>';

	} elseif ( $acf_id_modal ) {
		global $cta_url_modal_array;
		$cta_url_modal_array[] = $acf_id_modal;
		$start_point = paperplane_random_code();
		$item_output = '<button type="button" aria-haspopup="true" aria-label="' . $item->title . ': ' . esc_html__( 'Apre una finestra sovrapposta alla pagina', 'paperPlane-blankTheme' ) . '" class="default-button modal-open-js ' . $start_point . '" data-modal-id="' . $acf_id_modal . '" data-modal-back-to="' . $start_point . '">' . $item->title . '</button>';
	}

	return $item_output;
}
add_filter( 'walker_nav_menu_start_el', 'paperplane_menu_items_as_buttons', 10, 4 );

function paperplane_submenu_attributes( $output, $depth, $args ) {
	// Determina il contesto in base al menu
	$context = 'desktop'; // default
	if ( isset( $args->theme_location ) && $args->theme_location === 'overlay-menu-mobile' ) {
		$context = 'mobile';
	}

	if ( $depth === 0 ) {
		// Aggiungi data-menu-type al <ul class="sub-menu">
		$output = str_replace(
			'<ul class="sub-menu">',
			'<ul class="sub-menu" data-menu-type="' . $context . '">',
			$output
		);
	}
	return $output;
}
//add_filter( 'walker_nav_menu_start_lvl', 'paperplane_submenu_attributes', 10, 3 );




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
	$chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$code = '';

	for ( $i = 0; $i < 5; $i++ ) {
		$code .= $chars[ random_int( 0, strlen( $chars ) - 1 ) ];
	}

	return $code;
}

// Template di pagina predefinito MODULI
function module_page_template_default() {
	global $post;
	if ( 'page' == $post->post_type
		&& 0 != count( get_page_templates( $post ) )
		&& get_option( 'page_for_posts' ) != $post->ID // Not the page for listing posts
		&& '' == $post->page_template // Only when page_template is not set
	) {
		$post->page_template = "page-modules.php";
	}
}
add_action( 'add_meta_boxes', 'module_page_template_default', 1 );


function allow_editor_manage_menus() {
	// Ottieni il ruolo "editor"
	$role = get_role( 'editor' );

	// Verifica se il ruolo esiste e non ha già il permesso di modificare le opzioni del tema
	if ( $role && ! $role->has_cap( 'edit_theme_options' ) ) {
		// Aggiungi la capability "edit_theme_options" agli editor
		$role->add_cap( 'edit_theme_options' );
	}
}
// Usa l'hook 'init' per eseguire questa funzione quando WordPress si inizializza
// add_action( 'init', 'allow_editor_manage_menus' );

function papeplane_compile_privacy_cookies() {
	if ( function_exists( 'pll_the_languages' ) ) {
		$acf_options_parameter = pll_current_language( 'slug' );
	} else {
		$acf_options_parameter = 'any-lang';
	}
	$options_fields_multilang = paperplane_options_transients_multilanguage( $acf_options_parameter );
	$anno = date( 'Y' );
	$pagina_privacy_policy = '';
	if ( $options_fields_multilang['pagina_privacy_policy'] ?? null ) {
		$pagina_privacy_policy = $options_fields_multilang['pagina_privacy_policy'];
	}
	$pagina_cookie_policy = '';
	if ( $options_fields_multilang['pagina_cookie_policy'] ?? null ) {
		$pagina_cookie_policy = $options_fields_multilang['pagina_cookie_policy'];
	}
	add_action( 'wp_footer', function () use ($anno, $pagina_privacy_policy, $pagina_cookie_policy) {
		?>
		<script>
			document.addEventListener('DOMContentLoaded', function () {
				// Aggiunta del link privacy policy
				document.querySelectorAll('.privacy-link-js').forEach(link => {
					link.href = '<?php echo $pagina_privacy_policy; ?>';
				});
				// Aggiunta del link cookie policy
				document.querySelectorAll('.cookie-link-js').forEach(link => {
					link.href = '<?php echo $pagina_cookie_policy; ?>';
				});
				// Aggiunta anno (footer)
				document.querySelectorAll('.year-set-js').forEach(span => {
					span.textContent = '<?php echo $anno; ?>';
				});
			});
		</script>
		<?php
	} );
}

add_action( 'init', 'papeplane_compile_privacy_cookies' );