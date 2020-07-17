<?php
get_header();
?>

<main id="main-content">
  <section class="border-box">

    <div class="container">
      <div class="grid-row">

      <?php
      if (have_posts()) {
        while (have_posts()) {
          the_post();
      ?>
        <div class="grid-item item-s-12">
          <?php the_content(); ?>
        </div>
      <?php
        }
      }
      ?>

      </div>
    </div>

  </section>
</main>

<?php
get_footer();
?>
