<?php
// Paperplane _blankTheme - template per header.
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0, user-scalable=yes">
	<title>
		<?php wp_title( '|', true, 'right' ); ?>
	</title>
	<?php
	wp_head();
	global $use_transients_fields, $theme_version, $acf_options_parameter, $static_bloginfo_stylesheet_directory, $options_fields, $options_fields_multilang, $cta_url_modal_array, $theme_pagination, $attivare_pwa;
	// Imposto la variabile globale per definire:
// - se è attivo Polylang il linguaggio in cui l'utente sta visitando il sito
// - se non è attivo Polylang un valore generico 'any-lang'
	if ( function_exists( 'pll_the_languages' ) ) {
		$acf_options_parameter = pll_current_language( 'slug' );
	} else {
		$acf_options_parameter = 'any-lang';
	}
	// Imposto e valorizzo la variabile globale per definire il tipo di paginazione:
	$theme_pagination = get_field( 'theme_pagination', 'option' );
	// Imposto e valorizzo l'array globale con le ID delle modal eventualmente inserite in pagina:
	$cta_url_modal_array = array();
	// Imposto e valorizzo la variabile globale per definire la cartella del tema:
	$static_bloginfo_stylesheet_directory = get_bloginfo( 'stylesheet_directory' );
	// Genero le trnasients delle pagine di opzioni
	paperplane_options_transients();
	?>
	<!-- Chrome, Firefox OS and Opera -->
	<meta name="theme-color" content="<?php echo $options_fields['mobile_navbar_color']; ?>">
	<!-- Windows Phone -->
	<meta name="msapplication-navbutton-color" content="<?php echo $options_fields['mobile_navbar_color']; ?>">
	<!-- iOS Safari -->
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
	<?php if ( $attivare_pwa == 1 ) : ?>
		<link rel="manifest" href="<?php echo get_home_url(); ?>/manifest.json">
		<link rel="prefetch" href="<?php echo get_home_url(); ?>/manifest.json">
	<?php endif; ?>
</head>

<body>
	<div class="loader">
		<div class="bar"></div>
	</div>
	<?php include( locate_template( 'template-parts/grid/accessible-navi.php' ) ); ?>
	<div id="site-wrapper">
		<div id="preheader"></div>
		<header id="header" data-had-class="">
			<div class="wrapper-padded">
				<div class="">
					<div id="header-structure">
						<div class="logo">
							<a href="<?php echo home_url(); ?>" rel="bookmark"
								title="homepage - <?php echo get_bloginfo( 'name' ); ?>"
								aria-label="homepage - <?php echo get_bloginfo( 'name' ); ?>"></a>
						</div>
						<nav class="menu" aria-label="<?php _e( 'Menu principale', 'paperPlane-blankTheme' ); ?>">
							<?php
							if ( has_nav_menu( 'header-menu' ) ) {
								wp_nav_menu( array( 'theme_location' => 'header-menu', 'container' => 'ul', 'menu_class' => 'header-menu header-menu-js' ) );
							}
							?>
						</nav>
						<div class="side-head">
							<ul>
								<li>
									<button class="hambuger-element ham-activator-js" aria-haspopup="true"
										aria-expanded="false" aria-controls="head-overlay"
										title="<?php _e( 'Premi invio per accedere al menu ad hamburger', 'paperPlane-blankTheme' ); ?>"
										aria-label="<?php _e( 'Premi invio per accedere al menu ad hamburger', 'paperPlane-blankTheme' ); ?>">
										<span></span>
										<span></span>
										<span></span>
										<span></span>
									</button>
								</li>
							</ul>
						</div>
					</div>
				</div>
			</div>
			<div class="submenu-close submenu-close-js"></div>
		</header>
		<div id="head-overlay" class="hidden bg-4" aria-hidden="true">
			<div class="scroll-opportunity scroll-opportunity-overlay-js">
				<div class="wrapper">
					<div class="wrapper-padded">
						<nav class="menu" aria-label="<?php _e( 'Menu secondario', 'paperPlane-blankTheme' ); ?>">
							<?php
							if ( has_nav_menu( 'overlay-menu-mobile' ) ) {
								wp_nav_menu( array( 'theme_location' => 'overlay-menu-mobile', 'container' => 'ul', 'menu_class' => 'overlay-menu-css overlay-menu-mobile-js' ) );
							}
							?>
						</nav>
						<?php if ( $options_fields['animations_option'] == 1 ) : ?>
							<nav class="user-accessibility-options"
								aria-label="<?php _e( 'Preferenze accessibilità', 'paperPlane-blankTheme' ); ?>">
								<?php include( locate_template( 'template-parts/grid/user-a11y-options.php' ) ); ?>
							</nav>
						<?php endif; ?>
						<?php if ( $options_fields['global_socials'] ) : ?>
							<nav aria-label="<?php _e( 'Menu social', 'paperPlane-blankTheme' ); ?>">
								<ul class="site-socials inline-socials">
									<?php
									foreach ( $options_fields['global_socials'] as $global_social ) :
										$parse_social = parse_url( $global_social['global_socials_profile_url'] );
										?>
										<li>
											<a href="<?php echo $global_social['global_socials_profile_url']; ?>"
												class="<?php echo $global_social['global_socials_icon']; ?>" target="_blank"
												aria-label="<?php echo __( 'Visita il nostro profilo su', 'paperPlane-blankTheme' ) . ' ' . $parse_social['host'] . ' ' . __( '- si apre in una nuova finestra', 'paperPlane-blankTheme' ); ?>"
												rel="noopener">
											</a>
										</li>
									<?php endforeach; ?>
								</ul>
							</nav>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
		<main id="page-content">
			<?php include( locate_template( 'template-parts/grid/page-opening.php' ) ); ?>