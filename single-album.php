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
  <section class="padding-top-basic">
    <div class="container">
      <div class="grid-row">
        <div class="grid-item item-s-12 item-m-5 margin-bottom-basic">
          <?php the_post_thumbnail('gallery', array( 'alt' => get_the_title() . ' album cover', 'data-no-lazysizes' => 'true')); ?>
        </div>
        <div class="grid-item item-s-12 item-m-6 offset-m-1 grid-row no-gutter align-content-start margin-bottom-basic">
          <header class="grid-item item-s-12 margin-bottom-small">
            <h1 class="u-visuallyhidden"><?php the_title(); ?></h1>
          <?php if (!empty($artist)) { ?>
            <div>
              <span><?php echo $artist; ?></span>
            </div>
          <?php } if (!empty($title)) { ?>
            <div>
              <span><?php echo $title; ?></span>
            </div>
          <?php } if (!empty($styles)) { ?>
            <div>
              <span>Style: </span><?php
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
            <div>
              <span>Label: </span><?php
                foreach($labels as $key => $value) {
                  echo '<span>' . $value->name . '</span>';
                  echo $key + 1 !== count($labels) ? ', ' : '';
                }
              ?>
            </div>
          <?php } if (!empty($catalog_num)) { ?>
            <div>
              <span>Catalog Number: <?php echo $catalog_num; ?></span>
            </div>
          <?php } if (!empty($years)) { ?>
            <div>
              <span>Released: </span><?php
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
  <section class="margin-bottom-large">
    <div class="container">
      <div class="grid-row">
        <div id="album-content-holder" class="grid-item item-s-12 item-m-5 margin-bottom-small">
          <?php the_content(); ?>
          <?php if (!empty($tags)) { ?>
          <div>
            <span>Tags: </span><?php
              foreach($tags as $key => $value) {
                echo '<span>' . $value->name . '</span>';
                echo $key + 1 !== count($tags) ? ' / ' : '';
              }
            ?>
          </div>
          <?php } ?>
        </div>

        <div id="album-tracklist-credits-holder" class="grid-row grid-item item-s-12 item-m-6 offset-m-1 margin-bottom-small">
        <?php if (!empty($tracklist)) { ?>
          <div>
            <div>
              <span>Tracklist:</span>
            </div>
            <div>
              <?php echo apply_filters('the_content', $tracklist); ?>
            </div>
          </div>
        <?php } if (!empty($credits)) { ?>
          <div>
            <div>
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
