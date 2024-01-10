<div class="flex-hold-child grid-item-infinite" data-aos="fade-up">
	<a href="<?php the_permalink(); ?>"
		title="<?php echo __( 'Approfondisci:', 'paperPlane-blankTheme' ) . ' ' . get_the_title(); ?>"
		aria-label="<?php echo __( 'Approfondisci:', 'paperPlane-blankTheme' ) . ' ' . get_the_title(); ?>"
		class="absl card-link">
	</a>
	<div class="grid-listing-image">
		<?php
		$image_data = array(
			'image_type' => 'post_thumbnail',
			// options: post_thumbnail, acf
			'image_value' => ''
			// se utilizzi un custom field indica qui il nome del campo
		);
		$image_appearance = array(
			// options: true, false
			'lazyload' => true,
			// options: sync, async
			'decoding' => 'async',
			// options: true, false - se false non mette contenitore intorno all'immagine
			'image-wrap' => true
		);
		$image_sizes = array(
			// qui sono definiti i ritagli o dimensioni. Devono corrispondere per numero a quanto dedinfito nella funzione nei parametri data-srcset o srcset
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