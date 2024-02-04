<?php
$content_fields = paperplane_content_transients( $post->ID );
$modal_video_include = $content_fields['modal_video_include'];
?>
<section id="paperplane-modal-js-<?php echo $post->ID; ?>" class="paperplane-modal paperplane-modal-js hidden"
	aria-hidden="true" data-modal-id="<?php echo $post->ID; ?>">
	<div class="modal-close-area modal-close-js" data-modal-id="<?php echo $post->ID; ?>">
	</div>
	<div class="modal-box offerta-overlay-box-js"
		style="max-width: <?php echo $content_fields['modal_max_width']; ?>px">
		<?php if ( $content_fields['modal_title'] ) : ?>
			<div class="modal-title">
				<h2 class="as-h3">
					<?php echo $content_fields['modal_title']; ?>
				</h2>
			</div>
		<?php endif; ?>
		<button class="modal-close-button modal-close-js modal-close-js-<?php echo $post->ID; ?>  masked-element"
			data-modal-id="<?php echo $post->ID; ?>"
			aria-label="<?php _e( 'Chiudi questo pannello', 'paperPlane-blankTheme' ); ?>">
		</button>
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
				</div>
			</div>
		</div>
	</div>
</section>