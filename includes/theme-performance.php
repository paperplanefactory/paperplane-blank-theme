<?php

/**
 * Gestisce il precaricamento delle risorse critiche come font, immagini e video
 * Questa funzione viene eseguita nell'header della pagina per ottimizzare i tempi di caricamento
 * 
 * @return void
 */
function paperplane_preload_data() {
	// Usa una cache statica per evitare calcoli multipli della stessa funzione
	// nella stessa richiesta
	static $cached_preload_data = null;
	if ( $cached_preload_data !== null ) {
		echo $cached_preload_data;
		return;
	}

	// Inizializza la stringa che conterrà tutti i tag di preload
	$preload_data = '';

	// Ottiene l'URL della directory del tema in modo sicuro
	$stylesheet_directory = esc_url( get_bloginfo( 'stylesheet_directory' ) );

	// Array dei font da precaricare con le loro configurazioni
	// per stabilire quali font precvaricare:
	// visualizzare una pagina del sito in Chrome
	// aprire il pannello dev
	// ricaricare la pagina
	// aprire la tab Network o Rete
	// filtrare per tipo di file font
	// per ogni font copiare la URL "Request URL:" e aggiungerla all'array
	// 'type' può essere 'preconnect' per la connessione al server dei font da usare come primo elemento dell'array
	// o 'font/woff2' per i file dei font specifici - utilizzare l'estensione corretta del font
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
			'url' => 'https://paperplaneblanktheme.local/wp-content/themes/paperplane-blank-theme/assets/fonts/material-icons/MaterialIcons-Regular.ttf',
			'type' => 'font/ttf'
		]
	];



	// Genera i tag di preload per ogni font
	// Usa un formato diverso per preconnect e preload dei font
	foreach ( $fonts_preload as $font ) {
		if ( $font['type'] === 'preconnect' ) {
			$preload_data .= sprintf(
				'<link rel="preconnect" href="%s" crossorigin />%s',
				esc_url( $font['url'] ),
				"\n"
			);
		} else {
			$preload_data .= sprintf(
				'<link rel="preload" href="%s" as="font" fetchpriority="high" type="%s" crossorigin />%s',
				esc_url( $font['url'] ),
				esc_attr( $font['type'] ),
				"\n"
			);
		}
	}



	// Precarica il logo del sito con alta priorità
	$logo_path = $stylesheet_directory . '/assets/images/site-logo-header.svg';
	if ( $logo_path ) {
		$preload_data .= sprintf(
			'<link rel="preload" href="%s" fetchpriority="high" as="image" type="image/svg+xml" crossorigin />%s',
			esc_url( $logo_path ),
			"\n"
		);
	}

	// Gestisce il precaricamento specifico per il post corrente
	global $post;
	// Verifica che esista un post e che la funzione dei transient sia disponibile
	if ( $post instanceof WP_Post && function_exists( 'paperplane_content_transients' ) ) {
		$content_fields = paperplane_content_transients( $post->ID );

		// Verifica la presenza di media di apertura nella pagina
		if ( ! empty( $content_fields ) && isset( $content_fields['page_opening_media'] ) ) {
			$page_opening_media = $content_fields['page_opening_media'] ?? 'no-media';

			// Gestisce il precaricamento delle immagini
			if ( $page_opening_media === 'image' ) {
				$preload_data .= generate_image_preload_tags( $content_fields );
			}

			// Gestisce il precaricamento del poster del video
			elseif ( $page_opening_media === 'video' && ! empty( $content_fields['page_opening_video_poster'] ) ) {
				$video_poster = $content_fields['page_opening_video_poster'];
				if ( isset( $video_poster['sizes']['large'] ) && isset( $video_poster['mime_type'] ) ) {
					$preload_data .= sprintf(
						'<link rel="preload" href="%s" fetchpriority="auto" as="image" type="%s" />%s',
						esc_url( $video_poster['sizes']['large'] ),
						esc_attr( $video_poster['mime_type'] ),
						"\n"
					);
				}
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
 * Gestisce sia le versioni desktop che mobile delle immagini di apertura
 * 
 * @param array $content_fields Array contenente i dati delle immagini
 * @return string Tag HTML generati per il preload
 */
function generate_image_preload_tags( $content_fields ) {
	// Inizializza la stringa che conterrà i tag di preload
	$preload_tags = '';

	// Verifica la presenza dell'immagine desktop (requisito minimo)
	if ( empty( $content_fields['page_opening_image_desktop'] ) ) {
		return $preload_tags;
	}

	// Recupera l'immagine mobile, se non presente usa quella desktop come fallback
	// Questo garantisce sempre un'immagine per i dispositivi mobili
	$mobile_image = ! empty( $content_fields['page_opening_image_mobile'] )
		? $content_fields['page_opening_image_mobile']
		: $content_fields['page_opening_image_desktop'];

	// Genera il tag per il precaricamento dell'immagine desktop
	// Usa la media query per caricare solo su schermi larghi
	if ( isset( $content_fields['page_opening_image_desktop']['sizes']['full_desk_hd'] ) ) {
		$preload_tags .= sprintf(
			'<link rel="preload" media="(min-width: 1024px)" href="%s" fetchpriority="auto" as="image" type="%s" />%s',
			esc_url( $content_fields['page_opening_image_desktop']['sizes']['full_desk_hd'] ),
			esc_attr( $content_fields['page_opening_image_desktop']['mime_type'] ),
			"\n"
		);
	}

	// Genera il tag per il precaricamento dell'immagine mobile
	// Usa la media query per caricare solo su schermi stretti
	if ( isset( $mobile_image['sizes']['full_desk'] ) ) {
		$preload_tags .= sprintf(
			'<link rel="preload" media="(max-width: 1023px)" href="%s" fetchpriority="auto" as="image" type="%s" />%s',
			esc_url( $mobile_image['sizes']['full_desk'] ),
			esc_attr( $mobile_image['mime_type'] ),
			"\n"
		);
	}

	return $preload_tags;
}

// Aggiunge la funzione paperplane_preload_data all'hook wp_head
// La priorità 1 assicura che venga eseguita tra le prime
add_action( 'wp_head', 'paperplane_preload_data', 1 );



/**
 * Gestisce il precaricamento speculativo delle pagine attraverso le Speculation Rules API
 * Genera un tag script con le regole per il prefetch delle pagine selezionate
 */
function paperplane_preload_speculationrules_pages() {
	// Verifica il supporto multilingua e ottiene il parametro lingua
	// Se Polylang è attivo usa la lingua corrente, altrimenti usa un valore predefinito
	$acf_options_parameter = function_exists( 'pll_current_language' ) ?
		pll_current_language( 'slug' ) :
		'any-lang';

	// Carica le opzioni salvate nei transient
	paperplane_options_transients();

	// Recupera l'elenco delle pagine da precaricare dalle opzioni
	global $options_fields_multilang;
	$speculationrules_pages = $options_fields_multilang['speculationrules_pages'] ?? [];

	// Se non ci sono pagine da precaricare, termina
	if ( empty( $speculationrules_pages ) ) {
		return;
	}

	// Converte l'array di oggetti pagina in array di URL
	$urls = array_map( function ($page) {
		return get_permalink( $page->ID );
	}, $speculationrules_pages );

	// Prepara l'array delle regole di speculazione
	// 'prefetch' indica che le pagine verranno precaricate
	// 'source': 'list' specifica che gli URL vengono da un elenco definito
	$speculation_rules = [ 
		'prefetch' => [ 
			[ 
				'source' => 'list',
				'urls' => array_filter( $urls ) // Rimuove eventuali URL vuoti
			]
		]
	];

	// Stampa il tag script con le regole
	// JSON_UNESCAPED_SLASHES mantiene gli slash negli URL
	printf(
		"\n" . '<script type="speculationrules">%s</script>' . "\n",
		wp_json_encode( $speculation_rules, JSON_UNESCAPED_SLASHES )
	);
}
// Aggiunge la funzione al footer della pagina
add_action( 'wp_footer', 'paperplane_preload_speculationrules_pages' );

// Carica le opzioni dai transient
$options_fields = paperplane_options_transients();

// Disabilita Query Monitor nel backend se l'opzione è disattivata
if ( $options_fields['use_query_monitor_backend'] != 1 ) {
	add_filter( 'qm/dispatch/html', function () {
		// Restituisce false nelle pagine di amministrazione
		// per disabilitare Query Monitor
		if ( is_admin() ) {
			return false;
		}
		return true;
	} );
}