<article <?php post_class('grid-item no-gutter item-s-12 item-m-4 grid-row'); ?> id="post-<?php the_ID(); ?>">
  <div class="grid-item item-s-12 margin-bottom-small">
    <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('recent-post'); ?></a>
  </div>
  <div class="grid-item item-s-12">
    <h2 class="font-size-large font-cond margin-bottom-tiny"><?php the_title(); ?></h2>
  </div>
  <div class="grid-item no-gutter item-s-12">
    <div class="grid-item item-s-12">
      <span>Author</span>
    </div>
  </div>
</article>
