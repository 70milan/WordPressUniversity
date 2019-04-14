<?php



// event post type


function university_post_types(){
	register_post_type('event',array(
			
		
		/// first two lines to allow user to only access custom post(event)
		
			'capability_type' => 'event',
			'map_meta_cap'=> true,
			'supports'=>array('title','editor','excerpt'),
			'has_archive'=> true,
			'public' => true,
			'labels' => array(
			'name'=> 'Events',
			'add_new_item'=> 'Add New Event',
			'edit_item'=>'Edit Event',
			'all_items'=> 'All Events',
			'singular_name'=> 'Event'
		),
		'menu_icon' => 'dashicons-calendar'

	));





//program post type



	register_post_type('program',array(
		
			'supports'=>array('title'),
			'rewrite' => array('slug'=>'programs'),
			'has_archive'=> true,
			'public' => true,
			'labels' => array(
			'name'=> 'Programs',
			'add_new_item'=> 'Add New Program',
			'edit_item'=>'Edit Program',
			'all_items'=> 'All Programs',
			'singular_name'=> 'Program'
		),
		'menu_icon' => 'dashicons-awards'

	));


// campuses



	register_post_type('campus',array(
			'capability_type' => 'campus',
			'map_meta_cap'=> true,
			'supports'=>array('title','editor', 'excerpt'),
			'rewrite' => array('slug'=>'campuses'),
			'has_archive'=> true,
			'public' => true,
			'labels' => array(
			'name'=> 'Campuses',
			'add_new_item'=> 'Add New Campus',
			'edit_item'=>'Edit Campus',
			'all_items'=> 'All Campuses',
			'singular_name'=> 'Campus'
		),
		'menu_icon' => 'dashicons-location-alt'

	));


// professors


	register_post_type('Professor',array(
		
			'supports'=>array('title','editor','thumbnail'),
			'show_in_rest' => true,
			'public' => true,
			'labels' => array(
			'name'=> 'Professors',
			'add_new_item'=> 'Add New Professor',
			'edit_item'=>'Edit Professor',
			'all_items'=> 'All Professors',
			'singular_name'=> 'Professor'
		),
		'menu_icon' => 'dashicons-welcome-learn-more'

	));

// notes 

	register_post_type('notes',array(
			'capability_type'=> 'notes',
			'map_meta_cap'=> true,		
			'supports'=>array('title','editor'),
			'show_in_rest' => true,
			'public' => false,
			'show_ui'=> true,
			'labels' => array(
			'name'=> 'Notes',
			'add_new_item'=> 'Add New Note',
			'edit_item'=>'Edit Note',
			'all_items'=> 'All Notes',
			'singular_name'=> 'Note'
		),
		'menu_icon' => 'dashicons-welcome-write-blog'

	));

/*working with custom api endpoints
	/// like post type */

	register_post_type('Like',array(		
			'supports'=>array('title'),
			'public' => false,
			'show_ui'=> true,
			'labels' => array(
			'name'=> 'likes',
			'add_new_item'=> 'Add New like',
			'edit_item'=>'Edit like',
			'all_items'=> 'All likes',
			'singular_name'=> 'like'
		),
		'menu_icon' => 'dashicons-heart'
	));
}
add_action('init','university_post_types');

