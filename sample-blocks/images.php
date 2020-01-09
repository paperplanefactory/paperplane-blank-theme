<?php
$image_data = array(
    'image_type' => 'post_thumbnail', // options: post_thumbnail, acf_field, acf_sub_field
    'image_value' => 'immagine_acf', // se utilizzi un custom field indica qui il nome del campo
    'size_fallback' => 'full_desk'
);
$image_sizes = array( // qui sono definiti i ritagli o dimensioni. Devono corrispondere per numero a quanto dedinfito nella funzione nei parametri data-srcset o srcset
    'retina' => 'full_desk_retina',
    'desktop' => 'full_desk',
    'mobile' => 'content_picture',
    'micro' => 'micro'
);
print_theme_image( $image_data, $image_sizes );
?>

<?php
$image_data = array(
    'image_type' => 'post_thumbnail', // options: post_thumbnail, acf_field, acf_sub_field
    'image_value' => 'immagine_acf', // se utilizzi un custom field indica qui il nome del campo
    'size_fallback' => 'full_desk'
);
$image_sizes = array( // qui sono definiti i ritagli o dimensioni. Devono corrispondere per numero a quanto dedinfito nella funzione nei parametri data-srcset o srcset
    'retina' => 'full_desk_retina',
    'desktop' => 'full_desk',
    'mobile' => 'content_picture',
    'micro' => 'micro'
);
print_theme_image_justincase_nolazy( $image_data, $image_sizes );
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
