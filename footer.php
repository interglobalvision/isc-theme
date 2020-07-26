<?php
$options = get_site_option('_igv_site_options');
?>
  <footer id="footer" class="background-white padding-top-basic padding-bottom-large">
    <div class="container">
      <div class="grid-row">
        <div class="grid-item item-s-12 item-l-4 no-gutter grid-column justify-between">
          <div class="grid-item">
            <div class="not-mobile">
              <span class="font-bold">Logo</span>
            </div>
          </div>
        <?php if (!empty($options['mailchimp_action'])) { ?>
          <div class="grid-item">
            <?php get_template_part('partials/mailchimp'); ?>
          </div>
        <?php } ?>
        </div>
        <div class="grid-item item-s-12 item-l-4 no-gutter grid-column">
        <?php if (!empty($options['contact_address'])) { ?>
          <div class="grid-item">
            <?php echo apply_filters('the_content', $options['contact_address']); ?>
          </div>
        <?php } if (!empty($options['footer_text'])) { ?>
          <div class="grid-item">
            <?php echo apply_filters('the_content', $options['footer_text']); ?>
          </div>
        <?php } ?>
        </div>
        <div class="grid-item item-s-12 item-l-4 no-gutter grid-column">
        <?php if (!empty($options['hours'])) { ?>
          <div class="grid-item">
            <?php echo apply_filters('the_content', $options['hours']); ?>
          </div>
        <?php } ?>
          <div id="social-holder" class="grid-item no-gutter grid-row margin-top-basic">
            <div class="grid-item">Social Media</div>
            <div class="grid-item">Social Media</div>
            <div>&nbsp;</div>
          </div>
        </div>
      </div>
    </div>
  </footer>

</section>

<div id="loader">LOADING</div>

<?php
if (!is_search()) {
  get_template_part('partials/search-panel');
}
get_template_part('partials/player');
get_template_part('partials/scripts');
get_template_part('partials/schema-org');
?>

</body>
</html>
