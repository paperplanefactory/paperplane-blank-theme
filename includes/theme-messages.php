<?php
// Ricordarsi di abilitare il plugin paperplane-custom-welcome-email per la gestione delle e-mail di iscrizione al sito che non possono essere modificate da qui.

//no messaggi di errore in login
function no_errors_please() {
	return '<strong>Login errato!</strong><br />Puoi provare a reimpostare la password con il link che trovi qui sotto: in caso non ricevessi l&rsquo;email contatta <a href="mailto:info@paperplanefactory.com" target="_blank">PaperPlane</a>.';
}
add_filter( 'login_errors', 'no_errors_please' );

// remove version
function wpbeginner_remove_version() {
	return '';
}
add_filter( 'the_generator', 'wpbeginner_remove_version' );

// admin footer
function remove_footer_admin() {
	echo 'Powered by <a href="https://www.wordpress.org" target="_blank">WordPress</a> | Handcrafted by <a href="https://paperplanefactory.com" target="_blank">Paperplane</a></p>';
}
add_filter( 'admin_footer_text', 'remove_footer_admin' );

// admin help box
add_action( 'wp_dashboard_setup', 'my_custom_dashboard_widgets' );
function my_custom_dashboard_widgets() {
	global $wp_meta_boxes;
	wp_add_dashboard_widget( 'custom_help_widget', 'Supporto per il tuo sito', 'custom_dashboard_help' );
}
function custom_dashboard_help() {
	echo '<a href="https://paperplanefactory.com" target="_blank"><img src="' . get_template_directory_uri() . '/assets/images/admin-images/logo-paper.svg" width="200" /></a><h2>Benvenuto nelll&rsquo;area di amministrazione del tuo sito!</h2><p>Il sito <strong>' . get_bloginfo( 'name' ) . '</strong> è basato su <a href="https://wordpress.org/" target="_blank">WordPress</a> e utilizza un tema appositamente creato da <a href="https://paperplanefactory.com" target="_blank">PaperPlane</a>.<br />
  <strong>Hai bisogno di assistenza?</strong> Contattaci usando <a href="mailto:info@paperplanefactory.com">questo link</a> o scrivendo a info@paperplanefactory.com.</p>';
}

// custom login
add_filter( 'login_headerurl', 'namespace_login_headerurl' );

// rimuovo emoji
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
remove_action( 'wp_print_styles', 'print_emoji_styles' );
remove_action( 'admin_print_styles', 'print_emoji_styles' );

// login custom logo
function namespace_login_style() {
	echo '<style>.login h1 a { background-image: url( ' . get_template_directory_uri() . '/assets/images/site-logo-header.svg ) !important; background-size:contain !important; }</style>';
}
add_action( 'login_head', 'namespace_login_style' );

// Avoid users enumeration

add_action( 'init', function () {
	if ( isset( $_REQUEST['author'] )
		&& preg_match( '/\\d/', $_REQUEST['author'] ) > 0
		&& ! is_user_logged_in()
	) {
		wp_die( 'forbidden - number in author name not allowed = ' . esc_html( $_REQUEST['author'] ) );
	}
} );

add_action( 'rest_authentication_errors', function ($access) {
	if ( is_user_logged_in() ) {
		return $access;
	}

	if ( ( preg_match( '/users/i', $_SERVER['REQUEST_URI'] ) !== 0 )
		|| ( isset( $_REQUEST['rest_route'] ) && ( preg_match( '/users/i', $_REQUEST['rest_route'] ) !== 0 ) )
	) {
		return new \WP_Error(
			'rest_cannot_access',
			'Only authenticated users can access the User endpoint REST API.',
			[ 
				'status' => rest_authorization_required_code()
			]
		);
	}

	return $access;
} );