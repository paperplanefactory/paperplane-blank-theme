<?php
// Paperplane _blankTheme - template per footer.
wp_reset_query();
global $acf_options_parameter;
?>
<footer id="footer" class="combo-1">
  <div class="wrapper">
    <div class="wrapper-padded">
      <div class="footer-structure-1">

        <div class="block logo">
          <div class="logo">
            <a href="<?php echo home_url(); ?>" rel="bookmark" title="homepage - <?php echo get_bloginfo( 'name' ); ?>" class="absl"></a>
          </div>
        </div>

        <div class="block menu allupper">
          <?php
          if ( has_nav_menu( 'footer-menu' ) ) {
            wp_nav_menu( array( 'theme_location' => 'footer-menu', 'container' => 'ul', 'menu_class' => 'footer-menu' ) );
          }
          ?>
        </div>

        <div class="block social">
          <?php if ( have_rows( 'global_socials', 'option' ) ) : ?>
            <ul class="inline-socials">
              <?php while ( have_rows( 'global_socials', 'option' ) ) : the_row(); ?>
                <li>
                  <a href="<?php the_sub_field( 'global_socials_profile_url' ); ?>" target="_blank" aria-label="Visit <?php the_sub_field( 'global_socials_profile_url' ); ?>" rel="noopener">
                    <i class="<?php the_sub_field( 'global_socials_icona' ); ?>" aria-hidden="true"></i>
                  </a>
                </li>
              <?php endwhile; ?>
            </ul>
          <?php endif; ?>
        </div>
        <div class="block texts">
          <?php the_field( 'footer_fields_texts_1', $acf_options_parameter ); ?>
        </div>
      </div>
    </div>
  </div>
</footer>

<!--
<div class="preload-container">
  <div class="sk-folding-cube">
    <div class="sk-cube1 sk-cube"></div>
    <div class="sk-cube2 sk-cube"></div>
    <div class="sk-cube4 sk-cube"></div>
    <div class="sk-cube3 sk-cube"></div>
  </div>
</div>
-->
<?php wp_footer(); ?>
</body>
</html>
