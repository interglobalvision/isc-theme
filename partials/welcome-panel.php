<?php
$options = get_site_option('_igv_site_options');
?>

<div id="welcome-panel" class="grid-row align-items-center align-content-center padding-top-mid padding-bottom-mid">
  <?php if (!empty($options['welcome_text'])) { ?>
  <div id="welcome-content" class="grid-item item-s-8 font-mono">
    <?php echo apply_filters('the_content', $options['welcome_text']); ?>
  </div>
  <?php } ?>
  <div class="grid-item item-s-8">
    <p>Our website uses cookies<br><a href="<?php echo home_url('privacy-policy'); ?>" class="font-size-small">Read our privacy policy.</a></p>
  </div>
  <div id="close-welcome"><img class="close-welcome" src="<?php bloginfo('stylesheet_directory'); ?>/dist/img/close.png" /></div>
</div>
