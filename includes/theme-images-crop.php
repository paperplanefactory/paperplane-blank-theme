<?php
// custom image size for featured images
add_theme_support( 'post-thumbnails' );
add_image_size( 'full_desk_retina', 3840, 9999);
add_image_size( 'full_desk', 1920, 9999);
add_image_size( 'round_image', 250, 250, true);
add_image_size( 'round_image_hd', 500, 500, true);
add_image_size( 'column', 500, 9999);
add_image_size( 'column_hd', 700, 9999);
add_image_size( 'slide', 900, 9999);
add_image_size( 'slide_hd', 1800, 9999);



add_image_size( 'content_picture', 768, 9999);
add_image_size( 'content_picture_cropped', 768, 400, true);
//add_image_size( 'logo_size', 200, 9999);
add_image_size( 'column', 500, 9999);
add_image_size( 'highlighted_sentence', 236, 9999);


add_image_size( 'opening_squared', 960, 960, true);
add_image_size( 'micro', 10, 9999);


function wpb_imagelink_setup() {
    $image_set = get_option( 'image_default_link_type' );
    if ($image_set !== 'none') {
        update_option('image_default_link_type', 'none');
    }
}
add_action('admin_init', 'wpb_imagelink_setup', 10);

// limito il numero di scelte per le immagini "in content"
add_filter('image_size_names_choose', 'my_image_sizes');
function my_image_sizes($sizes) {
unset( $sizes['medium']);
unset( $sizes['large']);
unset( $sizes['full']);
$addsizes = array(
  "full" => __( "Immagine originale, non ridimensionata. Usare solo per le immagini piccole allineate al centro."),
  "content_picture" => __( "Resized for text column")
);
$newsizes = array_merge($sizes, $addsizes);
return $newsizes;
}
