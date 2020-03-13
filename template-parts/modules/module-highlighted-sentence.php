<!-- module-highlighted-sentence -->
<?php
$module_highlighted_sentence_image = get_sub_field( 'module_highlighted_sentence_image' );
$module_highlighted_sentence_image_format = get_sub_field( 'module_highlighted_sentence_image_format' );
$module_highlighted_sentence_cta_target = get_sub_field( 'module_highlighted_sentence_cta_target' );
switch ( $module_highlighted_sentence_cta_target ) {
  case 'cta-target-internal' :
  $module_highlighted_sentence_cta_url = get_sub_field( 'module_highlighted_sentence_cta_target_internal' );
  $module_highlighted_sentence_cta_url_target = '_self';
  break;
  case 'cta-target-external' :
  $module_highlighted_sentence_cta_url = get_sub_field( 'module_highlighted_sentence_cta_target_external' );
  $module_highlighted_sentence_cta_url_target = '_blank';
  break;
  case 'cta-target-file' :
  $module_highlighted_sentence_cta_url = get_sub_field( 'module_highlighted_sentence_cta_target_file' );
  $module_highlighted_sentence_cta_url_target = '_blank';
  break;
}
 ?>
<div class="wrapper module-highlighted-sentence <?php the_sub_field( 'module_bg' ); ?>">
  <div class="module-spacer">
    <div class="wrapper-padded">
      <div class="wrapper-padded-more">
        <div class="wrapper-padded-more-924">
          <?php if ( $module_highlighted_sentence_image != '' ) : ?>
            <div class="flex-hold">
              <div class="flex-hold-child">
                <?php if ( $module_highlighted_sentence_image_format === 'normal-image' ) : ?>
                  <?php
                  $image_data = array(
                      'image_type' => 'acf_sub_field', // options: post_thumbnail, acf_field, acf_sub_field
                      'image_value' => 'module_highlighted_sentence_image', // se utilizzi un custom field indica qui il nome del campo
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
                <?php else : ?>
                  <div class="image-rounder">
                    <?php
                    $image_data = array(
                        'image_type' => 'acf_sub_field', // options: post_thumbnail, acf_field, acf_sub_field
                        'image_value' => 'module_highlighted_sentence_image', // se utilizzi un custom field indica qui il nome del campo
                        'size_fallback' => 'round_image'
                    );
                    $image_sizes = array( // qui sono definiti i ritagli o dimensioni. Devono corrispondere per numero a quanto dedinfito nella funzione nei parametri data-srcset o srcset
                        'retina' => 'round_image',
                        'desktop' => 'round_image',
                        'mobile' => 'round_image',
                        'micro' => 'micro'
                    );
                    print_theme_image( $image_data, $image_sizes );
                    ?>
                  </div>
                <?php endif; ?>
              </div>
              <div class="flex-hold-child">
                <div class="last-child-no-margin">
                  <h2><?php the_sub_field( 'module_highlighted_sentence_text' ); ?></h2>
                  <?php if ( get_sub_field( 'module_highlighted_sentence_author' ) ) : ?>
                    <h6><?php the_sub_field( 'module_highlighted_sentence_author' ); ?></h6>
                  <?php endif; ?>
                </div>

                <?php if ( get_sub_field( 'module_highlighted_sentence_cta_text' ) ) : ?>
                  <div class="cta-holder">
                    <a href="<?php echo $module_highlighted_sentence_cta_url; ?>" target="<?php echo $module_highlighted_sentence_cta_url_target; ?>" class="default-button dark-default-button allupper"><?php the_sub_field( 'module_highlighted_sentence_cta_text' ); ?></a>
                  </div>
                <?php endif; ?>
              </div>
            </div>
          <?php else : ?>
            <div class="last-child-no-margin">
              <h2><?php the_sub_field( 'module_highlighted_sentence_text' ); ?></h2>
              <?php if ( get_sub_field( 'module_highlighted_sentence_author' ) ) : ?>
                <h6><?php the_sub_field( 'module_highlighted_sentence_author' ); ?></h6>
              <?php endif; ?>
            </div>
            <?php if ( get_sub_field( 'module_highlighted_sentence_cta_text' ) ) : ?>
              <div class="cta-holder">
                <a href="<?php echo $module_highlighted_sentence_cta_url; ?>" target="<?php echo $module_highlighted_sentence_cta_url_target; ?>" class="default-button dark-default-button allupper"><?php the_sub_field( 'module_highlighted_sentence_cta_text' ); ?></a>
              </div>
            <?php endif; ?>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- module-highlighted-sentence -->
