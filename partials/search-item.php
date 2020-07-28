<article <?php post_class('grid-item item-s-12 item-m-6 grid-row flex-nowrap search-result margin-bottom-small'); ?> id="post-<?php the_ID(); ?>">
  <div>
    <a href="<?php the_permalink(); ?>">
      <div class="search-thumb-holder margin-right-tiny" style="background-image: url('<?php echo get_the_post_thumbnail_url(); ?>')"></div>
    </a>
  </div>
  <div class="flex-grow">
    <a href="<?php the_permalink(); ?>">
      <div>
        <span class="font-uppercase"><?php
          switch (get_post_type()) {
            case 'post':
              echo 'Feature';
              break;
            case 'album':
              echo 'Album';
              break;
            default:
              echo ' ';
          }
        ?></span>
      </div>
      <div>
        <?php the_title(); ?>
      </div>
    </a>
  </div>
</article>
