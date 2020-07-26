<article <?php post_class('grid-item no-gutter item-s-12 item-m-6 grid-column margin-bottom-basic'); ?> id="post-<?php the_ID(); ?>">
  <div class="grid-row margin-bottom-tiny">
    <div class="grid-item item-s-auto flex-grow offset-l-3">
      <span>Author</span>
    </div>
    <div class="grid-item">
      <?php echo get_the_date(); ?>
    </div>
  </div>
  <div class="grid-item margin-bottom-tiny">
    <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('full'); ?></a>
  </div>
  <div class="grid-row margin-bottom-tiny">
    <div class="grid-item item-s-3">
      <span class="font-uppercase">Feature</span>
    </div>
    <div class="grid-item item-s-9">
      <h2 class="font-cond font-size-large"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
    </div>
  </div>
  <div class="grid-item font-mono font-color-grey">
    <?php the_excerpt(); ?>
  </div>
  <div class="grid-item flex-grow grid-row align-content-end">
    <div class="offset-s-9">
      <a href="<?php the_permalink(); ?>">-></a>
    </div>
  </div>
</article>
