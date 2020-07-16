<?php
$options = get_site_option('_igv_site_options');
?>
  <footer id="footer" class="background-white padding-top-basic padding-bottom-large">
    <div class="container">
      <div class="grid-row">
        <div class="grid-item item-s-12">
          <div class="not-mobile">
          </div>
        </div>
      <?php if (!empty($options['mailchimp_action'])) { ?>
        <div class="grid-item">
          <?php get_template_part('partials/mailchimp'); ?>
        </div>
      <?php } if (!empty($options['contact_address'])) { ?>
        <div class="grid-item">
          Address
        </div>
      <?php } if (!empty($options['footer_text'])) { ?>
        <div class="grid-item">
          Footer text
        </div>
      <?php } if (!empty($options['hours'])) { ?>
        <div class="grid-item">
          Hours
        </div>
      <?php } ?>
      </div>
    </div>
  </footer>

</section>

<div id="loader">LOADING</div>

<?php
get_template_part('partials/player');
get_template_part('partials/scripts');
get_template_part('partials/schema-org');
?>

</body>
</html>
