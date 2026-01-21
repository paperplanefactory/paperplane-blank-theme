<?php
/**
 * Renderizza un blocco espandibile
 * 
 * @param string $title Testo del bottone espansore
 * @param string $content Contenuto HTML da mostrare quando espanso
 * @param bool $is_open Stato iniziale (true = aperto, false = chiuso) - default: false
 * @param string|null $custom_id ID personalizzato (opzionale, altrimenti auto-generato)
 */
function paperplane_expanding_block( $title, $content, $is_open = false, $custom_id = null, $custom_css_class = null, $show_close_button = false, ) {
	static $counter = 0;

	// Genera ID univoco
	if ( $custom_id === null ) {
		$counter++;
		$unique_id = $counter;
	} else {
		$unique_id = $custom_id;
	}

	// Determina le classi e attributi in base allo stato iniziale
	if ( $is_open ) {
		$button_class = 'expander exp-close';
		$aria_expanded = 'true';
		$content_class = 'expandable-content visible';
		$close_tabindex = '';
		$close_aria_hidden = '';
	} else {
		$button_class = 'expander exp-open';
		$aria_expanded = 'false';
		$content_class = 'expandable-content';
		$close_tabindex = ' tabindex="-1"';
		$close_aria_hidden = ' aria-hidden="true"';
	}

	?>
	<div class="expanding-block <?php echo $custom_css_class; ?>">
		<button type="button" id="expand-button-<?php echo esc_attr( $unique_id ); ?>"
			class="<?php echo esc_attr( $button_class ); ?>" aria-expanded="<?php echo esc_attr( $aria_expanded ); ?>"
			data-expand-id="<?php echo esc_attr( $unique_id ); ?>"
			aria-controls="expand-content-<?php echo esc_attr( $unique_id ); ?>">
			<span><?php echo $title; ?></span>
		</button>

		<div role="region" id="expand-content-<?php echo esc_attr( $unique_id ); ?>"
			aria-labelledby="expand-button-<?php echo esc_attr( $unique_id ); ?>"
			class="<?php echo esc_attr( $content_class ); ?>">
			<div class="inner">
				<div class="content-styled last-child-no-margin">
					<a name="expandable-content-<?php echo esc_attr( $unique_id ); ?>" class="section-anchor"></a>
					<?php echo $content; ?>
					<?php if ( $show_close_button ) : ?>
						<div class="close-area">
							<button type="button" id="expand-close-button-<?php echo esc_attr( $unique_id ); ?>"
								class="expander-closer" data-expand-id="<?php echo esc_attr( $unique_id ); ?>"
								aria-expanded="<?php echo esc_attr( $aria_expanded ); ?>"
								aria-controls="expand-content-<?php echo esc_attr( $unique_id ); ?>" <?php echo $close_tabindex; ?><?php echo $close_aria_hidden; ?>>
								<?php esc_html_e( 'Chiudi', 'paperPlane-blankTheme' ); ?>
							</button>
						</div>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
	<?php
}
