<?php
$theme_external_scripts = get_field( 'theme_external_scripts', 'option');
if ( $theme_external_scripts == 1 ) {
  function theme_handle_external_scripts() {
    if ( function_exists( 'PLL' ) ) {
    	$theme_scripts_current_language = pll_current_language();
    }
    else {
    	$theme_scripts_current_language = 'any-lang';
    }
    $theme_head_script = get_field( 'theme_head_script', $theme_scripts_current_language );
    $theme_body_script = get_field( 'theme_body_script', $theme_scripts_current_language );
    $theme_after_body_script = get_field( 'theme_after_body_script', $theme_scripts_current_language );
    ?>
    	<script type="text/javascript">
      var theme_head_script = decodeURIComponent("<?php echo rawurlencode( $theme_head_script ); ?>");
      var theme_body_script = decodeURIComponent("<?php echo rawurlencode( $theme_body_script ); ?>");
      var theme_after_body_script = decodeURIComponent("<?php echo rawurlencode( $theme_after_body_script ); ?>");
      function add_theme_external_scripts() {
        jQuery('head').append(theme_head_script);
    		jQuery('body').prepend(theme_body_script);
    		jQuery('body').append(theme_after_body_script);
      }
      add_theme_external_scripts();
      </script>
    <?php
  }

  add_action( 'wp_footer', 'theme_handle_external_scripts', 9999);
}
