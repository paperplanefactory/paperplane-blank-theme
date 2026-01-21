<?php
/**
 * Configurazione centralizzata per le aperture pagina
 * Elimina la duplicazione di logica tra rendering e preload
 */

/**
 * Registry delle configurazioni per ogni tipo di apertura
 * 
 * @return array Configurazione di tutti i tipi di apertura
 */
function get_page_opening_registry() {
	return [
		'opening-fullscreen' => [
			'template' => 'template-parts/grid/page-opening/opening-fullscreen.php',
			'has_media' => true,
			'preload_config' => [
				'enabled' => true,
				'media_types' => [ 'image', 'video' ],
				'image_fields' => [
					'image' => [
						'desktop' => 'page_opening_image_desktop',
						'mobile' => 'page_opening_image_mobile',
					],
					'video' => [
						'poster' => 'page_opening_image_video_poster',
					]
				],
				'sizes' => [
					'desktop' => 'full_desk_hd',
					'mobile' => 'full_desk',
					'poster' => 'full_desk'
				],
				'media_queries' => [
					'desktop' => '(min-width: 1024px)',
					'mobile' => '(max-width: 1023px)',
					'poster' => ''
				]
			]
		],
		'opening-text' => [
			'template' => 'template-parts/grid/page-opening/opening-text.php',
			'has_media' => false,
			'preload_config' => [
				'enabled' => false,
			]
		],
		'opening-archive' => [
			'template' => 'template-parts/grid/page-opening/opening-archive.php',
			'has_media' => false,
			'preload_config' => [
				'enabled' => false,
			]
		],
		'opening-search' => [
			'template' => 'template-parts/grid/page-opening/opening-search.php',
			'has_media' => false,
			'preload_config' => [
				'enabled' => false,
			]
		],
		'opening-404' => [
			'template' => 'template-parts/grid/page-opening/opening-404.php',
			'has_media' => false,
			'preload_config' => [
				'enabled' => false,
			]
		]
	];
}

/**
 * Determina quale configurazione di apertura usare in base al contesto
 * QUESTA È LA FUNZIONE CENTRALE CHE ELIMINA LA DUPLICAZIONE
 * 
 * @param array $content_fields Campi ACF del contenuto corrente
 * @return array|null Configurazione dell'apertura o null se non applicabile
 */
function get_page_opening_config( $content_fields = [] ) {
	$registry = get_page_opening_registry();

	// Determina il tipo di apertura in base al contesto
	$opening_type = determine_opening_type( $content_fields );

	if ( ! $opening_type || ! isset( $registry[ $opening_type ] ) ) {
		return null;
	}

	$config = $registry[ $opening_type ];

	// Arricchisce la configurazione con i dati specifici del contesto
	$config['opening_type'] = $opening_type;
	$config['content_fields'] = $content_fields;

	// Determina il tipo di media se applicabile
	if ( $config['has_media'] && ! empty( $content_fields['page_opening_media'] ) ) {
		$config['media_type'] = $content_fields['page_opening_media'];
	}

	return $config;
}

/**
 * Determina quale tipo di apertura usare in base al contesto della pagina
 * Centralizza tutta la logica condizionale
 * 
 * @param array $content_fields Campi ACF del contenuto corrente
 * @return string|null Tipo di apertura
 */
function determine_opening_type( $content_fields = [] ) {
	// Template di pagina personalizzati e singoli post
	if ( is_page_template( 'page-modules.php' ) ||
		is_page_template( 'page-listing.php' ) ||
		is_singular( 'post' ) ) {

		// Controlla se esiste un layout definito
		if ( ! empty( $content_fields['page_opening_layout'] ) ) {
			return $content_fields['page_opening_layout'];
		}
	}

	// Pagine di archivio
	if ( is_archive() ) {
		return 'opening-archive';
	}

	// Risultati di ricerca
	if ( is_search() ) {
		return 'opening-search';
	}

	// Pagina 404
	if ( is_404() ) {
		return 'opening-404';
	}

	return null;
}

/**
 * Ottiene le immagini da precaricare per la configurazione corrente
 * Usata dalla funzione di preload
 * 
 * @param array $config Configurazione dell'apertura
 * @return array Array di immagini con i loro metadati per il preload
 */
function get_preloadable_images( $config ) {
	$images = [];

	// Se il preload non è abilitato per questo tipo, ritorna array vuoto
	if ( empty( $config['preload_config']['enabled'] ) ) {
		return $images;
	}

	$preload_config = $config['preload_config'];
	$content_fields = $config['content_fields'];
	$media_type = $config['media_type'] ?? 'no-media';

	// Determina quali campi immagine cercare in base al tipo di media
	$fields_to_check = [];

	if ( $media_type === 'image' && isset( $preload_config['image_fields']['image'] ) ) {
		$fields_to_check = $preload_config['image_fields']['image'];
	} elseif ( $media_type === 'video' && isset( $preload_config['image_fields']['video'] ) ) {
		$fields_to_check = $preload_config['image_fields']['video'];
	} else {
		return $images;
	}

	// Controlla la presenza di desktop e mobile per decidere le media queries
	$has_desktop = false;
	$has_mobile = false;

	foreach ( $fields_to_check as $type => $field_name ) {
		if ( $type === 'desktop' && ! empty( $content_fields[ $field_name ] ) ) {
			$has_desktop = true;
		}
		if ( $type === 'mobile' && ! empty( $content_fields[ $field_name ] ) ) {
			$has_mobile = true;
		}
	}

	// Genera l'array delle immagini da precaricare
	foreach ( $fields_to_check as $type => $field_name ) {
		if ( empty( $content_fields[ $field_name ] ) ||
			! is_array( $content_fields[ $field_name ] ) ) {
			continue;
		}

		$image_data = $content_fields[ $field_name ];
		$size_key = $preload_config['sizes'][ $type ] ?? null;

		if ( ! $size_key || ! isset( $image_data['sizes'][ $size_key ] ) ) {
			continue;
		}

		// Determina la media query
		$media_query = '';
		if ( $type === 'desktop' && $has_desktop && $has_mobile ) {
			$media_query = $preload_config['media_queries']['desktop'];
		} elseif ( $type === 'mobile' && $has_desktop && $has_mobile ) {
			$media_query = $preload_config['media_queries']['mobile'];
		} elseif ( $type === 'poster' ) {
			$media_query = $preload_config['media_queries']['poster'];
		}

		$images[] = [
			'url' => $image_data['sizes'][ $size_key ],
			'mime_type' => $image_data['mime_type'],
			'media_query' => $media_query,
			'type' => $type
		];
	}

	return $images;
}