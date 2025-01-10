<?php
/**
 * Aggiunge la pagina delle impostazioni
 */
add_action( 'admin_menu', function () {
	add_options_page(
		'Impostazioni JSON Generator',
		'Advanced search - JSON Generator',
		'manage_options',
		'json-generator-settings',
		'json_generator_settings_page'
	);
} );

/**
 * Registra le impostazioni
 */
add_action( 'admin_init', function () {
	register_setting( 'json_generator_options', 'json_generator_settings' );

	add_settings_section(
		'json_generator_main',
		'Impostazioni Generali',
		function () {
			echo '<p>Configura le impostazioni per la generazione del JSON.</p>';
		},
		'json-generator-settings'
	);

	add_settings_field(
		'frontend_js',
		'Caricamento script frontend',
		'json_generator_frontend_script_field',
		'json-generator-settings',
		'json_generator_main'
	);

	add_settings_field(
		'server_type',
		'Tipo di Server',
		'json_generator_server_type_field',
		'json-generator-settings',
		'json_generator_main'
	);

	add_settings_field(
		'post_types',
		'Post Types da includere',
		'json_generator_post_types_field',
		'json-generator-settings',
		'json_generator_main'
	);

	add_settings_field(
		'batch_size',
		'Post per batch',
		'json_generator_batch_size_field',
		'json-generator-settings',
		'json_generator_main'
	);

	add_settings_field(
		'auto_update',
		'Aggiornamento automatico',
		'json_generator_auto_update_field',
		'json-generator-settings',
		'json_generator_main'
	);

	add_settings_field(
		'daily_generation',
		'Generazione giornaliera',
		'json_generator_daily_generation_field',
		'json-generator-settings',
		'json_generator_main'
	);
} );

/**
 * Campo per abilitare/disabilitare il caricamento dello script frontend
 */
function json_generator_frontend_script_field() {
	$options = get_option( 'json_generator_settings' );
	$frontend_js = isset( $options['frontend_js'] ) ? $options['frontend_js'] : true;

	// Aggiungiamo un campo hidden che assicura che l'opzione esista sempre
	echo '<input type="hidden" name="json_generator_settings[frontend_js]" value="0">';
	echo '<label><input type="checkbox" name="json_generator_settings[frontend_js]" value="1" ' . checked( $frontend_js, true, false ) . '> ';
	echo 'Abilita il caricamento dello script search-suggestions.min.js</label>';
	echo '<p class="description">Se disabilitato, lo script non verrà caricato automaticamente nel frontend.</p>';
}

/**
 * Campo per selezionare il tipo di server
 */
function json_generator_server_type_field() {
	$options = get_option( 'json_generator_settings' );
	$server_type = isset( $options['server_type'] ) ? $options['server_type'] : 'apache';

	echo '<select name="json_generator_settings[server_type]">';
	echo '<option value="apache"' . selected( $server_type, 'apache', false ) . '>Apache</option>';
	echo '<option value="nginx"' . selected( $server_type, 'nginx', false ) . '>Nginx</option>';
	echo '</select>';
	echo '<p class="description">Seleziona il tipo di server web in uso. Questo influenza la generazione dei file compressi.</p>';
}

/**
 * Campo per i post types
 */
function json_generator_post_types_field() {
	$options = get_option( 'json_generator_settings' );
	$post_types = get_post_types( [ 'public' => true ], 'objects' );
	$saved_types = isset( $options['post_types'] ) ? $options['post_types'] : array();
	$priorities = isset( $options['post_type_priorities'] ) ? $options['post_type_priorities'] : array();

	// Valori predefiniti per le priorità
	$default_priorities = array(
		'page' => 1,    // Massima priorità per le pagine
		'post' => 2,    // Seconda priorità per i post
		'default' => 10 // Priorità predefinita per altri tipi
	);

	echo '<div style="max-height: 200px; overflow-y: auto; padding: 10px; border: 1px solid #ccc;">';
	echo '<p class="description">Seleziona i post type da includere e imposta la loro priorità nei risultati (numeri più bassi = priorità più alta)</p>';

	foreach ( $post_types as $post_type ) {
		$checked = in_array( $post_type->name, $saved_types ) ? 'checked' : '';

		// Assegna priorità con questo ordine:
		// 1. Priorità salvata nelle opzioni
		// 2. Priorità predefinita specifica per il post type
		// 3. Priorità predefinita generale
		$priority = $priorities[ $post_type->name ] ??
			$default_priorities[ $post_type->name ] ??
			$default_priorities['default'];

		printf(
			'<div style="display: flex; align-items: center; margin-bottom: 5px;">
                <label style="flex: 1;">
                    <input type="checkbox" name="json_generator_settings[post_types][]" 
                           value="%s" %s> %s
                </label>
                <input type="number" 
                       name="json_generator_settings[post_type_priorities][%s]" 
                       value="%s" 
                       min="1"
                       style="width: 70px; margin-left: 10px;">
            </div>',
			esc_attr( $post_type->name ),
			$checked,
			esc_html( $post_type->labels->name ),
			esc_attr( $post_type->name ),
			esc_attr( $priority )
		);
	}
	echo '</div>';
}

/**
 * Campo per la dimensione del batch
 */
function json_generator_batch_size_field() {
	$options = get_option( 'json_generator_settings' );
	$batch_size = isset( $options['batch_size'] ) ? intval( $options['batch_size'] ) : 50;

	echo '<input type="number" name="json_generator_settings[batch_size]" value="' . esc_attr( $batch_size ) . '" min="1" max="500">';
	echo '<p class="description">Numero di post da processare per ogni batch (1-500). Un numero più basso usa meno memoria.</p>';
}

/**
 * Campo per abilitare/disabilitare update al salvataggio del singolo contenuto
 */
function json_generator_auto_update_field() {
	$options = get_option( 'json_generator_settings' );
	$auto_update = isset( $options['auto_update'] ) ? $options['auto_update'] : true;

	// Aggiungiamo un campo hidden che assicura che l'opzione esista sempre
	echo '<input type="hidden" name="json_generator_settings[auto_update]" value="0">';
	echo '<label><input type="checkbox" name="json_generator_settings[auto_update]" value="1" ' . checked( $auto_update, true, false ) . '> ';
	echo 'Abilita aggiornamento automatico del JSON durante il salvataggio dei contenuti</label>';
	echo '<p class="description">Se disabilitato, il JSON verrà aggiornato solo quando richiesto manualmente.</p>';
}
/**
 * Campo per abilitare/disabilitare update giornaliera
 */
function json_generator_daily_generation_field() {
	$options = get_option( 'json_generator_settings' );
	$daily_generation = isset( $options['daily_generation'] ) ? $options['daily_generation'] : false;

	echo '<label><input type="checkbox" name="json_generator_settings[daily_generation]" value="1" ' . checked( $daily_generation, true, false ) . '> ';
	echo 'Abilita generazione automatica giornaliera del JSON dopo mezzanotte</label>';
	echo '<p class="description">Il file JSON verrà rigenerato completamente ogni notte dopo mezzanotte.</p>';
}

/**
 * Crea file JSON compresso e non compresso
 */
/**
 * Crea file JSON compresso e non compresso in base al tipo di server
 */
function create_compressed_json( $json_data, $json_file ) {
	$options = get_option( 'json_generator_settings' );
	$server_type = isset( $options['server_type'] ) ? $options['server_type'] : 'apache';

	// Salva versione normale
	$temp_file = $json_file . '.tmp';
	$success = file_put_contents(
		$temp_file,
		json_encode( $json_data, JSON_UNESCAPED_UNICODE )
	);

	if ( $success ) {
		rename( $temp_file, $json_file );

		// Gestione della compressione in base al tipo di server
		if ( $server_type === 'apache' ) {
			// Crea versione compressa per Apache
			$gz_file = $json_file . '.gz';
			$gz = gzopen( $gz_file, 'w9' ); // 9 è il livello massimo di compressione
			gzwrite( $gz, file_get_contents( $json_file ) );
			gzclose( $gz );

			// Crea o aggiorna .htaccess per gestire la compressione
			$htaccess = dirname( $json_file ) . '/.htaccess';
			file_put_contents( $htaccess, "
# Abilita l'accesso ai file JSON
<FilesMatch \"(posts\\.json|posts\\.json\\.gz)$\">
    Order Allow,Deny
    Allow from all
</FilesMatch>

# Configura la codifica gzip
<FilesMatch \"\\.gz$\">
    AddEncoding gzip .gz
    ForceType application/json
</FilesMatch>

# Blocca l'accesso a tutti gli altri file
<Files ~ \"^(?!(posts\\.json|posts\\.json\\.gz)$)\">
    Order Allow,Deny
    Deny from all
</Files>" );
		} elseif ( $server_type === 'nginx' ) {
			// Per Nginx, rimuovi il file .gz se esiste
			$gz_file = $json_file . '.gz';
			if ( file_exists( $gz_file ) ) {
				unlink( $gz_file );
			}

			// Rimuovi anche .htaccess se esiste
			$htaccess = dirname( $json_file ) . '/.htaccess';
			if ( file_exists( $htaccess ) ) {
				unlink( $htaccess );
			}
		}
	}

	return $success;
}

/**
 * Pagina delle impostazioni
 */
function json_generator_settings_page() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	$upload_dir = wp_upload_dir();
	$json_file = $upload_dir['baseurl'] . '/json-data/posts.json';
	$gz_file = $json_file . '.gz';

	if ( isset( $_GET['message'] ) ) {
		if ( $_GET['message'] === 'json-updated' ) {
			$processed = isset( $_GET['processed'] ) ? intval( $_GET['processed'] ) : 0;
			$total = isset( $_GET['total'] ) ? intval( $_GET['total'] ) : 0;
			if ( $total > 0 ) {
				$percentage = round( ( $processed / $total ) * 100 );
				echo '<div class="notice notice-success"><p>File JSON aggiornato. Processati ' . $processed . ' post su ' . $total . ' (' . $percentage . '%).</p></div>';
			} else {
				echo '<div class="notice notice-success"><p>File JSON aggiornato con successo.</p></div>';
			}
		}
	}
	?>
	<div class="wrap">
		<h1>Impostazioni JSON Generator</h1>

		<!-- Progress bar -->
		<div id="json-progress" style="display: none;" class="notice notice-info">
			<p>
				<span id="json-progress-text">Generazione in corso...</span>
				<br>
				<progress id="json-progress-bar" value="0" max="100" style="width: 100%; margin-top: 10px;"></progress>
			</p>
			<style>
				#json-progress-bar {
					progress::-moz-progress-bar {
						background: #000ccc;
					}

					progress::-webkit-progress-value {
						background: #000ccc;
					}

					progress {
						color: #000ccc;
					}
				}
			</style>
		</div>

		<form action="options.php" method="post">
			<?php
			settings_fields( 'json_generator_options' );
			do_settings_sections( 'json-generator-settings' );
			submit_button( 'Salva Impostazioni' );
			?>
		</form>

		<hr>

		<h2>Genera JSON</h2>
		<p>File JSON corrente:
			<br><code><?php echo esc_html( $json_file ); ?></code>
			<br><code><?php echo esc_html( $gz_file ); ?></code> (versione compressa)
		</p>

		<?php
		// Mostra dimensioni dei file se esistono
		$json_path = $upload_dir['basedir'] . '/json-data/posts.json';
		$gz_path = $json_path . '.gz';
		if ( file_exists( $json_path ) && file_exists( $gz_path ) ) {
			$json_size = filesize( $json_path );
			$gz_size = filesize( $gz_path );
			if ( $json_size > 0 ) {
				$json_formatted = size_format( $json_size );
				$gz_formatted = size_format( $gz_size );
				$compression = round( ( 1 - $gz_size / $json_size ) * 100 );
				echo "<p>Dimensioni:<br>
					  - Non compresso: {$json_formatted}<br>
					  - Compresso: {$gz_formatted} (riduzione del {$compression}%)</p>";
			} else {
				echo "<p>Il file JSON sembra essere vuoto.</p>";
			}
		}
		?>

		<form method="post" action="<?php echo admin_url( 'admin-post.php' ); ?>">
			<?php wp_nonce_field( 'generate_json_action', 'json_generator_nonce' ); ?>
			<input type="hidden" name="action" value="generate_json_action">
			<p><input type="number" name="post_id" placeholder="ID del post da aggiornare (opzionale)"></p>
			<input type="submit" class="button button-primary" value="Aggiorna JSON">
		</form>
	</div>

	<script>
		jQuery(document).ready(function ($) {
			let isGenerating = false;
			let currentBatch = 0;

			function updateProgress(processed, total) {
				const percentage = Math.round((processed / total) * 100);
				$('#json-progress-bar').attr('value', processed).attr('max', total);
				$('#json-progress-text').text(`Processati ${processed} post su ${total} (${percentage}%)`);
			}

			function checkProgress() {
				if (!isGenerating) return;

				$.ajax({
					url: ajaxurl,
					type: 'POST',
					data: {
						action: 'check_json_progress',
						batch: currentBatch,
						nonce: '<?php echo wp_create_nonce( "check_json_progress" ); ?>'
					},
					success: function (response) {
						if (response.processed !== undefined && response.total !== undefined) {
							updateProgress(response.processed, response.total);

							if (response.isCompleted) {
								isGenerating = false;
								setTimeout(function () {
									window.location.href = '<?php echo add_query_arg( [ "page" => "json-generator-settings", "message" => "json-updated" ], admin_url( "options-general.php" ) ); ?>';
								}, 1000);
							} else {
								currentBatch++;
								continueGeneration();
							}
						}
					},
					error: function () {
						console.error('Errore nel controllo del progresso');
					}
				});
			}

			function continueGeneration() {
				$.ajax({
					url: ajaxurl,
					type: 'POST',
					data: {
						action: 'generate_json_action',
						batch: currentBatch,
						json_generator_nonce: '<?php echo wp_create_nonce( "generate_json_action" ); ?>'
					},
					success: function (response) {
						if (response.success) {
							setTimeout(checkProgress, 1000);
						} else {
							console.error('Errore nella generazione del batch');
						}
					},
					error: function () {
						console.error('Errore nella chiamata AJAX');
					}
				});
			}

			$('form[action="<?php echo admin_url( "admin-post.php" ); ?>"]').on('submit', function (e) {
				if ($(this).find('input[name="post_id"]').val()) {
					return true;
				}

				e.preventDefault();
				isGenerating = true;
				currentBatch = 0;
				$('#json-progress').show();

				continueGeneration();

				return false;
			});
		});
	</script>
	<?php
}

/**
 * Ottiene i dati di un post per il JSON
 */
function get_post_json_data( $post_id ) {
	if ( get_post_status( $post_id ) !== 'publish' ) {
		return null;
	}

	$searchable_fields = array(
		'new_module' => array(
			'module_text',
			'module_highlighted_sentence_text',
			'module_highlighted_sentence_author',
			'module_fullscreen_image_main_text',
			'module_fullscreen_image_secondary_text',
			'module_scroll_text_content'
		),
		'direct' => array(
			'page_opening_title',
			'page_opening_subtitle'
		)
	);

	$all_fields = get_fields( $post_id, false );
	$searchable_content = '';

	if ( ! empty( $all_fields['new_module'] ) && is_array( $all_fields['new_module'] ) ) {
		foreach ( $all_fields['new_module'] as $module ) {
			foreach ( $searchable_fields['new_module'] as $field ) {
				if ( ! empty( $module[ $field ] ) ) {
					$searchable_content .= ' ' . wp_strip_all_tags( $module[ $field ], true );
				}
			}
		}
	}

	foreach ( $searchable_fields['direct'] as $field ) {
		if ( ! empty( $all_fields[ $field ] ) ) {
			$searchable_content .= ' ' . wp_strip_all_tags( $all_fields[ $field ], true );
		}
	}

	return array(
		'id' => $post_id,
		'title' => get_the_title( $post_id ),
		'url' => get_permalink( $post_id ),
		'post_type' => get_post_type( $post_id ),
		'featured_image' => get_the_post_thumbnail_url( $post_id, 'full' ) ?: '',
		'searchable_content' => trim( $searchable_content ),
		'modified' => get_the_modified_date( 'Y-m-d H:i:s', $post_id )
	);
}

/**
 * Endpoint per controllare il progresso
 */
add_action( 'wp_ajax_check_json_progress', function () {
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_send_json_error( 'Permesso negato' );
	}

	$batch = isset( $_POST['batch'] ) ? intval( $_POST['batch'] ) : 0;
	$options = get_option( 'json_generator_settings' );
	$post_types = isset( $options['post_types'] ) ? $options['post_types'] : array( 'post' );
	$batch_size = isset( $options['batch_size'] ) ? intval( $options['batch_size'] ) : 50;

	// Conta il totale
	$count_args = array(
		'post_type' => $post_types,
		'post_status' => 'publish',
		'posts_per_page' => -1,
		'fields' => 'ids',
		'no_found_rows' => false
	);
	$count_query = new WP_Query( $count_args );
	$total = $count_query->found_posts;

	// Calcola quanti post sono stati processati in questo batch
	$args = array(
		'post_type' => $post_types,
		'post_status' => 'publish',
		'posts_per_page' => $batch_size,
		'offset' => $current_batch * $batch_size,
		'orderby' => 'modified',
		'order' => 'DESC',
		'fields' => 'ids'
	);

	$posts = get_posts( $args );
	$processed = ( $batch * $batch_size ) + count( $posts );
	$processed = min( $processed, $total ); // Non superare il totale

	wp_send_json( [ 
		'processed' => $processed,
		'total' => $total,
		'isCompleted' => $processed >= $total
	] );
} );

/**
 * Endpoint AJAX per la generazione
 */
add_action( 'wp_ajax_generate_json_action', function () {
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_send_json_error( 'Permesso negato' );
	}

	if ( ! wp_verify_nonce( $_POST['json_generator_nonce'], 'generate_json_action' ) ) {
		wp_send_json_error( 'Verifica di sicurezza fallita' );
	}

	$upload_dir = wp_upload_dir();
	$json_dir = $upload_dir['basedir'] . '/json-data';
	$json_file = $json_dir . '/posts.json';

	if ( ! file_exists( $json_dir ) ) {
		wp_mkdir_p( $json_dir );
	}

	$current_batch = isset( $_POST['batch'] ) ? intval( $_POST['batch'] ) : 0;

	// Se è il primo batch, inizializza un array vuoto
	if ( $current_batch === 0 ) {
		$json_data = array();
	} else {
		// Altrimenti carica il JSON esistente
		$json_data = file_exists( $json_file ) ? json_decode( file_get_contents( $json_file ), true ) : array();
		if ( ! is_array( $json_data ) ) {
			$json_data = array();
		}
	}

	$options = get_option( 'json_generator_settings' );
	$post_types = isset( $options['post_types'] ) ? $options['post_types'] : array( 'post' );
	$batch_size = isset( $options['batch_size'] ) ? intval( $options['batch_size'] ) : 50;

	// Recupera i post per questo batch
	$args = array(
		'post_type' => $post_types,
		'post_status' => 'publish',
		'posts_per_page' => $batch_size,
		'offset' => $current_batch * $batch_size,
		'orderby' => 'ID',
		'order' => 'ASC',
		'fields' => 'ids'
	);

	$posts = get_posts( $args );
	foreach ( $posts as $post_id ) {
		$post_data = get_post_json_data( $post_id );
		if ( $post_data ) {
			$json_data[ $post_id ] = $post_data;
		}
		clean_post_cache( $post_id );
	}

	// Usa la funzione di compressione
	$success = create_compressed_json( $json_data, $json_file );

	if ( $success ) {
		wp_send_json_success();
	} else {
		wp_send_json_error( 'Errore nella scrittura del file JSON' );
	}
} );

/**
 * Handler per il form POST (singolo post)
 */
add_action( 'admin_post_generate_json_action', function () {
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( 'Permesso negato' );
	}

	if ( ! wp_verify_nonce( $_POST['json_generator_nonce'], 'generate_json_action' ) ) {
		wp_die( 'Verifica di sicurezza fallita' );
	}

	if ( ! empty( $_POST['post_id'] ) ) {
		$upload_dir = wp_upload_dir();
		$json_dir = $upload_dir['basedir'] . '/json-data';
		$json_file = $json_dir . '/posts.json';

		if ( ! file_exists( $json_dir ) ) {
			wp_mkdir_p( $json_dir );
		}

		$json_data = file_exists( $json_file ) ? json_decode( file_get_contents( $json_file ), true ) : array();
		if ( ! is_array( $json_data ) ) {
			$json_data = array();
		}

		$post_id = intval( $_POST['post_id'] );
		$post_data = get_post_json_data( $post_id );
		if ( $post_data ) {
			$json_data[ $post_id ] = $post_data;
		} else {
			unset( $json_data[ $post_id ] );
		}

		// Usa la funzione di compressione anche per il singolo post
		create_compressed_json( $json_data, $json_file );

		wp_redirect( add_query_arg(
			array(
				'page' => 'json-generator-settings',
				'message' => 'json-updated',
				'processed' => 1,
				'total' => 1
			),
			admin_url( 'options-general.php' )
		) );
		exit;
	}

	wp_redirect( add_query_arg(
		array( 'page' => 'json-generator-settings' ),
		admin_url( 'options-general.php' )
	) );
	exit;
} );

add_action( 'wp_after_insert_post', function ($post_id, $post, $update) {
	// Controllo se l'aggiornamento automatico è abilitato
	$options = get_option( 'json_generator_settings' );
	if ( ! isset( $options['auto_update'] ) || ! $options['auto_update'] ) {
		return;
	}
	// Ignora se è un autosave o revisione
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
		return;
	if ( wp_is_post_revision( $post_id ) )
		return;

	// Controlla se il post è pubblicato
	if ( $post->post_status !== 'publish' )
		return;

	// Verifica se il tipo di post è tra quelli configurati
	$options = get_option( 'json_generator_settings' );
	$post_types = isset( $options['post_types'] ) ? $options['post_types'] : array( 'post' );
	if ( ! in_array( $post->post_type, $post_types ) )
		return;

	// Aggiorna il JSON in modo asincrono
	wp_schedule_single_event( time(), 'update_json_for_post', array( $post_id ) );
}, 10, 3 );

// Registra l'evento cron
add_action( 'update_json_for_post', function ($post_id) {
	$upload_dir = wp_upload_dir();
	$json_dir = $upload_dir['basedir'] . '/json-data';
	$json_file = $json_dir . '/posts.json';

	// Crea la directory se non esiste
	if ( ! file_exists( $json_dir ) ) {
		wp_mkdir_p( $json_dir );
	}

	// Inizializza array vuoto se il file non esiste o non è valido
	$json_data = [];
	if ( file_exists( $json_file ) ) {
		$json_data = json_decode( file_get_contents( $json_file ), true );
		if ( ! is_array( $json_data ) ) {
			$json_data = [];
		}
	}

	// Aggiorna o rimuovi il post dal JSON
	$post_data = get_post_json_data( $post_id );
	if ( $post_data ) {
		$json_data[ $post_id ] = $post_data;
	} else {
		unset( $json_data[ $post_id ] );
	}

	create_compressed_json( $json_data, $json_file );
} );

/**
 * Script frontend
 */
add_action( 'wp_enqueue_scripts', function () {
	$options = get_option( 'json_generator_settings' );

	// Verifica se il caricamento dello script frontend è abilitato
	if ( ! isset( $options['frontend_js'] ) || $options['frontend_js'] ) {
		wp_enqueue_script( 'search-suggestions', get_template_directory_uri() . '/assets/js/search-suggestions.min.js', array(), '1.0', true );

		$upload_dir = wp_upload_dir();
		$json_url = $upload_dir['baseurl'] . '/json-data/posts.json';

		wp_localize_script( 'search-suggestions', 'searchConfig', array(
			'jsonUrl' => $json_url,
			'gzipUrl' => $options['server_type'] === 'apache' ? $json_url . '.gz' : null,
			'postTypePriorities' => $options['post_type_priorities'] ?? array()
		) );
	}
} );


// Registra l'evento cron giornaliero
add_action( 'admin_init', function () {
	if ( ! wp_next_scheduled( 'daily_json_generation_start' ) ) {
		wp_schedule_event( strtotime( 'tomorrow midnight' ), 'daily', 'daily_json_generation_start' );
	}
} );

// Avvia la generazione giornaliera
add_action( 'daily_json_generation_start', function () {
	$options = get_option( 'json_generator_settings' );

	// Controlla se la generazione giornaliera è abilitata
	if ( ! isset( $options['daily_generation'] ) || ! $options['daily_generation'] ) {
		return;
	}

	// Inizializza il processo batch
	wp_schedule_single_event( time(), 'daily_json_generation_batch', array( 0 ) );
} );

// Esegue un singolo batch
add_action( 'daily_json_generation_batch', function ($current_batch) {
	$options = get_option( 'json_generator_settings' );
	$post_types = isset( $options['post_types'] ) ? $options['post_types'] : array( 'post' );
	$batch_size = isset( $options['batch_size'] ) ? intval( $options['batch_size'] ) : 50;

	// Setup file JSON
	$upload_dir = wp_upload_dir();
	$json_dir = $upload_dir['basedir'] . '/json-data';
	$json_file = $json_dir . '/posts.json';

	if ( ! file_exists( $json_dir ) ) {
		wp_mkdir_p( $json_dir );
	}

	// Carica il JSON esistente solo al primo batch
	if ( $current_batch === 0 ) {
		$json_data = array();
	} else {
		$json_data = json_decode( file_get_contents( $json_file ), true );
		if ( ! is_array( $json_data ) ) {
			$json_data = array();
		}
	}

	// Conta il totale dei post
	$count_args = array(
		'post_type' => $post_types,
		'post_status' => 'publish',
		'posts_per_page' => -1,
		'fields' => 'ids',
		'no_found_rows' => false
	);
	$count_query = new WP_Query( $count_args );
	$total_published = $count_query->found_posts;
	wp_reset_postdata();

	// Recupera i post per questo batch
	$args = array(
		'post_type' => $post_types,
		'post_status' => 'publish',
		'posts_per_page' => $batch_size,
		'offset' => $current_batch * $batch_size,
		'orderby' => 'modified',
		'order' => 'DESC',
		'fields' => 'ids'
	);

	$posts = get_posts( $args );
	foreach ( $posts as $post_id ) {
		$post_data = get_post_json_data( $post_id );
		if ( $post_data ) {
			$json_data[ $post_id ] = $post_data;
		}
		clean_post_cache( $post_id );
	}

	// Salva il JSON
	$success = create_compressed_json( $json_data, $json_file );

	// Calcola il progresso
	$processed = ( $current_batch * $batch_size ) + count( $posts );

	if ( $processed < $total_published ) {
		// Schedula il prossimo batch
		wp_schedule_single_event( time() + 30, 'daily_json_generation_batch', array( $current_batch + 1 ) );
	}
} );

// Pulisce lo schedule quando l'opzione viene disattivata
add_action( 'update_option_json_generator_settings', function ($old_value, $new_value) {
	$old_daily = isset( $old_value['daily_generation'] ) ? $old_value['daily_generation'] : false;
	$new_daily = isset( $new_value['daily_generation'] ) ? $new_value['daily_generation'] : false;

	if ( $old_daily !== $new_daily ) {
		if ( $new_daily ) {
			if ( ! wp_next_scheduled( 'daily_json_generation_start' ) ) {
				wp_schedule_event( strtotime( 'tomorrow midnight' ), 'daily', 'daily_json_generation_start' );
			}
		} else {
			wp_clear_scheduled_hook( 'daily_json_generation_start' );
			wp_clear_scheduled_hook( 'daily_json_generation_batch' );
		}
	}
}, 10, 2 );

/**
 * Rimuove il post dal JSON quando viene eliminato
 */
/**
 * Rimuove il post dal JSON quando viene spostato nel cestino
 */
add_action( 'wp_trash_post', function ($post_id) {
	// Controllo se l'aggiornamento automatico è abilitato
	$options = get_option( 'json_generator_settings' );
	if ( ! isset( $options['auto_update'] ) || ! $options['auto_update'] ) {
		return;
	}

	// Verifica se il tipo di post è tra quelli configurati
	$post_type = get_post_type( $post_id );
	$post_types = isset( $options['post_types'] ) ? $options['post_types'] : array( 'post' );
	if ( ! in_array( $post_type, $post_types ) ) {
		return;
	}

	// Setup percorsi file
	$upload_dir = wp_upload_dir();
	$json_dir = $upload_dir['basedir'] . '/json-data';
	$json_file = $json_dir . '/posts.json';

	// Se il file JSON non esiste, non c'è niente da fare
	if ( ! file_exists( $json_file ) ) {
		return;
	}

	// Carica il JSON esistente
	$json_data = json_decode( file_get_contents( $json_file ), true );
	if ( ! is_array( $json_data ) ) {
		return;
	}

	// Rimuovi il post dal JSON se esiste
	if ( isset( $json_data[ $post_id ] ) ) {
		unset( $json_data[ $post_id ] );
		// Aggiorna il file JSON
		create_compressed_json( $json_data, $json_file );
	}
} );

/**
 * Rimuove il post dal JSON quando passa da pubblicato a bozza
 */
add_action( 'transition_post_status', function ($new_status, $old_status, $post) {
	// Verifica se il post sta passando da 'publish' a un altro stato
	if ( $old_status === 'publish' && $new_status !== 'publish' ) {
		// Controllo se l'aggiornamento automatico è abilitato
		$options = get_option( 'json_generator_settings' );
		if ( ! isset( $options['auto_update'] ) || ! $options['auto_update'] ) {
			return;
		}

		// Verifica se il tipo di post è tra quelli configurati
		$post_types = isset( $options['post_types'] ) ? $options['post_types'] : array( 'post' );
		if ( ! in_array( $post->post_type, $post_types ) ) {
			return;
		}

		// Setup percorsi file
		$upload_dir = wp_upload_dir();
		$json_dir = $upload_dir['basedir'] . '/json-data';
		$json_file = $json_dir . '/posts.json';

		// Se il file JSON non esiste, non c'è niente da fare
		if ( ! file_exists( $json_file ) ) {
			return;
		}

		// Carica il JSON esistente
		$json_data = json_decode( file_get_contents( $json_file ), true );
		if ( ! is_array( $json_data ) ) {
			return;
		}

		// Rimuovi il post dal JSON se esiste
		if ( isset( $json_data[ $post->ID ] ) ) {
			unset( $json_data[ $post->ID ] );
			// Aggiorna il file JSON
			create_compressed_json( $json_data, $json_file );
		}
	}
}, 10, 3 );