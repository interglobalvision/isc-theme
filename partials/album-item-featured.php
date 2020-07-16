<article <?php post_class('grid-item item-s-4 album-featured'); ?> id="album-featured-<?php the_ID(); ?>">
  <a href="<?php the_permalink(); ?>">
    <?php the_post_thumbnail('full'); ?>
    <?php the_title(); ?>
  </a>
</article>
