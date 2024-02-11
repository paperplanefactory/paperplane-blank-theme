<?php
// All scripts
function paperplane_load_scripts() {
	// versione del tema
	global $theme_version, $theme_pagination, $attivare_pwa;
	//$content_fields = paperplane_content_transients( $post->ID );
	// smart jquery inclusion
	if ( ! is_admin() ) {
		wp_deregister_script( 'jquery' );
		wp_register_script(
			'jquery',
			get_template_directory_uri() . '/assets/js/libs/jquery-3.7.1.min.js',
			array(),
			'3.7.1',
			array(
				//'strategy' => 'async',
				'in_footer' => false, // Note: This is the default value.
			)
		);
		wp_enqueue_script( 'jquery' );
	}

	if ( $theme_pagination === 'theme-infinite-scroll' ) {
		// Infinite Scroll
		// documentazione: https://infinite-scroll.com/
		wp_register_script(
			'theme-infinitescroll',
			get_template_directory_uri() . '/assets/js/libs/infinite-scroll.min.js',
			array( 'jquery' ),
			'4.0.1',
			array(
				'strategy' => 'defer',
				'in_footer' => true, // Note: This is the default value.
			)
		);
		wp_enqueue_script( 'theme-infinitescroll' );
	}
	// AOS
	// documentazione: https://github.com/michalsnik/aos
	wp_register_script(
		'theme-aos',
		get_template_directory_uri() . '/assets/js/libs/aos.min.js',
		array( 'jquery' ),
		$theme_version,
		array(
			'strategy' => 'defer',
			'in_footer' => true, // Note: This is the default value.
		)
	);
	wp_enqueue_script( 'theme-aos' );

	// slick
	// documentazione: https://github.com/kenwheeler/slick
	wp_register_script(
		'slick',
		get_template_directory_uri() . '/assets/js/libs/slick.min.js',
		array( 'jquery' ),
		$theme_version,
		array(
			'strategy' => 'defer',
			'in_footer' => true, // Note: This is the default value.
		)
	);
	wp_enqueue_script( 'slick' );

	// parallasse
	// documentazione: https://github.com/dixonandmoe/rellax
	// wp_register_script( 'js-parallax', get_template_directory_uri() . '/assets/js/libs/rellax.min.js', '', '1.10.0', false);
	// wp_enqueue_script( 'js-parallax' );

	// Comportamenti ricorrenti
	wp_register_script(
		'paperplane-theme-general',
		get_template_directory_uri() . '/assets/js/theme-general.min.js',
		array( 'jquery' ),
		$theme_version,
		array(
			'strategy' => 'defer',
			'in_footer' => true, // Note: This is the default value.
		)
	);
	wp_enqueue_script( 'paperplane-theme-general' );
	if ( $attivare_pwa == 1 ) {
		// PWA
		wp_register_script(
			'paperplane-theme-pwa-install',
			get_template_directory_uri() . '/assets/pwa/pwa-install.min.js',
			array( 'jquery' ),
			$theme_version,
			array(
				'strategy' => 'defer',
				'in_footer' => true, // Note: This is the default value.
			)
		);
		wp_enqueue_script( 'paperplane-theme-pwa-install' );
	}
}

add_action( 'wp_enqueue_scripts', 'paperplane_load_scripts' );