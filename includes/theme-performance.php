<?php
function paperplane_preload_self_hosted_fonts() {
	$static_bloginfo_stylesheet_directory = get_bloginfo( 'stylesheet_directory' );
	//$preload_fonts_meta = '<link rel="prefetch" href="' . get_template_directory_uri() . '/style.min.css" as="style" crossorigin />' . "\n";
	//$preload_fonts_meta = '<link rel="preconnect" href="https://fonts.googleapis.com" crossorigin />' . "\n";
	//$preload_fonts_meta .= '<link rel="prefetch" href="https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@400;700&family=Montserrat:ital,wght@0,400;0,700;1,400;1,700&display=swap" as="style" crossorigin />' . "\n";
	//$preload_fonts_meta .= '<link rel="preload" href="' . $static_bloginfo_stylesheet_directory . '/assets/fonts/material-icons/MaterialIcons-Regular.ttf" as="font" crossorigin />' . "\n";
	$preload_fonts_meta = '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />' . "\n";
	$preload_fonts_meta .= '<link rel="preload" href="https://fonts.gstatic.com/s/montserrat/v26/JTUSjIg1_i6t8kCHKm459WlhyyTh89Y.woff2" as="font" fetchpriority="high" type="font/woff2" crossorigin />' . "\n";
	$preload_fonts_meta .= '<link rel="preload" href="https://fonts.gstatic.com/s/robotoslab/v34/BngMUXZYTXPIvIBgJJSb6ufN5qWr4xCC.woff2" as="font" fetchpriority="high" type="font/woff2" crossorigin />' . "\n";
	echo $preload_fonts_meta;
}
add_action( 'wp_head', 'paperplane_preload_self_hosted_fonts', 1 );
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
						$preload_media_meta .= '<link rel="preload" media="(min-width: 1024px)" href="' . $content_fields['page_opening_image_desktop']['sizes']['full_desk_hd'] . '" as="image" type="' . $content_fields['page_opening_image_desktop']['mime_type'] . '" />' . "\n";
					}
					if ( ! empty( $content_fields['page_opening_image_mobile'] ) ) {
						$preload_media_meta .= '<link rel="preload" media="(max-width: 1023px)" href="' . $content_fields['page_opening_image_mobile']['sizes']['full_desk'] . '" as="image" type="' . $content_fields['page_opening_image_desktop']['mime_type'] . '" />' . "\n";
					}
				}
				if ( $page_opening_video === 'si' ) {
					//$preload_media_meta .= '<link rel="preload" href="' . $content_fields['page_opening_video_mp4'] . '" fetchpriority="high" as="video" type="video/mp4" />' . "\n";
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










