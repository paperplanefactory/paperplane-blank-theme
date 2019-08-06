$(document).ready(function() {
	var sliderSpeed = 800;

	// queste sono le variabili per modificare il comportamento degli slide tra desktop e mobile
	var settings_slide_1 = function() {
		var settings_desktop = {
			slideWidth: 4000,
			speed: sliderSpeed,
			minSlides: 2,
			maxSlides: 2,
			slideMargin: 25,
			touchEnabled: true,
			controls: true,
			pager: true,
			auto: false,
			mode: 'horizontal',
			infiniteLoop: true,
			preloadImages: 'all',
			nextText: '<i class="fas fa-long-arrow-alt-right" aria-label="next"></i>',
			prevText: '<i class="fas fa-long-arrow-alt-left" aria-label="previous"></i>',
			keyboardEnabled: true,
			adaptiveHeight: true,
			adaptiveHeightSpeed: 300,
	};
	var settings_mobile = {
		slideWidth: 4000,
		speed: sliderSpeed,
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
		nextText: '<i class="fas fa-long-arrow-alt-right" aria-label="next"></i>',
		prevText: '<i class="fas fa-long-arrow-alt-left" aria-label="previous"></i>',
		keyboardEnabled: true,
		adaptiveHeight: true,
		adaptiveHeightSpeed: 300
	};
	return ($(window).width()>767) ? settings_desktop : settings_mobile;
}

var settings_slide_2 = function() {
	var settings_desktop = {
		slideWidth: 4000,
		speed: sliderSpeed,
		minSlides: 1,
		maxSlides: 1,
		slideMargin: 25,
		touchEnabled: true,
		controls: true,
		pager: true,
		auto: false,
		mode: 'horizontal',
		infiniteLoop: true,
		preloadImages: 'all',
		nextText: '<i class="fas fa-long-arrow-alt-right" aria-label="next"></i>',
		prevText: '<i class="fas fa-long-arrow-alt-left" aria-label="previous"></i>',
		keyboardEnabled: true,
		adaptiveHeight: true,
		adaptiveHeightSpeed: 300
};
var settings_mobile = {
	slideWidth: 4000,
	speed: sliderSpeed,
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
	nextText: '<i class="fas fa-long-arrow-alt-right" aria-label="next"></i>',
	prevText: '<i class="fas fa-long-arrow-alt-left" aria-label="previous"></i>',
	keyboardEnabled: true,
	adaptiveHeight: true,
	adaptiveHeightSpeed: 300
};
return ($(window).width()>767) ? settings_desktop : settings_mobile;
}

var settingsFull = function() {
	var settingsFull1 = {
		slideWidth: 4000,
		speed: sliderSpeed,
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
		nextText: '<i class="fas fa-long-arrow-alt-right" aria-label="next"></i>',
		prevText: '<i class="fas fa-long-arrow-alt-left" aria-label="previous"></i>',
		keyboardEnabled: true,
		adaptiveHeight: true,
		adaptiveHeightSpeed: 300
	};
	return settingsFull1;
}

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

			// attivo ogni slideshow presente in pagina
			$('.' + get_slider_class).each(function (index, value) {
				$('.' + get_slider_class).each(function (i) {
					class_counter++;
					$(this).addClass(get_slider_class+class_counter);
					// per ogni slideshow presente in pagina aggiungo una classe col contatore anche al bottone fullscreen
					$(this).next('.fullscreen-activator-1').addClass('fullscreen-activator-1'+class_counter);
					// pulsante per attivare il fullscreen
					$('.fullscreen-activator-1' + class_counter).click(function(){
						$(this).parent().toggleClass('fullscreen-mode');
						$(this).parent().parent().find(".slideshow-ul").fadeTo( 100, 0.5 ).delay(300).fadeTo( 150, 1 );
						if ($(this).parent().hasClass('fullscreen-mode')) {
							expandedSettings();
						}
						else {
							tourLandingScript();
						}
						});
				});
				// aggiungo ad ogni slideshow il contatore
				slider_counter++;
				// var regular_slider: definisco la variabile che mi permette di utilizzare i Public Methods
				function tourLandingScript() {
					regular_slider.reloadSlider(settings_slide_1());
				}
				function expandedSettings() {
					regular_slider.reloadSlider(settingsFull());
				}
				var regular_slider = $('.'+get_slider_class+slider_counter).bxSlider(settings_slide_1());
				$(window).resize(tourLandingScript);
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

			// attivo ogni slideshow presente in pagina
			$('.' + get_slider_class).each(function (index, value) {
				$('.' + get_slider_class).each(function (i) {
					class_counter++;
					$(this).addClass(get_slider_class+class_counter);
					// per ogni slideshow presente in pagina aggiungo una classe col contatore anche al bottone fullscreen
					$(this).next('.fullscreen-activator-2').addClass('fullscreen-activator-2'+class_counter);
					// pulsante per attivare il fullscreen
					$('.fullscreen-activator-2' + class_counter).click(function(){
						$(this).parent().toggleClass('fullscreen-mode');
						$(this).parent().parent().find(".slideshow-ul").fadeTo( 100, 0.5 ).delay(300).fadeTo( 150, 1 );
						if ($(this).parent().hasClass('fullscreen-mode')) {
							expandedSettings();
						}
						else {
							tourLandingScript();
						}
						});
				});
				// aggiungo ad ogni slideshow il contatore
				slider_counter++;
				// var regular_slider: definisco la variabile che mi permette di utilizzare i Public Methods
				function tourLandingScript() {
					regular_slider.reloadSlider(settings_slide_2());
				}
				function expandedSettings() {
					regular_slider.reloadSlider(settingsFull());
				}
				var regular_slider = $('.'+get_slider_class+slider_counter).bxSlider(settings_slide_2());
				$(window).resize(tourLandingScript);
			});
		}
	}
	activateSliders_2();


	$('.bx-controls a').bind('click', function(e) {
		$(this).addClass('no-click');
		//paperPlaneLazyLoad.update();
		setTimeout(function () {
			$('.bx-controls a').removeClass('no-click');
		}, sliderSpeed);
	});
});
