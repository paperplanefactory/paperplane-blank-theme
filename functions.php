<?php
global $theme_version, $attivare_pwa;
$theme_version = get_field( 'theme_version', 'option' );
$attivare_pwa = get_field( 'attivare_pwa', 'option' );
global $theme_pagination;
$theme_pagination = get_field( 'theme_pagination', 'option' );
// gestione caricamento css
include_once "includes/theme-stylesloader.php";
// gestione caricamento script
include_once "includes/theme-scriptsloader.php";
// gestione ritagli immagini
include_once "includes/theme-images-crop.php";
// gestione immagini
include_once "includes/theme-images-grab.php";
// lazy load
include_once "includes/theme-lazyload.php";
// gestione trim testi
include_once "includes/theme-txts.php";
// gestione core WordPress
include_once "includes/theme-messages.php";
// custom menus
include_once "includes/theme-menus.php";
// gestione tassonomie
include_once "includes/theme-taxonomies.php";
// gestione tipo di paginazione
include_once "includes/theme-pagination.php";
// gestione CTA
include_once "includes/theme-ctas.php";
// gestione videos
include_once "includes/theme-videos.php";
// gestione transients
include_once "includes/theme-transients.php";
// PWA
include_once "includes/theme-pwa.php";
// Maintenance page
include_once "includes/theme-maintenance.php";
// CF7 Forms
include_once "includes/theme-cf7-forms.php";
// Performance
include_once "includes/theme-performance.php";
// A/B testing
include_once "includes/theme-ab-testing.php";
// attivo le traduzioni
function paperplane_theme_load_theme_textdomain() {
	load_theme_textdomain( 'paperPlane-blankTheme', get_template_directory() . '/languages' );
}
add_action( 'after_setup_theme', 'paperplane_theme_load_theme_textdomain' );


// ricerca
// per rendere effettive le modifiche a queste funzioni è necessario salvare la pagina di opzioni dei permalink di WordPress
function psi_oggi_search_meta_queries( $where, $wp_query ) {
	global $wpdb;

	//if there is no metaquery, bye!
	$meta_queries = $wp_query->get( 'meta_query' );
	if ( ! $meta_queries || $meta_queries == '' )
		return $where;

	//if only one relation
	$where = str_replace( $wpdb->postmeta . ".meta_key = 'post_title' AND " . $wpdb->postmeta . ".meta_value", $wpdb->posts . ".post_title", $where );
	$where = str_replace( $wpdb->postmeta . ".meta_key = 'post_content' AND " . $wpdb->postmeta . ".meta_value", $wpdb->posts . ".post_content", $where );
	$where = str_replace( $wpdb->postmeta . ".meta_key = 'post_excerpt' AND " . $wpdb->postmeta . ".meta_value", $wpdb->posts . ".post_excerpt", $where );

	////for nested relations

	//count the numbers of meta queries for possible replacements
	$number_of_relations = count( $meta_queries );

	//replace 'WHERE' using the multidimensional postmeta naming logic used by wordpress core
	$i = 1;
	while ( $i <= $number_of_relations && $number_of_relations > 0 ) {
		$where = str_replace( "mt" . $i . ".meta_key = 'post_title' AND mt" . $i . ".meta_value", $wpdb->posts . ".post_title", $where );
		$where = str_replace( "mt" . $i . ".meta_key = 'post_content' AND mt" . $i . ".meta_value", $wpdb->posts . ".post_content", $where );
		$where = str_replace( "mt" . $i . ".meta_key = 'post_excerpt' AND mt" . $i . ".meta_value", $wpdb->posts . ".post_excerpt", $where );
		$i++;
	}

	return $where;
}

add_filter( 'posts_where', 'psi_oggi_search_meta_queries', 10, 2 );

// sostituire listing-colonne con il titolo della pagina di ricerca
function psi_oggi_search_rewrite() {
	add_rewrite_rule(
		'listing-colonne/([^/]+)/filter/([^/]+)(/page/(\d+))?',
		'index.php?pagename=listing-colonne&kw=$matches[1]&filter=$matches[2]&paged=$matches[4]',
		'top'
	);
	add_filter( 'query_vars', 'psi_oggi_add_query_vars' );
}
add_action( 'init', 'psi_oggi_search_rewrite', 1 );

function psi_oggi_add_query_vars( $vars ) {
	$vars[] = 'paged';
	$vars[] = 'kw';
	$vars[] = 'filter';

	return $vars;
}

// sostituire listing-colonne con il template della pagina di ricerca
function psi_oggi_search_submit_redirect() {
	global $wp_query;
	if ( ! is_admin() && $wp_query->is_main_query() && $wp_query->is_page( 'listing-colonne' ) ) {
		$old_url = $_SERVER['REQUEST_URI'];
		//$new_url = preg_replace( '/\?kw=([^&]+)&filter=([^&]+)/', '$1/filter/$2/', $old_url );
		$new_url = preg_replace( '/\?kw=([^&]+)&filter=([^&]+)(&paged=(\d+))?/', '$1/filter/$2$4', $old_url );
		if ( $old_url !== $new_url ) {
			wp_redirect( $new_url, 301 );
			exit;
		}
	}
}
add_action( 'template_redirect', 'psi_oggi_search_submit_redirect' );