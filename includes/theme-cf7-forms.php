<?php
add_filter( 'wpcf7_autop_or_not', '__return_false' );
function paperplane_theme_wpcf7_accessibility( $output, $tag, $atts, $m ) {
	// aggiungo un paragrafo che specifica i campi obblicatori
	if ( $tag === 'contact-form-7' ) {
		$msg = '<div class="form-hold">';
		$msg .= '<p class="as-label">';
		$msg .= __( 'Tutti i campi obbligatori sono contrassegnati da un *', 'paperPlane-blankTheme' );
		$msg .= '</p>';
		$output = $msg . $output;
		// inutilizzato - aggiungo bottone per l'accessibilità per tornare al primo input con errori
		//$check = '<button class="form-top-js screen-reader-text" aria-hidden="true" hidden>' . __( 'Sposta il focus al primo campo contenente errori.', 'paperPlane-blankTheme' ) . '</button>';
		//$output .= $check;
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
		add_filter( 'wpcf7_editor_panels', function ($panels) {
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
				<code>&lt;p&gt;Leggi le &lt;a href="url-privacy"&gt;condizioni e l'informativa sulla privacy&lt;/a&gt; prima di accettare.&lt;/p&gt;<br/>[checkbox* checkbox-privacy use_label_element "Inviando i tuoi dati attraverso questa pagina confermi di aver letto e preso atto di quanto disposto nell’informativa sulla privacy prevista ai sensi dell’art. 13 del regolamento UE 2016/679 (GDPR). *"]</code>
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

		add_filter( 'wpcf7_form_tag', function ($tag) use ($country_prefixes) {
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
			</script>
			<?php
		} );
	}
}
add_action( 'init', 'paperplane_populate_phone_prefixes' );

add_filter( 'wpcf7_form_autocomplete', function ($autocomplete) {
	$autocomplete = 'on';
	return $autocomplete;
}, 10, 1 );