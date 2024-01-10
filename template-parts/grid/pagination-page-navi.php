<?php
global $options_fields, $options_fields_multilang;
?>
<div class="wrapper">
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