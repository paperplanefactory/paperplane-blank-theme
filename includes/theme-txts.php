<?php
//conto le parole del content - call in template: echo word_count();
function word_count() {
	$content = get_post_field( 'post_content', $post->ID );
	$word_count = str_word_count( strip_tags( $content ) );
	return $word_count;
}

function excerpt( $limit ) {
	$excerpt = explode( ' ', get_the_excerpt(), $limit );

	if ( count( $excerpt ) >= $limit ) {
		array_pop( $excerpt );
		$excerpt = implode( " ", $excerpt ) . '...';
	} else {
		$excerpt = implode( " ", $excerpt );
	}

	$excerpt = preg_replace( '`\[[^\]]*\]`', '', $excerpt );

	return $excerpt;
}

// page title generator
function twentytwelve_wp_title( $title, $sep ) {
	global $paged, $page;

	if ( is_feed() )
		return $title;

	// Add the site name.
	$title .= get_bloginfo( 'name' );

	// Add the site description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		$title = "$title $sep $site_description";

	// Add a page number if necessary.
	if ( $paged >= 2 || $page >= 2 )
		$title = "$title $sep " . sprintf( __( 'Page %s', 'twentytwelve' ), max( $paged, $page ) );

	return $title;
}
add_filter( 'wp_title', 'twentytwelve_wp_title', 10, 2 );

/**
 * Replaces the login header logo URL
 *
 * @param $url
 */
function namespace_login_headerurl( $url ) {
	$url = home_url( '/' );
	return $url;
}

/**
 * Mostra il testo in modo condizionale: come paragrafo se breve,
 * o come elemento details con summary se lungo
 * 
 * @param string $testo Il testo da mostrare
 * @param int $lunghezzaMax Lunghezza massima prima di attivare details (default 100)
 * @return void
 */
/**
 * Versione alternativa con supporto per divisione in paragrafi
 *
 * @param string $testo Il testo da visualizzare, può contenere HTML
 * @param int $lunghezzaMax Lunghezza massima prima di usare details/summary
 * @param string $testoSummary Testo da mostrare nel summary
 * @param bool $dividiParagrafi Se dividere il testo in paragrafi
 */
function mostraDettagliTestoAvanzata( $testo, $lunghezzaMax = 100, $testoSummary = "Leggi messaggio", $dividiParagrafi = true ) {
	// Verifica la lunghezza del testo senza considerare i tag HTML
	$testoSenzaTag = strip_tags( $testo );

	if ( strlen( $testoSenzaTag ) <= $lunghezzaMax ) {
		// Se è minore o uguale alla lunghezza massima, mostra tutto il testo con HTML
		echo wp_kses_post( $testo );
	} else {
		echo "<details>";
		echo "    <summary>" . esc_html( $testoSummary ) . "</summary>";
		// Contenuto completo con HTML preservato

		// Dividi il testo in paragrafi mantenendo i tag HTML
		$paragrafi = preg_split( '/\n\s*\n|\r\n\s*\r\n|\r\s*\r/m', $testo );

		echo "<div class=\"last-child-no-margin underlined-links\">";
		foreach ( $paragrafi as $paragrafo ) {
			if ( trim( $paragrafo ) !== '' ) {
				// Controllo se il paragrafo contiene già un tag HTML di blocco
				if ( preg_match( '/^\s*<(p|div|h[1-6]|ul|ol|table|blockquote)[^>]*>/i', $paragrafo ) ) {
					echo wp_kses_post( $paragrafo );
				} else {
					echo "    <p>" . wp_kses_post( $paragrafo ) . "</p>";
				}
			}
		}
		echo "</div>";


		echo "</details>";
	}
}