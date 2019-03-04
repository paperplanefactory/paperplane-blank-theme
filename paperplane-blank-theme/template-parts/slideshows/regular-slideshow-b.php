<?php
$args_filter_posts = array(
  'post_type' => 'post',
  'posts_per_page' => -1,
  //'category_name' => 'test',
);
$my_filter_posts = get_posts( $args_filter_posts );
?>
<?php if ( !empty ( $my_filter_posts ) ) : ?>


<div class="slider-is-true regular-slideshow">
<input type="hidden" class="slideshow-selector-2" value="postslider-2" />
<ul class="slideshow-ul verticalize postslider-2">
  <?php foreach ( $my_filter_posts as $post ) : setup_postdata ($post ); ?>
    <li>
      <div class="image-block">
        <?php get_template_part( 'template-parts/images/image-display-1' ); ?>
      </div>
    </li>
  <?php endforeach; wp_reset_postdata(); ?>

</ul>
<div class="fullscreen-activator fullscreen-activator-2">
</div>
</div>
<?php endif; ?>
