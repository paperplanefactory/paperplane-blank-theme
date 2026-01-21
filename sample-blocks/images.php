<?php
$image_data = array(
	'image_type' => 'acf',
	'image_value' => $field_name['video_cover']
);
$image_appearance = array(
	'lazyload' => true,
	'decoding' => 'async',
	'image-wrap' => false,
	'image-wrap-custom-class' => ''

);
$image_sizes = array(
	'desktop_hd' => 'column_hd',
	'mobile_hd' => 'column'
);
print_theme_image( $image_data, $image_appearance, $image_sizes );
?>


<?php
// url immagine da ACF
$scegli_immagine = get_sub_field( 'scegli_immagine' );
$scegli_immagine_URL = $scegli_immagine['sizes']['full_desk'];

// url immagine da post thumbnail
$thumb_id = get_post_thumbnail_id();
$thumb_url_desktop = wp_get_attachment_image_src( $thumb_id, 'pro_size_card', true );
$thumb_url_desktop[0];
?>