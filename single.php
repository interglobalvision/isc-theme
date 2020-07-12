<?php
get_header();
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
?>

<main id="main-content">
  <section class="border-square">

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
