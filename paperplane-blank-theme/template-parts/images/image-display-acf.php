<?php
$immagine_acf = get_field( 'immagine_acf' );
$immagine_acf_URL_desktop = $immagine_acf['sizes']['slide_image_desktop'];
$immagine_acf_URL_mobile = $immagine_acf['sizes']['slide_image_mobile'];
$immagine_acf_URL_micro = $immagine_acf['sizes']['micro'];
if ( $thumb_id != '' ) :
 ?>
 <div class="no-the-100">
   <picture>
     <source media="(max-width: 1024px)" data-srcset="<?php echo $immagine_acf_URL_mobile; ?>">
       <source media="(min-width: 1025px)" data-srcset="<?php echo $immagine_acf_URL_desktop; ?>">
         <img data-src="<?php echo $immagine_acf_URL_desktop; ?>" src="<?php echo $immagine_acf_URL_micro; ?>" title="<?php echo $immagine_acf['title']; ?> - <?php echo get_bloginfo( 'name' ); ?>" alt="<?php echo $immagine_acf['alt']; ?> - <?php echo get_bloginfo( 'name' ); ?>"  class="lazy" />
       </picture>
 </div>
<?php endif; ?>
