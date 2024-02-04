<?php
function set_pwa_data() {
	// versione del tema
	global $theme_version;
	$favicons_folder = get_stylesheet_directory_uri() . '/assets/images/favicons/';
	// generate manifest
	$manifest_data = array();
	$manifest_data['name'] = get_field( 'pwa_name', 'option' );
	$manifest_data['short_name'] = get_field( 'pwa_short_name', 'option' );
	$manifest_data['description'] = get_field( 'pwa_short_description', 'option' );
	$manifest_data['id'] = get_home_url() . '/?utm_source=pwa-homescreen';
	$manifest_data['start_url'] = get_home_url() . '/?utm_source=pwa-homescreen';
	$manifest_data['scope'] = '/';
	$manifest_data['display'] = 'standalone';
	$manifest_data['lang'] = 'it-IT';
	$manifest_data['background_color'] = get_field( 'pwa_background_color', 'option' );
	$manifest_data['theme_color'] = get_field( 'pwa_theme_color', 'option' );
	$manifest_data['orientation'] = 'portrait-primary';
	$manifest_data['icons'][0]['src'] = $favicons_folder . 'favicon-1024x1024.png';
	$manifest_data['icons'][0]['type'] = 'image/png';
	$manifest_data['icons'][0]['sizes'] = '1024x1024';
	$manifest_data['icons'][0]['purpose'] = 'any';
	$manifest_data['icons'][1]['src'] = $favicons_folder . 'favicon-1024x1024-maskable.png';
	$manifest_data['icons'][1]['type'] = 'image/png';
	$manifest_data['icons'][1]['sizes'] = '1024x1024';
	$manifest_data['icons'][1]['purpose'] = 'maskable';
	if ( get_field( 'pwa_shortcuts', 'option' ) ) {
		$pwa_shortcuts = get_field( 'pwa_shortcuts', 'option' );
		foreach ( $pwa_shortcuts as $index => $pwa_shortcut ) {
			$manifest_data['shortcuts'][ $index ]['name'] = $pwa_shortcut['pwa_shortcut_name'];
			$manifest_data['shortcuts'][ $index ]['short_name'] = $pwa_shortcut['pwa_shortcut_short_name'];
			$manifest_data['shortcuts'][ $index ]['description'] = $pwa_shortcut['pwa_shortcut_description'];
			$manifest_data['shortcuts'][ $index ]['url'] = $pwa_shortcut['pwa_shortcut_url'];
			$manifest_data['shortcuts'][ $index ]['icons'][0]['src'] = $favicons_folder . 'android-icon-96x96.png';
			$manifest_data['shortcuts'][ $index ]['icons'][0]['sizes'] = '96x96';
		}
	}
	if ( get_field( 'pwa_screenshots', 'option' ) ) {
		$pwa_screenshots = get_field( 'pwa_screenshots', 'option' );
		foreach ( $pwa_screenshots as $index => $pwa_screenshot ) {
			if ( $pwa_screenshot['pwa_screenshot_image']['sizes']['column_hd-width'] > $pwa_screenshot['pwa_screenshot_image']['sizes']['column_hd-height'] ) {
				$form_factor = 'wide';
			} else {
				$form_factor = 'narrow';
			}
			$manifest_data['screenshots'][ $index ]['src'] = $pwa_screenshot['pwa_screenshot_image']['sizes']['column_hd'];
			$manifest_data['screenshots'][ $index ]['sizes'] = $pwa_screenshot['pwa_screenshot_image']['sizes']['column_hd-width'] . 'x' . $pwa_screenshot['pwa_screenshot_image']['sizes']['column_hd-height'];
			$manifest_data['screenshots'][ $index ]['type'] = 'image/' . $pwa_screenshot['pwa_screenshot_image']['subtype'];
			$manifest_data['screenshots'][ $index ]['form_factor'] = $form_factor;
			$manifest_data['screenshots'][ $index ]['label'] = $pwa_screenshot['pwa_screenshot_image_label'];
		}
	}
	//var_dump( $manifest_data );
	//die();

	$manifest_data_ = array(
		'name' => get_bloginfo( 'name' ),
		'short_name' => get_bloginfo( 'name' ),
		'description' => get_bloginfo( 'description' ),
		'id' => get_home_url() . '/?utm_source=pwa-homescreen',
		'start_url' => get_home_url() . '/?utm_source=pwa-homescreen',
		'scope' => get_home_url(),
		'display' => 'standalone',
		'lang' => 'it-IT',
		'background_color' => $manifest_data['background_color'],
		'theme_color' => $manifest_data['theme_color'],
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
		'screenshots' => array(
			array(
				'src' => $manifest_data['screenshots'][ $index ]['src'],
				'sizes' => '1280x720',
				'type' => 'image/png',
				'form_factor' => 'wide',
				'label' => 'Homescreen di' . get_bloginfo( 'name' ),
			),
			array(
				'src' => $manifest_data['screenshots'][ $index ]['src'],
				'sizes' => '720x1280',
				'type' => 'image/png',
				'form_factor' => 'narrow',
				'label' => 'Homescreen di' . get_bloginfo( 'name' ),
			),
		),
	);


	// encode manifest data
	$manifest_data = stripslashes( json_encode( $manifest_data ) );
	// set path to manifest.json file
	$manifest_file = '/../../../../manifest.json';
	// write/overwrite manifest.json on site root folder
	file_put_contents( __DIR__ . $manifest_file, $manifest_data );
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
	file_put_contents( __DIR__ . $sw_file, $sw_data );
	// copy/overwrite sw.js to site root folder
	//copy(__DIR__ . '/../assets/pwa/sw.js', __DIR__ . '/../../../../sw.js');
	$offline_page_data = '<!doctype html>
  <html lang="it">
  <head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>' . get_bloginfo( 'name' ) . ' | ' . get_bloginfo( 'description' ) . '</title>
  <meta name="description" content="' . get_bloginfo( 'name' ) . ' | ' . get_bloginfo( 'description' ) . '">
  <meta name="author" content="' . get_bloginfo( 'name' ) . '">
  <meta name="robots" content="noindex, nofollow" />
  <style>
  body {
    background-color: ' . get_field( 'uc_m_bgcolor', 'option' ) . ';
    color: ' . get_field( 'uc_m_color', 'option' ) . ';
    font-family:Arial, Helvetica, sans-serif;
  }
  * {
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    box-sizing: border-box;
    margin: 0;
    padding: 0;
  }
  .offline-page {
    position: relative;
    width: 100%;
    overflow: hidden;
    min-height: 100dvh;
    display: grid;
    padding: 0;
    margin: 0;
    align-content: center;
    width: 100%;
  }
  .content {
    position: relative;
    text-align: center;
    max-width: 750px;
    margin: 0 auto;
    padding: 4vw;
  }

  .content img {
    max-width: 200px;
    height: auto;
    margin: 0 0 30px 0;
  }

  h1 {
    font-size: 20px;
    line-height: 28px;
  }
  </style>
  </head>
  <body>
  <div class="offline-page">
  <div class="content">
  <img src="' . parse_url( get_stylesheet_directory_uri(), PHP_URL_PATH ) . '/assets/images/site-logo-header.svg" />
  <h1>Nessuna connessioen disponibile.<br />No connection avialable.</h1>
  </div>
  </div>
  </body>
  </html>';
	$offline_page_file = '/../../../../offline.html';
	// write/overwrite manifest.json on site root folder
	file_put_contents( __DIR__ . $offline_page_file, $offline_page_data );
}

function unset_pwa_data() {
	$upload_info = get_home_path();
	//$file = $upload_info['basedir'] . '/manifest.json';
	var_dump( $upload_info );
	wp_delete_file( $upload_info . 'manifest.json' );
	wp_delete_file( $upload_info . 'sw.js' );
}

function manage_pwa_files() {
	$screen = get_current_screen();
	$attivare_pwa = get_field( 'attivare_pwa', 'option' );
	if ( strpos( $screen->id, 'theme-general-settings' ) == true ) {
		if ( $attivare_pwa == false ) {
			unset_pwa_data();
		} else {
			set_pwa_data();
		}
	}
}
add_action( 'acf/save_post', 'manage_pwa_files', 20 );