<article <?php post_class('grid-item no-gutter item-s-12 item-m-4 grid-row'); ?> id="post-<?php the_ID(); ?>">
  <div class="grid-item item-s-12">
    <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('full'); ?></a>
  </div>
  <div class="grid-item item-s-12">
    <h2><?php the_title(); ?></h2>
  </div>
  <div class="grid-item no-gutter item-s-12">
    <div class="grid-item item-s-12">
      <span>Author</span>
    </div>
  </div>
</article>
