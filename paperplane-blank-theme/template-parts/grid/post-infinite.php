<div class="flex-hold-child grid-item-infinite">
  <div class="pad-top-2 pad-right-2 pad-bottom-2 pad-left-2">
    <a href="<?php the_permalink(); ?>">
      <?php get_template_part( 'template-parts/images/image-display-post-thumbnail' ); ?>
    </a>
    <h6><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h6>
  </div>
</div>
