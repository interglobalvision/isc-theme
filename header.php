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

  <link rel="preload" href="<?php bloginfo('stylesheet_directory'); ?>/dist/static/fonts/ROM-Medium.woff2" as="font" type="font/woff2" crossorigin>
  <link rel="preload" href="<?php bloginfo('stylesheet_directory'); ?>/dist/static/fonts/ROMCondensed-Medium.woff2" as="font" type="font/woff2" crossorigin>
  <link rel="preload" href="<?php bloginfo('stylesheet_directory'); ?>/dist/static/fonts/ROM-Light.woff2" as="font" type="font/woff2" crossorigin>
  <link rel="preload" href="<?php bloginfo('stylesheet_directory'); ?>/dist/static/fonts/ROMMono-Regular.woff2" as="font" type="font/woff2" crossorigin>

<?php if (is_singular() && pings_open(get_queried_object())) { ?>
  <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
<?php } ?>

<!-- Facebook Pixel Code -->
<script>
!function(f,b,e,v,n,t,s)
{if(f.fbq)return;n=f.fbq=function(){n.callMethod?
n.callMethod.apply(n,arguments):n.queue.push(arguments)};
if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
n.queue=[];t=b.createElement(e);t.async=!0;
t.src=v;s=b.getElementsByTagName(e)[0];
s.parentNode.insertBefore(t,s)}(window, document,'script',
'https://connect.facebook.net/en_US/fbevents.js');
fbq('init', '1351098861910831');
fbq('track', 'PageView');
</script>
<noscript><img height="1" width="1" style="display:none"
src="https://www.facebook.com/tr?id=1351098861910831&ev=PageView&noscript=1"
/></noscript>
<!-- End Facebook Pixel Code -->

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
  <header id="header" class="nav-down">
    <div class="container">
      <div class="grid-row padding-top-micro padding-bottom-micro align-items-center justify-between">
        <div class="grid-item">
          <h1 class="font-bold font-size-large"><a href="<?php echo home_url(); ?>">ISCHiFi</a></h1>
        </div>
        <nav id="main-nav">
          <ul class="grid-row font-cond">
            <li class="grid-item">
              <a href="<?php echo home_url('collection'); ?>" class="toggle-nav">Collection</a>
            </li>
            <li class="grid-item">
              <a href="<?php echo home_url('features'); ?>" class="toggle-nav">Features</a>
            </li>
            <li class="grid-item">
              <a href="<?php echo get_term_link('playlist', 'category'); ?>" class="toggle-nav">Playlists</a>
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
        <div id="mobile-nav-toggle" class="grid-item toggle-nav not-desktop">
          <div id="nav-toggle-open"><?php get_template_part('assets/nav-open.svg'); ?></div>
          <div id="nav-toggle-closed"><?php get_template_part('assets/nav-closed.svg'); ?></div>
        </div>
      </div>
    </div>
  </header>

  <?php get_template_part('partials/welcome-panel'); ?>
