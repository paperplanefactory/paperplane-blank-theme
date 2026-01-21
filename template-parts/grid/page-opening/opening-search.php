<div class="wrapper">
	<div class="wrapper-padded">
		<div class="wrapper-padded-container">
			<section class="page-opening-simple-spacer alignleft">
				<div class="last-child-no-margin">
					<h1>
						<?php esc_html_e( 'Hai cercato: ', 'paperPlane-blankTheme' ); ?>
						<?php echo get_search_query(); ?>
					</h1>
					<?php
					global $wp_query;
					$num = $wp_query->found_posts;
					if ( $num > 0 ) : ?>
						<p>
							<?php echo $num; ?>
							<?php if ( $num == 1 ) {
								esc_html_e( 'risultato', 'paperPlane-blankTheme' );
							} else {
								esc_html_e( 'risultati', 'paperPlane-blankTheme' );
							} ?>
						</p>
					<?php else : ?>
						<p>
							<?php esc_html_e( 'La ricerca non ha prodotto risultati.', 'paperPlane-blankTheme' ); ?>
						</p>
					<?php endif; ?>
				</div>
				<div class="clearer"></div>
			</section>
		</div>
	</div>
</div>