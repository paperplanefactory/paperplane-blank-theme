<?php
global $acf_options_parameter;
global $mega_menu_wrapper;
$mega_menu_counter = 0;
if ( have_rows( 'mega_menu_repeater', $acf_options_parameter ) ) : while ( have_rows( 'mega_menu_repeater', $acf_options_parameter ) ) : the_row();
$mega_menu_counter++;
?>
<nav class="mega-menu mega-menu-js mega-menu-js-<?php echo $mega_menu_counter; ?>-<?php echo $acf_options_parameter; ?>-target hidden">
  <div class="mega-menu-holder <?php echo $mega_menu_wrapper; ?> colors-black-bg">
    <div class="mega-menu-spacer mega-menu-js-hover">
      <div class="flex-hold flex-hold-3 margins-wide">
        <div class="flex-hold-child">
          <?php
          if ( has_nav_menu( 'mega-menu-' . $mega_menu_counter . '' ) ) {
            wp_nav_menu( array( 'theme_location' => 'mega-menu-' . $mega_menu_counter . '', 'container' => 'ul', 'menu_class' => 'mega-menu-page-list' ) );
          }
          ?>
        </div>
        <div class="flex-hold-child">
          <?php
          $image_data = array(
              'image_type' => 'acf_sub_field', // options: post_thumbnail, acf_field, acf_sub_field
              'image_value' => 'mega_menu_repeater_image', // se utilizzi un custom field indica qui il nome del campo
              'size_fallback' => 'column'
          );
          $image_sizes = array( // qui sono definiti i ritagli o dimensioni. Devono corrispondere per numero a quanto dedinfito nella funzione nei parametri data-srcset o srcset
              'desktop_default' => 'column',
              'desktop_hd' => 'column_hd',
              'mobile_default' => 'column',
              'mobile_hd' => 'column_hd',
              'lazy_placheholder' => 'micro'
          );
          print_theme_image( $image_data, $image_sizes );
          ?>
        </div>
        <div class="flex-hold-child">
          <div class="last-child-no-margin">
            <p>
              <?php the_sub_field( 'mega_menu_repeater_additional_info' ); ?>
            </p>
          </div>
          <?php paperplane_theme_cta('paperplane_theme_cta_mega_menu'); ?>
        </div>
      </div>
    </div>
  </div>
</nav>
<script type="text/javascript">
jQuery('.header-menu-js > .menu-item').not('.mega-menu-js-trigger').hover(function(e) {
  jQuery('.mega-menu-js').addClass('hidden');
  jQuery('.mega-menu-js-trigger').removeClass('current-mega-menu');
});
jQuery('.mega-menu-js-hover').mouseleave(function() {
  jQuery('.mega-menu-js-<?php echo $mega_menu_counter; ?>-<?php echo $acf_options_parameter; ?>-target').addClass('hidden');
  jQuery('.mega-menu-js-trigger').removeClass('current-mega-menu');
});
jQuery('.mega-menu-js-<?php echo $mega_menu_counter; ?>-<?php echo $acf_options_parameter; ?>-trigger').hover(function() {
  jQuery('.mega-menu-js-trigger').removeClass('current-mega-menu');
  jQuery(this).addClass('current-mega-menu');
  jQuery('.mega-menu-js').addClass('hidden');
  jQuery('.mega-menu-js-<?php echo $mega_menu_counter; ?>-<?php echo $acf_options_parameter; ?>-target').removeClass('hidden');
});
</script>
<?php endwhile; endif; ?>
