<?php

/**
 * Stampa un'immagine responsive con supporto per picture element, lazy loading e aspect-ratio
 *
 * @param array $image_data Dati dell'immagine
 *   - 'image_type' (string): Tipo di immagine. Opzioni: 'acf' | 'post_thumbnail'
 *   - 'image_value' (array): Valore del campo immagine (richiesto se image_type = 'acf' - il nome del campo)
 *
 * @param array $image_appearance Impostazioni di visualizzazione
 *   - 'lazyload' (bool): Abilita lazy loading. Opzioni: true | false
 *                        true = loading="lazy" fetchpriority="low"
 *                        false = loading="eager" fetchpriority="high"
 *   - 'decoding' (string): Metodo di decodifica. Opzioni: 'sync' | 'async'
 *   - 'image-wrap' (bool): Aggiunge contenitore div attorno all'immagine. Opzioni: true | false
 *   - 'image-wrap-custom-class' (string, opzionale): Classe CSS personalizzata per il wrapper
 *                                                     Se presente, sostituisce 'no-the-100'
 *                                                     Se presente, NON vengono aggiunte le variabili CSS --aspect-*
 *
 * @param array $image_sizes Array di size WordPress per le immagini responsive
 *                          Il primo elemento è per desktop (min-width: 1024px)
 *                          Il secondo elemento è per mobile (max-width: 1023px)
 *                          Formato: ['chiave_descrittiva' => 'nome_size_wordpress']
 *
 * @return void Echo dell'HTML generato
 *
 * ESEMPI D'USO:
 *
 * Esempio 1 - Immagine ACF con classe default e aspect-ratio automatico:
 * $image_data = array(
 *     'image_type' => 'acf',
 *     'image_value' => get_field('mia_immagine')
 * );
 * $image_appearance = array(
 *     'lazyload' => true,
 *     'decoding' => 'async',
 *     'image-wrap' => true
 * );
 * $image_sizes = array(
 *     'desktop_hd' => 'large',
 *     'mobile_hd' => 'medium'
 * );
 * print_theme_image( $image_data, $image_appearance, $image_sizes );
 *
 * Output: <div class="no-the-100" style="--aspect-desktop: 1200 / 801; --aspect-mobile: 500 / 500;">...</div>
 *
 * Esempio 2 - Immagine con classe personalizzata (senza aspect-ratio automatico):
 * $image_data = array(
 *     'image_type' => 'acf',
 *     'image_value' => get_field('mia_immagine')
 * );
 * $image_appearance = array(
 *     'lazyload' => false,
 *     'decoding' => 'sync',
 *     'image-wrap' => true,
 *     'image-wrap-custom-class' => 'hero-image-container'
 * );
 * $image_sizes = array(
 *     'desktop_hd' => 'full',
 *     'mobile_hd' => 'large'
 * );
 * print_theme_image( $image_data, $image_appearance, $image_sizes );
 *
 * Output: <div class="hero-image-container">...</div>
 *
 * Esempio 3 - Post thumbnail senza wrapper:
 * $image_data = array(
 *     'image_type' => 'post_thumbnail',
 *     'image_value' => null // non necessario per post_thumbnail
 * );
 * $image_appearance = array(
 *     'lazyload' => true,
 *     'decoding' => 'async',
 *     'image-wrap' => false
 * );
 * $image_sizes = array(
 *     'desktop_hd' => 'large',
 *     'mobile_hd' => 'thumbnail'
 * );
 * print_theme_image( $image_data, $image_appearance, $image_sizes );
 *
 * Output: <picture>...<img>...</picture> (senza div wrapper)
 *
 * NOTE:
 * - Se 'image-wrap' = true e NON è presente 'image-wrap-custom-class', viene usata la classe 'no-the-100'
 *   e vengono aggiunte le variabili CSS --aspect-desktop e --aspect-mobile per gestire l'aspect-ratio
 * - Se 'image-wrap-custom-class' è presente, le variabili CSS --aspect-* NON vengono aggiunte
 *   e la gestione dell'aspect-ratio deve essere fatta manualmente nel CSS della classe personalizzata
 * - La funzione utilizza wp_cache per ottimizzare le performance (cache di 300 secondi)
 * - Le dimensioni nell'array $image_sizes devono essere registrate in WordPress con add_image_size()
 */

function print_theme_image( $image_data, $image_appearance, $image_sizes ) {
	// Validazione input
	if ( empty( $image_data ) || empty( $image_sizes ) ) {
		return;
	}

	// Configurazione lazy loading
	$lazyload_snippet = isset( $image_appearance['lazyload'] )
		? ( $image_appearance['lazyload'] ? 'loading="lazy" fetchpriority="low"' : 'loading="eager" fetchpriority="high"' )
		: 'loading="lazy" fetchpriority="low"';

	// Gestione image wrap
	$image_wrap = $image_appearance['image-wrap'] ?? false;

	// Gestione classe wrapper (custom o default)
	$has_custom_class = isset( $image_appearance['image-wrap-custom-class'] ) && ! empty( $image_appearance['image-wrap-custom-class'] );
	$wrapper_class = $has_custom_class ? $image_appearance['image-wrap-custom-class'] : 'no-the-100';

	// Recupero ID immagine
	$thumb_id = null;
	if ( $image_data['image_type'] === 'acf' && is_array( $image_data['image_value'] ) ) {
		$thumb_id = $image_data['image_value']['ID'];
	} elseif ( $image_data['image_type'] === 'post_thumbnail' ) {
		$thumb_id = get_post_thumbnail_id( get_the_ID() );
	}

	if ( ! $thumb_id ) {
		return;
	}

	// Recupero alt text
	$attachment_alt = get_post_meta( $thumb_id, '_wp_attachment_image_alt', true ) ?: '';

	// Gestione cache e generazione URLs
	$cache_key = 'print_theme_image_cache_' . $thumb_id;
	$sharped_images = wp_cache_get( $cache_key );

	if ( false === $sharped_images ) {
		$sharped_images = [];
		foreach ( $image_sizes as $image_size ) {
			$thumb_url = wp_get_attachment_image_src( $thumb_id, $image_size, true );
			if ( $thumb_url ) {
				$sharped_images[] = [
					'url' => $thumb_url[0],
					'width' => $thumb_url[1],
					'height' => $thumb_url[2]
				];
			}
		}
		wp_cache_set( $cache_key, $sharped_images, 300 );
	}

	if ( empty( $sharped_images ) ) {
		return;
	}

	// Determinazione del tipo di file
	$filetype = wp_check_filetype( $sharped_images[0]['url'] );

	// Generazione HTML
	$decoding = $image_appearance['decoding'] ?? 'async';

	// Wrapper con o senza CSS Custom Properties
	if ( $image_wrap ) {
		if ( $has_custom_class ) {
			// Classe personalizzata: solo classe, nessuno style
			$html = sprintf( '<div class="%s">', esc_attr( $wrapper_class ) );
		} else {
			// Classe default: classe + style con aspect-ratio
			$html = sprintf(
				'<div class="%s" style="--aspect-desktop: %d / %d; --aspect-mobile: %d / %d;">',
				esc_attr( $wrapper_class ),
				$sharped_images[0]['width'],
				$sharped_images[0]['height'],
				$sharped_images[1]['width'],
				$sharped_images[1]['height']
			);
		}
	} else {
		$html = '';
	}

	$html .= '<picture>';
	$html .= sprintf(
		'<source type="image/%s" media="(max-width: 1023px)" srcset="%s">',
		$filetype['ext'],
		$sharped_images[1]['url']
	);
	$html .= sprintf(
		'<source type="image/%s" media="(min-width: 1024px)" srcset="%s">',
		$filetype['ext'],
		$sharped_images[0]['url']
	);
	$html .= sprintf(
		'<img src="%s" alt="%s" %s decoding="%s">',
		$sharped_images[0]['url'],
		esc_attr( $attachment_alt ),
		$lazyload_snippet,
		$decoding
	);
	$html .= '</picture>';
	$html .= $image_wrap ? '</div>' : '';

	echo $html;
}