<?php
// kill menus transients
// add_action('wp_update_nav_menu', 'paperplane_kill_menu_transients');
// add_action( 'save_post', 'paperplane_kill_menu_transients' );
function paperplane_kill_menu_transients($nav_menu_selected_id) {
  delete_transient( 'header_menu_transient' );
}
