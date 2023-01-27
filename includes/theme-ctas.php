<?php
function paperplane_theme_cta($field_name) {
  if (is_string($field_name)) {
    $field_name = array($field_name);
  }
  if (call_user_func_array('have_rows', $field_name)) {
    $cta_html = '<div class="cta-holder">';
    while (call_user_func_array('have_rows', $field_name)) {
      the_row();
      $button_text = get_sub_field('cta_text');
      if ( $button_text != '' ) {
        $cta_destination = get_sub_field('cta_destination');
        $target = get_sub_field('cta_target');
        if( $cta_destination === 'internal-cta' ) {
          $cta_internals = get_sub_field('cta_internal');
          foreach($cta_internals as $cta_internal) {
            $cta_internal_ID = $cta_internal->ID;
            $cta_title = $cta_internal->post_title;
            $cta_internal_post_type = $cta_internal->post_type;
            if ($cta_internal_post_type != 'cpt_modal') {
              $cta_url = get_permalink($cta_internal_ID);
              $cta_url_modal_class = '';
              $data_modal_open_id = '';
            }
            else {
              global $cta_url_modal_array;
              $cta_url_modal_array[] = $cta_internal_ID;
              $cta_url = '#';
              $cta_url_modal_class = 'modal-open-js';
              $data_modal_open_id = '.paperplane-modal-js-' . $cta_internal_ID;
            }
          }
        }
        elseif( $cta_destination === 'external-cta' ) {
          $cta_title = __( 'Visita', 'paperPlane-blankTheme' );
          $cta_url = get_sub_field('cta_url');
          $cta_url_modal_class = '';
          $data_modal_open_id = '';
        }
        elseif( $cta_destination === 'download-cta' ) {
          $cta_title = __( 'Scarica', 'paperPlane-blankTheme' );
          $cta_url = get_sub_field('cta_file_download');
          $cta_url_modal_class = '';
          $data_modal_open_id = '';
        }
        $cta_appearance = get_sub_field('cta_appearance');
        $cta_html .= '<a href="' . $cta_url . '" target="' . $target . '" class="' . $cta_appearance .'  ' . $cta_url_modal_class . ' allupper" data-modal-open-id="'.$data_modal_open_id.'" title="'.$cta_title.' '.$button_text.'" aria-label="'.$cta_title.' '.$button_text.'">' . $button_text . '</a>';
      }
    }
    $cta_html .= '</div>';
    echo $cta_html;
  }
}



function paperplane_theme_cta_image($field_name) {
  if (is_string($field_name)) {
    $field_name = array($field_name);
  }
  $cta_html = '';
  if (call_user_func_array('have_rows', $field_name)) {
    $cta_counter = 0;
    while (call_user_func_array('have_rows', $field_name)) {
      the_row();
      $cta_counter ++;
      $button_text = get_sub_field('cta_text');
      if ( $button_text != '' ) {
        $cta_destination = get_sub_field('cta_destination');
        $target = get_sub_field('cta_target');
        if( $cta_destination === 'internal-cta' ) {
          $cta_internals = get_sub_field('cta_internal');
          foreach($cta_internals as $cta_internal) {
            $cta_internal_ID = $cta_internal->ID;
            $cta_title = $cta_internal->post_title;
            $cta_internal_post_type = $cta_internal->post_type;
            if ($cta_internal_post_type != 'cpt_modal') {
              $cta_url = get_permalink($cta_internal_ID);
              $cta_url_modal_class = '';
            }
            else {
              global $cta_url_modal_array;
              $cta_url_modal_array[] = $cta_internal_ID;
              $cta_url = '#';
              $cta_url_modal_class = 'modal-open-js';
            }
          }
        }
        elseif( $cta_destination === 'external-cta' ) {
          $cta_title = __( 'Visita', 'paperPlane-blankTheme' );
          $cta_url = get_sub_field('cta_url');
          $cta_url_modal_class = '';
        }
        elseif( $cta_destination === 'download-cta' ) {
          $cta_title = __( 'Scarica', 'paperPlane-blankTheme' );
          $cta_url = get_sub_field('cta_file_download');
          $cta_url_modal_class = '';
        }
        if ( $cta_url != '' ) {
          $cta_html .= '<a href="' . $cta_url . '" target="' . $target . '" class="' . $cta_url_modal_class . '" data-modal-open-id=".paperplane-modal-js-' . $cta_internal_ID . '" title="'.$cta_title.' '.$button_text.'" aria-label="'.$cta_title.' '.$button_text.'">';
        }
        else {
          $cta_html .= '<a href="#" target="_self" class="not-link" title="' . __( 'Link non cliccabile', 'paperPlane-blankTheme' ) . '" aria-label="' . __( 'Link non cliccabile', 'paperPlane-blankTheme' ) . '">';
        }
      }
    }
    if ( $cta_counter > 1 ) {
      $cta_html = '<a href="#" target="_self" class="not-link" title="' . __( 'Link non cliccabile', 'paperPlane-blankTheme' ) . '" aria-label="' . __( 'Link non cliccabile', 'paperPlane-blankTheme' ) . '">';
    }

    echo $cta_html;
  }
}
