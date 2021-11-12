<?php
global $listing_page_id;
$pagination_color_scheme = get_field( 'page_opening_color_scheme', $listing_page_id );
if ( $pagination_color_scheme == '' ) {
  $pagination_color_scheme = get_field( 'theme_archive_page_color_scheme', 'option' );
}
 ?>
<div class="wrapper <?php echo $pagination_color_scheme; ?>">
  <div class="wrapper-padded">
    <div class="aligncenter">
      <?php
      if ( function_exists( 'wp_pagenavi' ) ) {
        wp_pagenavi();
      }
       ?>
    </div>
  </div>
</div>
