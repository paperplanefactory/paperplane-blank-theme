$(document).ready(function() {
	// Wrappo i video player in una div per dimensionarli responsive
	$('.content-styled iframe').wrap('<div class="video_frame"></div>');
	// Controllo se l'immagine ha la didascalia e se manca la wrappo per allinearla
	if(! $('img.alignnone').closest('.wp-caption').length ) {
		$('img.alignnone').wrap('<div class="wp-caption alignnone"></div>');
	}
	if(! $('img.aligncenter').closest('.wp-caption').length ) {
		$('img.aligncenter').wrap('<div class="wp-caption aligncenter"></div>');
	}
	if( $('img.alignleft') ) {
		$('img.alignleft').wrap('<div class="wp-caption alignleft"></div>');
	}
	if( $('img.alignright') ) {
		$('img.alignright').wrap('<div class="wp-caption alignright"></div>');
	}
	


	// hamburger
	$('.ham-activator').click(function(){
		$('.nav-icon3').toggleClass('open');
		if ( $( '.nav-icon3' ).hasClass('open') ) {
			$( '#head-overlay' ).focus();
		}
		else {
			$( '#header' ).focus();
		}
		$( '#head-overlay' ).fadeToggle( 150 );
		$( '#search-box' ).fadeOut(300);
	});
	// expandables
	$('.expander').click(function() {
	if ( $(this).hasClass('exp-minus') ) {
		$(this).addClass('exp-plus');
		$(this).removeClass('exp-minus');
		$(this).parent().next('.expandable-content').slideUp(150);

		}
	else {
		$(this).addClass('exp-minus');
		$(this).removeClass('exp-plus');
		$(this).parent().next('.expandable-content').slideDown(150);
		}
	});
});
