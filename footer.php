<?php
$options = get_site_option('_igv_site_options');
?>
  <footer id="footer" class="background-white padding-top-basic padding-bottom-large">
    <div class="container">
      <div class="grid-row">
        <div class="grid-item item-s-12 item-l-4 no-gutter grid-column justify-between">
          <div class="grid-item">
            <div class="not-mobile">
              <div class="margin-bottom-tiny"><span class="font-bold">ISCHiFi</span></div>
              <div><?php get_template_part('assets/logo.svg'); ?></div>
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
          <div class="grid-item margin-bottom-basic">
            <?php echo apply_filters('the_content', $options['hours']); ?>
          </div>
        <?php } ?>
          <div id="social-holder" class="grid-item no-gutter grid-row">
          <?php if (!empty($options['socialmedia_instagram'])) { ?>
            <div class="grid-item">
              <a href="https://instagram.com/<?php echo $options['socialmedia_instagram']; ?>" class="social-icon">
                <img src="<?php bloginfo('stylesheet_directory'); ?>/dist/img/social-instagram.png" />
              </a>
            </div>
          <?php } if (!empty($options['socialmedia_facebook_url'])) { ?>
            <div class="grid-item">
              <a href="<?php echo $options['socialmedia_facebook_url']; ?>" class="social-icon">
                <img src="<?php bloginfo('stylesheet_directory'); ?>/dist/img/social-facebook.png" />
              </a>
            </div>
          <?php } if (!empty($options['socialmedia_twitter'])) { ?>
            <div class="grid-item">
              <a href="https://twitter.com/<?php echo $options['socialmedia_twitter']; ?>" class="social-icon">
                <img src="<?php bloginfo('stylesheet_directory'); ?>/dist/img/social-twitter.png" />
              </a>
            </div>
          <?php } ?>
            <div>&nbsp;</div>
          </div>
        </div>
      </div>
    </div>
  </footer>

</section>

<div id="loader"><img src="<?php bloginfo('stylesheet_directory'); ?>/dist/img/loading.png" /></div>

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
