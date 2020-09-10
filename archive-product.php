<?php
get_header();
$promo_message = gws_get_option('_gws_shop_promo_message');
?>
<main id="main-content">
  <section class="padding-top-mid mobile-margin-top">
    <div class="container">
      <div class="grid-row">
        <div class="grid-item">
          <?php echo !empty($promo_message) ? $promo_message : ''; ?>
        </div>
      </div>
    </div>
  </section>
</main>
<?php
get_footer();
?>
