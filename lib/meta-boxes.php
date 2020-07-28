<?php

/* Get post objects for select field options */
function get_post_objects( $query_args ) {
  $args = wp_parse_args( $query_args, array(
    'post_type' => 'post',
  ) );
  $posts = get_posts( $args );
  $post_options = array();
  if ( $posts ) {
    foreach ( $posts as $post ) {
      $post_options [ $post->ID ] = $post->post_title;
    }
  }
  return $post_options;
}


/**
 * Include and setup custom metaboxes and fields.
 *
 * @category YourThemeOrPlugin
 * @package  Metaboxes
 * @license  http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 * @link     https://github.com/WebDevStudios/CMB2
 */

/**
 * Hook in and add metaboxes. Can only happen on the 'cmb2_init' hook.
 */
add_action( 'cmb2_init', 'igv_cmb_metaboxes' );
function igv_cmb_metaboxes() {

  // Start with an underscore to hide fields from custom fields list
  $prefix = '_igv_';

  /**
   * Metaboxes declarations here
   * Reference: https://github.com/WebDevStudios/CMB2/blob/master/example-functions.php
   */

  // ALBUM

  $album_metabox = new_cmb2_box( array(
    'title'         => __( 'Settings', 'cmb2' ),
    'id'            => 'album_metabox',
    'object_types'  => array( 'album', ), // Post type
  ) );

  $album_metabox->add_field( array(
		'name'       => __( 'Images', 'cmb2' ),
		'id'         => $prefix . 'album_images',
		'type'       => 'file_list',
	) );

	$album_metabox->add_field( array(
		'name'       => __( 'Artist', 'cmb2' ),
		'id'         => $prefix . 'album_artist',
		'type'       => 'text',
	) );

	$album_metabox->add_field( array(
		'name'       => __( 'Title', 'cmb2' ),
		'id'         => $prefix . 'album_title',
		'type'       => 'text',
	) );

  $album_metabox->add_field( array(
		'name'       => __( 'Catalog Number', 'cmb2' ),
		'id'         => $prefix . 'album_catalog_num',
		'type'       => 'text',
	) );

  $album_metabox->add_field( array(
		'name'       => __( 'Release Date', 'cmb2' ),
		'id'         => $prefix . 'album_release_date',
		'type'       => 'text',
	) );

  $album_metabox->add_field( array(
		'name'       => __( 'Tracklist', 'cmb2' ),
		'id'         => $prefix . 'album_tracklist',
		'type'       => 'textarea',
	) );

  $album_metabox->add_field( array(
		'name'       => __( 'Credits', 'cmb2' ),
		'id'         => $prefix . 'album_credits',
		'type'       => 'textarea',
	) );

  $album_metabox->add_field( array(
		'name'       => __( 'Tidal URL', 'cmb2' ),
		'id'         => $prefix . 'album_tidal_url',
		'type'       => 'text_url',
	) );

  $album_metabox->add_field( array(
		'name'       => __( 'Apple Music URL', 'cmb2' ),
		'id'         => $prefix . 'album_apple_url',
		'type'       => 'text_url',
	) );

  $album_metabox->add_field( array(
		'name'       => __( 'Spotify URL', 'cmb2' ),
		'id'         => $prefix . 'album_spotify_url',
		'type'       => 'text_url',
	) );

  $album_metabox->add_field( array(
		'name'       => __( 'YouTube URL', 'cmb2' ),
		'id'         => $prefix . 'album_youtube_url',
		'type'       => 'text_url',
	) );

  $album_metabox->add_field( array(
		'name'       => __( 'Bandcamp URL', 'cmb2' ),
		'id'         => $prefix . 'album_bandcamp_url',
		'type'       => 'text_url',
	) );

  $album_metabox->add_field( array(
		'name'       => __( 'Soundcloud URL', 'cmb2' ),
		'id'         => $prefix . 'album_soundcloud_url',
		'type'       => 'text_url',
	) );

  // TRACK

  $track_metabox = new_cmb2_box( array(
    'title'         => __( 'Settings', 'cmb2' ),
    'id'            => 'track_metabox',
    'object_types'  => array( 'track', ), // Post type
  ) );

  $track_metabox->add_field( array(
		'name'       => __( 'Soundcloud URL', 'cmb2' ),
		'id'         => $prefix . 'track_soundcloud',
		'type'       => 'text_url',
	) );

  $track_metabox->add_field( array(
    'name'      	=> __( 'Related Album', 'cmb2' ),
    'id'        	=> $prefix . 'track_album',
    'type'      	=> 'post_search_ajax',
    // Optional :
    'limit'      	=> 1,
    'query_args'	=> array(
      'post_type'			=> array( 'album' ),
      'post_status'		=> array( 'publish' ),
      'posts_per_page'	=> -1
    )
  ) );

  // HOME

  $home_page = get_page_by_path('home');

  if (!empty($home_page)) {
    $home_metabox = new_cmb2_box( array(
  		'id'            => 'home_metabox',
  		'title'         => __( 'Settings', 'cmb2' ),
  		'object_types'  => array( 'page', ), // Post type
      'show_on'      => array(
        'key' => 'id',
        'value' => array( $home_page->ID )
      ),
  	) );

    $home_metabox->add_field( array(
  		'name'      	=> __( 'Featured Albums', 'cmb2' ),
  		'id'        	=> $prefix . 'featured_albums',
  		'type'    => 'custom_attached_posts',
  		'column'  => true, // Output in the admin post-listing as a custom column. https://github.com/CMB2/CMB2/wiki/Field-Parameters#column
  		'options' => array(
  			'show_thumbnails' => true, // Show thumbnails on the left
  			'filter_boxes'    => true, // Show a text box for filtering the results
  			'query_args'      => array(
  				'posts_per_page' => 10,
  				'post_type'      => 'album',
  			), // override the get_posts args
  		),
  	) );
  }

}
?>
