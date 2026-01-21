<!-- module-text -->
<?php
global $cta_align_class;
$analize_content = $module['module_text'];
if ( strpos( $analize_content, 'text-align: center;' ) ) {
	$cta_align_class = 'aligncenter';
} elseif ( strpos( $analize_content, 'text-align: right;' ) ) {
	$cta_align_class = 'alignright';
} else {
	$cta_align_class = '';
}
?>
<section class="wrapper module-text">
	<div class="<?php echo $module['module_vertical_top_space'] . ' ' . $module['module_vertical_bottom_space']; ?>">
		<div class="wrapper-padded">
			<div class="wrapper-padded-container">
				<div class="wrapper-padded-more-700">
					<div id="<?php echo $custom_anchor_point; ?>" class="section-anchor">
						<div class="content-styled last-child-no-margin">
							<?php echo $module['module_text']; ?>
						</div>
						<?php paperplane_theme_cta_advanced( $module['module_text_cta'] ); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<!-- module-text -->