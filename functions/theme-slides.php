<?php
add_action( 'wp_footer', 'activate_slideshows');
function activate_slideshows() {
	$generic_slider_selector = '.slideshow_number';
?>
<script>

var myLazyLoadScroll = new LazyLoad({
	container: document.getElementById('postsliderID')
});

$(document).ready(function() {
	singleSlideWidth = $('.modulo-slideshow-home').width();
	$(".homeslider li, .home-not-slider li, .postslider li").css("width", singleSlideWidth);
	slidepair = 1;

	// gestione slideshow quando inseriti tramite repeater
  var apiNum = 0;
  $( '<?php echo $generic_slider_selector; ?>' ).each(function( index ) {
    var setSlideId = $( this ).val();
    var apiName = 'api';
    apiNum++;
    var apiSelect = apiName+apiNum;
    var apiSelect = $(setSlideId).bxSlider({
      slideWidth: 4000,
  		speed: 800,
      minSlides: slidepair,
      maxSlides: slidepair,
      slideMargin: 0,
  		touchEnabled: true,
  		controls: true,
      pager: true,
      pagerType: 'short',
      mode: 'horizontal',
      infiniteLoop: true,
      auto: false,
      nextText: '',
      prevText: ''
    });
   resetSlide = function() {
     apiSelect.reloadSlider();
     };

  });
});

</script>
<?php }
