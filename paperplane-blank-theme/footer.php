<?php
// Paperplane _blankTheme - template per footer.
wp_reset_query();
?>
<footer id="footer" class="bg-1 txt-6">
  <div class="wrapper">
    <div class="wrapper-padded">
      <div class="flex-hold flex-hold-3 margins-thin">

        <div class="flex-hold-child">
          <?php the_field( 'credits_and_more', 'options' ); ?>
        </div>

        <div class="flex-hold-child">
          <h5>menu - se non spunta il menu è perchè non è stato definito o impostato.</h5>
          <?php if ( has_nav_menu( 'footer-menu' ) ) {
            wp_nav_menu( array( 'theme_location' => 'footer-menu', 'container' => 'ul', 'menu_class' => 'footer-menu' ) );
          } ?>
        </div>

        <div class="flex-hold-child">
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

    </div>
  </div>
</footer>


<?php wp_footer(); ?>
</body>
</html>
