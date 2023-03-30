<?php
function set_pwa_data()
{
  // versione del tema
  global $theme_version;
  $favicons_folder = get_stylesheet_directory_uri() . '/assets/images/favicons/';
  // generate manifest
  $manifest_data = array(
    'name' => get_bloginfo('name'),
    'short_name' => get_bloginfo('name'),
    'description' => get_bloginfo('description'),
    'start_url' => get_home_url() . '/?utm_source=pwa-homescreen',
    'scope' => get_home_url(),
    'icons' => array(
      array(
        'src' => $favicons_folder . 'favicon-1024x1024.png',
        'type' => 'image\/png',
        'sizes' => '1024x1024',
        'purpose' => 'any'
      ),
      array(
        'src' => $favicons_folder . 'favicon-1024x1024-maskable.png',
        'type' => 'image\/png',
        'sizes' => '1024x1024',
        'purpose' => 'maskable'
      ),
    ),
    'display' => 'standalone',
    'lang' => 'it-IT',
    'background_color' => '#FFFFFF',
    'theme_color' => '#D10019',
    'orientation' => 'portrait-primary',
    'lang' => 'it-IT',
    'shortcuts' => array(
      array(
        'name' => 'Cartellone',
        'url' => '/cartellone',
        'description' => 'Consulta il cartellone del Teatro Franco Parenti'
      ),
      array(
        'name' => 'Calendario',
        'url' => '/calendario',
        'description' => 'Consulta il calendario del Teatro Franco Parenti'
      ),
    ),
  );
  // encode manifest data
  $manifest_data = stripslashes(json_encode($manifest_data));
  // set path to manifest.json file
  $file = '/../../../../manifest.json';
  // write/overwrite manifest.json on site root folder
  file_put_contents(__DIR__ . $file, $manifest_data);
  // copy/overwrite sw.js to site root folder
  copy(__DIR__ . '/../assets/pwa/sw.js', __DIR__ . '/../../../../sw.js');
}

function unset_pwa_data()
{


  //wp_delete_file($file);
}

add_action('wp_enqueue_scripts', 'pwa_scripts');
function pwa_scripts()
{
  global $theme_version;
  wp_register_script('theme-pwa-install', get_template_directory_uri() . '/assets/pwa/pwa-install.min.js#deferload', '', $theme_version, false);
  wp_enqueue_script('theme-pwa-install');
}

function manage_pwa_files()
{

  $screen = get_current_screen();
  if (strpos($screen->id, "theme-general-settings") == true) {
    $attivare_pwa = get_field('attivare_pwa', 'option');
    if ($attivare_pwa == true) {
      var_dump($attivare_pwa);
      //die();
      set_pwa_data();
    } elseif ($attivare_pwa == false) {
      $upload_info = get_home_path();
      //$file = $upload_info['basedir'] . '/manifest.json';
      var_dump($upload_info);
      wp_delete_file($upload_info . 'manifest.json');
      die();
    }
  }
}
add_action('acf/save_post', 'manage_pwa_files', 20);