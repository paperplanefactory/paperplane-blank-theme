<!-- module-highlighted-sentence -->
<?php
// richiamo l'immagine associata alla frase in evidenza
$module_highlighted_sentence_image = get_sub_field( 'module_highlighted_sentence_image' );
// recupero le informazioni per la CTA del modulo
$cta_text_data = get_sub_field( 'module_additional_elements_cta_text' );
if ( $cta_text_data != '' ) {
  $cta_type_data = get_sub_field( 'module_additional_elements_cta_target' );
  switch ( $cta_type_data ) {
    case 'cta-target-internal' :
    $cta_url_data = get_sub_field( 'module_additional_elements_cta_target_internal' );
    $cta_url_target = '_self';
    $cta_url_parameter_data = get_sub_field( 'module_additional_elements_cta_target_internal_parameter' );
    if ( $cta_url_parameter_data != '' ) {
      $cta_url_data = $cta_url_data . $cta_url_parameter_data;
    }
    break;
    case 'cta-target-external' :
    $cta_url_data = get_sub_field( 'module_additional_elements_cta_target_external' );
    $cta_url_target = '_blank';
    break;
    case 'cta-target-file' :
    $cta_url_data = get_sub_field( 'module_additional_elements_cta_target_file' );
    $cta_url_target = '_blank';
    break;
  }
  $cta_appearence = get_sub_field( 'module_additional_elements_cta_appearence' );
}
 ?>
<section class="wrapper module-highlighted-sentence <?php the_sub_field( 'module_bg' ); ?>">
  <div class="<?php the_sub_field( 'module_vertical_top_space' ); ?> <?php the_sub_field( 'module_vertical_bottom_space' ); ?>">
    <div class="wrapper-padded">
      <div class="wrapper-padded-container">
        <?php
        // se esiste l'immagine associata alla frase in evidenza imposto il layout imagine + testo
        if ( $module_highlighted_sentence_image != '' ) :
          ?>
          <div class="flex-hold flex-hold-rich-highlighted-sentence">
            <div class="flex-hold-rich-highlighted-sentence-image">
              <div class="sticky-element">
                <div class="image-rounder" data-aos="fade-up">
                  <?php
                  $image_data = array(
                      'image_type' => 'acf_sub_field', // options: post_thumbnail, acf_field, acf_sub_field
                      'image_value' => 'module_highlighted_sentence_image', // se utilizzi un custom field indica qui il nome del campo
                      'size_fallback' => 'round_image'
                  );
                  $image_sizes = array( // qui sono definiti i ritagli o dimensioni. Devono corrispondere per numero a quanto dedinfito nella funzione nei parametri data-srcset o srcset
                      'desktop_default' => 'round_image',
                      'desktop_hd' => 'round_image_hd',
                      'mobile_default' => 'round_image',
                      'mobile_hd' => 'round_image_hd',
                      'lazy_placheholder' => 'micro'
                  );
                  print_theme_image( $image_data, $image_sizes );
                  ?>
                </div>
              </div>
            </div>
            <div class="flex-hold-rich-highlighted-sentence-text">
              <div class="last-child-no-margin">
                <h2><?php the_sub_field( 'module_highlighted_sentence_text' ); ?></h2>
                <?php if ( get_sub_field( 'module_highlighted_sentence_author' ) ) : ?>
                  <h6><?php the_sub_field( 'module_highlighted_sentence_author' ); ?></h6>
                <?php endif; ?>
              </div>
              <?php
              // se è impostata la CTA la inserisco
              if ( $cta_text_data != '' ) :
                ?>
                <div class="cta-holder">
                  <a href="<?php echo $cta_url_data; ?>" target="<?php echo $cta_url_target; ?>" class="<?php echo $cta_appearence; ?> allupper"><?php echo $cta_text_data; ?></a>
                </div>
              <?php endif; ?>
            </div>
          </div>
        <?php
        // se non esiste l'immagine associata alla frase in evidenza imposto il layout semplice
        else :
          ?>
          <div class="wrapper-padded-more-924">
              <div class="last-child-no-margin">
                <h2><?php the_sub_field( 'module_highlighted_sentence_text' ); ?></h2>
                <?php if ( get_sub_field( 'module_highlighted_sentence_author' ) ) : ?>
                  <h6><?php the_sub_field( 'module_highlighted_sentence_author' ); ?></h6>
                <?php endif; ?>
              </div>
              <?php
              // se è impostata la CTA la inserisco
              if ( $cta_text_data != '' ) :
                ?>
                <div class="cta-holder">
                  <a href="<?php echo $cta_url_data; ?>" target="<?php echo $cta_url_target; ?>" class="<?php echo $cta_appearence; ?> allupper"><?php echo $cta_text_data; ?></a>
                </div>
              <?php endif; ?>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</section>
<!-- module-highlighted-sentence -->
