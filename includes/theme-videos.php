<?php
function paperplane_theme_videos( $field_names ) {
	if ( is_string( $field_names ) ) {
		$field_names = array( $field_names );
	}
	if ( $field_names ) {
		global $post;
		foreach ( $field_names as $field_name ) {
			$videos_count = paperplane_random_code();
			$video_source = $field_name['video_source'];
			if ( $video_source === 'youtube' || $video_source === 'vimeo' ) {
				$video_id = $field_name['video_id'];
				//$video_cover = $field_name['video_cover']['sizes']['column'];
			}
			if ( $video_source === 'upload-video' ) {
				$video_id = 'uploaded-video';
				//$video_cover = $field_name['video_cover']['sizes']['column'];
			}
			if ( $field_name['video_caption'] ?? null ) {
				$link_title = __( 'Guarda', 'paperPlane-blankTheme' ) . ' ' . wp_strip_all_tags( $field_name['video_caption'] );
			} else {
				$link_title = __( 'Guarda', 'paperPlane-blankTheme' );
			}
			?>
			<div class="video-block">
				<div class="video-frame image-as-link">
					<button id="play-video-<?php echo $videos_count; ?>" class="play-video-js video-cover"
						data-video-toplay="video-<?php echo $videos_count; ?>" data-video-source="<?php echo $video_source; ?>"
						data-youtube-video-id="<?php echo $video_id; ?>" title="<?php echo $link_title; ?>"
						aria-label="<?php echo $link_title; ?>">
						<div aria-hidden="true">
							<?php
							$image_data = array(
								'image_type' => 'acf',
								// options: post_thumbnail, acf
								'image_value' => $field_name['video_cover']
								// se utilizzi un custom field indica qui il nome del campo
							);
							$image_appearance = array(
								// options: true, false
								'lazyload' => true,
								// options: sync, async
								'decoding' => 'async',
								// options: true, false - se false non mette contenitore intorno all'immagine
								'image-wrap' => false
							);
							$image_sizes = array(
								// qui sono definiti i ritagli o dimensioni. Devono corrispondere per numero a quanto dedinfito nella funzione nei parametri data-srcset o srcset
								'desktop_hd' => 'column_hd',
								'mobile_hd' => 'column'
							);
							print_theme_image( $image_data, $image_appearance, $image_sizes );
							?>
						</div>
					</button>
					<?php if ( $video_source === 'vimeo' ) : ?>
						<iframe id="video-<?php echo $videos_count; ?>" class="video-stop-js"
							data-video-source="<?php echo $video_source; ?>"
							data-src="https://player.vimeo.com/video/<?php echo $video_id; ?>" loading="lazy" width="640" height="360"
							allow="autoplay; fullscreen" data-autoplay autoplay playsinline mozallowfullscreen webkitallowfullscreen
							allowfullscreen title="<?php echo $link_title; ?>" aria-label="<?php echo $link_title; ?>"
							aria-hidden="true"></iframe>
					<?php elseif ( $video_source === 'youtube' ) : ?>
						<div id="video-<?php echo $videos_count; ?>" class="video-stop-js"
							data-video-source="<?php echo $video_source; ?>" data-youtube-video-id="<?php echo $video_id; ?>"
							data-video-tostop="video-<?php echo $videos_count; ?>" aria-hidden="true">
						</div>
					<?php elseif ( $video_source === 'upload-video' ) : ?>
						<video id="video-<?php echo $videos_count; ?>" class="video-stop-js"
							data-video-source="<?php echo $video_source; ?>" preload="metadata" loading="lazy" controls
							aria-hidden="true">
							<source type="video/mp4" src="<?php echo $field_name['video_file']['url']; ?>">
						</video>
					<?php endif; ?>
				</div>
				<?php if ( $field_name['video_caption'] ?? null ) : ?>
					<div class="content-styled last-child-no-margin video-caption">
						<?php echo $field_name['video_caption']; ?>
					</div>
				<?php endif; ?>
				<?php if ( $field_name['video_file']['description'] ?? null ) : ?>
					<div class="expanding-block">
						<div class="expander-top">
							<h2>
								<button id="expand-button-<?php echo $videos_count; ?>" class="expander exp-open" aria-expanded="false"
									data-expand-id="<?php echo $videos_count; ?>"
									title="<?php echo __( 'Leggi la trascrizione del video', 'paperPlane-blankTheme' ) . ': ' . __( 'questo bottone permette di accedere ad un approfondimento', 'paperPlane-blankTheme' ); ?>"
									aria-label="<?php echo __( 'Leggi la trascrizione del video', 'paperPlane-blankTheme' ) . ': ' . __( 'questo bottone permette di accedere ad un approfondimento', 'paperPlane-blankTheme' ); ?>"
									aria-controls="expand-content-<?php echo $videos_count; ?>">
									<span class="icon-js exp-plus" aria-hidden="true"></span>
									<span aria-hidden="true">
										<?php _e( 'Leggi la trascrizione del video', 'paperPlane-blankTheme' ); ?>
									</span>
								</button>
							</h2>
						</div>
						<div id="expand-content-<?php echo $videos_count; ?>"
							aria-labelledby="expand-button-<?php echo $videos_count; ?>" class="expandable-content">
							<div class="inner">
								<div class="content-styled last-child-no-margin">
									<a name="expandable-content-<?php echo $videos_count; ?>" class="section-anchor"></a>
									<p>
										<?php echo $field_name['video_file']['description']; ?>
									</p>
									<button id="expand-close-button-<?php echo $videos_count; ?>" class="expander-closer"
										data-expand-id="<?php echo $videos_count; ?>"
										title="<?php echo __( 'Chiudi', 'paperPlane-blankTheme' ); ?>" aria-expanded="true"
										aria-controls="expand-content-<?php echo $videos_count; ?>">
										<?php _e( 'Chiudi la trascrizione', 'paperPlane-blankTheme' ); ?>
									</button>
								</div>
							</div>
						</div>
					</div>
				<?php endif; ?>
			</div>
			<?php
		}
	}
}