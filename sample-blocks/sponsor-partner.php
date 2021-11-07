<?php if ( have_rows( 'aggiungi_modifica_sponsor_partner', 'option' ) ) : ?>
  <div class="wrapper bg-7 txt-1">
    <div class="wrapper-padded">
      <div class="wrapper-padded-container">
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
