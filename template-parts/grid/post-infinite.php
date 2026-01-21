<div class="flex-hold-child grid-item-infinite" data-aos="fade-up">
	<a href="<?php the_permalink(); ?>"
		title="<?php echo esc_html__( 'Approfondisci:', 'paperPlane-blankTheme' ) . ' ' . get_the_title(); ?>"
		aria-label="<?php echo esc_html__( 'Approfondisci:', 'paperPlane-blankTheme' ) . ' ' . get_the_title(); ?>"
		class="absl card-link">
	</a>
	<div class="grid-listing-image">
		<?php
		$image_data = array(
			'image_type' => 'post_thumbnail',
			'image_value' => ''
		);
		$image_appearance = array(
			'lazyload' => true,
			'decoding' => 'async',
			'image-wrap' => true,
			'image-wrap-custom-class' => ''
		);
		$image_sizes = array(
			'desktop_hd' => 'column_cut_hd',
			'mobile_hd' => 'column_cut_hd'
		);
		print_theme_image( $image_data, $image_appearance, $image_sizes );
		?>
	</div>
	<div class="grid-listing-texts last-child-no-margin">
		<h2 class="as-h3">
			<?php the_title(); ?>
		</h2>
	</div>
</div>