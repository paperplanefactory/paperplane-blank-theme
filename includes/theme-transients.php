<?php
/**
 * Sistema di gestione transient per tema PaperPlane
 * Ottimizza le performance cachando i dati ACF usando transient WordPress
 */

global $use_transients_fields;
$use_transients_fields = get_field( 'use_transients_fields', 'option' );

/**
 * Configura il supporto multilingua per il sistema di transient
 * 
 * @return array Array degli slug delle lingue disponibili o 'any-lang' per siti monolingua
 */
function paperplane_multilang_setup() {
	// Verifica se Polylang Ã¨ attivo e restituisce array degli slug delle lingue disponibili
	if ( function_exists( 'PLL' ) ) {
		$langs_parameters = array(
			'hide_if_empty' => 0,
			'fields' => 'slug'
		);
		$languages = pll_languages_list( $langs_parameters );
	}
	// Imposta parametro di fallback per siti monolingua
	else {
		$languages = array( 'any-lang' );
	}
	return $languages;
}

/**
 * Recupera i campi ACF di un contenuto usando transient cache
 * 
 * @param int $content_id ID del post/pagina
 * @return array|false Campi ACF del contenuto
 */
function paperplane_content_transients( $content_id ) {
	global $use_transients_fields;
	if ( $use_transients_fields == 1 ) {
		// Tentativo di recupero dal cache transient
		$content_fields_transient = get_transient( 'paperplane_transient_content_fields_' . $content_id );
		if ( empty( $content_fields_transient ) ) {
			// Cache miss: recupera dal database e salva in transient
			$content_fields = get_fields( $content_id );
			set_transient( 'paperplane_transient_content_fields_' . $content_id, $content_fields, DAY_IN_SECONDS * 4 );
		} else {
			// Cache hit: usa dati dal transient
			$content_fields = $content_fields_transient;
		}
	} else {
		// Transient disabilitati: recupera sempre dal database
		$content_fields = get_fields( $content_id );
	}
	return $content_fields;
}

/**
 * Pre-genera transient per i campi ACF durante il salvataggio del post
 * Evita il carico della prima richiesta dopo il salvataggio
 * 
 * @param int $content_id ID del post salvato
 */
function paperplane_content_transients_generation( $content_id ) {
	global $use_transients_fields;
	if ( $use_transients_fields == 1 ) {
		// Evita l'esecuzione durante il salvataggio automatico per prestazioni
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}
		// Crea transient solo se non esiste giÃ 
		$content_fields_transient = get_transient( 'paperplane_transient_content_fields_' . $content_id );
		if ( empty( $content_fields_transient ) ) {
			$content_fields = get_fields( $content_id );
			set_transient( 'paperplane_transient_content_fields_' . $content_id, $content_fields, DAY_IN_SECONDS * 4 );
		}
	}
}

add_action( 'save_post', 'paperplane_content_transients_generation', 20, 3 );

/**
 * Recupera le opzioni ACF globali usando transient cache
 * 
 * @return array|false Campi delle opzioni ACF
 */
function paperplane_options_transients() {
	global $use_transients_fields;
	if ( $use_transients_fields == 1 ) {
		// Tentativo di recupero dal cache
		$paperplane_transient_options_fields_ = get_transient( 'paperplane_transient_options_fields_' );
		if ( empty( $paperplane_transient_options_fields_ ) ) {
			// Cache miss: recupera e salva
			$options_fields = get_fields( 'options' );
			set_transient( 'paperplane_transient_options_fields_', $options_fields, DAY_IN_SECONDS * 4 );
		} else {
			// Cache hit: usa transient
			$options_fields = $paperplane_transient_options_fields_;
		}
		return $options_fields;
	} else {
		// Bypass cache: accesso diretto al database
		$options_fields = get_fields( 'options' );
		return $options_fields;
	}
}

/**
 * Recupera opzioni ACF specifiche per lingua usando transient cache
 * Utilizzato con plugin multilingua come Polylang
 * 
 * @param string $acf_options_parameter Parametro linguaggio (es. 'options_en', 'options_it')
 * @return array|false Campi delle opzioni per la lingua specifica
 */
function paperplane_options_transients_multilanguage( $acf_options_parameter ) {
	global $use_transients_fields;
	if ( $use_transients_fields == 1 ) {
		// Cache key specifico per lingua
		$options_fields_multilang_transient = get_transient( 'paperplane_transient_options_fields_multilang_' . $acf_options_parameter );
		if ( empty( $options_fields_multilang_transient ) ) {
			// Recupera dati specifici lingua dal database
			$options_fields_multilang = get_fields( $acf_options_parameter );
			set_transient( 'paperplane_transient_options_fields_multilang_' . $acf_options_parameter, $options_fields_multilang, DAY_IN_SECONDS * 4 );
		} else {
			$options_fields_multilang = $options_fields_multilang_transient;
		}
		return $options_fields_multilang;
	} else {
		$options_fields_multilang = get_fields( $acf_options_parameter );
		return $options_fields_multilang;
	}
}

/**
 * Invalida tutti i transient PaperPlane quando un post viene salvato
 * Strategia aggressiva per garantire coerenza dei dati
 * 
 * @param int $post_id ID del post
 * @param object $post Oggetto post
 * @param bool $update True se Ã¨ un aggiornamento, false se nuovo post
 */
function paperplane_delete_content_transients( $post_id, $post, $update ) {
	// Invalida tutti i tipi di transient per sicurezza
	delete_transients_with_prefix( 'paperplane_transient_content_fields_' );
	delete_transients_with_prefix( 'paperplane_transient_query_modals_' );
	delete_transients_with_prefix( 'paperplane_transient_query_mega_menus' );
	delete_transients_with_prefix( 'paperplane_transient_options_fields_' );
	delete_transients_with_prefix( 'paperplane_transient_options_fields_multilang_' );
}
add_action( 'save_post', 'paperplane_delete_content_transients', 10, 3 );
add_action( 'wp_trash_post', 'paperplane_delete_content_transients_on_post_delete', 10 );
add_action( 'delete_post', 'paperplane_delete_content_transients_on_post_delete', 10 );

/**
 * Invalida transient quando un post viene eliminato definitivamente
 * Versione semplificata senza parametri del post
 */
function paperplane_delete_content_transients_on_post_delete() {
	delete_transients_with_prefix( 'paperplane_transient_content_fields_' );
	delete_transients_with_prefix( 'paperplane_transient_query_modals_' );
	delete_transients_with_prefix( 'paperplane_transient_query_mega_menus' );
	delete_transients_with_prefix( 'paperplane_transient_options_fields_' );
	delete_transients_with_prefix( 'paperplane_transient_options_fields_multilang_' );
}

/**
 * Invalida transient delle opzioni quando vengono salvate le pagine opzioni ACF
 * Hook specifico per ACF che si attiva solo al salvataggio opzioni
 */
function paperplane_delete_option_pages_transients() {
	// Rimuove transient opzioni generali
	delete_transient( 'paperplane_transient_options_fields_' );

	// Rimuove transient per tutte le lingue disponibili
	$languages = paperplane_multilang_setup();
	foreach ( $languages as $language ) {
		delete_transient( 'paperplane_transient_options_fields_multilang_' . $language );
	}
}
add_action( 'acf/save_post', 'paperplane_delete_option_pages_transients', 20 );

/**
 * Cancella tutti i transient che iniziano con un prefisso specifico
 * 
 * @param string $prefix Prefisso dei transient da eliminare
 */
function delete_transients_with_prefix( $prefix ) {
	foreach ( get_transient_keys_with_prefix( $prefix ) as $key ) {
		delete_transient( $key );
	}
}

/**
 * Trova tutte le chiavi transient nel database che iniziano con un prefisso
 * 
 * @param string $prefix Prefisso da cercare
 * @return array Array delle chiavi transient trovate (senza prefisso _transient_)
 */
function get_transient_keys_with_prefix( $prefix ) {
	global $wpdb;
	$prefix = $wpdb->esc_like( '_transient_' . $prefix );
	$sql = "SELECT `option_name` FROM $wpdb->options WHERE `option_name` LIKE '%s'";
	$keys = $wpdb->get_results( $wpdb->prepare( $sql, $prefix . '%' ), ARRAY_A );

	if ( is_wp_error( $keys ) ) {
		return [];
	}

	return array_map( function ( $key ) {
		// Rimuove il prefisso '_transient_' dal nome dell'opzione per uso con delete_transient()
		return ltrim( $key['option_name'], '_transient_' );
	}, $keys );
}

/**
 * Programma l'evento cron giornaliero per la pulizia automatica dei transient
 * Esecuzione fissata alle 05:00 per minimizzare l'impatto sulle prestazioni
 */
function paperplane_schedule_transient_cleanup() {
	if ( ! wp_next_scheduled( 'paperplane_cleanup_transients' ) ) {
		// Calcola il prossimo timestamp per le 05:00
		$next_5am = strtotime( 'today 05:00' );
		if ( $next_5am <= time() ) {
			$next_5am = strtotime( 'tomorrow 05:00' );
		}

		wp_schedule_event( $next_5am, 'daily', 'paperplane_cleanup_transients' );
	}
}
add_action( 'wp', 'paperplane_schedule_transient_cleanup' );

/**
 * Esegue la pulizia automatica dei transient scaduti e orfani
 * Chiamata dal cron job giornaliero alle 05:00
 */
function paperplane_auto_cleanup_transients() {
	global $wpdb;

	// Log di inizio pulizia (solo se WP_DEBUG attivo)
	if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
		error_log( 'PaperPlane: Avvio pulizia automatica transient' );
	}

	// Query per trovare transient scaduti confrontando timestamp timeout con ora corrente
	$expired_transients = $wpdb->get_col( $wpdb->prepare( "
        SELECT REPLACE(option_name, '_transient_timeout_', '') 
        FROM {$wpdb->options} 
        WHERE option_name LIKE %s 
        AND option_value < %d
    ", '_transient_timeout_paperplane_transient_%', time() ) );

	$cleaned_count = 0;

	foreach ( $expired_transients as $transient_key ) {
		if ( delete_transient( $transient_key ) ) {
			$cleaned_count++;
		}
	}

	// Trova e rimuove transient "orfani" (senza record di timeout corrispondente)
	// Questo puÃ² accadere quando i timeout vengono eliminati ma non i dati transient
	$orphaned_transients = $wpdb->get_col( $wpdb->prepare( "
        SELECT REPLACE(option_name, '_transient_', '') 
        FROM {$wpdb->options} t1
        WHERE option_name LIKE %s 
        AND NOT EXISTS (
            SELECT 1 FROM {$wpdb->options} t2 
            WHERE t2.option_name = CONCAT('_transient_timeout_', REPLACE(t1.option_name, '_transient_', ''))
        )
    ", '_transient_paperplane_transient_%' ) );

	foreach ( $orphaned_transients as $transient_key ) {
		if ( delete_transient( $transient_key ) ) {
			$cleaned_count++;
		}
	}

	// Log del risultato della pulizia (solo se elementi rimossi e debug attivo)
	if ( defined( 'WP_DEBUG' ) && WP_DEBUG && $cleaned_count > 0 ) {
		error_log( "PaperPlane: Rimosse {$cleaned_count} transient scadute/orfane" );
	}

	// Ottimizzazione tabella database se rimosse molte transient (migliora prestazioni)
	if ( $cleaned_count > 50 ) {
		$wpdb->query( "OPTIMIZE TABLE {$wpdb->options}" );
	}
}
add_action( 'paperplane_cleanup_transients', 'paperplane_auto_cleanup_transients' );

/**
 * Pulisce tutti gli eventi cron quando il tema/plugin viene disattivato
 * Evita l'accumulo di cron jobs orfani nel sistema
 */
function paperplane_deactivate_cleanup() {
	wp_clear_scheduled_hook( 'paperplane_cleanup_transients' );
}
// NOTA: Decommentare e collegare all'hook di disattivazione del tema/plugin quando necessario
// register_deactivation_hook( __FILE__, 'paperplane_deactivate_cleanup' );

/*
======================================================================
ESEMPI DI UTILIZZO DELLE FUNZIONI TRANSIENT
======================================================================
*/

/**
 * ESEMPIO 1: paperplane_content_transients()
 * Recupera campi ACF di un post/pagina con cache automatico
 */

/*
// In single.php, page.php o nei template
global $post;

// Recupera tutti i campi ACF del post corrente
$campi_post = paperplane_content_transients( $post->ID );

// Uso dei campi recuperati
if ( $campi_post ) {
	$titolo_hero = $campi_post['titolo_hero'] ?? '';
	$immagine_featured = $campi_post['immagine_featured'] ?? '';
	$contenuto_extra = $campi_post['contenuto_extra'] ?? '';

	// Output
	if ( $titolo_hero ) {
		echo '<h2>' . esc_html( $titolo_hero ) . '</h2>';
	}
}

// Per un post specifico (es. homepage ID 15)
$campi_homepage = paperplane_content_transients( 15 );

// Per la pagina corrente in un template
$campi_corrente = paperplane_content_transients( get_the_ID() );

// Per un post in un loop
while ( have_posts() ) {
	the_post();
	$campi_loop = paperplane_content_transients( get_the_ID() );
	// ... usa i campi
}
*/

/**
 * ESEMPIO 2: paperplane_options_transients()
 * Recupera opzioni globali ACF con cache
 */

/*
// In header.php
$opzioni = paperplane_options_transients();

if ( $opzioni ) {
	$logo_sito = $opzioni['logo_sito'] ?? '';
	$colore_tema = $opzioni['colore_tema'] ?? '#000000';
	$menu_principale = $opzioni['menu_principale'] ?? '';

	// Uso nel template
	if ( $logo_sito ) {
		echo '<img src="' . esc_url( $logo_sito['url'] ) . '" alt="Logo">';
	}

	// CSS dinamico
	echo '<style>:root { --colore-tema: ' . esc_attr( $colore_tema ) . '; }</style>';
}

// In footer.php
$opzioni = paperplane_options_transients();

$copyright = $opzioni['testo_copyright'] ?? '';
$social_links = $opzioni['social_links'] ?? array();
$indirizzo = $opzioni['indirizzo_azienda'] ?? '';

echo '<footer>';
if ( $copyright ) {
	echo '<p>' . esc_html( $copyright ) . '</p>';
}
echo '</footer>';
*/

/**
 * ESEMPIO 3: paperplane_options_transients_multilanguage()
 * Recupera opzioni specifiche per lingua (con Polylang)
 */

/*
// In functions.php per siti multilingua
if ( function_exists( 'pll_current_language' ) ) {
	$lingua_corrente = pll_current_language();

	// Recupera opzioni per la lingua corrente
	$opzioni_lingua = paperplane_options_transients_multilanguage( 'options_' . $lingua_corrente );

	if ( $opzioni_lingua ) {
		$titolo_sito = $opzioni_lingua['titolo_sito'] ?? '';
		$descrizione = $opzioni_lingua['descrizione_sito'] ?? '';
		$contatti = $opzioni_lingua['info_contatti'] ?? '';

		// Uso nel template
		echo '<h1>' . esc_html( $titolo_sito ) . '</h1>';
		echo '<p>' . esc_html( $descrizione ) . '</p>';
	}
}

// Esempio con gestione fallback
$lingua = pll_current_language() ?? 'it'; // Default italiano

// Prova con lingua specifica
$opzioni = paperplane_options_transients_multilanguage( 'options_' . $lingua );

// Se non trova nulla, usa opzioni generali
if ( empty( $opzioni ) ) {
	$opzioni = paperplane_options_transients();
}
*/

/**
 * ESEMPIO 4: Uso in query personalizzate e loop complessi
 */

/*
// Loop personalizzato con cache ACF
$posts_query = new WP_Query( array(
	'post_type' => 'prodotto',
	'posts_per_page' => 6,
	'meta_key' => 'in_evidenza',
	'meta_value' => '1'
) );

if ( $posts_query->have_posts() ) {
	echo '<div class="prodotti-evidenza">';
	while ( $posts_query->have_posts() ) {
		$posts_query->the_post();

		// Recupera campi ACF con cache
		$campi_prodotto = paperplane_content_transients( get_the_ID() );

		$prezzo = $campi_prodotto['prezzo'] ?? '';
		$immagine_gallery = $campi_prodotto['gallery_prodotto'] ?? array();
		$caratteristiche = $campi_prodotto['caratteristiche'] ?? array();

		echo '<div class="prodotto-card">';
		echo '<h3>' . get_the_title() . '</h3>';
		if ( $prezzo ) {
			echo '<p class="prezzo">€ ' . esc_html( $prezzo ) . '</p>';
		}
		echo '</div>';
	}
	echo '</div>';
	wp_reset_postdata();
}
*/