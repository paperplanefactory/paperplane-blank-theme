<?php
$image_data = array(
    'image_type' => 'acf_sub_field', // options: post_thumbnail, acf_field, acf_sub_field
    'image_value' => 'mega_menu_repeater_image', // se utilizzi un custom field indica qui il nome del campo
    'size_fallback' => 'column'
);
$image_sizes = array( // qui sono definiti i ritagli o dimensioni. Devono corrispondere per numero a quanto dedinfito nella funzione nei parametri data-srcset o srcset
    'desktop_default' => 'column',
    'desktop_hd' => 'column_hd',
    'mobile_default' => 'column',
    'mobile_hd' => 'column_hd',
    'lazy_placheholder' => 'micro'
);
print_theme_image( $image_data, $image_sizes );
?>


<?php
// url immagine da ACF
$scegli_immagine = get_sub_field( 'scegli_immagine' );
$scegli_immagine_URL = $scegli_immagine['sizes']['full_desk'];

// url immagine da post thumbnail
$thumb_id = get_post_thumbnail_id();
$thumb_url_desktop = wp_get_attachment_image_src($thumb_id, 'pro_size_card', true);
$thumb_url_desktop[0];
 ?>
