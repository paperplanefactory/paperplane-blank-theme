<div class="flex-hold-child grid-item-infinite">
  <div class="pad-top-2 pad-right-2 pad-bottom-2 pad-left-2">
    <a href="<?php the_permalink(); ?>">
      <?php
      $image_data = array(
          'image_type' => 'post_thumbnail', // options: post_thumbnail, acf_field, acf_sub_field
          'image_value' => 'immagine_acf', // se utilizzi un custom field indica qui il nome del campo
          'size_fallback' => 'full_desk'
      );
      $image_sizes = array( // qui sono definiti i ritagli o dimensioni. Devono corrispondere per numero a quanto dedinfito nella funzione nei parametri data-srcset o srcset
          'retina' => 'content_picture_cropped',
          'desktop' => 'content_picture_cropped',
          'mobile' => 'content_picture_cropped',
          'micro' => 'micro'
      );
      print_theme_image( $image_data, $image_sizes );
      ?>
    </a>
    <h6><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h6>
  </div>
</div>
