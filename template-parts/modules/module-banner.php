<!-- module-banner -->
<?php
$banner = $module['module_banner_object'];
if ($banner):
  $post = $banner;
  setup_postdata($post);
  $content_fields = paperplane_content_transients($post->ID);
  $banner_background_image = $content_fields['banner_background_image'];
  if ($banner_background_image != '') {
    $banner_background_image_URL = $banner_background_image['sizes']['full_desk'];
    $banner_background_image_hd_URL = $banner_background_image['sizes']['full_desk_hd'];
  }
  $banner_foreground_image = $content_fields['banner_foreground_image'];
  ?>
  <div class="wrapper module-banner">
    <a name="section-<?php echo $module_count; ?>" class="section-anchor"></a>
    <div class="<?php echo $module['module_vertical_top_space'] . ' ' . $module['module_vertical_bottom_space']; ?>">
      <div class="wrapper-padded">
        <div class="wrapper-padded-container">
          <div class="banner-space coverize <?php echo $content_fields['banner_color_scheme']; ?>">
            <img src="<?php echo $module_fullscreen_image_image_hd_URL; ?>" title="<?php the_title(); ?>"
              alt="<?php the_title(); ?>" loading="lazy" />
            <div class="above-image-opacity"></div>
            <div class="banner-content">
              <?php if ($content_fields['banner_foreground_image'] != ''): ?>
                <div class="flex-hold flex-hold-banner">
                  <div class="banner-image uncoverize" data-aos="zoom-out">
                    <?php paperplane_theme_cta_absl_advanced($content_fields['paperplane_theme_cta_banner']); ?>
                    <?php
                    $image_data = array(
                      'image_type' => 'acf',
                      // options: post_thumbnail, acf
                      'image_value' => $content_fields['banner_foreground_image'],
                      // se utilizzi un custom field indica qui il nome del campo
                      'size_fallback' => 'banner'
                    );
                    $image_sizes = array(
                      // qui sono definiti i ritagli o dimensioni. Devono corrispondere per numero a quanto dedinfito nella funzione nei parametri data-srcset o srcset
                      'desktop_default' => 'banner',
                      'desktop_hd' => 'banner_hd',
                      'mobile_default' => 'banner',
                      'mobile_hd' => 'banner_hd',
                      'lazy_placheholder' => 'micro'
                    );
                    print_theme_image($image_data, $image_sizes);
                    ?>
                  </div>
                  <div class="banner-texts">
                    <div class="last-child-no-margin">
                      <h2>
                        <?php the_title(); ?>
                      </h2>
                      <?php paperplane_theme_cta_advanced($content_fields['paperplane_theme_cta_banner']); ?>
                    </div>
                  </div>
                </div>
              <?php else: ?>
                <div class="last-child-no-margin">
                  <h2>
                    <?php the_title(); ?>
                  </h2>
                  <?php paperplane_theme_cta_advanced($content_fields['paperplane_theme_cta_banner']); ?>
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