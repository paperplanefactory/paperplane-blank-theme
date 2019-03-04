<?php
$args_filter_posts = array(
  'post_type' => 'post',
  'posts_per_page' => -1
);
$my_filter_posts = get_posts( $args_filter_posts );
?>
<?php if ( !empty ( $my_filter_posts ) ) : ?>


<div class="slider-is-true regular-slideshow">
<input type="hidden" class="slideshow-selector-1" value="postslider-1" />
<ul class="slideshow-ul postslider verticalize postslider-1">
  <?php foreach ( $my_filter_posts as $post ) : setup_postdata ($post ); ?>
    <li>
      <div class="image-block">
        <?php get_template_part( 'template-parts/images/image-display-1' ); ?>
      </div>
    </li>
  <?php endforeach; wp_reset_postdata(); ?>

</ul>
<div class="fullscreen-activator fullscreen-activator-1">
</div>
</div>
<?php endif; ?>
