<?php
function paperplane_theme_cta_advanced( $field_names ) {
	if ( is_string( $field_names ) ) {
		$field_names = array( $field_names );
	}
	if ( $field_names ) {
		$cta_html = '<div class="cta-holder">';
		foreach ( $field_names as $field_name ) {
			$button_text = $field_name['cta_text'];
			if ( $button_text != '' ) {
				$cta_destination = $field_name['cta_destination'];
				$target = $field_name['cta_target'];
				if ( $cta_destination === 'internal-cta' ) {
					$cta_internals = $field_name['cta_internal'];
					foreach ( $cta_internals as $cta_internal ) {
						$cta_internal_ID = $cta_internal->ID;
						$cta_title = $cta_internal->post_title;
						$cta_internal_post_type = $cta_internal->post_type;
						if ( $cta_internal_post_type != 'cpt_modal' ) {
							$cta_url = get_permalink( $cta_internal_ID );
							$cta_url_modal_class = '';
							$data_modal_open_id = '';
							$start_point = '';
						} else {
							global $cta_url_modal_array;
							$cta_url_modal_array[] = $cta_internal_ID;
							$start_point = paperplane_random_code();
							$cta_url = '#modal-focus-' . $cta_internal_ID;
							$cta_url_modal_class = 'modal-open-js';
							$data_modal_open_id = $cta_internal_ID;
						}
					}
				} elseif ( $cta_destination === 'external-cta' ) {
					$cta_title = __( 'Visita', 'paperPlane-blankTheme' );
					$cta_url = $field_name['cta_url'];
					$cta_url_modal_class = '';
					$data_modal_open_id = '';
					$start_point = '';
				} elseif ( $cta_destination === 'download-cta' ) {
					$cta_title = __( 'Scarica', 'paperPlane-blankTheme' );
					$cta_url = $field_name['cta_file_download'];
					$cta_url_modal_class = '';
					$data_modal_open_id = '';
					$start_point = '';
				}
				$cta_appearance = $field_name['cta_appearance'];
				$cta_html .= '<a href="' . $cta_url . '" target="' . $target . '" class="' . $cta_appearance . '  ' . $cta_url_modal_class . ' ' . $start_point . ' allupper" data-modal-open-id="' . $data_modal_open_id . '" data-modal-back-to="' . $start_point . '" title="' . $cta_title . ' ' . $button_text . '" aria-label="' . $cta_title . ' ' . $button_text . '">' . $button_text . '</a>';
			}
		}
		$cta_html .= '</div>';
		echo $cta_html;
	}
}


function paperplane_theme_cta_absl_advanced( $field_names ) {
	if ( is_string( $field_names ) ) {
		$field_names = array( $field_names );
	}
	if ( $field_names ) {
		foreach ( $field_names as $field_name ) {
			$button_text = $field_name['cta_text'];
			if ( $button_text != '' ) {
				$cta_destination = $field_name['cta_destination'];
				$target = $field_name['cta_target'];
				if ( $cta_destination === 'internal-cta' ) {
					$cta_internals = $field_name['cta_internal'];
					foreach ( $cta_internals as $cta_internal ) {
						$cta_internal_ID = $cta_internal->ID;
						$cta_title = $cta_internal->post_title;
						$cta_internal_post_type = $cta_internal->post_type;
						if ( $cta_internal_post_type != 'cpt_modal' ) {
							$cta_url = get_permalink( $cta_internal_ID );
							$cta_url_modal_class = '';
							$data_modal_open_id = '';
							$start_point = '';
						} else {
							global $cta_url_modal_array;
							$cta_url_modal_array[] = $cta_internal_ID;
							$start_point = paperplane_random_code();
							$cta_url = '#modal-focus-' . $cta_internal_ID;
							$cta_url_modal_class = 'modal-open-js';
							$data_modal_open_id = $cta_internal_ID;
						}
					}
				} elseif ( $cta_destination === 'external-cta' ) {
					$cta_title = __( 'Visita', 'paperPlane-blankTheme' );
					$cta_url = $field_name['cta_url'];
					$cta_url_modal_class = '';
					$data_modal_open_id = '';
					$start_point = '';
				} elseif ( $cta_destination === 'download-cta' ) {
					$cta_title = __( 'Scarica', 'paperPlane-blankTheme' );
					$cta_url = $field_name['cta_file_download'];
					$cta_url_modal_class = '';
					$data_modal_open_id = '';
					$start_point = '';
				}
				$cta_appearance = $field_name['cta_appearance'];
				$cta_html = '<a href="' . $cta_url . '" target="' . $target . '" class="' . $cta_url_modal_class . ' ' . $start_point . ' absl" data-modal-open-id="' . $data_modal_open_id . '" data-modal-back-to="' . $start_point . '" title="' . $cta_title . ' ' . $button_text . '" aria-label="' . $cta_title . ' ' . $button_text . '"></a>';
				echo $cta_html;
			}
		}
	}
}