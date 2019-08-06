<?php
// Paperplane _blankTheme - template per footer.
wp_reset_query();
?>
<footer id="footer" class="bg-1 txt-6">
  <div class="wrapper clear-link-area">
    <div class="wrapper-padded">
      <div class="flex-hold flex-hold-3 margins-thin">

        <div class="flex-hold-child">
          <?php the_field( 'credits_and_more', 'options' ); ?>
        </div>

        <div class="flex-hold-child">
          <?php
          if ( has_nav_menu( 'header-menu' ) ) {
            wp_nav_menu( array( 'theme_location' => 'header-menu', 'container' => 'ul', 'menu_class' => 'header-menu' ) );
          }
          ?>
        </div>

        <div class="flex-hold-child">
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
                  <?php if ( get_sub_field( 'etichetta_partner_sponsor' ) ) : ?>
                    <?php the_sub_field( 'etichetta_partner_sponsor' ); ?>
                  <?php else : ?>
                    &nbsp;
                  <?php endif; ?>
                </div>
                <?php if ( get_sub_field( 'url_sito_partner_sponsor' ) ) : ?>
                    <div class="partner-logo no-the-100">
                      <a href="<?php the_sub_field( 'url_sito_partner_sponsor' ); ?>" target="_blank" aria-label="Visit <?php the_sub_field( 'url_sito_partner_sponsor' ); ?>" rel="noopener">
                      <picture>
                        <img data-src="<?php echo $logo_URL; ?>" src="<?php echo $logo_URL_micro; ?>" class="lazy" alt="logo" />
                      </picture>
                      </a>
                    </div>

                <?php else : ?>
                  <div class="partner-logo no-the-100">
                    <picture>
                      <img data-src="<?php echo $logo_URL; ?>" src="<?php echo $logo_URL_micro; ?>" class="lazy" alt="logo" />
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
