<div class="wrapper">
	<div class="wrapper-padded">
		<div class="search-container">
			<form role="search" method="get" action="<?php echo home_url( '/' ); ?>">
				<fieldset>
					<label for="search-input">
						<?php echo __( 'Cerca', 'paperPlane-blankTheme' ); ?>
					</label>
					<input type="text" id="search-input" placeholder="Cerca..." name="s" autocomplete="off">
					<button class="search-submit element-icon-after">
						<span class="screen-reader-text">
							<?php echo __( 'Avvia la ricerca', 'paperPlane-blankTheme' ); ?>
						</span>
					</button>
					<div id="search-suggestions" class="suggestions-container"></div>
				</fieldset>
			</form>
		</div>
	</div>
</div>