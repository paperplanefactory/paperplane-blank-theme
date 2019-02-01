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
	$( '.ham-activator' ).click(function(){
		$( '.hambuger-element' ).toggleClass('open');
		if ( $( '.hambuger-element' ).hasClass( 'open' ) ) {
			$('html').css('overflowY', 'hidden');
			$('body').addClass('occupy-scrollbar');
			$( '#header-overlay' ).focus();
			$(this).attr('aria-expanded', true);
		}
		else {
			$('html').css('overflowY', 'scroll');
			$('body').removeClass('occupy-scrollbar');
			$( '#header' ).focus();
			$(this).attr('aria-expanded', false);
		}
		$( '#head-overlay' ).fadeToggle( 150 );
		$( '#search-box' ).fadeOut( 300 );
	});
	// expandables
	$('.expander').click(function(e) {
	if ( $(this).hasClass('exp-close') ) {
		$(this).addClass('exp-open').removeClass('exp-close').attr('aria-expanded', false).focus();
		$(this).find('span').addClass('exp-plus').removeClass('exp-minus');
		$(this).parent().next('.expandable-content').slideUp(150);

		}
	else {
		$(this).addClass('exp-close').removeClass('exp-open').attr('aria-expanded', true);
		$(this).find('span').removeClass('exp-plus').addClass('exp-minus');
		$(this).parent().next('.expandable-content').slideDown(150).focus();
		}
		e.preventDefault();
	});
});
