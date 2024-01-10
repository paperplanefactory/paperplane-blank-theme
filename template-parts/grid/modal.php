<?php
$content_fields = paperplane_content_transients( $post->ID );
$modal_video_include = $content_fields['modal_video_include'];
?>
<section id="paperplane-modal-js-<?php echo $post->ID; ?>"
	class="paperplane-modal paperplane-modal-js paperplane-modal-js-<?php echo $post->ID; ?> hidden"
	data-modal-close-id=".paperplane-modal-js-<?php echo $post->ID; ?>" aria-hidden="true">
	<div class="modal-close-area modal-close-js" data-modal-close-id=".paperplane-modal-js-<?php echo $post->ID; ?>">
	</div>
	<div class="modal-box offerta-overlay-box-js"
		style="max-width: <?php echo $content_fields['modal_max_width']; ?>px">
		<a name="modal-focus-<?php echo $post->ID; ?>"></a>
		<?php if ( $content_fields['modal_title'] ) : ?>
			<div class="modal-title">
				<h3>
					<?php echo $content_fields['modal_title']; ?>
				</h3>
			</div>
		<?php endif; ?>
		<a href="#" class="modal-focus-<?php echo $post->ID; ?> section-anchor screen-reader-text">
			<?php _e( 'Continua la navigazione in questa finestra di dialogo', 'paperPlane-blankTheme' ); ?>
		</a>
		<a href="#" class="modal-close-button modal-close-js screen-reader-text"
			data-modal-close-id=".paperplane-modal-js-<?php echo $post->ID; ?>"
			title="<?php _e( 'Chiudi questo pannello', 'paperPlane-blankTheme' ); ?>"
			aria-label="<?php _e( 'Chiudi questo pannello', 'paperPlane-blankTheme' ); ?>">
			<?php _e( 'Chiudi questo pannello', 'paperPlane-blankTheme' ); ?>
		</a>
		<div class="insider">
			<div class="inner-message inner-message-js">
				<div class="last-child-no-margin">
					<?php
					if ( $modal_video_include == 1 ) {
						paperplane_theme_videos( $content_fields['modal_video'] );
					}
					?>
					<div class="content-styled last-child-no-margin">
						<?php echo $content_fields['modal_content']; ?>
					</div>
					<a href="#" class="modal-close-js screen-reader-text"
						data-modal-close-id=".paperplane-modal-js-<?php echo $post->ID; ?>"
						title="<?php _e( 'Chiudi questo pannello', 'paperPlane-blankTheme' ); ?>"
						aria-label="<?php _e( 'Chiudi questo pannello', 'paperPlane-blankTheme' ); ?>">
						<?php _e( 'Chiudi questo pannello', 'paperPlane-blankTheme' ); ?>
					</a>
				</div>
			</div>
		</div>
	</div>
</section>