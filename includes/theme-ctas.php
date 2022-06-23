<?php
function print_theme_cta( $cta_data, $cta_appearence, $cta_advanced_options, $cta_url_modal_id, $cta_file ) {
  $cta_title = $cta_data['title'];
  $cta_url = $cta_data['url'];
  $cta_target = $cta_data['target'] ? $cta_data['target'] : '_self';
  $cta_url_modal_class = '';
  if ( $cta_advanced_options === 'cta-modal' ) {
    global $cta_url_modal_array;
    $cta_url_modal_array[] = $cta_url_modal_id;
    $cta_url_modal_class = 'modal-open-js';
    $cta_url = '#';
    $cta_target = '_self';
  }
  if ( $cta_advanced_options === 'cta-file' ) {
    $cta_url = $cta_file;
    $cta_target = '_blank';
    $cta_url_modal_class = '';
  }
  if ( $cta_data != '' ) {
    $cta_html = '<div class="cta-holder">';
    $cta_html .= '<a href="' . $cta_url . '" target="' . $cta_target . '" class="' . $cta_appearence .'  ' . $cta_url_modal_class . ' allupper" data-modal-open-id=".paperplane-modal-js-' . $cta_url_modal_id . '">' . $cta_title . '</a>';
    $cta_html .= '</div>';
    echo $cta_html;
  }
}
