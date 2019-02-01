<?php
$prev_post = get_adjacent_post(false, '', true);
if ( !empty ( $prev_post ) ) {
  $infinite_prev_post_id = $prev_post->ID;
}
?>
<div class="centil-post-header" url="<?php echo esc_url(the_permalink()); ?>" title="<?php echo esc_attr(the_title()); ?>"></div>
<div class="post-listing">
  <div class="wrapper">
    <div class="wrapper-padded">
      <div class="wrapper-padded-more">
        <div class="content-styled">
          <h1 class="singletitle"><?php the_title(); ?></h1>
          <?php the_content(); ?>
          <?php if( have_rows('modulo') ) : ?>
              <?php
              while ( have_rows('modulo') ) : the_row(); ?>
                <?php the_sub_field('testo'); ?>
            <?php endwhile; ?>
            <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</div>
<?php if ( !empty ( $infinite_prev_post_id ) ) : ?>
<div class="centil-infinite-scroll"><?php echo $infinite_prev_post_id; ?></div>
<?php else : ?>
  <div class="last-message">
    <h2>Fine!!</h2>
  </div>
<?php endif; ?>
