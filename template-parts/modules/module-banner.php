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
                </div>
                <div class="banner-texts">
                  <div class="last-child-no-margin">
                    <h2><?php the_title(); ?></h2>
                    <?php paperplane_theme_cta('paperplane_theme_cta_banner'); ?>
                  </div>
                </div>
              </div>
            <?php else : ?>
              <div class="last-child-no-margin">
                <h2><?php the_title(); ?></h2>
                <?php paperplane_theme_cta('paperplane_theme_cta_banner'); ?>
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
