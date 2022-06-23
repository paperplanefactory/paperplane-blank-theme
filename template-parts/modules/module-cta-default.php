<?php
$cta_data = get_sub_field('module_additional_elements_cta_data');
$cta_appearence = get_sub_field( 'module_additional_elements_cta_appearence' );
$cta_advanced_options = get_sub_field( 'module_additional_elements_cta_altre_funzioni' );
$cta_url_modal_id = get_sub_field( 'module_additional_elements_cta_modal' );
$cta_file = get_sub_field( 'module_additional_elements_cta_file' );
if ( $cta_data != '' ) {
  print_theme_cta( $cta_data, $cta_appearence, $cta_advanced_options, $cta_url_modal_id, $cta_file );
}
?>
