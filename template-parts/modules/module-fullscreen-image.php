<!-- module-fullscreen-image -->
<?php
if ( $module['module_fullscreen_image_image_desktop'] ?? null ) {
	$module_fullscreen_image_image_desktop_URL = $module['module_fullscreen_image_image_desktop']['sizes']['full_desk_hd'];
	$filetype_desktop = wp_check_filetype( $module_fullscreen_image_image_desktop_URL );
}
if ( $module['module_fullscreen_image_image_mobile'] ?? null ) {
	$module_fullscreen_image_image_mobile_URL = $module['module_fullscreen_image_image_mobile']['sizes']['full_desk'];
	$filetype_mobile = wp_check_filetype( $module_fullscreen_image_image_mobile_URL );
}
if ( $module['module_fullscreen_image_image_video'] ?? null ) {
	$module_fullscreen_image_image_video = $module['module_fullscreen_image_image_video'];
} else {
	$module_fullscreen_image_image_video = 0;
}
?>
<div
	class="wrapper module-fullscreen-image bg-4 <?php echo $module['module_vertical_top_space'] . ' ' . $module['module_vertical_bottom_space']; ?>">
	<a name="section-<?php echo $module_count; ?>" class="section-anchor"></a>
	<div class="module-box-fullscreen coverize <?php echo $module['module_fullscreen_text_align_horizontal']; ?>"
		data-aos="fade">
		<?php if ( $module_fullscreen_image_image_video == 1 ) : ?>
			<button class="video-stop video-stop-js pause"
				data-video-stop="module-fullscreen-video-<?php echo $module_count; ?>"
				title="<?php _e( 'Ferma il video', 'paperPlane-blankTheme' ); ?>"
				aria-label="<?php _e( 'Ferma il video', 'paperPlane-blankTheme' ); ?>"></button>
			<video id="module-fullscreen-video-<?php echo $module_count; ?>" aria-hidden="true" class="stoppable-js"
				data-autoplay autoplay loop muted playsinline>
				<source type="video/mp4" src="<?php echo $module['module_fullscreen_image_image_video_file']; ?>">
			</video>
		<?php else : ?>
			<?php if ( isset( $module_fullscreen_image_image_desktop_URL ) ) : ?>
				<div class="desktop-only">
					<img src="<?php echo $module_fullscreen_image_image_desktop_URL; ?>" title="<?php the_title(); ?>"
						alt="<?php the_title(); ?>" loading="lazy" type="image/<?php echo $filetype_desktop['ext']; ?>"
						decoding="async" />
				</div>
			<?php endif; ?>
			<?php if ( isset( $module_fullscreen_image_image_mobile_URL ) ) : ?>
				<div class="mobile-only">
					<img src="<?php echo $module_fullscreen_image_image_mobile_URL; ?>" title="<?php the_title(); ?>"
						alt="<?php the_title(); ?>" loading="lazy" type="image/<?php echo $filetype_mobile['ext']; ?>"
						decoding="async" />
				</div>
			<?php endif; ?>
		<?php endif; ?>
		<div class="above-image-opacity"></div>
		<div class="wrapper-padded">
			<div class="module-fullscreen-texts fluid-typo" data-aos="fade-right">
				<?php if ( $module['module_fullscreen_image_main_text'] ) : ?>
					<h1>
						<?php echo $module['module_fullscreen_image_main_text']; ?>
					</h1>
				<?php endif; ?>
				<?php if ( $module['module_fullscreen_image_secondary_text'] ) : ?>
					<h2>
						<?php echo $module['module_fullscreen_image_secondary_text']; ?>
					</h2>
				<?php endif; ?>
				<div class="clearer"></div>
				<?php paperplane_theme_cta_advanced( $module['paperplane_theme_cta'] ); ?>
			</div>
		</div>
	</div>
</div>
<!-- module-fullscreen-image -->