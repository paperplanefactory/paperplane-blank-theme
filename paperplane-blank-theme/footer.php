<?php
// Paperplane _blankTheme - template per footer.
wp_reset_query();
if ( function_exists( 'PLL' ) ) {
  $show_options_again = get_field( 'show_options_again', pll_current_language('slug') );
}
else {
  $show_options_again = get_field( 'show_options_again', 'any-lang' );
}
?>
<footer id="footer" class="bg-1 txt-6">
  <div class="wrapper">
    <div class="wrapper-padded">
      <div class="flex-hold flex-hold-3 margins-thin">

        <div class="flex-hold-child">
          <?php the_field( 'credits_and_more', 'options' ); ?>
          <a href="#" class="show-paperplane-gdpr"><?php echo $show_options_again;?></a>
        </div>

        <div class="flex-hold-child">
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
                    <i class="<?php the_sub_field( 'global_socials_icona' ); ?>"></i>
                  </a>
                </li>
              <?php endwhile; ?>
            </ul>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>



  <?php if ( have_rows( 'aggiungi_modifica_sponsor_partner', 'option' ) ) : ?>
    <div class="wrapper bg-7 txt-1">
      <div class="wrapper-padded">
        <div class="wrapper-padded-more">
          <div class="wrapper-padded-more-840">
            <div class="flex-hold parnter-grid flex-hold-5 margins-wide">
              <?php while ( have_rows( 'aggiungi_modifica_sponsor_partner', 'option' ) ) : the_row();
              $logo = get_sub_field( 'logo_partner' );
              $logo_URL = $logo['sizes']['logo_size'];
              $logo_URL_micro = $logo['sizes']['micro'];
               ?>
              <div class="flex-hold-child partner-box">
                <div class="partner-label cta-1">
                  <?php the_sub_field( 'etichetta_partner_sponsor' ); ?>
                </div>
                <?php if ( get_sub_field( 'url_sito_partner_sponsor' ) ) : ?>

                    <div class="partner-logo no-the-100">
                      <a href="<?php the_sub_field( 'url_sito_partner_sponsor' ); ?>" target="_blank">
                      <picture>
                        <img data-src="<?php echo $logo_URL; ?>" src="<?php echo $logo_URL_micro; ?>" class="lazy" />
                      </picture>
                      </a>
                    </div>

                <?php else : ?>
                  <div class="partner-logo no-the-100">
                    <picture>
                      <img data-src="<?php echo $logo_URL; ?>" src="<?php echo $logo_URL_micro; ?>" class="lazy" />
                    </picture>
                  </div>
                <?php endif; ?>
              </div>
            <?php endwhile; ?>
            </div>
          </div>
        </div>

      </div>
    </div>
  <?php endif; ?>

</footer>


<?php wp_footer(); ?>
</body>
</html>
