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
<?php
$classes = '';
$isStorePage = is_page('cart') || is_singular('product') || is_post_type_archive('product');
$classes .= $isStorePage ? 'background-pistachio' : '';
?>
<body <?php body_class($classes); ?>>
<!--[if lt IE 9]><p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p><![endif]-->

<?php
$show_shop = get_show_shop();
?>
<section id="main-container">
  <header id="header" class="background-almond">
    <div class="container">
      <div class="grid-row padding-top-micro padding-bottom-micro align-items-center justify-between">
        <div class="grid-item">
          <h1 class="font-bold font-size-large"><a href="<?php echo home_url(); ?>">ISCHiFi</a></h1>
        </div>
        <nav>
          <ul class="grid-row font-cond">
            <li class="grid-item">
              <a href="<?php echo home_url('collection'); ?>" class="toggle-nav">Collection</a>
            </li>
            <li class="grid-item">
              <a href="<?php echo home_url('features'); ?>" class="toggle-nav">Features</a>
            </li>
            <li class="grid-item">
              <a href="<?php echo home_url('store'); ?>" class="toggle-nav">Store</a>
            </li>
            <li class="grid-item">
              <a class="search-toggle" href="#" class="toggle-nav">Search</a>
            </li>
            <li class="grid-item">
              <a href="<?php echo home_url('cart'); ?>"><?php get_template_part('assets/shopping-bag.svg'); ?></a>
              <span>(<span class="gws-cart-counter">0</span>)</span>
            </li>
          </ul>
        </nav>
      </div>
    </div>
  </header>

  <?php get_template_part('partials/welcome-panel'); ?>
