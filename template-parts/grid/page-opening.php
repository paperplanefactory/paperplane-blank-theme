<?php
global $content_fields;
if (is_archive()) {
  include(locate_template('template-parts/grid/page-opening/opening-archive.php'));
} else {
  $page_opening_layout = $content_fields['page_opening_layout'];
  $thumb_id = get_post_thumbnail_id();
  $thumb_url_desktop = wp_get_attachment_image_src($thumb_id, 'full_desk', true);
  $thumb_url_desktop_hd = wp_get_attachment_image_src($thumb_id, 'full_desk_hd', true);
  $page_opening_video = $content_fields['page_opening_video'];
  $page_breadcrumbs = $content_fields['page_breadcrumbs'];
  $page_scroll_button = $content_fields['page_scroll_button'];
  switch ($page_opening_layout) {
    case 'opening-fullscreen':
      $page_opening_layout_size = 'page-opening-fullscreen';
      break;
    case 'opening-almost-fullscreen':
      $page_opening_layout_size = 'page-opening-fullscreen-less';
      break;
    case 'opening-text-image':
      break;
  }
  $page_taxonomy_show = $content_fields['page_taxonomy_show'];
  if ($page_opening_layout === 'opening-fullscreen' || $page_opening_layout === 'opening-almost-fullscreen') {
    include(locate_template('template-parts/grid/page-opening/opening-fullscreen.php'));
  } elseif ($page_opening_layout === 'opening-text') {
    include(locate_template('template-parts/grid/page-opening/opening-text.php'));
  }
}
?>