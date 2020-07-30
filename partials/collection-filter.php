<div class="grid-row">
  <div class="grid-item no-gutter item-s-12 item-m-7 item-l-6 offset-l-2 grid-row margin-bottom-basic">
    <div class="grid-item item-s-3 item-m-auto">
      <span class="font-uppercase font-size-tiny">Style</span>
    </div>
    <div class="grid-item flex-grow">
      <?php
        $select_args = array(
          'filter_class' => 'collection-filter',
          'initial_value' => function() {
            $q_style = get_query_var('style');
            $active_style = get_term_by('slug', $q_style, 'style');
            echo $active_style ? $active_style->name : 'All';
          },
          'filter_options' => function() {
            $styles = get_terms('style', array(
                'hide_empty' => true,
            ));
            $q_style = get_query_var('style');

            echo '<a href="' . get_post_type_archive_link('album') . '?style=" class="filter-option ' . (!$q_style ? 'active' : '') . '" data-context="filter" data-filter="style">All</a>';

            foreach($styles as $key => $value) {
              echo '<a href="' . get_post_type_archive_link('album') . '?style=' . $value->slug . '" class="filter-option ' . ($q_style === $value->slug ? 'active' : '') . '" data-context="filter" data-filter="style">';
              echo $value->name;
              echo '</a>';
            }
          }
        );

        custom_filter($select_args);
      ?>
    </div>
  </div>
  <div class="grid-item no-gutter item-s-12 item-m-5 item-l-3 offset-l-1 grid-row margin-bottom-basic">
    <div class="grid-item item-s-3 item-m-auto">
      <span class="font-uppercase font-size-tiny">Sort By</span>
    </div>
    <div class="grid-item flex-grow">
      <?php
        /*
        - Added Newest
        orderby=date
        order=DESC
        meta_key=

        - Added Oldest
        orderby=date
        order=ASC
        meta_key=

        - Artist A-Z
        orderby=meta_value
        order=ASC
        meta_key=_igv_album_artist

        - Artist Z-A
        orderby=meta_value
        order=DESC
        meta_key=_igv_album_artist

        - Release Date - Newest
        orderby=meta_value
        order=DESC
        meta_key=_igv_album_release_date

        - Release Date - Oldest
        orderby=meta_value
        order=ASC
        meta_key=_igv_album_release_date

        */

        $select_args = array(
          'filter_class' => 'collection-filter',
          'initial_value' => function() {
            $q_order = get_query_var('order');
            $q_orderby = get_query_var('orderby');
            $q_meta_key = get_query_var('meta_key');

            if ($q_orderby === 'meta_value') {
              if ($q_meta_key === '_igv_album_artist') {
                if ($q_order === 'ASC') {
                  echo 'Artist A-Z';
                } else {
                  echo 'Artist Z-A';
                }
              } else {
                if ($q_order === 'ASC') {
                  echo 'Release Date - Oldest';
                } else {
                  echo 'Release Date - Newest';
                }
              }
            } else {
              if ($q_order === 'ASC') {
                echo 'Added Oldest';
              } else {
                echo 'Added Newest';
              }
            }
          },
          'filter_options' => function() {
            $q_order = get_query_var('order');
            $q_orderby = get_query_var('orderby');
            $q_meta_key = get_query_var('meta_key');
            $album_archive_url = get_post_type_archive_link('album');

            echo '<a href="' . get_post_type_archive_link('album') . '?orderby=date&order=DESC" class="filter-option ' . (!$q_orderby || ($q_order === 'DESC' && $q_orderby === 'date') ? 'active' : '') . '" data-context="filter" data-filter="sort">Added Newest</a>';

            echo '<a href="' .
            $album_archive_url .
            '?orderby=date&order=ASC" class="filter-option ' .
            ($q_order === 'ASC' && $q_orderby === 'date' ? 'active' : '') .
            '" data-context="filter" data-filter="sort">Added Oldest</a>';

            echo '<a href="' .
            $album_archive_url .
            '?orderby=meta_value&order=ASC&meta_key=_igv_album_artist" class="filter-option ' .
            ($q_order === 'ASC' && $q_meta_key === '_igv_album_artist' ? 'active' : '') .
            '" data-context="filter" data-filter="sort">Artist A–Z</a>';

            echo '<a href="' .
            $album_archive_url .
            '?orderby=meta_value&order=DESC&meta_key=_igv_album_artist" class="filter-option ' .
            ($q_order === 'DESC' && $q_meta_key === '_igv_album_artist' ? 'active' : '') .
            '" data-context="filter" data-filter="sort">Artist Z–A</a>';

            echo '<a href="' .
            $album_archive_url .
            '?orderby=meta_value&order=DESC&meta_key=_igv_album_release_date" class="filter-option ' .
            ($q_order === 'DESC' && $q_meta_key === '_igv_album_release_date' ? 'active' : '') .
            '" data-context="filter" data-filter="sort">Release Date - Newest</a>';

            echo '<a href="' .
            $album_archive_url .
            '?orderby=meta_value&order=ASC&meta_key=_igv_album_release_date" class="filter-option ' .
            ($q_order === 'ASC' && $q_meta_key === '_igv_album_release_date' ? 'active' : '') .
            '" data-context="filter" data-filter="sort">Release Date - Oldest</a>';
          }
        );

        custom_filter($select_args);
      ?>
    </div>
  </div>
</div>
