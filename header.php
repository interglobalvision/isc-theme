<!DOCTYPE html>
<html lang="en" prefix="og: http://ogp.me/ns#">
<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <title><?php wp_title('|',true,'right'); bloginfo('name'); ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

<?php
get_template_part('partials/globie');
get_template_part('partials/seo');
?>

  <link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url'); ?>" />
  <link rel="icon" href="<?php bloginfo('stylesheet_directory'); ?>/dist/img/favicon.png">
  <link rel="shortcut" href="<?php bloginfo('stylesheet_directory'); ?>/dist/img/favicon.ico">
  <link rel="apple-touch-icon" href="<?php bloginfo('stylesheet_directory'); ?>/dist/img/favicon-touch.png">
  <link rel="apple-touch-icon" sizes="114x114" href="<?php bloginfo('stylesheet_directory'); ?>/dist/img/favicon.png">

<?php if (is_singular() && pings_open(get_queried_object())) { ?>
  <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
<?php } ?>

  <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<!--[if lt IE 9]><p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p><![endif]-->
<section id="main-container">
  <header id="header">
    <div class="container">
      <div class="grid-row padding-top-tiny">
        <div class="grid-item flex-grow margin-bottom-tiny">
          <h1 class="font-bold font-size-large"><a href="<?php echo home_url(); ?>">ISCHiFi</a></h1>
        </div>
      </div>
    </div>
    <nav id="main-nav">
      <div class="container">
        <div id="main-nav-row" class="font-cond grid-row padding-top-tiny">
          <div class="grid-item font-size-large font-sans font-bold mobile-only margin-bottom-mid">
            <a href="<?php echo home_url(); ?>" class="toggle-nav">ISCHiFi</a>
          </div>
          <div class="grid-item item-s-12 item-m-auto margin-bottom-tiny">
            <a href="<?php echo home_url('collection'); ?>" class="toggle-nav">Collection</a>
          </div>
          <div class="grid-item item-s-12 item-m-auto margin-bottom-tiny">
            <a href="<?php echo home_url('features'); ?>" class="toggle-nav">Features</a>
          </div>
          <div class="grid-item item-s-12 item-m-auto">
            <a class="search-toggle" href="#" class="toggle-nav">Search</a>
          </div>
        </div>
      </div>
    </nav>
    <div id="mobile-nav-toggle" class="toggle-nav">
      <img id="nav-toggle-open" src="<?php bloginfo('stylesheet_directory'); ?>/dist/img/nav-open.png" />
      <img id="nav-toggle-closed" src="<?php bloginfo('stylesheet_directory'); ?>/dist/img/nav-closed.png" />
    </div>
  </header>

  <?php get_template_part('partials/welcome-panel'); ?>
