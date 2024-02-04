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

		<?php echo '.horizontal-scrolling-items-' . $module_count; ?>
			{
			<?php echo 'animation: infiniteScroll ' . $scrolling_speed . 's infinite linear;'; ?>

		}
	}

	@media screen and (min-width: 1px) and (max-width: 1023px) {

		<?php echo '.horizontal-scrolling-items-' . $module_count; ?>
			{
			<?php echo 'animation: infiniteScroll ' . $scrolling_speed_mobile . 's infinite linear;'; ?>

		}
	}
</style>
<section class="wrapper module-scroll-text bg-4">
	<a name="section-<?php echo $module_count; ?>" class="section-anchor"></a>
	<div class="<?php echo $module['module_vertical_top_space'] . ' ' . $module['module_vertical_bottom_space']; ?>">
		<div class="scrolling-txt-container" aria-hidden="true">
			<div class="horizontal-scrolling-items horizontal-scrolling-items-<?php echo $module_count; ?> fluid-typo">
				<div class="horizontal-scrolling-items-item">
					<?php for ( $k = 0; $k < $text_loop; $k++ ) : ?>
						<span class="txt-item as-h1">
							<?php echo $module['module_scroll_text_content']; ?>
						</span>
					<?php endfor; ?>
				</div>
				<div class="horizontal-scrolling-items-item">
					<?php for ( $k = 0; $k < $text_loop; $k++ ) : ?>
						<span class="txt-item as-h1">
							<?php echo $module['module_scroll_text_content']; ?>
						</span>
					<?php endfor; ?>
				</div>
			</div>
		</div>
		<div class="scrolling-txt-container-accessible">
			<?php echo $module['module_scroll_text_content']; ?>
		</div>
	</div>
</section>
<!-- module-scroll-text -->