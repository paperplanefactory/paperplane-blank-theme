<?php
function paperplane_theme_wpcf7_accessibility( $output, $tag, $atts, $m ) {
	// aggiungo un paragrafo che specifica i campi obblicatori
	if ( $tag === 'contact-form-7' ) {
		$msg = '<div class="form-hold">';
		$msg .= '<p class="as-label">';
		$msg .= __( 'Tutti i campi obbligatori sono contrassegnati da un *', 'paperPlane-blankTheme' );
		$msg .= '</p>';
		$output = $msg . $output;
		// inutilizzato - aggiungo bottone per l'accessibilità per tornare al primo input con errori
		//$check = '<button class="form-top-js screen-reader-text" aria-hidden="true" hidden>' . __( 'Sposta il focus al primo campo contenente errori.', 'paperPlane-blankTheme' ) . '</button>';
		//$output .= $check;
		$output .= '</div>';
	}

	return $output;
}

add_filter( 'do_shortcode_tag', 'paperplane_theme_wpcf7_accessibility', 10, 4 );