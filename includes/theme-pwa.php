<?php
function set_pwa_data()
{
  // versione del tema
  global $theme_version;
  $color = '#FFFFFF';
  $bg_color = '#000000';
  $favicons_folder = get_stylesheet_directory_uri() . '/assets/images/favicons/';
  // generate manifest
  $manifest_data = array(
    'name' => get_bloginfo('name'),
    'short_name' => get_bloginfo('name'),
    'description' => get_bloginfo('description'),
    'start_url' => get_home_url() . '/?utm_source=pwa-homescreen',
    'scope' => get_home_url(),
    'display' => 'standalone',
    'lang' => 'it-IT',
    'background_color' => $bg_color,
    'theme_color' => $color,
    'orientation' => 'portrait-primary',
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
  );
  // encode manifest data
  $manifest_data = stripslashes(json_encode($manifest_data));
  // set path to manifest.json file
  $manifest_file = '/../../../../manifest.json';
  // write/overwrite manifest.json on site root folder
  file_put_contents(__DIR__ . $manifest_file, $manifest_data);
  $sw_data = "importScripts('https://storage.googleapis.com/workbox-cdn/releases/5.1.2/workbox-sw.js');
  const CACHE = \"paperplane-offline-page-" . $theme_version . "\";
  const offlineFallbackPage = \"/offline.html\";
  
  self.addEventListener(\"message\", (event) => {
    if (event.data && event.data.type === \"SKIP_WAITING\") {
      self.skipWaiting();
    }
  });
  
  self.addEventListener('install', async (event) => {
    event.waitUntil(
      caches.open(CACHE)
        .then((cache) => cache.add(offlineFallbackPage))
    );
  });
  
  if (workbox.navigationPreload.isSupported()) {
    workbox.navigationPreload.enable();
  }
  
  self.addEventListener('fetch', (event) => {
    if (event.request.mode === 'navigate') {
      event.respondWith((async () => {
        try {
          const preloadResp = await event.preloadResponse;
  
          if (preloadResp) {
            return preloadResp;
          }
  
          const networkResp = await fetch(event.request);
          return networkResp;
        } catch (error) {
  
          const cache = await caches.open(CACHE);
          const cachedResp = await cache.match(offlineFallbackPage);
          return cachedResp;
        }
      })());
    }
  });";
  //$sw_data = stripslashes(json_encode($sw_data));
  // set path to manifest.json file
  $sw_file = '/../../../../sw.js';
  // write/overwrite manifest.json on site root folder
  file_put_contents(__DIR__ . $sw_file, $sw_data);
  // copy/overwrite sw.js to site root folder
  //copy(__DIR__ . '/../assets/pwa/sw.js', __DIR__ . '/../../../../sw.js');
  $offline_page_data = '<!doctype html>
  <html lang="it">
  <head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>' . get_bloginfo('name') . ' | ' . get_bloginfo('description') . '</title>
  <meta name="description" content="' . get_bloginfo('name') . ' | ' . get_bloginfo('description') . '">
  <meta name="author" content="' . get_bloginfo('name') . '">
  <meta name="robots" content="noindex, nofollow" />
  <style>
  body {
    background-color: ' . $bg_color . ';
    color: ' . $color . ';
    font-family:Arial, Helvetica, sans-serif;
  }
  * {
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    box-sizing: border-box;
  }
  .offline-page {
    position: absolute;
    width: 100%;
    padding: calc(3vw + 70px) 3vw 3vw 3vw;
    text-align: center;
    background-image: url("' . parse_url(get_stylesheet_directory_uri(), PHP_URL_PATH) . '/assets/images/site-logo-header.svg");
    background-position: 50% 3vw;
    background-repeat: no-repeat;
    background-size: auto 50px;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
  }

  h1 {
    font-size: 20px;
  }
  </style>
  </head>
  <body>
  <div class="offline-page">
  <h1>You are offline</h1>
  </div>
  </body>
  </html>';
  $offline_page_file = '/../../../../offline.html';
  // write/overwrite manifest.json on site root folder
  file_put_contents(__DIR__ . $offline_page_file, $offline_page_data);
}

function unset_pwa_data()
{
  $upload_info = get_home_path();
  //$file = $upload_info['basedir'] . '/manifest.json';
  var_dump($upload_info);
  wp_delete_file($upload_info . 'manifest.json');
  wp_delete_file($upload_info . 'sw.js');
}

function manage_pwa_files()
{
  $screen = get_current_screen();
  $attivare_pwa = get_field('attivare_pwa', 'option');
  if (strpos($screen->id, "theme-general-settings") == true) {
    if ($attivare_pwa == false) {
      unset_pwa_data();
    } else {
      set_pwa_data();
    }
  }
}
add_action('acf/save_post', 'manage_pwa_files', 20);

global $attivare_pwa;
if ($attivare_pwa == true) {
  add_action('wp_enqueue_scripts', 'pwa_scripts');
}

function pwa_scripts()
{
  global $theme_version;
  wp_register_script('theme-pwa-install', get_template_directory_uri() . '/assets/pwa/pwa-install.min.js', array(), $theme_version, false);
  wp_enqueue_script('theme-pwa-install');
}