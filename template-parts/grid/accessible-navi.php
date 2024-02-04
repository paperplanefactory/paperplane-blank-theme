<nav class="accessible-navi-container">
	<a href="#page-skip-to-content" class="accessible-navi default-button"
		aria-label="<?php _e( 'Vai al contenuto', 'paperPlane-blankTheme' ); ?>">
		<?php _e( 'Vai al contenuto', 'paperPlane-blankTheme' ); ?>
	</a>
</nav>


<?php if ( $options_fields['animations_option'] == 1 ) : ?>
	<nav class="reduce-motion-overlay reduce-motion-overlay-js"
		aria-label="<?php _e( 'Preferenze accessibilità', 'paperPlane-blankTheme' ); ?>">
		<?php include( locate_template( 'template-parts/grid/user-a11y-options.php' ) ); ?>
	</nav>
<?php endif; ?>