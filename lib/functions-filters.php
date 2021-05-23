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
function add_lazysize_on_srcset($attr, $attachment, $size) {

  if (!is_admin()) {

    // if image has data-no-lazysizes attribute dont add lazysizes classes
    if (isset($attr['data-no-lazysizes'])) {
      unset($attr['data-no-lazysizes']);
      return $attr;
    }

    $image = wp_get_attachment_image_src($attachment->ID, $size);

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

    $svg_color = 'rgb(200, 200, 200)';

    // Set default to white blank
    $attr['src'] = 'data:image/svg+xml,%3Csvg style="background-color:' . $svg_color . '" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 ' . $image[1] . ' ' . $image[2] . '"%3E%3C/svg%3E';

  }

  return $attr;

}
add_filter('wp_get_attachment_image_attributes', 'add_lazysize_on_srcset', 10, 3);

function igv_query_vars( $qvars ) {
    $qvars[] = 'sort';
    return $qvars;
}
add_filter( 'query_vars', 'igv_query_vars' );

function igv_set_playlist_query_args($query){
  $paged = $query->query_vars[ 'paged' ];

  if (!is_admin() &&
  $query->is_main_query() &&
  $query->is_category('playlist')) {
    $query->set( 'paged', $paged );

    $cat = get_category_by_slug('playlist');
    $latest_playlist = get_posts(array('category'=>$cat->term_id,'numberposts'=>1));

    $query->set('post__not_in', array($latest_playlist[0]->ID)); //exclude queries by post ID
    $query->set( 'posts_per_page', 6 );
  }
}
add_action('pre_get_posts','igv_set_playlist_query_args');

function igv_set_community_query_args($query){
  $paged = $query->query_vars[ 'paged' ];

  if (!is_admin() &&
  $query->is_main_query() &&
  $query->is_category('community')) {
    $query->set( 'paged', $paged );

    $cat = get_category_by_slug('community');
    $latest_community = get_posts(array('category'=>$cat->term_id,'numberposts'=>1));

    $query->set('post__not_in', array($latest_community[0]->ID)); //exclude queries by post ID
    $query->set( 'posts_per_page', 6 );
  }
}
add_action('pre_get_posts','igv_set_community_query_args');

function igv_set_album_query_args($query){
  if(!is_admin() && $query->is_main_query() && is_post_type_archive('album')){
    $query->set('posts_per_page', 24);

    $sort = $query->get('sort');

    switch ($sort) {
      case 'added_newest':
        $query->set('orderby', 'date');
        $query->set('order', 'DESC');
        $query->set('meta_key', null);
        break;
      case 'added_oldest':
        $query->set('orderby', 'date');
        $query->set('order', 'ASC');
        $query->set('meta_key', null);
        break;
      case 'artist_a_z':
        $query->set('orderby', 'meta_value');
        $query->set('order', 'ASC');
        $query->set('meta_key', '_igv_album_artist');
        break;
      case 'artist_z_a':
        $query->set('orderby', 'meta_value');
        $query->set('order', 'DESC');
        $query->set('meta_key', '_igv_album_artist');
        break;
      case 'release_newest':
        $query->set('orderby', 'meta_value');
        $query->set('order', 'DESC');
        $query->set('meta_key', '_igv_album_release_date');
        break;
      case 'release_oldest':
        $query->set('orderby', 'meta_value');
        $query->set('order', 'ASC');
        $query->set('meta_key', '_igv_album_release_date');
        break;
      default:
        $query->set('orderby', 'date');
        $query->set('order', 'DESC');
        $query->set('meta_key', null);
    }
  }
}
add_action('pre_get_posts','igv_set_album_query_args');

function igv_set_search_query_args($query) {
  if (!is_admin() && $query->is_search) {
    $query->set('post_type',array('post','album','product'));
    $query->set('posts_per_page', 10);
  }
  return $query;
}
add_filter('pre_get_posts','igv_set_search_query_args');

/*function igv_set_tag_archive_query_args($query) {
  if (!is_admin() && $query->is_tag()) {
    $query->set('post_type',array('post','album','product'));
    $query->set('posts_per_page', 10);
  }
  return $query;
}
add_filter('pre_get_posts','igv_set_tag_archive_query_args');*/

function igv_set_product_archive_query_args($query) {
  if(!is_admin() && $query->is_main_query() && is_post_type_archive('product')){
    $query->set('posts_per_page', 12);
    $args = array(
      'post_type' => array('product'),
      'numberposts' => 1,
      'meta_key'   => '_igv_product_featured',
      'meta_value' => 'on'
    );
    $featured_product = get_posts($args);
    if ($featured_product) {
      $query->set('post__not_in', array($featured_product[0]->ID));
    }
  }
  return $query;
}
add_filter('pre_get_posts','igv_set_product_archive_query_args');
