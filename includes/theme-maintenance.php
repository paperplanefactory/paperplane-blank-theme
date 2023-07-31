<?php
function paperplane_set_maintenance_page() {
	// versione del tema
	global $theme_version;
	$color = '#000000';
	$bg_color = '#FFFFFF';
	$favicons_folder = get_stylesheet_directory_uri() . '/assets/images/favicons/';
	$maintenance_message = get_field( 'maintenance_message', 'option' );
	if ( $maintenance_message ) {
		$message_m = $maintenance_message;
	} else {
		$message_m = 'Sito in manutenzione - torneremo online in un minuto.<br />
      Site under maintenance - we will be back online in a minute.';

	}
	$underconstruction_message = get_field( 'underconstruction_message', 'option' );
	if ( $underconstruction_message ) {
		$message_u = $maintenance_message;
	} else {
		$message_u = 'Sito in costruzione.<br />
    Under construction.';

	}
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
    background-color: ' . $bg_color . ';
    color: ' . $color . ';
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
  <h1>
  ' . $message_m . '
  </h1>
  </div>
  </div>
  </body>
  </html>';
	$offline_page_file = '/../../../maintenance.php';
	// write/overwrite manifest.json on site root folder
	file_put_contents( __DIR__ . $offline_page_file, $offline_page_data );
















	$underconstruction_page_data = '<!doctype html>
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
    background-color: ' . $bg_color . ';
    color: ' . $color . ';
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
  <h1>
  ' . $message_u . '
  </h1>
  </div>
  </div>
  </body>
  </html>';
	$underconstruction_page_file = '/../under-construction.php';
	// write/overwrite manifest.json on site root folder
	file_put_contents( __DIR__ . $underconstruction_page_file, $underconstruction_page_data );
}


function paperplane_manage_maintenance_files() {
	$screen = get_current_screen();
	if ( strpos( $screen->id, 'theme-general-settings' ) == true ) {
		paperplane_set_maintenance_page();
	}
}
add_action( 'acf/save_post', 'paperplane_manage_maintenance_files', 20 );