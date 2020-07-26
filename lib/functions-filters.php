<?php

// Custom filters (like pre_get_posts etc)

// Page Slug Body Class
function add_slug_body_class( $classes ) {
  global $post;
  if (isset($post) && !is_home() && !is_archive()) {
    $classes[] = $post->post_type . '-' . $post->post_name;
  }
  return $classes;
}
add_filter( 'body_class', 'add_slug_body_class' );

// Custom img attributes to be compatible with lazysize
function add_lazysize_on_srcset($attr) {

  if (!is_admin()) {

    // if image has data-no-lazysizes attribute dont add lazysizes classes
    if (isset($attr['data-no-lazysizes'])) {
      unset($attr['data-no-lazysizes']);
      return $attr;
    }

    // Add lazysize class
    $attr['class'] .= ' lazyload';

    if (isset($attr['srcset'])) {
      // Add lazysize data-srcset
      $attr['data-srcset'] = $attr['srcset'];
      // Remove default srcset
      unset($attr['srcset']);
    } else {
      // Add lazysize data-src
      $attr['data-src'] = $attr['src'];
    }

    // Set default to white blank
    $attr['src'] = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAQAAAABCAQAAABTNcdGAAAAC0lEQVR42mNkgAIAABIAAmXG3J8AAAAASUVORK5CYII=';

  }

  return $attr;

}
add_filter('wp_get_attachment_image_attributes', 'add_lazysize_on_srcset');

function igv_set_post_query_args($query){
  if($query->is_main_query() && $query->is_home()){
    $latest_post = get_posts(array('numberposts' => 1));
    $query->set('post__not_in', array($latest_post[0]->ID)); //exclude queries by post ID

    $ppp = 6;
    $offset = -4;

    if (!$query->is_paged()) {
      $query->set('posts_per_page',$offset + $ppp);
    } else {
      $offset = $offset + ( ($query->query_vars['paged']-1) * $ppp );
      $query->set('posts_per_page',$ppp);
      $query->set('offset',$offset);
    }
  }
}
add_action('pre_get_posts','igv_set_post_query_args');

function igv_homepage_offset_pagination( $found_posts, $query ) {
  if($query->is_main_query() && $query->is_home()){
    $offset = -4;
    $found_posts = $found_posts + $offset;
  }
  return $found_posts;
}
add_filter( 'found_posts', 'igv_homepage_offset_pagination', 10, 2 );

function igv_set_album_query_args($query){
  if($query->is_main_query() && is_post_type_archive('album')){
    $query->set('posts_per_page', 24);
  }
}
add_action('pre_get_posts','igv_set_album_query_args');

function igv_set_search_query_args($query) {
  if ($query->is_search) {
    $query->set('post_type',array('post','album'));
    $query->set('posts_per_page', 10);
  }
  return $query;
}
add_filter('pre_get_posts','igv_set_search_query_args');
