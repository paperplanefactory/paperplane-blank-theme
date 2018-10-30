<?php
// Paperplane _blankTheme - template per footer.
wp_reset_query();
?>
<div id="footer" class="bg-1 txt-6">
  <div class="wrapper">
    <div class="wrapper-padded">
      <div class="flex-hold flex-hold-3">
        <div class="flex-hold-child">
          <a href="<?php echo home_url(); ?>" rel="bookmark" title="homepage">
          &copy; <?php echo date("Y"); ?> <?php echo get_bloginfo( 'name' ); ?>
          </a>
        </div>
        <div class="flex-hold-child">
          <ul>
            <?php wp_nav_menu( array( 'theme_location' => 'footer-menu', 'menu_class' => 'foot-menu' ) ); ?>
          </ul>
        </div>
        <div class="flex-hold-child">
          <?php the_field( 'credits_and_more', 'options' ); ?>
          <?php if ( have_rows( 'global_socials', 'option' ) ) : ?>
            <ul class="inline-socials">
              <?php while ( have_rows( 'global_socials', 'option' ) ) : the_row(); ?>
                <li>
                  <a href="<?php the_sub_field( 'global_socials_profile_url' ); ?>" target="_blank">
                    <img src="<?php the_sub_field( 'global_socials_icona' ); ?>" />      
                  </a>
                </li>
              <?php endwhile; ?>
            </ul>
          <?php endif; ?>
        </div>
      </div>


<?php wp_footer();
?>
</body>
</html>
