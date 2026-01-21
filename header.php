<?php
// Paperplane _blankTheme - template per header.
// definisco le variaibil globali che possono poi essere lette tramite 
global $use_transients_fields,
$theme_version,
$acf_options_parameter,
$static_bloginfo_stylesheet_directory,
$options_fields,
$options_fields_multilang,
$cta_url_modal_array,
$theme_pagination,
$attivare_pwa,
$content_fields;
// include( locate_template( 'parcorso/nome-file.php' ) );
// imposto la variabile globale per definire:
// - se è attivo Polylang il linguaggio in cui l'utente sta visitando il sito
// - se non è attivo Polylang un valore generico 'any-lang'
if ( function_exists( 'pll_the_languages' ) ) {
	$acf_options_parameter = pll_current_language( 'slug' );
} else {
	$acf_options_parameter = 'any-lang';
}
// genero le trnasients delle pagine di opzioni
$options_fields_multilang = paperplane_options_transients_multilanguage( $acf_options_parameter );
$options_fields = paperplane_options_transients();
// verifico se esiste l'oggetto $post
if ( isset( $post ) ) {
	// se esiste l'oggetto $post richiamo l'array con i campi personalizzati
	$content_fields = paperplane_content_transients( $post->ID );
}
// imposto e valorizzo la variabile globale per definire il tipo di paginazione:
$theme_pagination = $options_fields['theme_pagination'];
// imposto l'array globale con le ID delle modal eventualmente inserite in pagina
// in questo modo se nella pagina sono presenti modal il loro ID viene aggiunto a questo array
// l'array viene poi usato nel footer per richiamare le modali
$cta_url_modal_array = array();
// imposto e valorizzo la variabile globale per definire il percorso della cartella del tema:
$static_bloginfo_stylesheet_directory = get_bloginfo( 'stylesheet_directory' );

if ( $options_fields['animations_option'] == 1 || $options_fields['opacity_option'] == 1 || $options_fields['darkmode_option'] == 1 ) {
	$html_a11y_user_prefs = '';
	$cookie_name = 'paperplane_user_preferences';
	$user_preferences = isset( $_COOKIE[ $cookie_name ] ) ? json_decode( stripslashes( $_COOKIE[ $cookie_name ] ), true ) : null;
	$dark_mode_checked = ( $user_preferences && isset( $user_preferences['dark_mode'] ) && $user_preferences['dark_mode'] == 1 ) ? 'true' : 'false';
	if ( $dark_mode_checked == 'true' ) {
		$html_a11y_user_prefs .= 'data-theme="dark" ';
	}
	$reduced_motion_checked = ( $user_preferences && isset( $user_preferences['reduced_motion'] ) && $user_preferences['reduced_motion'] == 0 ) ? 'true' : 'false';
	if ( $reduced_motion_checked == 'true' ) {
		$html_a11y_user_prefs .= 'data-reduced-motion="true" ';
	}
	$reduced_transparency_checked = ( $user_preferences && isset( $user_preferences['reduced_transparency'] ) && $user_preferences['reduced_transparency'] == 1 ) ? 'true' : 'false';
	if ( $reduced_transparency_checked == 'true' ) {
		$html_a11y_user_prefs .= 'data-reduced-transparency="true" ';
	}
} else {
	$html_a11y_user_prefs = '';
}
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> <?php echo $html_a11y_user_prefs; ?>>

<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
	<title>
		<?php wp_title( '|', true, 'right' ); ?>
	</title>
	<style>
		<?php readfile( get_template_directory() . '/critical.processed.css' ); ?>
	</style>

	<?php
	wp_head();
	?>
	<meta name="theme-color" content="<?php echo $options_fields['mobile_navbar_color']; ?>">
	<meta name="msapplication-navbutton-color" content="<?php echo $options_fields['mobile_navbar_color']; ?>">
	<meta name="apple-mobile-web-app-status-bar-style" content="<?php echo $options_fields['mobile_navbar_color']; ?>">
	<link rel="apple-touch-icon" sizes="57x57"
		href="<?php echo $static_bloginfo_stylesheet_directory; ?>/assets/images/favicons/apple-icon-57x57.png">
	<link rel="apple-touch-icon" sizes="60x60"
		href="<?php echo $static_bloginfo_stylesheet_directory; ?>/assets/images/favicons/apple-icon-60x60.png">
	<link rel="apple-touch-icon" sizes="72x72"
		href="<?php echo $static_bloginfo_stylesheet_directory; ?>/assets/images/favicons/apple-icon-72x72.png">
	<link rel="apple-touch-icon" sizes="76x76"
		href="<?php echo $static_bloginfo_stylesheet_directory; ?>/assets/images/favicons/apple-icon-76x76.png">
	<link rel="apple-touch-icon" sizes="114x114"
		href="<?php echo $static_bloginfo_stylesheet_directory; ?>/assets/images/favicons/apple-icon-114x114.png">
	<link rel="apple-touch-icon" sizes="120x120"
		href="<?php echo $static_bloginfo_stylesheet_directory; ?>/assets/images/favicons/apple-icon-120x120.png">
	<link rel="apple-touch-icon" sizes="144x144"
		href="<?php echo $static_bloginfo_stylesheet_directory; ?>/assets/images/favicons/apple-icon-144x144.png">
	<link rel="apple-touch-icon" sizes="152x152"
		href="<?php echo $static_bloginfo_stylesheet_directory; ?>/assets/images/favicons/apple-icon-152x152.png">
	<link rel="apple-touch-icon" sizes="180x180"
		href="<?php echo $static_bloginfo_stylesheet_directory; ?>/assets/images/favicons/apple-icon-180x180.png">
	<link rel="icon" type="image/png" sizes="192x192"
		href="<?php echo $static_bloginfo_stylesheet_directory; ?>/assets/images/favicons/android-icon-192x192.png">
	<link rel="icon" type="image/png" sizes="32x32"
		href="<?php echo $static_bloginfo_stylesheet_directory; ?>/assets/images/favicons/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="96x96"
		href="<?php echo $static_bloginfo_stylesheet_directory; ?>/assets/images/favicons/favicon-96x96.png">
	<link rel="icon" type="image/png" sizes="16x16"
		href="<?php echo $static_bloginfo_stylesheet_directory; ?>/assets/images/favicons/favicon-16x16.png">
	<meta name="msapplication-TileImage"
		content="<?php echo $static_bloginfo_stylesheet_directory; ?>/assets/images/favicons/ms-icon-144x144.png">
	<link rel="icon" type="image/png" sizes="1024x1024"
		href="<?php echo $static_bloginfo_stylesheet_directory; ?>/assets/images/favicons/favicon-1024x1024.png">
	<link rel="apple-touch-icon"
		href="<?php echo $static_bloginfo_stylesheet_directory; ?>/assets/images/favicons/favicon-1024x1024-maskable.png">
	<meta name="msapplication-TileColor" content="#ffffff">
	<?php
	// includo il manifesto per PWA se la PWA è attiva
	if ( $attivare_pwa == 1 ) :
		?>
		<link rel="manifest" href="<?php echo get_home_url(); ?>/manifest.json">
	<?php endif; ?>
	<!-- meta personalizzato per versione del tema -->
	<meta name="theme-version" data-theme-version="<?php echo $theme_version; ?>">
</head>

<body class="">
	<?php
	if ( function_exists( 'wp_body_open' ) ) {
		wp_body_open();
	}
	?>
	<!-- animazione barra di caricamento per PWA -->
	<div class="loader">
		<div class="bar"></div>
	</div>
	<?php
	// includo la navigazione accessibile
	include( locate_template( 'template-parts/grid/accessible-navi.php' ) );
	?>
	<div id="site-wrapper">
		<?php include( locate_template( 'template-parts/grid/header-message.php' ) ); ?>

		<header id="header">
			<div class="submenu-close submenu-close-js"></div>
			<div class="wrapper-padded">
				<div id="header-structure" class="navigation-height-counter">
					<div class="logo logo-mask-focus-visible">
						<a href="<?php echo home_url(); ?>" rel="bookmark"
							aria-label="<?php printf( esc_html__( 'Visita la homepage di %s', 'paperPlane-blankTheme' ), get_bloginfo( 'name' ) ); ?>"></a>
					</div>
					<nav class="header-main-menu-desktop"
						aria-label="<?php esc_html_e( 'Menu principale', 'paperPlane-blankTheme' ); ?>">
						<?php
						if ( has_nav_menu( 'header-menu' ) ) {
							wp_nav_menu( array(
								'theme_location' => 'header-menu',
								'walker' => new Paperplane_Accessible_Walker(),
								'container' => false,
								'menu_class' => 'menu-list header-menu-js',
								'items_wrap' => '<ul id="%1$s" class="%2$s" data-menu-type="desktop">%3$s</ul>'
							) );
						}
						?>
					</nav>
					<div class="side-head">
						<ul>
							<li>
								<button type="button" id="hamburger-button" class="hambuger-element"
									aria-haspopup="true" aria-expanded="false" aria-controls="head-overlay">
									<span class="screen-reader-text">
										<?php esc_html_e( 'Accedi al menu ad hamburger, usa la combinazione p + esc per chuidere il menu', 'paperPlane-blankTheme' ); ?>
									</span>
									<span class="ham-bar ham-bar-1"></span>
									<span class="ham-bar ham-bar-2"></span>
									<span class="ham-bar ham-bar-3"></span>
									<span class="ham-bar ham-bar-4"></span>
								</button>
							</li>
						</ul>
					</div>
				</div>
			</div>

			<div id="head-overlay" class="hidden">
				<div class="scroll-opportunity">
					<div class="wrapper">
						<nav class="header-main-menu-mobile"
							aria-label="<?php esc_html_e( 'Menu secondario', 'paperPlane-blankTheme' ); ?>">
							<?php
							if ( has_nav_menu( 'overlay-menu-mobile' ) ) {
								wp_nav_menu( array(
									'theme_location' => 'overlay-menu-mobile',
									'walker' => new Paperplane_Accessible_Walker(),
									'container' => false,
									'menu_class' => 'overlay-menu-mobile-js',
									'items_wrap' => '<ul id="%1$s" class="%2$s" data-menu-type="mobile">%3$s</ul>'
								) );
							}
							?>
						</nav>
						<div class="wrapper-padded">
							<!-- pannello per opzioni accessibilità e dark mode -->
							<?php if ( $options_fields['animations_option'] == 1 || $options_fields['opacity_option'] == 1 || $options_fields['darkmode_option'] == 1 ) : ?>
								<nav aria-label="<?php esc_html_e( 'Preferenze visive.', 'paperPlane-blankTheme' ); ?>">
									<?php include( locate_template( 'template-parts/grid/user-a11y-options.php' ) ); ?>
								</nav>
							<?php endif; ?>
							<?php if ( $options_fields['global_socials'] ) : ?>
								<nav aria-label="<?php esc_html_e( 'Menu social', 'paperPlane-blankTheme' ); ?>">
									<ul class="site-socials inline-socials">
										<?php
										foreach ( $options_fields['global_socials'] as $global_social ) :
											?>
											<li>
												<a href="<?php echo $global_social['global_socials_profile_url']; ?>"
													class="<?php echo $global_social['global_socials_icon']; ?>" target="_blank"
													aria-label="<?php echo $global_social['global_socials_screen_reader_text']; ?>"
													rel="noopener">
												</a>
											</li>
										<?php endforeach; ?>
									</ul>
								</nav>
							<?php endif; ?>
						</div>
					</div>
					<button type="button" class="overlay-navi-reset overlay-navi-reset-js"
						aria-label="<?php echo esc_html__( 'Ritorna al pulsante di apertura del menu', 'paperPlane-blankTheme' ); ?>"
						aria-labelledby="hamburger-button"></button>
				</div>

			</div>
		</header>
		<main id="page-content" tabindex="-1">
			<?php include( locate_template( 'template-parts/grid/page-opening.php' ) ); ?>

			<?php
			/**
			 * Barra di ricerca con integrazione suggerimenti
			 * Le opzioni sono gestite tramite /wp-admin/options-general.php?page=json-generator-settings
			 */
			include( locate_template( 'template-parts/grid/search-bar.php' ) );
			?>