<div class="wrapper <?php echo $options_fields['theme_archive_page_color_scheme']; ?>">
	<div class="wrapper-padded">
		<div class="wrapper-padded-container">
			<div class="page-opening-simple-spacer alignleft">
				<div class="last-child-no-margin">
					<h1>
						<?php _e( 'Hai cercato: ', 'paperPlane-blankTheme' ); ?>
						<?php echo get_search_query(); ?>
					</h1>
					<?php
					global $wp_query;
					$num = $wp_query->found_posts;
					if ( $num > 0 ) : ?>
						<p>
							<?php echo $num; ?>
							<?php if ( $num == 1 ) {
								_e( 'risultato', 'paperPlane-blankTheme' );
							} else {
								_e( 'risultati', 'paperPlane-blankTheme' );
							} ?>
						</p>
					<?php else : ?>
						<p>
							<?php _e( 'La ricerca non ha prodotto risultati.', 'paperPlane-blankTheme' ); ?>
						</p>
					<?php endif; ?>
				</div>
				<div class="clearer"></div>
			</div>
		</div>
	</div>
</div>