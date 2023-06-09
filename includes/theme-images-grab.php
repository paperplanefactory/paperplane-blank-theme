<?php
function print_theme_image($image_data, $image_sizes)
{
  if (count($image_data) > 0) {
    $post_id = get_the_ID();
    $image_data_select = $image_data['image_type']; // post_thumbnail, acf_field or acf_sub_field
    $size_fallback = $image_data['size_fallback']; // crop to use as fallback
    if ($image_data_select === 'acf') { // ACF FIELD - be sure to set "image -> image array in ACF options"
      $thumb_id = $image_data['image_value']['ID']; // retrieve the image ID
    } elseif ($image_data_select === 'post_thumbnail') { // nomrmal featured image
      // retrieve post/page ID
      $thumb_id = get_post_thumbnail_id($post_id); // retrieve the image ID
    }
    if (isset($thumb_id)) {
      $attachment_title = get_the_title($thumb_id); // image title
      $attachment_alt = get_post_meta($thumb_id, '_wp_attachment_image_alt', true); // image alt text
      if (count($image_sizes) > 0) {
        $print_theme_image_cache_key = 'print_theme_image_cache_' . $thumb_id;
        $sharped_images = wp_cache_get($print_theme_image_cache_key); // check if array of images URL is set as cache
        if (false === $sharped_images) {
          $sharped_images = array(); // declare arry to use later in data-srcset
          foreach ($image_sizes as $image_size) {
            $thumb_url[$image_size] = wp_get_attachment_image_src($thumb_id, $image_size, true); // retrive array for desired size
            if ($thumb_url[$image_size][3] == true) { // check if cropped image exists
              $sharped_images[] = $thumb_url[$image_size][0]; // retrive image URL
              $filetype = wp_check_filetype($thumb_url[$image_size][0]);
            } else { // if cropped image does not exist
              $thumb_url[$image_size] = wp_get_attachment_image_src($thumb_id, $size_fallback, true); // retrive array for fallback size
              $sharped_images[] = $thumb_url[$image_size][0]; // retrive fallback image URL
              $filetype = wp_check_filetype($thumb_url[$image_size][0]);
            }
          }
          wp_cache_set($print_theme_image_cache_key, $sharped_images, 300); // set array of images URL as cache
        }
        // this is simple HTML - remember to use lazyload (https://github.com/verlok/lazyload) for better performance
        $html_image_output = '';
        $html_image_output .= '<div class="no-the-100">';
        $html_image_output .= '<picture>';
        $html_image_output .= '<source type="image/' . $filetype['ext'] . '" media="(max-width: 1023px)" srcset="' . $sharped_images[2] . ', ' . $sharped_images[3] . ' 2x" sizes="100vw">';
        $html_image_output .= '<source type="image/' . $filetype['ext'] . '" media="(min-width: 1024px)" srcset="' . $sharped_images[0] . ', ' . $sharped_images[1] . ' 2x" sizes="100vw">';
        $html_image_output .= '<img src="' . $sharped_images[4] . '" title="' . $attachment_title . '" alt="' . $attachment_alt . '" loading="lazy" decoding="async" width="' . $thumb_url[$image_size][1] . '" height="' . $thumb_url[$image_size][2] . '" />';
        $html_image_output .= '</picture>';
        $html_image_output .= '</div>';
        echo $html_image_output;
      }
    }
  }
}

// Per le immagini che sono all'interno del viewport iniziale
function print_theme_image_nolazy($image_data, $image_sizes)
{
  if (count($image_data) > 0) {
    $post_id = get_the_ID();
    $image_data_select = $image_data['image_type']; // post_thumbnail, acf_field or acf_sub_field
    $size_fallback = $image_data['size_fallback']; // crop to use as fallback
    if ($image_data_select === 'acf') { // ACF FIELD - be sure to set "image -> image array in ACF options"
      $thumb_id = $image_data['image_value']['ID']; // retrieve the image ID
    } elseif ($image_data_select === 'post_thumbnail') { // nomrmal featured image
      // retrieve post/page ID
      $thumb_id = get_post_thumbnail_id($post_id); // retrieve the image ID
    }
    if (isset($thumb_id)) {
      $attachment_title = get_the_title($thumb_id); // image title
      $attachment_alt = get_post_meta($thumb_id, '_wp_attachment_image_alt', true); // image alt text
      if (count($image_sizes) > 0) {
        $print_theme_image_cache_key = 'print_theme_image_cache_' . $thumb_id;
        $sharped_images = wp_cache_get($print_theme_image_cache_key); // check if array of images URL is set as cache
        if (false === $sharped_images) {
          $sharped_images = array(); // declare arry to use later in data-srcset
          foreach ($image_sizes as $image_size) {
            $thumb_url[$image_size] = wp_get_attachment_image_src($thumb_id, $image_size, true); // retrive array for desired size
            if ($thumb_url[$image_size][3] == true) { // check if cropped image exists
              $sharped_images[] = $thumb_url[$image_size][0]; // retrive image URL
              $filetype = wp_check_filetype($thumb_url[$image_size][0]);
            } else { // if cropped image does not exist
              $thumb_url[$image_size] = wp_get_attachment_image_src($thumb_id, $size_fallback, true); // retrive array for fallback size
              $sharped_images[] = $thumb_url[$image_size][0]; // retrive fallback image URL
              $filetype = wp_check_filetype($thumb_url[$image_size][0]);
            }
          }
          wp_cache_set($print_theme_image_cache_key, $sharped_images, 300); // set array of images URL as cache
        }
        // this is simple HTML - remember to use lazyload (https://github.com/verlok/lazyload) for better performance
        $html_image_output = '';
        $html_image_output .= '<div class="no-the-100">';
        $html_image_output .= '<picture>';
        $html_image_output .= '<source type="image/' . $filetype['ext'] . '" media="(max-width: 1023px)" srcset="' . $sharped_images[2] . ', ' . $sharped_images[3] . ' 2x" sizes="100vw">';
        $html_image_output .= '<source type="image/' . $filetype['ext'] . '" media="(min-width: 1024px)" srcset="' . $sharped_images[0] . ', ' . $sharped_images[1] . ' 2x" sizes="100vw">';
        $html_image_output .= '<img src="' . $sharped_images[4] . '" title="' . $attachment_title . '" alt="' . $attachment_alt . '" decoding="async" width="' . $thumb_url[$image_size][1] . '" height="' . $thumb_url[$image_size][2] . '" />';
        $html_image_output .= '</picture>';
        $html_image_output .= '</div>';
        echo $html_image_output;
      }
    }
  }
}


function print_theme_image_lazyslick($image_data, $image_sizes)
{
  if (count($image_data) > 0) {
    $image_data_select = $image_data['image_type']; // post_thumbnail, acf_field or acf_sub_field
    $size_fallback = $image_data['size_fallback']; // crop to use as fallback
    if ($image_data_select === 'acf') { // ACF FIELD - be sure to set "image -> image array in ACF options"
      $thumb_id = $image_data['image_value']['ID']; // retrieve the image ID
    } elseif ($image_data_select === 'post_thumbnail') { // nomrmal featured image
      $post_id = get_the_ID(); // retrieve post/page ID
      $thumb_id = get_post_thumbnail_id($post_id); // retrieve the image ID
    }
    if ($thumb_id != '') {
      $attachment_title = get_the_title($thumb_id); // image title
      $attachment_alt = get_post_meta($thumb_id, '_wp_attachment_image_alt', true); // image alt text
      if (count($image_sizes) > 0) {
        $print_theme_image_cache_key = 'print_theme_image_cache_' . $thumb_id;
        $sharped_images = wp_cache_get($print_theme_image_cache_key); // check if array of images URL is set as cache
        if (false === $sharped_images) {
          $sharped_images = array(); // declare arry to use later in data-srcset
          foreach ($image_sizes as $image_size) {
            $thumb_url[$image_size] = wp_get_attachment_image_src($thumb_id, $image_size, true); // retrive array for desired size
            if ($thumb_url[$image_size][3] == true) { // check if cropped image exists
              $sharped_images[] = $thumb_url[$image_size][0]; // retrive image URL
            } else { // if cropped image does not exist
              $thumb_url[$image_size] = wp_get_attachment_image_src($thumb_id, $size_fallback, true); // retrive array for fallback size
              $sharped_images[] = $thumb_url[$image_size][0]; // retrive fallback image URL
            }
          }
          wp_cache_set($print_theme_image_cache_key, $sharped_images, 300); // set array of images URL as cache
        }
        // this is simple HTML - remember to use lazyload (https://github.com/verlok/lazyload) for better performance
        $html_image_output = '';
        $html_image_output .= '<div class="no-the-100">';
        $html_image_output .= '<picture>';
        $html_image_output .= '<source media="(max-width: 1023px)" srcset="' . $sharped_images[2] . ', ' . $sharped_images[3] . ' 2x" sizes="100vw">';
        $html_image_output .= '<source media="(min-width: 1024px)" srcset="' . $sharped_images[0] . ', ' . $sharped_images[1] . ' 2x" sizes="100vw">';
        $html_image_output .= '<img src="' . $sharped_images[4] . '" title="' . $attachment_title . '" alt="' . $attachment_alt . '" loading="lazy" decoding="async" width="' . $thumb_url[$image_size][1] . '" height="' . $thumb_url[$image_size][2] . '" />';
        $html_image_output .= '</picture>';
        $html_image_output .= '</div>';
        echo $html_image_output;
      }
    }
  }
}

function paperplane_images_preload_add_meta_tags()
{
  global $post;
  $content_fields = paperplane_content_transients($post->ID);
  if ($content_fields) {
    $preload_media_meta = '';
    if (array_key_exists('page_opening_layout', $content_fields)) {
      $page_opening_layout = $content_fields['page_opening_layout'];
    }

    if ($page_opening_layout === 'opening-fullscreen' || $page_opening_layout === 'opening-almost-fullscreen') {
      $page_opening_video = $content_fields['page_opening_video'];
      if (array_key_exists('page_opening_image_desktop', $content_fields) && isset($content_fields['page_opening_image_desktop'])) {
        $page_opening_image_desktop = $content_fields['page_opening_image_desktop'];
      }
      if (array_key_exists('page_opening_image_mobile', $content_fields) && isset($content_fields['page_opening_image_mobile'])) {
        $page_opening_image_mobile = $content_fields['page_opening_image_mobile'];
      }
      $thumb_id = get_post_thumbnail_id($post->ID);
      if ($page_opening_image_desktop) {
        $thumb_url_desktop = wp_get_attachment_image_src($page_opening_image_desktop, 'full_desk_hd', true);
        $thumb_url_desktop = $thumb_url_desktop[0];
      } elseif ($thumb_id != 0) {
        $thumb_url_desktop = wp_get_attachment_image_src($thumb_id, 'full_desk_hd', true);
        $thumb_url_desktop = $thumb_url_desktop[0];
      }

      if ($page_opening_image_mobile) {
        $thumb_url_mobile = wp_get_attachment_image_src($page_opening_image_mobile, 'full_desk_hd', true);
        $thumb_url_mobile = $thumb_url_mobile[0];
      } elseif ($thumb_id != 0) {
        $thumb_url_mobile = wp_get_attachment_image_src($thumb_id, 'full_desk_hd', true);
        $thumb_url_mobile = $thumb_url_mobile[0];
      }
      if ($page_opening_video === 'no' && isset($thumb_url_desktop)) {
        $preload_media_meta .= '<link rel="preload" href="' . $thumb_url_desktop . '" as="image" media="(min-width: 1024px)" />' . "\n";
      }
      if ($page_opening_video === 'no' && isset($thumb_url_mobile)) {
        $preload_media_meta .= '<link rel="preload" href="' . $thumb_url_mobile . '" as="image" media="(max-width: 1023px)" />' . "\n";
      }
      echo $preload_media_meta;
    }
  }
}
add_action('wp_head', 'paperplane_images_preload_add_meta_tags');