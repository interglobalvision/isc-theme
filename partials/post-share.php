<div class="grid-row align-items-center">
  <div class="grid-item item-s-2">
    <span>Share:</span>
  </div>
  <ul class="grid-row align-items-center">
    <li class="grid-item">
      <a class="social-icon" href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode( get_permalink() ); ?>"><img src="<?php bloginfo('stylesheet_directory'); ?>/dist/img/social-facebook.png" /></a>
    </li>
    <li class="grid-item">
      <a class="social-icon" href="https://twitter.com/intent/tweet?text=Check%20this%20out%3A%20<?php echo urlencode( get_permalink() ); ?>"><img src="<?php bloginfo('stylesheet_directory'); ?>/dist/img/social-twitter.png" /></a>
    </li>
    <li class="grid-item">
      <a class="social-icon" href="mailto:?&subject=<?php echo rawurlencode( get_the_title() ); ?>&body=Check%20this%20out:%0D<?php echo urlencode( get_permalink() ); ?>"><img src="<?php bloginfo('stylesheet_directory'); ?>/dist/img/social-email.png" /></a>
    </li>
  </ul>
</div>
