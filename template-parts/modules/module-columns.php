<!-- module-columns -->
<section class="wrapper module-columns">
	<div class="<?php echo $module['module_vertical_top_space'] . ' ' . $module['module_vertical_bottom_space']; ?>">
		<div class="wrapper-padded">
			<div class="wrapper-padded-container">
				<div id="<?php echo $custom_anchor_point; ?>" class="section-anchor">
					<div
						class="flex-hold flex-hold-<?php echo $module['module_columns_columns_number']; ?> margins-wide">
						<?php
						if ( $module['module_columns_columns_repeater'] ?? null ) :
							foreach ( $module['module_columns_columns_repeater'] as $column ) :
								$module_columns_columns_repeater_image_format = $column['module_columns_columns_repeater_image_format'];
								?>
								<div class="flex-hold-child module-column-box">
									<div class="<?php echo $column['module_columns_columns_repeater_align']; ?>">
										<?php if ( $column['module_columns_columns_repeater_image'] ?? null ) : ?>
											<div class="column-image">
												<?php if ( $module_columns_columns_repeater_image_format === 'normal-image' ) : ?>
													<?php
													$image_data = array(
														'image_type' => 'acf',
														'image_value' => $column['module_columns_columns_repeater_image']
													);
													$image_appearance = array(
														'lazyload' => true,
														'decoding' => 'async',
														'image-wrap' => true,
														'image-wrap-custom-class' => ''
													);
													$image_sizes = array(
														'desktop_hd' => 'column_hd',
														'mobile_hd' => 'column_hd'
													);
													print_theme_image( $image_data, $image_appearance, $image_sizes );
													?>
												<?php elseif ( $module_columns_columns_repeater_image_format === 'round-image' ) : ?>
													<div class="image-rounder">
														<?php
														$image_data = array(
															'image_type' => 'acf',
															'image_value' => $column['module_columns_columns_repeater_image']
														);
														$image_appearance = array(
															'lazyload' => true,
															'decoding' => 'async',
															'image-wrap' => true,
															'image-wrap-custom-class' => ''
														);
														$image_sizes = array(
															'desktop_hd' => 'round_image_hd',
															'mobile_hd' => 'round_image'
														);
														print_theme_image( $image_data, $image_appearance, $image_sizes );
														?>
													</div>
												<?php else : ?>
													<div class="image-icon">
														<?php
														$image_data = array(
															'image_type' => 'acf',
															'image_value' => $column['module_columns_columns_repeater_image']
														);
														$image_appearance = array(
															'lazyload' => true,
															'decoding' => 'async',
															'image-wrap' => true,
															'image-wrap-custom-class' => ''
														);
														$image_sizes = array(
															'desktop_hd' => 'round_image_hd',
															'mobile_hd' => 'round_image'
														);
														print_theme_image( $image_data, $image_appearance, $image_sizes );
														?>
													</div>
												<?php endif; ?>
												</a>
											</div>
										<?php endif; ?>
										<?php
										if ( $column['module_columns_columns_repeater_counter_value'] ?? null ) :
											$counter_text = '';
											$counter_label = '';
											if ( $column['module_columns_columns_repeater_counter_value_before'] ?? null ) {
												$counter_label .= $column['module_columns_columns_repeater_counter_value_before'];
											}
											$counter_label .= $column['module_columns_columns_repeater_counter_value'];
											if ( $column['module_columns_columns_repeater_counter_value_after'] ?? null ) {
												$counter_label .= $column['module_columns_columns_repeater_counter_value_after'];
											}
											if ( $column['module_columns_columns_repeater_counter_description'] ?? null ) {
												$counter_label .= ' ' . $column['module_columns_columns_repeater_counter_description'];
											}
											?>
											<div class="counter">
												<h2 class="screen-reader-text"><?php echo $counter_label; ?></h2>
												<div class="as-h1" aria-hidden="true">
													<?php
													if ( $column['module_columns_columns_repeater_counter_value_before'] ?? null ) {
														$counter_text .= $column['module_columns_columns_repeater_counter_value_before'];
													}
													if ( $column['module_columns_columns_repeater_counter_value'] ?? null ) {
														$counter_text .= '<span class="count just-number count-pre"
													data-bar-number="' . $column['module_columns_columns_repeater_counter_value'] . '">0</span>';
													}
													if ( $column['module_columns_columns_repeater_counter_value_after'] ?? null ) {
														$counter_text .= $column['module_columns_columns_repeater_counter_value_after'];
													}
													if ( $column['module_columns_columns_repeater_counter_description'] ?? null ) {
														$counter_text .= '<span class="as-h4 counter-label"> ' . $column['module_columns_columns_repeater_counter_description'] . '</span>';
													}
													echo $counter_text;
													?>
												</div>
											</div>
										<?php endif; ?>
										<?php if ( $column['module_columns_columns_repeater_content'] ?? null ) : ?>
											<div class="content-styled last-child-no-margin">
												<?php echo $column['module_columns_columns_repeater_content']; ?>
											</div>
										<?php endif; ?>
										<?php paperplane_theme_cta_advanced( $column['paperplane_theme_cta_module_columns'] ); ?>
									</div>
								</div>
							<?php endforeach; endif; ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<!-- module-columns -->