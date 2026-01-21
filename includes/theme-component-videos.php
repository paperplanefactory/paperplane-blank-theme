<?php
function paperplane_theme_videos( $field_names ) {
	if ( is_string( $field_names ) ) {
		$field_names = array( $field_names );
	}
	if ( $field_names ) {
		global $post;
		foreach ( $field_names as $field_name ) {
			$video_id = '';
			$videos_count = paperplane_random_code();
			$video_source = $field_name['video_source'];
			$video_title = wp_strip_all_tags( $field_name['video_caption'] ?? '' );

			if ( $video_source === 'youtube' || $video_source === 'vimeo' ) {
				$video_id = $field_name['video_id'];
			}
			?>
			<div class="video-block">
				<div class="video-frame">
					<?php if ( $video_source === 'vimeo' ) : ?>
						<iframe id="video-<?php echo $videos_count; ?>" class="video-element"
							src="https://player.vimeo.com/video/<?php echo esc_attr( $video_id ); ?>" width="640" height="360"
							allow="autoplay; fullscreen" loading="lazy" mozallowfullscreen webkitallowfullscreen allowfullscreen
							aria-label="<?php esc_html_e( 'Elemento video', 'paperPlane-blankTheme' ); ?>">
						</iframe>
					<?php elseif ( $video_source === 'youtube' ) : ?>
						<iframe id="video-<?php echo $videos_count; ?>" class="video-element"
							src="https://www.youtube.com/embed/<?php echo esc_attr( $video_id ); ?>?enablejsapi=1" width="640"
							height="360" allow="autoplay; fullscreen" loading="lazy"
							aria-label="<?php esc_html_e( 'Elemento video', 'paperPlane-blankTheme' ); ?>">
						</iframe>
					<?php elseif ( $video_source === 'upload-video' ) : ?>
						<video id="video-<?php echo $videos_count; ?>" class="video-element" preload="metadata" controls
							aria-label="<?php echo esc_attr( $video_title ); ?>">
							<source type="video/mp4" src="<?php echo esc_url( $field_name['video_file']['url'] ); ?>">
						</video>
					<?php endif; ?>
				</div>
				<?php if ( $field_name['video_caption'] ?? null ) : ?>
					<div class="content-styled last-child-no-margin video-caption">
						<?php echo $field_name['video_caption']; ?>
					</div>
				<?php endif; ?>
				<?php
				if ( $field_name['video_file']['description'] ?? null ) :
					paperplane_expanding_block(
						esc_html__( 'Leggi la trascrizione del video', 'paperPlane-blankTheme' ),
						'<p>' . $field_name['video_file']['description'] . '</p>',
						false,
						null,
						null,
						true
					);
					?>
				<?php endif; ?>
			</div>
			<?php
		}
	}
}