<?php
$styles = get_terms('style', array(
    'hide_empty' => true,
));
$q_style = get_query_var('style');
$q_order = get_query_var('order');
$q_orderby = get_query_var('orderby');
?>
<div class="grid-row">
  <div class="grid-item no-gutter item-s-12 item-m-7 item-l-6 offset-l-2 grid-row margin-bottom-basic">
    <div class="grid-item item-s-3 item-m-auto">
      <span>STYLE</span>
    </div>
    <div class="grid-item flex-grow">
      <div class="filter-wrapper">
        <div class="filter">
          <div class="filter-trigger text-align-center">
            <span class="filter-value"><?php
              $active_style = get_term_by('slug', $q_style, 'style');
              echo $active_style ? $active_style->name : 'All';
            ?></span>
          </div>
          <div class="filter-options grid-column text-align-center">
            <?php
              echo '<a href="' . get_post_type_archive_link('album') . '?style=" class="filter-option ' . (!$q_style ? 'active' : '') . '" data-context="filter" data-filter="style">All</a>';

              foreach($styles as $key => $value) {
                echo '<a href="' . get_post_type_archive_link('album') . '?style=' . $value->slug . '" class="filter-option ' . ($q_style === $value->slug ? 'active' : '') . '" data-context="filter" data-filter="style">';
                echo $value->name;
                echo '</a>';
              }
            ?>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="grid-item no-gutter item-s-12 item-m-5 item-l-3 offset-l-1 grid-row margin-bottom-basic">
    <div class="grid-item item-s-3 item-m-auto">
      <span>SORT BY</span>
    </div>
    <div class="grid-item flex-grow">
      <div class="filter-wrapper">
        <div class="filter">
          <div class="filter-trigger text-align-center">
            <span class="filter-value"><?php
              if ($q_orderby === 'title') {
                if ($q_order === 'ASC') {
                  echo 'A-Z';
                } else {
                  echo 'Z-A';
                }
              } else {
                if ($q_order === 'ASC') {
                  echo 'Oldest';
                } else {
                  echo 'Newest';
                }
              }
            ?></span>
          </div>
          <div class="filter-options grid-column text-align-center">
            <?php
              echo '<a href="' . get_post_type_archive_link('album') . '?orderby=date&order=DESC" class="filter-option ' . (!$q_orderby || ($q_order === 'DESC' && $q_orderby === 'date') ? 'active' : '') . '" data-context="filter" data-filter="sort">Newest</a>';
              echo '<a href="' . get_post_type_archive_link('album') . '?orderby=date&order=ASC" class="filter-option ' . ($q_order === 'ASC' && $q_orderby === 'date' ? 'active' : '') . '" data-context="filter" data-filter="sort">Oldest</a>';
              echo '<a href="' . get_post_type_archive_link('album') . '?orderby=title&order=ASC" class="filter-option ' . ($q_order === 'ASC' && $q_orderby === 'title' ? 'active' : '') . '" data-context="filter" data-filter="sort">A-Z</a>';
              echo '<a href="' . get_post_type_archive_link('album') . '?orderby=title&order=DESC" class="filter-option ' . ($q_order === 'DESC' && $q_orderby === 'title' ? 'active' : '') . '" data-context="filter" data-filter="sort">Z-A</a>';
            ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
