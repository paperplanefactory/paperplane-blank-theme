<?php
// 1. Controlla se avviso è attivo in ACF
$show_notice = $options_fields_multilang['header_mostra_avviso'] ?? false;

// 2. Se attivo, verifica che non sia stato chiuso dall'utente
if ( $show_notice ) {
	// Genera hash univoco dell'avviso basato sul contenuto
	$notice_hash = md5(
		( $options_fields_multilang['header_avviso_testo'] ?? '' ) .
		( $options_fields_multilang['header_avviso_summary'] ?? 'Avviso importante' ) .
		( $options_fields_multilang['header_avviso_link'] ?? '' ) .
		( $options_fields_multilang['header_avviso_testo_link'] ?? '' )
	);

	$cookie_name = 'header_notice_dismissed_' . $notice_hash;

	// Se cookie esiste, non mostrare
	if ( isset( $_COOKIE[ $cookie_name ] ) ) {
		$show_notice = false;
	}
}

// 3. Renderizza solo se deve essere mostrato
if ( $show_notice ) :
	$view_mode = $options_fields_multilang['header_avviso_view'] ?? 'static-text';
	?>
	<aside id="pre-header" class="navigation-height-counter">
		<div class="wrapper-padded">
			<?php
			mostraDettagliTestoAvanzata(
				$options_fields_multilang['header_avviso_testo'],
				$options_fields_multilang['header_avviso_summary'] ?? 'Avviso importante',
				$options_fields_multilang['header_avviso_link'] ?? '',
				$options_fields_multilang['header_avviso_testo_link'] ?? '',
				$notice_hash,
				$view_mode
			);
			?>
		</div>
	</aside>
<?php endif; ?>