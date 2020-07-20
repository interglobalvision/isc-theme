<section id="search-form-holder">
  <div class="grid-row justify-center padding-top-small padding-bottom-small">
    <form id="search-form" method="get" class="grid-item item-s-12" action="<?php echo home_url('/'); ?>">
      <label for="s" class="grid-row text-align-center">
        <span class="font-uppercase grid-item">Search</span>
        <div class="flex-grow grid-row grid-item">
          <input type="text" class="flex-grow search-field text-align-center" name="s" placeholder="<?php echo is_search() ? get_search_query() : ''; ?>">
        </div>
      </label>
      <!--button type="submit" id="search-submit" class="margin-top-tiny button">Submit</button-->
    </form>
  </div>
</section>
