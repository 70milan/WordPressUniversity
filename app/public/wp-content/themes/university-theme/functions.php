<?php 


require get_theme_file_path('/inc/like-route.php');


require get_theme_file_path('/inc/search-route.php');

///////////////////////////////////////////////////////////////

function university_custom_rest(){

		register_rest_field('post','authorName', array(

			'get_callback' => function(){ return get_the_author();}

		));

}

add_action('rest_api_init', 'university_custom_rest');

////////////////////////////////////////////////////////////////////

function pageBanner($args = NULL) {

	if(!$args['title'])	{
		$args['title'] = get_the_title();
	}

	if(!$args['subtitle'])	{
		$args['subtitle'] = get_field('page_banner_subtitle');
	}
	if(!$args['pic'])	{
		if(get_field('page_banner_background_image')){

			$args['pic'] = get_field('page_banner_background_image')['sizes']['pageBanner'];
		} else {
			$args['pic'] = get_theme_file_uri('/images/ocean.jpg');
		}
	}

?>

	<div class="page-banner">
    <div class="page-banner__bg-image" style="background-image: url(<?php echo $args['pic']?>);"></div>
    
    <div class="page-banner__content container container--narrow">
      <h1 class="page-banner__title"><?php echo $args['title']; ?></h1>
      <div class="page-banner__intro">
        <p><?php echo $args['subtitle']; ?></p>
      </div>
    </div>  
  </div>
	<?php
}

function university_files() {

	wp_enqueue_script('main_uni_js', get_theme_file_uri('/js/scripts-bundled.js'), NULL, '1.0', true);
	wp_enqueue_script('googleMap','//maps.googleapis.com/maps/api/js?key=AIzaSyDl553OhtLk-9tkST41odF7F6O4HS5Ttmw' ,NULL, '1.0', false);
	wp_enqueue_style('custom-google-fonts', '/fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i');
	wp_enqueue_style('font-awesome','//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
	wp_enqueue_style('university_main_styles', get_stylesheet_uri());
	wp_localize_script('main_uni_js', 'uniData', array(

		'root_url' => get_site_url(),
		'nonce' => wp_create_nonce('wp_rest')

));
}

add_action('wp_enqueue_scripts', 'university_files');

function university_features() {
	add_theme_support('title-tag');
	add_theme_support('post-thumbnails');
	add_image_size('professorLandscape', 400, 260, true);
	add_image_size('professorPortrait', 480, 650, true);
	add_image_size('pageBanner', 1500, 350, true);
}

add_action('after_setup_theme', 'university_features');

function university_adjust_queries ($query) {

		if(!is_admin() AND is_post_type_archive('campus') AND $query-> is_main_query()){
		$query -> set('posts_per_page', -1);	

		}	



		if(!is_admin() AND is_post_type_archive('program') AND $query-> is_main_query()){

		$query -> set('order','ASC');
		$query -> set('orderby','title');
		$query -> set('posts_per_page',-1);	

		}	

		if(!is_admin() AND is_post_type_archive('event') AND $query-> is_main_query()){
		$today = date('Ymd');
		$query -> set('meta_key', 'event_date');
		$query -> set('orderby', 'meta_value_num');
		$query -> set('order','ASC');
		$query -> set('meta_query',  array(
                    array(
                    'key' => 'event_date',
                    'compare'=> '>=',
                    'value' => $today,
                    'type' => 'numeric'
                  )

              ));

}
}
add_action('pre_get_posts', 'university_adjust_queries');

function universityMapKey($api) {

		$api['key'] = 'AIzaSyDl553OhtLk-9tkST41odF7F6O4HS5Ttmw';
		return $api;

}


add_filter('acf/fields/google_map/api', 'universityMapKey');




// redirect subscriber acc out of the admin and onto homepage


add_action('admin_init', 'redirectSubsToFront');

function redirectSubsToFront(){
	$ourCurrentUser = wp_get_current_user();	
	
	if(count($ourCurrentUser -> roles)==1 AND $ourCurrentUser ->roles[0]=='subscriber' ) {
			wp_redirect(site_url('/'));
			exit;
	}

}

///disabling admin toolbar for subscribers

add_action('wp_loaded', 'noAdminBar');

function noAdminBar(){
	$ourCurrentUser = wp_get_current_user();	
	
	if(count($ourCurrentUser -> roles)==1 AND $ourCurrentUser ->roles[0]=='subscriber' ) {
			show_admin_bar(false);
	}

}


//customize login screen

add_filter('login_headerurl', 'ourHeaderUrl');

function ourHeaderUrl() {
	return esc_url(site_url('/'));
}

add_action('login_enqueue_scripts','ourLoginCSS');

function ourLoginCSS() {
	wp_enqueue_style('university_main_styles', get_stylesheet_uri());
	wp_enqueue_style('custom-google-fonts', '/fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i');
}

/// to remove "powered by wordpress" hover effect



add_filter('login_headertitle','ourLogin');

function ourLogin(){

	return get_bloginfo('name');

}