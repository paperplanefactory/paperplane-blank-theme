<?php
if ( $options_fields['animations_option'] == 1 || $options_fields['opacity_option'] == 1 || $options_fields['darkmode_option'] == 1 ) :
	global $data_theme_color, $body_reduced_transparency, $body_body_reduced_motion;
	// Ottenere le preferenze utente dal cookie
	$cookie_name = 'paperplane_user_preferences';
	$user_preferences = isset( $_COOKIE[ $cookie_name ] ) ? json_decode( stripslashes( $_COOKIE[ $cookie_name ] ), true ) : null;
	// Impostare valori predefiniti se non ci sono preferenze salvate
	$dark_mode_checked = ( $user_preferences && isset( $user_preferences['dark_mode'] ) && $user_preferences['dark_mode'] == 1 ) ? 'true' : 'false';
	$reduced_motion_checked = ( $user_preferences && isset( $user_preferences['reduced_motion'] ) && $user_preferences['reduced_motion'] == 0 ) ? 'false' : 'true';
	$reduced_transparency_checked = ( $user_preferences && isset( $user_preferences['reduced_transparency'] ) && $user_preferences['reduced_transparency'] == 1 ) ? 'true' : 'false';
	?>
	<div class="user-accessibility-options">
		<?php
		if ( $options_fields['animations_option'] == 1 ) : ?>
			<button type="button" role="switch" class="paperplane-toggle active paperplane-reduce-motion-js"
				aria-label="<?php esc_html_e( 'Animazioni', 'paperPlane-blankTheme' ); ?>"
				aria-checked="<?php echo $reduced_motion_checked; ?>">
				<span class="fake-label" aria-hidden="true">
					<?php esc_html_e( 'Animazioni', 'paperPlane-blankTheme' ); ?>
				</span>
				<div class="paperplane-switch" aria-hidden="true">
					<div class="paperplane-switch-inner">
						<div class="paperplane-switch-dot">
							<div class="paperplane-switch-label">
								<?php
								// MODIFICATO: Ora il label si adatta allo stato iniziale
								if ( $reduced_motion_checked === 'true' ) {
									esc_html_e( 'On', 'paperPlane-blankTheme' );
								} else {
									esc_html_e( 'Off', 'paperPlane-blankTheme' );
								}
								?>
							</div>
						</div>
					</div>
				</div>
				<div class="clearer"></div>
			</button>
		<?php endif; ?>
		<?php
		if ( $options_fields['opacity_option'] == 1 ) : ?>
			<button type="button" role="switch" class="paperplane-toggle paperplane-reduce-transparency-js"
				aria-label="<?php esc_html_e( 'Trasparenze', 'paperPlane-blankTheme' ); ?>"
				aria-checked="<?php echo $reduced_transparency_checked; ?>">
				<span class="fake-label" aria-hidden="true">
					<?php esc_html_e( 'Riduci trasparenze', 'paperPlane-blankTheme' ); ?>
				</span>
				<div class="paperplane-switch" aria-hidden="true">
					<div class="paperplane-switch-inner">
						<div class="paperplane-switch-dot">
							<div class="paperplane-switch-label">
								<?php
								// MODIFICATO: Ora il label si adatta allo stato iniziale
								if ( $reduced_transparency_checked === 'true' ) {
									esc_html_e( 'On', 'paperPlane-blankTheme' );
								} else {
									esc_html_e( 'Off', 'paperPlane-blankTheme' );
								}
								?>
							</div>
						</div>
					</div>
				</div>
				<div class="clearer"></div>
			</button>
		<?php endif; ?>
		<?php
		if ( $options_fields['darkmode_option'] == 1 ) : ?>
			<button type="button" role="switch" class="paperplane-toggle paperplane-darkmode-js"
				aria-label="<?php esc_html_e( 'Dark mode', 'paperPlane-blankTheme' ); ?>"
				aria-checked="<?php echo $dark_mode_checked; ?>">
				<span class="fake-label" aria-hidden="true">
					<?php esc_html_e( 'Dark mode', 'paperPlane-blankTheme' ); ?>
				</span>
				<div class="paperplane-switch" aria-hidden="true">
					<div class="paperplane-switch-inner">
						<div class="paperplane-switch-dot">
							<div class="paperplane-switch-label">
								<?php
								// MODIFICATO: Ora il label si adatta allo stato iniziale
								if ( $dark_mode_checked === 'true' ) {
									esc_html_e( 'On', 'paperPlane-blankTheme' );
								} else {
									esc_html_e( 'Off', 'paperPlane-blankTheme' );
								}
								?>
							</div>
						</div>
					</div>
				</div>
				<div class="clearer"></div>
			</button>
		<?php endif; ?>
	</div>
<?php endif; ?>