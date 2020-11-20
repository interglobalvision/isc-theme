<div class="grid-row align-items-center">
  <div class="grid-item item-s-2">
    <span>Share:</span>
  </div>
  <ul class="grid-row align-items-center">
    <li class="grid-item">
      <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode( get_permalink() ); ?>">F</a>
    </li>
    <li class="grid-item">
      <a href="https://twitter.com/intent/tweet?text=Check%20this%20out%3A%20<?php echo urlencode( get_permalink() ); ?>">T</a>
    </li>
    <li class="grid-item">
      <a href="mailto:?&subject=<?php echo rawurlencode( get_the_title() ); ?>&body=Check%20this%20out:%0D<?php echo urlencode( get_permalink() ); ?>">M</a>
    </li>
  </ul>
</div>
