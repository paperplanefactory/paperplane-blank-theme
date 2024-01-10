<?php
$image_data = array(
	'image_type' => 'acf',
	// options: post_thumbnail, acf
	'image_value' => $module['nome_field']
	// se utilizzi un custom field indica qui il nome del campo con il formato $module['nome_field']
);
$image_appearance = array(
	// options: true, false
	'lazyload' => true,
	// options: sync, async
	'decoding' => 'async',
	// options: true, false - se false non mette contenitore intorno all'immagine
	'image-wrap' => true
);
$image_sizes = array(
	// qui sono definiti i ritagli o dimensioni. Devono corrispondere per numero a quanto dedinfito nella funzione nei parametri data-srcset o srcset
	'desktop_hd' => 'column_hd',
	'mobile_hd' => 'column_hd'
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