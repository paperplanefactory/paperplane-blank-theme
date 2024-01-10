<?php
//conto le parole del content - call in template: echo word_count();
function word_count() {
	$content = get_post_field( 'post_content', $post->ID );
	$word_count = str_word_count( strip_tags( $content ) );
	return $word_count;
}

function excerpt( $limit ) {
	$excerpt = explode( ' ', get_the_excerpt(), $limit );

	if ( count( $excerpt ) >= $limit ) {
		array_pop( $excerpt );
		$excerpt = implode( " ", $excerpt ) . '...';
	} else {
		$excerpt = implode( " ", $excerpt );
	}

	$excerpt = preg_replace( '`\[[^\]]*\]`', '', $excerpt );

	return $excerpt;
}

// page title generator
function twentytwelve_wp_title( $title, $sep ) {
	global $paged, $page;

	if ( is_feed() )
		return $title;

	// Add the site name.
	$title .= get_bloginfo( 'name' );

	// Add the site description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		$title = "$title $sep $site_description";

	// Add a page number if necessary.
	if ( $paged >= 2 || $page >= 2 )
		$title = "$title $sep " . sprintf( __( 'Page %s', 'twentytwelve' ), max( $paged, $page ) );

	return $title;
}
add_filter( 'wp_title', 'twentytwelve_wp_title', 10, 2 );

/**
 * Replaces the login header logo URL
 *
 * @param $url
 */
function namespace_login_headerurl( $url ) {
	$url = home_url( '/' );
	return $url;
}

//fix cut paste drama from https://jonathannicol.com/blog/2015/02/19/clean-pasted-text-in-wordpress/
add_filter( 'tiny_mce_before_init', 'paperplane_remove_paste_junk' );

/**
 * Customize TinyMCE's configuration
 *
 * @param   array
 * @return  array
 */
function paperplane_remove_paste_junk( $in ) {
	$in['paste_preprocess'] = "function(plugin, args){
    var whitelist = 'p,b,strong,i,em,h2,h3,h4,h5,h6,ul,li,ol,a,href';  // Strip all HTML tags except those we have whitelisted here
    var stripped = jQuery('<div>' + args.content + '</div>');
    var els = stripped.find('*').not(whitelist);
    for (var i = els.length - 1; i >= 0; i--) {
      var e = els[i];
      jQuery(e).replaceWith(e.innerHTML);
    }
    // Strip all class and id attributes
    stripped.find('*').removeAttr('id').removeAttr('class').removeAttr('style');
    args.content = stripped.html();    // Return the clean HTML
  }";
	return $in;
}