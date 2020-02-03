<?php
// custom image size for featured images
add_theme_support( 'post-thumbnails' );
add_image_size( 'full_desk_retina', 3840, 9999);
add_image_size( 'full_desk', 1920, 9999);
add_image_size( 'content_picture', 768, 9999);
add_image_size( 'content_picture_cropped', 768, 400, true);
add_image_size( 'logo_size', 200, 9999);
add_image_size( 'micro', 10, 9999);


function wpb_imagelink_setup() {
    $image_set = get_option( 'image_default_link_type' );
    if ($image_set !== 'none') {
        update_option('image_default_link_type', 'none');
    }
}
add_action('admin_init', 'wpb_imagelink_setup', 10);
