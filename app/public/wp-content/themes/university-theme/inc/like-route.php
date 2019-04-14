<?php


add_action('rest_api_init', 'universityLikeRoutes');


function universityLikeRoutes(){
    register_rest_route('university/v1', 'manageLike', array(
        'methods'=> 'POST',
        'callback'=> 'createLike'
    ));

    register_rest_route('university/v1', 'manageLike', array(
        'methods'=> 'DELETE',
        'callback'=> 'deleteLike'
    ));
}

function createLike($data){
    if(is_user_logged_in()) {
          $professor = sanitize_text_field($data['professorId']);
        
            $existQuery = new WP_Query(array(
            'author'=> get_current_user_id(),
            'post_type'=>'like',
            'meta_query'=> array(
              array(
                'key'=>'like_professor_id',
                'compare'=>'=',
                'value'=> $professor
            )
            )
          ));
    
          if($existQuery->found_posts ==0 AND get_post_type($professor) == 'professor'){
            return wp_insert_post(array(
            'post_type'=> 'like',
            'post_status'=>'publish',
            'post_title'=> 'Ouwwr PHP Create Post test',
            'meta_input'=> array(
                'like_professor_id'=> $professor
            )
            ));

          } else {
              die("invalid");
          }
       

    }else {
        die("only logged in users can create a like");
    }
 
} 
function deleteLike(){
        return 'error';
}

