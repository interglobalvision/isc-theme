<?php
get_header();
?>

<main id="main-content">
<?php
if (have_posts()) {
  while (have_posts()) {
    the_post();

    $artist = get_post_meta($post->ID, '_igv_album_artist', true);
    $title = get_post_meta($post->ID, '_igv_album_title', true);
    $catalog_num = get_post_meta($post->ID, '_igv_album_catalog_num', true);
    $tracklist = get_post_meta($post->ID, '_igv_album_tracklist', true);
    $credits = get_post_meta($post->ID, '_igv_album_credits', true);

    $styles = get_the_terms($post->ID, 'style');
    $labels = get_the_terms($post->ID, 'label');
    $years = get_the_terms($post->ID, 'year');
    $countries = get_the_terms($post->ID, 'country');
    $tags = get_the_terms($post->ID, 'post_tag');

    $the_content = get_the_content();
    $album_id = $post->ID;
?>
  <section class="padding-top-basic font-mono">
    <div class="container">
      <div class="grid-row">
        <div class="grid-item item-s-12 item-m-5 margin-bottom-basic">
          <?php the_post_thumbnail('large', array( 'alt' => get_the_title() . ' album cover')); ?>
        </div>
        <div class="grid-item item-s-12 item-m-6 offset-m-1 grid-row no-gutter align-content-start margin-bottom-basic">
          <header class="grid-item item-s-12 margin-bottom-small">
            <h1 class="u-visuallyhidden"><?php the_title(); ?></h1>
          <?php if (!empty($artist)) { ?>
            <div>
              <span class="font-cond font-size-large"><?php echo $artist; ?></span>
            </div>
          <?php } if (!empty($title)) { ?>
            <div>
              <span class="font-sans font-size-large"><?php echo $title; ?></span>
            </div>
          <?php } if (!empty($styles)) { ?>
            <div class="margin-top-tiny">
              <span class="font-cond margin-right-micro">Style: </span><?php
                foreach($styles as $key => $value) {
                  echo '<span>' . $value->name . '</span>';
                  echo $key + 1 !== count($styles) ? ', ' : '';
                }
              ?>
            </div>
          <?php } ?>
          </header>

          <div id="album-details" class="grid-item item-s-12 item-m-10 offset-m-2 margin-bottom-basic">
          <?php if (!empty($labels)) { ?>
            <div class="margin-bottom-micro">
              <span class="font-cond margin-right-micro">Label: </span><?php
                foreach($labels as $key => $value) {
                  echo '<span>' . $value->name . '</span>';
                  echo $key + 1 !== count($labels) ? ', ' : '';
                }
              ?>
            </div>
          <?php } if (!empty($catalog_num)) { ?>
            <div class="margin-bottom-micro">
              <span class="font-cond margin-right-micro">Catalog Number: </span><span><?php echo $catalog_num; ?></span>
            </div>
          <?php } if (!empty($years)) { ?>
            <div class="margin-bottom-micro">
              <span class="font-cond margin-right-micro">Released: </span><?php
                foreach($years as $key => $value) {
                  echo '<span>' . $value->name . '</span>';
                  echo $key + 1 !== count($years) ? ', ' : '';
                }
              ?>
            </div>
          <?php } ?>
          </div>
          <?php get_template_part('partials/album-streaming'); ?>
        </div>
      </div>
    </div>
  </section>
  <section class="margin-bottom-large font-mono">
    <div class="container">
      <div class="grid-row">
        <div id="album-content-holder" class="grid-item item-s-12 item-m-5 margin-bottom-small align-content-start">
          <div class="font-color-grey"><?php the_content(); ?></div>
          <?php if (!empty($tags)) { ?>
          <div class="margin-top-small">
            <span>Tags: </span><?php
              foreach($tags as $key => $value) {
                echo '<span>' . $value->name . '</span>';
                echo $key + 1 !== count($tags) ? ' / ' : '';
              }
            ?>
          </div>
          <?php } ?>
        </div>

        <div id="album-tracklist-credits-holder" class="grid-row grid-item item-s-12 item-m-6 offset-m-1 margin-bottom-small align-content-start">
        <?php if (!empty($tracklist)) { ?>
          <div class="margin-bottom-tiny">
            <div class="margin-bottom-tiny">
              <span>Tracklist:</span>
            </div>
            <div>
              <?php echo apply_filters('the_content', $tracklist); ?>
            </div>
          </div>
        <?php } if (!empty($credits)) { ?>
          <div class="margin-bottom-tiny">
            <div class="margin-bottom-tiny">
              <span>Credits:</span>
            </div>
            <div>
              <?php echo apply_filters('the_content', $credits); ?>
            </div>
          </div>
        <?php } ?>
        </div>
      </div>
    </div>
  </section>
<?php
  }
}

$args = array(
  'post_type' => array('album'),
  'posts_per_page' => 4,
  'post__not_in' => array($album_id),
);

$query = new WP_Query($args);

if ($query->have_posts()) {
?>
  <section class="padding-top-basic padding-bottom-basic border-box">
    <div class="container">
      <div class="grid-row">
        <div class="grid-item item-s-12 margin-bottom-small">
          <span>Suggested Records</span>
        </div>
      <?php
        while ($query->have_posts()) {
          $query->the_post();
      ?>
        <article <?php post_class('grid-item item-s-6 item-m-3'); ?> id="album-<?php the_ID(); ?>">
          <a href="<?php the_permalink() ?>">
            <h3 class="u-visuallyhidden"><?php the_title(); ?></h3>
            <div><?php the_post_thumbnail('full'); ?></div>
          </a>
        </article>
      <?php
        }
      ?>
      </div>
    </div>
  </section>
<?php
}
wp_reset_postdata();
?>
</main>

<?php
get_footer();
?>
