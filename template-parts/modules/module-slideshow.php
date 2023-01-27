<!-- module-slideshow -->
<?php
// recupero la larghezza dello slide
$module_slideshow_width = get_sub_field( 'module_slideshow_width' );
if ( $module_slideshow_width === 'slide-contained' ) {
  $slide_wrapper_class = 'wrapper-padded-more-924';
}
elseif ( $module_slideshow_width === 'slide-full' ) {
  $slide_wrapper_class = 'wrapper-padded-parent';
}
// recupero il tipo di slideshow
$module_slideshow_type = get_sub_field( 'module_slideshow_type' );
 ?>
<div class="wrapper module-slideshow <?php the_sub_field( 'module_bg' ); ?>">
  <a name="section-<?php echo $module_count; ?>" class="section-anchor"></a>
  <div class="<?php the_sub_field( 'module_vertical_top_space' ); ?> <?php the_sub_field( 'module_vertical_bottom_space' ); ?>">
    <div class="wrapper-padded">
      <div class="<?php echo $slide_wrapper_class; ?>">
        <div class="<?php the_sub_field( 'module_slideshow_type' ); ?> <?php the_sub_field( 'module_slideshow_type' ); ?>-js">
          <?php
          if ( have_rows( 'module_slideshow_repeater' ) ) : while ( have_rows( 'module_slideshow_repeater' ) ) : the_row();
          ?>
          <div class="slide-inner">
            <div class="container">
              <?php
              // slideshow doppio - larghezza contenuta
              if ( $module_slideshow_width === 'slide-contained' && $module_slideshow_type === 'slide-double' ) {
                $image_data = array(
                    'image_type' => 'acf_sub_field', // options: post_thumbnail, acf_field, acf_sub_field
                    'image_value' => 'module_slideshow_repeater_image', // se utilizzi un custom field indica qui il nome del campo
                    'size_fallback' => 'slide_double'
                );
                $image_sizes = array( // qui sono definiti i ritagli o dimensioni. Devono corrispondere per numero a quanto dedinfito nella funzione nei parametri data-srcset o srcset
                    'desktop_default' => 'slide_double',
                    'desktop_hd' => 'slide_double_hd',
                    'mobile_default' => 'slide_double',
                    'mobile_hd' => 'slide_double_hd',
                    'lazy_placheholder' => 'micro'
                );
                print_theme_image_lazyslick( $image_data, $image_sizes );
              }
              // slideshow doppio - larghezza full
              if ( $module_slideshow_width === 'slide-full' && $module_slideshow_type === 'slide-double' ) {
                $image_data = array(
                    'image_type' => 'acf_sub_field', // options: post_thumbnail, acf_field, acf_sub_field
                    'image_value' => 'module_slideshow_repeater_image', // se utilizzi un custom field indica qui il nome del campo
                    'size_fallback' => 'slide'
                );
                $image_sizes = array( // qui sono definiti i ritagli o dimensioni. Devono corrispondere per numero a quanto dedinfito nella funzione nei parametri data-srcset o srcset
                    'desktop_default' => 'slide',
                    'desktop_hd' => 'slide_hd',
                    'mobile_default' => 'slide',
                    'mobile_hd' => 'slide_hd',
                    'lazy_placheholder' => 'micro'
                );
                print_theme_image_lazyslick( $image_data, $image_sizes );
              }
              // slideshow singolo - larghezza contenuta
              if ( $module_slideshow_width === 'slide-contained' && $module_slideshow_type === 'slide-single' ) {
                $image_data = array(
                    'image_type' => 'acf_sub_field', // options: post_thumbnail, acf_field, acf_sub_field
                    'image_value' => 'module_slideshow_repeater_image', // se utilizzi un custom field indica qui il nome del campo
                    'size_fallback' => 'slide'
                );
                $image_sizes = array( // qui sono definiti i ritagli o dimensioni. Devono corrispondere per numero a quanto dedinfito nella funzione nei parametri data-srcset o srcset
                    'desktop_default' => 'slide',
                    'desktop_hd' => 'slide_hd',
                    'mobile_default' => 'slide',
                    'mobile_hd' => 'slide_hd',
                    'lazy_placheholder' => 'micro'
                );
                print_theme_image_lazyslick( $image_data, $image_sizes );
              }
              // slideshow singolo - larghezza full
              if ( $module_slideshow_width === 'slide-full' && $module_slideshow_type === 'slide-single' ) {
                $image_data = array(
                    'image_type' => 'acf_sub_field', // options: post_thumbnail, acf_field, acf_sub_field
                    'image_value' => 'module_slideshow_repeater_image', // se utilizzi un custom field indica qui il nome del campo
                    'size_fallback' => 'full_desk'
                );
                $image_sizes = array( // qui sono definiti i ritagli o dimensioni. Devono corrispondere per numero a quanto dedinfito nella funzione nei parametri data-srcset o srcset
                    'desktop_default' => 'full_desk',
                    'desktop_hd' => 'full_desk_hd',
                    'mobile_default' => 'full_desk',
                    'mobile_hd' => 'full_desk_hd',
                    'lazy_placheholder' => 'micro'
                );
                print_theme_image_lazyslick( $image_data, $image_sizes );
              }
              ?>
              <div class="slide-caption">
                <?php if ( get_sub_field( 'module_slideshow_repeater_caption' ) ) : ?>
                  <figcaption><?php the_sub_field( 'module_slideshow_repeater_caption' ); ?></figcaption>
                <?php endif; ?>
              </div>
            </div>
          </div>
          <?php endwhile; endif; ?>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- module-slideshow -->
