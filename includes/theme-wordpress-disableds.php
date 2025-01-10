<?php
// Disabilita Gutenberg
add_filter( 'use_block_editor_for_post', '__return_false' );

// Disabilita anche per i widget
add_filter( 'use_widgets_block_editor', '__return_false' );

// remove junk from head
remove_action( 'wp_head', 'rsd_link' );
remove_action( 'wp_head', 'wp_generator' );
remove_action( 'wp_head', 'feed_links', 2 );
remove_action( 'wp_head', 'index_rel_link' );
remove_action( 'wp_head', 'wlwmanifest_link' );
remove_action( 'wp_head', 'feed_links_extra', 3 );
remove_action( 'wp_head', 'start_post_rel_link', 10, 0 );
remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 );
remove_action( 'wp_head', 'adjacent_posts_rel_link', 10, 0 );
add_filter( 'wp_img_tag_add_auto_sizes', '__return_false' );

function papperplane_disable_useless_styles() {
	wp_deregister_style( 'classic-theme-styles' );
	wp_dequeue_style( 'classic-theme-styles' );
	wp_dequeue_style( 'global-styles' );
	wp_dequeue_style( 'svg-icon-style-inline-css' );
	wp_dequeue_style( 'wp-block-library' );
	wp_dequeue_style( 'safe-svg-svg-icon-style' );
	wp_deregister_style( 'safe-svg-svg-icon-style' );
}
add_filter( 'wp_enqueue_scripts', 'papperplane_disable_useless_styles', 100 );