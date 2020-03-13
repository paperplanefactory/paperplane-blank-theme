<?php
$thumb_id = get_post_thumbnail_id();
$thumb_url_desktop = wp_get_attachment_image_src($thumb_id, 'pro_size_card', true);
$page_opening_video = get_field( 'page_opening_video' );
$page_opening_layout = get_field( 'page_opening_layout' );
switch ( $page_opening_layout ) {
  case 'opening-fullscreen' :
  $page_opening_layout_size = 'page-opening-fullscreen';
  break;
  case 'opening-almost-fullscreen' :
  $page_opening_layout_size = 'page-opening-fullscreen-less';
  break;
  case 'cta-target-file' :
  $module_stripe_repeater_cta_url = get_field( 'module_stripe_repeater_cta_target_file' );
  $module_stripe_repeater_cta_url_target = '_blank';
  break;
}
$page_opening_cta_target = get_field( 'page_opening_cta_target' );
switch ( $page_opening_cta_target ) {
  case 'cta-target-internal' :
  $page_opening_cta_url = get_field( 'module_additional_elements_cta_target_internal' );
  $page_opening_cta_url_target = '_self';
  break;
  case 'cta-target-external' :
  $page_opening_cta_url = get_field( 'module_additional_elements_cta_target_external' );
  $page_opening_cta_url_target = '_blank';
  break;
  case 'cta-target-file' :
  $page_opening_cta_url = get_field( 'module_additional_elements_cta_target_file' );
  $page_opening_cta_url_target = '_blank';
  break;
}
 ?>
 <?php if ( $page_opening_layout === 'opening-fullscreen' || $page_opening_layout === 'opening-almost-fullscreen' ) : ?>
   <div class="wrapper page-opening">
     <div class="<?php echo $page_opening_layout_size; ?> fullscreen-cta <?php the_field( 'page_opening_text_align' ); ?> lazy coverize blended" data-bg="url('<?php echo $thumb_url_desktop[0]; ?>')" data-aos="zoom-out">
       <?php if ( $page_opening_video === 'si' ) : ?>
         <div class="fullscreen-video">
          <video class="lazy"  autoplay muted loop>
            <source type="video/mp4" data-src="<?php the_field( 'page_opening_video_mp4' ); ?>">
            <source type="video/ogg" data-src="<?php the_field( 'page_opening_video_ogg' ); ?>">
            <source type="video/webm" data-src="<?php the_field( 'page_opening_video_avi' ); ?>">
          </video>
        </div>
        <?php endif; ?>
         <div class="fullscreen-cta-aligner">
           <div class="wrapper">
             <div class="wrapper-padded">
               <div class="wrapper-padded-more">
                 <div class="fullscreen-cta-safe-padding <?php the_field( 'page_opening_text_align_horizontal' ); ?>" data-aos="fade-right">
                   <div class="last-child-no-margin txt-4">
                     <?php if ( get_field( 'page_opening_title' ) ) : ?>
                       <h1><?php the_field( 'page_opening_title' ); ?></h1>
                     <?php else : ?>
                       <h1><?php the_title(); ?></h1>
                     <?php endif; ?>
                     <?php if ( get_field( 'page_opening_subtitle' ) ) : ?>
                       <h2><?php the_field( 'page_opening_subtitle' ); ?></h2>
                     <?php endif; ?>
                   </div>

                   <?php if ( get_field( 'page_opening_cta_text' ) ) : ?>
                     <div class="cta-holder">
                       <a href="<?php echo $page_opening_cta_url; ?>" target="<?php echo $page_opening_cta_url_target; ?>" class="default-button dark-default-button allupper"><?php the_field( 'page_opening_cta_text' ); ?></a>
                     </div>
                   <?php endif; ?>
                 </div>
               </div>
             </div>
           </div>
         </div>


       <?php if ( $page_opening_layout === 'opening-fullscreen' ) : ?>
         <div id="intro-scroll-js" class="scroll-down">

         </div>
       <?php endif; ?>
     </div>
   </div>
   <div class="below-the-fold"></div>
 <?php endif; ?>
