<!-- module-fullscreen-image -->
<section
	class="wrapper module-fullscreen-image <?php echo $module['module_vertical_top_space'] . ' ' . $module['module_vertical_bottom_space']; ?>">
	<div id="<?php echo $custom_anchor_point; ?>" class="section-anchor">
		<div class="module-box-fullscreen coverize <?php echo $module['module_fullscreen_text_align_horizontal']; ?>"
			data-aos="fade">
			<?php if ( $module['module_fullscreen_image_image_video'] == 1 ) : ?>
				<button type="button" class="play-pause-animation animation-play-pause-js pause"
					data-video-stop="module-fullscreen-video-<?php echo $module_count; ?>"
					title="<?php esc_html_e( 'Ferma il video', 'paperPlane-blankTheme' ); ?>"
					aria-label="<?php esc_html_e( 'Ferma il video', 'paperPlane-blankTheme' ); ?>"></button>
				<video id="module-fullscreen-video-<?php echo $module_count; ?>" aria-hidden="true" class="stoppable-js"
					data-autoplay autoplay loop muted playsinline>
					<source type="video/mp4" src="<?php echo $module['module_fullscreen_image_image_video_file']; ?>">
				</video>
			<?php else : ?>
				<?php if ( $module['module_fullscreen_image_image_desktop'] ?? null ) : ?>
					<div class="desktop-only">
						<?php
						$image_data = array(
							'image_type' => 'acf',
							'image_value' => $module['module_fullscreen_image_image_desktop']
						);
						$image_appearance = array(
							'lazyload' => false,
							'decoding' => 'async',
							'image-wrap' => false,
							'image-wrap-custom-class' => ''
						);
						$image_sizes = array(
							'desktop_hd' => 'full_desk_hd',
							'mobile_hd' => 'full_desk'
						);
						print_theme_image( $image_data, $image_appearance, $image_sizes );
						?>
					</div>
				<?php endif; ?>
				<?php if ( $module['module_fullscreen_image_image_mobile'] ?? null ) : ?>
					<div class="mobile-only">
						<?php
						$image_data = array(
							'image_type' => 'acf',
							'image_value' => $module['module_fullscreen_image_image_mobile']
						);
						$image_appearance = array(
							'lazyload' => false,
							'decoding' => 'async',
							'image-wrap' => false,
							'image-wrap-custom-class' => ''
						);
						$image_sizes = array(
							'desktop_hd' => 'full_desk_hd',
							'mobile_hd' => 'full_desk'
						);
						print_theme_image( $image_data, $image_appearance, $image_sizes );
						?>
					</div>
				<?php endif; ?>
			<?php endif; ?>
			<div class="above-image-opacity"></div>
			<div class="wrapper-padded">
				<div class="module-fullscreen-texts" data-aos="fade-right">
					<?php if ( $module['module_fullscreen_image_main_text'] ?? null ) : ?>
						<h1>
							<?php echo $module['module_fullscreen_image_main_text']; ?>
						</h1>
					<?php endif; ?>
					<?php if ( $module['module_fullscreen_image_secondary_text'] ?? null ) : ?>
						<h2>
							<?php echo $module['module_fullscreen_image_secondary_text']; ?>
						</h2>
					<?php endif; ?>
					<div class="clearer"></div>
					<?php paperplane_theme_cta_advanced( $module['module_fullscreen_image_cta'] ); ?>
				</div>
			</div>
		</div>
	</div>
</section>
<!-- module-fullscreen-image -->