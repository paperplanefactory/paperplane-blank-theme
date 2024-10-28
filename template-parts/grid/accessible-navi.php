<nav class="accessible-navi-container"
	aria-label="<?php _e( 'Menu per saltare il menu di navigazione.', 'paperPlane-blankTheme' ); ?>">
	<!-- link per saltare la navigazione principale -->
	<a href="#page-content" id="skip-to-content" class="accessible-navi default-button" aria-controls="page-content">
		<?php _e( 'Vai al contenuto', 'paperPlane-blankTheme' ); ?>
	</a>
</nav>

<!-- pannello per opzioni accessibilità e dark mode -->
<?php if ( $options_fields['animations_option'] == 1 || $options_fields['opacity_option'] == 1 || $options_fields['darkmode_option'] == 1 ) : ?>
	<nav class="reduce-motion-overlay user-accessibility-options reduce-motion-overlay-js"
		aria-label="<?php _e( 'Preferenze visive.', 'paperPlane-blankTheme' ); ?>">
		<?php include( locate_template( 'template-parts/grid/user-a11y-options.php' ) ); ?>
	</nav>
<?php endif; ?>