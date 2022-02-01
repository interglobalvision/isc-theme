
  <footer id="footer" class="background-white padding-top-basic font-size-small">
    <div class="container">
      <?php get_template_part('partials/footer'); ?>
    </div>
  </footer>

  <?php
  if (!is_search()) {
    get_template_part('partials/search-panel');
  }
  get_template_part('partials/player');
  ?>

</section>

<div id="loader"><img src="<?php bloginfo('stylesheet_directory'); ?>/dist/img/loading.png" /></div>

<?php
get_template_part('partials/overlay-gallery');
get_template_part('partials/scripts');
get_template_part('partials/schema-org');
?>

</body>
</html>
