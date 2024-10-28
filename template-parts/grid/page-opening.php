<?php
/* 
richiamo il tipo di apertura in base al tipo di contenuto
la prima condizione è per i template di pagina e per il singolo post
se ci sono nuovi CPT vanno aggiunti qui is_singular( 'cpt_nome' )
se il nuovo CPT ha una apertura differente da quelle predefinite aggiungere una condizione specifica dopo questa per gestire più agilmente il layout
*/
if ( is_page_template( 'page-modules.php' ) || is_page_template( 'page-listing.php' ) || is_singular( 'post' ) ) {
	// verifico se esiste l'oggetto $post
	if ( isset( $post ) ) {
		// se esiste l'oggetto $post richiamo l'array con i campi personalizzati
		$content_fields = paperplane_content_transients( $post->ID );
	}
	// verifico se esiste la chiave dell'array del campo che mi serve e se ha un valore
	if ( $content_fields['page_opening_layout'] ?? null ) {
		// verifico se il campo ha il valore per apertura fullscreen
		if ( $content_fields['page_opening_layout'] === 'opening-fullscreen' || $content_fields['page_opening_layout'] === 'opening-almost-fullscreen' ) {
			include( locate_template( 'template-parts/grid/page-opening/opening-fullscreen.php' ) );
		}
		// altrimenti uso l'apertura di solo testo
		if ( $content_fields['page_opening_layout'] === 'opening-text' ) {
			include( locate_template( 'template-parts/grid/page-opening/opening-text.php' ) );
		}
	}
}
// per la pagina di archivio generica: https://developer.wordpress.org/reference/functions/is_archive/
// per gestione archivio personalizzato di una tassonomia custom: https://developer.wordpress.org/reference/functions/is_tax/
if ( is_archive() ) {
	include( locate_template( 'template-parts/grid/page-opening/opening-archive.php' ) );
}
// per gestione risultati di ricerca: https://developer.wordpress.org/reference/functions/is_search/
if ( is_search() ) {
	include( locate_template( 'template-parts/grid/page-opening/opening-search.php' ) );
}
// per gestione 404: https://developer.wordpress.org/reference/functions/is_404/
if ( is_404() ) {
	include( locate_template( 'template-parts/grid/page-opening/opening-404.php' ) );
}
?>