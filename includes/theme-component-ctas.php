<?php
function paperplane_theme_cta_advanced( $field_names, $after_ctas = null ) {
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
				// Recupero il valore del target (senza l'attributo HTML) per la logica di $cta_title
				$cta_target_value = $field_name['cta_target'];
				// Inizializzo la variabile per l'URL da verificare
				$current_url = '';
				// Inizializzo la variabile per il testo da copiare
				$data_copy_text = '';
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
						// recupero il tipo di post del post type di riferimento
						$cta_internal_post_type = $cta_internal->post_type;
						// definisco il comportamento se il post type non è una modal
						if ( $cta_internal_post_type != 'cpt_modal' ) {
							// recupero il permalink del post type di riferimento
							$cta_url = 'href="' . get_permalink( $cta_internal_ID ) . '" ';
							// essendo un contenuto interno al sito imposto il target come _self
							$cta_target = 'target="_self"';
							$cta_target_value = '_self';
							// non ho bisogno di aggiungere classi
							$cta_class .= '';
							// non ho bisogno di aggiungere il parametro per gestire la modal
							$data_modal_open_id = '';
							// non ho bisogno di aggiungere il parametro per il focus alla chiusura della modal
							$start_point = '';
							// si tratta di un link, quindi definisco il tag a
							$cta_tag = 'a';
							// definisco il comportamento se il post type è una modal
							$data_modal_title = '';
							$rel_attribute = '';
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
							$rel_attribute = '';
						}
					}
					// gestisco la CTA per i link esterni o interni con un parametro
				} elseif ( $cta_destination === 'external-cta' ) {
					// Recupero l'URL per la verifica del dominio
					$current_url = $field_name['cta_url'];
					// Verifico se contiene un anchor
					if ( strpos( $field_name['cta_url'], '#' ) !== false ) {
						$cta_class .= ' anchor';
					}
					// Verifica se il dominio è diverso da quello attuale
					if ( isset( $field_name['cta_url'] ) && is_external_domain( $field_name['cta_url'] ) ) {
						// Il dominio è esterno, aggiungi una classe specifica
						$cta_class .= ' external-domain';
						// Aggiungi un attributo rel per ragioni di sicurezza
						$rel_attribute = 'rel="noopener noreferrer"';
					} else {
						$rel_attribute = '';
					}
					// definisco parametro href
					$cta_url = 'href="' . $field_name['cta_url'] . '" ';
					// definisco il target
					$cta_target = 'target="' . $field_name['cta_target'] . '"';
					// non ho bisogno di aggiungere il parametro per gestire la modal
					$data_modal_open_id = '';
					// non ho bisogno di aggiungere il parametro per il focus alla chiusura della modal
					$start_point = '';
					// si tratta di un link, quindi definisco il tag a
					$cta_tag = 'a';
					$data_modal_title = '';
					// gestisco la CTA per i download
				} elseif ( $cta_destination === 'download-cta' ) {
					// Recupero l'URL per la verifica del dominio
					$current_url = $field_name['cta_file_download'];
					// Verifica se il dominio è diverso da quello attuale
					if ( isset( $field_name['cta_file_download'] ) && is_external_domain( $field_name['cta_file_download'] ) ) {
						// Il dominio è esterno, aggiungi una classe specifica
						$cta_class .= ' external-domain';
						// Aggiungi un attributo rel per ragioni di sicurezza
						$rel_attribute = 'rel="noopener noreferrer"';
					} else {
						$rel_attribute = '';
					}
					// definisco parametro href
					$cta_url = 'href="' . $field_name['cta_file_download'] . '" ';
					// definisco il target
					$cta_target = 'target="' . $field_name['cta_target'] . '"';
					// non ho bisogno di aggiungere il parametro per gestire la modal
					$data_modal_open_id = '';
					// non ho bisogno di aggiungere il parametro per il focus alla chiusura della modal
					$start_point = '';
					// si tratta di un link, quindi definisco il tag a
					$cta_tag = 'a';
					$data_modal_title = '';
					// aggiungo la classe dedicata
					$cta_class .= ' download';
					// gestisco la CTA per mailto
				} elseif ( $cta_destination === 'mailto-cta' ) {
					// Recupero l'email
					$current_url = $field_name['cta_mailto'];
					$rel_attribute = '';
					// definisco parametro href con mailto:
					$cta_url = 'href="mailto:' . $field_name['cta_mailto'] . '" ';
					// per mailto non serve target
					$cta_target = '';
					// aggiungo la classe dedicata
					$cta_class .= ' mailto';
					// non ho bisogno di aggiungere il parametro per gestire la modal
					$data_modal_open_id = '';
					// non ho bisogno di aggiungere il parametro per il focus alla chiusura della modal
					$start_point = '';
					// si tratta di un link, quindi definisco il tag a
					$cta_tag = 'a';
					$data_modal_title = '';
					// gestisco la CTA per copiare testo
				} elseif ( $cta_destination === 'copytext-cta' ) {
					// Recupero il testo da copiare
					$current_url = $field_name['cta_copytext'];
					$rel_attribute = '';
					// non ho bisogno di una URL per un bottone
					$cta_url = '';
					// non ho bisogno di un target perché è un bottone
					$cta_target = '';
					// aggiungo la classe dedicata
					$cta_class .= ' copytext';
					// non ho bisogno di aggiungere il parametro per gestire la modal
					$data_modal_open_id = '';
					// non ho bisogno di aggiungere il parametro per il focus alla chiusura della modal
					$start_point = '';
					// si tratta di un bottone, quindi definisco il tag button
					$cta_tag = 'button';
					$data_modal_title = '';
					// valorizzo l'attributo data-copy-text con il testo da copiare
					$data_copy_text = ' data-copy-text="' . $field_name['cta_copytext'] . '"';
				}

				// Aggiungo la classe di tracciamento se presente
				if ( ! empty( $field_name['cta_tracking_class'] ) ) {
					$cta_class .= ' ' . $field_name['cta_tracking_class'];
				}
				// Inizia con cta_a11y_text (che può essere vuoto)
				$cta_a11y_text = isset( $field_name['cta_a11y_text'] ) ? $field_name['cta_a11y_text'] : '';

				// Aggiungi il suffisso basato sul target
				if ( $cta_target_value === '_blank' ) {
					// Se target è _blank, aggiungere il messaggio differenziando dominio interno/esterno
					if ( ! empty( $current_url ) && is_external_domain( $current_url ) ) {
						// Dominio esterno + _blank
						$cta_a11y_text .= ' ' . esc_html__( 'Si apre in una nuova finestra su un sito esterno', 'paperPlane-blankTheme' );
					} else {
						// Dominio interno + _blank
						$cta_a11y_text .= ' ' . esc_html__( 'Si apre in una nuova finestra', 'paperPlane-blankTheme' );
					}
					// Aggiungi la classe blank se non già presente
					if ( strpos( $cta_class, 'blank' ) === false ) {
						$cta_class .= ' blank';
					}
				} elseif ( $cta_target_value === '_self' && ! empty( $current_url ) && is_external_domain( $current_url ) ) {
					// Se target è _self e il dominio è esterno, aggiungere il messaggio
					$cta_a11y_text .= ' ' . esc_html__( 'Si apre su un sito esterno', 'paperPlane-blankTheme' );
				}

				// custom event for specific CTA

				if ( ! isset( $data_modal_title ) ) {
					$data_modal_title = '';
				}
				if ( isset( $cta_tag ) ) {
					// Renderizza lo span screen-reader-text solo se $cta_a11y_text non è vuoto
					$screen_reader_span = ! empty( $cta_a11y_text ) ? '<span class="screen-reader-text"> ' . $cta_a11y_text . '</span>' : '';
					$cta_html .= '<' . $cta_tag . ' ' . $cta_url . ' ' . $rel_attribute . ' ' . $cta_target . ' class="' . $cta_class . '" data-modal-id="' . $data_modal_open_id . '" data-modal-title="' . $data_modal_title . '" data-modal-back-to="' . $start_point . '"' . $data_copy_text . '>' . $button_text . $screen_reader_span . '</' . $cta_tag . '>';
				}

			}
		}
		$cta_html .= '</div>';
		if ( $after_ctas != 0 ) {
			$cta_html .= '<div class="last-child-no-margin mobile-after-cta">';
			$cta_html .= '<p class="as-h6 underlined-links">';
			$cta_html .= $after_ctas;
			$cta_html .= '</p>';
			$cta_html .= '</div>';
		}
		echo $cta_html;
	}
}

/**
 * Funzione per verificare se un URL appartiene a un dominio diverso da quello attuale
 *
 * @param string $url URL da controllare
 * @return boolean True se il dominio è esterno, False se è lo stesso dominio o URL vuoto
 */
function is_external_domain( $url ) {
	// Se l'URL è vuoto, restituisci false
	if ( empty( $url ) ) {
		return false;
	}

	// Ottieni il dominio corrente
	$current_domain = $_SERVER['HTTP_HOST'];

	// Estrai il dominio dall'URL
	$url_parts = parse_url( $url );

	// Se non è possibile estrarre l'host o l'URL è relativo, restituisci false
	if ( ! isset( $url_parts['host'] ) ) {
		return false;
	}

	$url_domain = $url_parts['host'];

	// Confronta i domini (case insensitive)
	return ( strtolower( $url_domain ) !== strtolower( $current_domain ) );
}