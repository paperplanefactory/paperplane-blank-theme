<?php
// contatore
global $module_count;
$module_count++;
 ?>

 <div class="fullscreen-slideshow modulo-slideshow<?php echo $module_count; ?>">
   <input type="hidden" class="fullscreen-slideshow-selector" value=".postslider<?php echo $module_count; ?>" />
   <input type="hidden" class="fullscreen-slideshow-counter" value="<?php echo $module_count; ?>" />
   <ul id="postsliderIDfull<?php echo $module_count; ?>" class="postslider<?php echo $module_count; ?>">
     <?php
     $args_filter_posts = array(
       'post_type' => 'post',
       'posts_per_page' => -1
     );
     $my_filter_posts = get_posts( $args_filter_posts );
     ?>
     <?php if ( !empty ( $my_filter_posts ) ) : ?>
       <?php foreach ( $my_filter_posts as $post ) : setup_postdata ($post ); ?>
         <li class="fullscreen-slideshow-li">
           <div class="image-block">
             <a href="<?php the_permalink(); ?>">
               <?php get_template_part( 'template-parts/images/image-display-1' ); ?>
             </a>
           </div>
           <div class="text-block">
             <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
           </div>
         </li>
       <?php endforeach; wp_reset_postdata(); endif; ?>
   </ul>
 </div>
 <script>
 var myLazyLoad<?php echo $module_count; ?> = new LazyLoad({
     container: document.getElementById('postsliderIDfull<?php echo $module_count; ?>')
 });
 </script>
