<?php
$styles = get_terms('style', array(
    'hide_empty' => true,
));
?>
<div class="grid-row">
  <div class="grid-item no-gutter item-s-12 item-m-7 item-l-9 grid-row">
    <div class="grid-item item-s-3 item-m-auto">
      <span>STYLE</span>
    </div>
    <div class="grid-item flex-grow">
      <div class="select-wrapper">
        <div class="select">
          <div class="select-trigger text-align-center">
            <span class="select-value">Value</span>
          </div>
          <div class="select-options grid-column text-align-center">
            <span data-term-id="0">All</span>
            <?php foreach($styles as $key => $value) {
              echo '<span data-term-id="' . $value->term_id . '" data-name="' . $value->name . '">';
              echo $value->name;
              echo '</span>';
            } ?>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="grid-item no-gutter item-s-12 item-m-5 item-l-3 grid-row">
    <div class="grid-item item-s-3 item-m-auto">
      <span>SORT BY</span>
    </div>
    <div class="grid-item flex-grow">
      <div class="select-wrapper">
        <div class="select">
          <div class="select-trigger text-align-center">
            <span class="select-value">Value</span>
          </div>
          <div class="select-options grid-column text-align-center">
            <span data-sort="new">Newest</span>
            <span data-sort="old">Oldest</span>
            <span data-sort="a">A-Z</span>
            <span data-sort="z">Z-A</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
