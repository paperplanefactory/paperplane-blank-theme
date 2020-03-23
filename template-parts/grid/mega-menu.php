<?php
$mega_menu_counter = 0;
if ( have_rows( 'mega_menu_repeater', $acf_options_parameter ) ) : while ( have_rows( 'mega_menu_repeater', $acf_options_parameter ) ) : the_row();
$mega_menu_counter++;
$mega_menu_repeater_cta_target = get_sub_field( 'mega_menu_repeater_cta_target' );
switch ( $mega_menu_repeater_cta_target ) {
  case 'cta-target-internal' :
  $mega_menu_repeater_cta_url = get_sub_field( 'mega_menu_repeater_cta_target_internal' );
  $mega_menu_repeater_cta_url_target = '_self';
  break;
  case 'cta-target-external' :
  $mega_menu_repeater_cta_url = get_sub_field( 'mega_menu_repeater_cta_target_external' );
  $mega_menu_repeater_cta_url_target = '_blank';
  break;
  case 'cta-target-file' :
  $mega_menu_repeater_cta_url = get_sub_field( 'mega_menu_repeater_cta_target_file' );
  $mega_menu_repeater_cta_url_target = '_blank';
  break;
}
?>
<nav class="mega-menu combo-1 default-box-shadow mega-menu-js mega-menu-js-<?php echo $mega_menu_counter; ?>-target hidden">
  <div class="mega-menu-spacer">
    <div class="flex-hold flex-hold-3 margins-wide">
      <div class="flex-hold-child">
        <ul class="mega-menu-page-list">
          <?php
          if ( have_rows( 'mega_menu_repeater_pages_repeater' ) ) : while ( have_rows( 'mega_menu_repeater_pages_repeater' ) ) : the_row();
          ?>
          <li>
            <a href="<?php the_sub_field( 'mega_menu_repeater_pages_repeater_page' ); ?>"><?php the_sub_field( 'mega_menu_repeater_pages_repeater_page_title' ); ?></a>
          </li>
          <?php endwhile; endif; ?>
        </ul>
      </div>
      <div class="flex-hold-child">
        <?php
        $image_data = array(
            'image_type' => 'acf_sub_field', // options: post_thumbnail, acf_field, acf_sub_field
            'image_value' => 'mega_menu_repeater_image', // se utilizzi un custom field indica qui il nome del campo
            'size_fallback' => 'column'
        );
        $image_sizes = array( // qui sono definiti i ritagli o dimensioni. Devono corrispondere per numero a quanto dedinfito nella funzione nei parametri data-srcset o srcset
            'retina' => 'column',
            'desktop' => 'column',
            'mobile' => 'column',
            'micro' => 'micro'
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
        <?php if ( get_sub_field( 'mega_menu_repeater_cta_text' ) ) : ?>
          <div class="cta-holder">
            <a href="<?php echo $mega_menu_repeater_cta_url; ?>" target="<?php echo $mega_menu_repeater_cta_url_target; ?>" class="<?php the_sub_field( 'mega_menu_repeater_cta_appearence' ); ?> allupper"><?php the_sub_field( 'mega_menu_repeater_cta_text' ); ?></a>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</nav>
<script type="text/javascript">
$('.mega-menu-js-<?php echo $mega_menu_counter; ?>-trigger').hover(function() {
  $('.mega-menu-js-trigger').removeClass('current-mega-menu');
  $(this).addClass('current-mega-menu');
  $('.mega-menu-js').addClass('hidden');
  $('.mega-menu-js-<?php echo $mega_menu_counter; ?>-target').removeClass('hidden');
});
</script>
<?php endwhile; endif; ?>
