<a name="page-skip-to-content"></a>
<?php
if ( is_page_template( 'page-modules.php' ) || is_page_template( 'page-listing.php' ) || basename( get_page_template() ) === 'page.php' ) {
	$content_fields = paperplane_content_transients( $post->ID );
	if ( isset( $content_fields['page_opening_layout'] ) ) {
		if ( $content_fields['page_opening_layout'] === 'opening-fullscreen' || $content_fields['page_opening_layout'] === 'opening-almost-fullscreen' ) {
			include( locate_template( 'template-parts/grid/page-opening/opening-fullscreen.php' ) );
		}
		if ( $content_fields['page_opening_layout'] === 'opening-text' ) {
			include( locate_template( 'template-parts/grid/page-opening/opening-text.php' ) );
		}
	}
}
if ( is_archive() ) {
	include( locate_template( 'template-parts/grid/page-opening/opening-archive.php' ) );
}
if ( is_search() ) {
	include( locate_template( 'template-parts/grid/page-opening/opening-search.php' ) );
}
if ( is_404() ) {
	include( locate_template( 'template-parts/grid/page-opening/opening-404.php' ) );
}
?>