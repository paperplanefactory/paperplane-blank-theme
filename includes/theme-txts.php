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
 * Mostra il testo dell'avviso in un wrapper che verrà gestito da JS
 * 
 * @param string $testo Il testo da mostrare (solo testo + <br />)
 * @param string $testoSummary Testo da mostrare nel summary se necessario
 * @param string $link URL del link opzionale da mostrare alla fine
 * @param string $testoLink Testo del link opzionale
 * @param string $noticeHash Hash univoco dell'avviso per gestione cookie
 * @param string $viewMode Modalità visualizzazione: 'static-text' o 'scroll-text'
 */
function mostraDettagliTestoAvanzata( $testo, $testoSummary = "Leggi messaggio", $link = '', $testoLink = '', $noticeHash = '', $viewMode = 'static-text' ) {
	// Classi del container in base alla modalità
	$container_classes = 'avviso-container';

	if ( $viewMode === 'scroll-text' ) {
		// Modalità scroll: già visibile, CSS gestisce animazione
		$container_classes .= ' avviso-scroll visible';
	}

	// Wrapper con data attribute per JS
	echo '<div class="' . esc_attr( $container_classes ) . '" data-summary-text="' . esc_attr( $testoSummary ) . '" data-notice-id="' . esc_attr( $noticeHash ) . '" data-view-mode="' . esc_attr( $viewMode ) . '">';

	// Fallback CSS per JS disabilitato
	echo '<noscript><style>.avviso-container{opacity:1!important;visibility:visible!important;}</style></noscript>';

	echo '<div class="avviso-content last-child-no-margin underlined-links">';

	// Il testo può contenere solo <br /> e <br>
	$testo_pulito = wp_kses( $testo, array( 'br' => array() ) );

	// Output del testo con eventuale link nello stesso paragrafo
	echo '<p>' . $testo_pulito;

	// Aggiungi il link alla fine se presente
	if ( ! empty( $link ) && ! empty( $testoLink ) ) {
		echo ' <a href="' . esc_url( $link ) . '" class="avviso-link">' . esc_html__( $testoLink ) . '</a>';
	}

	echo '</p>';

	echo '</div>';

	// Bottone close
	echo '<button type="button" class="close-header-notice close-header-notice-js"><span class="screen-reader-text">Nascondi questo avviso permanentemente</span></button>';

	echo '</div>';
}
