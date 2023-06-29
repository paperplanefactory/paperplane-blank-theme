<a href="#page-content" class="accessible-navi default-button"
	title="<?php _e( 'Vai al contenuto', 'paperPlane-blankTheme' ); ?>"
	aria-label="<?php _e( 'Vai al contenuto', 'paperPlane-blankTheme' ); ?>">
	<?php _e( 'Vai al contenuto', 'paperPlane-blankTheme' ); ?>
</a>
<?php if ( $options_fields['animations_option'] == 1 ) : ?>
	<div class="reduce-motion-button reduce-motion-button-js hidden">
		<div class="opening-icon" aria-hidden="true"></div>
		<a href="#" class="accessible-navi-activate-js" title="<?php _e( 'Riduci animazioni', 'paperPlane-blankTheme' ); ?>"
			aria-label="<?php _e( 'Riduci animazioni', 'paperPlane-blankTheme' ); ?>"
			data-original-label="<?php _e( 'Riduci animazioni', 'paperPlane-blankTheme' ); ?>"
			data-active-label="<?php _e( 'Attiva animazioni', 'paperPlane-blankTheme' ); ?>">
			<?php _e( 'Riduci animazioni', 'paperPlane-blankTheme' ); ?>
		</a>
		<button class="close-reduce-motion close-reduce-motion-js"
			title="<?php _e( 'Nascondi opzione per ridurre animazioni', 'paperPlane-blankTheme' ); ?>"
			aria-label="<?php _e( 'Nascondi opzione per ridurre animazioni', 'paperPlane-blankTheme' ); ?>"></button>
	</div>
<?php endif; ?>