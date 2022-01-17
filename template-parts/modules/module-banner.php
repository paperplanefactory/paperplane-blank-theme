<!-- module-banner -->
<?php
$banner = get_sub_field( 'module_banner_object' );
if( $banner ) :
  $post = $banner;
  setup_postdata( $post );
  $banner_background_image = get_field( 'banner_background_image' );
  if ( $banner_background_image != '' ) {
    $banner_background_image_URL = $banner_background_image['sizes']['full_desk'];
    $banner_background_image_hd_URL = $banner_background_image['sizes']['full_desk_hd'];
    $banner_bg_lazy_class = 'lazy coverize';
  }
  $banner_foreground_image = get_field( 'banner_foreground_image' );
  // recupero le informazioni per la CTA del modulo
  $cta_banner_text_data = get_field( 'banner_cta_text' );
  if ( $cta_banner_text_data != '' ) {
    $cta_banner_type_data = get_field( 'banner_cta_target' );
    global $cta_url_modal_array;
    switch ( $cta_banner_type_data ) {
      case 'cta-target-internal' :
      $cta_banner_url_data = get_field( 'banner_cta_target_internal' );
      $cta_banner_url_data = get_permalink( $cta_banner_url_data[0] );
      $cta_banner_url_target = '_self';
      $cta_url_modal_class = '';
      $cta_banner_url_parameter_data = get_field( 'banner_cta_target_internal_parameter' );
      if ( $cta_banner_url_parameter_data != '' ) {
        $cta_banner_url_data = $cta_banner_url_data . $cta_url_parameter_data;
      }
      break;
      case 'cta-target-external' :
      $cta_banner_url_data = get_field( 'banner_cta_target_external' );
      $cta_banner_url_target = '_blank';
      $cta_url_modal_class = '';
      break;
      case 'cta-target-file' :
      $cta_banner_url_data = get_field( 'banner_cta_target_file' );
      $cta_banner_url_target = '_blank';
      $cta_url_modal_class = '';
      break;
      case 'cta-target-modal' :
      $cta_url_data = '#';
      $cta_url_target = '_self';
      $cta_url_modal_class = 'modal-open-js';
      $cta_url_modal_id = get_field( 'banner_cta_modal' );
      $cta_url_modal_array[] = get_field( 'banner_cta_modal' );
      break;
    }
    $cta_banner_appearence = get_field( 'banner_cta_appearence' );
  }
?>
<div class="wrapper module-banner">
  <a name="section-<?php echo $module_count; ?>" class="section-anchor"></a>
  <div class="<?php the_sub_field( 'module_vertical_top_space' ); ?> <?php the_sub_field( 'module_vertical_bottom_space' ); ?>">
    <div class="wrapper-padded">
      <div class="wrapper-padded-container">
        <div class="banner-space coverize <?php echo $banner_bg_lazy_class; ?> <?php the_field( 'banner_color_scheme' ); ?>" data-bg="<?php echo $module_fullscreen_image_image_URL; ?>" data-bg-hidpi="<?php echo $module_fullscreen_image_image_hd_URL; ?>">
          <div class="above-image-opacity"></div>
          <div class="banner-content">
            <?php if ( $banner_foreground_image != '' ) : ?>
              <div class="flex-hold flex-hold-banner">
                <div class="banner-image" data-aos="zoom-out">
                  <a href="<?php echo $cta_banner_url_data; ?>" target="<?php echo $cta_banner_url_target; ?>" title="<?php the_title(); ?>">
                    <?php
                    $image_data = array(
                        'image_type' => 'acf_field', // options: post_thumbnail, acf_field, acf_sub_field
                        'image_value' => 'banner_foreground_image', // se utilizzi un custom field indica qui il nome del campo
                        'size_fallback' => 'banner'
                    );
                    $image_sizes = array( // qui sono definiti i ritagli o dimensioni. Devono corrispondere per numero a quanto dedinfito nella funzione nei parametri data-srcset o srcset
                        'desktop_default' => 'banner',
                        'desktop_hd' => 'banner_hd',
                        'mobile_default' => 'banner',
                        'mobile_hd' => 'banner_hd',
                        'lazy_placheholder' => 'micro'
                    );
                    print_theme_image( $image_data, $image_sizes );
                    ?>
                  </a>
                </div>
                <div class="banner-texts">
                  <div class="last-child-no-margin">
                    <h2><?php the_title(); ?></h2>
                    <?php
                    // se è impostata la CTA la inserisco
                    if ( $cta_banner_text_data != '' ) :
                      ?>
                      <div class="cta-holder">
                        <a href="<?php echo $cta_banner_url_data; ?>" target="<?php echo $cta_banner_url_target; ?>" class="<?php echo $cta_banner_appearence; ?> <?php echo $cta_url_modal_class; ?> allupper" data-modal-open-id=".paperplane-modal-js-<?php echo $cta_url_modal_id; ?>"><?php echo $cta_banner_text_data; ?></a>
                      </div>
                    <?php endif; ?>
                  </div>
                </div>
              </div>
            <?php else : ?>
              <div class="last-child-no-margin">
                <h2><?php the_title(); ?></h2>
                <?php
                // se è impostata la CTA la inserisco
                if ( $cta_banner_text_data != '' ) :
                  ?>
                  <div class="cta-holder">
                    <a href="<?php echo $cta_banner_url_data; ?>" target="<?php echo $cta_banner_url_target; ?>" class="<?php echo $cta_banner_appearence; ?> <?php echo $cta_url_modal_class; ?> allupper" data-modal-open-id=".paperplane-modal-js-<?php echo $cta_url_modal_id; ?>"><?php echo $cta_banner_text_data; ?></a>
                  </div>
                <?php endif; ?>
              </div>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- module-banner -->
<?php wp_reset_postdata(); endif; ?>
