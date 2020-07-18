<section id="search-form-holder" class="grid-row">
  <div class="grid-item item-s-12 grid-row justify-center padding-top-small padding-bottom-small">
    <div class="grid-item item-s-12">
      <form id="search-form" method="get" class="grid-row text-align-center" action="<?php echo home_url('/'); ?>">
        <input type="text" class="flex-grow search-field text-align-center" name="s" placeholder="<?php if (is_search()) { the_search_query(); } else { echo 'Search'; } ?>">
        <!--button type="submit" id="search-submit" class="margin-top-tiny button">Submit</button-->
      </form>
    </div>
  </div>
</section>
