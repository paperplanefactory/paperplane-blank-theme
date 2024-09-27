<!-- module-expanding-text -->
<section class="wrapper module-expanding-text bg-4">
	<a name="section-<?php echo $module_count; ?>" class="section-anchor"></a>
	<div class="<?php echo $module['module_vertical_top_space'] . ' ' . $module['module_vertical_bottom_space']; ?>">
		<div class="wrapper-padded">
			<div class="wrapper-padded-container">
				<div class="wrapper-padded-more-700">
					<?php if ( $module['module_expanding_text_repeater'] ) :
						$expand_count = 0;
						foreach ( $module['module_expanding_text_repeater'] as $expanding_block ) :
							$expand_count++;
							?>
							<div class="expanding-block">
								<div class="expander-top">
									<h2>
										<button id="expand-button-<?php echo $module_count . '-' . $expand_count; ?>"
											class="expander exp-open" aria-expanded="false"
											data-expand-id="<?php echo $module_count . '-' . $expand_count; ?>"
											aria-controls="expand-content-<?php echo $module_count . '-' . $expand_count; ?>">
											<span class="icon-js" aria-hidden="true"></span>
											<span>
												<?php echo $expanding_block['module_expanding_text_title']; ?>
											</span>
										</button>
									</h2>
								</div>
								<div id="expand-content-<?php echo $module_count . '-' . $expand_count; ?>"
									aria-labelledby="expand-button-<?php echo $module_count . '-' . $expand_count; ?>"
									class="expandable-content">
									<div class="inner">
										<div class="content-styled last-child-no-margin">
											<a name="expandable-content-<?php echo $module_count; ?>"
												class="section-anchor"></a>
											<?php echo $expanding_block['module_expanding_text_content']; ?>
											<button id="expand-close-button-<?php echo $module_count . '-' . $expand_count; ?>"
												class="expander-closer"
												data-expand-id="<?php echo $module_count . '-' . $expand_count; ?>"
												aria-expanded="true"
												aria-controls="expand-content-<?php echo $module_count . '-' . $expand_count; ?>">
												<?php _e( 'Chiudi', 'paperPlane-blankTheme' ); ?>
											</button>
										</div>
									</div>
								</div>
							</div>
						<?php endforeach; endif; ?>
				</div>
			</div>
		</div>
	</div>
</section>
<!-- module-expanding-text -->