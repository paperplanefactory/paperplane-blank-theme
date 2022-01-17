<!-- module-text -->
<?php
global $cta_align_class;
$analize_content = get_sub_field( 'module_text' );
if ( strpos( $analize_content, 'text-align: center;' ) ) {
  $cta_align_class = 'aligncenter';
}
elseif ( strpos( $analize_content, 'text-align: right;' ) ) {
  $cta_align_class = 'alignright';
}
else {
  $cta_align_class = '';
}
 ?>
<section class="wrapper module-text <?php the_sub_field( 'module_bg' ); ?>">
  <a name="section-<?php echo $module_count; ?>" class="section-anchor"></a>
  <div class="<?php the_sub_field( 'module_vertical_top_space' ); ?> <?php the_sub_field( 'module_vertical_bottom_space' ); ?>">
    <div class="wrapper-padded">
      <div class="wrapper-padded-container">
        <div class="wrapper-padded-more-700">
          <div class="content-styled last-child-no-margin">
            <?php the_sub_field( 'module_text' ); ?>
          </div>
          <?php get_template_part( 'template-parts/modules/module-cta-default' ); ?>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- module-text -->
