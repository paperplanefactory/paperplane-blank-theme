<?php
global $options_fields, $options_fields_multilang;
?>
<div class="wrapper <?php echo $options_fields['theme_archive_page_color_scheme']; ?>">
	<div class="wrapper-padded">
		<div class="aligncenter">
			<?php
			if ( function_exists( 'wp_pagenavi' ) ) {
				wp_pagenavi();
			}
			?>
		</div>
	</div>
</div>