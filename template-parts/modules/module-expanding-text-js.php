<!-- module-expanding-text -->
<div class="wrapper module-expanding-text <?php echo $module['module_bg']; ?>">
  <a name="section-<?php echo $module_count; ?>" class="section-anchor"></a>
  <div class="<?php echo $module['module_vertical_top_space'] . ' ' . $module['module_vertical_bottom_space']; ?>">
    <div class="wrapper-padded">
      <div class="wrapper-padded-container">
        <div class="wrapper-padded-more-700">
          <?php if ($module['module_expanding_text_repeater']):
            foreach ($module['module_expanding_text_repeater'] as $expanding_block): ?>
              <div class="expanding-block">
                <div class="expander-top">
                  <button class="expander exp-open" aria-expanded="false"><span class="exp-plus"></span>
                    <?php echo $expanding_block['module_expanding_text_title']; ?>
                  </button>
                </div>
                <div class="expandable-content">
                  <div class="inner">
                    <div class="content-styled last-child-no-margin">
                      <a name="expandable-content-<?php echo $module_count; ?>" class="section-anchor"></a>
                      <?php echo $expanding_block['module_expanding_text_content']; ?>
                    </div>
                  </div>
                </div>
              </div>
            <?php endforeach; endif; ?>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- module-expanding-text -->