<?php
// Paperplane _blankTheme - template per single posts.
get_header();
?>

<?php while ( have_posts() ) : the_post(); ?>
  <?php get_template_part( 'template-parts/single-contents/infinite-post' ); ?>
<?php endwhile; ?>
<div class="bottom-message">
  <h2>wait!!!</h2>
  </div>
</div>
<?php get_footer(); ?>
