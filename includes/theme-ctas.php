<?php
function paperplane_theme_cta_advanced( $field_names ) {
	if ( is_string( $field_names ) ) {
		$field_names = array( $field_names );
	}
	//var_dump( $field_names );
	if ( ! empty( $field_names[0]['cta_text'] ) ) {
		$cta_html = '<div class="cta-holder">';
		$ga_modal_event_trigger = '';
		$ga_modal_event_data = '';
		foreach ( $field_names as $field_name ) {
			$button_text = $field_name['cta_text'];
			if ( $button_text != '' ) {
				$cta_destination = $field_name['cta_destination'];
				$cta_target = 'target="' . $field_name['cta_target'] . '"';
				if ( ! empty( $field_name['cta_appearance'] ) ) {
					$cta_class = $field_name['cta_appearance'];
				} else {
					$cta_class = 'default-button';
				}
				if ( $cta_destination === 'internal-cta' ) {
					$cta_internals = $field_name['cta_internal'];
					foreach ( $cta_internals as $cta_internal ) {
						$cta_internal_ID = $cta_internal->ID;
						$cta_title = $cta_internal->post_title;
						$cta_internal_post_type = $cta_internal->post_type;
						if ( $cta_internal_post_type != 'cpt_modal' ) {
							$cta_url = 'href="' . get_permalink( $cta_internal_ID ) . '" ';
							$cta_target = 'target="_self"';
							$cta_class .= '';
							$data_modal_open_id = '';
							$start_point = '';
							$cta_tag = 'a';
						} else {
							$back_to_code = paperplane_random_code();
							global $cta_url_modal_array;
							$cta_url_modal_array[] = $cta_internal_ID;
							$cta_url = '';
							$cta_target = '';
							$start_point = $back_to_code;
							$cta_class .= ' modal-open-js ' . $back_to_code;
							$data_modal_open_id = $cta_internal_ID;
							$cta_tag = 'button';
							$data_modal_title = get_the_title( $cta_internal_ID );
							// GA event for modal
							$ga_modal_event_data = 'data-ga-modal-event-name="open_modal" data-ga-modal-event-cta-text="' . $button_text . '" data-ga-modal-title="' . $data_modal_title . '"';
						}
					}
				} elseif ( $cta_destination === 'external-cta' ) {
					$cta_title = __( 'Visita', 'paperPlane-blankTheme' );
					$cta_url = 'href="' . $field_name['cta_url'] . '" ';
					$cta_target = 'target="' . $field_name['cta_target'] . '"';
					$cta_class .= '';
					$data_modal_open_id = '';
					$start_point = '';
					$cta_tag = 'a';
				} elseif ( $cta_destination === 'download-cta' ) {
					$cta_title = __( 'Scarica', 'paperPlane-blankTheme' );
					$cta_url = 'href="' . $field_name['cta_file_download'] . '" ';
					$cta_target = 'target="' . $field_name['cta_target'] . '"';
					$cta_class .= '';
					$data_modal_open_id = '';
					$start_point = '';
					$cta_tag = 'a';
				}

				// custom event for specific CTA
				$cta_custom_event_google_analytics = $field_name['cta_custom_event_google_analytics'];
				if ( $cta_custom_event_google_analytics == 1 ) {
					$function_unique_id = paperplane_random_code();
					$cta_class .= ' ga-custom-event-trigger-js';
					$ga_custom_event_data = 'data-ga-custom-event-name="' . $field_name['cta_custom_event_google_analytics_name'] . '" data-ga-custom-event-cta-text="' . $button_text . '" data-ga-custom-event-cta-url="' . get_permalink() . '" data-ga-custom-event-cta-page-title="' . get_the_title() . '"';
				} else {
					$cta_class .= '';
					$ga_custom_event_data = '';
				}
				// custom event for A/B testing
				global $post;
				$ab_testing_page_a = get_post_meta( $post->ID, 'ab_testing_page_a', true );
				if ( ! empty( $ab_testing_page_a ) ) {
					$cta_class .= ' ga-ab-event-trigger-js';
					$ab_testing_page_b = get_post_meta( $post->ID, 'ab_testing_page_b', true );
					$ab_testing_page_this = $post->ID;
					$ab_ga4_event_name = get_post_meta( $post->ID, 'ab_ga4_event_name', true );
					if ( $ab_testing_page_this == $ab_testing_page_a ) {
						$ab_ga4_event_sent_name = $ab_ga4_event_name . '_a_cta_click';
					}
					if ( $ab_testing_page_this == $ab_testing_page_b ) {
						$ab_ga4_event_sent_name = $ab_ga4_event_name . '_b_cta_click';
					}
					$ga_ab_event_data = 'data-ga-ab-event-name="' . $ab_ga4_event_sent_name . '" data-ga-ab-cta-text="' . $button_text . '" data-ga-ab-cta-url="' . $cta_url . '"';

				} else {
					$cta_class .= '';
					$ga_ab_event_data = '';

				}
				if ( ! isset( $data_modal_title ) ) {
					$data_modal_title = '';
				}
				$cta_html .= '<' . $cta_tag . ' ' . $cta_url . ' ' . $cta_target . ' class="' . $cta_class . '" data-modal-id="' . $data_modal_open_id . '" data-modal-title="' . $data_modal_title . '" data-modal-back-to="' . $start_point . '" ' . $ga_custom_event_data . ' ' . $ga_ab_event_data . ' ' . $ga_modal_event_data . ' title="' . $cta_title . ' ' . $button_text . '" aria-label="' . $cta_title . ' ' . $button_text . '">' . $button_text . '</' . $cta_tag . '>';
			}
		}
		$cta_html .= '</div>';
		//$cta_html .= '<section class="paperplane-modal  -hidden"><div class="modal-box offerta-overlay-box-js"><div class="insider">ciao</div></div></section>';
		echo $cta_html;
	}
}


function paperplane_theme_cta_absl_advanced( $field_names ) {
	if ( is_string( $field_names ) ) {
		$field_names = array( $field_names );
	}
	if ( ! empty( $field_names[0]['cta_text'] ) ) {
		$i = 0;
		foreach ( $field_names as $field_name ) {
			$i++;
			if ( $i == 1 ) {
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

					$cta_html = '<a href="' . $cta_url . '" target="' . $target . '" class="' . $cta_url_modal_class . ' ' . $start_point . '" data-modal-open-id="' . $data_modal_open_id . '" data-modal-back-to="' . $start_point . '" title="' . $cta_title . ' ' . $button_text . '" aria-label="' . $cta_title . ' ' . $button_text . '"></a>';
					echo $cta_html;
				}
			}

		}
	}
}