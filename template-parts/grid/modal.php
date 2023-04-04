<?php
$content_fields = paperplane_content_transients($post->ID);
?>
<div id="paperplane-modal-js-<?php echo $post->ID; ?>"
  class="paperplane-modal paperplane-modal-js paperplane-modal-js-<?php echo $post->ID; ?> hidden <?php echo $content_fields['colore_di_sfondo_modal']; ?>"
  tabindex="<?php echo $post->ID; ?>" data-modal-close-id=".paperplane-modal-js-<?php echo $post->ID; ?>">
  <div class="modal-close-area modal-close-js" data-modal-close-id=".paperplane-modal-js-<?php echo $post->ID; ?>">
  </div>
  <div class="modal-box offerta-overlay-box-js" style="max-width: <?php echo $content_fields['modal_max_width']; ?>px">

    <?php if ($content_fields['modal_title']): ?>
      <div class="modal-title">
        <h3>
          <?php echo $content_fields['modal_title']; ?>
        </h3>
      </div>
    <?php endif; ?>
    <a href="#" class="modal-focus-<?php echo $post->ID; ?> section-anchor"></a>
    <a href="#" class="modal-close-button modal-close-js"
      data-modal-close-id=".paperplane-modal-js-<?php echo $post->ID; ?>"
      title="<?php _e('Chiudi questo pannello', 'paperPlane-blankTheme'); ?>"
      aria-label="<?php _e('Chiudi questo pannello', 'paperPlane-blankTheme'); ?>">
      <svg>
        <rect class="svg-button-bg" width="32" height="32" />
        <g transform="translate(2.5 3.5)">
          <line class="svg-button-line" x2="16" y2="16" transform="translate(5.5 4.5)" />
          <line class="svg-button-line" x1="16" y2="16" transform="translate(5.5 4.5)" />
        </g>
      </svg>
    </a>
    <div class="insider">
      <div class="inner-message inner-message-js">
        <div class="content-styled last-child-no-margin">
          <?php echo $content_fields['modal_content']; ?>
        </div>
      </div>
    </div>
  </div>
</div>