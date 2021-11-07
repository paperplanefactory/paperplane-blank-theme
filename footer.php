<?php
// Paperplane _blankTheme - template per footer.
wp_reset_query();
global $acf_options_parameter;
global $footer_wrapper;
global $static_bloginfo_stylesheet_directory;
?>
<footer id="footer" class="colors-black-bg">
  <div class="wrapper">
    <div class="wrapper-padded">
      <div class="<?php echo $footer_wrapper; ?>">
        <div class="flex-hold flex-hold-2 margins-wide verticalize">
          <div class="flex-hold-child">
            <div class="footer-logo">
              <a href="<?php echo home_url(); ?>" rel="bookmark" title="homepage - <?php echo get_bloginfo( 'name' ); ?>">
                <img data-src="<?php echo $static_bloginfo_stylesheet_directory; ?>/assets/images/site-logo-header.svg" class="lazy" />
              </a>
            </div>
          </div>
          <div class="flex-hold-child desktop-align-right">
            <?php if ( have_rows( 'global_socials', 'option' ) ) : ?>
              <ul class="inline-socials">
                <?php while ( have_rows( 'global_socials', 'option' ) ) : the_row(); ?>
                  <li>
                    <a href="<?php the_sub_field( 'global_socials_profile_url' ); ?>" class="icon <?php the_sub_field( 'global_socials_icon' ); ?>" target="_blank" aria-label="Visit <?php the_sub_field( 'global_socials_profile_url' ); ?>" rel="noopener">
                    </a>
                  </li>
                <?php endwhile; ?>
              </ul>
            <?php endif; ?>
          </div>
        </div>
        <?php
        if ( has_nav_menu( 'footer-menu' ) ) {
          wp_nav_menu( array( 'theme_location' => 'footer-menu', 'container' => 'ul', 'menu_class' => 'footer-menu' ) );
        }
        ?>
        <div class="flex-hold flex-hold-2 margins-wide verticalize">
          <div class="flex-hold-child">
            <?php the_field( 'footer_legal_notes', $acf_options_parameter ); ?>
          </div>
          <div class="flex-hold-child desktop-align-right">
            <?php the_field( 'footer_credits', $acf_options_parameter ); ?>
          </div>
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
