<?php
get_header();
$default_promo = gws_get_option('_gws_default_promo');
?>
<main id="main-content">
  <section class="padding-top-mid mobile-margin-top">
    <div class="container">
      <div class="grid-row">
        <div class="grid-item">
          <?php echo !empty($default_promo) ? $default_promo : ''; ?>
        </div>
      </div>
    </div>
  </section>
</main>
<?php
get_footer();
?>
