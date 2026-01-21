<?php
/* 
Richiamo il tipo di apertura in base al tipo di contenuto
usando la configurazione centralizzata per eliminare duplicazione di logica
*/

// Ottiene la configurazione appropriata per il contesto corrente
$opening_config = get_page_opening_config( $content_fields );

// Se esiste una configurazione valida, include il template appropriato
if ( $opening_config && ! empty( $opening_config['template'] ) ) {
	include( locate_template( $opening_config['template'] ) );
}