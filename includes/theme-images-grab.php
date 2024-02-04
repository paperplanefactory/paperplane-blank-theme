<?php
function print_theme_image( $image_data, $image_appearance, $image_sizes ) {
	if ( count( $image_data ) > 0 ) {
		$post_id = get_the_ID();
		if ( array_key_exists( 'lazyload', $image_appearance ) ) {
			$lazyload = $image_appearance['lazyload'];
			if ( $lazyload === TRUE ) {
				$lazyload_snippet = 'loading="lazy" fetchpriority="low"';
			} else {
				$lazyload_snippet = 'loading="eager" fetchpriority="high"';
			}
		}
		if ( array_key_exists( 'image-wrap', $image_appearance ) ) {
			$image_wrap = $image_appearance['image-wrap'];
		}
		$image_data_select = $image_data['image_type']; // post_thumbnail, acf_field or acf_sub_field
		if ( $image_data_select === 'acf' ) { // ACF FIELD - be sure to set "image -> image array in ACF options"
			if ( is_array( $image_data['image_value'] ) ) {
				$thumb_id = $image_data['image_value']['ID']; // retrieve the image ID
			}

		} elseif ( $image_data_select === 'post_thumbnail' ) { // nomrmal featured image
			// retrieve post/page ID
			$thumb_id = get_post_thumbnail_id( $post_id ); // retrieve the image ID
		}
		if ( isset( $thumb_id ) ) {
			$attachment_alt = get_post_meta( $thumb_id, '_wp_attachment_image_alt', true ); // image alt text
			if ( empty( $attachment_alt ) ) {
				$attachment_alt = get_the_title( $thumb_id ) . ': ' . __( 'questa immagine non ha ancora un testo alternativo.', 'paperPlane-blankTheme' );
			}
			if ( count( $image_sizes ) > 0 ) {
				$print_theme_image_cache_key = 'print_theme_image_cache_' . $thumb_id;
				$sharped_images = wp_cache_get( $print_theme_image_cache_key ); // check if array of images URL is set as cache
				if ( false === $sharped_images ) {
					$sharped_images = array(); // declare arry to use later in data-srcset
					foreach ( $image_sizes as $image_size ) {
						$thumb_url[ $image_size ] = wp_get_attachment_image_src( $thumb_id, $image_size, true ); // retrive array for desired size
						$sharped_images[] = $thumb_url[ $image_size ][0]; // retrive image URL
						$filetype = wp_check_filetype( $thumb_url[ $image_size ][0] );
					}
					wp_cache_set( $print_theme_image_cache_key, $sharped_images, 300 ); // set array of images URL as cache
				}
				$html_image_output = '';
				if ( $image_wrap == true ) {
					$html_image_output .= '<div class="no-the-100">';
				}
				$html_image_output .= '<picture>';
				$html_image_output .= '<source type="image/' . $filetype['ext'] . '" media="(max-width: 1023px)" srcset="' . $sharped_images[1] . '">';
				$html_image_output .= '<source type="image/' . $filetype['ext'] . '" media="(min-width: 1024px)" srcset="' . $sharped_images[0] . '">';
				$html_image_output .= '<img src="' . $sharped_images[0] . '" alt="' . $attachment_alt . '" ' . $lazyload_snippet . '  decoding="' . $image_appearance['decoding'] . '" width="' . $thumb_url[ $image_size ][1] . '" height="' . $thumb_url[ $image_size ][2] . '" />';
				$html_image_output .= '</picture>';
				if ( $image_wrap == true ) {
					$html_image_output .= '</div>';
				}
				echo $html_image_output;
			}
		}
	}
}

