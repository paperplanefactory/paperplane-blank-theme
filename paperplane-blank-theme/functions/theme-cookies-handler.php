<?php
add_filter( 'the_content', 'paperplane_iframe_gdpr', 99, 4 );
function paperplane_iframe_gdpr( $html ) {
  return preg_replace('~<iframe[^>]*\K(?=src)~i','gdpr-', $html);
}


add_action( 'wp_footer', 'paperplane_handle_cookies', 9999);
function paperplane_handle_cookies() {
  // versione del tema
  if ( function_exists( 'PLL' ) ) {
    $cookie_version = get_field( 'cookie_version', pll_current_language('slug') );
    $cookie_gdpr_expry = get_field( 'scadenza_cookie_gdpr', pll_current_language('slug') );
    $non_gdpr_tracking_codes = get_field( 'non_gdpr_tracking_codes', pll_current_language('slug') );
    $gdpr_tracking_codes = get_field( 'gdpr_tracking_codes', pll_current_language('slug') );
    $embedded_content_message = get_field( 'embedded_content_message', pll_current_language('slug') );
    $forzare_il_reload = get_field( 'forzare_il_reload', pll_current_language('slug') );
    $forzare_accettazione_scroll = get_field( 'forzare_accettazione_scroll', pll_current_language('slug') );
    $pixel_scroll = get_field( 'pixel_scroll', pll_current_language('slug') );
  }
  else {
    $cookie_version = get_field( 'cookie_version', 'any-lang' );
    $cookie_gdpr_expry = get_field( 'scadenza_cookie_gdpr', 'any-lang' );
    $non_gdpr_tracking_codes = get_field( 'non_gdpr_tracking_codes', 'any-lang' );
    $gdpr_tracking_codes = get_field( 'gdpr_tracking_codes', 'any-lang' );
    $embedded_content_message = get_field( 'embedded_content_message', 'any-lang' );
    $forzare_il_reload = get_field( 'forzare_il_reload', 'any-lang' );
    $forzare_accettazione_scroll = get_field( 'forzare_accettazione_scroll', 'any-lang' );
    $pixel_scroll = get_field( 'pixel_scroll', 'any-lang' );
  }


  //
  //converto ore in giorni
  $days_expry = ($cookie_gdpr_expry / 24);

  //

  //
   ?>
  <script>
  $(document).ready(function() {
    var non_gdpr_tracking_codes = decodeURIComponent("<?php echo rawurlencode($non_gdpr_tracking_codes); ?>");
    var gdpr_tracking_codes = decodeURIComponent("<?php echo rawurlencode($gdpr_tracking_codes); ?>");
    var embedded_content_message = decodeURIComponent("<?php echo rawurlencode($embedded_content_message); ?>");
    var myCookie<?php echo $cookie_version; ?> = Cookies.get('paperplane-gdpr<?php echo $cookie_version; ?>');
    $('head').append(non_gdpr_tracking_codes);
    if ( myCookie<?php echo $cookie_version; ?> === 'no' ) {
      $('iframe').each(function() {
        $(this).replaceWith( "<div class='paperplane-gdpr-content-message'><a href='#' class='paperplane-gdpr-accept absl'></a>"+embedded_content_message+"</div>" );
      });
    }
    if ( typeof myCookie<?php echo $cookie_version; ?> === 'undefined' || myCookie<?php echo $cookie_version; ?> === null || myCookie<?php echo $cookie_version; ?> === '' ) {
      $('#paperplane-cookie-notice').fadeIn(200);
      $('iframe').each(function() {
        $(this).replaceWith( "<div class='paperplane-gdpr-content-message'><a href='#' class='paperplane-gdpr-accept absl'></a>"+embedded_content_message+"</div>" );
      });
      <?php if ( $forzare_accettazione_scroll === 'yes' ) : ?>
      function acceptOnScroll() {
  		fromTop = $(document).scrollTop();
    		if ( fromTop > <?php echo $pixel_scroll; ?> ) {
          $('#paperplane-cookie-notice').fadeOut(200);
          Cookies.set('paperplane-gdpr<?php echo $cookie_version; ?>', 'yes', { expires: <?php echo $days_expry; ?> });
          <?php if ( $forzare_il_reload === 'yes' ) : ?>
          location.reload();
          <?php endif; ?>
    		}
    	}
      $(document).scroll(function() {
    		acceptOnScroll();
    	});
      <?php endif; ?>

    }
    if ( myCookie<?php echo $cookie_version; ?> === 'yes' ) {
      $('head').append(gdpr_tracking_codes);
      $('iframe').each(function() {
        var blockedSrc = $(this).attr("gdpr-src");
        $(this).attr('src', blockedSrc);
        $(this).removeAttr('gdpr-src');
      });
      $('script').each(function() {
        var blockedScript = $(this).attr("gdpr-src");
        $(this).attr('src', blockedScript);
        $(this).removeAttr('gdpr-src');
      });
    }


    $('.paperplane-gdpr-accept').click(function( event ) {
      event.preventDefault();
      $('#paperplane-cookie-notice').fadeOut(200);
      Cookies.set('paperplane-gdpr<?php echo $cookie_version; ?>', 'yes', { expires: <?php echo $days_expry; ?> });
      <?php if ( $forzare_il_reload === 'yes' ) : ?>
      location.reload();
      <?php endif; ?>

    });
    $('.paperplane-gdpr-deny').click(function( event ) {
      event.preventDefault();
      $('#paperplane-cookie-notice').fadeOut(200);
      Cookies.set('paperplane-gdpr<?php echo $cookie_version; ?>', 'no', { expires: <?php echo $days_expry; ?> });
      <?php if ( $forzare_il_reload === 'yes' ) : ?>
      location.reload();
      <?php endif; ?>
    });
    $('.show-paperplane-gdpr').click(function( event ) {
      event.preventDefault();
      Cookies.remove('paperplane-gdpr<?php echo $cookie_version; ?>');
      if ( myCookie<?php echo $cookie_version; ?> === 'yes' ) {
        $('.paperplane-message-cookie-accepted').show();
      }
      if ( myCookie<?php echo $cookie_version; ?> === 'no' ) {
        $('.paperplane-message-cookie-refused').show();
      }
      $('#paperplane-cookie-notice').fadeIn(200);
    });



  });

  </script>
<?php }



add_action( 'wp_footer', 'cookies_banner', 9999);
function cookies_banner() {
  // versione del tema
  if ( function_exists( 'PLL' ) ) {
    $banner_message = get_field( 'banner_message', pll_current_language('slug') );
    $banner_accept_text = get_field( 'banner_accept_text', pll_current_language('slug') );
    $banner_deny_text = get_field( 'banner_deny_text', pll_current_language('slug') );
    $more_info_text = get_field( 'more_info_text', pll_current_language('slug') );
    $url_cookie_policy = get_field( 'url_cookie_policy', pll_current_language('slug') );
    $url_cookie_policy_target = get_field( 'url_cookie_policy_target', pll_current_language('slug') );
    $promemoria_cookie_accettati = get_field( 'promemoria_cookie_accettati', pll_current_language('slug') );
    $promemoria_cookie_rifiutati = get_field( 'promemoria_cookie_rifiutati', pll_current_language('slug') );
  }
  else {
    $banner_message = get_field( 'banner_message', 'any-lang' );
    $banner_accept_text = get_field( 'banner_accept_text', 'any-lang' );
    $banner_deny_text = get_field( 'banner_deny_text', 'any-lang' );
    $more_info_text = get_field( 'more_info_text', 'any-lang' );
    $url_cookie_policy = get_field( 'url_cookie_policy', 'any-lang' );
    $url_cookie_policy_target = get_field( 'url_cookie_policy_target', 'any-lang' );
    $promemoria_cookie_accettati = get_field( 'promemoria_cookie_accettati', 'any-lang' );
    $promemoria_cookie_rifiutati = get_field( 'promemoria_cookie_rifiutati', 'any-lang' );
  }
   ?>
  <div id="paperplane-cookie-notice">
    <div class="paperplane-cookie-notice-container">
      <div class="paperplane-message-cookie-accepted">
        <?php echo $promemoria_cookie_accettati; ?>
      </div>
      <div class="paperplane-message-cookie-refused">
        <?php echo $promemoria_cookie_rifiutati; ?>
      </div>
      <?php echo $banner_message; ?> <a href="#" class="paperplane-gdpr-accept"><?php echo $banner_accept_text; ?></a> <a href="#" class="paperplane-gdpr-deny"><?php echo $banner_deny_text; ?></a> <a href="<?php echo $url_cookie_policy; ?>" target="<?php echo $url_cookie_policy_target; ?>"><?php echo $more_info_text; ?></a>
    </div>

  </div>
<?php }
