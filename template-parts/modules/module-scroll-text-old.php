<!-- module-scroll-text -->
<?php
$scrolling_chars_count = strlen( $module['module_scroll_text_content'] );
if ( $scrolling_chars_count > 15 ) {
	$scrolling_speed = $scrolling_chars_count / 2.5;
	$scrolling_speed_mobile = $scrolling_chars_count / 3;
} else {
	$scrolling_speed = 10;
	$scrolling_speed_mobile = 10;
}

//$text_loop = $scrolling_chars_count / 4;
$text_loop = 6;
?>
<style>
	@media screen and (min-width: 1024px) {

		<?php echo '.horizontal-scrolling-items-' . $module_count . '.animate'; ?>
			{
			<?php echo 'animation: infiniteScroll ' . $scrolling_speed . 's infinite linear;'; ?>

		}
	}

	@media screen and (min-width: 1px) and (max-width: 1023px) {

		<?php echo '.horizontal-scrolling-items-' . $module_count . '.animate'; ?>
			{
			<?php echo 'animation: infiniteScroll ' . $scrolling_speed_mobile . 's infinite linear;'; ?>

		}
	}
</style>
<section class="wrapper module-scroll-text">
	<a name="<?php echo $custom_anchor_point; ?>" class="section-anchor"></a>
	<div class="<?php echo $module['module_vertical_top_space'] . ' ' . $module['module_vertical_bottom_space']; ?>">
		<div class="scrolling-txt-wrapper">
			<div class="scrolling-txt-container">
				<div id="module-scroll-text-<?php echo $module_count; ?>"
					class="horizontal-scrolling-items horizontal-scrolling-items-<?php echo $module_count; ?> animate">
					<div class="horizontal-scrolling-items-item">
						<?php for ( $k = 0; $k < $text_loop; $k++ ) : ?>
							<span class="txt-item as-h1" aria-hidden="true">
								<?php echo $module['module_scroll_text_content']; ?>
							</span>
						<?php endfor; ?>
					</div>
					<div class="horizontal-scrolling-items-item">
						<?php for ( $k = 0; $k < $text_loop; $k++ ) : ?>
							<span class="txt-item as-h1" aria-hidden="true">
								<?php echo $module['module_scroll_text_content']; ?>
							</span>
						<?php endfor; ?>
					</div>
				</div>
			</div>
			<button type="button" id="module-scroll-text-<?php echo $module_count; ?>-control"
				class="play-pause-animation animation-stop-js pause"
				data-video-stop="module-scroll-text-<?php echo $module_count; ?>"
				aria-label="<?php esc_html_e( 'Ferma animazione', 'paperPlane-blankTheme' ); ?>" aria-pressed="true"
				aria-controls="module-scroll-text-<?php echo $module_count; ?>"
				aria-labelledby="module-scroll-text-<?php echo $module_count; ?>"></button>
		</div>
		<div class="scrolling-txt-container-accessible">
			<?php echo $module['module_scroll_text_content']; ?>
		</div>
	</div>
</section>
<!-- module-scroll-text -->