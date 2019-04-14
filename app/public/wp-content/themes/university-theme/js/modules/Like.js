import $ from 'jquery';



class Like {

constructor(){
   this.events();
}
events() {
    $(".like-box").on("click", this.ourClickDispatcher.bind(this));

}

//methods

ourClickDispatcher(e){
var currentLikeBox = $(e.target).closest(".like-box");


    if(currentLikeBox.data('exists') == 'yes'){

        this.deleteLike(currentLikeBox);

    } else{
        this.createLike(currentLikeBox);
    }


}

createLike(currentLikeBox){
 $.ajax({
     beforeSend: (xhr) => {

         xhr.setRequestHeader('X-WP-Nonce', uniData.nonce);
     }, 
    url: uniData.root_url + '/wp-json/university/v1/manageLike',
     type: 'POST',
     data: { 'professorId': currentLikeBox.data('professor')},
     success: (response)=> {
        // makin like button work on the fly
        
        currentLikeBox.attr('data-exists', 'yes');
         var likeCount = parseInt(currentLikeBox.find(".like-count").html(), 10);
         likeCount++;
         currentLikeBox.find(".like-count").html(likeCount);

        console.log(response);
     },
     error: (response) =>{
         console.log(response);
     }
 });
}

deleteLike(){
    $.ajax({
        url: uniData.root_url + '/wp-json/university/v1/manageLike',
       
        type: 'DELETE',
        success: (response) => {
            console.log(response);
        },
        error: (response) => {
            console.log(response);
        }
    });
}

}

export default Like;