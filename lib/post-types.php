<?php
// Menu icons for Custom Post Types
// https://developer.wordpress.org/resource/dashicons/
function add_menu_icons_styles(){
?>

<style>
#menu-posts-album .dashicons-admin-post:before {
    content: '\f514';
}
</style>

<?php
}
add_action( 'admin_head', 'add_menu_icons_styles' );


//Register Custom Post Types
add_action( 'init', 'register_cpt_album' );

function register_cpt_album() {

  $labels = array(
    'name' => _x( 'Collection', 'igv' ),
    'singular_name' => _x( 'Album', 'igv' ),
    'add_new' => _x( 'Add New', 'igv' ),
    'add_new_item' => _x( 'Add New Album', 'igv' ),
    'edit_item' => _x( 'Edit Album', 'igv' ),
    'new_item' => _x( 'New Album', 'igv' ),
    'view_item' => _x( 'View Album', 'igv' ),
    'search_items' => _x( 'Search Collection', 'igv' ),
    'not_found' => _x( 'No albums found', 'igv' ),
    'not_found_in_trash' => _x( 'No albums found in Trash', 'igv' ),
    'parent_item_colon' => _x( 'Parent Album:', 'igv' ),
    'menu_name' => _x( 'Collection', 'igv' ),
  );

  $args = array(
    'labels' => $labels,
    'hierarchical' => false,

    'supports' => array( 'title', 'editor', 'thumbnail' ),

    'public' => true,
    'show_ui' => true,
    'show_in_menu' => true,
    'menu_position' => 5,

    'show_in_nav_menus' => true,
    'publicly_queryable' => true,
    'exclude_from_search' => false,
    'has_archive' => 'collection',
    'query_var' => true,
    'can_export' => true,
    'rewrite' => true,
    'capability_type' => 'post',

    'show_in_rest'        => true,
    /*'template'          => array(
      array( 'core/heading', array(
        'level' => '5', 'content' => 'Some List' ) ),
      array( 'core/list' ),
      array( 'core/heading', array(
        'level' => '5', 'content' => 'Some Text' ) ),
      array( 'core/paragraph' )
    ),*/
		//'template_lock'     => 'all',
  );

  register_post_type( 'album', $args );
}
