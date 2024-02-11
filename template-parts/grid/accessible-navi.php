<nav class="accessible-navi-container">
	<!-- link per saltare la navigazione principale -->
	<a href="#page-skip-to-content" class="accessible-navi default-button"
		aria-label="<?php _e( 'Vai al contenuto', 'paperPlane-blankTheme' ); ?>">
		<?php _e( 'Vai al contenuto', 'paperPlane-blankTheme' ); ?>
	</a>
</nav>

<!-- pannello per opzioni accessibilità e dark mode -->
<?php if ( $options_fields['animations_option'] == 1 || $options_fields['opacity_option'] == 1 || $options_fields['darkmode_option'] == 1 ) : ?>
	<div class="reduce-motion-overlay user-accessibility-options reduce-motion-overlay-js">
		<?php include( locate_template( 'template-parts/grid/user-a11y-options.php' ) ); ?>
	</div>
<?php endif; ?>