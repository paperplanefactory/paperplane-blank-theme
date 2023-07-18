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
				<div class="video-frame">
					<a href="#" id="play-video-<?php echo $videos_count; ?>" class="play-video-js video-cover"
						data-video-toplay="video-<?php echo $videos_count; ?>" data-video-source="<?php echo $video_source; ?>"
						data-youtube-video-id="<?php echo $video_id; ?>" title="<?php echo $link_title; ?>"
						aria-label="<?php echo $link_title; ?>">
						<?php
						$image_data = array(
							'image_type' => 'acf',
							// options: post_thumbnail, acf
							'image_value' => $field_name['video_cover'],
							// se utilizzi un custom field indica qui il nome del campo
							'size_fallback' => 'column'
						);
						$image_sizes = array(
							// qui sono definiti i ritagli o dimensioni. Devono corrispondere per numero a quanto dedinfito nella funzione nei parametri data-srcset o srcset
							'desktop_default' => 'column',
							'desktop_hd' => 'column_hd',
							'mobile_default' => 'column',
							'mobile_hd' => 'column',
							'lazy_placheholder' => 'micro'
						);
						print_theme_image( $image_data, $image_sizes );
						?>
					</a>
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
							<source type="video/mp4" src="<?php echo $field_name['video_file']; ?>">
						</video>
					<?php endif; ?>
				</div>
				<?php if ( $field_name['video_caption'] ?? null ) : ?>
					<div class="content-styled last-child-no-margin video-caption">
						<?php echo $field_name['video_caption']; ?>
					</div>
				<?php endif; ?>
			</div>
			<?php
		}
	}
}