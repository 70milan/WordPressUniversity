import $ from 'jquery';

class Search {

// descrivbe and create our object

	constructor(){
		this.addSearchHTML();
		this.isSpinnerVisible = false;
		this.resultsDiv = $("#search-overlay__results");
		this.openButton = $(".js-search-trigger");
		this.closeButton = $(".search-overlay__close");
		this.seachOverlay = $(".search-overlay");
		this.searchField = $("#search-term");
		this.previousValue;
		this.typingTimer;
		this.previousValue;
		this.isOverlayOpen = false;
		this.events();
}
// events
events() {

	this.openButton.on("click", this.openOverlay.bind(this));
	this.closeButton.on("click", this.closeOverlay.bind(this));
	$(document).on("keydown", this.keyPressDispatcher.bind(this));
	this.searchField.on("keyup", this.typingLogic.bind(this));
}


// methods/actions/functions

typingLogic() {
		if(this.previousValue != this.searchField.val()) {

		clearTimeout(this.typingTimer);

		if(this.searchField.val()) {

			if(!this.isSpinnerVisible){

			this.resultsDiv.html('<div class="spinner-loader"></div>');
			this.isSpinnerVisible = true;
		}
		this.typingTimer = setTimeout(this.getResults.bind(this), 500);


		} else {

			this.searchField.html('');
			this.isSpinnerVisible = false;


		}




		}
		this.previousValue = this.searchField.val();
}



////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
getResults(){

  $.getJSON(uniData.root_url + '/wp-json/university/v1/search?term=' + this.searchField.val(), (results) => {

		this.resultsDiv.html(`

<div class="row">
<div class="one-third">
	<h2 class="search-overlay__section-title">General Information</h2>
	${results.generalInfo.length ? '<ul class="link-list min-list">' : '<p>No general information found.</p>'}

		${results.generalInfo.map(item=> `<li><a href="${item.url}" >${item.title}</a>${item.postType == 'post' ? ` by ${item.author}` : ''} </li>`).join('')}

	${results.generalInfo.length ? '</ul>' : ''}
</div>
<div class="one-third">





<h2 class="search-overlay__section-title">Programs</h2>

${results.programs.length ? '<ul class="link-list min-list">' : `<p>No programs match that search. <a href="${uniData.root_url}/programs"> View all programs</a</p>`}

	${results.programs.map(item=> `<li><a href="${item.url}" >${item.title}</a></li>`).join('')}

${results.programs.length ? '</ul>' : ''}



<h2 class="search-overlay__section-title">Professors</h2>

${results.professors.length ? '<ul class="professor-cards">' : '<p>No professor found.</p>'}

	${results.professors.map(item=> `



		<li class="professor-card__list-item">
			<a class="professor-card" href="${item.url}">
				<img class="professor-card__image" src="${item.image}">
				<span class="professor-card__name">${item.title}</span>
			</a>
		</li>



		`).join('')}

${results.professors.length ? '</ul>' : ''}

</div>
<div class="one-third">

<h2 class="search-overlay__section-title">Campuses</h2>
${results.campuses.length ? '<ul class="link-list min-list">' : `<p>No campus match that search. <a href="${uniData.root_url}/campuses"> View all campuses</a</p>`}

	${results.campuses.map(item=> `<li><a href="${item.url}" >${item.title}</a></li>`).join('')}

${results.campuses.length ? '</ul>' : ''}


<h2 class="search-overlay__section-title">Events</h2>

${results.events.length ? '' : `<p>No events match that search. <a href="${uniData.root_url}/events"> View all events</a</p>`}
${results.events.map(item=> `

	<div class="event-summary">
          <a class="event-summary__date t-center" href="${item.url}">
            <span class="event-summary__month">${item.month}</span>
            <span class="event-summary__day">${item.day}</span>  
          </a>
          <div class="event-summary__content">
            <h5 class="event-summary__title headline headline--tiny"><a href="${item.url}">${item.title}</a></h5>
            <p>${item.description}<a href="${item.url}" class="nu gray">Learn more</a></p>
     </div>
</div>


`).join('')}

</div>
</div>


			`);

	this.isSpinnerVisible = false;

	});



}

keyPressDispatcher(e){
	if (e.keyCode == 83 && !this.isOverlayOpen && !$("input, textarea").is(':focus')) {
		this.openOverlay();
	}

	if (e.keyCode == 27 && this.isOverlayOpen) {
		this.closeOverlay();
	}

}





openOverlay(){

	this.seachOverlay.addClass("search-overlay--active");
	$("body").addClass("body-no-scroll");
	this.searchField.val('');
	setTimeout(() => this.searchField.focus(), 301);
	console.log("open method ran");
	this.isOverlayOpen = true;
	return false;
}
closeOverlay(){
	this.seachOverlay.removeClass("search-overlay--active");
 	$("body").removeClass("body-no-scroll");
 	console.log("close method ran");
 	this.isOverlayOpen = false;
}


addSearchHTML() {

		$("body").append(`

			<div class = "search-overlay ">
  			<div class="search-overlay__top">
   			<div class="container">
    		 <i class="fa fa-search search-overlay__icon" aria-hidden="true"></i>
      <input type = "text" class="search-term" placeholder="What are you looking for?" id = "search-term">
    	  <i class="fa fa-window-close search-overlay__close" aria-hidden="true"></i>
    </div>
    </div>


    <div class="container">
    <div id="search-overlay__results"></div>
    </div>

		`);
	}



}


export default Search;
