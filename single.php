<?php
// Paperplane _blankTheme - template per single posts.
get_header();
?>

<?php while ( have_posts() ) : the_post(); ?>
  <div class="wrapper-padded">
    <div class="wrapper-padded-more">
      <div class="wrapper-padded-more-650">
        <div class="content_styled">
          <?php paperplane_breadcrumbs(); ?>
          <h2><?php the_title(); ?></h2>
          <?php the_content(); ?>
        </div>
      </div>
    </div>
  </div>
<?php endwhile; ?>
<?php get_footer(); ?>
