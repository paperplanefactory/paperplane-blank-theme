<?php
$cta_data = get_field('page_opening_cta_data');
$cta_appearence = get_field( 'page_opening_cta_appearence' );
$cta_advanced_options = get_field( 'page_opening_cta_altre_funzioni' );
$cta_url_modal_id = get_field( 'page_opening_cta_modal' );
$cta_file = get_field( 'page_opening_cta_file' );
if ( $cta_data != '' ) {
  print_theme_cta( $cta_data, $cta_appearence, $cta_advanced_options, $cta_url_modal_id, $cta_file );
}
?>
