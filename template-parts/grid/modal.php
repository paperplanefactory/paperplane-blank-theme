<div class="paperplane-modal paperplane-modal-js-<?php echo get_the_ID(); ?> hidden <?php the_field( 'colore_di_sfondo_modal' ); ?>">
    <div class="modal-close-area modal-close-js" data-modal-close-id=".paperplane-modal-js-<?php echo get_the_ID(); ?>"></div>
      <div class="modal-box offerta-overlay-box-js" style="max-width: <?php the_field( 'modal_max_width'); ?>px">
        <?php if ( get_field( 'modal_title') ) : ?>
          <div class="modal-title">
            <h3><?php the_field( 'modal_title'); ?></h3>
          </div>
        <?php endif; ?>

				<div class="modal-close-button modal-close-js" data-modal-close-id=".paperplane-modal-js-<?php echo get_the_ID(); ?>">
          <svg>
            <rect class="svg-button-bg" width="32" height="32"/>
            <g transform="translate(2.5 3.5)">
              <line class="svg-button-line" x2="16" y2="16" transform="translate(5.5 4.5)"/>
              <line class="svg-button-line" x1="16" y2="16" transform="translate(5.5 4.5)"/>
            </g>
          </svg>
        </div>
        <div class="insider">
          <div class="inner-message inner-message-js">
            <?php the_field( 'modal_content' ); ?>
          </div>
        </div>
      </div>
  </div>
