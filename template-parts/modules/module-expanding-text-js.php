<!-- module-expanding-text -->
<section class="wrapper module-expanding-text">
	<div class="<?php echo $module['module_vertical_top_space'] . ' ' . $module['module_vertical_bottom_space']; ?>">
		<div class="wrapper-padded">
			<div class="wrapper-padded-container">
				<div class="wrapper-padded-more-700">
					<div id="<?php echo $custom_anchor_point; ?>" class="section-anchor">
						<?php if ( $module['module_expanding_text_repeater'] ) :
							foreach ( $module['module_expanding_text_repeater'] as $expanding_block ) :
								paperplane_expanding_block(
									$expanding_block['module_expanding_text_title'],
									$expanding_block['module_expanding_text_content'],
									$expanding_block['module_expanding_text_status'],
									null,
									'prova',
									true );
								?>
							<?php endforeach; endif; ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<!-- module-expanding-text -->