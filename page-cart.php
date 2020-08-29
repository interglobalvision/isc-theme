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
    <div class="container">
      <div id="cart-items" class="gws-cart-items">
        <div class="gws-cart-item margin-bottom-basic">
          <div class="grid-row">
            <div class="grid-row item-s-4 item-m-2">
              <div class="grid-item gws-cart-thumb"></div>
            </div>
            <div class="grid-row item-s-8 item-m-10">
              <div class="grid-row item-s-12 item-m-6 margin-bottom-small align-content-start">
                <div class="grid-item item-s-12 margin-bottom-small">
                  <span class="gws-cart-title"></span>
                </div>
                <div class="grid-row item-s-12 align-content-start">
                  <div class="grid-item item-s-6 item-m-3">
                    <span class="font-cond">Qty</span>
                  </div>
                  <div class="grid-item item-s-6 item-m-3">
                    <input type="number" min="1" max="100" class="gws-cart-quantity" />
                  </div>
                </div>
              </div>
              <div class="item-s-12 item-m-6 grid-row align-content-start">
                <div class="grid-item item-s-6 item-m-12 margin-bottom-small">
                  <span class="font-cond">Price</span>
                </div>
                <div class="grid-item item-s-6 item-m-12">
                  <span>$<span class="gws-cart-item-subtotal"></span></span>
                </div>
              </div>
            </div>
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
