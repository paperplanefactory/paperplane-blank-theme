<?php
add_filter( 'wpcf7_autop_or_not', '__return_false' );
function paperplane_theme_wpcf7_accessibility( $output, $tag, $atts, $m ) {
	// aggiungo un paragrafo che specifica i campi obblicatori
	if ( $tag === 'contact-form-7' ) {
		$msg = '<div class="form-hold">';
		$msg .= '<p class="as-label">';
		$msg .= esc_html__( 'Tutti i campi obbligatori sono contrassegnati da un *', 'paperPlane-blankTheme' );
		$msg .= '</p>';
		$msg .= '<p class="screen-reader-text"><strong>';
		$msg .= esc_html__( 'Attenzione: al termine del form, dopo il pulsante di invio, potrebbero essere presenti dei campi generati dal sistema antispam: non devono essere compilati.', 'paperPlane-blankTheme' );
		$msg .= '</strong></p>';
		$output = $msg . $output;
		$output .= '</div>';
	}

	return $output;
}

add_filter( 'do_shortcode_tag', 'paperplane_theme_wpcf7_accessibility', 10, 4 );

// Verifica se CF7 è attivo
if ( ! function_exists( 'is_cf7_active' ) ) {
	function is_cf7_active() {
		// Prima verifica se la funzione is_plugin_active esiste
		if ( ! function_exists( 'is_plugin_active' ) ) {
			include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
		}

		return is_plugin_active( 'contact-form-7/wp-contact-form-7.php' );
	}
}




// Esempio di utilizzo
add_action( 'init', function () {
	if ( is_cf7_active() ) {
		// Aggiungi nuova tab
		add_filter( 'wpcf7_editor_panels', function ( $panels ) {
			$panels['instructions-wrapper'] = [
				'title' => 'Best practice impostazioni',
				'callback' => 'paperplane_cf7_bp'
			];
			return $panels;
		} );
		function paperplane_cf7_bp( $post ) {
			?>
			<h2>Formattazione input:</h2>
			<div class="instructions-wrapper">
				<h3>Usare correttamente le label</h3>
				<p>
					Assegnare name e ID uguali e univoci per ogni campo:
				</p>
				<code>&lt;label for="your-name"&gt; Nome* &lt;/label&gt;<br/>[text your-name id:your-name autocomplete:name]</code>
				<p>
					Name serve per salvare il dato all'invio, ID per associare la label. Il valore "for" della label deve
					corrispondere all'ID del campo.
				</p>
				<h3>Checkbox e radio button (gruppi o singole)</h3>
				<p>
					Checkbox e radio button non devono essere associati come gruppo ad una label ma ogni elemento deve avere una
					label usando l'opzione "use_label_element":
				</p>
				<code>&lt;p&gt;Testo con istruzioni simile a label&lt;/p&gt;<br/>[checkbox your-choice use_label_element "Mattina" "Pomeriggio" "Sera"]</code>
				<p>
					Se è necessario che siano preceduti da un testo con istruzioni usare un paragrafo.
				</p>


				<h3>Numeri di telefono</h3>
				<p>
					Per i numeri di telefono è possibile associare un campo select con i prefissi internazionali usando questo
					codice:
				</p>
				<code>&lt;div class="phone-wrapper"&gt;<br/>&lt;label for="phone-prefix" class="screen-reader-text"&gt;Prefisso internazionale&lt;/label&gt;<br/>[select phone-prefix class:phone-prefix-populate id:phone-prefix autocomplete:tel-country-code]<br/>&lt;label for="phone-number" class="get-prefix-space"&gt;Numero di telefono*&lt;/label&gt;<br/>[tel* phone-number class:phone-number-style id:phone-number autocomplete:tel]<br/>&lt;/div&gt;</code>
				<p>
					Aggiungere sempre alla label del campo per il numero di telefono la classe <code>get-prefix-space</code>: viene
					utilizzata in JS per posizionare correttamente la select con i prefissi.
				</p>
				<p>
					Il campo select viene popolato automaticamente con un elenco di tutti i prefissi internazionali.<br />
					In caso si più campi telefono nello stesso form adattare le corrispondenze label - field ID e mentenere nel nome
					del campo prefisso la stringa "-prefix" - ad esempio:<br />
					<code>[select phone-prefix-2 class:phone-prefix-populate id:phone-prefix-2]</code>
				</p>


				<h3>Accettazione privacy e altri controlli</h3>
				<p>
					Per il controllo dell'accettazione della privacy ma anche per l'iscrizione alla newsletter <strong>non usare il
						campo "accettazione - acceptance"</strong> perchè disabilita il bottone di invio e rende il form non
					accessibile.<br />
					Usare invece un checkbox (obbligatorio a seconda dei casi) preceduto da un paragrafo che con le istruzioni del
					campo e un link alla privacy policy. Ad esempio:

				</p>
				<code>&lt;p&gt;Leggi le &lt;a href="url-privacy"&gt;condizioni e l'informativa sulla privacy&lt;/a&gt; prima di accettare.&lt;/p&gt;<br/>[checkbox* checkbox-privacy use_label_element "Inviando i tuoi dati attraverso questa pagina confermi di aver letto e preso atto di quanto disposto nell'informativa sulla privacy prevista ai sensi dell'art. 13 del regolamento UE 2016/679 (GDPR). *"]</code>
				<h3>Autocomplete</h3>
				<p>
					Quando possibile ogni campo dovrebbe essere corredato dall'attributo <code>autocomplete</code><br />
					Ad esempio:
				</p>
				<code>&lt;label for="your-name"&gt; Nome* &lt;/label&gt;<br/>[text your-name id:your-name autocomplete:name]</code>
				<p>
					Un elenco delle possibili opzioni è <a href="https://www.w3schools.com/tags/att_input_autocomplete.asp"
						target="_blank">disponibile qui</a>.
				</p>
				<h3>Flamingo</h3>
				<p>
					Per ottenere delle informazioni utili nella pagina di riepilogo messaggi di Flamingo usare la tab "Impostazioni
					aggiuntive" che si trova qui accanto e popolarla con i seguenti dati:<br />
					flamingo_email: "[campo-email]"<br />
					flamingo_name: "[campo-nome]"<br />
					flamingo_subject: "Contatto dal sito (o un campo significativo se presente)"<br />
				</p>
			</div>
			<?php
		}
	}
} );

function paperplane_populate_phone_prefixes() {
	if ( is_cf7_active() ) {
		$country_prefixes = [
			'AC +247',  // Ascension Island
			'AD +376',  // Andorra
			'AE +971',  // United Arab Emirates
			'AF +93',   // Afghanistan
			'AG +1',    // Antigua and Barbuda
			'AI +1',    // Anguilla
			'AL +355',  // Albania
			'AM +374',  // Armenia
			'AO +244',  // Angola
			'AR +54',   // Argentina
			'AS +1',    // American Samoa
			'AT +43',   // Austria
			'AU +61',   // Australia
			'AW +297',  // Aruba
			'AX +358',  // Åland Islands
			'AZ +994',  // Azerbaijan
			'BA +387',  // Bosnia and Herzegovina
			'BB +1',    // Barbados
			'BD +880',  // Bangladesh
			'BE +32',   // Belgium
			'BF +226',  // Burkina Faso
			'BG +359',  // Bulgaria
			'BH +973',  // Bahrain
			'BI +257',  // Burundi
			'BJ +229',  // Benin
			'BL +590',  // Saint Barthélemy
			'BM +1',    // Bermuda
			'BN +673',  // Brunei
			'BO +591',  // Bolivia
			'BQ +599',  // Bonaire, Sint Eustatius and Saba
			'BR +55',   // Brazil
			'BS +1',    // Bahamas
			'BT +975',  // Bhutan
			'BW +267',  // Botswana
			'BY +375',  // Belarus
			'BZ +501',  // Belize
			'CA +1',    // Canada
			'CC +61',   // Cocos Islands
			'CD +243',  // Democratic Republic of the Congo
			'CF +236',  // Central African Republic
			'CG +242',  // Republic of the Congo
			'CH +41',   // Switzerland
			'CI +225',  // Ivory Coast
			'CK +682',  // Cook Islands
			'CL +56',   // Chile
			'CM +237',  // Cameroon
			'CN +86',   // China
			'CO +57',   // Colombia
			'CR +506',  // Costa Rica
			'CU +53',   // Cuba
			'CV +238',  // Cape Verde
			'CW +599',  // Curaçao
			'CX +61',   // Christmas Island
			'CY +357',  // Cyprus
			'CZ +420',  // Czech Republic
			'DE +49',   // Germany
			'DJ +253',  // Djibouti
			'DK +45',   // Denmark
			'DM +1',    // Dominica
			'DO +1',    // Dominican Republic
			'DZ +213',  // Algeria
			'EC +593',  // Ecuador
			'EE +372',  // Estonia
			'EG +20',   // Egypt
			'EH +212',  // Western Sahara
			'ER +291',  // Eritrea
			'ES +34',   // Spain
			'ET +251',  // Ethiopia
			'FI +358',  // Finland
			'FJ +679',  // Fiji
			'FK +500',  // Falkland Islands
			'FM +691',  // Micronesia
			'FO +298',  // Faroe Islands
			'FR +33',   // France
			'GA +241',  // Gabon
			'GB +44',   // United Kingdom
			'GD +1',    // Grenada
			'GE +995',  // Georgia
			'GF +594',  // French Guiana
			'GG +44',   // Guernsey
			'GH +233',  // Ghana
			'GI +350',  // Gibraltar
			'GL +299',  // Greenland
			'GM +220',  // Gambia
			'GN +224',  // Guinea
			'GP +590',  // Guadeloupe
			'GQ +240',  // Equatorial Guinea
			'GR +30',   // Greece
			'GT +502',  // Guatemala
			'GU +1',    // Guam
			'GW +245',  // Guinea-Bissau
			'GY +592',  // Guyana
			'HK +852',  // Hong Kong
			'HN +504',  // Honduras
			'HR +385',  // Croatia
			'HT +509',  // Haiti
			'HU +36',   // Hungary
			'ID +62',   // Indonesia
			'IE +353',  // Ireland
			'IL +972',  // Israel
			'IM +44',   // Isle of Man
			'IN +91',   // India
			'IO +246',  // British Indian Ocean Territory
			'IQ +964',  // Iraq
			'IR +98',   // Iran
			'IS +354',  // Iceland
			'IT +39',   // Italy
			'JE +44',   // Jersey
			'JM +1',    // Jamaica
			'JO +962',  // Jordan
			'JP +81',   // Japan
			'KE +254',  // Kenya
			'KG +996',  // Kyrgyzstan
			'KH +855',  // Cambodia
			'KI +686',  // Kiribati
			'KM +269',  // Comoros
			'KN +1',    // Saint Kitts and Nevis
			'KP +850',  // North Korea
			'KR +82',   // South Korea
			'KW +965',  // Kuwait
			'KY +1',    // Cayman Islands
			'KZ +7',    // Kazakhstan
			'LA +856',  // Laos
			'LB +961',  // Lebanon
			'LC +1',    // Saint Lucia
			'LI +423',  // Liechtenstein
			'LK +94',   // Sri Lanka
			'LR +231',  // Liberia
			'LS +266',  // Lesotho
			'LT +370',  // Lithuania
			'LU +352',  // Luxembourg
			'LV +371',  // Latvia
			'LY +218',  // Libya
			'MA +212',  // Morocco
			'MC +377',  // Monaco
			'MD +373',  // Moldova
			'ME +382',  // Montenegro
			'MF +590',  // Saint Martin
			'MG +261',  // Madagascar
			'MH +692',  // Marshall Islands
			'MK +389',  // Macedonia
			'ML +223',  // Mali
			'MM +95',   // Myanmar
			'MN +976',  // Mongolia
			'MO +853',  // Macau
			'MP +1',    // Northern Mariana Islands
			'MQ +596',  // Martinique
			'MR +222',  // Mauritania
			'MS +1',    // Montserrat
			'MT +356',  // Malta
			'MU +230',  // Mauritius
			'MV +960',  // Maldives
			'MW +265',  // Malawi
			'MX +52',   // Mexico
			'MY +60',   // Malaysia
			'MZ +258',  // Mozambique
			'NA +264',  // Namibia
			'NC +687',  // New Caledonia
			'NE +227',  // Niger
			'NF +672',  // Norfolk Island
			'NG +234',  // Nigeria
			'NI +505',  // Nicaragua
			'NL +31',   // Netherlands
			'NO +47',   // Norway
			'NP +977',  // Nepal
			'NR +674',  // Nauru
			'NU +683',  // Niue
			'NZ +64',   // New Zealand
			'OM +968',  // Oman
			'PA +507',  // Panama
			'PE +51',   // Peru
			'PF +689',  // French Polynesia
			'PG +675',  // Papua New Guinea
			'PH +63',   // Philippines
			'PK +92',   // Pakistan
			'PL +48',   // Poland
			'PM +508',  // Saint Pierre and Miquelon
			'PR +1',    // Puerto Rico
			'PS +970',  // Palestine
			'PT +351',  // Portugal
			'PW +680',  // Palau
			'PY +595',  // Paraguay
			'QA +974',  // Qatar
			'RE +262',  // Réunion
			'RO +40',   // Romania
			'RS +381',  // Serbia
			'RU +7',    // Russia
			'RW +250',  // Rwanda
			'SA +966',  // Saudi Arabia
			'SB +677',  // Solomon Islands
			'SC +248',  // Seychelles
			'SD +249',  // Sudan
			'SE +46',   // Sweden
			'SG +65',   // Singapore
			'SH +290',  // Saint Helena
			'SI +386',  // Slovenia
			'SJ +47',   // Svalbard and Jan Mayen
			'SK +421',  // Slovakia
			'SL +232',  // Sierra Leone
			'SM +378',  // San Marino
			'SN +221',  // Senegal
			'SO +252',  // Somalia
			'SR +597',  // Suriname
			'SS +211',  // South Sudan
			'ST +239',  // São Tomé and Príncipe
			'SV +503',  // El Salvador
			'SX +1',    // Sint Maarten
			'SY +963',  // Syria
			'SZ +268',  // Swaziland
			'TC +1',    // Turks and Caicos Islands
			'TD +235',  // Chad
			'TG +228',  // Togo
			'TH +66',   // Thailand
			'TJ +992',  // Tajikistan
			'TK +690',  // Tokelau
			'TL +670',  // East Timor
			'TM +993',  // Turkmenistan
			'TN +216',  // Tunisia
			'TO +676',  // Tonga
			'TR +90',   // Turkey
			'TT +1',    // Trinidad and Tobago
			'TV +688',  // Tuvalu
			'TW +886',  // Taiwan
			'TZ +255',  // Tanzania
			'UA +380',  // Ukraine
			'UG +256',  // Uganda
			'US +1',    // United States
			'UY +598',  // Uruguay
			'UZ +998',  // Uzbekistan
			'VA +39',   // Vatican City
			'VC +1',    // Saint Vincent and the Grenadines
			'VE +58',   // Venezuela
			'VG +1',    // British Virgin Islands
			'VI +1',    // U.S. Virgin Islands
			'VN +84',   // Vietnam
			'VU +678',  // Vanuatu
			'WF +681',  // Wallis and Futuna
			'WS +685',  // Samoa
			'XK +383',  // Kosovo
			'YE +967',  // Yemen
			'YT +262',  // Mayotte
			'ZA +27',   // South Africa
			'ZM +260',  // Zambia
			'ZW +263'   // Zimbabwe
		];

		add_filter( 'wpcf7_form_tag', function ( $tag ) use ( $country_prefixes ) {
			if ( strpos( $tag['name'], '-prefix' ) !== false ) {
				$tag['values'] = $country_prefixes;
				$tag['raw_values'] = $country_prefixes;
			}
			return $tag;
		}, 10, 1 );
		add_action( 'wp_footer', function () use ($country_prefixes) {
			?>
			<script>
				document.addEventListener('DOMContentLoaded', function () {
					const selects = document.querySelectorAll('.phone-prefix-populate');
					if (!selects.length) return;

					document.querySelectorAll('.get-prefix-space').forEach(spaceElement => {
						// Trova il select precedente
						const previousSelect = spaceElement.previousElementSibling.querySelector('.phone-prefix-populate');

						// Trova il campo tel successivo
						const nextTelField = spaceElement.nextElementSibling.querySelector('input[type="tel"]');

						if (previousSelect && nextTelField) {
							// Calcola l'altezza totale dello spazio
							const rect = spaceElement.getBoundingClientRect();
							const totalHeight = rect.height +
								parseInt(window.getComputedStyle(spaceElement).marginTop) +
								parseInt(window.getComputedStyle(spaceElement).marginBottom);

							// Applica margin top e altezza del campo tel
							previousSelect.style.marginTop = totalHeight + 'px';
							previousSelect.style.height = nextTelField.offsetHeight + 'px';
							previousSelect.classList.add('visible');
						}
					});

					const prefixes = <?php echo json_encode( $country_prefixes ); ?>;

					const htmlLang = document.documentElement.lang;
					const countryCode = htmlLang.split('-')[1] || htmlLang.split('_')[1] || htmlLang;
					let defaultPrefix = prefixes.find(prefix =>
						prefix.startsWith(countryCode.toUpperCase())
					);

					if (!defaultPrefix) {
						defaultPrefix = prefixes.find(prefix =>
							prefix.startsWith('IT')
						) || prefixes[0];
					}

					selects.forEach(select => {
						select.options.length = 0;

						const defaultOption = new Option(defaultPrefix, defaultPrefix, true, true);
						select.add(defaultOption);

						prefixes.forEach(prefix => {
							if (prefix !== defaultPrefix) {
								const option = new Option(prefix, prefix);
								select.add(option);
							}
						});
					});
				});

				// Blocca la validazione in tempo reale di CF7
				// Intercetta gli eventi change/blur/input nella capture phase
				// Così CF7 non rigenera gli errori durante l'interazione con i campi
				document.addEventListener('DOMContentLoaded', function () {
					var forms = document.querySelectorAll('.wpcf7-form');

					forms.forEach(function (form) {
						// Aggiungi una classe al form per indicare che la validazione live è disabilitata
						form.classList.add('wpcf7-no-live-validation');

						// Seleziona tutti i campi del form
						var inputs = form.querySelectorAll('input, select, textarea');

						inputs.forEach(function (input) {
							// Blocca gli eventi che CF7 usa per la validazione live
							// Usa capture: true per intercettare gli eventi prima dei listener di CF7

							input.addEventListener('change', function (e) {
								e.stopPropagation();
							}, true);

							input.addEventListener('blur', function (e) {
								e.stopPropagation();
							}, true);

							input.addEventListener('input', function (e) {
								e.stopPropagation();
							}, true);
						});
					});
				});

				// Restaura il DOM prima che CF7 validi il form
				// Estrae la wrapper errors-summary e rimette i contenuti nello stato originale
				document.addEventListener('wpcf7submit', function (event) {
					var form = event.target;
					var formId = form.id;

					// Se il form non ha ID, ne generiamo uno basato sull'indice
					if (!formId) {
						var formIndex = Array.from(document.querySelectorAll('form')).indexOf(form);
						formId = 'wpcf7-form-' + formIndex;
						form.id = formId;
					}

					var errorSummaryId = 'error-summary-' + formId;
					var wrapperSelector = '#errors-summary-wrapper-' + errorSummaryId;
					var wrapper = document.querySelector(wrapperSelector);

					if (wrapper) {
						// Estrai errorSummary e errorList dalla wrapper
						var errorSummary = wrapper.querySelector('#' + errorSummaryId);
						var errorList = wrapper.querySelector('[id^="error-list-"]');

						if (errorSummary && errorList) {
							// IMPORTANTE: Rimetti errorList DENTRO errorSummary
							// Così CF7 sa dove generare la nuova lista
							errorSummary.appendChild(errorList);

							// Svuota la lista (rimuovi tutti i <li>)
							errorList.innerHTML = '';

							// Rimuovi le classi e attributi che abbiamo aggiunto
							errorList.classList.remove('screen-reader-response', 'section-anchor', 'show-errors');
							errorList.removeAttribute('aria-label');

							// Rimetti errorSummary al posto della wrapper
							wrapper.parentElement.insertBefore(errorSummary, wrapper);

							// Rimuovi la wrapper
							wrapper.remove();
						}
					}
				}, false);

				// Gestione degli errori di validazione - REFACTORED
				document.addEventListener('wpcf7invalid', function (event) {
					var form = event.target;
					var formId = form.id;

					// Se il form non ha ID, ne generiamo uno basato sull'indice
					if (!formId) {
						var formIndex = Array.from(document.querySelectorAll('form')).indexOf(form);
						formId = 'wpcf7-form-' + formIndex;
						form.id = formId; // Assegna l'ID al form
					}

					var errorSummaryId = 'error-summary-' + formId;

					// Cerchiamo la div .screen-reader-response generata da CF7
					// Contact Form 7 la crea senza ID, quindi la cerchiamo per classe
					var errorSummary = form.parentElement.querySelector('.screen-reader-response');

					// Se la troviamo e non ha ID, assegniamogli l'ID dinamico
					if (errorSummary && !errorSummary.id) {
						errorSummary.id = errorSummaryId;
						errorSummary.classList.add('section-anchor');
						errorSummary.setAttribute('tabindex', '-1');
					}

					if (errorSummary) {
						// Modifica aria-atomic nel paragrafo di stato
						var statusParagraph = errorSummary.querySelector('p[role="status"]');
						if (statusParagraph) {
							statusParagraph.setAttribute('aria-atomic', 'false');

							// Monitora se CF7 cambia aria-atomic e ripristinalo a false
							var observer = new MutationObserver(function (mutations) {
								mutations.forEach(function (mutation) {
									if (mutation.attributeName === 'aria-atomic' &&
										mutation.target.getAttribute('aria-atomic') === 'true') {
										mutation.target.setAttribute('aria-atomic', 'false');
									}
								});
							});

							observer.observe(statusParagraph, { attributes: true, attributeFilter: ['aria-atomic'] });
						}

						// Log in tempo reale: traccia elementi con aria-live ogni 0.5 secondi
						var liveRegionLogger = setInterval(function () {
							var ariaLiveElements = document.querySelectorAll('[aria-live]');
							console.log('=== Elementi con aria-live ===');
							console.log('Totale:', ariaLiveElements.length);
							ariaLiveElements.forEach(function (el, index) {
								console.log(index + 1 + '.', {
									'aria-live': el.getAttribute('aria-live'),
									'class': el.className,
									'id': el.id,
									'role': el.getAttribute('role'),
									'tagName': el.tagName
								});
							});
						}, 500);

						setTimeout(function () {
							var errorList = errorSummary.querySelector('ul');

							if (errorList) {
								var errorItems = Array.prototype.slice.call(errorList.querySelectorAll('li'));

								// Riordina in base alla posizione nel form
								errorItems.sort(function (a, b) {
									var aMatch = a.id.match(/ve-(.+)$/);
									var bMatch = b.id.match(/ve-(.+)$/);

									if (!aMatch || !bMatch) return 0;

									var aFieldName = aMatch[1];
									var bFieldName = bMatch[1];

									var aWrapper = form.querySelector('[data-name="' + aFieldName + '"]');
									var bWrapper = form.querySelector('[data-name="' + bFieldName + '"]');

									if (!aWrapper || !bWrapper) return 0;

									var position = aWrapper.compareDocumentPosition(bWrapper);

									if (position & Node.DOCUMENT_POSITION_FOLLOWING) {
										return -1;
									} else if (position & Node.DOCUMENT_POSITION_PRECEDING) {
										return 1;
									}
									return 0;
								});

								// Migliora i messaggi di errore
								for (var i = 0; i < errorItems.length; i++) {
									var item = errorItems[i];
									var link = item.querySelector('a');

									if (link) {
										var itemId = item.id;
										var match = itemId.match(/ve-(.+)$/);

										if (match) {
											var fieldName = match[1];
											var labelText = '';

											var label = form.querySelector('label[for="' + fieldName + '"]');

											if (label) {
												var labelClone = label.cloneNode(true);
												var hiddenSpans = labelClone.querySelectorAll('span[aria-label]');
												for (var j = 0; j < hiddenSpans.length; j++) {
													hiddenSpans[j].remove();
												}
												labelText = labelClone.textContent.trim();
											} else {
												var wrapper = form.querySelector('[data-name="' + fieldName + '"]');
												if (wrapper) {
													var listItemLabel = wrapper.querySelector('.wpcf7-list-item-label');
													if (listItemLabel) {
														labelText = listItemLabel.textContent.trim();
													}
												}
											}

											if (labelText) {
												// Cerca il messaggio di errore nello span .wpcf7-not-valid-tip
												var fieldWrapper = form.querySelector('[data-name="' + fieldName + '"]');
												var errorTip = fieldWrapper ? fieldWrapper.querySelector('.wpcf7-not-valid-tip') : null;
												var errorMessage = errorTip ? errorTip.textContent.trim() : '';

												// Se c'è un messaggio di errore, aggiungilo al testo
												if (errorMessage) {
													link.textContent = labelText + ' - ' + errorMessage;
												} else {
													link.textContent = labelText;
												}
											}
										}

										// Gestore click per navigare ai campi con errori
										link.addEventListener('click', function (e) {
											e.preventDefault();
											var targetId = this.getAttribute('href').substring(1);
											var targetElement = document.getElementById(targetId);

											if (targetElement) {
												// Usa scrollIntoView nativa con scroll-margin-top gestito da CSS
												targetElement.scrollIntoView({ behavior: 'smooth', block: 'start' });
												// Focus dopo che lo scroll è completato
												setTimeout(function () {
													targetElement.focus();
												}, 300);
											}
										});
									}
								}

								// Reinserisci gli elementi ordinati
								errorList.innerHTML = '';
								for (var k = 0; k < errorItems.length; k++) {
									errorList.appendChild(errorItems[k]);
								}

								// IMPORTANTE: Sposta la <ul> FUORI dalla regione live
								// Così il paragrafo viene annunciato separatamente dalla lista
								// Assegna un ID alla lista se non ce l'ha
								if (!errorList.id) {
									errorList.id = 'error-list-' + errorSummaryId;
								}
								// Sposta la lista subito dopo error-summary
								errorSummary.parentElement.insertBefore(errorList, errorSummary.nextSibling);

								// Aggiungi classi e attributi alla lista
								errorList.classList.add('screen-reader-response', 'section-anchor', 'show-errors');
								errorList.setAttribute('aria-label', 'Sommario campi con errori');

								// WRAP: Crea una div wrapper errors-summary
								var wrapper = document.createElement('div');
								wrapper.className = 'errors-summary content-styled';
								wrapper.id = 'errors-summary-wrapper-' + errorSummaryId;

								// Sposta errorSummary e errorList dentro la wrapper
								errorSummary.parentElement.insertBefore(wrapper, errorSummary);
								wrapper.appendChild(errorSummary);
								wrapper.appendChild(errorList);

								// Rimuovi eventuali liste duplicate rimaste dentro errorSummary
								// (CF7 a volte crea liste alternative con attributi diversi)
								var duplicateLists = errorSummary.querySelectorAll('ul');
								duplicateLists.forEach(function (list) {
									list.remove();
								});
							}

							errorSummary.classList.add('show-errors');

							// Scroll verso l'error summary usando scrollIntoView nativa
							// Lo spazio sopra è gestito da CSS: #error-summary-form-id { scroll-margin-top: 120px; }
							errorSummary.scrollIntoView({ behavior: 'smooth', block: 'start' });

							// Focus dopo che lo scroll è completato
							setTimeout(function () {
								errorSummary.focus();
							}, 300);
						}, 50);
					}
				}, false);

				// Nascondi error summary quando il form viene inviato con successo
				document.addEventListener('wpcf7mailsent', function (event) {
					var form = event.target;
					var formId = form.id;

					// Se il form non ha ID, ne generiamo uno basato sull'indice
					if (!formId) {
						var formIndex = Array.from(document.querySelectorAll('form')).indexOf(form);
						formId = 'wpcf7-form-' + formIndex;
						form.id = formId;
					}

					var errorSummaryId = 'error-summary-' + formId;
					var wrapperSelector = '#errors-summary-wrapper-' + errorSummaryId;
					var wrapper = document.querySelector(wrapperSelector);

					// Se esiste la wrapper, rimuovi show-errors da lì
					if (wrapper) {
						wrapper.classList.remove('show-errors');
					} else {
						// Fallback: se non esiste la wrapper, prova con errorSummary diretto
						var errorSummary = document.getElementById(errorSummaryId);
						if (errorSummary) {
							errorSummary.classList.remove('show-errors');
						}
					}
				}, false);
			</script>
			<?php
		} );
	}
}
add_action( 'init', 'paperplane_populate_phone_prefixes' );

add_filter( 'wpcf7_form_autocomplete', function ( $autocomplete ) {
	$autocomplete = 'on';
	return $autocomplete;
}, 10, 1 );