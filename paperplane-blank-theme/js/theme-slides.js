$(document).ready(function() {
	// slideshows
	// per aggiungere uno slider con parametri (parametri e NON CSS) differenti
	// copiare questa funzione
	// cambiare nome alla funzione
	// nella nuova funzione:
	// cambiare selettore '.slideshow-selector-1' -> '.slideshow-selector-2'
	// cambiare selettore '.fullscreen-activator-1' -> '.fullscreen-activator-2'
	// nel nuovo file PHP slideshow cambiare:
	// <input type="hidden" class="slideshow-selector-1" value="postslider-1" /> -> <input type="hidden" class="slideshow-selector-2" value="postslider-2" />
	// <ul class="slideshow-ul verticalize postslider-1"> -> <ul class="slideshow-ul verticalize postslider-2">
	function activateSliders_1() {
		// attivo gli slideshow solo se nella pagina è effettivamente inserito uno slideshow
		if ($(".slider-is-true")[0]){
			// dichiaro le variabili per contare quanti slideshow son presenti basandomi sulla classe
			var class_counter = 0;
			// e per contare la variabile per gestire i Public Methods https://bxslider.com/options/
			var slider_counter = 0;
			// recupero la classe in base al valore dell'hidden field "slideshow-selector"
			var get_slider_class = $( '.slideshow-selector-1' ).val();
			// per ogni slideshow presente in pagina aggiungo una classe col contatore
			$('.' + get_slider_class).each(function (i) {
				class_counter++;
				$(this).addClass(get_slider_class+class_counter);
				// per ogni slideshow presente in pagina aggiungo una classe col contatore anche al bottone fullscreen
				$(this).next( '.fullscreen-activator-1' ).addClass( 'fullscreen-activator-1'+class_counter );
				// pulsante per attivare il fullscreen
				$('.fullscreen-activator-1' + class_counter).click(function(){
					$(this).parent().toggleClass('fullscreen-mode');
					$(this).parent().parent().find(".slideshow-ul").fadeTo( 100, 0.5 ).delay(300).fadeTo( 150, 1 );
					});
			});
			// attivo ogni slideshow presente in pagina
			$('.' + get_slider_class).each(function (index, value) {
				// aggiungo ad ogni slideshow il contatore
				slider_counter++;
				// var regular_slider: definisco la variabile che mi permette di utilizzare i Public Methods
				var regular_slider = $('.'+get_slider_class+slider_counter).bxSlider({
					slideWidth: 4000,
					speed: 1000,
					minSlides: 1,
					maxSlides: 1,
					slideMargin: 0,
					touchEnabled: true,
					controls: true,
					pager: true,
					auto: false,
					mode: 'horizontal',
					infiniteLoop: true,
					preloadImages: 'all',
					nextText: '',
					prevText: '',
					keyboardEnabled: true,
					adaptiveHeight: true,
					adaptiveHeightSpeed: 300,
					onSliderResize: function(){
						// al ridimensionamento dello schermo faccio un reset per adattare le immagini
						regular_slider.redrawSlider();
					},
					onSlideBefore: function(){
						// nel momento in cui chiedo la slide successiva carico l'immagine con Lazy Load
						(function() {
							var myLazyLoad = new LazyLoad({
								elements_selector: ".lazy",
								class_loading: "lazy-loading",
								class_loaded: "lazy-loaded"
							});
						}());
					}
				});
				$('.fullscreen-activator-1').click(function(){
					regular_slider.redrawSlider();
				});
			});
		}
	}
	activateSliders_1();







	function activateSliders_2() {
		// attivo gli slideshow solo se nella pagina è effettivamente inserito uno slideshow
		if ($(".slider-is-true")[0]){
			// dichiaro le variabili per contare quanti slideshow son presenti basandomi sulla classe
			var class_counter = 0;
			// e per contare la variabile per gestire i Public Methods https://bxslider.com/options/
			var slider_counter = 0;
			// recupero la classe in base al valore dell'hidden field "slideshow-selector"
			var get_slider_class = $( '.slideshow-selector-2' ).val();
			// per ogni slideshow presente in pagina aggiungo una classe col contatore
			$('.' + get_slider_class).each(function (i) {
				class_counter++;
				$(this).addClass(get_slider_class+class_counter);
				// per ogni slideshow presente in pagina aggiungo una classe col contatore anche al bottone fullscreen
				$(this).next('.fullscreen-activator-2').addClass('fullscreen-activator-2'+class_counter);
				// pulsante per attivare il fullscreen
				$('.fullscreen-activator-2' + class_counter).click(function(){
					$(this).parent().toggleClass('fullscreen-mode');
					$(this).parent().parent().find(".slideshow-ul").fadeTo( 100, 0.5 ).delay(300).fadeTo( 150, 1 );
					});
			});
			// attivo ogni slideshow presente in pagina
			$('.' + get_slider_class).each(function (index, value) {
				// aggiungo ad ogni slideshow il contatore
				slider_counter++;
				// var regular_slider: definisco la variabile che mi permette di utilizzare i Public Methods
				var regular_slider = $('.'+get_slider_class+slider_counter).bxSlider({
					slideWidth: 4000,
					speed: 1000,
					minSlides: 1,
					maxSlides: 1,
					slideMargin: 0,
					touchEnabled: true,
					controls: true,
					pager: true,
					auto: false,
					mode: 'vertical',
					infiniteLoop: true,
					preloadImages: 'all',
					nextText: '',
					prevText: '',
					keyboardEnabled: true,
					//adaptiveHeight: true,
					//adaptiveHeightSpeed: 300,
					onSliderResize: function(){
						// al ridimensionamento dello schermo faccio un reset per adattare le immagini
						regular_slider.redrawSlider();
					},
					onSlideBefore: function(){
						// nel momento in cui chiedo la slide successiva carico l'immagine con Lazy Load
						(function() {
							var myLazyLoad = new LazyLoad({
								elements_selector: ".lazy",
								class_loading: "lazy-loading",
								class_loaded: "lazy-loaded"
							});
						}());
					}
				});
				$('.fullscreen-activator-2').click(function(){
					regular_slider.redrawSlider();
				});
			});
		}
	}
	activateSliders_2();


});
