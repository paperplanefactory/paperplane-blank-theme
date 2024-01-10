<nav class="accessible-navi-container"
	aria-label="<?php _e( 'Gestione preferenze di navigazione', 'paperPlane-blankTheme' ); ?>">
	<a href="#page-skip-to-content" class="accessible-navi default-button"
		aria-label="<?php _e( 'Vai al contenuto', 'paperPlane-blankTheme' ); ?>">
		<?php _e( 'Vai al contenuto', 'paperPlane-blankTheme' ); ?>
	</a>
</nav>


<?php if ( $options_fields['animations_option'] == 1 ) : ?>
	<div class="reduce-motion-overlay reduce-motion-overlay-js">
		<?php include( locate_template( 'template-parts/grid/user-a11y-options.php' ) ); ?>
	</div>
<?php endif; ?>