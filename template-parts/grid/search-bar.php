<div class="wrapper">
	<div class="module-paddings-top module-paddings-bottom">
		<div class="wrapper-padded">
			<div class="wrapper-padded-more-700">
				<div class="search-container">
					<form role="search" method="get" action="<?php echo home_url( '/' ); ?>">
						<fieldset>
							<label for="search-input">
								<?php esc_html_e( 'Cerca', 'paperPlane-blankTheme' ); ?>
							</label>
							<div class="input-elements">
								<input aria-expanded="false" aria-controls="search-suggestions" aria-autocomplete="list"
									autocomplete="off" id="search-input" name="s" placeholder="" type="search"
									role="combobox" data-autocomplete-suggestions="" data-autocomplete-trigger-input=""
									data-autocomplete-accepted="false">
								<button type="button" id="search-close-button" class="search-close"
									aria-label="Chiudi risultati ricerca">
								</button>
								<ul aria-labelledby="search-input" id="search-suggestions" role="listbox"
									class="suggestions-container">
								</ul>
								<button type="submit" id="search-submit-button"
									class="search-submit element-icon-after">
									<span class="screen-reader-text">
										<?php esc_html_e( 'Esegui ricerca approfondita', 'paperPlane-blankTheme' ); ?>
									</span>
								</button>
							</div>
							<span id="search-status-js" aria-live="polite" role="status"
								class="screen-reader-text"></span>
						</fieldset>
					</form>
				</div>
				<p>
					Prova a cercare "listing" o "Pagina".
				</p>
			</div>
		</div>
	</div>
</div>