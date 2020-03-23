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
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- Chrome, Firefox OS and Opera -->
<meta name="theme-color" content="#000000">
<!-- Windows Phone -->
<meta name="msapplication-navbutton-color" content="#000000">
<!-- iOS Safari -->
<meta name="apple-mobile-web-app-status-bar-style" content="#000000">
<title><?php wp_title( '|', true, 'right' ); ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<?php
wp_head();
global $acf_options_parameter;
if (function_exists('pll_the_languages')) {
  $acf_options_parameter = pll_current_language('slug');
}
else {
  $acf_options_parameter = 'any-lang';
}

?>
<link rel="apple-touch-icon" sizes="57x57" href="<?php bloginfo('stylesheet_directory'); ?>/assets/images/favicons/apple-icon-57x57.png">
<link rel="apple-touch-icon" sizes="60x60" href="<?php bloginfo('stylesheet_directory'); ?>/assets/images/favicons/apple-icon-60x60.png">
<link rel="apple-touch-icon" sizes="72x72" href="<?php bloginfo('stylesheet_directory'); ?>/assets/images/favicons/apple-icon-72x72.png">
<link rel="apple-touch-icon" sizes="76x76" href="<?php bloginfo('stylesheet_directory'); ?>/assets/images/favicons/apple-icon-76x76.png">
<link rel="apple-touch-icon" sizes="114x114" href="<?php bloginfo('stylesheet_directory'); ?>/assets/images/favicons/apple-icon-114x114.png">
<link rel="apple-touch-icon" sizes="120x120" href="<?php bloginfo('stylesheet_directory'); ?>/assets/images/favicons/apple-icon-120x120.png">
<link rel="apple-touch-icon" sizes="144x144" href="<?php bloginfo('stylesheet_directory'); ?>/assets/images/favicons/apple-icon-144x144.png">
<link rel="apple-touch-icon" sizes="152x152" href="<?php bloginfo('stylesheet_directory'); ?>/assets/images/favicons/apple-icon-152x152.png">
<link rel="apple-touch-icon" sizes="180x180" href="<?php bloginfo('stylesheet_directory'); ?>/assets/images/favicons/apple-icon-180x180.png">
<link rel="icon" type="image/png" sizes="192x192"  href="<?php bloginfo('stylesheet_directory'); ?>/assets/images/favicons/android-icon-192x192.png">
<link rel="icon" type="image/png" sizes="32x32" href="<?php bloginfo('stylesheet_directory'); ?>/assets/images/favicons/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="96x96" href="<?php bloginfo('stylesheet_directory'); ?>/assets/images/favicons/favicon-96x96.png">
<link rel="icon" type="image/png" sizes="16x16" href="<?php bloginfo('stylesheet_directory'); ?>/assets/images/favicons/favicon-16x16.png">
<link rel="manifest" href="<?php bloginfo('stylesheet_directory'); ?>/assets/images/favicons/manifest.json">
<meta name="msapplication-TileColor" content="#ffffff">
<meta name="msapplication-TileImage" content="<?php bloginfo('stylesheet_directory'); ?>/assets/images/favicons/ms-icon-144x144.png">
</head>

<body>

<div id="preheader"></div>
<header id="header" class="combo-1">
  <div class="wrapper-padded">
    <div id="header-structure">
      <div class="logo">
        <a href="<?php echo home_url(); ?>" rel="bookmark" title="homepage - <?php echo get_bloginfo( 'name' ); ?>" class="absl"></a>
      </div>
      <nav class="menu allupper">
        <?php
        if ( has_nav_menu( 'header-menu' ) ) {
          wp_nav_menu( array( 'theme_location' => 'header-menu', 'container' => 'ul', 'menu_class' => 'header-menu' ) );
        }
        ?>
      </nav>
      <div class="side-head">
        <ul>
          <li>
            <div type="button" aria-haspopup="true" aria-expanded="false" aria-label="Navigation" class="hambuger-element ham-activator">
              <span></span>
              <span></span>
              <span></span>
              <span></span>
            </div>
          </li>
        </ul>
      </div>
    </div>
  </div>
</header>
<?php include( locate_template( 'template-parts/grid/mega-menu.php' ) ); ?>

<div id="head-overlay" class="hidden bg-1 combo-1">
  <div class="scroll-opportunity">
    <div class="wrapper">
      <div class="wrapper-padded">
        <div class="wrapper-padded-more">
          <?php if ( have_rows( 'global_socials', 'option' ) ) : ?>
            <ul class="inline-socials">
              <?php while ( have_rows( 'global_socials', 'option' ) ) : the_row(); ?>
                <li>
                  <a href="<?php the_sub_field( 'global_socials_profile_url' ); ?>" target="_blank" aria-label="Visit <?php the_sub_field( 'global_socials_profile_url' ); ?>" rel="noopener">
                    <i class="<?php the_sub_field( 'global_socials_icona' ); ?>" aria-hidden="true"></i>
                  </a>
                </li>
              <?php endwhile; ?>
            </ul>
          <?php endif; ?>
          <h1><i class="fas fa-space-shuttle"></i> Test spazio verticale viewport</h1>
          <h1><i class="fas fa-space-shuttle"></i> Test spazio verticale viewport</h1>
          <h1>Test spazio verticale viewport</h1>
          <h1>Test spazio verticale viewport</h1>
          <h1>Test spazio verticale viewport</h1>
          <h1>Test spazio verticale viewport</h1>
          <h1>Test spazio verticale viewport</h1>
          <h1>Test spazio verticale viewport</h1>
          <h1>Test spazio verticale viewport</h1>
          <h1>Test spazio verticale viewport</h1>
          <h1>Test spazio verticale viewport</h1>
          <h1>Test spazio verticale viewport</h1>
          <h1>Test spazio verticale viewport</h1>
          <h1>Test spazio verticale viewport</h1>
          <h1>Test spazio verticale viewport</h1>
          <h1>Test spazio verticale viewport</h1>
          <h1>Test spazio verticale viewport</h1>
          <h1>Test spazio verticale viewport</h1>
          <h1>Test spazio verticale viewport</h1>
          <h1>Test spazio verticale viewport</h1>
          <h1>Test spazio verticale viewport</h1>
          <h1>Test spazio verticale viewport</h1>
          <h1>Test spazio verticale viewport</h1>
          <h1>Test spazio verticale viewport</h1>
          <h1>Test spazio verticale viewport</h1>
          <h1>Test spazio verticale viewport</h1>
          <h1>Test spazio verticale viewport</h1>
          <h1>Test spazio verticale viewport</h1>
          <h1>Test spazio verticale viewport</h1>
          <h1>Test spazio verticale viewport</h1>
          <h1>Test spazio verticale viewport</h1>
          <h1>Test spazio verticale viewport</h1>
          <h1>Test spazio verticale viewport</h1>
        </div>
      </div>
    </div>
  </div>
</div>
