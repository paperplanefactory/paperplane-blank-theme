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
		'paperplane-theme-general' => [ 
			'src' => '/assets/js/theme-general.min.js',
			'deps' => [ 'jquery' ],
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

	// Aggiungi variabili JavaScript se necessario
	wp_localize_script( 'paperplane-theme-general', 'themeVars', [ 
		'ajaxUrl' => admin_url( 'admin-ajax.php' ),
		'themeUrl' => get_template_directory_uri()
	] );
}
add_action( 'wp_enqueue_scripts', 'paperplane_load_scripts' );

// Funzione helper per verificare l'esistenza dei file
function get_theme_file_mod_time( $file_path ) {
	$full_path = get_template_directory() . $file_path;
	return file_exists( $full_path ) ? filemtime( $full_path ) : false;
}