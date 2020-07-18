<?php
get_header();
?>

<main id="main-content">
  <section>
    <div class="container">
      <div class="grid-row">

      <?php
      if (have_posts()) {
        while (have_posts()) {
          the_post();
      ?>
        <header id="post-header" class="item-s-12 grid-row">
          <div id="post-title-holder" class="grid-item item-s-12 item-l-6">
            <h1>Title</h1>
          </div>
          <div id="post-details-holder" class="item-s-12 item-l-6 grid-row">
            <div class="grid-item item-s-8 item-l-6 offset-l-2">
              Author
            </div>
            <div class="grid-item item-s-4">
              Date
            </div>
          </div>
        </header>
        <div class="grid-item item-s-12">
          <?php the_post_thumbnail('full', array('id' => 'post-featured-image')); ?>
        </div>
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
