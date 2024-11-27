<?php
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

	$html = $image_wrap ? '<div class="no-the-100">' : '';
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
		'<img src="%s" alt="%s" %s decoding="%s" width="%d" height="%d">',
		$sharped_images[0]['url'],
		esc_attr( $attachment_alt ),
		$lazyload_snippet,
		$decoding,
		$sharped_images[0]['width'],
		$sharped_images[0]['height']
	);
	$html .= '</picture>';
	$html .= $image_wrap ? '</div>' : '';

	echo $html;
}
