<!-- module-banner -->
<?php
$banner = get_sub_field( 'module_banner_object' );
if( $banner ) :
  $post = $banner;
  setup_postdata( $post );
  $banner_shadow = get_field( 'banner_shadow' );
  $banner_background_image = get_field( 'banner_background_image' );
  $banner_background_image_URL = $banner_background_image['sizes']['full_desk'];

  $banner_foreground_image = get_field( 'banner_foreground_image' );
  $banner_cta_target = get_field( 'banner_cta_target' );
  switch ( $banner_cta_target ) {
    case 'cta-target-internal' :
    $banner_cta_url = get_field( 'banner_cta_target_internal' );
    $banner_cta_url_target = '_self';
    break;
    case 'cta-target-external' :
    $banner_cta_url = get_field( 'banner_cta_target_external' );
    $banner_cta_url_target = '_blank';
    break;
    case 'cta-target-file' :
    $banner_cta_url = get_field( 'banner_cta_target_file' );
    $banner_cta_url_target = '_blank';
    break;
  }
?>
<div class="wrapper module-banner <?php the_sub_field( 'module_bg' ); ?>">
  <div class="module-spacer">
    <div class="wrapper-padded">
      <div class="wrapper-padded-container">
        <?php if ( $banner_foreground_image != '' ) : ?>
          <?php if ( $banner_background_image != '' ) : ?>
            <div class="banner-space lazy blended <?php the_field( 'banner_color_scheme' ); ?> <?php echo $banner_shadow; ?>" data-bg="<?php echo $banner_background_image_URL; ?>" data-aos="zoom-out">
          <?php else : ?>
            <div class="banner-space <?php the_field( 'banner_color_scheme' ); ?> <?php echo $banner_shadow; ?>">
          <?php endif; ?>
            <div class="flex-hold flex-hold-banner-image verticalize">
              <div class="banner-box banner-image" data-aos="fade-right" data-aos-delay="450">
                <a href="<?php echo $banner_cta_url; ?>" target="<?php echo $banner_cta_url_target; ?>">
                  <?php
                  $image_data = array(
                      'image_type' => 'acf_field', // options: post_thumbnail, acf_field, acf_sub_field
                      'image_value' => 'banner_foreground_image', // se utilizzi un custom field indica qui il nome del campo
                      'size_fallback' => 'highlighted_sentence'
                  );
                  $image_sizes = array( // qui sono definiti i ritagli o dimensioni. Devono corrispondere per numero a quanto dedinfito nella funzione nei parametri data-srcset o srcset
                      'retina' => 'highlighted_sentence',
                      'desktop' => 'highlighted_sentence',
                      'mobile' => 'highlighted_sentence',
                      'micro' => 'micro'
                  );
                  print_theme_image( $image_data, $image_sizes );
                  ?>
                </a>
              </div>
              <div class="banner-box banner-text last-child-no-margin">
                <h2><?php the_title(); ?></h2>
              </div>
              <div class="banner-box banner-cta" data-aos="fade-left" data-aos-delay="450">
                <a href="<?php echo $banner_cta_url; ?>" target="<?php echo $banner_cta_url_target; ?>" class="<?php the_field( 'banner_cta_appearence' ); ?> allupper"><?php the_field( 'banner_cta_text' ); ?></a>
              </div>
            </div>
          </div>
        <?php else : ?>
          <?php if ( $banner_background_image != '' ) : ?>
            <div class="banner-space lazy blended <?php the_field( 'banner_color_scheme' ); ?> <?php echo $banner_shadow; ?>" data-bg="url('<?php echo $banner_background_image_URL; ?>')" data-aos="zoom-out">
          <?php else : ?>
            <div class="banner-space <?php the_field( 'banner_color_scheme' ); ?> <?php echo $banner_shadow; ?>">
          <?php endif; ?>
            <div class="flex-hold flex-hold-banner verticalize">
              <div class="banner-box banner-text last-child-no-margin">
                <h2><?php the_title(); ?></h2>
              </div>
              <div class="banner-box banner-cta">
                <a href="<?php echo $banner_cta_url; ?>" target="<?php echo $banner_cta_url_target; ?>" class="<?php the_field( 'banner_cta_appearence' ); ?> allupper"><?php the_field( 'banner_cta_text' ); ?></a>
              </div>
            </div>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>
<!-- module-banner -->
<?php wp_reset_postdata(); endif; ?>
