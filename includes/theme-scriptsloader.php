<?php
/**
 * Gestisce il caricamento degli script del tema
 * 
 * @return void
 */
function paperplane_load_scripts() {
	// Variabili globali
	global $theme_version, $theme_pagination, $attivare_pwa;

	// Script condizionali
	if ( $theme_pagination === 'theme-infinite-scroll' ) {
		wp_enqueue_script(
			'theme-infinitescroll',
			get_template_directory_uri() . '/assets/js/libs/infinite-scroll.min.js',
			[ 'jquery' ],
			'4.0.1',
			[
				'strategy' => 'defer',
				'in_footer' => true,
			]
		);
	}

	if ( $attivare_pwa == 1 ) {
		wp_enqueue_script(
			'paperplane-theme-pwa-install',
			get_template_directory_uri() . '/assets/pwa/pwa-install.min.js',
			[ 'jquery' ],
			$theme_version,
			[
				'strategy' => 'defer',
				'in_footer' => true,
			]
		);
	}

	// Array di configurazione degli script
	$scripts = [
		'jquery' => [
			'src' => '/assets/js/libs/jquery-3.7.1.min.js',
			'deps' => [],
			'version' => '3.7.1',
			'in_footer' => false
		],
		// File del tema - ORDINE IMPORTANTE
		'paperplane-theme-accessibility' => [
			'src' => '/assets/js/theme-accessibility.min.js',
			'deps' => [], // Nessuna dipendenza esterna
			'version' => $theme_version,
			'strategy' => 'defer',
			'in_footer' => true
		],
		'paperplane-theme-navigation' => [
			'src' => '/assets/js/theme-navigation.min.js',
			'deps' => [], // Nessuna dipendenza esterna
			'version' => $theme_version,
			'strategy' => 'defer',
			'in_footer' => true
		],
		'theme-aos' => [
			'src' => '/assets/js/libs/aos.min.js',
			'deps' => [ 'jquery' ],
			'version' => $theme_version,
			'strategy' => 'defer',
			'in_footer' => true
		],
		'slick' => [
			'src' => '/assets/js/libs/slick.min.js',
			'deps' => [ 'jquery' ],
			'version' => $theme_version,
			'strategy' => 'defer',
			'in_footer' => true
		],


		'paperplane-theme-utilities' => [
			'src' => '/assets/js/theme-utilities.min.js',
			'deps' => [ 'jquery', 'theme-aos', 'slick' ], // Richiede jQuery, AOS e Slick
			'version' => $theme_version,
			'strategy' => 'defer',
			'in_footer' => true
		],
		'paperplane-video-emebds' => [
			'src' => '/assets/js/video-emebds.min.js',
			'deps' => [ 'jquery' ],
			'version' => $theme_version,
			'strategy' => 'defer',
			'in_footer' => false
		]
	];

	// Gestione jQuery nel frontend
	if ( ! is_admin() ) {
		wp_deregister_script( 'jquery' );
	}

	// Registra e carica gli script base
	foreach ( $scripts as $handle => $script ) {
		$script_path = get_template_directory() . $script['src'];

		if ( file_exists( $script_path ) ) {
			wp_register_script(
				$handle,
				get_template_directory_uri() . $script['src'],
				$script['deps'],
				$script['version'],
				[
					'strategy' => $script['strategy'] ?? null,
					'in_footer' => $script['in_footer'] ?? true,
				]
			);
			wp_enqueue_script( $handle );
		}
	}

	// Passa stringhe tradotte
	wp_localize_script(
		handle: 'paperplane-theme-utilities',
		object_name: 'themeStrings',
		l10n: [
			/* translators: Testo del pulsante per andare alla slide successiva */
			'nextSlide' => esc_html__( 'Slide precedente', 'paperPlane-blankTheme' ),

			/* translators: Testo del pulsante per tornare alla slide precedente */
			'prevSlide' => esc_html__( 'Slide successiva', 'paperPlane-blankTheme' ),

			/* translators: Messaggio di conferma quando l'URL viene copiato negli appunti */
			'urlCopied' => esc_html__( ' - copiato', 'paperPlane-blankTheme' ),

			/* translators: Tooltip che appare al passaggio del mouse sul link */
			'clickToCopy' => esc_html__( 'Clicca per copiare l\'URL', 'paperPlane-blankTheme' ),

			/* translators: Etichetta del pulsante per chiudere i risultati di ricerca */
			'closeSearchResults' => esc_html__( 'Chiudi risultati ricerca', 'paperPlane-blankTheme' ),

			/* translators: Singolare nel contatore dei risultati di ricerca */
			'searchResultSingular' => esc_html__( 'risultato', 'paperPlane-blankTheme' ),

			/* translators: Plurale nel contatore dei risultati di ricerca */
			'searchResultPlural' => esc_html__( 'risultati', 'paperPlane-blankTheme' ),

			/* translators: Messaggio quando non ci sono risultati di ricerca */
			'noSearchResults' => esc_html__( '0 risultati', 'paperPlane-blankTheme' ),

			/* translators: Testo aggiuntivo per invitare a proseguire nella visualizzazione dei risultati */
			'proceedToView' => esc_html__( ', prosegui per visualizzare', 'paperPlane-blankTheme' ),

			/* translators: Etichetta ARIA per il dropdown dei suggerimenti di ricerca */
			'searchSuggestions' => esc_html__( 'Suggerimenti di ricerca', 'paperPlane-blankTheme' ),

			/* translators: Messaggio di errore quando gli elementi di ricerca non vengono trovati */
			'searchElementsNotFound' => esc_html__( 'Elementi di ricerca non trovati', 'paperPlane-blankTheme' ),

			/* translators: Messaggio di fallback per il caricamento della versione non compressa */
			'fallbackUncompressed' => esc_html__( 'Fallback alla versione non compressa', 'paperPlane-blankTheme' ),

			/* translators: Messaggio di errore nel caricamento del JSON */
			'errorLoadingJSON' => esc_html__( 'Errore nel caricamento del JSON', 'paperPlane-blankTheme' ),

			/* translators: Messaggio di errore generico nel caricamento */
			'errorLoading' => esc_html__( 'Errore nel caricamento:', 'paperPlane-blankTheme' ),

			/* translators: Messaggio di errore nel caricamento dei dati */
			'errorLoadingData' => esc_html__( 'Errore caricamento dati:', 'paperPlane-blankTheme' )
		]
	);
}
add_action( 'wp_enqueue_scripts', 'paperplane_load_scripts' );

// Funzione helper per verificare l'esistenza dei file
function get_theme_file_mod_time( $file_path ) {
	$full_path = get_template_directory() . $file_path;
	return file_exists( $full_path ) ? filemtime( $full_path ) : false;
}