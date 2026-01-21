<?php
/**
 * Versione refactored delle funzioni di preload
 * Usa la configurazione centralizzata eliminando la duplicazione di logica
 */


/**
 * Gestisce il precaricamento delle risorse critiche come font, immagini e video
 * VERSIONE REFACTORED - usa la configurazione centralizzata
 * 
 * @return void
 */
function paperplane_preload_data() {
	// Usa una cache statica per evitare calcoli multipli della stessa funzione
	static $cached_preload_data = null;
	if ( $cached_preload_data !== null ) {
		echo $cached_preload_data;
		return;
	}

	// Inizializza la stringa che conterrà tutti i tag di preload
	$preload_data = '';

	// Ottiene l'URL della directory del tema in modo sicuro
	$stylesheet_directory = esc_url( get_bloginfo( 'stylesheet_directory' ) );

	// Array dei font da precaricare (invariato)
	$fonts_preload = [
		[
			'url' => 'https://fonts.gstatic.com',
			'type' => 'preconnect'
		],
		[
			'url' => 'https://fonts.gstatic.com/s/atkinsonhyperlegible/v11/9Bt23C1KxNDXMspQ1lPyU89-1h6ONRlW45G04pIoWQeCbA.woff2',
			'type' => 'font/woff2'
		],
		[
			'url' => 'https://fonts.gstatic.com/s/atkinsonhyperlegible/v11/9Bt73C1KxNDXMspQ1lPyU89-1h6ONRlW45G8Wbc9dCWPRl-uFQ.woff2',
			'type' => 'font/woff2'
		],
		[
			'url' => 'https://fonts.gstatic.com/s/montserrat/v29/JTUSjIg1_i6t8kCHKm459WlhyyTh89Y.woff2',
			'type' => 'font/woff2'
		],
		[
			'url' => $stylesheet_directory . '/assets/fonts/material-icons/MaterialIcons-Regular.ttf',
			'type' => 'font/ttf'
		]
	];

	// Genera i tag di preload per ogni font (invariato)
	foreach ( $fonts_preload as $font ) {
		if ( $font['type'] === 'preconnect' ) {
			$preload_data .= sprintf(
				'<link rel="preconnect" href="%s" crossorigin />%s',
				esc_url( $font['url'] ),
				"\n"
			);
		} else {
			$preload_data .= sprintf(
				'<link rel="preload" href="%s" as="font" type="%s" crossorigin />%s',
				esc_url( $font['url'] ),
				esc_attr( $font['type'] ),
				"\n"
			);
		}
	}

	// Precarica il logo del sito (invariato)
	$logo_path = $stylesheet_directory . '/assets/images/site-logo-header.svg';
	if ( $logo_path ) {
		$preload_data .= sprintf(
			'<link rel="preload" href="%s" fetchpriority="high" as="image" type="image/svg+xml" crossorigin="anonymous" />%s',
			esc_url( $logo_path ),
			"\n"
		);
	}

	// NUOVA LOGICA: Usa la configurazione centralizzata per le immagini
	global $post;
	if ( $post instanceof WP_Post && function_exists( 'paperplane_content_transients' ) ) {
		$content_fields = paperplane_content_transients( $post->ID );

		if ( ! empty( $content_fields ) ) {
			// Ottiene la configurazione appropriata
			$opening_config = get_page_opening_config( $content_fields );

			// Genera i tag di preload usando la configurazione
			if ( $opening_config ) {
				$preload_data .= generate_image_preload_tags_refactored( $opening_config );
			}
		}
	}

	// Memorizza i dati generati nella cache statica
	$cached_preload_data = $preload_data;

	// Stampa tutti i tag di preload generati
	echo $preload_data;
}

/**
 * Genera i tag HTML per il precaricamento delle immagini responsive
 * VERSIONE REFACTORED - usa la configurazione centralizzata
 * 
 * @param array $opening_config Configurazione dell'apertura dalla funzione centralizzata
 * @return string HTML con i tag di preload
 */
function generate_image_preload_tags_refactored( $opening_config ) {
	$preload_tags = '';

	// Ottiene le immagini da precaricare usando la funzione helper
	$images = get_preloadable_images( $opening_config );

	// Genera i tag di preload per ogni immagine
	foreach ( $images as $image ) {
		$preload_tags .= sprintf(
			'<link rel="preload" %shref="%s" fetchpriority="high" as="image" type="%s" />%s',
			$image['media_query'] ? sprintf( 'media="%s" ', $image['media_query'] ) : '',
			esc_url( $image['url'] ),
			esc_attr( $image['mime_type'] ),
			"\n"
		);
	}

	return $preload_tags;
}

// Aggiunge la funzione paperplane_preload_data all'hook wp_head
add_action( 'wp_head', 'paperplane_preload_data', 1 );



/**
 * Gestisce il precaricamento speculativo delle pagine (invariato)
 */
function paperplane_preload_speculationrules_pages() {
	$acf_options_parameter = function_exists( 'pll_current_language' ) ?
		pll_current_language( 'slug' ) :
		'any-lang';

	paperplane_options_transients();

	global $options_fields_multilang;
	$speculationrules_pages = $options_fields_multilang['speculationrules_pages'] ?? [];

	if ( empty( $speculationrules_pages ) ) {
		return;
	}

	$urls = array_map( function ( $page ) {
		return get_permalink( $page->ID );
	}, $speculationrules_pages );

	$speculation_rules = [
		'prefetch' => [
			[
				'source' => 'list',
				'urls' => array_filter( $urls )
			]
		]
	];

	printf(
		"\n" . '<script type="speculationrules">%s</script>' . "\n",
		wp_json_encode( $speculation_rules, JSON_UNESCAPED_SLASHES )
	);
}
add_action( 'wp_footer', 'paperplane_preload_speculationrules_pages' );

// Resto del codice invariato...
$options_fields = paperplane_options_transients();

if ( ! isset( $options_fields['use_query_monitor_backend'] ) || $options_fields['use_query_monitor_backend'] != true ) {
	add_filter( 'qm/dispatch/html', function () {
		if ( is_admin() ) {
			return false;
		}
		return true;
	} );
}

function generate_critical_css() {
	$critical_source = get_template_directory() . '/critical.min.css';
	$critical_output = get_template_directory() . '/critical.processed.css';

	if ( ! file_exists( $critical_output ) ||
		filemtime( $critical_source ) > filemtime( $critical_output ) ) {

		$css = file_get_contents( $critical_source );
		$theme_slug = get_template();
		$css = str_replace(
			'url(assets/',
			'url(/wp-content/themes/' . $theme_slug . '/assets/',
			$css
		);

		file_put_contents( $critical_output, $css );
	}
}
add_action( 'after_switch_theme', 'generate_critical_css' );
add_action( 'init', 'generate_critical_css' );