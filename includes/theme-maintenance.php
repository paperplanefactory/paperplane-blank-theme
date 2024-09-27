<?php
function paperplane_set_maintenance_page() {
	// versione del tema
	global $theme_version;
	$color = get_field( 'uc_m_color', 'option' );
	$bg_color = get_field( 'uc_m_bgcolor_copia', 'option' );
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
	$underconstruction_embed = get_field( 'underconstruction_embed', 'option' );
	$underconstruction_embed_css = get_field( 'underconstruction_embed_css', 'option' );
	$custom_page_image = get_field( 'custom_page_image', 'option' );
	if ( $custom_page_image ) {
		$page_image = $custom_page_image['sizes']['column_cut_hd'];
	} else {
		$page_image = parse_url( get_stylesheet_directory_uri(), PHP_URL_PATH ) . '/assets/images/site-logo-header.svg';
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
  <img src="' . $page_image . '" />
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
    padding: 4vw;
    margin: 0;
    align-content: center;
    width: 100%;
  }
  .content {
    position: relative;
    text-align: center;
    max-width: 750px;
    margin: 0 auto;
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
  .embed {
    position: relative;
    padding-bottom: 26.25% !important;
    overflow: hidden !important;
    height: auto !important;
    width: 100%;
    max-width: 900px;
    ' . $underconstruction_embed_css . '
  }
  .embed embed,
  .embed iframe,
  .embed object {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
  }
  .embed video {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
  }
  </style>
  </head>
  <body>
  <div class="offline-page">
  <div class="content">
  <img src="' . $page_image . '" />
  <h1>
  ' . $message_u . '
  </h1>
  </div>';
	if ( $underconstruction_page_data != '' ) :
		$underconstruction_page_data .= '<div class="embed">' . $underconstruction_embed . '</div>';
	endif;
	$underconstruction_page_data .= '</div>
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