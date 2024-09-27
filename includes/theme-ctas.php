<?php
function paperplane_theme_cta_advanced( $field_names ) {
	// componente per CTA
	if ( is_string( $field_names ) ) {
		$field_names = array( $field_names );
	}
	// verifico se esistono valori per la CTA controllando il testo della CTA
	if ( ! empty( $field_names[0]['cta_text'] ) ) {
		// genero un contenitore per la/le CTA
		$cta_html = '<div class="cta-holder">';
		$ga_modal_event_trigger = '';
		$ga_modal_event_data = '';
		// genero ogni CTA
		foreach ( $field_names as $field_name ) {
			if ( array_key_exists( 'cta_text', $field_name ) && isset( $field_name['cta_text'] ) ) {
				// creo una variabile con il testo del bottone
				$button_text = $field_name['cta_text'];
				// creo una variabile con il contenuto di destinazione della CTA
				$cta_destination = $field_name['cta_destination'];
				// creo e definisco il target della CTA
				$cta_target = 'target="' . $field_name['cta_target'] . '"';
				// verifico e creo l'aspetto grafico della CTA
				if ( array_key_exists( 'cta_appearance', $field_name ) && isset( $field_name['cta_appearance'] ) ) {
					$cta_class = $field_name['cta_appearance'];
				} else {
					$cta_class = 'default-button';
				}
				// gestisco la CTA per i post type
				if ( $cta_destination === 'internal-cta' ) {
					// recupero i dati del post type di riferimento
					$cta_internals = $field_name['cta_internal'];
					foreach ( $cta_internals as $cta_internal ) {
						// recupero ID del post type di riferimento
						$cta_internal_ID = $cta_internal->ID;
						// recupero titolo del post type di riferimento
						$cta_title = $cta_internal->post_title;
						// recupero il tipo di post del post type di riferimento
						$cta_internal_post_type = $cta_internal->post_type;
						// definisco il comportamento se il post type non è una modal
						if ( $cta_internal_post_type != 'cpt_modal' ) {
							// recupero il permalink del post type di riferimento
							$cta_url = 'href="' . get_permalink( $cta_internal_ID ) . '" ';
							// essendo un contenuto interno al sito imposto il target come _self
							$cta_target = 'target="_self"';
							// non ho bisogno di aggiungere classi
							$cta_class .= '';
							// non ho bisogno di aggiungere il parametro per gestire la modal
							$data_modal_open_id = '';
							// non ho bisogno di aggiungere il parametro per il focus alla chiusura della modal
							$start_point = '';
							// si tratta di un link, quindi definisco il tag a
							$cta_tag = 'a';
							// definisco il comportamento se il post type è una modal
						} else {
							// genero una variabile con un codice univoco
							$back_to_code = paperplane_random_code();
							// recupero l'array con gli ID di altre modal eventualmente presenti in pagina
							global $cta_url_modal_array;
							// aggiungo l'ID della modal utilizzata all'array con gli ID di altre modal che definisce la query nel footer
							$cta_url_modal_array[] = $cta_internal_ID;
							// non ho bisogno di una URL
							$cta_url = '';
							// non ho bisogno di un target perchè è un bottone
							$cta_target = '';
							// aggiungo il parametro per il focus alla chiusura della modal
							$start_point = $back_to_code;
							// aggiungo la class con ID per definire il comportamento JavaScript
							$cta_class .= ' modal-open-js ' . $back_to_code;
							// valorizzo la variabile per comportamenti???
							$data_modal_open_id = $cta_internal_ID;
							// si tratta di un bottone, quindi definisco il tag button
							$cta_tag = 'button';
							// recupero il titolo della modal per avere un bottone piu accessibile
							$data_modal_title = get_the_title( $cta_internal_ID );
							// definisco l'evento GA per la modal
							$ga_modal_event_data = 'data-ga-modal-event-name="open_modal" data-ga-modal-event-cta-text="' . $button_text . '" data-ga-modal-title="' . $data_modal_title . '"';
						}
					}
					// gestisco la CTA per i link esterni o interni con un parametro
				} elseif ( $cta_destination === 'external-cta' ) {
					// definisco parzialmente il testo dell'etichetta per il titolo
					if ( $field_name['cta_target'] === '_self' ) {
						$cta_title = '';
					}
					if ( $field_name['cta_target'] === '_blank' ) {
						$cta_title = __( 'Si apre in una nuova finestra,', 'paperPlane-blankTheme' );
					}
					// definisco parametro href
					$cta_url = 'href="' . $field_name['cta_url'] . '" ';
					// definisco il target
					$cta_target = 'target="' . $field_name['cta_target'] . '"';
					// non ho bisogno di aggiungere classi
					$cta_class .= '';
					// non ho bisogno di aggiungere il parametro per gestire la modal
					$data_modal_open_id = '';
					// non ho bisogno di aggiungere il parametro per il focus alla chiusura della modal
					$start_point = '';
					// si tratta di un link, quindi definisco il tag a
					$cta_tag = 'a';
					// gestisco la CTA per i download
				} elseif ( $cta_destination === 'download-cta' ) {
					// definisco parzialmente il testo dell'etichetta per il titolo
					if ( $field_name['cta_target'] === '_self' ) {
						$cta_title = __( 'Scarica o visualizza file', 'paperPlane-blankTheme' );
					}
					if ( $field_name['cta_target'] === '_blank' ) {
						$cta_title = __( 'Si apre in una nuova finestra, scarica o visualizza file', 'paperPlane-blankTheme' );
					}
					// definisco parametro href
					$cta_url = 'href="' . $field_name['cta_file_download'] . '" ';
					// definisco il target
					$cta_target = 'target="' . $field_name['cta_target'] . '"';
					// non ho bisogno di aggiungere classi
					$cta_class .= '';
					// non ho bisogno di aggiungere il parametro per gestire la modal
					$data_modal_open_id = '';
					// non ho bisogno di aggiungere il parametro per il focus alla chiusura della modal
					$start_point = '';
					// si tratta di un link, quindi definisco il tag a
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
				if ( isset( $cta_tag ) ) {
					$cta_html .= '<' . $cta_tag . ' ' . $cta_url . ' ' . $cta_target . ' class="' . $cta_class . '" data-modal-id="' . $data_modal_open_id . '" data-modal-title="' . $data_modal_title . '" data-modal-back-to="' . $start_point . '" ' . $ga_custom_event_data . ' ' . $ga_ab_event_data . ' ' . $ga_modal_event_data . '>' . $button_text . '<span class="screen-reader-text">' . $cta_title . '</span></' . $cta_tag . '>';
				}
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

					$cta_html = '<a href="' . $cta_url . '" target="' . $target . '" class="' . $cta_url_modal_class . ' ' . $start_point . '" data-modal-open-id="' . $data_modal_open_id . '" data-modal-back-to="' . $start_point . '" title="' . $cta_title . ' ' . $button_text . '"><span class="screen-reader-text">' . $cta_title . ' ' . $button_text . '</span></a>';
					echo $cta_html;
				}
			}

		}
	}
}