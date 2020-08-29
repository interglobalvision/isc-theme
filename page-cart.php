<?php
get_header();
?>

<main id="main-content">
<?php
if (have_posts()) {
  while (have_posts()) {
    the_post();
?>
  <section class="gws-cart padding-bottom-large padding-top-mid mobile-margin-top">
    <div id="cart-items" class="gws-cart-items">
      <div class="gws-cart-item">
        <div class="grid-row">
          <div class="grid-row item-s-12 item-l-6 offset-l-1">
            <div class="grid-item item-s-6 margin-bottom-small">
              <div class="gws-cart-thumb"></div>
            </div>

            <div class="grid-item item-s-6 margin-bottom-small">
              <div class="gws-cart-title"></div>
            </div>
          </div>

          <div class="grid-row item-s-12 item-l-4">
            <div class="grid-item item-s-6 margin-bottom-small">
              <span>$<span class="gws-cart-item-subtotal"></span></span>
            </div>
            <div class="grid-item item-s-4 margin-bottom-small">
              <input type="number" min="1" max="100" class="gws-cart-quantity" />
            </div>
            <div class="grid-item item-s-2 margin-bottom-small">
              <a class="gws-cart-remove u-pointer">&times;</a>
            </div>
          </div>

          <div class="grid-item item-s-12 item-l-10 offset-l-1 margin-bottom-small">
            <div class="border"></div>
          </div>
        </div>
      </div>
    </div>
  </section>
<?php
  }
}
?>
</main>

<?php
get_footer();
?>
