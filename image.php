<?php
/**
 * The template for displaying image attachments.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */

get_header();
while ( have_posts() ) : the_post();
$excerpt = get_the_excerpt();
$parent = get_post_field( 'post_parent', $id);
//function to get next or previous keys in an array
function array_navigate($array, $key){
    $keys = array_keys($array);
    $index = array_flip($keys);
    $return = array();
    $return['prev'] = (isset($keys[$index[$key]-1])) ? $keys[$index[$key]-1] : end($keys);
    $return['next'] = (isset($keys[$index[$key]+1])) ? $keys[$index[$key]+1] : current($keys);
    return $return;
}

function previous_attachment_ID($att_post){
    //get the attachments which share the same post parent
    $images =& get_children('post_type=attachment&post_mime_type=image&output=ARRAY_N&orderby=menu_order&order=ASC&post_parent='.$att_post->post_parent);
    if($images){
        //get the id of the previous attachment
        $ppid_arr = array_navigate($images, $att_post->ID);
        $ppid = $ppid_arr['prev'];
        return $ppid;
    }
    return false;
}

//previous attachment link function
function prev_att_link($att_post=null){
    if($att_post == null){
        global $post;
        $att_post = get_post($post);
    }
    $ppid = previous_attachment_ID($att_post);
    if($ppid != false){
        return '<a href="' . get_attachment_link($ppid) . '" class="previous-attachment-link"></a>';
    } else {
        //there is no previous link
        return false;
    }
}

function next_attachment_ID($att_post){
    //get the attachments which share the same post parent
    $images =& get_children('post_type=attachment&post_mime_type=image&output=ARRAY_N&orderby=menu_order&order=ASC&post_parent='.$att_post->post_parent);
    if($images){
        //get the id of the next attachment
        $ppid_arr = array_navigate($images, $att_post->ID);
        $ppid = $ppid_arr['next'];
        return $ppid;
    }
    return false;
}

//next attachment link function
function next_att_link($att_post=null){
    if($att_post == null){
        global $post;
        $att_post = get_post($post);
    }
    $ppid = next_attachment_ID($att_post);
    if($ppid != false){
        return '<a href="' . get_attachment_link($ppid) . '" class="next-attachment-link"></a>';
    } else{
        return false;
    }
}





/**
 * Grab the IDs of all the image attachments in a gallery so we can get the URL of the next adjacent image in a gallery,
 * or the first image (if we're looking at the last image in a gallery), or, in a gallery of one, just the link to that image file
 */
 $attachments = array_values( get_children( array(
   'post_parent' => $post->post_parent,
   'post_status' => 'inherit',
   'post_type' => 'attachment',
   'post_mime_type' => 'image',
   'order' => 'ASC',
   'orderby' => 'menu_order ID',
   'exclude' => $thumb_ID )
   ) );
 foreach ( $attachments as $k => $attachment ) :
 	if ( $attachment->ID == $post->ID )
 		break;
 endforeach;

$k++;
$total_attachments = count( $attachments );
// If there is more than 1 attachment in a gallery
if ( count( $attachments ) > 1 ) :
	if ( isset( $attachments[ $k ] ) ) :
		// get the URL of the next image attachment
		$next_attachment_url = get_attachment_link( $attachments[ $k ]->ID );
	else :
		// or get the URL of the first image attachment
		$next_attachment_url = get_attachment_link( $attachments[ 0 ]->ID );
	endif;
else :
	// or, if there's only 1 image, get the URL of the image
	$next_attachment_url = wp_get_attachment_url();
endif;










if ( $parent != 0 ) {
  $args_original = array(
   'post_type' => 'picture',
   'include' => $parent
   );
  $original_post = get_posts( $args_original );
  foreach ($original_post as $post) : setup_postdata($post);
  $i_am_number = $post->ID;
  $original_title = get_the_title();
  $original_content = get_field('informazioni_aggiuntive');
  $categories = get_the_category();
  $category_id = $categories[0]->cat_ID;
  $category_link = get_category_link( $category_id );
  $next_post_url = get_permalink( get_adjacent_post(true,'',false)->ID );
  $previous_post_url = get_permalink( get_adjacent_post(true,'',true)->ID );
  $current_post_url = get_permalink();
  endforeach;
  wp_reset_query();
}
?>
<?php
// smartphone
if( $isMobile == 1 ) {
  $image_attributes = wp_get_attachment_image_src( $attachment_id, 'content_picture' );
}
// tablet
elseif( $isTablet == 1 ) {
  $image_attributes = wp_get_attachment_image_src( $attachment_id, 'full_tab' );
}
// desktop
elseif ( $isDesktop == 1 ) {
  $image_attributes = wp_get_attachment_image_src( $attachment_id, 'full_desk' );
}
?>
<div class="picture-fullscreen bg-4">
  <div class="title-holder">
    <div class="wrapper">
      <div class="wrapper-padded">
        <h1><?php echo $original_title; ?></h1>
      </div>
    </div>
  </div>
    <div class="absl_swipe"></div>
    <div class="picture_prev" title="previous image">
      <?php echo prev_att_link(); ?><span>&#xab;</span>
    </div>
    <div class="picture_next" title="next image">
      <?php echo next_att_link(); ?><span>&#xbb;</span>
    </div>
  <div class="image-holder bg-3 lazy" data-original="<?php echo $image_attributes[0] ?>" role="img" aria-label="<?php the_title(); ?> | <?php bloginfo( 'name' ); ?>"><div class="lazy-placehoder"></div></div>
  <div class="info-holder">
    <div class="wrapper">
      <div class="wrapper-padded cta-2">
        <span class="counter"><?php echo $k . ' / ' . $total_attachments; ?></span>
        <?php if ( $excerpt != "" ) { echo ' - '.$excerpt; } ?>
      </div>
    </div>
  </div>
</div>
<?php if ( $parent != 0 ) : ?>
  <div class="wrapper">
    <div class="wrapper-padded">
      <div class="wrapper-padded-more">
        <?php include( locate_template ( 'page-templates/gallery_thumbs.php' ) ); ?>
        <?php foreach ($original_post as $post) : setup_postdata($post); ?>
          <div class="content-styled">
            <?php the_content(); ?>
          </div>
        <?php endforeach; wp_reset_query(); ?>
      </div>
    </div>
  </div>
<?php endif; ?>
<?php
endwhile; ?>
<?php get_footer(); ?>
