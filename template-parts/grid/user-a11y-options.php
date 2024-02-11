<?php
if ( $options_fields['animations_option'] == 1 || $options_fields['opacity_option'] == 1 || $options_fields['darkmode_option'] == 1 ) :
	global $data_theme_color,
	$body_reduced_transparency,
	$body_body_reduced_motion;
	?>
	<nav class="user-accessibility-options" aria-label="<?php _e( 'Preferenze visive', 'paperPlane-blankTheme' ); ?>">
		<?php
		if ( $options_fields['animations_option'] == 1 ) : ?>
			<button role="switch" class="paperplane-toggle active paperplane-reduce-motion-js"
				aria-label="<?php _e( 'Permette di disattivare le animazioni.', 'paperPlane-blankTheme' ); ?>"
				aria-checked="true">
				<span class="fake-label" aria-hidden="true">
					<?php _e( 'Animazioni', 'paperPlane-blankTheme' ); ?>
				</span>
				<div class="paperplane-switch" aria-hidden="true">
					<div class="paperplane-switch-on">
						<?php _e( 'On', 'paperPlane-blankTheme' ); ?>
					</div>
					<div class="paperplane-switch-off">
						<?php _e( 'Off', 'paperPlane-blankTheme' ); ?>
					</div>
					<div class="paperplane-switch-inner">
						<div class="paperplane-switch-dot"></div>
					</div>
				</div>
				<div class="clearer"></div>
			</button>
		<?php endif; ?>
		<?php
		if ( $options_fields['opacity_option'] == 1 ) : ?>
			<button role="switch" class="paperplane-toggle paperplane-reduce-transparency-js"
				aria-label="<?php _e( 'Permette di ridurre le trasparenze.', 'paperPlane-blankTheme' ); ?>"
				aria-checked="false">
				<span class="fake-label" aria-hidden="true">
					<?php _e( 'Riduci trasparenze', 'paperPlane-blankTheme' ); ?>
				</span>
				<div class="paperplane-switch" aria-hidden="true">
					<div class="paperplane-switch-on">
						<?php _e( 'On', 'paperPlane-blankTheme' ); ?>
					</div>
					<div class="paperplane-switch-off">
						<?php _e( 'Off', 'paperPlane-blankTheme' ); ?>
					</div>
					<div class="paperplane-switch-inner">
						<div class="paperplane-switch-dot"></div>
					</div>
				</div>
				<div class="clearer"></div>
			</button>
		<?php endif; ?>
		<?php
		if ( $options_fields['darkmode_option'] == 1 ) : ?>
			<button role="switch" class="paperplane-toggle paperplane-darkmode-js"
				aria-label="<?php _e( 'Permette di attivare il dark mode.', 'paperPlane-blankTheme' ); ?>" aria-checked="false">
				<span class="fake-label" aria-hidden="true">
					<?php _e( 'Dark mode', 'paperPlane-blankTheme' ); ?>
				</span>
				<div class="paperplane-switch" aria-hidden="true">
					<div class="paperplane-switch-on">
						<?php _e( 'On', 'paperPlane-blankTheme' ); ?>
					</div>
					<div class="paperplane-switch-off">
						<?php _e( 'Off', 'paperPlane-blankTheme' ); ?>
					</div>
					<div class="paperplane-switch-inner">
						<div class="paperplane-switch-dot"></div>
					</div>
				</div>
				<div class="clearer"></div>
			</button>
		<?php endif; ?>
	</nav>
<?php endif; ?>