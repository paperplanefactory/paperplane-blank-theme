<!-- module-columns -->
<div class="wrapper module-columns <?php echo $module['module_bg']; ?>">
  <a name="section-<?php echo $module_count; ?>" class="section-anchor"></a>
  <div class="<?php echo $module['module_vertical_top_space'] . ' ' . $module['module_vertical_bottom_space']; ?>">
    <div class="wrapper-padded">
      <div class="wrapper-padded-container">
        <div class="flex-hold flex-hold-<?php echo $module['module_columns_columns_number']; ?> margins-wide">
          <?php
          if ($module['module_columns_columns_repeater']):
            foreach ($module['module_columns_columns_repeater'] as $column):
              $module_columns_columns_repeater_image = $column['module_columns_columns_repeater_image'];
              $module_columns_columns_repeater_image_format = $column['module_columns_columns_repeater_image_format'];
              $module_columns_columns_repeater_image_URL = $module_columns_columns_repeater_image['url'];
              ?>
              <div class="flex-hold-child module-column-box">
                <div class="<?php echo $column['module_columns_columns_repeater_align']; ?>">
                  <?php if ($module_columns_columns_repeater_image != ''): ?>
                    <div class="column-image">
                      <?php paperplane_theme_cta_absl_advanced($column['paperplane_theme_cta_module_columns']); ?>
                      <?php if ($module_columns_columns_repeater_image_format === 'normal-image'): ?>
                        <?php
                        $image_data = array(
                          'image_type' => 'acf',
                          // options: post_thumbnail, acf
                          'image_value' => $column['module_columns_columns_repeater_image'],
                          // se utilizzi un custom field indica qui il nome del campo
                          'size_fallback' => 'column'
                        );
                        $image_sizes = array(
                          // qui sono definiti i ritagli o dimensioni. Devono corrispondere per numero a quanto dedinfito nella funzione nei parametri data-srcset o srcset
                          'desktop_default' => 'column',
                          'desktop_hd' => 'column_hd',
                          'mobile_default' => 'column',
                          'mobile_hd' => 'column_hd',
                          'lazy_placheholder' => 'micro'
                        );
                        print_theme_image($image_data, $image_sizes);
                        ?>
                      <?php elseif ($module_columns_columns_repeater_image_format === 'round-image'): ?>
                        <div class="image-rounder">
                          <?php paperplane_theme_cta_absl_advanced($column['paperplane_theme_cta_module_columns']); ?>
                          <?php
                          $image_data = array(
                            'image_type' => 'acf',
                            // options: post_thumbnail, acf
                            'image_value' => $column['module_columns_columns_repeater_image'],
                            // se utilizzi un custom field indica qui il nome del campo
                            'size_fallback' => 'round_image'
                          );
                          $image_sizes = array(
                            // qui sono definiti i ritagli o dimensioni. Devono corrispondere per numero a quanto dedinfito nella funzione nei parametri data-srcset o srcset
                            'desktop_default' => 'round_image',
                            'desktop_hd' => 'round_image_hd',
                            'mobile_default' => 'round_image',
                            'mobile_hd' => 'round_image',
                            'lazy_placheholder' => 'micro_cut'
                          );
                          print_theme_image($image_data, $image_sizes);
                          ?>
                        </div>
                      <?php else: ?>
                        <div class="image-icon">
                          <?php paperplane_theme_cta_absl_advanced($column['paperplane_theme_cta_module_columns']); ?>
                          <?php
                          $image_data = array(
                            'image_type' => 'acf',
                            // options: post_thumbnail, acf
                            'image_value' => $column['module_columns_columns_repeater_image'],
                            // se utilizzi un custom field indica qui il nome del campo
                            'size_fallback' => 'column_icon'
                          );
                          $image_sizes = array(
                            // qui sono definiti i ritagli o dimensioni. Devono corrispondere per numero a quanto dedinfito nella funzione nei parametri data-srcset o srcset
                            'desktop_default' => 'column_icon',
                            'desktop_hd' => 'column_icon_hd',
                            'mobile_default' => 'column_icon',
                            'mobile_hd' => 'column_icon_hd',
                            'lazy_placheholder' => 'micro'
                          );
                          print_theme_image($image_data, $image_sizes);
                          ?>
                        </div>
                      <?php endif; ?>
                      </a>
                    </div>
                  <?php endif; ?>
                  <?php if ($column['module_columns_columns_repeater_counter_value']): ?>
                    <div class="counter">
                      <?php if ($column['module_columns_columns_repeater_counter_value_before']): ?>
                        <h3>
                          <?php echo $column['module_columns_columns_repeater_counter_value_before']; ?>
                        </h3>
                      <?php endif; ?>
                      <h2 class="as-h1 count just-number count-pre"
                        data-bar-number="<?php echo $column['module_columns_columns_repeater_counter_value']; ?>">0</h1>
                        <?php if ($column['module_columns_columns_repeater_counter_value_after']): ?>
                          <h3>
                            <?php echo $column['module_columns_columns_repeater_counter_value_after']; ?>
                          </h3>
                        <?php endif; ?>
                        <?php if ($column['module_columns_columns_repeater_counter_description']): ?>
                          <h4>
                            <?php echo $column['module_columns_columns_repeater_counter_description']; ?>
                          </h4>
                        <?php endif; ?>
                    </div>
                  <?php endif; ?>
                  <?php if ($column['module_columns_columns_repeater_content']): ?>
                    <div class="content-styled last-child-no-margin">
                      <?php echo $column['module_columns_columns_repeater_content']; ?>
                    </div>
                  <?php endif; ?>
                  <?php paperplane_theme_cta_advanced($column['paperplane_theme_cta_module_columns']); ?>
                </div>
              </div>
            <?php endforeach; endif; ?>
        </div>
        <?php paperplane_theme_cta_advanced($module['paperplane_theme_cta']); ?>
      </div>
    </div>
  </div>
</div>
<!-- module-columns -->