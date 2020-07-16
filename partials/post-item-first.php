<article <?php post_class('padding-top-basic padding-bottom-basic'); ?> id="post-<?php the_ID(); ?>">
  <div class="mobile-only">
    <div class="grid-row">
      <div class="grid-item no-gutter item-s-12 grid-row">
        <div class="grid-item item-s-auto flex-grow offset-l-3">
          <span>Author</span>
        </div>
        <div class="grid-item">
          <?php the_date(); ?>
        </div>
      </div>
      <div class="grid-item item-s-12">
        <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('full'); ?></a>
      </div>
      <div class="grid-item item-s-3">
        <span>FEATURE</span>
      </div>
      <div class="grid-item item-s-9">
        <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
      </div>
      <div class="grid-item item-s-12">
        <?php the_excerpt(); ?>
      </div>
      <div class="grid-item offset-s-9">
        <a href="<?php the_permalink(); ?>">-></a>
      </div>
    </div>
  </div>
  <div class="not-mobile">
    <div class="grid-row">
      <div class="grid-item item-s-6">
        <div class="grid-item item-s-12">
          <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
        </div>
        <div class="grid-item no-gutter item-s-12 grid-row">
          <div class="grid-item item-s-auto flex-grow offset-l-3">
            <span>Author</span>
          </div>
          <div class="grid-item">
            <?php the_date(); ?>
          </div>
        </div>
        <div class="grid-item item-s-12">
          <?php the_excerpt(); ?>
        </div>
      </div>
      <div class="grid-item item-s-6">
        <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('full'); ?></a>
      </div>
    </div>
  </div>
</article>
