<?php
get_header();
?>

<main id="main-content">
  <section class="padding-bottom-large padding-top-mid mobile-margin-top">
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
          <div id="post-details-holder" class="item-s-12 item-l-6 grid-row margin-bottom-small margin-top-tiny">
            <div class="grid-item item-s-8 item-l-6 offset-l-2">
              <?php guest_authors($post->ID); ?>
            </div>
            <div class="grid-item item-s-4">
              <time datetime="<?php echo get_the_date('Y-m-d'); ?>" class="font-size-small"><?php echo get_the_date(); ?></time>
            </div>
          </div>
        </header>
        <div class="grid-item item-s-12 margin-bottom-mid text-align-center">
          <?php the_post_thumbnail('full', array('id' => 'post-featured-image')); ?>
        </div>
        <div class="grid-item item-s-12 grid-row justify-center">
          <div id="post-content">
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
