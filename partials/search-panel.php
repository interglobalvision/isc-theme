<div id="search-toggle-overlay"></div>
<div id="search-panel" class="padding-left-basic padding-right-basic padding-top-mid">
  <?php get_search_form(); ?>
  <section>
    <div id="search-results" class="grid-row">
    </div>
    <div class="grid-row justify-end">
      <div class="grid-item">
        <a id="search-load-more" class="load-more-button hide" data-context="search-load-more" href="<?php echo $load_more_url; ?>">Load more</a>
      </div>
    </div>
  </section>
</div>
