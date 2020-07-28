<?php
get_header();
?>

<main id="main-content">
  <section class="padding-top-basic padding-bottom-large">
    <div class="container">
      <div class="grid-row">

      <?php
      if (have_posts()) {
        while (have_posts()) {
          the_post();
      ?>
        <header id="post-header" class="item-s-12 grid-row margin-bottom-tiny">
          <div id="post-title-holder" class="grid-item item-s-12 item-l-6 margin-bottom-small">
            <h1 class="font-size-extra font-cond"><?php the_title(); ?></h1>
          </div>
          <div id="post-details-holder" class="item-s-12 item-l-6 grid-row margin-bottom-small">
            <div class="grid-item item-s-8 item-l-6 offset-l-2">
              <?php guest_authors($post->ID); ?>
            </div>
            <div class="grid-item item-s-4">
              <?php echo get_the_date(); ?>
            </div>
          </div>
        </header>
        <div class="grid-item item-s-12 margin-bottom-basic">
          <?php the_post_thumbnail('full', array('id' => 'post-featured-image')); ?>
        </div>
        <div class="grid-item item-s-12 grid-row justify-center">
          <div id="post-content-holder">
            <?php the_content(); ?>
          </div>
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
