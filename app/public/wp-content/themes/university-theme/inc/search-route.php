
<?php
/// create custom rest api url



add_action('rest_api_init', 'UniversityRegisterSearch');

function UniversityRegisterSearch() {

	register_rest_route('university/v1', 'search', array(

		'method' => WP_REST_SERVER:: READABLE,
		'callback' => 'UniversitySearchResults'


	));
}


function UniversitySearchResults($data) {

		$mainQuery = new WP_Query(array(
			'post_type' => array('post','page','professor','program','campus','event'),
			's' => sanitize_text_field($data['term'])
		));

	$results = array(
		'generalInfo'=> array(),
		'professors'=>array(),
		'programs'=> array(),
		'events'=> array(),
		'campuses'=>array()
		);

	while ($mainQuery-> have_posts()) {
		$mainQuery -> the_post();


		if(get_post_type() == 'post' OR get_post_type() =='page'){
		array_push($results['generalInfo'], array(
			'title' => get_the_title(),
			'url'	=> get_the_permalink(),
			'postType'	=> get_post_type(),
			'author' => get_the_author()
		));
	}

	if(get_post_type() == 'professor'){
	array_push($results['professors'], array(
		'title' => get_the_title(),
		'url'	=> get_the_permalink(),
		'image' => get_the_post_thumbnail_url(0, 'professorLandscape')
	));
}

	if(get_post_type() == 'campus'){
	array_push($results['campuses'], array(
		'title' => get_the_title(),
		'url'	=> get_the_permalink()
	));
	}

	if(get_post_type() == 'program'){
		//// to show related campuses to the program typed
	$relatedCampuses = get_field('related_campuses');

		//// only if it has a campus
	if($relatedCampuses){
	foreach($relatedCampuses as $campus){
		array_push($results['campuses'], array(
			'title' => get_the_title($campus),
			'url'	=> get_the_permalink($campus)
		));
	}

	}

array_push($results['programs'], array(
	'title' => get_the_title(),
	'url'	=> get_the_permalink(),
	'id'	=> get_the_id()
));
}

if(get_post_type() == 'event'){

 $eventDate = new DateTime(get_field('event_date', false,false));
 
 //// for the description


 $description = null;
 if (has_excerpt()){
             $description = get_the_excerpt();
              } 
              else {
              $description = wp_trim_words(get_the_content(), 15);
            }

array_push($results['events'], array(
	'title' => get_the_title(),
	'url'	=> get_the_permalink(),
	'month'=> $eventDate ->format('M'),
	'day' => $eventDate ->format('d'),

//// for the description

	'description'=> $description
));
}

	}


	if($results['programs']){
		
		
	$programsMetaQuery = array('relation' => 'OR');

	foreach($results['programs'] as $item){

		array_push($programsMetaQuery, array(
			'key'=> 'related_programs',
			'compare'=> 'LIKE',
			'value'=> '"' . $results['programs'][0]['id'] . '"'
		));


	}

	$programRelationshipQuery = new WP_Query(array(

		'post_type' => array('professor','event'),
		'meta_query' => $programsMetaQuery

	 ));
////////////////////////////////////////////////* relationships between each other(prof-program) which we wanna show on our livesearch results

	while ($programRelationshipQuery-> have_posts()) {
		$programRelationshipQuery -> the_post();

		
		if(get_post_type() == 'event'){

			$eventDate = new DateTime(get_field('event_date', false,false));
			
			//// for the description
		   
		   
			$description = null;
			if (has_excerpt()){
						$description = get_the_excerpt();
						 } 
						 else {
						 $description = wp_trim_words(get_the_content(), 15);
					   }
		   
		   array_push($results['events'], array(
			   'title' => get_the_title(),
			   'url'	=> get_the_permalink(),
			   'month'=> $eventDate ->format('M'),
			   'day' => $eventDate ->format('d'),
		   
		   //// for the description
		   
			   'description'=> $description
		   ));
		   }
		
		if(get_post_type() == 'professor'){
			array_push($results['professors'], array(
				'title' => get_the_title(),
				'url'	=> get_the_permalink(),
				'image' => get_the_post_thumbnail_url(0, 'professorLandscape')
			));
		}

	}	


	//// to avoid any duplicates while rendering
	$results['professors'] = array_values(array_unique($results['professors'], SORT_REGULAR));
	$results['events'] = array_values(array_unique($results['events'], SORT_REGULAR));

	}

	return $results;
}











	
