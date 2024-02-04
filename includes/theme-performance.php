<?php
function paperplane_preload_images_above_the_fold() {
	global $post;
	$static_bloginfo_stylesheet_directory = get_bloginfo( 'stylesheet_directory' );
	$preload_media_meta = "\n" . '<link rel="preload" href="' . $static_bloginfo_stylesheet_directory . '/assets/images/site-logo-header.svg" fetchpriority="high" as="image" type="image/svg+xml" crossorigin />' . "\n";
	if ( $post ) {
		$content_fields = paperplane_content_transients( $post->ID );
		if ( $content_fields ) {
			if ( array_key_exists( 'page_opening_layout', $content_fields ) ) {
				$page_opening_layout = $content_fields['page_opening_layout'];
			}

			if ( $page_opening_layout === 'opening-fullscreen' || $page_opening_layout === 'opening-almost-fullscreen' ) {
				$page_opening_video = $content_fields['page_opening_video'];
				if ( $page_opening_video === 'no' ) {
					if ( ! empty( $content_fields['page_opening_image_desktop'] ) ) {
						$preload_media_meta .= '<link rel="preload" media="(min-width: 1024px)" href="' . $content_fields['page_opening_image_desktop']['sizes']['full_desk_hd'] . '" fetchpriority="high" as="image" type="' . $content_fields['page_opening_image_desktop']['mime_type'] . '" />' . "\n";
					}
					if ( ! empty( $content_fields['page_opening_image_mobile'] ) ) {
						$preload_media_meta .= '<link rel="preload" media="(max-width: 1023px)" href="' . $content_fields['page_opening_image_mobile']['sizes']['full_desk'] . '" fetchpriority="high" as="image" type="' . $content_fields['page_opening_image_desktop']['mime_type'] . '" />' . "\n";
					}
				}
				if ( $page_opening_video === 'si' ) {
					$preload_media_meta .= '<link rel="preload" href="' . $content_fields['page_opening_video_mp4'] . '" fetchpriority="high" as="video" type="video/mp4" />' . "\n";
				}
			}
		}
	}
	echo $preload_media_meta;
}
add_action( 'wp_head', 'paperplane_preload_images_above_the_fold', 1 );

function paperplane_preload_speculationrules_pages() {
	if ( function_exists( 'pll_the_languages' ) ) {
		$acf_options_parameter = pll_current_language( 'slug' );
	} else {
		$acf_options_parameter = 'any-lang';
	}
	paperplane_options_transients();
	global $options_fields_multilang, ${$options_fields_multilang . $acf_options_parameter};
	$speculationrules_pages = ${$options_fields_multilang . $acf_options_parameter}['speculationrules_pages'];
	if ( isset( $speculationrules_pages ) && ! empty( $speculationrules_pages ) ) {
		$speculationrules_pages_counter = count( $speculationrules_pages );
		$i = 0;
		$quick_links_urls = '';
		foreach ( $speculationrules_pages as $speculationrules_page ) {
			if ( ++$i === $speculationrules_pages_counter ) {
				$quick_links_urls .= '"' . get_permalink( $speculationrules_page->ID ) . '"';
			} else {
				$quick_links_urls .= '"' . get_permalink( $speculationrules_page->ID ) . '", ';
			}
		}
		$quicklinks_data = '<script type="speculationrules">';
		$quicklinks_data .= '{';
		$quicklinks_data .= '"prefetch": [';
		$quicklinks_data .= '{';
		$quicklinks_data .= '"source": "list",';
		$quicklinks_data .= '"urls": [' . $quick_links_urls . ']';
		$quicklinks_data .= '}';
		$quicklinks_data .= ']';
		$quicklinks_data .= '}';
		$quicklinks_data .= '</script>';
		echo $quicklinks_data;
	}
}
add_action( 'wp_footer', 'paperplane_preload_speculationrules_pages' );










