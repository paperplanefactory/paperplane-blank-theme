<?php
// Paperplane _blankTheme - template per header.
?>
<!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) | !(IE 8)  ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->

<head>
  <meta charset="<?php bloginfo('charset'); ?>" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0, user-scalable=yes">
  <title>
    <?php wp_title('|', true, 'right'); ?>
  </title>
  <link rel="profile" href="http://gmpg.org/xfn/11">
  <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
  <?php
  wp_head();
  global $theme_version, $acf_options_parameter, $static_bloginfo_stylesheet_directory, $options_fields, $options_fields_multilang, $cta_url_modal_array, $theme_pagination, $footer_wrapper, $mega_menu_wrapper, $header_wrapper, $attivare_pwa;
  // Imposto la variabile globale per definire:
// - se è attivo Polylang il linguaggio in cui l'utente sta visitando il sito
// - se non è attivo Polylang un valore generico 'any-lang'
  if (function_exists('pll_the_languages')) {
    $acf_options_parameter = pll_current_language('slug');
  } else {
    $acf_options_parameter = 'any-lang';
  }
  // Imposto e valorizzo le variabili globali per definire i wrapper:
  $header_width = get_field('theme_header_width', 'option');
  if ($header_width === 'full-width') {
    $header_wrapper = '';
    $mega_menu_wrapper = '';
  }
  if ($header_width === 'contained-width') {
    $header_wrapper = 'wrapper-padded-more';
    $mega_menu_wrapper = 'mega-menu-holder-contained';
  }
  $footer_width = get_field('theme_footer_width', 'option');
  if ($footer_width === 'full-width') {
    $footer_wrapper = '';
  }
  if ($footer_width === 'contained-width') {
    $footer_wrapper = 'wrapper-padded-more';
  }
  // Imposto e valorizzo la variabile globale per definire il tipo di paginazione:
  $theme_pagination = get_field('theme_pagination', 'option');
  // Imposto e valorizzo l'array globale con le ID delle modal eventualmente inserite in pagina:
  $cta_url_modal_array = array();
  // Imposto e valorizzo la variabile globale per definire la cartella del tema:
  $static_bloginfo_stylesheet_directory = get_bloginfo('stylesheet_directory');
  // Genero le trnasients delle pagine di opzioni
  paperplane_options_transients();
  ?>
  <!-- Chrome, Firefox OS and Opera -->
  <meta name="theme-color" content="#000000">
  <!-- Windows Phone -->
  <meta name="msapplication-navbutton-color" content="#000000">
  <!-- iOS Safari -->
  <meta name="apple-mobile-web-app-status-bar-style" content="#000000">
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
  <?php if ($attivare_pwa == 1): ?>
    <link rel="manifest" href="<?php echo get_home_url(); ?>/manifest.json">
    <link rel="prefetch" href="<?php echo get_home_url(); ?>/manifest.json">

  <?php endif; ?>

</head>

<body>
  <?php include(locate_template('template-parts/grid/accessible-navi.php')); ?>
  <div id="site-wrapper">
    <div id="preheader"></div>
    <header id="header" class="colors-black-bg">
      <div class="wrapper-padded">
        <div class="<?php echo $header_wrapper; ?>">
          <div id="header-structure">
            <div class="logo">
              <a href="<?php echo home_url(); ?>" rel="bookmark" title="homepage - <?php echo get_bloginfo('name'); ?>"
                class="absl"></a>
            </div>
            <nav class="menu allupper">
              <?php
              if (has_nav_menu('header-menu')) {
                wp_nav_menu(array('theme_location' => 'header-menu', 'container' => 'ul', 'menu_class' => 'header-menu header-menu-js'));
              }
              ?>
            </nav>
            <div class="side-head">
              <ul>
                <li>
                  <button class="hambuger-element ham-activator" aria-haspopup="true" aria-controls="head-overlay"
                    onclick="hamburgerMenu()"
                    title="<?php _e('Accedi al menu ad hamburger', 'paperPlane-blankTheme'); ?>"
                    aria-label="<?php _e('Accedi al menu ad hamburger', 'paperPlane-blankTheme'); ?>">
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
    <?php include(locate_template('template-parts/grid/mega-menu.php')); ?>

    <div id="head-overlay" class="hidden colors-black-bg" aria-hidden="true">
      <div class="scroll-opportunity">
        <div class="wrapper">
          <nav class="menu">
            <?php
            if (has_nav_menu('overlay-menu-mobile')) {
              wp_nav_menu(array('theme_location' => 'overlay-menu-mobile', 'container' => 'ul', 'menu_class' => 'overlay-menu-mobile-css overlay-menu-mobile-js'));
            }
            ?>
          </nav>
          <?php if ($options_fields): ?>
            <ul class="inline-socials">
              <?php foreach ($options_fields['global_socials'] as $global_social): ?>
                <li>
                  <a href="<?php echo $global_social['global_socials_profile_url']; ?>"
                    class="<?php echo $global_social['global_socials_icon']; ?>" target="_blank"
                    aria-label="Visit <?php echo $global_social['global_socials_profile_url']; ?>" rel="noopener">
                  </a>
                </li>
              <?php endforeach; ?>
            </ul>
          <?php endif; ?>
        </div>
      </div>
    </div>
    <div id="page-content">
      <?php include(locate_template('template-parts/grid/page-opening.php')); ?>