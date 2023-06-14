<!-- module-expanding-text -->
<div class="wrapper module-expanding-text <?php echo $module['module_bg']; ?>">
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
									<button id="expand-button-<?php echo $module_count . '-' . $expand_count; ?>"
										class="expander exp-open" aria-expanded="false"
										data-expand-id="<?php echo $module_count . '-' . $expand_count; ?>"><span
											class="exp-plus"></span>
										<?php echo $expanding_block['module_expanding_text_title']; ?>
									</button>
								</div>
								<div id="expand-content-<?php echo $module_count . '-' . $expand_count; ?>"
									class="expandable-content">
									<div class="inner">
										<div class="content-styled last-child-no-margin">
											<a name="expandable-content-<?php echo $module_count; ?>"
												class="section-anchor"></a>
											<?php echo $expanding_block['module_expanding_text_content']; ?>
											<h6>
												<a href="#"
													id="expand-close-button-<?php echo $module_count . '-' . $expand_count; ?>"
													class="expander-closer"
													data-expand-id="<?php echo $module_count . '-' . $expand_count; ?>"
													title="<?php echo __( 'Chiudi', 'paperPlane-blankTheme' ) . ' ' . $expanding_block['module_expanding_text_title']; ?>"
													aria-label="<?php echo __( 'Chiudi', 'paperPlane-blankTheme' ) . ' ' . $expanding_block['module_expanding_text_title']; ?>">
													<?php _e( 'Chiudi', 'paperPlane-blankTheme' ); ?>
												</a>
											</h6>
										</div>
									</div>
								</div>
							</div>
						<?php endforeach; endif; ?>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- module-expanding-text -->