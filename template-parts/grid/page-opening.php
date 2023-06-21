<?php
$content_fields = paperplane_content_transients( $post->ID );
if ( is_archive() ) {
	include( locate_template( 'template-parts/grid/page-opening/opening-archive.php' ) );
} elseif ( is_search() ) {
	include( locate_template( 'template-parts/grid/page-opening/opening-search.php' ) );

} elseif ( is_404() ) {
	include( locate_template( 'template-parts/grid/page-opening/opening-404.php' ) );

} else {
	if ( array_key_exists( 'page_opening_layout', $content_fields ) ) {
		$page_opening_layout = $content_fields['page_opening_layout'];
	}
	if ( $page_opening_layout === 'opening-fullscreen' || $page_opening_layout === 'opening-almost-fullscreen' ) {
		$thumb_id = get_post_thumbnail_id();
		if ( array_key_exists( 'page_opening_image_desktop', $content_fields ) && isset( $content_fields['page_opening_image_desktop'] ) ) {
			$page_opening_image_desktop = $content_fields['page_opening_image_desktop'];
		}
		if ( array_key_exists( 'page_opening_image_mobile', $content_fields ) && isset( $content_fields['page_opening_image_mobile'] ) ) {
			$page_opening_image_mobile = $content_fields['page_opening_image_mobile'];
		}
		$thumb_id = get_post_thumbnail_id( $post->ID );
		if ( $page_opening_image_desktop ) {
			$thumb_url_desktop = wp_get_attachment_image_src( $page_opening_image_desktop, 'full_desk_hd', true );
			$thumb_url_desktop = $thumb_url_desktop[0];
		} elseif ( $thumb_id != 0 ) {
			$thumb_url_desktop = wp_get_attachment_image_src( $thumb_id, 'full_desk_hd', true );
			$thumb_url_desktop = $thumb_url_desktop[0];
		}

		if ( $page_opening_image_mobile ) {
			$thumb_url_mobile = wp_get_attachment_image_src( $page_opening_image_mobile, 'full_desk', true );
			$thumb_url_mobile = $thumb_url_mobile[0];
		} elseif ( $thumb_id != 0 ) {
			$thumb_url_mobile = wp_get_attachment_image_src( $thumb_id, 'full_desk', true );
			$thumb_url_mobile = $thumb_url_mobile[0];
		}
		if ( isset( $thumb_url_desktop ) ) {
			$filetype_desktop = wp_check_filetype( $thumb_url_desktop );
		}
		if ( isset( $thumb_url_mobile ) ) {
			$filetype_mobile = wp_check_filetype( $thumb_url_mobile );
		}
		$page_opening_video = $content_fields['page_opening_video'];
		$page_scroll_button = $content_fields['page_scroll_button'];
	}
	$page_breadcrumbs = $content_fields['page_breadcrumbs'];

	switch ( $page_opening_layout ) {
		case 'opening-fullscreen':
			$page_opening_layout_size = 'page-opening-fullscreen';
			break;
		case 'opening-almost-fullscreen':
			$page_opening_layout_size = 'page-opening-fullscreen-less';
			break;
		case 'opening-text-image':
			break;
	}
	$page_taxonomy_show = $content_fields['page_taxonomy_show'];
	if ( $page_opening_layout === 'opening-fullscreen' || $page_opening_layout === 'opening-almost-fullscreen' ) {
		include( locate_template( 'template-parts/grid/page-opening/opening-fullscreen.php' ) );
	} elseif ( $page_opening_layout === 'opening-text' ) {
		include( locate_template( 'template-parts/grid/page-opening/opening-text.php' ) );
	}
}
?>