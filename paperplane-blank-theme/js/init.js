
jQuery(document).ready(function($){


	prevLink = jQuery('.picture_prev a').attr('href');
	nextLink = jQuery('.picture_next a').attr('href');

	$(document).keydown(function(e) {
    switch(e.which) {
        case 37: // left
				jQuery(location).attr('href', prevLink);
        break;

        case 39: // right
				jQuery(location).attr('href', nextLink);
        break;

        default: return; // exit this handler for other keys
    }
    e.preventDefault(); // prevent the default action (scroll / move caret)
});

	$('.absl_swipe').on('swipeleft', function() {
				jQuery(location).attr('href', nextLink);

		}
	).on('swiperight', function() {
				jQuery(location).attr('href', prevLink);

		}
	);
});
