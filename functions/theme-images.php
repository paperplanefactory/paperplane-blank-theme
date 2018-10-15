<?php
// disabilito il ridimensionamento minimo di medium e large
function add_image_insert_override($sizes){
    unset( $sizes['medium']);
    unset( $sizes['large']);
    return $sizes;
}
add_filter('intermediate_image_sizes_advanced', 'add_image_insert_override' );

// custom image size for featured images
add_theme_support( 'post-thumbnails' );
add_image_size( 'full_desk', 1920, 9999);
add_image_size( 'content_picture', 768, 9999);

add_image_size( 'desktop_image', 1920, 800, true);
add_image_size( 'tablet_image', 768, 50, true);
add_image_size( 'mobile_image', 200, 600, true);

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
"content_picture" => __( "Content picture")
);
$newsizes = array_merge($sizes, $addsizes);
return $newsizes;
}
