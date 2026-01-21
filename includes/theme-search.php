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

	$default_priorities = array(
		'page' => 1,
		'post' => 2,
		'default' => 10
	);

	echo '<div style="max-height: 200px; overflow-y: auto; padding: 10px; border: 1px solid #ccc;">';
	echo '<p class="description">Seleziona i post type da includere e imposta la loro priorità nei risultati (numeri più bassi = priorità più alta)</p>';

	foreach ( $post_types as $post_type ) {
		$checked = in_array( $post_type->name, $saved_types ) ? 'checked' : '';

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
 * FUNZIONE HELPER CENTRALIZZATA
 * Ritorna i metadati del file JSON più recente
 */
function get_latest_json_metadata() {
	$upload_dir = wp_upload_dir();
	$timestamp = get_option( 'json_generator_latest_timestamp' );

	if ( ! $timestamp ) {
		return array(
			'timestamp' => '',
			'jsonUrl' => '',
			'gzipUrl' => ''
		);
	}

	return array(
		'timestamp' => $timestamp,
		'jsonUrl' => $upload_dir['baseurl'] . '/json-data/paperplane-search-index-' . $timestamp . '.json',
		'gzipUrl' => $upload_dir['baseurl'] . '/json-data/paperplane-search-index-' . $timestamp . '.json.gz'
	);
}

/**
 * Pulisce i file JSON vecchi della cartella json-data/
 */
function cleanup_old_json_files() {
	$upload_dir = wp_upload_dir();
	$json_dir = $upload_dir['basedir'] . '/json-data';

	if ( ! is_dir( $json_dir ) ) {
		return;
	}

	$files = glob( $json_dir . '/paperplane-search-index-*.json' );

	if ( ! is_array( $files ) || count( $files ) <= 1 ) {
		return;
	}

	usort( $files, function ( $a, $b ) {
		return filemtime( $b ) - filemtime( $a );
	} );

	for ( $i = 1; $i < count( $files ); $i++ ) {
		$file = $files[ $i ];
		$gz_file = $file . '.gz';

		if ( file_exists( $file ) ) {
			unlink( $file );
		}

		if ( file_exists( $gz_file ) ) {
			unlink( $gz_file );
		}
	}
}

/**
 * Crea file JSON compresso e non compresso in base al tipo di server
 */
function create_compressed_json( $json_data, $json_file ) {
	$options = get_option( 'json_generator_settings' );
	$server_type = isset( $options['server_type'] ) ? $options['server_type'] : 'apache';

	$temp_file = $json_file . '.tmp';
	$success = file_put_contents(
		$temp_file,
		json_encode( $json_data, JSON_UNESCAPED_UNICODE )
	);

	if ( $success ) {
		rename( $temp_file, $json_file );

		if ( $server_type === 'apache' ) {
			$gz_file = $json_file . '.gz';
			$gz = gzopen( $gz_file, 'w9' );
			gzwrite( $gz, file_get_contents( $json_file ) );
			gzclose( $gz );

			$htaccess = dirname( $json_file ) . '/.htaccess';
			file_put_contents( $htaccess, "
# Abilita l'accesso ai file JSON
<FilesMatch \"(paperplane-search-index-.*\\.json|paperplane-search-index-.*\\.json\\.gz)$\">
    Order Allow,Deny
    Allow from all
</FilesMatch>

# Configura la codifica gzip
<FilesMatch \"\\.gz$\">
    AddEncoding gzip .gz
    ForceType application/json
</FilesMatch>

# Blocca l'accesso a tutti gli altri file
<Files ~ \"^(?!(paperplane-search-index-.*\\.json|paperplane-search-index-.*\\.json\\.gz)$)\">
    Order Allow,Deny
    Deny from all
</Files>" );
		} elseif ( $server_type === 'nginx' ) {
			$gz_file = $json_file . '.gz';
			if ( file_exists( $gz_file ) ) {
				unlink( $gz_file );
			}

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

	$metadata = get_latest_json_metadata();

	if ( isset( $_GET['message'] ) ) {
		if ( $_GET['message'] === 'json-updated' ) {
			echo '<div class="notice notice-success"><p>File JSON aggiornato con successo.</p></div>';
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

					progress::-webkit-progress-bar {
						background-color: #f3f3f3;
					}

					progress::-webkit-progress-value {
						background-color: #000ccc;
					}
				}
			</style>
		</div>

		<!-- Sezione Genera JSON -->
		<div class="postbox">
			<h2 class="hndle"><span>Genera JSON</span></h2>
			<div class="inside">
				<?php if ( ! empty( $metadata['timestamp'] ) ) : ?>
					<p>
						<strong>File JSON corrente:</strong>
						<br>
						<code><?php echo esc_html( $metadata['jsonUrl'] ); ?></code>
						<br><br>
						<strong>Versione compressa:</strong>
						<br>
						<code><?php echo esc_html( $metadata['gzipUrl'] ); ?></code>
					</p>
				<?php else : ?>
					<p>
						<em>Nessun file JSON generato ancora.</em>
					</p>
				<?php endif; ?>

				<p>
					<button id="json-generate-btn" class="button button-primary">Genera JSON ora</button>
				</p>
			</div>
		</div>

		<form method="post" action="options.php">
			<?php
			settings_fields( 'json_generator_options' );
			do_settings_sections( 'json-generator-settings' );
			submit_button();
			?>
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
									location.reload();
								}, 1500);
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
						action: 'generate_json_batch',
						batch: currentBatch,
						nonce: '<?php echo wp_create_nonce( "generate_json_batch" ); ?>'
					},
					success: function (response) {
						if (response.success) {
							setTimeout(checkProgress, 1000);
						} else {
							console.error('Errore nella generazione del batch');
							isGenerating = false;
						}
					},
					error: function () {
						console.error('Errore nella chiamata AJAX');
						isGenerating = false;
					}
				});
			}

			$('#json-generate-btn').on('click', function (e) {
				e.preventDefault();
				const btn = $(this);
				btn.prop('disabled', true).text('Generazione in corso...');

				isGenerating = true;
				currentBatch = 0;
				$('#json-progress').show();

				continueGeneration();
			});
		});
	</script>
	<?php
}

/**
 * Estrae i dati di un singolo post per il JSON
 */
function get_post_json_data( $post_id ) {
	$post = get_post( $post_id );

	if ( ! $post || $post->post_status !== 'publish' ) {
		return null;
	}

	$searchable_content = $post->post_content;

	if ( function_exists( 'get_field' ) ) {
		$fields = get_fields( $post_id );
		if ( is_array( $fields ) ) {
			foreach ( $fields as $field_value ) {
				if ( is_string( $field_value ) ) {
					$searchable_content .= ' ' . $field_value;
				}
			}
		}
	}

	return array(
		'id' => $post->ID,
		'title' => esc_html( $post->post_title ),
		'url' => esc_url( get_permalink( $post->ID ) ),
		'post_type' => $post->post_type,
		'featured_image' => esc_url( get_the_post_thumbnail_url( $post->ID, 'thumbnail' ) ) ?: '',
		'searchable_content' => wp_strip_all_tags( $searchable_content ),
		'modified' => $post->post_modified
	);
}

/**
 * AJAX: Genera un singolo batch
 */
add_action( 'wp_ajax_generate_json_batch', function () {
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_send_json_error( 'Permesso negato' );
	}

	if ( ! wp_verify_nonce( $_POST['nonce'], 'generate_json_batch' ) ) {
		wp_send_json_error( 'Verifica di sicurezza fallita' );
	}

	$current_batch = isset( $_POST['batch'] ) ? intval( $_POST['batch'] ) : 0;
	$options = get_option( 'json_generator_settings' );
	$post_types = isset( $options['post_types'] ) ? $options['post_types'] : array( 'post' );
	$batch_size = isset( $options['batch_size'] ) ? intval( $options['batch_size'] ) : 50;

	$upload_dir = wp_upload_dir();
	$json_dir = $upload_dir['basedir'] . '/json-data';

	if ( ! file_exists( $json_dir ) ) {
		wp_mkdir_p( $json_dir );
	}

	// Primo batch: crea il file con timestamp
	if ( $current_batch === 0 ) {
		$timestamp = date( 'Y-m-d-H-i' );
		update_option( 'json_generator_generation_in_progress', $timestamp );
		$json_data = array();
		$json_file = $json_dir . '/paperplane-search-index-' . $timestamp . '.json';
	} else {
		// Batch successivi: carica il file esistente
		$timestamp = get_option( 'json_generator_generation_in_progress' );
		$json_file = $json_dir . '/paperplane-search-index-' . $timestamp . '.json';
		$json_data = file_exists( $json_file ) ? json_decode( file_get_contents( $json_file ), true ) : array();
		if ( ! is_array( $json_data ) ) {
			$json_data = array();
		}
	}

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

	// Salva il file
	$success = create_compressed_json( $json_data, $json_file );

	if ( $success ) {
		wp_send_json_success();
	} else {
		wp_send_json_error( 'Errore nella scrittura del file JSON' );
	}
} );

/**
 * AJAX: Controlla il progresso
 */
add_action( 'wp_ajax_check_json_progress', function () {
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_send_json_error( 'Permesso negato' );
	}

	if ( ! wp_verify_nonce( $_POST['nonce'], 'check_json_progress' ) ) {
		wp_send_json_error( 'Verifica di sicurezza fallita' );
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
	wp_reset_postdata();

	// Calcola quanti post sono stati processati
	$processed = ( $batch * $batch_size ) + $batch_size;
	$processed = min( $processed, $total );

	$is_completed = $processed >= $total;

	// Se è l'ultimo batch, aggiorna il timestamp
	if ( $is_completed ) {
		$timestamp = get_option( 'json_generator_generation_in_progress' );
		if ( $timestamp ) {
			update_option( 'json_generator_latest_timestamp', $timestamp );
			delete_option( 'json_generator_generation_in_progress' );
			cleanup_old_json_files();
		}
	}

	wp_send_json( array(
		'processed' => $processed,
		'total' => $total,
		'isCompleted' => $is_completed
	) );
} );

/**
 * REST API ENDPOINT
 */
add_action( 'rest_api_init', function () {
	register_rest_route( 'custom/v1', '/latest-json-url/', array(
		'methods' => 'GET',
		'callback' => function () {
			$metadata = get_latest_json_metadata();
			$options = get_option( 'json_generator_settings' );

			if ( empty( $metadata['timestamp'] ) ) {
				return new WP_Error(
					'no_index',
					'File JSON non disponibile',
					array( 'status' => 404 )
				);
			}

			return array(
				'jsonUrl' => $metadata['jsonUrl'],
				'gzipUrl' => $metadata['gzipUrl'],
				'postTypePriorities' => $options['post_type_priorities'] ?? array()
			);
		},
		'permission_callback' => '__return_true'
	) );
} );

/**
 * Aggiorna il JSON al salvataggio di un post
 */
add_action( 'save_post', function ( $post_id ) {
	$options = get_option( 'json_generator_settings' );
	if ( ! isset( $options['auto_update'] ) || ! $options['auto_update'] ) {
		return;
	}

	$post_type = get_post_type( $post_id );
	$post_types = isset( $options['post_types'] ) ? $options['post_types'] : array( 'post' );
	if ( ! in_array( $post_type, $post_types ) ) {
		return;
	}

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	$upload_dir = wp_upload_dir();
	$json_dir = $upload_dir['basedir'] . '/json-data';

	if ( ! is_dir( $json_dir ) ) {
		return;
	}

	$files = glob( $json_dir . '/paperplane-search-index-*.json' );
	if ( ! is_array( $files ) || empty( $files ) ) {
		return;
	}

	usort( $files, function ( $a, $b ) {
		return filemtime( $b ) - filemtime( $a );
	} );

	$latest_file = $files[0];
	$json_file = $latest_file;

	$json_data = json_decode( file_get_contents( $json_file ), true );
	if ( ! is_array( $json_data ) ) {
		$json_data = [];
	}

	$post_data = get_post_json_data( $post_id );
	if ( $post_data ) {
		$json_data[ $post_id ] = $post_data;
	} else {
		unset( $json_data[ $post_id ] );
	}

	create_compressed_json( $json_data, $json_file );
} );

/**
 * Carica lo script frontend
 */
add_action( 'wp_enqueue_scripts', function () {
	$options = get_option( 'json_generator_settings' );

	if ( ! isset( $options['frontend_js'] ) || $options['frontend_js'] ) {
		wp_enqueue_script( 'search-suggestions', get_template_directory_uri() . '/assets/js/search-suggestions.min.js', array(), '1.0', true );
	}
} );

/**
 * Cron: Generazione giornaliera
 */
add_action( 'admin_init', function () {
	if ( ! wp_next_scheduled( 'daily_json_generation_start' ) ) {
		wp_schedule_event( strtotime( 'tomorrow midnight' ), 'daily', 'daily_json_generation_start' );
	}
} );

add_action( 'daily_json_generation_start', function () {
	$options = get_option( 'json_generator_settings' );

	if ( ! isset( $options['daily_generation'] ) || ! $options['daily_generation'] ) {
		return;
	}

	wp_schedule_single_event( time(), 'daily_json_generation_batch', array( 0 ) );
} );

add_action( 'daily_json_generation_batch', function ( $current_batch ) {
	$options = get_option( 'json_generator_settings' );
	$post_types = isset( $options['post_types'] ) ? $options['post_types'] : array( 'post' );
	$batch_size = isset( $options['batch_size'] ) ? intval( $options['batch_size'] ) : 50;

	$upload_dir = wp_upload_dir();
	$json_dir = $upload_dir['basedir'] . '/json-data';

	if ( ! file_exists( $json_dir ) ) {
		wp_mkdir_p( $json_dir );
	}

	if ( $current_batch === 0 ) {
		$timestamp = date( 'Y-m-d-H-i' );
		update_option( 'json_generator_generation_in_progress', $timestamp );
		$json_data = array();
		$json_file = $json_dir . '/paperplane-search-index-' . $timestamp . '.json';
	} else {
		$timestamp = get_option( 'json_generator_generation_in_progress' );
		$json_file = $json_dir . '/paperplane-search-index-' . $timestamp . '.json';
		$json_data = json_decode( file_get_contents( $json_file ), true );
		if ( ! is_array( $json_data ) ) {
			$json_data = array();
		}
	}

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

	create_compressed_json( $json_data, $json_file );

	$processed = ( $current_batch * $batch_size ) + count( $posts );

	if ( $processed < $total_published ) {
		wp_schedule_single_event( time() + 30, 'daily_json_generation_batch', array( $current_batch + 1 ) );
	} else {
		update_option( 'json_generator_latest_timestamp', $timestamp );
		delete_option( 'json_generator_generation_in_progress' );
		cleanup_old_json_files();
	}
} );

add_action( 'update_option_json_generator_settings', function ( $old_value, $new_value ) {
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
 * Rimuove il post dal JSON quando viene spostato nel cestino
 */
add_action( 'wp_trash_post', function ( $post_id ) {
	$options = get_option( 'json_generator_settings' );
	if ( ! isset( $options['auto_update'] ) || ! $options['auto_update'] ) {
		return;
	}

	$post_type = get_post_type( $post_id );
	$post_types = isset( $options['post_types'] ) ? $options['post_types'] : array( 'post' );
	if ( ! in_array( $post_type, $post_types ) ) {
		return;
	}

	$upload_dir = wp_upload_dir();
	$json_dir = $upload_dir['basedir'] . '/json-data';

	$files = glob( $json_dir . '/paperplane-search-index-*.json' );
	if ( ! is_array( $files ) || empty( $files ) ) {
		return;
	}

	usort( $files, function ( $a, $b ) {
		return filemtime( $b ) - filemtime( $a );
	} );

	$json_file = $files[0];

	$json_data = json_decode( file_get_contents( $json_file ), true );
	if ( ! is_array( $json_data ) ) {
		return;
	}

	if ( isset( $json_data[ $post_id ] ) ) {
		unset( $json_data[ $post_id ] );
		create_compressed_json( $json_data, $json_file );
	}
} );

/**
 * Rimuove il post dal JSON quando passa da pubblicato a bozza
 */
add_action( 'transition_post_status', function ( $new_status, $old_status, $post ) {
	if ( $old_status === 'publish' && $new_status !== 'publish' ) {
		$options = get_option( 'json_generator_settings' );
		if ( ! isset( $options['auto_update'] ) || ! $options['auto_update'] ) {
			return;
		}

		$post_types = isset( $options['post_types'] ) ? $options['post_types'] : array( 'post' );
		if ( ! in_array( $post->post_type, $post_types ) ) {
			return;
		}

		$upload_dir = wp_upload_dir();
		$json_dir = $upload_dir['basedir'] . '/json-data';

		$files = glob( $json_dir . '/paperplane-search-index-*.json' );
		if ( ! is_array( $files ) || empty( $files ) ) {
			return;
		}

		usort( $files, function ( $a, $b ) {
			return filemtime( $b ) - filemtime( $a );
		} );

		$json_file = $files[0];

		$json_data = json_decode( file_get_contents( $json_file ), true );
		if ( ! is_array( $json_data ) ) {
			return;
		}

		if ( isset( $json_data[ $post->ID ] ) ) {
			unset( $json_data[ $post->ID ] );
			create_compressed_json( $json_data, $json_file );
		}
	}
}, 10, 3 );