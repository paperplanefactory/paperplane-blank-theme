<div class="flex-hold-child grid-item-infinite" data-aos="fade-up">
  <div class="grid-listing-image">
    <a href="<?php the_permalink(); ?>">
      <?php
      $image_data = array(
          'image_type' => 'post_thumbnail', // options: post_thumbnail, acf_field, acf_sub_field
          'image_value' => '', // se utilizzi un custom field indica qui il nome del campo
          'size_fallback' => 'column_cut'
      );
      $image_sizes = array( // qui sono definiti i ritagli o dimensioni. Devono corrispondere per numero a quanto dedinfito nella funzione nei parametri data-srcset o srcset
          'desktop_default' => 'column_cut',
          'desktop_hd' => 'column_cut_hd',
          'mobile_default' => 'column_cut',
          'mobile_hd' => 'column_cut_hd',
          'lazy_placheholder' => 'micro_cut'
      );
      print_theme_image( $image_data, $image_sizes );
      ?>
    </a>
  </div>
  <div class="grid-listing-texts last-child-no-margin">
    <h3><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h3>
  </div>
</div>
